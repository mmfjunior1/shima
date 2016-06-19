@extends('master.layout')
@section('title', 'Os melhores imóveis de São Paulo e região com excelentes preços - Imobiliaria Shima')
@section('content')
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
	                       			<h1 class="text-center" style="margin-bottom:0px; margin-top:0px !important; font-size:29px; background:none; width:100%; text-align: center; padding:0px;       color:white; margin-bottom:15px">Quer comprar ou alugar um imóvel? Encontre agora!</h1> 
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
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>O melhor imóvel está aqui!</h2>
		<p>Nós temos os melhores imóveis. Garantimos isso pois selecionamos, um a um, os imóveis anunciados, unindo qualidade com o melhor preço. Confira!</p>
	</div>
</section>
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>Quer vender ou alugar seu imóvel? Fale com a gente!</h2>
		<p>Se você tem um imóvel e deseja fazer negócio com ele, deixe que a Imobiliária Shima cuide de tudo. Iremos analisar seu imóvel e dispor em nossa plataforma. Você não paga para anunciar com a gente!</p>
	</div>
</section>
@endsection
