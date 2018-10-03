<?php

$app->group('/membros', function(){
    $this->post('/autoCadastrar', 'MembroController:autoCadastrar');
})->add(new \App\Middelware\AuthMiddelware($container));
