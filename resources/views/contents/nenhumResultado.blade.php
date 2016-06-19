@extends('master.layout')

@section('content')

@section('title', "Nenhum imóvel foi encontrado - Imobiliária Shima")
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
	    height: 34px;
	    line-height: 1.4;
	    padding: 5px 10px;
	    width: 100%;
	}
	table textarea
	{
		width: 100%;
		height: 100px;
	}
	table.form td label {
	    font-size: 0.85em;
	    text-align: left;
	    color: #444 !important;
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
	
	.col-md-3 li
	{
		color:#555555;
		list-style:none;
		text-align:left;
		font-size:20px;
		line-height:2.865em;;
		margin-left:-40px
	}
</style>

<section class="jumbotron jumbotron5" style="height:450px">

	<div class="container" >
		<div class="row">
			<div class="container">
				<div class="row">
	                <div  class="col-md-4"></div>
    	            <div class="col-md-8" style="width:100%; margin-top:12%">
        		        <form name="frm_main_searching" id="frm_main_searching" method="post" action="busca">
        		        	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                		    <div class="search-job">
        						<div class="search-job-inner" style="margin-top: 27px; background-color:rgba(29, 29, 29, 0.32)">
	                       			<h1 class="text-center" style="margin-bottom:0px; margin-top:0px !important; font-size:29px; width:100%; text-align: center; padding:0px;font-weight:bold;margin-bottom:15px"><div style="background:#fff;color:#E92922;"> Nenhum resultado foi encontrado. Pesquise novamente.</div></h1> 
									 <div class="search-fild" style="border-radius: 5px 0px 0px 5px;">
	                 					<input name="tipo_imovel" id="tipo_imovel" placeholder="O que procura?" class="select-search" style="text-align:center ; border-radius: 5px 0 0 5px; font-size:17px"/>
	          	    				</div>
		    			             <div class="search-fild">
		                				<input id="route" name="route" class="select-search" value="" placeholder="Onde procura? (Bairro ou Cidade)" type="text" style="text-align:center;font-size:17px">
		               		 		</div>
				                    <input type="hidden" id="sublocality_level_1" name="sublocality_level_1" value=""/>
				                    <input type="hidden" id="sublocality_level_3" name="sublocality_level_3" value=""/>
				                    <input type="hidden" id="sublocality_level_2" name="sublocality_level_2" value=""/>
				                    <input type="hidden" id="postal_code" name="postal_code" value=""/>
				                    <input type="hidden" id="street_number" name="street_number" value=""/>
				                    <input type="hidden" id="neighborhood" name="neighborhood" value=""/>
				                    <input type="hidden" id="locality" name="locality" value="" />
				                    <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" value="" />
				                    <input type="hidden" id="country"  name="country" value="" />
				                    
				                    
				                    <input type="hidden" id="bairro" name="bairro" value=""/>
				                    <input type="hidden" id="localidade" placeholder="localidade" name="localidade" value=""/>
				                    <input type="hidden" id="uf" name="uf" value="" />
				                    <input type="hidden" id="logradouro" name="logradouro" value="" />
		                		<div class="search-fild-last">
									<button class="search-now" name="btn_front_search" id="btn_front_search" type="submit" style="background:#E92922" title="Procurar Bussiness">Procurar</button>
								</div>  
		            	  		<div class="clr"></div>
            				</div>
       				 	</div>
                    </form>
                </div>  
					<div class="col-md-12" style="text-align:center">
						<br>
						<br>
	                </div>
                </div>  
			</div>
        </div>
	</div>
</section>
@endsection