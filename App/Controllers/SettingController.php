<?php

use GuzzleHttp\Client;

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
                'alert' => $this->f3->get('COOKIE[alert]'),
                'URL', $this->f3->get('SCHEME') . '://' . $this->f3->get('HEADERS.Host')
            )
        );
        setcookie("alert", "", time() - 3600); //удалить cookie 'alert'
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
        $result = $this->getTelegramDate(
            'setwebhook',
            [
                'query' => [
                    'url' => $url
                ]
            ]
        );

        $this->f3->set('COOKIE[alert]', $result);
        $this->f3->reroute('@backend_setting');
    }

    function getWebHookInfo()
    {
        $result = $this->getTelegramDate('getWebHookInfo');
        $this->f3->set('COOKIE[alert]', $result);
        $this->f3->reroute('@backend_setting');
    }

    function getTelegramDate($route = '', $params = [], $method = 'post')
    {
        $client = new Client(['base_uri' => 'https://api.telegram.org/bot' . $this->f3->get('token') . '/']);
        $result = $client->request($method, $route, $params);
        return (string) $result->getBody();
    }
}
