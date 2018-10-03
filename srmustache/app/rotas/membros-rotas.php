<?php

$app->group('/membros', function(){
    $this->get('', function ($request, $response, $args) {
        return $this->view->render($response, 'membros/membros-lista.html');
    })->setName('membros');

    $this->get('/novo', function ($request, $response, $args) {
        return $this->view->render($response, 'membros/membros-novo.html');
    })->setName('membros.novo');
    
})->add(new \App\Middelware\AuthMiddelware($container));

// Rotas do autocadastro
$app->group('/AutoCadastroMembro', function(){
    $this->get('/{token}', 'MembroController:index');
});

    /*
        $app->get('/AutoCadastroMembro/{token}', function ($request, $response, $args) {
            $this->get('/home', 'HomeController:home')->setName('home');
            return $this->view->render($response, 'autoCadastro/index.html');
	    })->setName('autoCadastro');
    */

	
?>