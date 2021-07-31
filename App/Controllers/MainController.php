<?php

class MainController extends Controller
{
    function beforeroute()
    {
    }

    function render()
    {
        $body = file_get_contents('php://input'); //Получаем в $body json строку
        $arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr
        $sms = $arr['message']['text']; //Получаем текст сообщения, которое нам пришло.
        //О структуре этого массива который прилетел нам от телеграмма можно узнать из официальной документации.

        //Сразу и id получим, которому нужно отправлять всё это назад
        $tg_id = $arr['message']['chat']['id'];

        // file_put_contents(__DIR__ . '/message.txt', print_r($tg_id, true));

        //Перевернём строку задом-наперёд используя функцию cir_strrev
        $sms_rev = $this->cir_strrev($sms);

        //Используем наш ещё не написанный класс, для отправки сообщения в ответ
        $this->send($tg_id, $sms_rev);
        exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
        // $template = new Template;
        // $this->f3->set('content', 'home.htm');
        // echo $template->render('layout/layout.htm');
    }

    function cir_strrev($stroka)
    { //Так как функция strrev не умеет нормально переворачивать кириллицу, нужен костыль через массив. Создадим функцию
        preg_match_all('/./us', $stroka, $array);
        return implode('', array_reverse($array[0]));
    }

    function send($id, $message)
    {   //Задаём публичную функцию send для отправки сообщений
        //Заполняем массив $data инфой, которую мы через api отправим до телеграмма
        $data = array(
            'chat_id'      => $id,
            'text'     => $message,
        );
        //Получаем ответ через функцию отправки до апи, которую создадим ниже
        $out = $this->request('sendMessage', $data);
        file_put_contents(__DIR__ . '/message.txt', print_r($out, true));

        //И пусть функция вернёт ответ. Правда в данном примере мы это никак не будем использовать, пусть будет задаток на будущее
        return $out;
    }

    function request($method, $data = array())
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->f3->get('token') .  '/' . $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); //Отправляем через POST
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //Сами данные отправляемые

        $out = json_decode(curl_exec($curl), true); //Получаем результат выполнения, который сразу расшифровываем из JSON'a в массив для удобства

        curl_close($curl); //Закрываем курл

        return $out; //Отправляем ответ в виде массива
    }
}
