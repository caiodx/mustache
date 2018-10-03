<?php

namespace App\Controllers;

class LoginController extends Controller
{
	public function index($request, $response)
	{
		return $this->view->render($response, 'login/login.html');
		
	}

	public function postLogin($request, $response)
	{
		// tenta logar
		$auth = $this->auth->attempt(
			$request->getParam('usuario'),
			$request->getParam('senha')
		);
		
		$retorno = array('auth' => ($auth == true), 'pagina_redirect' => $this->container->router->pathFor('home'));
		
		return $response->withHeader('Content-type', 'application/json')->withJSON($retorno);
				
	}
}