<?php


class SettingController extends Controller
{

    function render()
    {
        $template = new Template;
        $setting = new Setting($this->db);
        $setting->getSetting();
        $this->f3->set('setting', $setting->url_callback_bot);
        $this->f3->set('content','setting.htm');
        $this->f3->set('URL' ,$this->f3->get('SCHEME') . '://' . $this->f3->get('HEADERS.Host'));
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
    }

    function getWebHookInfo()
    {
    }

    function getTelegramDate()
    {
        $web = \Web::instance();
        $web->request('_curl')
        curl -F "url=https://<YOURDOMAIN.EXAMPLE>/<WEBHOOKLOCATION>" https://api.telegram.org/bot<YOURTOKEN>/setWebhook
    }
}
