<?php
//use App\helpers\Helpers;
?>
@extends('master.layout')
@section('title', 'Casas à venda - Imobiliaria Shima')
@section('content')
<section class="breadcrumb-wrapper">
	<div class="container">
		<div style="padding-left:20%;padding-right:20%;">
			<form id="frm_main_searching" action="/busca" method="post" name="frm_main_searching">
				<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
				<div class="search-job">
					<div class="search-job-inner">
						<h1 class="text-center h1Search"> Não encontrou o que procurava? Pesquise novamente!</h1>
						<div style="border-radius: 5px 0px 0px 5px;" class="search-fild">
                            
		                 		<input style="text-align:center ; border-radius: 5px 0 0 5px; font-size:14px" class="select-search ui-autocomplete-input" value="{{$tipo}}" placeholder="Que tipo de imóvel?" id="tipo_imovel"  name="tipo_imovel" autocomplete="off">
		          	    </div>
		          	    <div class="search-fild">
                			<input type="text" style="text-align:center;font-size:14px" placeholder="Onde procura? (Rua, bairro ou cidade)" value="{{$route}}" class="select-search" name="route" id="route" autocomplete="off">
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
							<button title="Buscar imóveis" style="background:#E92922; color: white;" type="submit" id="buscar_imoveis" name="buscar_imoveis" class="search-now">Procurar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<section id="eshop" class="content bg-color-2">
	<div class="container">
		<div class="row eshop-header">
			<div class="col-md-6">
			</div>
		</div>
        <input type="hidden" value="" name="third_parameter" id="third_parameter" />
        <input type="hidden" value="" id="geo_latitude" name="geo_latitude" />
        <input type="hidden" value="" id="geo_longitude" name="geo_longitude" />
            <div class="row eshop-main eshop-list">
                <div class="col-md-9 eshop-content">
                 <div id="ourlistingcontact">
       				 <div class="eshop-product">
       				 	<?php 
						foreach ($search as $results) 
						{
							$id					= $results->id;
							$tipoImovelVenda	= $results->tipo_imovel;	
							$operacao			= $results->operacao==1?'à venda':'para aluguel';
							$endereco			= $results->logradouro.', '.$results->numero;
							$bairro				= $results->bairro.' - '.$results->localidade.', '.$results->uf;
							$valor				= Helpers::formatNumber($results->valor_imovel);
							$area				= $results->area;
							$quartos			= $results->quartos;
							$banheiros			= $results->banheiros;
							$suites				= $results->suites;
							$vagas				= $results->vagas;
							$imagens			= array();
							for($a = 1; $a <= 6;$a++)
							{
								$foto	= "foto$a";
								if($results->$foto)
								{
									$imagens[] = $results->$foto; 
								}
							}
						?>
						<div class="row results" style="visibility:hidden;background-color:#fff;box-shadow:0 1px 1px 0 rgba(0,0,0,0.1);" >
							<div class="col-lg-6 col-md-7 col-xs-8">
								@if(count($imagens) > 0)
								<div class="slider1">
									@foreach ($imagens as $imagem)
									    <div class="slide"><img class="img-responsive" alt="{{{$tipoImovelVenda}}} {{{$operacao}}}" src="{{$imagem}}"></div>
									@endforeach
								</div>
								@endif
							</div>
								<div class="col-lg-6 col-md-5 col-xs-4">
									<div class="eshop-product-body">
										<h3 title="{{{$tipoImovelVenda}}} {{{$operacao}}}">{{{$tipoImovelVenda}}}<a href="imovel/{{$id}}"><span style="color:#E92922;"> {{$operacao}}</span>
										</a>
										</h3>
										<p></p>
										<span style="color:#000;">{{{$endereco}}}</span>
										<p>{{{$bairro}}}</p>
										<div class="clearfix">
											<div style="padding:0 10px 7px; margin-right:30%" class="product-price pull-left">
										  		<span style="text-decoration:none;" class="old-price">R$</span>
												<span class="new-price"> {{$valor}}</span>
											</div>
										</div>
										<ul class="ulDetalheImovel">
											<li style="border-left:0px">Área: {{$area}}</li>
											<li>Quartos: {{$quartos}}</li>
											<li>Suítes: {{$suites}}</li>
											<li>Banheiros: {{$banheiros}}</li>
											<li>Vagas: {{$vagas}}</li>
										</ul>
										<p></p>
										<div>
											   <a href="imovel/{{$id}}"class="btn btn-primary" style="font-size:10px;float:left;width:100%">Ver detalhes da oferta</a>&nbsp;
											   <!-- <button class="btn btn-primary" style="font-size:10px;float:left;margin-left:10px">Entre em contato</button>-->            
										</div>
										
									</div>
									<!-- 
									<div class="clearfix">
										<div style="padding-top:10px ; float:left!important" class="pull-right">
 										<div style="border-radius:12px;background-color:white;color:rgb(179, 179, 179); font-size:10px" class="btn btn-success">Musculação</div>
 										<div style="border-radius:12px;background-color:white;color:rgb(179, 179, 179); font-size:10px" class="btn btn-success">Treinamento Funcional</div>
 										<div style="border-radius:12px;background-color:white;color:rgb(179, 179, 179); font-size:10px" class="btn btn-success">Emagrecimento</div>	  </div>
									</div>-->
								</div>
						</div>
						<br>
						<?php }?>
						<div class="row">
							{!! $search->links() !!}
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-3 eshop-content menu hidden-xs hidden-md hidden-sm" style="top: 0px;" id="mustafa">
				<div class="list_filter_options">
					<h4 class="tituloDivFilter">Refinar busca</h4>
					<hr class="hrFilter">
		           	<h4>Imóveis por cidade</h4>
		           	<div id="carrosPorCidade" class="imovelPorCidade" style="display: block;">
		           		<?php 
		           			foreach($imovelCidade as $agrupamentoCidade)
		           			{
		           				
		           		?>
							<span class="color_back">SP - <a style="text-decoration:none;" href="busca/?localidade={{urlencode($agrupamentoCidade->localidade)}}">{{$agrupamentoCidade->localidade}}</a> </span><span class="color_gray">[{{$agrupamentoCidade->conta}}]</span><br>
						<?php 	
							}
						?>
					</div>
					
					  <h4>Operação</h4>
					  <div id="tipoCambio" class="imovelPorCidade">
					  		<?php 
		           			foreach($imovelOperacao as $agrupamentoOperacao)
		           			{
		           				$operacao	= $agrupamentoOperacao->operacao == 1?'Venda':'Aluguel';
			           		?>
								<span class="color_red"><a style="text-decoration:none;" href="busca?operacao={{$agrupamentoOperacao->operacao}}">{{$operacao}}</a></span><span class="color_gray"> [{{$agrupamentoOperacao->conta}}]</span><br>
							<?php 	
								}
							?>
					  </div>
					
					  <h4>Tipo de imóvel</h4>
					  
					  <div id="tipoCambio" class="imovelPorCidade">
						   <?php 
		           			foreach($tipoImovel as $agrupamentoTipoImovel)
		           			{
		           				
			           		?>
			           			<span class="color_red"><a style="text-decoration:none;" href="busca?tipo_imovel={{urlencode($agrupamentoTipoImovel->tipo_imovel)}}">{{$agrupamentoTipoImovel->tipo_imovel}}</a></span><span class="color_gray"> [{{$agrupamentoTipoImovel->conta}}]</span><br>
							<?php 	
								}
							?>
					  </div>
				  	  
				  	  <h4>Area</h4>
					  
					  <div id="tipoCambio" class="imovelPorCidade">
						   <?php 
		           			foreach($areaTotal as $agrupamentoArea)
		           			{
		           				
			           		?>
			           			<span class="color_red"><a style="text-decoration:none;" href="busca?area={{$agrupamentoArea->area}}">{{$agrupamentoArea->area}}  M²</a></span><span class="color_gray"> [{{$agrupamentoArea->conta}}]</span><br>
							<?php 	
								}
							?>
					  </div>
					  
					  <h4>Maior preço</h4>
					  <div id="faixaPrecoMax" class="faixaPreco">
						  <span class="color_red"></span> <span class="color_black"><strong><a href="busca?valor={{$maiorPrecoNonFormat}}" style="text-decoration:none;">R$ {{$maiorPreco}}</a></strong></span><br>
					  </div>
				   <h4>Menor preço</h4>
					  <div id="faixaPrecoMin" class="faixaPreco">
						  <span class="color_red"></span> <span class="color_black"><strong><a href="busca?valor={{$menorPrecoNonFormat}}" style="text-decoration:none;">R$ {{$menorPreco}}</a></strong></span><br>
					</div>
				   
		        </div>
            </div>
            <script src="js/stickyfloat.js"></script>
			    <script type="text/javascript">
			    $(function() { 
			        $('#mustafa').stickyfloat(); 
			    });
			  </script>
                <!-- ESHOP CONTENT - END -->
            </div>
        </div>
    </section>
    <script>
$(document).ready(function()
{
  $('.slider1').bxSlider({
    minSlides: 1,
    adaptiveHeight: true,
  });
  $(".results").css("visibility","visible");
});
</script>
@endsection
@section('imoveisDestaque')
<div class="col-md-12 hidden-xs hidden-sm userhe">
	<h3><i class="fa fa-home"></i>Imóveis esperando você para dar uma olhada</h3>
		<div id="latest-work-footer" class="row">
        	<div style="cursor:pointer;" class="overlay-wrapper col-sm-2">
            	<img alt="teste Tais" class="img-responsive" src="http://www.feelgreat.com.br/uploads/user/crop/fb1453926971.jpg"><!--style="width:160px;height:90px;"width:160px;height:90px; width:160px;height:90px;-->
                <a href="http://www.feelgreat.com.br/Personal-Trainer/Tais_1267" onclick="ga('send', 'event', 'Usuarios_Recentes','Clique_no_Rodape', 'Visita_no_profissional');"> 
   					<abbr class="overlay" rel="tooltip" title="Tais,Personal Trainer"></abbr>
   				</a>
			</div>
		</div>
</div>
@endsection