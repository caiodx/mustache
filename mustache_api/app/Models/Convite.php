<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convite extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'CONVITEID', 
		'NOME', 
		'EMAIL',
		'MENSAGEM', 
		'TOKEN', 
		'DATAENVIO',
		'DATACADASTRO'
	];

}