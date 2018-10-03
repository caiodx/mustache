<?php

$app->group('/cartao', function(){
    $this->get('', 'CartaoController:index');   
})->add(new \App\Middelware\AuthMiddelware($container));