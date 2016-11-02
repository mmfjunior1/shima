@extends('modal.layoutAdmin')
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
		 @include('contents.formCadImoveis')
        
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


