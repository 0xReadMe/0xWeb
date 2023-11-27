<?php
// определим кодировку UTF-8 и ответ 200
header("HTTP/1.1 200 OK");
header('Content-type: text/html; charset=utf-8');
// создаем объект бота
$newBot = new HelloBot();
// запускаем бота
$newBot->init();

/** Класс Бота
 * Class HelloBot
 */
class HelloBot
{
    // токен вашего бота
    private $token = "1274154595:AAGYCyTQbqGi5XMbiItsKBLx8qpOBvK-A2Q";
    // Приветствие пользователя
    private $helloText = "👑Добро пожаловать в чат, {%username%}!👑\n\n⚙️БОТ — @projmnky_bot\n➖➖➖➖➖➖➖➖➖➖\n💸 Канал с залётами —\nhttps://t.me/projmnkyinfo\n💵 Выплаты — 70% + комиссия обменника\n💳 Принимаем от 70 BYN до 3000 BYN\n➖➖➖➖➖➖➖➖➖➖\nМануал Kufar 2.0 - https://telegra.ph/Manual-Kufar-20-06-18\n➖➖➖➖➖➖➖➖➖➖\n📲Актитивация Viber,Kufar — @SMSBest_bot\n🤖Аккаунты —  @mramorstore_bot\n🏓Бомбер - @reidsbomber_bot\n➖➖➖➖➖➖➖➖➖➖\n👨‍💻Саппорты:\n👳‍♀️@hrz14rv\n👳‍♀️@tema_dev\n👳‍♀️@flexyenot\n👳‍♀️@gypssteam\n\nЕсли предоплата, пишем @flexyenot, выдаст карту!";

    /** Стартуем  бота
     * @return bool
     */
    public function init()
    {
        // получаем данные от АПИ и преобразуем их в ассоциативный массив
        $rawData = json_decode(file_get_contents('php://input'), true);
        // направляем данные из бота в метод
        // для определения дальнейшего выбора действий
        $this->router($rawData);
        // в любом случае вернем true для бот апи
        return true;
    }

    /** Роутер - Определяем что делать с данными от АПИ
     * @param $data
     * @return bool
     */
    private function router($data)
    {
        // проверяем массив данных на нужный нам ключ
        if (array_key_exists("new_chat_participant", $data['message'])) {
            // достаем имя нового пользователя
            $name = trim($data['message']['new_chat_participant']['first_name']
                . ' ' . $data['message']['new_chat_participant']['last_name']);
            // отправляем приветствие в чат
            $this->botApiQuery("sendMessage", [
                    'chat_id' => $data['message']['chat']['id'],
                    'text' => str_replace("{%username%}", $name, $this->helloText)
                ]
            );
        }
        return true;
    }

    /** Запрос к BotApi
     * @param $method
     * @param array $fields
     * @return mixed
     */
    private function botApiQuery($method, $fields = array())
    {
        $ch = curl_init('https://api.telegram.org/bot' . $this->token . '/' . $method);
        curl_setopt_array($ch, array(
            CURLOPT_POST => count($fields),
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 10
        ));
        $r = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $r;
    }
}
?>