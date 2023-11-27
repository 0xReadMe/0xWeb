<?php

	if(preg_match('/\/setimage/i', $message['text']) == TRUE) {
		if(preg_match('/\/setimage (.{24}|\d+);.+/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 10));
			
			if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
				$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");
				
				if(mysqli_num_rows($query) > 0) {
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

?>