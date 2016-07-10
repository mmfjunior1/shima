<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Search;
use App\Cliente;
use App\TipoImovel;
use App\Mensagem;
use App\Http\Controllers\CEPController;
use App\Http\Controllers\ClienteController;
use Validator;

class SearchController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function home(Request $request)
    {
    	return view('contents.indexContent');
    }
    public function index(Request $request)
    {
    	$dadosImovel	= new Search();
    	
    	$results		= $dadosImovel->pegaDadosImoveis($request);
    	
    	if($results['count'] == 0)
    	{
    		return view('contents.nenhumResultado',$results);
    	}
    	
    	return view('contents.searchContent',$results);
    }
    
    public function viewImovel($id = 0)
    {
    	$dadosImovel	= new Search();
    	
    	$dados 			= $dadosImovel->viewRegistroImovel($id);
    	
    	if(count($dados['search']) == 0)
    	{
    		return redirect('/');
    	}
    	
    	return view('contents.detalheAnuncio',$dadosImovel->viewRegistroImovel($id));
    }
    function busca(Request $request)
    {
    	return $this->index($request);
    }
    public function adminImoveisIndex(Request $request)
    {
    	$dadosImovel	= new Search();
    	
    	return view('contents.indexAdminImoveisListaContent',$dadosImovel->pegaDadosImoveis($request,10,true));
    }
    
    function show($id)
    {
    	$dados			= Search::select('clientes.id as id_cliente','imoveis.id as id_imovel','clientes.nome','clientes.cpf', 'imoveis.*')
    	
    	->leftJoin('clientes','imoveis.id_cliente','=', 'clientes.id')
    	
    	->where('imoveis.id','=',$id)->get();
    	
    	$dadosInquilino	;
    	
    	$tiposImovel				= TipoImovel::all();
    	
    	$dadosInquilino				= Cliente::find($dados[0]->inquilino);
    	
    	$dados[0]['id_inquilino']		= @$dadosInquilino->id;
    	
    	$dados[0]['cpf_inquilino']		= @$dadosInquilino->cpf;
    	
    	$dados[0]['nome_inquilino']		= @$dadosInquilino->nome;
    	
    	return view('contents.indexAdminImoveisCadastroContent',['tiposImovel'=>$tiposImovel,'search'=>$dados[0]]);
    }
    
	public function create()
    {
		$tiposImovel	= TipoImovel::all();
		
		return view('contents.indexAdminImoveisCadastroContent',['tiposImovel'=>$tiposImovel]);
    }
    
    function getClienteImovel( Request $request)
    {
    	$clienteController	= new ClienteController();
    	
    	$cep				= new CEPController();
    	
    	$dadosCliente		= $clienteController->getClientCpf($request->cpf);
    	
    	return $clienteController->getClientCpf($request->cpf);
    }
    function getEnderecoMaps( Request $request)
    {
    	$cep	= new CEPController();
    	return $cep->getDadosEnderecoGoogleMaps($request->endereco);
    }
    
    public function storeFotos(Request $request)
    {
    	$dadosImovel	= new Search();
    	$resultSet		= $dadosImovel::find((int)$request->id_imovel);
    	
    	$arrayImagens	= $request->file('sendFile');
    	$countImagens	= count($arrayImagens); 
    	if($countImagens == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhuma arquivo foi enviado. Selecione ao menos um arquivo.</strong>','statusOperation'=>false,]);
    	}
    	if($countImagens > 6)
    	{
    		return response()->json(['msg'=>'<strong>Atenção: Apenas 5 imagens são permitidas.</strong>','statusOperation'=>false,]);
    	}
    	$erroTipoImagem		= 0;
    	$qtdArquivosValidos	= 0;
    	$arquivosFalhos		= '<strong>Arquivos não enviados</strong><div style="color:red;font-weight:bold">';
    	$arquivosValidos 	= '';
    	$arrayFotos			= array();
    	$arrayTypes			= array('png','jpg','jpeg');
    	if(count($resultSet) == 0)
    	{
    		return response()->json(['msg'=>'<strong>Nenhum imóvel foi localizado. Tem certeza que o imóvel foi cadastrado primeiro?</strong>','statusOperation'=>false,]);
    	}
    	
    	for($a = 1; $a < 7; $a++)
    	{
    		$fieldFoto	= 'foto'.$a;
	    	if($resultSet->$fieldFoto && is_file($resultSet->$fieldFoto))
	    	{
	    		unlink($resultSet->$fieldFoto);
	    	}
    	}
	foreach($arrayImagens as $obj)
    	{
    		$ext	= $obj->guessExtension();
    		if(!in_array($ext, $arrayTypes))
    		{
    			$erroTipoImagem++;
    			$arquivosFalhos.=$obj->getClientOriginalName()."<br>";
    		}
    		else
    		{
    			$qtdArquivosValidos++;
    			$nomeArquivo							= md5($obj->getClientOriginalName().time());
    			$caminhoArquivo							= 'fotosImoveis/'.$nomeArquivo.'.'.$ext;
    			$nomeCampo								= 'foto'.$qtdArquivosValidos;
    			$arrayFotos['foto'.$qtdArquivosValidos] = $caminhoArquivo;
    			$resultSet->$nomeCampo = $caminhoArquivo;
    			try
    			{
    				$resultSet->save();
    				
    				$obj->move('fotosImoveis',$nomeArquivo.'.'.$ext);
    				//resize
    				$tamanhoImagem			= getimagesize($caminhoArquivo);
    				list($width, $height) 	= getimagesize($caminhoArquivo);
    				if($width > 625)
    				{
	    				$percent	=  bcdiv(bcsub(100 ,(bcdiv( bcmul(625, 100,2),$width,2)),2),100,2);
	    				$newwidth 	=  $width - ($width * $percent);
	    				$newheight 	=  $height - ($height * $percent);
	    				// Load
	    				$thumb 		= imagecreatetruecolor($newwidth, $newheight);
	    				if($ext == 'png')
	    				{
	    					$source		= imagecreatefrompng($caminhoArquivo);
	    					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	    					imagepng($thumb,$caminhoArquivo);
	    				}
	    				if($ext == 'jpg' || $ext =='jpeg')
	    				{
	    					$source 	= imagecreatefromjpeg($caminhoArquivo);
	    					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	    					imagejpeg($thumb,$caminhoArquivo);
	    				}
    				}
    				
    			}
    			catch(\Exception $e)
    			{
    				return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>0]);
    			}
    		}
    	}
    	if($erroTipoImagem == $countImagens)
    	{
    		return response()->json(['msg'=>'<strong>Atenção: Nenhuma imagem foi enviada. Certifique-se que as extensões dos arquivos são PNG ou JPG.</strong><br>'.$arquivosFalhos,'statusOperation'=>false,]);
    	}
    	return response()->json(['msg'=>'<strong>Operação concluída.</strong><br>Arquivos enviados:'.$qtdArquivosValidos.'<br>'.$arquivosFalhos,'statusOperation'=>true,"fotos"=>$arrayFotos]);
    	
    }
    public function store(Request $request)
    {
    	$messages	= array(
    			'id_cliente.required'		=>'O <strong> proprietário </strong> deve ser informado',
    			'cep.required'				=>'O Campo <strong>cep </strong> deve ser informado',
    			'cep.min'					=>'O Campo <strong>cep </strong> deve conter no mínimo :min caracteres',
    			'cep.max'					=>'O Campo <strong>cep </strong> deve conter no máximo :max caracteres',
    			'logradouro.required'		=>'O Campo <strong>logradouro </strong> deve ser informado',
    			'logradouro.min'			=>'O Campo <strong>logradouro </strong> deve conter no mínimo :min caracteres',
    			'logradouro.max'			=>'O Campo <strong>logradouro </strong> deve conter no máximo :max caracteres',
    			'numero.required'			=>'O Campo <strong>número </strong> deve ser informado',
    			'numero.min'				=>'O Campo <strong>número </strong> deve conter no mínimo :min caracteres',
    			'numero.max'				=>'O Campo <strong>número </strong> deve conter no máximo :max caracteres',
    			'bairro.required'			=>'O Campo <strong>bairro </strong> deve ser informado',
    			'bairro.min'				=>'O Campo <strong>bairro </strong> deve conter no mínimo :min caracteres',
    			'bairro.max'				=>'O Campo <strong>bairro </strong> deve conter no máximo :max caracteres',
    			'localidade.required'		=>'O Campo <strong>localidade </strong> deve ser informado',
    			'localidade.min'			=>'O Campo <strong>localidade </strong> deve conter no mínimo :min caracteres',
    			'localidade.max'			=>'O Campo <strong>localidade </strong> deve conter no máximo :max caracteres',
    			'uf.required'				=>'O Campo <strong>estado </strong> deve ser informado',
    			'uf.min'					=>'O Campo <strong>estado </strong> deve conter no mínimo :min caracteres',
    			'uf.max'					=>'O Campo <strong>estado </strong>deve conter no máximo :max caracteres',
    			'area.required'				=>'O Campo <strong>area </strong> deve ser informado',
    			'area.numeric'				=>'O Campo <strong>area </strong> deve ser informado apenas com números',
    			'area.max'					=>'O Campo <strong>area </strong> deve conter no máximo :max caracteres',
    			'quartos.integer'			=>'O Campo <strong>quartos </strong> deve ser informado apenas com números',
    			'quartos.min'				=>'O Campo <strong>quartos </strong> deve conter no mínimo :min caracteres',
    			'quartos.required'			=>'O Campo <strong>quartos </strong> deve ser informado',
    			'suites.required'			=>'O Campo <strong>suites deve </strong> deve ser informado',
    			'suites.integer'			=>'O Campo <strong>quartos </strong> deve ser informado apenas com números',
    			'suites.max'				=>'O Campo <strong>suites deve conter </strong> no máximo :max caracteres',
    			'vagas.required'			=>'O Campo <strong>vagas </strong> deve ser informado',
    			'vagas.integer'				=>'O Campo <strong>vagas </strong> deve ser informado apenas com números',
    			'banheiros.required'		=>'O Campo <strong>banheiros</strong> deve ser informado',
    			'banheiros.integer'			=>'O Campo <strong>banheiros</strong> deve ser informado apenas com números',
    	);
    	
    	$camposValidacao = array(
    			'id_cliente'			=>'required',
    			'logradouro'			=>'required|min:3|max:80',
    			'numero'				=>'required|min:1|max:10',
    			'bairro'				=>'required|min:3|max:80',
    			'localidade'			=>'required|min:3|max:50',
    			'uf'					=>'required|min:2|max:2',
    			'cep'					=>'required|min:9|max:10',
    			'area'					=>'required|min:1|numeric',
    	);
    	
    	$validator	= Validator::make($request->all(),$camposValidacao,$messages);
    	
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	
    	$endereco		= $request->logradouro.", ".$request->numero." ".$request->bairro.", ".$request->localidade."-".$request->uf;
    	
    	$maps			= new CEPController();
    	
    	$dadosEndereco	= $maps->getDadosEnderecoGoogleMaps($endereco);
    	
    	$dadosEndereco	= json_decode($dadosEndereco,true);
    	
    	$dadosImovel					= new Search();
    	
    	$resultSet						= $dadosImovel::find((int)$request->id);
    	
    	$dados							= $request->all();
    	if(!strstr($dados['codigo_imobiliaria'], "-"))
    	{
    		return response()->json(['msg'=>'<strong>O formato do código do imóvel está incorreto. Acrescente o hífen no código para continuar com a operação.</strong>','statusOperation'=>false,'id'=>0]);
    	}
    	if($dados['cpf'] == $dados['cpf_inquilino'] &&( $dados['cpf'] != "" && $dados['cpf_inquilino'] !=""))
    	{
    		return response()->json(['msg'=>'<strong>O CPF do proprietário não pode ser igual ao cpf do inquilino!</strong>','statusOperation'=>false,'id'=>0]);
    	}	 
    	$explodeCodOrdenacao			= explode("-",$dados['codigo_imobiliaria']);
    	$dados['codigo_ordenacao']		= $explodeCodOrdenacao[0];	
    	$dados['quartos']				= (int)$dados['quartos'];
    	$dados['suites']				= (int)$dados['suites'];
    	$dados['vagas']					= (int)$dados['vagas'];
    	$dados['banheiros']				= (int)$dados['banheiros'];
    	$dados['id_cliente']			= (int)$dados['id_cliente'];
    	$dados['inquilino']				= (int)$dados['id_cliente_inquilino'];
    	$dados['latitude']	= $dadosEndereco['results'][0]['geometry']['location']['lat'];
    	$dados['longitude']	= $dadosEndereco['results'][0]['geometry']['location']['lng'];
    	unset($dados['cpf']);
    	unset($dados['nome']);
    	unset($dados['id']);
    	unset($dados['_token']);
    	unset($dados['id_cliente_inquilino']);
    	unset($dados['cpf_inquilino']);
    	unset($dados['nome_inquilino']);
    	if(count($resultSet) == 0)
    	{
    		try
    		{
    			$create	= $dadosImovel::create($dados);
    			
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
    		$update = $dadosImovel::where('id',$request->id)->update($dados);
    		if($update == 1)
    		{
    			return response()->json(['msg'=>'<strong>Operação concluída</strong>','statusOperation'=>true,'id'=>$request->id]);
    		}
    		return response()->json(['msg'=>'<strong>Nenhum registro foi atualizado. Tente novamente.</strong>','statusOperation'=>false,]);
    	}
    	catch(\Exception $e)
    	{
    		return response()->json(['msg'=>'<strong>Erro ao executar operação!</strong><br><div style="color:red;font-weight:bold">['.$e->getMessage().']','statusOperation'=>false,'id'=>$request->id]);
    	}
    }
    public function cancelar( Request $request )
    {
    	$id	= (int)$request->id;
    
    	$resultSet	= Search::find((int)$request->id);
    	if(count($resultSet) == 0)
    	{
    		return response()->json(['id_cliente','tipo','valor_imovel','operacao','area','quartos','suites','banheiros','vagas','cep','logradouro','numero','bairro','localidade','uf','latitude','longitude']);
    	}
    	if($id == 0)
    	{
    		return response()->json(['id_cliente','tipo','valor_imovel','operacao','area','quartos','suites','banheiros','vagas','cep','logradouro','numero','bairro','localidade','uf','latitude','longitude']);
    	}
    	
    	$resultSet	= Search::select('clientes.id as id_cliente','clientes.nome','clientes.cpf','imoveis.*')->leftJoin('clientes','imoveis.id_cliente','=', 'clientes.id')->where('imoveis.id','=',$id)->get();
    	
    	return response()->json($resultSet[0]);
    }
    
    public function delete( Request $request )
    {
    	$resultSet	= Search::find((int)$request->id);
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
    
    public function emailImovel( Request $request)
    {
    	$messages	= array(
    			'id_cliente.required'		=>'O <strong> Cliente </strong> deve ser informado',
    			'nome.required'				=>'O campo <strong>nome</strong> é obrigatório.',
    			'nome.min'					=>'O campo <strong>nome</strong> deve conter no mínimo :min caracteres.',
    			'texto.min'					=>'O campo <strong>para texto da mensagem</strong> deve conter no mínimo :min caracteres.',
    			'texto.max'					=>'O campo <strong>para texto da mensagem</strong> deve conter no máximo :max caracteres.',
    			'emailcontato.email'		=>'O <strong>email</strong> informado não é válido.',
    			'emailcontato.required'		=>'O <strong>email</strong> é obrigatório.',
    			'emailcontato.max'			=>'O campo <strong>email</strong> deve conter no máximo :max caracteres.',
    	);
    	 
    	$camposValidacao = array(
    			'nome'					=>'required|min:3|max:30',
    			'emailcontato'			=>'required|email|max:80',
    			'texto'					=>'required|min:10|max:500',
    			
    	);
    	$validator	= Validator::make($request->all(),$camposValidacao,$messages);
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	$email						= $request->emailcontato;
    	$nome						= $request->nome;
    	$telefone					= $request->telefone;
    	$texto						= strip_tags($request->texto);
    	$titulo						= $request->titulo;
    	$url						= $request->url;
    	$dados						= array();
    	$dados['id']				= 0;
    	$dados['mensagem']			= $texto;
    	$dados['email']				= $email;
    	$dados['titulo']			= $titulo;
    	$dados['nome']				= $nome;
    	
    	$texto		= "<table>
    					<tr>
    					<td>Nome:</td>
    					<td>$nome</td>
    					</tr>
    					<tr>
    					<td>Email:</td>
    					<td>$email</td>
    					</tr>
    					<tr>
    					<td>Telefone:</td>
    					<td>$telefone</td>
    					</tr>
    					<tr>
    					<td>Texto enviado:</td>
    					<td>$titulo <br>$texto</td>
    					</tr>
    					<tr>
    					<td>URL do anúncio:</td>
    					<td>$url</td>
    					</tr>
    					</table>";
    	$email		= new MailController();
    	$retorno	= $email->sendEmail($titulo, $texto);
    	$decode		= json_decode($retorno->getContent());
    	
    	if($decode->statusOperation == true)
    	{
    		$create	= Mensagem::create($dados);
    		return response()->json(['msg'=>'<strong>Email enviado.</strong>','statusOperation'=>true]);
    	}
    	return $retorno;
    }
    
    public function emailContato( Request $request)
    {
    	$messages	= array(
    			'contact_name1.required'	=>'O campo <strong>nome</strong> é obrigatório.',
    			'contact_name1.min'			=>'O campo <strong>nome</strong> deve conter no mínimo :min caracteres.',
    			'contact_name1.max'			=>'O campo <strong>nome</strong> deve conter no máximo :max caracteres.',
    			'telefone.required'			=>'O campo <strong>telefone</strong> é obrigatório.',
    			'telefone.min'				=>'O campo <strong>telefone</strong> deve conter no mínimo :min caracteres.',
    			'telefone.max'				=>'O campo <strong>telefone</strong> deve conter no máximo :max caracteres.',
    			'contact_message1.min'		=>'O campo <strong>para texto da mensagem</strong> deve conter no mínimo :min caracteres.',
    			'contact_message1.max'		=>'O campo <strong>para texto da mensagem</strong> deve conter no máximo :max caracteres.',
    			'emailcontato.email'		=>'O <strong>email</strong> informado não é válido.',
    			'emailcontato.required'		=>'O <strong>email</strong> é obrigatório.',
    			'emailcontato.max'			=>'O campo <strong>email</strong> deve conter no máximo :max caracteres.',
    	);
    
    	$camposValidacao = array(
    			'contact_name1'					=>'required|min:3|max:30',
    			'telefone'						=>'required|min:8|max:16',
    			'contact_message1'				=>'required|min:5|max:500',
    			 
    	);
    	$validator	= Validator::make($request->all(),$camposValidacao,$messages);
    	if($validator->fails())
    	{
    		return $validator->errors();
    	}
    	$email						= $request->contact_email1;
    	$nome						= $request->contact_name1;
    	$telefone					= $request->telefone;
    	$texto						= strip_tags($request->contact_message1);
    	$titulo						= "Contato direto do site";
    	$url						= "";
    	$dados						= array();
    	$dados['id']				= 0;
    	$dados['mensagem']			= $texto;
    	$dados['email']				= $email;
    	$dados['titulo']			= $titulo;
    	$dados['nome']				= $nome;
    	 
    	$texto		= "<table>
    	<tr>
    	<td>Nome:</td>
    	<td>$nome</td>
    	</tr>
    	<tr>
    	<td>Email:</td>
    	<td>$email</td>
    	</tr>
    	<tr>
    	<td>Telefone:</td>
    	<td>$telefone</td>
    	</tr>
    	<tr>
    	<td>Texto enviado:</td>
    	<td>$titulo <br>$texto</td>
    	</tr>
    	
    	</table>";
    	$email		= new MailController();
    	$retorno	= $email->sendEmail($titulo, $texto);
    	$decode		= json_decode($retorno->getContent());
    	 
    	if($decode->statusOperation == true)
    	{
    		$create	= Mensagem::create($dados);
    		return response()->json(['msg'=>'<strong>Email enviado.</strong>','statusOperation'=>true]);
    	}
    	return $retorno;
    }
}
