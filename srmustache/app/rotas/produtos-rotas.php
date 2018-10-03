<?php

	$app->group('/produtos', function(){
		$this->get('', 'ProdutoController:index')->setName('produtos');
		$this->get('/novo', 'ProdutoController:novo')->setName('produtos.novo');
		$this->get('/{id}', 'ProdutoController:novo')->setName('produtos.editar');
	})->add(new \App\Middelware\AuthMiddelware($container));

?>