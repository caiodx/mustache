<?php

namespace App\Auth;

use App\Models\Usuario;

class Auth
{
	public function user()
	{
		if (isset($_SESSION['usuario'])) {
			return User::find($_SESSION['usuario']);
		}
	}

	public function check()
	{
		if (isset($_SESSION['usuario'])) {
			return isset($_SESSION['usuario']);
		}
	}

	public function attempt($login, $senha)
	{
		// tenta pegar o usuário pelo login e senha
		$user = Usuario::where('usuario' , $login)->where('senha' , $senha)->first();
		
		// verifica se existe
		if (!$user) {
			return false;
		}
		else{
			$_SESSION['usuario'] = $user->id;
			return true;
		}		
	}

	public function logout()
	{
		unset($_SESSION['usuario']);
	}
}