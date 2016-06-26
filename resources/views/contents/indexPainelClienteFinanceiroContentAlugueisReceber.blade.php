@extends('master.layoutPainelCliente')
@section('title', 'Imob - Mário Miranda')
@section('content')
		<style>
			input.notEdit{
				width:80%;
				height:30px;
				visibility:hidden;
			}
			table tr  td
			{
				padding:5px !important;
			}
			.main .row{
				line-height:40px;
			}
			.cabecalho
			{
				font-weight:bold;
			}
		</style>
		<div class="col-xs-offset-0 col-sm-12 col-md-12 col-xs-12 main" >
          <h2 class="sub-header">Financeiro - Alugueis a receber</h2> 
          	@if(count($search) == 0)
				<div role="alert" class="alert alert-danger alert-dismissible fade in"> 
					<!-- button aria-label="Close" data-dismiss="alert" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>--> 
					<h4>Nenhum aluguel a receber foi encontrado.</h4> 
					<p>Não existem algueis registrados para esse imóvel até o momento. Em caso de dúvidas, entre em contato com a imobiliária.</p> 
					<p><!-- <button class="btn btn-danger" type="button">Voltar</button>--> 
					<a class="btn btn-danger" href="/painelCliente/alugueis_a_receber">Voltar</a>
					<!-- <button class="btn btn-default" type="button">Or do this</button>--> </p> 
				</div>
				@else
          	<div class="row cabecalho">
			  <div class="col-xs-3 col-md-3">Data</div>
			  <div class="col-xs-3 col-md-4">Valor</div>
			  <div class="col-xs-3 col-md-4">Situação</div>
			</div>
				
              	<?php 
              		$color= "";
              		foreach ($search as $value)
              		{
	              		$data	= Helpers::dateFormat($value->data_vencimento);//Helpers::dateFormat($value->data_vencimento);
	              		
	              		$pago	= $value->pago == 't'?'Pago':'<span style="color:red">Pendente</span>';
	              		$color	= $color == ""?"background:#F9F9F9":"";
	              		echo '<div class="row" style="'.$color.'">
			              		<div class="col-xs-3 col-md-3">'.$data.'</div>
			              		<div class="col-xs-3 col-md-4">'.Helpers::formatNumber($value->valor).'</div>
			              		<div class="col-xs-3 col-md-4">'.$pago.'</div>
			              </div>';
                	}
                ?>
                <div class="row">
				  <div class="col-xs-18 col-md-12"><a class="btn btn-default" href="/painelCliente/alugueis_a_receber">Voltar</a></div>
				</div>
				@endif
        </div>
    </div>
@endsection