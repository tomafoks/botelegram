<?php

use App\Controllers\Telegram\Commands\TestCommand;
use Telegram\Bot\Api;

class MainController extends Controller
{
    function beforeroute()
    {
    }

    function render()
    {
        $telegram = new Api($this->f3->get('token'));
        $telegram->addCommand(TestCommand::class);
        $update = $telegram->commandsHandler(true);
    }
}
