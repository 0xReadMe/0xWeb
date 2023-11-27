-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 24 2019 г., 21:18
-- Версия сервера: 5.5.54
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `xmbrwatg_cash`
--

-- --------------------------------------------------------

--
-- Структура таблицы `demo_admin`
--

CREATE TABLE `demo_admin` (
  `id` int(11) NOT NULL,
  `win_youtuber` int(11) NOT NULL,
  `lose_youtuber` int(11) NOT NULL,
  `win_user` int(11) NOT NULL,
  `lose_user` int(11) NOT NULL,
  `pd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_admin`
--

INSERT INTO `demo_admin` (`id`, `win_youtuber`, `lose_youtuber`, `win_user`, `lose_user`, `pd`) VALUES
(1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `demo_email`
--

CREATE TABLE `demo_email` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` text NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_email`
--

INSERT INTO `demo_email` (`id`, `user_id`, `hash`, `data`) VALUES
(6, 1, 'IdIDaetdidQFpSIeaSHyyEyYoROpGhTYAfUFodOOOoRIpdi', '1558254585');

-- --------------------------------------------------------

--
-- Структура таблицы `demo_games`
--

CREATE TABLE `demo_games` (
  `id` int(11) NOT NULL,
  `user_id` text,
  `login` text,
  `chislo` text,
  `cel` text,
  `suma` text,
  `shans` text,
  `win_summa` text,
  `type` text,
  `data` text,
  `hash` text,
  `salt1` text,
  `salt2` text,
  `saltall` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_games`
--

INSERT INTO `demo_games` (`id`, `user_id`, `login`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `hash`, `salt1`, `salt2`, `saltall`) VALUES
(1, '', 'falos24\n', '475039', '100000-999999', '429', '69', '0', 'lose', '1561400291', 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e', NULL, NULL, ''),
(2, '', 'Elec3roCat73\n', '705929', '200000-999999', '2755', '36', '0', 'lose', '1561400295', 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e', NULL, NULL, ''),
(3, '', 'Russl\n', '418531', '100000-999999', '1972', '41', '4809.76', 'win', '1561400299', 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `demo_payments`
--

CREATE TABLE `demo_payments` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `suma` text NOT NULL,
  `data` text NOT NULL,
  `qiwi` text NOT NULL,
  `transaction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_payments`
--

INSERT INTO `demo_payments` (`id`, `user_id`, `suma`, `data`, `qiwi`, `transaction`) VALUES
(1, '1', '20', '2019-05-30 12:44:44', 'free-kassa', '8467');

-- --------------------------------------------------------

--
-- Структура таблицы `demo_payout`
--

CREATE TABLE `demo_payout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suma` text NOT NULL,
  `qiwi` text NOT NULL,
  `status` text NOT NULL,
  `data` text NOT NULL,
  `ip` text NOT NULL,
  `system` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_payout`
--

INSERT INTO `demo_payout` (`id`, `user_id`, `suma`, `qiwi`, `status`, `data`, `ip`, `system`) VALUES
(6, 9, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `demo_promo`
--

CREATE TABLE `demo_promo` (
  `id` int(11) NOT NULL,
  `promo` text NOT NULL,
  `active` text NOT NULL,
  `activelimit` text NOT NULL,
  `idactive` text NOT NULL,
  `data` text NOT NULL,
  `summa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_promo`
--

INSERT INTO `demo_promo` (`id`, `promo`, `active`, `activelimit`, `idactive`, `data`, `summa`) VALUES
(10, 'FDH2GK5', '0', '5', '', '24.06.2019 18:08:19', 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `demo_users`
--

CREATE TABLE `demo_users` (
  `id` int(11) NOT NULL,
  `login` text,
  `password` text,
  `email` text,
  `hash` text,
  `prava` int(11) NOT NULL,
  `ban` int(11) DEFAULT NULL,
  `ban_mess` text,
  `ip_reg` text,
  `ip` text,
  `referer` text,
  `data_reg` text,
  `online` int(11) DEFAULT NULL,
  `online_time` int(11) DEFAULT NULL,
  `balance` text,
  `bonus` int(11) DEFAULT NULL,
  `bonus_url` text,
  `vkname` text,
  `vkhash` text,
  `youtube` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_users`
--

INSERT INTO `demo_users` (`id`, `login`, `password`, `email`, `hash`, `prava`, `ban`, `ban_mess`, `ip_reg`, `ip`, `referer`, `data_reg`, `online`, `online_time`, `balance`, `bonus`, `bonus_url`, `vkname`, `vkhash`, `youtube`) VALUES
(0, '', '', '', '', 0, NULL, NULL, '', '', '', '', 0, 15, '0', 1, '0', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `demo_win`
--

CREATE TABLE `demo_win` (
  `id` int(11) NOT NULL,
  `win` text NOT NULL,
  `lose` text NOT NULL,
  `pd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_win`
--

INSERT INTO `demo_win` (`id`, `win`, `lose`, `pd`) VALUES
(1, '0', '0', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `demo_admin`
--
ALTER TABLE `demo_admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_email`
--
ALTER TABLE `demo_email`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `demo_games`
--
ALTER TABLE `demo_games`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `demo_payments`
--
ALTER TABLE `demo_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_payout`
--
ALTER TABLE `demo_payout`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `demo_promo`
--
ALTER TABLE `demo_promo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_users`
--
ALTER TABLE `demo_users`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `demo_win`
--
ALTER TABLE `demo_win`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `demo_admin`
--
ALTER TABLE `demo_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `demo_email`
--
ALTER TABLE `demo_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `demo_games`
--
ALTER TABLE `demo_games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `demo_payments`
--
ALTER TABLE `demo_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `demo_payout`
--
ALTER TABLE `demo_payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `demo_promo`
--
ALTER TABLE `demo_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `demo_users`
--
ALTER TABLE `demo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `demo_win`
--
ALTER TABLE `demo_win`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
