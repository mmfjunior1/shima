@extends('master.layoutPainelCliente')
@section('title', 'Imob - Mário Miranda')
@section('content')
<div style="margin-top:10%">
	     <div class="col-xs-12 col-md-4 glyphicon glyphicon-user opcoesPainelCliente dadosPessoais" >
			<div  class="tituloOpcaoPainelCliente">Meus dados</div>
		</div>
		<div class="col-xs-12 col-md-4 glyphicon glyphicon glyphicon-book opcoesPainelCliente imoveisCliente" >
			<div  class="tituloOpcaoPainelCliente">Documentos</div>
		</div>
		
		<div class="col-xs-12 col-md-4 glyphicon glyphicon-usd opcoesPainelCliente financeiro" >
			<div class="tituloOpcaoPainelCliente">Alugueis</div>
		</div>
	</div>
@endsection