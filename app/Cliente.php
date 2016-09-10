<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\helpers;
class Cliente extends Model
{
    //
	protected $table 		='clientes';
	
	protected $fillable		= ['tipo', 'nome','cpf','cnpj','rg','data_nascimento','logradouro','numero','bairro','localidade','uf','cep','telefone1','telefone2','email','senha','senha_aberta','password'];
	
	public function getCreatedAtAttribute($value)
	{
		$valor	= \App\helpers\Helpers::dateFormat($value);
		return $valor;
	}
}
