-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июл 03 2018 г., 13:02
-- Версия сервера: 10.1.31-MariaDB-cll-lve
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `i1081213_tap`
--

-- --------------------------------------------------------

--
-- Структура таблицы `spamers`
--

CREATE TABLE `spamers` (
  `spamer` varchar(58) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` int(255) NOT NULL DEFAULT '0',
  `tokens` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `spamers`
--

INSERT INTO `spamers` (`spamer`, `balance`, `tokens`) VALUES
('pFishVK', 0, '3'),
('amorskam', 0, '0'),
('cashwheel', 0, '0'),
('vanchestercity', 0, '0'),
('draiman3838', 0, '0'),
('cigil86', 0, '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
