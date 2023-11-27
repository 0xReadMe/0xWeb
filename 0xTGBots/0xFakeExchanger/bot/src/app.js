const settings = require('../settings.json')
const _ = require('./out.js')

init()
async function init() {
  console.log('\n\n')

  const bots = require('./bot.js')
  try {
		bots.tg.launch().catch(console.error)
	} catch(err) {
    _.cerr('Ошибка при запуске бота: ' + err + '\n')
    console.log(err)
		process.exit(1)
	}
  _.csuccess('Успешный запуск бота!')


	_.csuccess('Инициализация завершена!\n')
}