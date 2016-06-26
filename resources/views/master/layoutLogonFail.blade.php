<?php 
use App\Search;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="pt-br" />
<meta name="description" content="" />
<meta name="author" content="Mario Miranda Fernandes Junior" >
<meta name="keywords" content="casa, apartamento, loft, terreno, shima, sobrado" />
<title>@yield('title')</title>



     <style>
		.progresso
		{
			padding-right:5px;
			border-radius:5px; 
			text-align:right;
			font-weight:bold;
			box-shadow: inset -3px -3px 12px -5px #211E1E;
			-webkit-box-shadow: inset -3px -3px 12px -5px #211E1E;
			-moz-box-shadow: inset -3px -3px 12px -5px #211E1E;
			-o-box-shadow: inset -3px -3px 12px -5px #211E1E;
		}
		.statusPerfil
		{
			width:300px;
			border-radius:5px;
			background:#ccc;
		}
		.fraco
		{
			color:#fff;
			background:#A3271A;
		}
		.spanFraco
		{
			color:#A3271A;
			font-size:12px;
		}
		.medio
		{
			background:#e8f300;
			color:#000;
		}
		.spanNivel
		{
			text-shadow: 1px 1px #000;
			font-weight:bold;
		}
		.spanMedio
		{
			color:#e8f300;
			font-size:12px;
		}
		.forte
		{
			color:#fff;
			background:#119178;
		}
		.spanForte
		{
			color:#119178;
		}
		.muitoForte
		{
			color:#fff;
			background:#8CC63F;
		}
		.spanMuitoForte
		{
			color:#8CC63F;
			font-size:13px;
		}
		
		.botaoControle {
			background: none repeat scroll 0 0 #e8f300;
			border-radius: 8px;
			box-shadow: 2px 2px 2px #000;
			color: #575958;
			font-family: "Arial",Arial,serif;
			font-size:15px;
			font-weight:bold;
			height: 40px;
			position: relative;
			text-align: center;
			text-shadow: none;
			margin-top:10px;
			padding-left: 10px;
			padding-right: 10px;
			border:0px;
		}
		.atualizarPefil
		{
			font-size:12px;
			margin-top:0px;
			border:0px;
			padding-left:10px;
			padding-right:10px;
		}
		.botaoControle:hover
		{
			cursor:pointer;
			background-image: linear-gradient(to bottom, transparent, rgba(0,0,0,0.2));
		}
		.progressBar
		{
			width:60%;
			height:20px;
			margin:auto;
			border-radius: 10px;
			background:#fff;
		}
		.progressBarInner
		{
			position:relative;
			float:left;
			padding-right:2%;
			background:#e8f300;
			border-radius: 10px;
			font-weight:bold;
			text-align:right;
		}
		
		#tooltip
		{
			text-align: center;
			color: #fff;
			background: #111;
			position: absolute;
			z-index: 100;
			padding: 15px;
		}
		 
		#tooltip:after /* triangle decoration */
		{
			width: 0;
			height: 0;
			border-left: 10px solid transparent;
			border-right: 10px solid transparent;
			border-top: 10px solid #111;
			content: '';
			position: absolute;
			left: 50%;
			bottom: -10px;
			margin-left: -10px;
		}
		 
		#tooltip.top:after
		{
			border-top-color: transparent;
			border-bottom: 10px solid #111;
			top: -20px;
			bottom: auto;
		}
 
		#tooltip.left:after
		{
			left: 10px;
			margin: 0;
		}
 
		#tooltip.right:after
		{
			right: 10px;
			left: auto;
			margin: 0;
		}
		.star{color:#F00;}
		.error{color:#F00; font-size:12px;}
	</style>

    <!-- ==========================
    	Meta Tags 
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ==========================
    	Favicons 
    =========================== -->
    <link rel="shortcut icon" href="//images/icone.png">
	
    
    <!-- ==========================
    	Fonts 
    =========================== -->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    
    <!-- ==========================
    	CSS 
    =========================== -->
    <link type="text/css" rel="stylesheet" href="/css/select-box.css">
	<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="/css/animate.css">
	<link type="text/css" rel="stylesheet" href="/css/yamm.css">
	<link type="text/css" rel="stylesheet" href="/css/jquery.bootstrap-touchspin.css">
	<link type="text/css" rel="stylesheet" href="/css/owl.carousel.css">
	<link type="text/css" rel="stylesheet" href="/css/owl.theme.css">
	<link type="text/css" rel="stylesheet" href="/css/owl.transitions.css">
	<link type="text/css" rel="stylesheet" href="/css/magnific-popup.css">
	<link type="text/css" rel="stylesheet" href="/css/creative-brands.css">
	<link type="text/css" rel="stylesheet" href="/css/color-switcher.css">
	<link type="text/css" rel="stylesheet" href="/css/color.css">
	<link type="text/css" rel="stylesheet" href="/css/custom.css">
	<link type="text/css" rel="stylesheet" href="/css/jquery.bxslider.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    
    <!-- ==========================
    	JS 
    =========================== -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond./js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<script src="/js/vendor/jquery.min.js"></script>
    <script src="/js/vendor/jquery.bxslider.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
      <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body class="color-green" style=" margin:0px;">
	
		<!-- ==========================
	    	HEADER - START
	    =========================== -->
	<div id="page-wrapper">
	<nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <!-- <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>-->
          <a href="/" class="navbar-brand navbar-brand-custom"><img alt="Shima" src="/images/Shima-logo.png" alt="Logo Imobiliaria Shima"></a>
        </div>
      </div>
    </nav>
        @yield('content')
	</div>
	<footer>
		<div class="container">
        	<div class="row">
                <div class="col-md-6 hidden-xs hidden-sm ">
					<h3><i class="fa fa-home"></i>Oportunidades para venda</h3>
						<div id="latest-work-footer" class="row">
				        	<?php 
							$casasCompra	= Search::select('*')->where([['operacao',1],['status',1]])->take(5)->get();
							
							foreach($casasCompra as $value)
							{
								$foto = url(''.@$value->foto1.'');
								$operacao		= @$value->operacao==1?@$value->tipo_imovel.' à venda':@$value->tipo_imovel.' para aluguel';
								$bairro		= @$value->bairro.' - '.@$value->localidade.', '.@$value->uf;
								$endereco	= @$value->logradouro.', '.@$value->numero.', '.$bairro;
								$valor		= number_format(@$value->valor_imovel,2,",",".");
								echo '<div style="cursor:pointer;" class="overlay-wrapper col-sm-2">
				            	<img alt="'.$operacao.' por R$ '.$valor.'" class="img-responsive" src="'.$foto.'">
				                <a href="'.url('imovel/'.@$value->id).'" > 
				   					<abbr class="overlay" rel="tooltip" title="'.$operacao.' por R$ '.$valor.'"></abbr>
				   				</a>
								</div>';
							}
						?>
						</div>
				</div>
        		<div class="col-md-6 hidden-xs hidden-sm ">
					<h3><i class="fa fa-home"></i>Oportunidades para aluguel</h3>
						<div id="latest-work-footer" class="row">
				        	<?php 
							$casasAluguel	= Search::select('*')->where([['operacao',2,],['status',1]])->take(5)->get();
							
							foreach($casasAluguel as $value)
							{
								$foto = url(''.@$value->foto1.'');
								$operacao		= @$value->operacao==1?@$value->tipo_imovel.' à venda':@$value->tipo_imovel.' para aluguel';
								$bairro		= @$value->bairro.' - '.@$value->localidade.', '.@$value->uf;
								$endereco	= @$value->logradouro.', '.@$value->numero.', '.$bairro;
								$valor		= number_format(@$value->valor_imovel,2,",",".");
								echo '<div style="cursor:pointer;" class="overlay-wrapper col-sm-2">
				            	<img alt="'.$operacao.' por R$ '.$valor.'" class="img-responsive" src="'.$foto.'">
				                <a href="'.url('imovel/'.@$value->id).'" > 
				   					<abbr class="overlay" rel="tooltip" title="'.$operacao.' por R$ '.$valor.'"></abbr>
				   				</a>
								</div>';
							}
						?>
						</div>
				</div>
			</div>
		</div>
		    <div class="footer-bottom">
                <ul class="nav navbar-nav navbar-center">
                    <li><a href="/">Home</a></li>
                    <li><a href="https:///contactus">Fale Conosco</a></li>
                </ul>
            </div>
    </footer>
    <script src="/js/imobiliaria.js"></script>
	<script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.
		window.onload=initialize;
		var placeSearch, autocomplete;
		var componentForm = {
			sublocality_level_1: 'long_name',
			sublocality_level_2: 'long_name',
			sublocality_level_3: 'long_name',
			
			route: 'long_name',
			locality: 'long_name',
			administrative_area_level_1: 'short_name',
			country: 'short_name',
			street_number:'short_name',
			neighborhood:'long_name'
		};
		
		function initialize() 
		{ 
			autocomplete = new google.maps.places.Autocomplete(
			(document.getElementById('route')),
		      { types: ['geocode'] });
			google.maps.event.addListener(autocomplete, 'place_changed', function() 
			{ 
				$('#loading_add').show();
				fillInAddress();
			});
		}
		function fillInAddress() 
		{ 
			$("#localidade,#logradouro,#uf,#bairro").val('');
			var place = autocomplete.getPlace();
			for (var component in componentForm) 
			{ 
				
		    	document.getElementById(component).value = '';
		    	document.getElementById(component).disabled = false;
		  	}
		  	var logradouro = '';
		  	var addresType1 = '';
		  	var uf			= '';
		  	for (var i = 0; i < place.address_components.length; i++) 
		  	{
			  	var addressType = place.address_components[i].types[0];
			  	
				if (componentForm[addressType]) 
		  		{
			  		var val = place.address_components[i][componentForm[addressType]];
			  		console.log(addressType+'--'+val);
			  		switch(addressType)
			  		{
			  		case 'sublocality_level_1':
			  			addresType1 = 'bairro';
				  		break;
			  		case 'locality':
			  			addresType1 = 'localidade';
				  		break;
			  		case 'administrative_area_level_1':
			  			addresType1 = 'uf';
			  			uf			= val;
			  			break;
				  	case 'route':
				  		logradouro = val;
					  	break;
				  		
				  	}
				  	try
				  	{
			  			document.getElementById(addresType1).value = '';
				  	}catch(err){}
				  	try{
					 if(addresType1 != '')
					 {
						 
			  			document.getElementById(addresType1).value = val;
					 }
				  	}catch(err)
				  	{
						console.log('Erro: '+addresType1);
					}
			 	  	if(document.getElementById('route').value!="")
					{
			 	  		document.getElementById('route').value += ', ';}
						document.getElementById('route').value += val;
						document.getElementById('country').value = val;
		    		}
		  	}
		  	if(logradouro != '')
		  	{
			  	document.getElementById('logradouro').value = logradouro;
		  	}
		  	document.getElementById('uf').value = uf;
			$('#loading_add').hide();
		}
		</script>
		<script>
		$(function()
		{
	    	var availableTags = ["Casa","Apartamento","Salão comercial","Terreno","Casa de condomínio","Chácara","Cobertura","Consultório","Flat","Kitnet","Sobrado","Terreno"];
				$("#tipo_imovel").autocomplete(
				{
					source: availableTags, minLength:0
				}).on('focus', function() { $(this).keydown(); });
		});
	</script>
</body>
</html>