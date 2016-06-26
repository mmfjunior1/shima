@extends('master.layoutPainelCliente')
@section('title', 'Imob - Mário Miranda')
@section('content')
<style>
@font-face { 
	font-family: 'metro'; 
	src: url('metro-icons-fixed-2000-webfont.eot?x=1351252202'); 
	src: url('metro-icons-fixed-2000-webfont.eot?#iefix') format('embedded-opentype'),  url('metro-icons-fixed-2000-webfont.woff?x=1351252202') format('woff'),  url('metro-icons-fixed-2000-webfont.ttf?x=1351252202') format('truetype'),  url('metro-icons-fixed-2000-webfont.svg?x=1351252202#metroicons8-3regular') format('svg'); 
	font-weight: normal; 
	font-style: normal; }
</style>
		<div class="col-xs-offset-0 col-sm-12 col-md-12 col-xs-12 main" >
          <h2 class="sub-header">Financeiro - Contas a pagar e receber</h2> 
          	
			<div style="margin-top:10%">
			     <div class="col-xs-12 col-md-4 fa fa-money fa-1x  opcoesPainelCliente alugueisReceber" >
			     	<div  class="fa fa-arrow-left fa-1x" style="font-size: 30px;"></div>
					<div  class="tituloOpcaoPainelCliente">Alugueis a receber</div>
				</div>
				<div class="col-xs-12 col-md-4 fa fa-money fa-1x opcoesPainelCliente alugueis" >
					<div  class="fa fa-arrow-right fa-1x" style="font-size: 30px;"></div>
					<div  class="tituloOpcaoPainelCliente">Alugueis a pagar</div>
				</div>
				<div class="col-xs-12 col-md-4 fa fa-undo fa-1x opcoesPainelCliente voltar" >
					<div  class="tituloOpcaoPainelCliente">Voltar</div>
				</div>

			</div>		
        </div>
    </div>
@endsection