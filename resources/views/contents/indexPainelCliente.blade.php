@extends('master.layoutPainelCliente')
@section('title', 'Imob - Mário Miranda')
@section('content')
<div class="col-xs-offset-0 col-sm-12 col-md-12 col-xs-12 main" >
<h2 class="sub-header">Área do cliente</h2>
<div style="margin-top:10%">
	     <div class="col-xs-12 col-md-4 glyphicon glyphicon-user opcoesPainelCliente dadosPessoais" >
			<div  class="tituloOpcaoPainelCliente">Meus dados</div>
		</div>
		<div class="col-xs-12 col-md-4 fa fa-file opcoesPainelCliente imoveisCliente" >
			<div  class="tituloOpcaoPainelCliente">Documentos</div>
		</div>
		
		<div class="col-xs-12 col-md-4 glyphicon glyphicon-usd opcoesPainelCliente financeiro" >
			<div class="tituloOpcaoPainelCliente">Financeiro</div>
		</div>
	</div>
</div>
@endsection