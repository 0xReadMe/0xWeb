const settings = require('../settings.json')
const _ = require('./out.js')

const fs = require('fs')
const Telegraf = require('telegraf')
const {Markup, session} = Telegraf 

const bot = new Telegraf(settings.tgToken)

bot.use(session())

const backKb = (
  Markup
  .keyboard([['В начало']])
  .resize()
  .extra()
)

function getStartKb(){
  return (Markup
    .inlineKeyboard([
      [Markup.callbackButton(`Вывод (${settings.currencies.from})`, 'withdraw')],
      [Markup.callbackButton('Проверить статус заявки', 'checkStatus')],
      [Markup.urlButton('Обратная связь', settings.currencies.supportUrl)]
    ])
    .resize()
    .extra()
  )
}

bot.action('checkStatus', ctx => {
  ctx.session.isChecking = true
  ctx.session.isAllBack = false
  return ctx.reply('Введите номер заявки:', backKb)
})

bot.action('withdraw', ctx => {
  ctx.session.withdraw = {state: 1}
  ctx.session.isAllBack = false
  return ctx.reply('Введите номер вашей карты для вывода:', backKb)
})

bot.action('agree', async ctx => {
  const id = ctx.update.callback_query.from.id

  //ctx.session.withdraw = {amount: 501}

  if (!ctx.session.withdraw || !ctx.session.withdraw.amount) return ctx.reply('Введите данные еще раз')
  
  await ctx.reply(`Ваша заявка принята!
Для завершения вывода переведите точную сумму ${ctx.session.withdraw.amount} ${settings.currencies.from} на кошелек:`)
  await ctx.reply(settings.currencies.wallet)
  await ctx.reply(`В поле memo укажите номер заявки!
№ Вашей заявки: ${id*2-123456}
Ваша заявка будет обработана в автоматическом режиме в течении 20 минут.`)
})

bot.action(/cancel/, ctx => {
  ctx.session.isAllBack = true
  ctx.session.settingValue = false
  return ctx.editMessageText(`Редактирование отменено`)
})

bot.action(/\* (.+)/, ctx => {
  if (!ctx.session.settingValue) return ctx.reply('Введите значение заново')
  const param = ctx.match[1]
  const val = ctx.session.settingValue

  settings.currencies[param] = val
  try {
    fs.writeFileSync('settings.json', JSON.stringify(settings, null, 2))    
  } catch (err) {
    return ctx.reply(JSON.stringify(err, d))
  }
  return ctx.reply(`Значение параметра "${param}" сменено на "${val}"`)
})

bot.on('text', async ctx => {
  const text = ctx.update.message.text
  const id = ctx.update.message.from.id
  
  if (text === 'id') ctx.reply(id)

  if (settings.admins.includes(id) && text.split && text.split(' ')[0] === 'set') {
    const val = text.slice(4)
    if (!val || val.length <= 0) return ctx.reply('Неправильно введена команда')
    ctx.session.settingValue = val
    const buttons = Object.keys(settings.currencies).map(el => [Markup.callbackButton(el, '* '+el)])
    buttons.push([Markup.callbackButton('❌ Отменить', 'cancel')])
    return ctx.reply('Какому параметру присвоить значение\n'+val, Markup.inlineKeyboard(buttons).resize().extra())
  } else if (settings.admins.includes(id) && text === 'show') {
    let str = ''
    Object.keys(settings.currencies).map(el => {str += `${el} = ${settings.currencies[el]}\n`})
    return ctx.reply(str, {disable_web_page_preview: true})
  }

  if (text === '/start' || text === 'В начало' || ctx.session.isAllBack) {
    ctx.session.isAllBack = true
    return ctx.reply(`Вас приветствует Обменник ${settings.currencies.to}\nКурс сегодня: 1 ${settings.currencies.from} = ${settings.currencies.curr} ${settings.currencies.to}\nВыберите действие:`, getStartKb())
  } else if (ctx.session.isChecking) {
    ctx.session.isChecking = false
    ctx.session.isAllBack = true
    if (+text === ctx.update.message.from.id*2-123456) return ctx.reply(`Ваша заявка № ${text}
Статус: в ожидании перевода
Для завершения обмена, сделайте, пожалуйста, перевод по заявке!`)
    return ctx.reply('Не правильный номер заявки.', backKb)
  } else if (ctx.session.withdraw && ctx.session.withdraw.state) {
    switch (ctx.session.withdraw.state) {
      case 1: // card
        if (!/^(?:[0-9]{16})$/.test(text)) return ctx.reply('Неправильно введена карта', backKb)
        ctx.session.withdraw.state = 2
        ctx.session.withdraw.card = text
        await ctx.reply(`Курс: 1 ${settings.currencies.from} = ${settings.currencies.curr} ${settings.currencies.to}\nРезерв: 682791 ${settings.currencies.to}`)
        return ctx.reply(`Введите количество ${settings.currencies.from} для вывода:`, backKb)
        break;

      case 2: // card
        if (!ctx.session.withdraw.card) return ctx.reply('Введите номер карты еще раз', backKb)
        const num = parseFloat(text)
        if (!num) return ctx.reply('Некорректно введено количество')
        if (num < 100 || num > 100000) return ctx.reply('Количество не может быть менее 100 или более 100 тыс')
        ctx.session.withdraw.amount = num
        ctx.reply(`Проверьте правильность данных:\nНомер карты: ${ctx.session.withdraw.card}\n📤 Отдаете: ${ctx.session.withdraw.amount} ${settings.currencies.from}\n📥 Получаете: ${getGettingAmount(ctx.session.withdraw.amount).toFixed(3)} ${settings.currencies.to}`, Markup.inlineKeyboard([[Markup.callbackButton('Подтвердить', 'agree')]]).resize().extra())
        ctx.session.isAllBack = true
        break;
    }
  } else {
    ctx.session.isAllBack = true
    return ctx.reply(`Вас приветствует Обменник ${settings.currencies.to}\nКурс сегодня: 1 ${settings.currencies.from} = ${settings.currencies.curr} ${settings.currencies.to}\nВыберите действие:`, getStartKb())
  }
})

function getGettingAmount(amount) {
  return parseFloat(settings.currencies.curr) * +amount
}

module.exports = {tg: bot}