<?php


use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SearchController@home');

Route::get('/index', function () {
	return view('contents.indexContent');
});

Route::get('/contato', function () {
		return view('contents.contatoContent');
});

Route::post('/obrigado', function () {
	return view('contents.sucessoContent');
});

Route::get('admin',['middleware'=>'administrator', function () 
{
	return view('contents.indexAdminContent');
}]);

Route::post("logonSistema",							'LoginController@login');

Route::any("falha"		,							'LoginController@falha' );

Route::get('/painelCliente',							['middleware'=>'auth','uses'	=>		'PainelClienteController@index']);

Route::get('/painelCliente/dados',						['middleware'=>'auth','uses'	=>		'PainelClienteController@dadosPessoais']);

Route::get('/painelCliente/alugueis',					['middleware'=>'auth','uses'	=>		'PainelClienteController@financeiro']);

Route::get('/painelCliente/alugueis_a_receber',			['middleware'=>'auth','uses'	=>		'PainelClienteController@financeiroReceber']);

Route::get('/painelCliente/alugueis_a_receber/{id}',	['middleware'=>'auth','uses'	=>		'PainelClienteController@alugueisReceber']);

Route::get('/painelCliente/financeiro',					['middleware'=>'auth','uses'	=>		'PainelClienteController@painelFinanceiro']);

Route::get('/painelCliente/documentos',					['middleware'=>'auth','uses'	=>		'PainelClienteController@documentos']);

Route::get('/painelCliente/financeiro/{id}',			['middleware'=>'auth','uses'	=>		'PainelClienteController@alugueis']);

Route::get('/painelCliente/imovel/{id}',				['middleware'=>'auth','uses'	=>		'PainelClienteController@imovel']);

Route::get('/painelCliente/sair',						['middleware'=>'auth','uses'	=>		'LoginController@logout']);

Route::any('/emailAnuncio',								'SearchController@emailImovel');

Route::any('/emailContato',								'SearchController@emailContato');

Route::get('/imovel/{id}', 								'SearchController@viewImovel');


//Rotas possíveis para cadastro de clientes
Route::get('admin/clientes', 						['middleware'=>'administrator','uses'	=>'ClienteController@index']);

Route::any('admin/proprietarios', 					['middleware'=>'administrator','uses'	=>'ClienteController@index']);

Route::any('admin/clientes/search', 				['middleware'=>'administrator','uses'	=>'ClienteController@index']);

Route::any('admin/proprietarios/search', 			['middleware'=>'administrator','uses'	=>'ClienteController@index']);

Route::get('admin/clientes/cadastro',				['middleware'=>'administrator','uses'	=>'ClienteController@create']);

Route::get('admin/proprietarios/cadastro',			['middleware'=>'administrator','uses'	=>'ClienteController@create']);

Route::post('admin/clientes/gravar', 				['middleware'=>'administrator','uses'	=>'ClienteController@store']);

Route::post('admin/clientesuser/gravar',			['middleware'=>'auth','uses'			=>'ClienteController@store']);

Route::post('admin/clientes/cancelar',				['middleware'=>'administrator','uses'	=>'ClienteController@cancelar']);

Route::any('admin/clientes/show/{id}',				['middleware'=>'administrator','uses'	=>'ClienteController@show']);

Route::any('admin/proprietarios/show/{id}',			['middleware'=>'administrator','uses'	=>'ClienteController@show']);

Route::post('admin/clientes/excluir',				['middleware'=>'administrator','uses'	=>'ClienteController@delete']);

Route::any('admin/clientes/buscaCep',				['middleware'=>'administrator','uses'	=>'ClienteController@buscaCep']);

Route::any('admin/mensagem',						['middleware'=>'administrator','uses'	=>'MensagemController@index']);

Route::any('admin/mensagem/show/{id}',				['middleware'=>'administrator','uses'	=>'MensagemController@show']);

Route::post('admin/mensagem/excluir',				['middleware'=>'administrator','uses'	=>'MensagemController@delete']);

Route::post('admin/mensagem/gravar',				['middleware'=>'administrator','uses'	=>'MensagemController@enviar']);
//Rotas possíveis para cadastro de usuários
Route::any('admin/usuarios',						['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@index']);

Route::get('admin/usuarios/show/{id}',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@show']);

Route::post('admin/usuarios/gravar',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@store']);

Route::get('admin/usuarios/cadastro',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@create']);

Route::any('admin/usuarios/excluir',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@delete']);

Route::post('admin/usuarios/cancelar',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@cancelar']);

Route::post('admin/usuarios/cancelar',				['middleware'=>'administrator','uses'	=>'UsuarioSistemaController@cancelar']);

Route::get('admin/sair',							['middleware'=>'administrator','uses'	=>'LoginController@logoutAdmin']);

Route::get('admin/sigin', 							'UsuarioSistemaController@sigin');

Route::post("admin/logonSistema",					'UsuarioSistemaController@login');
	
Route::post("admin/login",							'LoginController@loginAdmin');
//Fim - Rotas possíveis para cadastro de usuários

//Fim - Rotas possíevis para cadastro de clientes
//Rotas possíveis para aluguel
Route::any('admin/aluguel/index',					['middleware'=>'administrator','uses'	=>'AluguelController@index']);

Route::any('admin/aluguel',							['middleware'=>'administrator','uses'	=>'AluguelController@index']);

Route::any('admin/docs',							['middleware'=>'administrator','uses'	=>'ClienteController@clientesDocs']);

Route::any('admin/docs/delDoc',						['middleware'=>'administrator','uses'	=>'ClienteController@deleteDoc']);

Route::any('admin/docs/show/{id}',					['middleware'=>'administrator','uses'	=>'ClienteController@clienteDoc']);

Route::post('/admin/docs/cadDocs',					['middleware'=>'administrator','uses'	=>'ClienteController@storeDocs']);

Route::any('admin/aluguel/show/{id}',				['middleware'=>'administrator','uses'	=>'AluguelController@show']);

Route::post('admin/aluguel/alteraAluguel',			['middleware'=>'administrator','uses'	=>'AluguelController@alteraAluguel']);

Route::post('admin/aluguel/delAluguel',				['middleware'=>'administrator','uses'	=>'AluguelController@delete']);

Route::post('/admin/aluguel/cadAluguel',			['middleware'=>'administrator','uses'	=>'AluguelController@store']);

Route::post('admin/aluguel/cancelar',				['middleware'=>'administrator','uses'	=>'AluguelController@alteraAluguel']);

//Fim - Rotas possíveis para alguel.
//Rotas possíveis para cadastro de imoveis
Route::any('admin/imoveis',							['middleware'=>'administrator','uses'	=>'SearchController@adminImoveisIndex']);

Route::any('admin/imoveis/search',					['middleware'=>'administrator','uses'	=>'SearchController@adminImoveisIndex']);

Route::get('admin/imoveis/cadastro',				['middleware'=>'administrator','uses'	=>'SearchController@create']);

Route::post('admin/imoveis/gravar',					['middleware'=>'administrator','uses'	=>'SearchController@store']);

Route::get('admin/imoveis/show/{id}',				['middleware'=>'administrator','uses'	=>'SearchController@show']);

Route::any('admin/imoveis/cancelar',				['middleware'=>'administrator','uses'	=>'SearchController@cancelar']);

Route::any('admin/imoveis/cadfotos',				['middleware'=>'administrator','uses'	=>'SearchController@storeFotos']);

Route::any('admin/imoveis/cliente',					['middleware'=>'administrator','uses'	=>'SearchController@getClienteImovel']);

Route::post('admin/imoveis/excluir',				['middleware'=>'administrator','uses'	=>'SearchController@delete']);

Route::any('admin/imoveis/enderecoMaps',			['middleware'=>'administrator','uses'	=>'SearchController@getEnderecoMaps']);

//Fim - Rotas possíevis para cadastro de clientes

Route::any('busca', 'SearchController@busca');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
