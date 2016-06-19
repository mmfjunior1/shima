<?php 
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CEPController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	private $googleApiKey 	= 'AIzaSyCNw0_iVCn_WGbWMBQKm5G33v4n_9zY2jw';
	private $apiGoogleUrl	= 'https://maps.googleapis.com/maps/api/geocode/json';
	function getCEP($cep="")
	{
		$cep	= trim($cep);
		if($cep == "")
		{
			return $cep;
		}
		$cep	= str_replace(array(".","-"," "),"",$cep);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://viacep.com.br/ws/$cep/json/");
		//curl_setopt($ch, CURLOPT_TIMEOUT_MS,1000);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = (String)@curl_exec ($ch);
		return $server_output;
	}
	
	function getDadosEnderecoGoogleMaps($endereco = '')
	{
		$url 	= $this->apiGoogleUrl.'?address='.urlencode($endereco).'&key='.$this->googleApiKey;
		$ch 	= curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultado = curl_exec($ch);
		if($resultado)
		{
			return $resultado;
		}
		$resultado	= array();
		//print_r( json_decode($resultado));
		$resultado['results'] = array();
		$resultado['status'] = 'ZERO_RESULTS';
		return response()->json($resultado);
	}
}
