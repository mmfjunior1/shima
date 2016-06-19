<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Search extends Model
{
    //
	protected $table = 'imoveis';
	protected $fillable		= ['id_cliente','inquilino', 'tipo','valor_imovel','operacao','area','quartos','suites','banheiros','vagas','cep','logradouro','numero','bairro','localidade','uf','latitude','longitude','status'];
	
	public function pegaDadosImoveis($request = null, $page = 8, $admin = false)
	{
		//$imoveis 		= Search::paginate(20);
		$localidade			= $request->localidade;
		$logradouro			= $request->logradouro;
		$bairro				= $request->bairro;
		$uf					= $request->uf;
		$operacao			= (int)$request->operacao;
		$tipoImovel			= (int)$request->tipo_imovel;
		$area				= $request->area;
		$tipo				= ucfirst(strtolower(trim($request->tipo_imovel)));
		$route				= $request->route;
		$array				= array();
		if($tipo)
		{
			$array['tipo_imovel']		= $tipo;
		}
		if($localidade)
		{
			$array['localidade']		= $localidade;
		}
		if($area)
		{
			$array['area']				= $area;
		}
		
		if($logradouro)
		{
			$array['logradouro']		= $logradouro;
		}
		if($bairro)
		{
			$array['bairro']			= $bairro;
		}
		if($uf && $uf != 'BR')
		{
			$array['uf']		= $uf;
		}
		if($operacao > 0)
		{
			$array['operacao']		= $operacao;
		}
		if($tipoImovel > 0)
		{
			$array['tipo']	= $tipoImovel;
		}
		
		if($admin == false)
		{
			$array['status']	= 't';
			if(count($array) > 0)
			{
				
				$imoveis	= Search::select('*')->join('tipo_imovel','imoveis.tipo','=','tipo_imovel.id_tipo')->where($array)->paginate($page)->appends($array);
			}
			else
			{
				$imoveis		= Search::select('*')->join('tipo_imovel','imoveis.tipo','=','tipo_imovel.id_tipo')->paginate($page)->appends($array);
			}
			$imovelCidade 	= DB::table('imoveis')->select(DB::raw('count(localidade) as conta, localidade'))->groupBy('localidade')->get();
			$imovelOperacao	= DB::table('imoveis')->select(DB::raw('count(operacao) as conta,operacao'))->groupBy('operacao')->get();
			$imovelTipo		= DB::table('imoveis')->select(DB::raw('count(tipo) as conta,tipo_imovel,tipo'))->join('tipo_imovel','imoveis.tipo','=','tipo_imovel.id_tipo')->groupBy(array('tipo_imovel','tipo'))->get();
			$areaTotal		= DB::table('imoveis')->select(DB::raw('count(area) as conta,area'))->groupBy(array('area'))->get();
			$maiorPreco		= DB::table('imoveis')->max('valor_imovel');
			$menorPreco		= DB::table('imoveis')->min('valor_imovel');
			$maiorPreco		= number_format($maiorPreco,2,",",".");
			$menorPreco		= number_format($menorPreco,2,",",".");
			return ['search'=>$imoveis,'areaTotal'=>$areaTotal, 'imovelCidade'=>$imovelCidade,'imovelOperacao'=>$imovelOperacao,'tipoImovel'=>$imovelTipo,'maiorPreco'=>$maiorPreco,'menorPreco'=>$menorPreco,"tipo"=>$tipo,"logradouro"=>$logradouro,"route"=>$route,'count'=>count($imoveis)];
		}
		
		if($admin == true)
		{
			$dado	= $request->dado;
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
				$array['cpf']					= $cpf;
				$array['imoveis.logradouro'] 	= $dado;
				$array['imoveis.bairro']	 	= $dado;
				$array['imoveis.localidade'] 	= $dado;
				$array['imoveis.uf'] 			= $dado;
				$array['nome']		 			= $dado;
				
			}
			if(count($array) > 0)
			{
				$imoveis 		= Search::select('imoveis.*')->leftJoin('clientes','imoveis.id_cliente','=', 'clientes.id')
									->orWhere(function ($imoveis) use ($array){
										foreach($array as $field=>$value)
										{
											
											$imoveis->orWhere($field,'ilike','%'.$value.'%');
										}
									})->paginate($page)->appends(['dado'=>$dado]);
			}
			else
			{
				$imoveis 		= Search::select('imoveis.*')->leftJoin('clientes','imoveis.id_cliente','=', 'clientes.id')->paginate($page);
			}
			return ['search'=>$imoveis,'dado'=>$dado];
		}
		
	}
	function viewRegistroImovel($id = 0)
	{
		//$dados = Search::find($id);
		$array['id'] 		= $id;
		$array['status'] 	= 't';
		
		$dados	= Search::select('*')->join('tipo_imovel','imoveis.tipo','=','tipo_imovel.id_tipo')->where($array)->get();
		
		return ['search'=>$dados,];
	}
}
