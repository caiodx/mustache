<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmailParametro extends Model
{
	protected $table = 'ConfigGlobalEmail';
	protected $primaryKey = 'ID';
	public $timestamps = false;
	protected $fillable = [
		'ID',
		'SMTP',
		'PORTA',
		'EMAIL',
		'SENHA',
		'TIPOSEGURANCA',
		'NOMEEXIBICAO',
		'EMAILEXIBICAO',
		'REQUER_AUTENTICACAO',
		'ENVIAHTML'
	];

}