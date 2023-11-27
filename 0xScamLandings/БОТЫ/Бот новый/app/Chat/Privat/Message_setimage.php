<?php

	if(preg_match('/^\/setimage/i', $message['text']) == TRUE) {
		if(preg_match('/^\/setimage ([a-z0-9]{24}|\d+);.+$/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 10));
			
			if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
				$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
				
				if(mysqli_num_rows($query) > 0) {
					$advert = mysqli_fetch_assoc($query);
					
					if($advert['worker'] == $message['from']) {
						if($advert['status'] > 1) {
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

?>