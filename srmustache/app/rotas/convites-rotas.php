<?php

$app->group('/convites', function(){
    $this->get('', function ($request, $response, $args) {
        return $this->view->render($response, 'convites/convites-lista.html');
    })->setName('convites');

    $this->get('/novo', function ($request, $response, $args) {
        return $this->view->render($response, 'convites/convites-novo.html');
    })->setName('convites.novo');
    
})->add(new \App\Middelware\AuthMiddelware($container));


 