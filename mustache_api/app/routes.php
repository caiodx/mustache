<?php

$app->get('/', function ($request, $response, $args) {
    echo "Acesso não autorizado!";
});


$app->post('/login', 'LoginController:postLogin');

include_once('rotas/convites-rotas.php');
include_once('rotas/parametros-rotas.php');
include_once('rotas/membros-rotas.php');
include_once('rotas/produtos-rotas.php');
include_once('rotas/cartao-rotas.php');
?>