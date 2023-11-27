const chalk = require('chalk')

function cout(str, color) {
	str = getDateString() + str

	if (color) {
		console.log(color(str));
	} else {
		console.log(str);
	}
}

function cerr(str) {
	cout(str, chalk.red.bold);
}

function cwarn(str) {
	cout(str, chalk.yellow.bold);
}

function csuccess(str) {
	cout(str, chalk.green.bold);
}

function getDateString(DateFormatOptions = {day: 'numeric', month: 'long', year: 'numeric', hour: 'numeric', minute: "numeric", second: "numeric"}) {
  let date = new Date();

	str = "[" + date.toLocaleDateString(
		'en-US',
		DateFormatOptions
	) + "] "

  return str
}

module.exports = {cout, cerr, cwarn, csuccess, getDateString}