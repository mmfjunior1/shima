<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\UserSystem;
use Validator;
use Hash;
class UsuarioSistemaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function listaUsuarioDb($request)
    {
    	$array				= array();
    	$dado				= $request->dado;
    	if(count($array) > 0)
    	{
    		$usuarios 		= UserSystem::select('*')
    		->orWhere(function ($usuarios) use ($array){
    			foreach($array as $field=>$value)
    			{
    				$usuarios->orWhere($field,'ilike','%'.$value.'%');
    			}
    		})->paginate(10)->appends(['dado'=>$dado]);
    	}
    	else
    	{
    		$usuarios 		= UserSystem::select('*')->paginate(10);
    	}
    	
    	return ['search'=>$usuarios,'dado'=>$dado];
    }
    
    public function index( Request $request )
    {
    	$array							= array();
    	$dado							= $request->dado;
    	$clienteLista					= $this->listaUsuarioDb($request);
    	return view('contents.indexAdminUsuarioListaContent',['search'=>$clienteLista['search'],'dado'=>$clienteLista['dado'],]);
    }
    
    
    public function create()
    {
    	return view('contents.indexAdminUsuarioCadastroContent');
    }
    
    public function sigin()
    {
    	return view('master.layoutLogin');
    }
    public function store(Request $request)
    {
    	$dados		= $request->all();
    	unset($dados['painelCliente']);
    	$nome		= $dados['nome'];
    	$messages	= array(
    					'nome.required'				=>'O campo Nome deve ser informado',
    					'nome.min'					=>'O campo Nome deve ter no mínimo :min caracteres',
    					'nome.max'					=>'O campo Nome deve ter no máximo :max caracteres',
    					'login.required'			=>'O campo Login deve ser informado',
    					'login.min'					=>'O campo Login deve conter no mínimo :min caracteres',
    					'login.max'					=>'O campo Login deve conter no máximo :max caracteres',
    	);
    	$camposValidacao = array(
    						'nome'					=>'required|min:5|max:80',
    						'login'					=>'required|min:5|max:20',
    	);
    	
   
    	$validator	= Validator::make($dados,$camposValidacao,$messages);
    	unset($dados['_token']);
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	$resultSet	= UserSystem::find((int)$request->id);
    	if(count($resultSet) == 0)
    	{
	    	try 
	    	{
	    		if($request->senha != $request->confSenha)
	    		{
	    			return response()->json(['msg'=>'<strong>Os campos Senha e Confirma senha devem conter o mesmo valor.</strong>','statusOperation'=>false,]);
	    		}
	    		if($request->senha == "")
	    		{
	    			return response()->json(['msg'=>'<strong>Uma senha deve ser informada.</strong>','statusOperation'=>false,]);
	    		}
	    		$dados['password']			= Hash::make($request->senha);
	    		$create	= UserSystem::create($dados);
	    		return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>$create->id]);
	    		
	    	}
	    	catch(\Exception $e)
	    	{
	    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
	    	}
	    	return;
    	}
    	try
    	{
    		if(isset($dados['senha']))
    		{
	    		$senha		= $dados['senha'];
	    		$confSenha	= $dados['confSenha'];
	    		
	    		unset($dados['senha']);
	    		unset($dados['confSenha']);
	    		$mudaSenha	= false;
	    		if($senha != "" || $confSenha != "")
	    		{
	    			if($senha != $confSenha)
	    			{
	    				return response()->json(['msg'=>'<strong>Falha ao modificar a senha. Os campos "Senha e Confirma senha" devem conter o mesmo valor.</strong>','statusOperation'=>false,'id'=>$request->id]);
	    			}
	    			$dados['password']		= Hash::make($senha);
	    			$mudaSenha				= true;
	    		}
    		}
    		$update = UserSystem::where('id',$request->id)->update($dados);
    		
    		if($update == 1)
    		{
    			return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>$request->id]);
    		}
    		return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,'id'=>$request->id]);
    	}
    	catch(\Exception $e)
    	{
    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    	}
    }
    
    public function show($id = 0,$json = false)
    {
    	$resultSet					= UserSystem::find((int)$id);
    	if($json )
    	{
    		return response()->json($resultSet);
    	}
    	
    	return view('contents.indexAdminUsuarioCadastroContent',['search'=>$resultSet]);
    }
    
    public function cancelar( Request $request )
    {
    	$id	= (int)$request->id;
    	$resultSet	= UserSystem::find((int)$request->id);
    	if(count($resultSet) == 0)
    	{
    		return response()->json(['nome'=>"",'login'=>"",'id'=>""]);
    	}
    	if($id == 0)
    	{
    		return response()->json(['nome'=>"",'login'=>"",'id'=>""]);
    	}
    	$resultSet					= UserSystem::find($id);
    	$resultSet->data_nascimento	= '';
    	return response()->json($resultSet);
    }
    
    public function delete( Request $request )
    {
    	$resultSet	= UserSystem::find((int)$request->id);
    	if(count($resultSet) > 0)
    	{
    		try
    		{	
    			$delete	= $resultSet->delete();
    			return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>0]);
    		}
    		catch(\Exception $e)
    		{
    			return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
    		}
    	}
    	return response()->json(['msg'=>'<strong>Nenhum registro foi localizado.</strong>','statusOperation'=>false,'id'=>0]);
    }
}
