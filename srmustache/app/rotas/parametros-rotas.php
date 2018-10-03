<?php

	$app->group('/parametros', function(){
		$this->get('/email', function ($request, $response, $args) {
			return $this->view->render($response, 'parametros/email.html');
		})->setName('parametros.email');
	})->add(new \App\Middelware\AuthMiddelware($container));

?>