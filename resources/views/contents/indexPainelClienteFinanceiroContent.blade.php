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
          <h2 class="sub-header">Financeiro - Alugueis</h2> 
          	@if(count($search) == 0)
				<div role="alert" class="alert alert-danger alert-dismissible fade in"> 
					<!-- button aria-label="Close" data-dismiss="alert" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>--> 
					<h4>Nenhum imóvel alugado foi encontrado.</h4> 
					<p>Não existem imóveis alugados por você até o momento. Em caso de dúvidas, entre em contato com a imobiliária.</p> 
					<p><!-- <button class="btn btn-danger" type="button">Voltar</button>--> 
					<a class="btn btn-danger" href="/painelCliente">Voltar</a>
					<!-- <button class="btn btn-default" type="button">Or do this</button>--> </p> 
				</div>
				@else
          		<table class="table table-striped"> 
					<thead> 
						<tr> 
							<th width="50%">Endereço</th> 
							<th width="40%">Valor do aluguel</th> 
							<th>&nbsp;</th> 
						</tr> 
					</thead> 
					<tbody> 
				<?php 
              		$color= "";
              		foreach ($search as $value)
              		{
	              		$data	= Helpers::dateFormat($value->data_vencimento);//Helpers::dateFormat($value->data_vencimento);
	              		$pago	= $value->pago == 't'?'Pago':'<span style="color:red">Pendente</span>';
	              		echo '<tr> 
							<td>'.$value->logradouro.', '.$value->numero.' - '.$value->localidade.'</td> 
							<td>'.Helpers::formatNumber($value->valor_imovel).'</td> 
							<td><a href="/painelCliente/financeiro/'.$value->id.'">Alugueis</a></td> 
						</tr>';
                	}
                ?>
                	</tbody> 
				</table>
				<div class="row">
					{!! $search->links() !!}
				</div>
                <div class="row">
				  <div class="col-xs-18 col-md-12"><a class="btn btn-default" href="/painelCliente">Voltar</a></div>
				</div>
				@endif
        </div>
    </div>
@endsection