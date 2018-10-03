<?php
 //$app->get('/convites', 'ConviteController:postSalvar');

$app->group('/cartao', function(){
    $this->get('', 'CartaoController:CriarCliente');     
})->add(new \App\Middelware\AuthMiddelware($container));
