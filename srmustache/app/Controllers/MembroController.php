<?php

namespace App\Controllers;

class MembroController extends Controller
{
	public function index($request, $response)
	{
		$token = $request->getAttribute('token');
		return $this->view->render($response, 'autoCadastro/index.html', [
			'token' => $token
		]);		
	}

}