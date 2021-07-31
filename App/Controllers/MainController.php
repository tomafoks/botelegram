<?php

class MainController extends Controller
{

    function render()
    {
        $template = new Template;
        $this->f3->set('content', 'home.htm');
        echo $template->render('layout/layout.htm');
    }
}
