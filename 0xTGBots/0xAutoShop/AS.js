const TeleBot = require('telebot')
const config = require('./AS_config')
const mongoose = require('mongoose')
const fs = require('fs')
var path = require("path")
const Qiwi = require('node-qiwi-api').Qiwi
const Wallet = new Qiwi(config.qiwi)
var items = require("./items.js")
mongoose.connect(config.mongodb)
const exmo = require('exmo-api');

if (config.exmo_enabled)
    exmo.init_exmo({ key: config.exmo_api_key, secret: config.exmo_api_secret });

const bot = new TeleBot({
    token: config.token,
    polling: {
        interval: 100,
        timeout: 0,
        limit: 100,
        retryTimeout: 250,
        proxy: config.proxy
    }
});


console.log('\nWelcome!\n\nDeveloper: @inffix\n\nInitializing...\n\nLogs:')

function addBal(user_id, sum) { if (user_id != 0) User.findOneAndUpdate({ id: user_id }, { $inc: { balance: sum } }).then((e) => { }) }
function setBal(user_id, sum) { User.findOneAndUpdate({ id: user_id }, { balance: sum }).then((e) => { }) }
async function getBal(user_id) { var u = await User.findOne({ id: user_id }); return u.balance }
function isAdmin(user_id) { return ~config.admin_list.indexOf(user_id) }
function sendAdmins(text, params) { for (var i = 0; i < config.admin_list.length; i++) bot.sendMessage(config.admin_list[i], text, params) }
function setState(user_id, state) { User.findOneAndUpdate({ id: user_id }, { state: Number(state) }).then((e) => { }) }
async function getState(user_id) { var u = await User.findOne({ id: user_id }); if (u) return u.state; else return 0 }
function setData(user_id, data) { User.findOneAndUpdate({ id: user_id }, { data: String(data) }).then((e) => { }) }
async function getData(user_id) { var u = await User.findOne({ id: user_id }); return u.data }
async function getInfo(user_id) { var u = await User.findOne({ id: user_id }); return u.info }
function incField(user_id, field, number) { User.findOneAndUpdate({ id: user_id }, JSON.parse('{ "$inc" : { "info.' + field + '": ' + number + ' } }')).then((e) => { }) }
async function getReferer(user_id, level) { var u = await User.findOne({ id: user_id }); var u2 = await User.findOne({ id: u.ref }); if (u2 == null) u2 = { id: 0, ref: 0 }; if (u2.id == 0) u2.ref = 0; if (level == 1) return u2.id; else if (level == 2) return u2.ref }
async function getUser(user_id) { var u = await User.findOne({ id: user_id }); return u }
function getItem(item_id) { return itemList.filter((e) => { if (e.id == item_id) return true })[0] }
function roundPlus(number) { if (isNaN(number)) return false; var m = Math.pow(10, 2); return Math.round(number * m) / m; }
async function getBought(user_id) { var u = await User.findOne({ id: user_id }); return u.bought }
async function pushBought(user_id, item_id) { var u = await User.findOne({ id: user_id }); u.bought.push(item_id); User.findOneAndUpdate({ id: user_id }, { bought: u.bought }).then() }

const RM_default = bot.keyboard([
    [bot.button('🛒 Товары')],
    [bot.button('🗂 Мои покупки'), bot.button('💳 Баланс')],
    [bot.button('👥 Партнёрка'), bot.button('📧 О нас')]
], { resize: true });

const RM_balance = bot.inlineKeyboard([
    [bot.inlineButton("Пополнить с помощью QIWI", { callback: "bal_1" })],
    [bot.inlineButton("Пополнить с помощью EXCODE", { callback: "bal_3" })],
    [bot.inlineButton("Вывести", { callback: "bal_2" })],
])

const RM_about = bot.inlineKeyboard([
    [bot.inlineButton("👨‍💻 Бот поддерки", { url: "http://t.me/bshopbbot" })],
    [bot.inlineButton("🌐 Сайт поддерки", { url: "http://bshopb.tilda.ws/" })],
])

const RM_admin = bot.inlineKeyboard([
    [bot.inlineButton("Рассылка", { callback: "admin_2" })],
    [bot.inlineButton("Зачислить", { callback: "admin_5" }), bot.inlineButton("Статистика", { callback: "admin_6" })],
    [bot.inlineButton("Изменить баланс", { callback: "admin_7" }), bot.inlineButton("Инфа о пользователе", { callback: "admin_8" })],
    [bot.inlineButton("Выгрузить items.js", { callback: "admin_9" }), bot.inlineButton("Загрузить items.js", { callback: "admin_10" })],
])

const RM_back = bot.keyboard([[bot.button('◀️ На главную')]], { resize: true });
const RM_mm1 = bot.inlineKeyboard([[bot.inlineButton("⏹ Стоп", { callback: "admin_mm_stop" }), bot.inlineButton("⏸ Пауза", { callback: "admin_mm_pause" })],])
const RM_mm2 = bot.inlineKeyboard([[bot.inlineButton("⏹ Стоп", { callback: "admin_mm_stop" }), bot.inlineButton("▶️ Продолжить", { callback: "admin_mm_play" })],])

bot.on('start', async function (msg) { sendAdmins('✅ Бот запущен!') })

bot.on('text', async function (msg) {
    if (msg.from != undefined) {
        let dt = new Date
        console.log("[" + dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds() + "] Пользователь " + msg.from.id + " отправил: " + msg.text)
        var uid = msg.from.id
        var text = msg.text
        if (text == "/start") {
            bot.sendMessage(uid, config.about_text, { replyMarkup: RM_default, parseMode: html });
            let isUser = await User.find({ id: uid })
            if (isUser.length == 0) {
                let t = new Date()
                t = t.getTime()
                let user = new User({ id: uid, username: msg.from.username, name: msg.from.first_name, balance: 0, ref: 0, ref2: 0, reg_time: t, info: { ref1count: 0, ref2count: 0, ref1earnings: 0, ref2earnings: 0 }, state: 0, data: "", bought: [] })
                await user.save()
            }
        }
        else if (text == "◀️ На главную") {
            setState(uid, 0)
            return bot.sendMessage(uid, 'Вы в главном меню', { replyMarkup: RM_default });
        }

        else if (text == '💳 Баланс')
            bot.sendMessage(uid, "На вашем балансе: <b>" + roundPlus(await getBal(uid)) + '</b>₽', { parseMode: html, replyMarkup: RM_balance })

        else if (text == '📧 О нас')
            bot.sendMessage(uid, "<b>BShop - первый магазин скриптов Telegram ботов</b>\n\nМы занимаемся продажей качественных, надёжных и простых в настройке скриптов, разработанных профессиональными программистами. Наша политика низких цен направлена на расширение рынка Telegram ботов. Мы готовы ответить на все Ваши вопросы:", { parseMode: html, replyMarkup: RM_about })

        else if (text == '👥 Партнёрка')
            bot.sendMessage(uid, '<i>В нашем магазине действует 2-ух уровневая партнёрская программа! Приглашайте пользователей и получайте:</i>\n\n<b>1 уровень:</b> ' + config.ref1_percent * 100 + '% от покупок\n<b>2 уровень:</b> ' + config.ref2_percent * 100 + '% от покупок\n\n<b>Ваши приглашённые:</b>\n\n<b>1</b> уровень - <b>' + (await getInfo(uid)).ref1count + '</b> партнёров - <b>' + roundPlus((await getInfo(uid)).ref1earnings) + '₽</b> заработано\n<b>2</b> уровень - <b>' + (await getInfo(uid)).ref2count + '</b> партнёров - <b>' + roundPlus((await getInfo(uid)).ref2earnings) + '₽</b> заработано\n\n<b>Ваши партнёрские ссылки:</b>\n\nhttps://t.me/' + config.bot_username + '?start=' + uid + '\nhttps://tgdo.me/' + config.bot_username + '?start=' + uid + '\n\n<b>Минимальный вывод:</b> ' + config.min_payout + "₽", { replyMarkup: RM_default, parseMode: html, webPreview: false })

        else if (text == '🛒 Товары') {
            var kb = bot.inlineKeyboard([[]])
            for (var i = 0; i < items.length; i++) {
                if (items[i].type == "section")
                    kb.inline_keyboard[i] = [bot.inlineButton(items[i].label, { callback: "s_" + i })]
                else if (items[i].type == "item")
                    kb.inline_keyboard[i] = [bot.inlineButton(items[i].label, { callback: "item_" + items[i].id })]
            }
            bot.sendMessage(uid, 'Каталог нашего магазина:', { replyMarkup: kb })
        }
        else if (text == '🗂 Мои покупки') {
            var ui = await getBought(uid)
            var kb = bot.inlineKeyboard([[]])
            for (var i = 0; i < ui.length; i++) {
                var item = getItem(ui[i])
                kb.inline_keyboard[i] = [bot.inlineButton(item.label, { callback: "item_" + item.id })]
            }
            if (ui.length != 0)
                bot.sendMessage(uid, 'Ваши покупки:', { replyMarkup: kb })
            else
                bot.sendMessage(uid, 'У Вас пока нет покупок', { replyMarkup: kb })
        }
        else if (await getState(uid) == 105) {
            exmo.api_query("excode_load", { code: text.replace("\n", "").replace(" ", "") }, function (result) {
                try {
                    var data = JSON.parse(result);
                    if (data.result && data.currency == "RUB") {
                        var sum = roundPlus(Number(data.amount))
                        addBal(uid, sum)
                        bot.sendMessage(uid, '💳 Ваш баланс пополнен на <b>' + sum + '₽</b>!', { parseMode: html })
                        sendAdmins('💳 Баланс пользователя <b>' + uid + '</b> пополнен на <b>' + sum + '₽</b> через <b>EXCODE</b>!', { parseMode: html })
                    }
                    else
                        bot.sendMessage(uid, '❗️<b>Ошибка</b>️\n\nНеверный EXCODE', { parseMode: html })
                }
                catch (e) {
                    bot.sendMessage(uid, '❗️<b>Ошибка</b>️\n\nНеверный EXCODE', { parseMode: html })
                }
            })
            setState(uid, 0)
        }
        else if (await getState(uid) == 100) {
            setData(uid, text)
            bot.sendMessage(uid, 'На вашем балансе <b>' + roundPlus(await getBal(uid)) + '₽</b>\n\nУкажите сумму для вывода:', { replyMarkup: RM_back, parseMode: html })
            setState(uid, 101)
        }

        else if (await getState(uid) == 101) {
            var wd_sum = text
            var d = await getData(uid)
            if (!isNaN(wd_sum)) {
                if (wd_sum <= (await getBal(uid))) {
                    if (wd_sum >= config.min_payout) {
                        const RM_po = bot.inlineKeyboard([[bot.inlineButton('✅ Подтвердить', { callback: 'accept_' + uid + '_' + wd_sum + "_" + d })]])
                        addBal(uid, -Number(wd_sum))
                        sendAdmins('📤 <b>Новая заявка на вывод!</b> 📤\n\nКошелёк: <code>' + d + '</code>\nСумма: <code>' + wd_sum + '</code>\nID: <code>' + uid + '</code>', { replyMarkup: RM_po, parseMode: html })
                        bot.sendMessage(uid, 'Кошелёк: <code>' + d + '</code>\nСумма: <code>' + wd_sum + '</code>\n\nВаша выплата будет произведена в течение <b>24-х</b> часов!', { replyMarkup: RM_default, parseMode: html })
                        setState(uid, 0)
                    }
                    else
                        bot.sendMessage(uid, '❗️<b>Ошибка</b>️\n\nМинимальная сумма выплаты - <b>' + config.min_payout + '₽</b>!\nУкажите другую сумму:', { replyMarkup: RM_back, parseMode: html })
                }
                else
                    bot.sendMessage(uid, '❗️<b>Ошибка</b>️\n\nНедостаточно средств для вывода\nУкажите другую сумму:', { replyMarkup: RM_back, parseMode: html })
            }
            else
                bot.sendMessage(uid, '❗️<b>Ошибка</b>️\n\nВведите число:', { replyMarkup: RM_back, parseMode: html })
        }

        else if (text == "/admin" && isAdmin(uid) || text == "/a" && isAdmin(uid)) {
            var h = process.uptime() / 3600 ^ 0
            var m = (process.uptime() - h * 3600) / 60 ^ 0
            var s = process.uptime() - h * 3600 - m * 60 ^ 0
            var heap = process.memoryUsage().rss / 1048576 ^ 0
            if (config.qiwi_state)
                Wallet.getBalance((err, balance) => { bot.sendMessage(uid, '<b>Админ-панель:</b>\n\n<b>Аптайм бота:</b> ' + h + ' часов ' + m + ' минут ' + s + ' секунд\n<b>Памяти использовано:</b> ' + heap + "МБ\n<b>Баланс QIWI:</b> " + balance.accounts[0].balance.amount + "₽", { replyMarkup: RM_admin, parseMode: html }) })
            else
                bot.sendMessage(uid, '<b>Админ-панель:</b>\n\n<b>Аптайм бота:</b> ' + h + ' часов ' + m + ' минут ' + s + ' секунд\n<b>Памяти использовано:</b> ' + heap + "МБ", { replyMarkup: RM_admin, parseMode: html });
        }
        else if (await getState(uid) == 901 && isAdmin(uid)) {
            bot.sendMessage(uid, 'Введите сумму: ', { replyMarkup: RM_default });
            setData(uid, Number(text))
            setState(uid, 902)
        }
        else if (await getState(uid) == 941 && isAdmin(uid)) {
            bot.sendMessage(uid, 'Текущий баланс: ' + roundPlus(await getBal(Number(text))) + " рублей\nВведите сумму, на которую необходимо изменить баланс:", { replyMarkup: RM_default });
            setData(uid, Number(text))
            setState(uid, 942)
        }
        else if (await getState(uid) == 951 && isAdmin(uid)) {
            var u = await getUser(Number(text))
            var date = new Date()
            var d = (date.getTime() - u.reg_time) / 86400000 ^ 0
            bot.sendMessage(uid, '<b>Информация о пользователе:</b>\n\nID: ' + text + '\nИмя: ' + u.name + '\nЮзернейм: @' + u.username + '\nДней в боте: ' + d + '\nРефералы:\n1 уровень - ' + u.info.ref1count + ' - ' + roundPlus(u.info.ref1earnings) + '₽\n2 уровень - ' + u.info.ref2count + ' - ' + roundPlus(u.info.ref2earnings) + '₽\n\nКупленные товары:\n' + JSON.stringify(u.bought) + '\n\nНа балансе ' + roundPlus(u.balance) + '₽', { replyMarkup: RM_default, parseMode: html })
            setState(uid, 0)
        }
        else if (await getState(uid) == 942 && isAdmin(uid)) {
            var sum = Number(text)
            var d = await getData(uid)
            setBal(d, sum)
            bot.sendMessage(d, '💳 Ваш баланс изменён на <b>' + Number(text) + '</b> рублей!', { parseMode: html })
            sendAdmins('💳 Баланс пользователя <b>' + d + '</b> изменён на <b>' + Number(text) + '</b> рублей вручную!', { parseMode: html })
            setData(uid, "")
            setState(uid, 0)
        }
        else if (await getState(uid) == 902 && isAdmin(uid)) {
            var sum = Number(text)
            var d = await getData(uid)
            addBal(d, sum)
            bot.sendMessage(d, '💳 Ваш баланс пополнен на <b>' + Number(text) + '</b> рублей!', { parseMode: html })
            sendAdmins('💳 Баланс пользователя <b>' + d + '</b> пополнен на <b>' + Number(text) + '</b> рублей вручную!', { parseMode: html })
            setData(uid, "")
            setState(uid, 0)
        }

        else if (await getState(uid) == 911 && isAdmin(uid) && text != "0") {
            setState(uid, 0)
            bot.sendMessage(uid, "Рассылка запущена!").then((e) => {
                mm_t(text, e.message_id, e.chat.id)
            })
        }
        else if (isAdmin(uid) && text == "0") {

            setState(uid, 0)
            bot.sendMessage(uid, "Отменено!")

        }
        else if (text.indexOf("/start") == -1) bot.sendMessage(uid, "🖥", { replyMarkup: RM_default })
    }
})
bot.on(/^\/start (.+)$/, async (msg, props) => {
    var ref = props.match[1]
    var uid = msg.from.id
    if (isNaN(ref) == false && ref != 589484345) {
        bot.sendMessage(uid, config.about_text, { replyMarkup: RM_default, parseMode: html });
        let isUser = await User.find({ id: uid })
        if (isUser.length == 0) {
            let t = new Date()
            t = t.getTime()
            var referer = await User.findOne({ id: ref })
            incField(referer.id, "ref1count", 1)
            incField(referer.ref, "ref2count", 1)
            let user = new User({ id: uid, username: msg.from.username, name: msg.from.first_name, balance: 0, ref: referer.id, ref2: referer.ref, reg_time: t, last_bonus_day: 0, info: { ref1count: 0, ref2count: 0, ref1earnings: 0, ref2earnings: 0, subsCount: 0, viewsCount: 0, payOut: 0, earned: 0, bonusCount: 0, advSpend: 0 }, state: 0, data: "", bought: [] })
            await user.save()
            bot.sendMessage(referer.id, '👤 У Вас новый <a href="tg://user?id=' + uid + '">реферал</a> на 1 уровне!', { parseMode: html })
            bot.sendMessage(referer.ref, '👤 У Вас новый <a href="tg://user?id=' + uid + '">реферал</a> на 2 уровне!', { parseMode: html })

        }
    }
})

bot.on('callbackQuery', async msg => {
    var d = msg.data
    var uid = msg.from.id
    if (d == "bal_1") {
        var RM_qiwi = bot.inlineKeyboard([[bot.inlineButton("Пополнить", { url: "https://qiwi.com/payment/form/99?currency=643&extra[%27comment%27]=BS" + uid + "&extra[%27account%27]=" + config.qiwi_num.substr(1) + "&amountInteger=1&amountFraction=0&blocked[0]=account&blocked[1]=comment" })]])
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: RM_qiwi }, "<b>Пополнение с помощью QIWI</b>\n\nРеквизиты для пополения баланса бота:\n\nКошелёк: <code>" + config.qiwi_num + "</code>\nКомментарий: <code>BS" + uid + '</code>\n\n<i>Баланс бота пополнится автоматически после перевода</i>')
    }
    else if (d == "bal_2") {
        bot.deleteMessage(uid, msg.message.message_id)
        setState(uid, 100)
        bot.sendMessage(uid, 'Введите номер Вашего <b>QIWI</b> кошелька для вывода:', { replyMarkup: RM_back, parseMode: html });
    }
    else if (d == "bal_3") {
        bot.deleteMessage(uid, msg.message.message_id)
        if (config.exmo_enabled) {
            setState(uid, 105)
            bot.sendMessage(uid, 'Введите номер рублёвого Exmo кода:', { replyMarkup: RM_back, parseMode: html })
        }
        else
            bot.sendMessage(uid, 'Данный способ пополнения временно недоступен', { replyMarkup: RM_back, parseMode: html });

    }
    else if (d.split("_")[0] == "open") {
        var itemId = d.split("_")[1]
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, "<b>Наименование:</b> " + getItem(itemId).label + "\n\n<b>Ваш товар:</b>\n\n" + getItem(itemId).product)
    }
    else if (d.split("_")[0] == "buy") {
        var itemId = d.split("_")[1]
        if ((await getBal(uid)) >= getItem(itemId).price) {
            sendAdmins('<a href="tg://user?id=' + uid + '">Пользователь</a> купил товар <b>"' + getItem(itemId).label + '"</b> с ID <b>' + itemId + "</b> за <b>" + getItem(itemId).price + "₽</b>", { parseMode: html })
            await bot.answerCallbackQuery(msg.id, { text: "✅ Спасибо за покупку!", showAlert: true })
            bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, "<b>Наименование:</b> " + getItem(itemId).label + "\n\n<b>Ваш товар:</b>\n\n" + getItem(itemId).product)
            addBal(uid, -getItem(itemId).price)
            pushBought(uid, itemId)
            addBal(await getReferer(uid, 1), getItem(itemId).price * config.ref1_percent)
            addBal(await getReferer(uid, 2), getItem(itemId).price * config.ref2_percent)
            bot.sendMessage(await getReferer(uid, 1), "💳 Вам начислено <b>" + getItem(itemId).price * config.ref1_percent + "₽</b> за покупку рефералом на <b>1 уровне</b>", { parseMode: html })
            bot.sendMessage(await getReferer(uid, 2), "💳 Вам начислено <b>" + getItem(itemId).price * config.ref2_percent + "₽</b> за покупку рефералом на <b>2 уровне</b>", { parseMode: html })
        }
        else
            await bot.answerCallbackQuery(msg.id, { text: "❗️ Для оплаты товара не хватает " + roundPlus(getItem(itemId).price - (await getBal(uid))) + "₽\n\nПополните Ваш баланс любым удобным способом", showAlert: true })

    }
    else if (d.split("_")[0] == "item") {
        var itemId = d.split("_")[1]
        var it = getItem(itemId)
        if (~(await getBought(uid)).indexOf(itemId))
            var kb = bot.inlineKeyboard([[bot.inlineButton("📂 Открыть", { callback: "open_" + itemId })]])
        else
            var kb = bot.inlineKeyboard([[bot.inlineButton("✅ Купить за " + it.price + '₽', { callback: "buy_" + itemId })]])
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, "<b>" + it.label + "</b>\n\n" + it.description)
    }
    else if (d.split("_")[0] == "catalog") {
        var kb = bot.inlineKeyboard([[]])
        for (var i = 0; i < items.length; i++) {

            if (items[i].type == "section")
                kb.inline_keyboard[i] = [bot.inlineButton(items[i].label, { callback: "s_" + i })]
            else if (items[i].type == "item")
                kb.inline_keyboard[i] = [bot.inlineButton(items[i].label, { callback: "item_" + items[i].id })]
        }
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, "Каталог нашего магазина:")

    }
    else if (d.split("_")[0] == "s") {
        var ii = Number(d.split("_")[1])
        var kb = bot.inlineKeyboard([[]])
        for (var i = 0; i < items[ii].objects.length; i++) {

            if (items[ii].objects[i].type == "subsection")
                kb.inline_keyboard[i] = [bot.inlineButton(items[ii].objects[i].label, { callback: "ss_" + ii + "_" + i })]
            else if (items[ii].objects[i].type == "item")
                kb.inline_keyboard[i] = [bot.inlineButton(items[ii].objects[i].label, { callback: "item_" + items[ii].objects[i].id })]
        }
        kb.inline_keyboard.push([bot.inlineButton("◀️ Назад", { callback: "catalog" })])
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, items[ii].description)
    }

    else if (d.split("_")[0] == "ss") {
        var s = Number(d.split("_")[1])
        var ss = Number(d.split("_")[2])
        var kb = bot.inlineKeyboard([[]])
        for (var i = 0; i < items[s].objects[ss].objects.length; i++) {
            if (items[s].objects[ss].objects[i].type == "item")
                kb.inline_keyboard[i] = [bot.inlineButton(items[s].objects[ss].objects[i].label, { callback: "item_" + items[s].objects[ss].objects[i].id })]
        }
        kb.inline_keyboard.push([bot.inlineButton("◀️ Назад", { callback: "s_" + s })])
        bot.editMessageText({ chatId: uid, messageId: msg.message.message_id, parseMode: html, replyMarkup: kb }, items[s].objects[ss].description)
    } else if (d.split("_")[0] == 'accept') {
        var id = d.split("_")[1]
        var sum = d.split("_")[2]
        var wallet = d.split("_")[3]
        bot.sendMessage(id, `<b>Ваша заявка на вывод средств обработана!</b>\n\n<b>${sum}₽</b> выплачено на кошелёк <b>${wallet}</b>!`, { parseMode: html });
        incField(id, "payOut", sum)
        bot.deleteMessage(uid, msg.message.message_id)
        await User.findOneAndUpdate({ id: 0 }, { $inc: { ref: sum } })
    }
    if (isAdmin(uid)) {
        if (d == "admin_2") {
            bot.sendMessage(uid, 'Отправьте сообщение для рассылки на всех пользователей бота (HTML разметка) (0 - отмена):', { replyMarkup: RM_default })
            setState(uid, 911)
        }
        else if (d == "admin_5") {
            bot.sendMessage(uid, 'Введите ID: ', { replyMarkup: RM_default })
            setState(uid, 901)
        }
        else if (d == "admin_6") {
            var u = await User.countDocuments({})
            var u1 = await User.countDocuments({ ref: 0 })
            var u2 = u - u1
            bot.sendMessage(uid, '<b>Статистика:</b>\n\nВсего пользователей: <b>' + u + '</b>\n<b>Из них</b>\nС реферером: <b>' + u2 + '</b>\nБез реферера: <b>' + u1 + '</b>', { replyMarkup: RM_default, parseMode: html });
        }
        else if (d == "admin_7") {
            bot.sendMessage(uid, 'Введите ID: ', { replyMarkup: RM_default })
            setState(uid, 941)

        }
        else if (d == "admin_8") {
            bot.sendMessage(uid, 'Введите ID: ', { replyMarkup: RM_default })
            setState(uid, 951)
        }
        else if (d == "admin_mm_stop") {
            var tek = Math.round((mm_i / mm_total) * 40)
            var str = ""
            for (var i = 0; i < tek; i++) str += "+"
            str += '>'
            for (var i = tek + 1; i < 41; i++) str += "-"
            mm_status = false;
            bot.editMessageText({ chatId: mm_achatid, messageId: mm_amsgid }, "Рассылка остановлена!")
            mm_u = []
        }
        else if (d == "admin_mm_pause") {
            var tek = Math.round((mm_i / mm_total) * 40)
            var str = ""
            for (var i = 0; i < tek; i++) str += "+"
            str += '>'
            for (var i = tek + 1; i < 41; i++) str += "-"
            mm_status = false;
            bot.editMessageText({ chatId: mm_achatid, messageId: mm_amsgid, replyMarkup: RM_mm2 }, "Выполнено: " + mm_i + '/' + mm_total + ' - ' + Math.round((mm_i / mm_total) * 100) + '%\n' + genMMTrackStr())
        }
        else if (d == "admin_mm_play") {

            mm_status = true;
            bot.editMessageText({ chatId: mm_achatid, messageId: mm_amsgid, replyMarkup: RM_mm1 }, "Выполнено: " + mm_i + '/' + mm_total + ' - ' + Math.round((mm_i / mm_total) * 100) + '%\n' + genMMTrackStr())
        }
        else if (d == "admin_9") {
            bot.sendAction(uid, "upload_document")
            bot.sendDocument(uid, './items.js')
        }
        else if (d == "admin_10") {
            bot.sendMessage(uid, "Отправьте новый файл items.js:")
            setState(uid, 991)
        }
    }
    bot.answerCallbackQuery(msg.id)

})

bot.on('document', async msg => {
    var uid = msg.from.id
    if (isAdmin(uid) && await getState(uid) == 991) {
        setState(uid, 0)
        var f = msg.document.file_id
        f = (await bot.getFile(f)).fileLink
        var request = require('request');
        request.get(f, function (error, response, body) {
            if (!error && response.statusCode == 200) {
                fs.writeFileSync(__dirname + "/items.js", body)
                var filename = path.resolve('./items.js')
                delete require.cache[filename]
                try {
                    items = require('./items')
                    updateItemList()
                    bot.sendMessage(uid, "Каталог изменён успешно!")
                } catch (e) {
                    bot.sendMessage(uid, "Неверная разметка файла!")
                }
            }
        })
    }

})

bot.start()

const html = "html"

process.on('unhandledRejection', (reason, p) => { console.log('Unhandled Rejection at: Promise', p, 'reason:', reason); })

var new_txid
var last_txid

var timerId = setInterval(async function () {
    if (config.qiwi_state) {
        try {
            Wallet.getOperationHistory({ rows: 1, operation: "IN", sources: ['QW_RUB'] }, async (err, operations) => {
                if (err == null) {
                    new_txid = operations.data[0].txnId
                    if (new_txid != last_txid && last_txid != undefined) {
                        var user_id = operations.data[0].comment
                        if (user_id.substr(0, 2) == "BS") {
                            user_id = user_id.split("BS")[1]
                            var sum = operations.data[0].sum.amount
                            addBal(Number(user_id), sum)
                            bot.sendMessage(user_id, '💳 Ваш баланс пополнен на <b>' + sum + '₽</b>!', { parseMode: html })
                            sendAdmins('💳 Баланс пользователя <b>' + user_id + '</b> пополнен на <b>' + sum + '₽</b> через <b>QIWI</b>!', { parseMode: html })
                        }
                    }
                }
            })
            last_txid = new_txid
        } finally { }
    }
}, config.qiwi_update);

var mm_total;
var mm_i;
var mm_mchatid;
var mm_mmsgid;
var mm_status = false;
var mm_amsgid;
var mm_type;
var mm_text;
var mm_achatid;
var mm_u;

var timerId = setInterval(async function () {
    if (mm_status) {
        try {
            mm_u[mm_i]
            if (mm_type == 'forward')
                await bot.forwardMessage(mm_u[mm_i], mm_mchatid, mm_mmsgid).then().catch((err) => { console.log(err) })
            if (mm_type == "text")
                await bot.sendMessage(mm_u[mm_i], mm_text, { replyMarkup: RM_default, parseMode: html }).then().catch((err) => { console.log(err) })
            console.log(mm_i + ') ID ' + mm_u[mm_i])
            isUser = undefined
            mm_i++
            if (mm_i % 10 == 0) {
                var tek = Math.round((mm_i / mm_total) * 40)
                var str = ""
                for (var i = 0; i < tek; i++) str += "+"
                str += '>'
                for (var i = tek + 1; i < 41; i++) str += "-"
                bot.editMessageText({ chatId: mm_achatid, messageId: mm_amsgid, replyMarkup: RM_mm1 }, "Выполнено: " + mm_i + '/' + mm_total + ' - ' + Math.round((mm_i / mm_total) * 100) + '%\n' + str)
            }
            if (mm_i == mm_total) {
                mm_status = false;
                bot.editMessageText({ chatId: mm_achatid, messageId: mm_amsgid }, "Выполнено: " + mm_i + '/' + mm_total)
                sendAdmins('Сообщение разослано ' + mm_i + ' пользователям!')
                mm_u = []
            }
        } finally { }
    }
}, config.mm_interval);

async function mm_t(text, amsgid, achatid) {
    let ut = await User.find({}, { id: 1 }).sort({ _id: -1 })
    mm_total = ut.length
    mm_u = []
    for (var i = 0; i < mm_total; i++)
        mm_u[i] = ut[i].id
    ut = undefined
    mm_i = 0;
    mm_status = true;
    mm_amsgid = amsgid;
    mm_type = "text";
    mm_text = text;
    mm_achatid = achatid;
}

var itemList = []

function updateItemList() {
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == "item")
            itemList.push(items[i])
        else if (items[i].type == "section") {
            for (var j = 0; j < items[i].objects.length; j++) {
                if (items[i].objects[j].type == "item")
                    itemList.push(items[i].objects[j])
                else if (items[i].objects[j].type == "subsection") {
                    for (var k = 0; k < items[i].objects[j].objects.length; k++)
                        itemList.push(items[i].objects[j].objects[k])
                }
            }
        }
    }
}

updateItemList()
  let ut = await User.find({}, { id: 1 }).sort({ _id: -1 })
    mm_total = ut.length
    mm_u = []
    for (var i = 0; i < mm_total; i++)
        mm_u[i] = ut[i].id
    ut = undefined
    mm_i = 0;
    mm_status = true;
    mm_amsgid = amsgid;
    mm_type = "text";
    mm_text = text;
    mm_a