<?php


class SettingController extends Controller
{
    function render()
    {
        $template = new Template;
        $setting = new Setting($this->db);
        $setting->getSetting();
        $this->f3->mset(
            array(
                'setting' => $setting->url_callback_bot,
                'content' => 'setting.htm',
                'alert' => $this->f3->get('COOKIE[alert]')
            )
        );
        setcookie("alert", "", time() - 3600); //удалить cookie alert
        $this->f3->set('URL', $this->f3->get('SCHEME') . '://' . $this->f3->get('HEADERS.Host'));
        echo $template->render('layout/layout.htm');
    }

    function store()
    {
        $setting = new Setting($this->db);
        $setting->edit();
        $this->f3->reroute('@backend_setting');
    }

    function setWebHook()
    {
        $url = $this->f3->get('POST.url_callback_bot');
        $result = $this->getTelegramDate('setWebHook',  ['url' => $url]);
        $this->f3->set('COOKIE[alert]', $result);
        $this->f3->reroute('@backend_setting');
    }

    function getWebHookInfo()
    {
        $result = $this->getTelegramDate('getWebHookInfo');
        var_dump($result);
        $this->f3->set('COOKIE[alert]', $result);
        $this->f3->reroute('@backend_setting');
    }

    function getTelegramDate($method, $data = array())
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->f3->get('token') .  '/' . $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); //Отправляем через POST
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //Сами данные отправляемые

        $out = json_encode(curl_exec($curl), true); //Получаем результат выполнения, который сразу расшифровываем из JSON'a в массив для удобства

        curl_close($curl); //Закрываем курл

        return $out; //Отправляем ответ в виде массива
    }
}
