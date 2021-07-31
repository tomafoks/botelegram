<?php


class SettingController extends Controller
{

    function render()
    {
        $template = new Template;
        $setting = new Setting($this->db);
        $setting->getSetting();
        $this->f3->set('setting', $setting->url);
        $this->f3->set('content','setting.htm');
        $this->f3->set('URL' ,$this->f3->get('SCHEME') . '://' . $this->f3->get('HEADERS.Host'));
        echo $template->render('layout/layout.htm');
    }

    function store()
    {
        
    }

    function setWebHook()
    {
    }

    function getWebHookInfo()
    {
    }

    function getTelegramDate()
    {
    }
}
