<?php

namespace App\Controllers;

class HomeController extends Controller
{
	public function index($request, $response)
	{
		return $response->withRedirect($this->container->router->pathFor('home'));			
	}

	public function sair($request, $response)
	{
		$this->auth->logout();
		return $response->withRedirect($this->container->router->pathFor('home'));		
	}

	public function home($request, $response)
	{
		return $this->view->render($response, 'principal/principal.html');
			
	}
}