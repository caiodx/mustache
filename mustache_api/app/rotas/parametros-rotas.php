<?php
 //$app->get('/convites', 'ConviteController:postSalvar');

$app->group('/parametros', function(){
    $this->post('/email/salvar', 'ParamEmailController:postSalvar');
    $this->get('/email/listar', 'ParamEmailController:listarTodos');
})->add(new \App\Middelware\AuthMiddelware($container));

