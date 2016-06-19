<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Mensagem;
use Validator;

class MensagemController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index( Request $request )
    {
    	$dado				= $request->dado;
    	$mensagem	 		= new Mensagem();
    	$results			= $mensagem->mensagens($request);
    	
    	return view('contents.indexAdminMensagensListaContent',$results);
    }
    
    public function create()
    {
    	return view('contents.indexAdminClientesCadastroContent');
    }
    
    /*public function store(Request $request)
    {
    	$arrayTypes		= array('pdf');
    	
    	$arrayBoletos	= $request->file('sendFile');
    	
    	$idCliente		= (int)$request->id_cliente; 
    	
    	if($idCliente == 0)
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
    			$nomeArquivo							= "ImoBiliariaShima-".time().$idCliente."-".$a.".pdf";
    			 
    			$caminhoArquivo							= 'boletos/'.$nomeArquivo;
    			if($obj->move('boletos',$nomeArquivo))
    			{
    				$dado['data_vencimento'] 	= $vencimento;
    			
    				$dado['valor'] 				= $valor;
    			
    				$dado['id'] 				= $idCliente;
    			
    				$dado['boleto'] 			= $caminhoArquivo;
    			
    				$create	= ParcelasAluguel::create($dado);
    			}
    			
    		}
    		catch(\Exception $e)
    		{
    			return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
    		}
    		$a++;
    	}
    	
    	return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'redirect'=>'/admin/aluguel/show/'.$idCliente]);
    }*/
    
    public function show($id = 0,$json = false)
    {
    	$resultSet			= Mensagem::find((int)$id);
    	$resultSet->lido	= 't';
    	$resultSet->save();
    	return view('contents.indexAdminMensagemContent',['search'=>$resultSet,]);
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
    	$idMensagem	= $request->id_mensagem;
    	try
    	{
    		$update = Mensagem::where('id_mensagem',$idMensagem)->delete();
    		if($update != 1)
    		{
    			return response()->json(['msg'=>'<strong>Erro ao excluir mensagem.</strong>','statusOperation'=>false,]);
    		}
    	}
    	catch(\Exception $e)
    	{
    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    	}
    	
    	return response()->json(['msg'=>'<strong>Operação concluída.</strong>','statusOperation'=>true,'redirect'=>'/admin/mensagem']);
    }
    
    function enviar( Request $request)
    {
    	$messages	= array(
    			'email.required'				=>'O <strong> email para resposta </strong> não consta da mensagem.',
    			'email.email'					=>'O  <strong>email</strong> informado na resposta não é válido.',
    			'mensagem.required'				=>'Para enviar a mensagem você precisa redigir uma resposta no campo <strong>Resposta</strong>.'
    	);
    	
    	$camposValidacao = array(
    			'email'					=>'required|email|max:80',
    			'mensagem'				=>'required|max:500',
    			 
    	);
    	$validator	= Validator::make($request->all(),$camposValidacao,$messages);
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	$email		= new MailController();
    	$retorno	= $email->sendEmail("Re:Contato realizado pelo site", $request->mensagem,array(),$request->email,$request->nome);
    	$decode		= json_decode($retorno->getContent());
    	if($decode->statusOperation == true)
    	{
    		return response()->json(['msg'=>'<strong>Email enviado.</strong>','statusOperation'=>true,'redirect'=>'/admin/mensagem']);
    	}
    	return response()->json(['msg'=>'<strong>Falha ao enviar a mensagem. Tente novamente</strong>','statusOperation'=>false]);
    }
}
