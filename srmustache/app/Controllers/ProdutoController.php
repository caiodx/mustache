<?php

namespace App\Controllers;

class ProdutoController extends Controller
{
	public function index($request, $response)	{

		return $this->view->render($response, 'produtos/produtos-lista.html');
	}


	public function novo($request, $response)	{

		return $this->view->render($response, 'produtos/produtos-novo.html');
	}

	public function editar($request, $response)	{

		return $this->view->render($response, 'produtos/produtos-novo.html');
	}
}