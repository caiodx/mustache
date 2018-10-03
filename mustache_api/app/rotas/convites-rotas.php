<?php
 //$app->get('/convites', 'ConviteController:postSalvar');

$app->group('/convites', function(){
    $this->post('/salvar', 'ConviteController:postSalvar');
    $this->get('/listar', 'ConviteController:listarTodos');
})->add(new \App\Middelware\AuthMiddelware($container));

$app->get('/convites/validarchave/{token}', 'ConviteController:validarChave');