<?php



$app->group('', function(){
    $this->get('/login', 'LoginController:index')->setName('login');
})->add(new \App\Middelware\UserMiddelware($container));


include_once(dirname(__FILE__).'/rotas/principal-rotas.php');
include_once(dirname(__FILE__).'/rotas/produtos-rotas.php');
include_once(dirname(__FILE__).'/rotas/membros-rotas.php');
include_once(dirname(__FILE__).'/rotas/convites-rotas.php');
include_once(dirname(__FILE__).'/rotas/parametros-rotas.php');
include_once(dirname(__FILE__).'/rotas/cartao-rotas.php');

?>