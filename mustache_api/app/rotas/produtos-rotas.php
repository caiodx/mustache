<?php
 //$app->get('/convites', 'ConviteController:postSalvar');

$app->group('/produtos', function(){
    $this->post('/salvar', 'ProdutoController:postSalvar');
    $this->get('/listar', 'ProdutoController:listarTodos');
    $this->get('/carregar_classes', 'ProdutoController:carregarClasses');
    $this->get('/carregar_produto', 'ProdutoController:carregarProduto');   
})->add(new \App\Middelware\AuthMiddelware($container));
