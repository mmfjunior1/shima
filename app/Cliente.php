<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
	protected $table 		='clientes';
	
	protected $fillable		= ['nome','cpf','cnpj','rg','data_nascimento','logradouro','numero','bairro','localidade','uf','cep','telefone1','telefone2','email','senha','senha_aberta','password'];
}
