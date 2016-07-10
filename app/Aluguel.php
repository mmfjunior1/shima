<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Aluguel extends Model
{
    //
	protected $table 		= 'imoveis';
	//protected $fillable		= ['id_cliente','tipo','valor_imovel','operacao','area','quartos','suites','banheiros','vagas','cep','logradouro','numero','bairro','localidade','uf','latitude','longitude'];
	
	public function imoveisAluguel($request = null, $page = 8)
	{
		$dado						= $request->dado;
		$array						= array();
		if($dado)
		{
			$cpf	= $dado;
			$cep	= $dado;
			if(strlen($cpf) >=11)
			{
				$cpf	= str_replace(['.','-',' '], '', $cpf);
				$cpf	= substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
			}
			if(strlen($cep) >=8)
			{
				$cep	= str_replace(['.','-',' '], '', $cpf);
				$cep	= substr($cep,0,5).'-'.substr($cep,5,3);
			}
			$array['imoveis.cep'] 			= $cep;
			$array['imoveis.cep'] 			= $cep;
			$array['cpf']					= $cpf;
			$array['imoveis.logradouro'] 	= $dado;
			$array['imoveis.bairro']	 	= $dado;
			$array['imoveis.localidade'] 	= $dado;
			$array['imoveis.uf'] 			= $dado;
			$array['nome']		 			= $dado;
			$array['codigo_imobiliaria']	= $dado;
			
		}
		
		$imoveis 		= Aluguel::select(['clientes.id as id_cliente','clientes.nome','imoveis.*'])
								->join('clientes','imoveis.inquilino','=', 'clientes.id')
								->where('operacao','=',2)->where(function ($imoveis) use ($array){
									foreach($array as $field=>$value)
									{
										$imoveis->orWhere($field,'ilike','%'.$value.'%');
									}
								})
								->orderBy('codigo_imobiliaria')
								->paginate($page)->appends(['dado'=>$dado]);
								
								
		return ['search'=>$imoveis,'dado'=>$dado];
		
	}
	function viewRegistroImovel($id = 0)
	{
		$dados = Search::find($id);
		$array['id'] 		= $id;
		$array['status'] 	= 't';
		
		$dados	= Search::select('*')->join('tipo_imovel','imoveis.tipo','=','tipo_imovel.id_tipo')->where($array)->get();
		
		return ['search'=>$dados,];
	}
}
