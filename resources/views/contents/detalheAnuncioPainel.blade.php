@extends('master.layoutPainelCliente')

@section('content')
<?php 
		$operacao		= $search[0]->operacao==1?$search[0]->tipo_imovel.' à venda':$search[0]->tipo_imovel.' para aluguel';
		$operacaoTitle	= $operacao. ' - Imobiliaria Shima.';
		$bairro		= $search[0]->bairro.' - '.$search[0]->localidade.', '.$search[0]->uf;
		$endereco	= $search[0]->logradouro.', '.$search[0]->numero.', '.$bairro;
		$valor		= number_format($search[0]->valor_imovel,2,",",".");
		$area		= (int)$search[0]->area;
		$quartos	= $search[0]->quartos;
		$banheiros	= $search[0]->banheiros;
		$suites		= $search[0]->suites;
		$vagas		= $search[0]->vagas;
		$latitude	= $search[0]->latitude;
		$longitude	= $search[0]->longitude;
		$precoMetro	= $search[0]->valor_imovel/$area;
		$precoMetro	= number_format($precoMetro,2,",",".");
		$imagens	= array();
		for($a = 1; $a <= 6;$a++)
		{
			$foto	= "foto$a";
			if($search[0]->$foto)
			{
				$imagens[] = '/'.$search[0]->$foto; 
			}
		}
		$url	= str_replace("painelCliente","",Request::url());
?>
@section('title', $operacaoTitle)
<style>
	.preco  {
    color: #E92922 !important;
    font-size: 2.5em !important;
    font-weight: bold !important;
    line-height: 1em !important;
    margin: 0 0 20px !important;
    background-color: none !important;
	}
	.labelFormContato
	{
		color: #444;
		padding-top:60% !important;
	}
	table.form {
    	border: 0 none;
    	width: 100%;
	}
	table input
	{
		 background: #fff none repeat scroll 0 0;
	    border: 1px solid #ccc;
	    border-radius: 5px;
	    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	    box-sizing: border-box;
	    color: #444;
	    display: block;
	    font-family: "Open Sans",Arial,sans-serif;
	    font-size: 1em;
	    font-weight: 400;
	    height: 29px;
	    line-height: 1.4;
	    padding: 5px 10px;
	    width: 100%;
	}
	table textarea
	{
		width: 100%;
		height: 80px;
	}
	table.form td.label {
	    font-size: 0.85em;
	    text-align: left;
	}
	
	table.form td {
    	padding: 5px 10px 5px 0;
    	vertical-align: middle;
	}
	.btnContato
	{
		width:100%;
		height:40px;
	}
	.conteinerAnuncio
	{
		width:95%;
	}
	.h3Anuncio
	{
		margin-bottom: 15px;
    	margin-top: 15px;
	}
	
	.col-md-4 li
	{
		color:#555555;
		list-style:none;
		text-align:left;
		font-size:20px;
		line-height:2.865em;;
		margin-left:-40px
	}
	.formMensagem
	{
		padding-right:0px !important;
		background:#F0F0F0;
	}
</style>
<div class="col-sm-9 col-sm-offset-0 col-md-12 col-md-offset-0 col-xs-12 main">
	<h2 class="sub-header">Meus dados</h2>
	<div class="col-sm-9 col-sm-offset-0 col-md-12 col-md-offset-0 col-xs-12">
		<div class="row"><h3 class="h3Anuncio">{{$operacao}} em {{$endereco}}</h3></div>
		<div class="row">
			<div class="">
				<div class="row">
	                <div  class="col-md-4" >
	                @if(count($imagens) > 0)
					<div class="slider1">
						@foreach ($imagens as $imagem)
						    <div class="slide"><img class="img-responsive" alt="Casa {{{$operacao}}}" src="{{$imagem}}"></div>
						@endforeach
					</div>
					@endif
	                </div>
	                <div class="col-md-4">
	                	<h2 class="preco">Detalhes</h2>
	                	<ul>
	                		<li>Área: {{$area}} m² (R$ {{$precoMetro}} o m²)</li>
	                		<li>Quartos: {{$quartos}}</li>
	                		<li>Banheiros: {{$banheiros}}</li>
	                		@if($suites > 0)
	                		<li>Suites: {{$suites}}</li>
	                		@endif
	                		<li>Garagem: {{$vagas}} vaga(s)</li>
	                	</ul>
	                </div>
    	           <div class="col-md-4 formMensagem">
        		       <h2 class="preco">R$ {{$valor}}</h2>
        		       <form id="formEmail">
    	               <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        		       <table cellspacing="0" cellpadding="0" border="0" class="form">
                                    <tbody>
                                        <tr>
                                            <td><label for="nome">Nome:</label></td>
                                            <td class="input">
                                                <input type="text" data-nav="nome|disableifexists" maxlength="30" name="nome" id="nome" placeholder="Nome" value="{{$user->nome}}" class="icr-input">
                                                <input type="hidden" name="valor" id="valor" value="{{$valor}}">
                                                <input type="hidden" name="titulo" id="titulo" value="Anuncio de {{$user->nome}}">
                                                <input type="hidden" name="url" id="url" value="{{$url}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="emailcontato">E-mail:</label></td>
                                            <td class="input">
                                                <input type="text" onkeypress="return(validaConteudo(event,this,'email'));" value="{{$user->email}}" value="" name="emailcontato" id="emailcontato" placeholder="Email" class="icr-input">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="telefoneCompleto">Telefone:</label></td>
                                            <td class="input">
                                                <input type="tel" placeholder="(11) 1234-5678" maxlength="14" onkeydown="bloqueiaEnter(event);" data-nav="telefonefixocompleto|disableifexists" value="{{$user->telefone1}}" id="telefone" name="telefone" class="icr-input icr-phone-mask">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="input">
                                                <textarea rows="3" placeholder="Deseja falar algo sobre esse anúncio? Envie-nos uma mensagem." id="texto" name="texto" class="icr-input"></textarea>
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td colspan="2" class="input">
                                                <button class="btn btn-primary btnContato btnEnviaEmailImovel" type="button" >Entre em contato</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                                <div class="row" id="mapa" style="width:100%;height:150px;left:10px;"></div>
                    	</div>  
				</div>  
			</div>
        </div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
function initMap(lat,lng) {
	var latitude 	= lat;
	var longitude 	= lng;
	var myLatLng 	= {lat: latitude, lng: longitude};
	var map = new google.maps.Map(document.getElementById('mapa'), {
			zoom: 18,
			center: myLatLng
	});
	var marker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		
	});
}
initMap({{$latitude}},{{$longitude}});
</script>
@endsection