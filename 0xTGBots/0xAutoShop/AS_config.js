var config = {};

// Администраторы бота:
config.admin_list = [] // ID админов бота

// Системные параметры бота:
config.mongodb = "mongodb://dbuser:dfghtrfh6r6г1ty@ds127376.mlab.com:27376/asdb"; // URL MongoDB базы 
config.token = ""; // API ключ бота
config.bot_username = "" // Юзернейм бота
config.mm_interval = 100; // Интервал между сообщениями при рассылке

// Партнёрка бота:
config.ref1_percent = 0.15; // % партнёрских отчислений 1ого уровня
config.ref2_percent = 0.1; // % партнёрских отчислений 2ого уровня
config.min_payout = 5; // Минимальный размер выплаты

// Платёжные системы
config.exmo_enabled = false;

config.about_text = 'Добро пожаловать в Lamp Shop! Мы являемся одним из лучших поставщиком веществ на рынке Москвы'

module.exports = config;
