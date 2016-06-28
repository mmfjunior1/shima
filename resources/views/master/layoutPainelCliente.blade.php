<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ><title>@yield('title')</title>-->
	<title>Imobiliaria Shima - {{$user->nome}}</title>
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
    
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets//js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>
	
	<link type="text/css" rel="stylesheet" href="/css/jquery.bxslider.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	.h1, .h2, .h3, h1, h2, h3 {
		    margin-bottom: 10px;
		    margin-top: 5px;
		}
    </style>
  </head>

  <body>
  <div style="border:1px solid;background: yellow;font-weight:bold;position:absolute;z-index:9999;left:45%;display:none;" id="divProcessando">Processando...</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mensagem do sistema</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnOkModal">Ok</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/painelCliente">Imobit - {{$user->nome}}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="/">Acessar o site</a></li>
            <li><a href="/painelCliente/dados">Minha conta</a></li>
            <!--  <li><a href="#">Settings</a></li> -->
            <!-- <li><a href="#">Profile</a></li>-->
            <li><a href="/painelCliente/sair">Sair</a></li>
          </ul>
         <!--  <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
           -->
        </div>
      </div>
    </nav>
    <div class="container-fluid">

	  <div class="row">
        <!-- <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Menu <span class="sr-only">(current)</span></a></li>
            <li><a href="/admin/clientes">Cadastro de clientes</a></li>
            <!-- <li><a href="/admin/imoveis">Cadastro de imóveis</a></li> -->
           <!--  <li><a href="/admin/aluguel">Gestão de alugueis</a></li>
          </ul>
        </div>-->
     
	@yield('content')
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery.min.js"></script>
    
    <script src="/js/bootstrap.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    <script src="/js/imobiliaria.js"></script>
    <script src="/js/vendor/jquery.bxslider.min.js"></script>
    <script>
		$(".dadosPessoais").click(function(){
			window.location.href='/painelCliente/dados';
		});
		$(".financeiro").click(function(){
			window.location.href='/painelCliente/financeiro';
		});
		$(".imoveisCliente").click(function(){
			window.location.href='/painelCliente/documentos';
		});
		$(".alugueis").click(function(){
			window.location.href='/painelCliente/alugueis';
		});
		$(".alugueisReceber").click(function(){
			window.location.href='/painelCliente/alugueis_a_receber';
		});
		$(".voltar").click(function(){
			window.location.href='/painelCliente';
		});
    </script>
    <script>
	$(document).ready(function(){
		$('.slider1').bxSlider({
	    	minSlides: 1,
	  	});
	  $(".results").css("visibility","visible");
	});
	</script>
  </body>
</html>
