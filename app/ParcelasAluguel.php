<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ParcelasAluguel extends Model
{
    //
	protected $table 		= 'aluguel';
	protected $fillable		= ['data_vencimento','valor','id','boleto',];
	
	public function parcelasAluguel($id = 0)
	{
		$dado			= $id;
		
		$alugueis 		= $this::select("*")->where('id','=',$dado)->paginate(5)->appends(['dado'=>$dado]);
		
		return ['search'=>$alugueis,];
		
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
