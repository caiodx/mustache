<?php
$app->group('', function(){
    $this->get('/', 'HomeController:index');
    $this->get('/sair/:id', 'HomeController:sair')->setName('sair');
    $this->get('/home', 'HomeController:home')->setName('home');
})->add(new \App\Middelware\AuthMiddelware($container));