@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')
		<style>
			input, select{
				width:100%;
				height:25px;
			}
			table tr  td
			{
				padding:2px !important;
			}
			.modal-dialog-fotos {
		   		width: 90%;
			}
			.fotos
			{
				height:350px;
				overflow-x:hidden;
				overflow-y:auto;
				padding: 25px;				
			}
			.rowFotos
			{
				padding-top:10px;
			}
			#myModal
			{
				z-index:9999 !important;
			}
			select
			{
				border:1px solid #ccc;
				
			}
		</style>
		
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Cadastro - Imóveis</h2> 
          	<!--  Modal maps -->
          	<!-- Modal -->
			<div class="modal fade" id="modalMaps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-fotos" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Mapa do imóvel selecionado</h4>
			      </div>
			      <div class="modal-body-mapa">
			        <div id="mapa" style="width:100%;height:400px"></div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="modalFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-fotos" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Gerencidador do fotos</h4>
			      </div>
			      <div class="modal-body-fotos">
			        <form name="formCadimoveifotos" id="formCadimoveisfotos" enctype="multipart/form-data">
			        	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			        	<fieldset>
			            <legend>&nbsp;&nbsp;&nbsp;Seleção de fotos</legend>
			            <table class="table">
			              <tbody>
			                <tr>
			                  <td width="13%"><input type="file" name="enviaFoto" id="enviaFoto" multiple ></td>
			                </tr>
			            </table>
			            <div class="fotos">
			            <div class="row rowFotos">
					        <div class="col-md-4">
					          	<img src="/{{{@$search->foto1}}}" name="foto1" id="foto1" width="350">
					        </div>
					        <div class="col-md-4">
					          <img src="/{{{@$search->foto2}}}" name="foto2" id="foto2" width="350">
					       </div>
					        <div class="col-md-4">
					          <img src="/{{{@$search->foto3}}}" name="foto3" id="foto3" width="350">
					        </div>
					      </div>
					       <div class="row rowFotos">
					        <div class="col-md-4">
					          <img src="/{{{@$search->foto4}}}" name="foto4" id="foto4" width="350">
					        </div>
					        <div class="col-md-4">
					          <img src="/{{{@$search->foto5}}}" name="foto5" id="foto5" width="350">
					       </div>
					        <div class="col-md-4">
					          <img src="/{{{@$search->foto6}}}" name="foto6" id="foto6" width="350">
					        </div>
					      </div>
					      </div>
			            </fieldset>
			        </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary btnCadFoto">Enviar fotos</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			      </div>
			    </div>
			  </div>
			</div>
          <div class="table-responsive">
          	<form name="formCadimoveis" id="formCadimoveis" class="formCad">
          	<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>">
            <fieldset>
            <legend>Dados Básicos</legend>
            <input type="hidden" name="id_cliente" id="id_cliente"  value="{{{@$search->id_cliente}}}">
            <input type="hidden" name="id_cliente_inquilino" id="id_cliente_inquilino"  value="{{{@$search->id_inquilino}}}">
            <table class="table">
              <tbody>
                <tr>
                  <td width="13%">Proprietário:</td>
                  <td width="20%"><input type="text" name="cpf" id="cpf" class="cpfSearch" value="{{{@$search->cpf}}}" placeholder="CPF"></td> 
                  <td colspan="5"><input type="text" name="nome" id="nome" size="45" value="{{{@$search->nome}}}" placeholder="Nome"></td>
                </tr>
                <tr>
                  <td width="13%">Inquilino:</td>
                  <td width="20%"><input type="text" name="cpf_inquilino" id="cpf_inquilino" class="cpfSearch" value="{{{@$search->cpf_inquilino}}}" placeholder="CPF"></td> 
                  <td colspan="5"><input type="text" name="nome_inquilino" id="nome_inquilino" size="45" value="{{{@$search->nome_inquilino}}}" placeholder="Nome"></td>
                </tr>
            </table>
            </fieldset>
            <fieldset>
            <legend>Dados do imóvel</legend>
            <table class="table">
              <tbody>
                <tr>
                  <td width="10%">Tipo:</td>
                  <td><select name="tipo">
                  		<option value="0">Selecione o tipo do imóvel </option>
                  	<?php 
                  		foreach($tiposImovel as $imoveisTipo)
                  		{
                  			$selected = ($imoveisTipo->id_tipo == @$search->tipo?'selected="selected"':'');
                  			echo '<option value="'.$imoveisTipo->id_tipo.'" '.$selected.'>'.$imoveisTipo->tipo_imovel.' </option>';
                  		}
                  	?>
                  </select></td>
                  <td width="7%">Valor R$:</td>
                  <td> <input type="text" name="valor_imovel" id="valor_imovel" value="{{{@$search->valor_imovel}}}"></td>
                  <td>Operação:</td>
                  <td><select name="operacao">
                  		<option value="1" <?php if (@$search->operacao == '1'?print("selected=\"selected\""):'')?>>Venda</option>
                  		<option value="2" <?php if (@$search->operacao == '2'?print("selected=\"selected\""):'')?>>Locação</option>
                  		</select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="13%">Área:</td>
                  <td width="13%"><input type="text" name="area" id="area" value="{{{@$search->area}}}"></td>
                  <td width="13%">Quartos:</td>
                  <td width="13%"><input type="text" name="quartos" id="quartos" value="{{{@$search->quartos}}}"></td>
                   <td width="13%">Suítes:</td>
                   <td width="13%"><input type="text" name="suites" id="suites" value="{{{@$search->suites}}}"></td>
                   <td width="13%">Banheiros:</td>
                   <td width="13%"><input type="text" name="banheiros" id="banheiros" size="3" value="{{{@$search->banheiros}}}"></td>
                 </tr>
                 <tr>
                   <td width="13%">Vagas:</td>
                   <td width="13%"><input type="text" name="vagas" id="vagas" size="3" value="{{{@$search->vagas}}}"></td>
                   <td width="13%">Situação:</td>
                   <td width="13%">
                   		<select name="status">
                   			<option value="t" <?php if (@$search->status ==1?print("selected=\"selected\""):'')?>>Ativo</option>
                   			<option value="f" <?php if (@$search->status !=1?print("selected=\"selected\""):'')?>>Inativo</option>
                   		</select>
                   </td>
                   <td width="13%">&nbsp;</td>
                   <td width="13%">&nbsp;</td>
                   <td width="13%">&nbsp;</td>
                   <td width="13%">&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </fieldset>
            <fieldset>
            <legend>Localização do imóvel</legend>
            <table class="table">
              <tbody>
              <tr>
                  <td width="10%">CEP:</td>
                  <td><input type="text" value="{{{@$search->cep}}}" size="45" id="cep" class="cep" name="cep"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="10%">Endereço:</td>
                  <td><input type="text" name="logradouro" id="logradouro" value="{{{@$search->logradouro}}}"></td>
                  <td><input type="text" name="numero" id="numero" size="5" value="{{{@$search->numero}}}"></td>
                  <td>Bairro:</td>
                  <td><input type="text" name="bairro" id="bairro" value="{{{@$search->bairro}}}"></td>
                   <td>Cidade:</td>
                   <td><input type="text" name="localidade" id="localidade" value="{{{@$search->localidade}}}"></td>
                   <td>Estado:</td>
                   <td><input type="text" name="uf" id="uf" size="3" value="{{{@$search->uf}}}"></td>
                </tr>
                </tbody>
                </table>
                <table class="table">
                <tbody>
                <tr>
                  <td width="10%"><button type="button" id="addFoto" data-toggle="modal"  name="addFoto" class="btn btn-default">Gerenciar fotos do imóvel</button></td>
                  <td><button type="button" id="viewMap" data-toggle="modal"  name="addFoto" class="btn btn-default btnViewMap">Visualizar mapa</button></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
               </tbody>
                 <!--   <input type="hidden" id="sublocality_level_3" name="sublocality_level_3" value=""/>
                    <input type="hidden" id="sublocality_level_2" name="sublocality_level_2" value=""/>
                    <input type="hidden" id="postal_code" name="hidden" value=""/>
                    <input type="hidden" id="street_number" name="street_number" value=""/>
                    <input type="hidden" id="neighborhood" name="neighborhood" value=""/>
                    <input type="hidden" id="country"  name="country" value="" />
                    <input type="text" id="latlong"  name="latlong" value="" />-->
            </table>
            <input type="hidden" id="longitude"  name="longitude" value="{{{@$search->longitude}}}" />
            <input type="hidden" id="latitude"  name="latitude" value="{{{@$search->latitude}}}" />
            </fieldset>
            
            <table class="table">
            	<tr>
            		<td><button type="button" id="btnCadCli" class="btn btn-primary btnCad" >Gravar</button></td>
            		<td><button type="button" id="btnDelCli" class="btn btn-danger btnCad">Excluir</button></td>
            		<td><button type="button" id="btnCancCli" class="btn btn-default btnCad">Cancelar</button></td>
            		<td><a class="btn btn-default" href="/admin/imoveis">Voltar</a></td>
            	</tr>
            </table>
            <input type="hidden" name="id" id="id" value="{{{@$search->id_imovel}}}"> 
            </form>
            
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'pt-BR'}
</script>
    <script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.
		//window.onload=initialize;
					
	 	// Exibir o mapa na div #mapa;
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
				title: $("#logradouro").val()+', '+$("#numero").val()+', '+$("#bairro").val()+' - '+$("#localidade").val()+'/'+$("#uf").val()
			});
		}
	  		
		
		var placeSearch, autocomplete;
		function initialize() 
		{ 
			autocomplete = new google.maps.places.Autocomplete(
			(document.getElementById('logradouro')),
		      { types: ['geocode'] });
			google.maps.event.addListener(autocomplete, 'place_changed', function() 
			{ 
				$('#loading_add').show();
				fillInAddress();
			});
			$("#route").attr('placeholder','');
		}
		function fillInAddress() 
		{ 
			var place = autocomplete.getPlace();
			
		  	var latLong	= '';
		  	
		  	if(place.address_components[0].long_name)
		  	{
			  	$("#logradouro").val(place.address_components[0].long_name);
		  	}
		  	if(place.address_components[1].long_name)
		  	{
			  	$("#bairro").val(place.address_components[1].long_name);
		  	}
		  	if(place.address_components[2].long_name)
		  	{
			  	$("#cidade").val(place.address_components[2].long_name);
		  	}
		  	if(place.address_components[4].long_name)
		  	{
			  	$("#estado").val(place.address_components[4].short_name);
		  	}
		  	var teste = "location";
		  	alert(place.geometry.length);
		  	$.each(place.geometry,function(index,value){
			  	alert(index);
			});
			  
		  
			$('#loading_add').hide();
		}
		</script> 
@endsection


