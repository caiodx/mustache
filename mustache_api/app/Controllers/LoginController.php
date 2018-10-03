<?php

namespace App\Controllers;

class LoginController extends Controller
{
	public function postLogin($request, $response)
	{
		// tenta logar
		$auth = $this->auth->attempt(
			$request->getParam('usuario'),
			$request->getParam('senha')
		);
		
		$retorno = array('auth' => ($auth == true));
		
		return $response->withHeader('Content-type', 'application/json')->withJSON($retorno);
				
	}
}