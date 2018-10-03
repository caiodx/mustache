<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
	public $timestamps = true;
	protected $primaryKey = "id";
	
	protected $fillable = [
		'id', 
		'classeid', 
        'especificacao',
        'base',
		'tipo'		
	];

}