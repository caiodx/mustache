<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	protected $fillable = [
		'id', 
		'usuario', 
		'senha',
		'tipo'
	];

	// public function setPassword($password)
	// {
	// 	$this->update([
	// 		'password' => password_hash($password, PASSWORD_DEFAULT)
	// 	]);
	// }
}