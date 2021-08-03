<?php

use Telegram\Bot\Api;

class MainController extends Controller
{
    function beforeroute()
    {
    }

    function render()
    {
        $telegram = new Api($this->f3->get('token'));
        $response = $telegram->getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();
        file_put_contents(__DIR__ . 'filename.txt', print_r($response, true));
    }
}
