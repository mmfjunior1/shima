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
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
    
    <link href="/css/jquery-ui.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets//js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/vendor/jquery.min.js"></script>
    <script src="/js/vendor/jquery-ui.js"></script>
    <script src="/js/imobiliaria.js"></script>
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body" style="padding: 0px">
        
      </div>
     
    </div>
  </div>
</div>
    <div class="container-fluid">

	  <div class="row">
        
	@yield('content')
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery.min.js"></script>
    <script src="/js/vendor/jquery-ui.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    
    <script>
    
    $(function() {
        $( "#data1,#data2,#data3,#data4,#data5" ).datepicker(
                {dateFormat: "dd/mm/yy",
                 navigationAsDateFormat: true,
                 monthNames: [ "Janr", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez" ]});
        
	});
    </script>
    <script>
		$( document ).ready(function(){
			$('.valorReais').keypress(function (e) { 
				
			    var charCode = (typeof e.which == "number") ? e.which : e.keyCode;

			    // Firefox will trigger this even on nonprintabel chars... allow them.
			    switch (charCode) {
			        case 8: // Backspace
			        case 0: // Arrow keys, delete, etc
			            return true;
			        default:
			    }

			    var lastChar =  String.fromCharCode(charCode);

			    // Reject anything not numbers or a comma
			    if (!lastChar.match("[0-9]|[.]")) {return false;}

			    // Reject comma if 1st character or if we already have one
			    if (lastChar == "." && this.value.length == 0) {return false;}
			    if (lastChar == "." && this.value.indexOf(".") != -1) {return false;}

			    // Cut off first char if 0 and we have a comma somewhere
			    if (this.value.indexOf(".") != -1 && this.value[0] == "0") {
			        this.value = this.value.substr(1);
			    }

			    return true;
			});
			
		});
	</script>
  </body>
</html>
