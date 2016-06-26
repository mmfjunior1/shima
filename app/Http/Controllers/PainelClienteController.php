<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\ParcelasAluguel;
use App\Search;
use App\Documento;
use Auth;

class PainelClienteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $user;
    function __construct()
    {
    	$this->user = Auth::user();
    }
    
    public function index( Request $request )
    {
    	
		return view('contents.indexPainelCliente',['search'=>null,'dado'=>null,'user'=>$this->user]);
    }
    
    function dadosPessoais($id = 0,$json = false)
    {
    	$resultSet					= $this->user;
    	if($json )
    	{
    		return response()->json($resultSet);
    	}
    	 
    	return view('contents.indexPainelClienteContent',['user'=>$resultSet]);
    }
    
    function painelFinanceiro()
    {
    	return view('contents.indexPainelClienteFinanceiroContas',['user'=>$this->user]);
    }
    
    function financeiro()
    {
    	$resultSet	= Search::select("*")->where(["inquilino"=>$this->user->id,"operacao"=>2])->paginate(8);
    	
    	return view('contents.indexPainelClienteFinanceiroContent',['search'=>$resultSet,'user'=>$this->user]);
    }
    
    function financeiroReceber()
    {
    	$resultSet	= Search::select("*")->
    	join('aluguel','imoveis.id','=', 'aluguel.id')
    	->
    	where('inquilino','>',0)->where('id_cliente','=',$this->user->id)->paginate(8);
    	return view('contents.indexPainelClienteFinanceiroContentReceber',['search'=>$resultSet,'user'=>$this->user]);
    }
    
    function alugueis($id = 0)
    {
    	$resultSet	= ParcelasAluguel::select("*")->where(["id"=>$id])->orderBy('data_vencimento','desc')->take(3)->get();
    	 
    	return view('contents.indexPainelClienteFinanceiroContentAlugueis',['search'=>$resultSet,'user'=>$this->user]);
    }
    
    function alugueisReceber($id = 0)
    {
    	$resultSet	= ParcelasAluguel::select("*")->where(["id"=>$id])->orderBy('data_vencimento','desc')->take(3)->get();
    
    	return view('contents.indexPainelClienteFinanceiroContentAlugueisReceber',['search'=>$resultSet,'user'=>$this->user]);
    }
    
    function documentos()
    {
    	$documentos		= new Documento();
    	
    	$dados 			= $documentos->select('*')->where('id_cliente','=',$this->user->id)->orderBy('created_at','desc')->paginate(8);
    	
    	return view('contents.indexPainelClienteDocumentoContent',['search'=>$dados,'user'=>$this->user]);
    }
}
