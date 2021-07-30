<?php


class SettingController extends Controller
{

    function render()
    {
        $template = new Template;
        $this->f3->set('content','setting.htm');
        echo $template->render('layout/layout.htm');
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
