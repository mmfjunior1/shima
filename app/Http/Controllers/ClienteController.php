<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Cliente;
use App\Search;
use App\Documento;
use App\Http\Controllers\CEPController;
use Validator;
use Hash;
class ClienteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $actionForm	= '/admin/clientes/search';
    public $actionForm1	= '/admin/proprietarios/search';
    public $urlEdit		= '/admin/clientes/show/';
    public $titulo		= 'Clientes';
    public $urlStore	= '/admin/clientes/cadastro';
    public $btnIncluir	= '';
    public function listaClientesDb($request)
    {
    	$array				= array();
    	
    	$tipoCliente		= $this->tipoCliente($request->url());
    	
    	$tipo				= $tipoCliente['tipo'];
    	
    	$dado				= $request->dado;
    	
    	if($dado)
    	{
    		$cpf	= $dado;
    		$cep	= $dado;
    		if(strlen($cpf) >=11)
    		{
    			$cpf	= str_replace(['.','-',' '], '', $cpf);
    			$cpf	= substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
    		}
    		$array['cpf']					= $cpf;
    		$array['nome']		 			= $dado;
    	}
    	if(count($array) > 0)
    	{
    		$clientes 		= Cliente::select(['clientes.id','clientes.nome','clientes.cpf','clientes.created_at'])
    		->orWhere(function ($clientes) use ($array){
    			foreach($array as $field=>$value)
    			{
    				$clientes->orWhere($field,'ilike','%'.$value.'%');
    			}
    		})->where('tipo','=',$tipo)->paginate(10)->appends(['dado'=>$dado]);
    	}
    	else
    	{
    		$clientes 		= Cliente::select(['clientes.id','clientes.nome','clientes.cpf','clientes.created_at'])->where('tipo','=',$tipo)->paginate(10);
    	}
    	return ['search'=>$clientes,'dado'=>$dado,'tipo'=>$tipoCliente];
    }
    
    public function index( Request $request )
    {
    	$array							= array();
    	
    	$dado							= $request->dado;
    	
    	$clienteLista					= $this->listaClientesDb($request);
    	
    	$viewDefinition					= array();
    	
    	$viewDefinition['titulo']		= /*$this->titulo;*/$clienteLista['tipo']['descricao2'];
    	
    	$viewDefinition['actionForm']	= str_replace("/search", "", $request->url()).'/search';
    	
    	$viewDefinition['urlEdit']		= str_replace("/search", "", $request->url()).'/show/';
    	
    	$viewDefinition['urlStore']		= str_replace("/search","",$request->url()).'/cadastro';
    	
    	$viewDefinition['btnIncluir']	= '<a href="'.$viewDefinition['urlStore'].'" class="btn btn-primary">Incluir</a>';
    	if($request->ajax())
    	{
    		$pages	= $clienteLista['search']->links();
    		
    		return \Response::json(['search'=>$clienteLista['search'],'dado'=>$clienteLista['dado'],'viewDefinition'=>$viewDefinition,"page"=>"$pages"]);
    	}
    	
    	
    	return view('contents.indexAdminClientesListaContent',['search'=>$clienteLista['search'],'dado'=>$clienteLista['dado'],'viewDefinition'=>$viewDefinition,]);
    }
    
    public function clientesDocs(Request $request)
    {
    	$array				= array();
    	$dado				= $request->dado;
    	$clienteLista		= $this->listaClientesDb($request);
    	$viewDefinition					= array();
    	$viewDefinition['titulo']		= 'Envio de documentos';
    	$viewDefinition['actionForm']	= '/admin/docs';
    	$viewDefinition['urlEdit']		= '/admin/docs/show/';
    	$viewDefinition['urlStore']		= '/admin/docs/cadastro';
    	$viewDefinition['btnIncluir']	= '';
    	return view('contents.indexAdminClientesListaContent',['search'=>$clienteLista['search'],'dado'=>$clienteLista['dado'],'viewDefinition'=>$viewDefinition]);
    }
    
    public function clienteDoc($id)
    {
    
    	$resultSet			= Cliente::select("*")
    	->leftJoin('documentos', 'clientes.id', '=', 'documentos.id_cliente')
    	->where('clientes.id','=',$id)
    	->get();
    	$resultSet 		= $resultSet[0];
    	$documentos		= new Documento();
    	$documentos		= $documentos->select("*")->where('id_cliente','=',$id)->paginate(3);
    	 
    	//return view('contents.indexAdminAluguelCadastroContent',['search'=>$resultSet,'parcelas'=>$parcelas['search']]);
    	
    	return view('contents.indexAdminDocumentosCadastroContent',['search'=>$resultSet,'documentos'=>$documentos]);
    }
    
    public function create(Request $request)
    {
    	$tipoCliente	= $this->tipoCliente($request->url());
    	
    	$urlVoltar		= str_replace("/cadastro","",$request->url());
    	
    	$campoCodProprietario		= "";
    	 
    	$tituloCampo				= "";
    	
    	if($tipoCliente['tipo']== 'p' )
    	{
    		$tituloCampo			= "Código Proprietário";
    		$campoCodProprietario 	= '<input type="text" name="cod_proprietario" id="cod_proprietario" value="" readonly>';
    	}
    	
    	return view('contents.indexAdminClientesCadastroContent',array('tipoCadastro'=>$tipoCliente['tipo'],"imoveis"=>array(), 'descricao'=>$tipoCliente['descricao'],'urlVoltar'=>$urlVoltar,'tituloCampo'=>$tituloCampo,'campoCodProprietario'=>$campoCodProprietario));
    }
    
    function tipoCliente($str)
    {
    	if(strstr($str, 'proprietarios'))
    	{
    		return array('tipo'=>'p','descricao'=>'Proprietario','descricao2'=>'Proprietarios');
    	}
    	
    	if(strstr($str, 'clientes'))
    	{
    		return array('tipo'=>'c','descricao'=>'Inquilino','descricao2'=>'Inquilinos');
    	}
    	return false;
    }
    
    public function store(Request $request)
    {
    	$dados		= $request->all();
    	$nome		= $dados['nome'];
    	$messages	= array(
    					'nome.required'				=>'O campo Nome deve ser informado',
    					'nome.min'					=>'O campo Nome deve ter no mínimo :min caracteres',
    					'nome.max'					=>'O campo Nome deve ter no máximo :max caracteres',
    					'cpf.required'				=>'O campo CPF deve ser informado',
    					'cpf.min'					=>'O campo CPF deve conter no mínimo :min caracteres',
    					'cpf.max'					=>'O campo CPF deve conter no máximo :max caracteres',
    					'rg.required'				=>'O campo rg deve ser informado',
    					'rg.min'					=>'O campo rg deve conter no mínimo :min caracteres',
    					'rg.max'					=>'O campo rg deve conter no máximo :max caracteres',
    					'email.max'					=>'O campo email deve conter no máximo :max caracteres',
    					'email.email'				=>'O email informado não é válido',
    					'email.required'			=>'O campo email deve ser informado',
		    			'cep.required'				=>'O campo cep deve ser informado',
		    			'cep.min'					=>'O campo cep deve conter no mínimo :min caracteres',
		    			'cep.max'					=>'O campo cep deve conter no máximo :max caracteres',
		    			'logradouro.required'		=>'O campo logradouro deve ser informado',
		    			'logradouro.min'			=>'O campo logradouro deve conter no mínimo :min caracteres',
		    			'logradouro.max'			=>'O campo logradouro deve conter no máximo :max caracteres',
		    			'numero.required'			=>'O campo número deve ser informado',
		    			'numero.min'				=>'O campo número deve conter no mínimo :min caracteres',
		    			'numero.max'				=>'O campo número deve conter no máximo :max caracteres',
		    			'bairro.required'			=>'O campo bairro deve ser informado',
		    			'bairro.min'				=>'O campo bairro deve conter no mínimo :min caracteres',
		    			'bairro.max'				=>'O campo bairro deve conter no máximo :max caracteres',
		    			'localidade.required'		=>'O campo localidade deve ser informado',
		    			'localidade.min'			=>'O campo localidade deve conter no mínimo :min caracteres',
		    			'localidade.max'			=>'O campo localidade deve conter no máximo :max caracteres',
		    			'uf.required'				=>'O campo estado deve ser informado',
		    			'uf.min'					=>'O campo estado deve conter no mínimo :min caracteres',
		    			'uf.max'					=>'O campo estado deve conter no máximo :max caracteres',
    					'telefone1.min'				=>'O campo Telefone deve conter no mínimo :min caracteres',
    					'telefone2.max'				=>'O campo Celular deve conter no máximo :max caracteres',
    	);
    	$camposValidacao = array(
    						'nome'					=>'required|min:5|max:80',
    						'cpf'					=>'required|min:11|max:14',
    						'cnpj'					=>'max:18',
    						'rg'					=>'required|min:5|max:15',
    						'email'					=>'required|max:150|email',
    						'logradouro'			=>'required|min:3|max:80',
    						'numero'				=>'required|min:1|max:10',
    						'bairro'				=>'required|min:3|max:80',
    						'localidade'			=>'required|min:3|max:50',
    						'uf'					=>'required|min:2|max:2',
    						'cep'					=>'required|min:9|max:10',
    						'telefone1'				=>'max:20',
    						'telefone2'				=>'max:20',
    	);
    	
    	/*if($dados['tipo'] == 'p')
    	{
    		if((int)$dados['cod_proprietario'] == 0)
    		{
    			return response()->json(['msg'=>'<strong>O código do proprietário deve ser informado.</strong>','statusOperation'=>false,]);
    		}
    	}*/
    	if(isset($request->painelCliente))
    	{
    		$camposValidacao = array(
    				'email'					=>'required|max:150|email',
    				
    		);
    		unset($dados['nome']);
    		unset($dados['cpf']);
    		unset($dados['cnpj']);
    		unset($dados['painelCliente']);
    		unset($dados['rg']);
    	}
   
    	$validator	= Validator::make($dados,$camposValidacao,$messages);
    	unset($dados['_token']);
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	$resultSet	= Cliente::find((int)$request->id);
    	if(count($resultSet) == 0)
    	{
	    	try 
	    	{
	    		//$dados			= $request->all();
	    		$dados['senha_aberta']	= time(); 
	    		$dados['password']		= Hash::make($dados['senha_aberta']);
	    		$email					= new MailController();
	    		
	    		$texto					= "<p>Olá ".$dados['nome'].", você acaba de ser cadastrado na plataforma de imóveis da Imobiliaria Shima.</p><p> Aqui você poderá ter acesso a funcionalidades que só clientes da imobiliária tem. Acesse já o seu painel em ".url('painelCliente').". Utilize seu endereço de email para entrar no sistema. Sua senha provisória é <strong>".$dados['senha_aberta']."</strong></p><p>Qualquer dúvida, entre em contato com a gente.</p><p>Atenciosamente, <br>equipe Imobiliária Shima.</p>";
	    		$retorno				= $email->sendEmail("Imobiliaria Shima - Você acaba de ser cadastrado em nossa plataforma", $texto,array(),$dados['email'],$nome);
	    		$decode					= json_decode($retorno->getContent());
	    		 
	    		if($decode->statusOperation == true)
	    		{
	    			
	    			$create	= Cliente::create($dados);
	    			$dados['cod_proprietario'] = $create->id;
	    			return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>$create->id,"dados"=>$dados]);
	    		}
	    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
	    		
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
    		$update = Cliente::where('id',$request->id)->update($dados);
    		
    		if($update == 1)
    		{
    			if(@$mudaSenha == true)
    			{
    				$email		= new MailController();
    				
    				$texto		= "<p>Olá, ".$nome.". </p><p>Você alterou sua senha de acesso no nosso painel de controle em ".date('d/m/Y').". </p><p>Sua nova senha começa com ".substr($senha,0,2).".</p><p>Caso tenha problemas com o acesso ao seu painel de usuário, entre em contato com a gente.</p><p>Atenciosamente,<br>Equipe Imobiliária Shima.</p>";
    				
    				$email->sendEmail("Alerta de mudança de senha - Imobiliária Shima", $texto,array(),$dados['email'],$nome);
    			}
    			$dados['cod_proprietario'] = $request->id;
    			return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>$request->id,"dados"=>$dados]);
    		}
    		return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,'id'=>$request->id]);
    	}
    	catch(\Exception $e)
    	{
    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    	}
    }
    
    public function show($id = 0,Request $request,$json = false)
    {
    	
    	$imoveis		= new Search();
    	
    	$tipoCliente		= $this->tipoCliente($request->url());
    	
    	if($tipoCliente['tipo'] == 'c')
    	{
    		$dadosCliente	= (object) array("dado"=>$request->dado,"inquilino"=>$id, "id_cliente"=>"","localidade"=>"","logradouro"=>"","bairro"=>"","uf"=>"","operacao"=>"","tipo"=>"","area"=>"","tipo_imovel"=>"","route"=>"","valor"=>"");
    	}
    	
    	if( $tipoCliente['tipo'] != 'c')
    	{
    		$dadosCliente	= (object) array("dado"=>$request->dado,"inquilino"=>"", "id_cliente"=>$id,"localidade"=>"","logradouro"=>"","bairro"=>"","uf"=>"","operacao"=>"","tipo"=>"","area"=>"","tipo_imovel"=>"","route"=>"","valor"=>"");
    	}
    	
    	$listaImoveis	= $imoveis->pegaDadosImoveis($dadosCliente,10,true);
    	
    	if($request->ajax())
    	{
    		$pages	= $listaImoveis['search']->links();
    		
    		return \Response::json(['search'=>$listaImoveis['search'],'dado'=>$listaImoveis['dado'],"page"=>"$pages"]);
    	}
    	$resultSet					= Cliente::find((int)$id);
    	
    	$campoCodProprietario		= "";
    	
    	$tituloCampo				= "";
    	
    	if($json )
    	{
    		return response()->json($resultSet);
    	}
    	
    	
    	if(@$resultSet->data_nascimento)
    	{
	    	$dataNascimento				= explode("-",@$resultSet->data_nascimento);
	    	$dataNascimento				= $dataNascimento[2]."/".$dataNascimento[1]."/".$dataNascimento[0];
	    	$resultSet->data_nascimento	= $dataNascimento;
	    }
	    
	    $urlVoltar						= preg_replace('/(\/show\/\d{0,})/', "", $request->url());
	    
	    if($tipoCliente['tipo']== 'p' )
	    {
	    	$tituloCampo			= "Código Proprietário";
	    	$campoCodProprietario 	= '<input type="text"  id="cod_proprietario" value="'.$resultSet->id.'" readonly>';
	    }
	    
	    
	    
	  	return view('contents.indexAdminClientesCadastroContent',['search'=>$resultSet,"imoveis"=>$listaImoveis['search'], 'tipoCadastro'=>$tipoCliente['tipo'],'descricao'=>$tipoCliente['descricao'],'urlVoltar'=>$urlVoltar,'tituloCampo'=>$tituloCampo,'campoCodProprietario'=>$campoCodProprietario]);
    }
    
    public function getClientCpf($cpf,$id)
    {
    	$cpf1	= "";
    	if(!stristr($cpf, "."))
    	{
    		$cpf1 = substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
    	}
    	if($id > 0)
    	{
    		$resultSet					= Cliente::where(['id'=>$id])->get();
    	}
    	else
    	{
    		$resultSet					= Cliente::where(['cpf'=>$cpf1])->orWhere(['cpf'=>$cpf])->get();
    	}
    	
    	if(count($resultSet) > 0)
    	{
    		$resultSet[0]->id_cliente = $resultSet[0]->id ;
    		unset($resultSet[0]->id);
    		return response()->json($resultSet[0]);
    	}
    	return response()->json(null);
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
    	$resultSet->data_nascimento	= '';
    	return response()->json($resultSet);
    }
    
    public function delete( Request $request )
    {
    	$resultSet	= Cliente::find((int)$request->id);
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
    
    public function buscaCep( Request $request )
    {
    	$cep 	= new CEPController();
    	$cep	= $cep->getCEP($request->cep);
    	$cep	= json_decode($cep);
    	return response()->json($cep);
    }
    /**
     * Exclui documento de um cliente
     * @param Request $request
     */
    public function deleteDoc( Request $request )
    {
    	$check		= $request->documentoLista;
    	$dados		= $request->all();
    	$idCliente	= $dados['id_cliente'];
    	 
    	unset($dados['marcaTodos']);
    	unset($dados['id_cliente']);
    	
    	if(count($check) > 0)
    	{
    		$a = 0;
    		foreach($check as $value)
    		{
    			$chave		= array_keys($check);
    			$arquivo	= $chave[$a];
    			$a++;
    			try
    			{
    				$update = Documento::where('id_documento',$value)->delete();
    				if($update != 1)
    				{
    					return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,]);
    				}
    				@unlink($arquivo);
    			}
    			catch(\Exception $e)
    			{
    				return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    			}
    		}
    		return response()->json(['msg'=>'<strong>Operação concluída.</strong>','statusOperation'=>true,'redirect'=>'/admin/docs/show/'.$idCliente]);
    	}
    	return response()->json(['msg'=>'<strong>Você deve selecionar ao menos um documento para realizar a exclusão.</strong>','statusOperation'=>true,]);
    }
    
    /**
     * Grava documentos para um cliente
     * @param Request $request
     */
    public function storeDocs(Request $request)
    {
    	$arrayTypes		= array('pdf','doc','jpg','jpeg','png','docx');
    	 
    	$arrayBoletos	= $request->file('documento');
    	
    	$idCliente		= (int)$request->id_cliente;
    	 
    	if($idCliente == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhum cliente foi selecionado. Verifique as informações e tente novamente.</strong>','statusOperation'=>false,]);
    	}
    	$countImagens	= count($arrayBoletos);
    	
    	if($countImagens == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhum documento foi enviado. Os documentos devem ser enviados nos seguintes formatos: pdf, doc, jpg, png ou docx.</strong>','statusOperation'=>false,]);
    	}
    	$arquivosFalhos	= "";
    	$a 				= 0 ;
    	foreach($arrayBoletos as $obj)
    	{
    
    		$ext			= $obj->guessExtension();
    		
    		$titulo			= $request->titulo[$a];
    		
    		if(!in_array($ext, $arrayTypes))
    		{
    			return response()->json(['msg'=>'<strong>Nenhum documento foi enviado. Os documentos devem ser enviados nos seguintes formatos: pdf, doc, jpg, png ou docx.</strong>','statusOperation'=>false,]);
    			break;
    		}
    		if($titulo	== "")
    		{
    			return response()->json(['msg'=>'<strong>O título do documento '.($a+1).' deve ser definido. Verifique as informações e tente novamente.</strong>','statusOperation'=>false,]);
    			break;
    		}
    
    		try
    		{
    			$nomeArquivo							= "ImoBiliariaShima-".time().$idCliente."-".$a.".".$ext;
				
    			$caminhoArquivo							= 'documentos/'.$nomeArquivo;
    		
    			if($obj->move('documentos',$nomeArquivo))
    			{
    				$dado['titulo'] 			= $request->titulo[$a];
    				 
    				$dado['arquivo']			= $caminhoArquivo;
    				 
    				$dado['id_cliente'] 		= $request->id_cliente;
    				
    				$create	= Documento::create($dado);
    			}
    			 
    		}
    		catch(\Exception $e)
    		{
    			return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
    		}
    		$a++;
    	}
    	 
    	return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'redirect'=>'/admin/docs/show/'.$idCliente]);
    }
    
}
