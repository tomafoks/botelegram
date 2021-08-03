<?php

use Telegram\Bot\Api;

class MainController extends Controller
{
    function beforeroute()
    {
    }

    function render()
    {
        $telegram = new Api($this->f3->get('token')); //Устанавливаем токен, полученный у BotFather

    }
}
