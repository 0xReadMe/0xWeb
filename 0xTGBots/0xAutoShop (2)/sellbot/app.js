const mongo = require('mongoose');
mongo.connect('база данных');

var User = mongo.model('User', {
	id: Number,
	balance: Number,
	ref: Number
});

let items = require('./items.json');
let menu = require('./menu.json');
let transactions = require('./transactions.json');

const Telegram = require('node-telegram-bot-api');
const bot = new Telegram('токен', { polling: true });

const { Qiwi } = require('node-qiwi-api');
const wallet = new Qiwi('токен');

setInterval(async () => {
	wallet.getOperationHistory({ rows: 3, operation: 'IN' }, (err, res) => {
		if(err) return console.error(err);

		let { data } = res;
		data.map(async (o) => {
			if(transactions.find((x) => x === o.txnId)) return;

			if(o.sum.currency !== 643) return;
			
			o.comment = Number(o.comment)
			if(!o.comment) return;

			let user = await User.findOne({ id: o.comment });
			if(!user) return;

			transactions.push(o.txnId);
			require('fs').writeFileSync('./transactions.json', JSON.stringify(transactions, null, '\t'));

			await user.inc('balance', o.sum.amount * 2);
			bot.sendMessage(user.id, `✅ На ваш баланс зачислено ${o.sum.amount * 2}₽`);

			if(user.ref) {
				let reffer = await User.findOne({ id: user.ref });

				await reffer.inc('balance', o.sum.amount / 10);
				await bot.sendMessage(user.ref, `✅ Ваш реферал пополнил баланс на сумму ${o.sum.amount}₽, вы получили ${o.sum.amount / 10}₽`);
			}

			bot.sendMessage(482579901, `✅ Пополнение баланса на ${o.sum.amount}₽ успешно завершено!`);
		});
	});
}, 10000);

bot.on('message', async (message) => {
	if(!message.text) return;
	message.send = (text, params) => {
		if(!params) params = {};
		Object.assign(params, {
			parse_mode: 'Markdown'
		});

		bot.sendMessage(message.chat.id, text, params);
	}

	let $menu = [];
	menu.main.map((x) => $menu.push(x));

	if(message.text.startsWith('/start')) {
		let hasUser = await User.findOne({ id: message.from.id }) ? true : false;
		if(!hasUser) {
			let refferId = Number(message.text.split(' ')[1]);
			let userPattern = {
				id: message.from.id,
				balance: 0,
				ref: refferId ? refferId : 0
			};

			if(userPattern.ref) {
				await bot.sendMessage('🔺 По вашей партнёрской ссылке был зарегистрирован новый [пользователь](tg://user?id=' + message.from.id + ')', { parse_mode: 'Markdown' });
			}

			let newUser = new User(userPattern);
			await newUser.save();
		}

		await message.send('🎁 Внимание! Действует акция x2 на пополнение!\n\n🏆 Пополнил баланс на 100₽, получил 200₽ на баланс.\n\n*Самое время пополнить баланс и начать зарабатывать на собственных ботах!*', {
			reply_markup: {
				inline_keyboard: [
					[{ text: 'Пополнить баланс', callback_data: 'deposit' }]
				]
			}
		});

		return message.send('🔥 Добро пожаловать в магазин ботов.\n📱 Здесь вы можете купить скрипт бота, регулярно добавляем новые скрипты.\n\n🙈 Всегда хотели своего бота? С нами вы это сможете сделать!', {
			reply_markup: {
				keyboard: $menu,
				resize_keyboard: true
			}
		});
	}

	message.user = await User.findOne({ id: message.from.id });

	if(message.text === '🛒 Магазин') {
		let inlinePattern = [];
		items.types.forEach((category) => {
			inlinePattern.push( [{ text: category.title, callback_data: category.inlineData }] );
		});

		return message.send('🗄 Выберите категорию:', {
			reply_markup: {
				inline_keyboard: inlinePattern
			}
		});
	}

	if(message.text === '📂 Мои покупки') {
		let types = [];
		Object.keys(items).forEach((type) => {
			types.push(type);
		});

		let inlinePattern = [];
		types.filter((x) => x !== 'types').map((item) => {
			let goods = items[item].filter((x) => x.customers.find((a) => a === message.from.id));
			if(goods) {
				goods.map(($) => {
					inlinePattern.push( [{ text: $.title, callback_data: `downloadScript:${item}:${$.inlineData}` }] );
				});
			}
		});

		if(inlinePattern.length === 0) return message.send('Вы ещё не покупали скрипты. ❌');
		else {
			return message.send('Список скриптов, которые Вы купили:', {
				reply_markup: {
					inline_keyboard: inlinePattern
				}
			});
		}
	}

	if(message.text === '💵 Баланс') {
		return message.send(`💵 Баланс: ${message.user.balance}₽`, {
			reply_markup: {
				inline_keyboard: [
					[{ text: '📥 Пополнить через QIWI', callback_data: 'deposit' }]
				]
			}
		});
	}

	if(message.text === '💼 Партнерка') {
		return message.send(`🌐 Ваша ссылка: https://telegram.me/Script4Bot?start=${message.from.id}
		
_Вы будете получать 10% от пополнений рефералов._
*Например*: ваш реферал пополил баланс на 5000₽, вы получили 500₽

*Вы уже пригласили*: ${await User.countDocuments({ ref: message.from.id })} чел.`);
	}

	if(message.text === '⚙️ О проекте') {
		return message.send(`🆕 *Script4Bot* — новый проект, который продаёт скрипты ботов в автоматическом режиме.
		
		🔡 *Качественные скрипты*
		🌀 *Быстрый ответ технической поддержки*`.replace(/\t/g, ''), {
			reply_markup: {
				inline_keyboard: [
					[{ text: '❓ Техническая поддержка', url: 'https://telegram.me/thepipidon' }]
				]
			}
		});
	}
	
	if(message.text === '/admin') {
		if(message.from.id !== 482579901) return message.send('шалун...');

		wallet.getBalance(async (err, { accounts }) => {
			if(err) return message.send('Ошибка.');
			message.send(`Баланс QIWI: ${accounts[0].balance.amount}₽\n\nПользователей зарегистрировано: ${await User.countDocuments()}`);
		});
	}

	if(/^(?:~)\s([^]+)/i.test(message.text)) {
		if(message.from.id !== 482579901) return;

		let result = eval(message.text.match(/^(?:~)\s([^]+)/i)[1]);
		try {
			if(typeof(result) === "string")
			{
				return message.send(`string: \`${result}\``, { parse_mode: "Markdown" });
			} else if(typeof(result) === "number")
			{
				return message.send(`number: \`${result}\``, { parse_mode: "Markdown" });
			} else {
				return message.send(`${typeof(result)}: \`${JSON.stringify(result, null, '\t\t')}\``, { parse_mode: "Markdown" });
			}
		} catch (e) {
			console.error(e);
			return message.send(`ошибка:
\`${e.toString()}\``, { parse_mode: "Markdown" });
		}
	}
});

bot.on('callback_query', async (query) => {
	const { message } = query;
	message.user = await User.findOne({ id: message.chat.id });

	query.answer = (text) => bot.answerCallbackQuery(query.id, text, true);
	message.edit = (text, params) => {
		if(!params) params = {};
		Object.assign(params, {
			parse_mode: 'Markdown',
			message_id: message.message_id,
			chat_id: message.chat.id
		})

		bot.editMessageText(text, params);
	}

	if(!message.user) return query.answer('📵 Произошла ошибка, напишите боту /start');

	if(items.types.find((x) => query.data === x.inlineData)) {
		let inlinePattern = [];
		
		items[query.data].forEach((item) => {
			inlinePattern.push( [{ text: item.title, callback_data: `showInfo:${query.data}:${item.inlineData}` }] );
		});

		return message.edit('🗄 Выберите скрипт:', {
			reply_markup: {
				inline_keyboard: inlinePattern
			}
		});
	} else {
		if(query.data.startsWith('showInfo:')) {
			let [ action, type, script ] = query.data.split(':');

			let item = items[type].find((x) => x.inlineData === script);
			if(!item) return query.answer('📵 Скрипт не найден или был удалён.');

			return bot.sendMessage(message.chat.id, `*${item.title}*
			
			_${item.description}_
			
			💵 Стоимость: *${item.price}₽*
			
			⚙️ Язык: *${item.language}*
			💾 База данных: *${item.database}*
			
			_После покупки скрипт будет доступен для загрузки в разделе «📂 Мои покупки»._`.replace(/\t/g, ''), {
				parse_mode: 'Markdown',
				reply_markup: {
					inline_keyboard: [
						[{ text: '🛒 Купить', callback_data: `buyScript:${type}:${script}` }]
					]
				}
			});
		}

		if(query.data.startsWith('buyScript:')) {
			let [ action, type, script ] = query.data.split(':');

			let item = items[type].find((x) => x.inlineData === script);
			if(!item) return query.answer('📵 Скрипт не найден или был удалён.');

			if(item.price > message.user.balance) return query.answer('📵 Недостаточно денег для покупки этого скрипта.\n\n📥 Пополните свой баланс на ' + (item.price - message.user.balance) + '₽');
			else if(message.user.balance >= item.price) {
				await message.user.dec('balance', item.price);
				item.customers.push(message.chat.id);

				require('fs').writeFileSync('./items.json', JSON.stringify(items, null, '\t'));
				return query.answer(`✅ Вы успешно приобрели скрипт «${item.title}», остаток на балансе: ${message.user.balance}₽\n\n⬇️ Загрузить скрипт можно в разделе «📂 Мои покупки»`);
			}
		}

		if(query.data.startsWith('downloadScript:')) {
			let [ action, type, script ] = query.data.split(':');

			console.info()

			let item = items[type].find((x) => x.inlineData === script);
			if(!item) return query.answer('📵 Скрипт не найден или был удалён.');

			if(!item.customers.find((x) => x === message.chat.id)) return query.answer('📵 У вас нет доступа к этому скрипту.');
			else {
				await bot.sendDocument(message.chat.id, `./scripts/${item.fileDirectory}`);
			}
		}

		if(query.data === 'deposit') {
			return message.edit(`✅ Автоматическое пополнение баланса через QIWI:
			
Кошелек: \`+79068410804\`, комментарий к платежу: \`${message.chat.id}\`

‼️ Обязательно укажите комментарий к платежу, иначе платеж не будет зачислен автоматически.`);
		}
	}
});

User.prototype.inc = function(field, value) {
	this[field] += value;
	return this.save();
}
   
User.prototype.dec = function(field, value) {
	this[field] -= value;
	return this.save();
}
   
User.prototype.set = function(field, value) {
	this[field] = value;
	return this.save();
}