<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Aluguel;
use App\Cliente;
use App\ParcelasAluguel;

class AluguelController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index( Request $request )
    {
    	$dado			= $request->dado;
    	$aluguelModel 	= new Aluguel();
    	$results		= $aluguelModel->imoveisAluguel($request);
    	return view('contents.indexAdminAlugueisListaContent',$results);
    }
    
    public function create()
    {
    	return view('contents.indexAdminClientesCadastroContent');
    }
    
    public function store(Request $request)
    {
    	$arrayTypes		= array('pdf');
    	
    	$arrayBoletos	= $request->file('sendFile');
    	
    	$idImovel		= (int)$request->id_imovel; 
    	
    	if($idImovel == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhum inquilino foi selecionado. Verifique as informações e tente novamente.</strong>','statusOperation'=>false,]);
    	}
    	$countImagens	= count($arrayBoletos);
    	if($countImagens == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhuma boleto foi enviado. Cada parcela deve conter um boleto no formato PDF.</strong>','statusOperation'=>false,]);
    	}
    	$arquivosFalhos	= "";
    	$a 				= 0 ;
    	foreach($arrayBoletos as $obj)
    	{
    		try
    		{
	    		$ext			= $obj->guessExtension();
	    		$vencimento		= $request->vencimento[$a];
	    		$valor			= $request->valor[$a];
	    		
	    		if(!in_array($ext, $arrayTypes))
	    		{
	    			return response()->json(['msg'=>'<strong>Atenção: Nenhum boleto foi enviado. Os boletos devem ser do formato PDF.</strong>','statusOperation'=>false,]);
	    			break;
	    		}
	    		if($vencimento	== "")
	    		{
	    			return response()->json(['msg'=>'<strong>A data de vencimento do boleto '.($a+1).' não foi informada. Verifique as informações e tente novamente.</strong>','statusOperation'=>false,]);
	    			break;
	    		}
	    		
	    		if((float)$valor == 0)
	    		{
	    			return response()->json(['msg'=>'<strong>O valor do boleto '.($a+1).' não foi informado. Verifique as informações e tente novamente.</strong>','statusOperation'=>false,]);
	    			break;
	    		}
	    		try
	    		{
	    			$nomeArquivo							= "ImoBiliariaShima-".time().$idImovel."-".$a.".pdf";
	    			 
	    			$caminhoArquivo							= 'boletos/'.$nomeArquivo;
	    			if($obj->move('boletos',$nomeArquivo))
	    			{
					$vencimento			= explode("/",$vencimento);
	    				$dado['data_vencimento'] 	= $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];
	    			
	    				$dado['valor'] 				= $valor;
	    			
	    				$dado['id'] 				= $idImovel;
	    			
	    				$dado['boleto'] 			= $caminhoArquivo;
	    			
	    				$create	= ParcelasAluguel::create($dado);
	    			}
	    			
	    		}
	    		catch(\Exception $e)
	    		{
	    			return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
	    		}
	    		$a++;
    		}catch(\Exception $e)
    		{
    			
    		}
    	}
    	
    	return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'redirect'=>'/admin/aluguel/show/'.$idImovel]);
    }
    
    public function show($id = 0,$json = false)
    {
    	//$resultSet		= Cliente::find((int)$id);
    	$resultSet			= Cliente::select("*")
    	->leftJoin('imoveis', 'clientes.id', '=', 'imoveis.inquilino')
    	->where('imoveis.id','=',$id)
    	->get();
    	$resultSet 		= $resultSet[0];
    	$alugueis		= new ParcelasAluguel();
    	$parcelas		= $alugueis->parcelasAluguel($resultSet->id);
    	
    	return view('contents.indexAdminAluguelCadastroContent',['search'=>$resultSet,'parcelas'=>$parcelas['search']]);
    }
    
    public function alteraAluguel(Request $request)
    {
    	$check	= $request->parcela;
    	$dados	= $request->all();
    	unset($dados['marcaTodos']);
    	unset($dados['id']);
    	unset($dados['id_cliente']);
    	unset($dados['parcela']);
    	if(count($check) > 0)
    	{
    		$a = 0;
    		foreach($check as $value)
    		{
    			$dadosPago['pago']	= $dados['pago'][$a];
    			$a++;
    			try
    			{
    				$dado	= ParcelasAluguel::select('boleto')->where('id_lancamento',$value)->get();
    				$update = ParcelasAluguel::where('id_lancamento',$value)->update($dadosPago);
    				if($update != 1)
    				{
    					return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,]);
    				}
    			}
    			catch(\Exception $e)
    			{
    				return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    			}
    			if($dadosPago['pago'] == 't')
    			{
    				@unlink($dado[0]->boleto);
    			}
    		}
    		return response()->json(['msg'=>'<strong>Operação concluída.</strong>','statusOperation'=>true,]);
    	}
    	return response()->json(['msg'=>'<strong>Você deve selecionar ao menos um aluguel para realizar a atualzação.</strong>','statusOperation'=>true,]);
    }
    public function cancelar( Request $request )
    {
    	$id	= (int)$request->id;
    	$resultSet	= Cliente::find((int)$request->id);
    	if(count($resultSet) == 0)
    	{
    		return response()->json(['nome'=>"",'data_nascimento'=>"",'rg'=>"",'cpf'=>"",'cnpj'=>"",'logradouro'=>"",'cep'=>"",'numero'=>"",'bairro'=>"",'localidade'=>"",'telefone1'=>"",'telefone2'=>"",'uf'=>"",'id'=>""]);
    	}
    	if($id == 0)
    	{
    		return response()->json(['nome'=>"",'data_nascimento'=>"",'rg'=>"",'cpf'=>"",'cnpj'=>"",'logradouro'=>"",'cep'=>"",'numero'=>"",'bairro'=>"",'localidade'=>"",'telefone1'=>"",'telefone2'=>"",'uf'=>"",'id'=>""]);
    	}
    	$resultSet					= Cliente::find($id);
    	$dataNascimento				= explode("-",$resultSet->data_nascimento);
    	$dataNascimento				= $dataNascimento[2]."/".$dataNascimento[1]."/".$dataNascimento[0];
    	$resultSet->data_nascimento	= $dataNascimento;
    	return response()->json($resultSet);
    }
    
    public function delete( Request $request )
    {
    	$check		= $request->parcela;
    	$dados		= $request->all();
    	$idCliente	= $dados['id_cliente'];
    	
    	unset($dados['marcaTodos']);
    	unset($dados['id']);
    	unset($dados['id_cliente']);
    	unset($dados['parcela']);
    	if(count($check) > 0)
    	{
    		$a = 0;
    		foreach($check as $value)
    		{
    			$dadosPago['pago']	= $dados['pago'][$a];
    			$a++;
    			try
    			{
    				$dado	= ParcelasAluguel::select('boleto')->where('id_lancamento',$value)->get();
    				
    				$update = ParcelasAluguel::where('id_lancamento',$value)->delete();
    				
    				if($update != 1)
    				{
    					return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,]);
    				}
    			}
    			catch(\Exception $e)
    			{
    				return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    			}
    			
    			@unlink($dado[0]->boleto);
    			
    		}
    		return response()->json(['msg'=>'<strong>Operação concluída.</strong>','statusOperation'=>true,'redirect'=>'/admin/aluguel/show/'.$dados['id_imovel']]);
    	}
    	return response()->json(['msg'=>'<strong>Você deve selecionar ao menos um aluguel para realizar a atualzação.</strong>','statusOperation'=>true,]);
    }
}
