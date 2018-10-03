<?php

namespace App\Middelware;

class AuthMiddelware extends Middelware
{
	public function __invoke($request, $response, $next)
	{
		//se o usuário nao esta logado, redireciona para o login
		if (!$this->container->auth->check()) {			
			$retorno = array('erro' => "usuario nao autenticado");
			return $response->withRedirect($this->container->router->pathFor('login'))->withJSON($retorno);
		}else{
			// continua normalmente na rota
			$response = $next($request, $response);
			return $response;
		}

		
	}
}