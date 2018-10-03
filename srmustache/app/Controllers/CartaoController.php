<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;

class CartaoController extends Controller   
{
	public function index($request, $response)
	{        
        return $this->view->render($response, 'cartao/teste.html');		
	}
	
}