<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;

class MembroController extends Controller
{
	
	public function autoCadastrar($request, $response){
		$nome = $request->getParam('txtNome');

		echo $nome;
	}

	

	
}