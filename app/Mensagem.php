<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Mensagem extends Model
{
    //
	protected $table 		= 'mensagem';
	protected $primaryKey	= 'id_mensagem';
	protected $fillable		= ['id','mensagem', 'email','titulo','nome',];
	
	public function mensagens($request = null, $page = 8)
	{
		$dado						= $request->dado;
		$array						= array();
		if($dado)
		{
			$array['nome']		 			= $dado;
			$array['email']		 			= $dado;
		}
	
		$mensagens 		= Mensagem::select(['*'])
		->where(function ($mensagens) use ($array){
			foreach($array as $field=>$value)
			{
				$mensagens->orWhere($field,'ilike','%'.$value.'%');
			}
		})->orderBy('created_at','desc')->
		paginate($page)->appends(['dado'=>$dado]);
	
	
		return ['search'=>$mensagens,'dado'=>$dado];
	
	}
	
}
