<?php

// Kickstart the framework
$f3 = require('lib/base.php');

$db = new \DB\SQL('mysql:host=localhost;dbname=botelegram', 'root', 'root');
$user = new \DB\SQL\Mapper($db, 'users');
$auth = new \Auth($user, array('id' => 'user_id', 'pw' => 'password'));
$auth->basic(); // a network login prompt will display to authenticate the user

$f3->config('config.ini');
$f3->set('DEBUG', 3);
$f3->set('AUTOLOAD','autoload/');
$obj=new Gadgets\iPad;

$f3->route('GET /','app/controllers/TestController->index');
// $f3->route('POST /item','Item->action_post');
// $f3->route('PATCH /item','Item->action_patch');
// $f3->route('PUT /item','Item->action_put');
// $f3->route('DELETE /item','Item->action_delete');

$f3->run();
