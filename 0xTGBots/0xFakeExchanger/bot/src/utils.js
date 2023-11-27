const utils = {}

utils.getDate = unixTime => {
  const t = new Date(unixTime * 1000)

  const old_month = t.getMonth() + 1
  const month = (old_month <= 9) ? '0' + old_month : old_month

  const old_day = t.getDate()
  const day = (old_day <= 9) ? '0' + old_day : old_day

  const old_minute = t.getMinutes()
  const minute = (old_minute <= 9) ? '0' + old_minute : old_minute

  const temp = {year: t.getFullYear(), month: month, day: day, hour: t.getHours(), minute: minute}
  temp.full = `${temp.month}.${temp.day}.${temp.year} ${temp.hour}:${temp.minute}`

  return temp
}

module.exports = utils