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
				padding:0px !important;
			}
			.modal-dialog-parcela {
		   		width: 100%;
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
				border:0px;
			}
			.modal-body-parcelas
			{
				padding:10px;
			}
			input
			{
				width:40%;
			}
		</style>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Dados da mensagem</h2> 
			<form name="formCadmensagem" id="formCadmensagem" class="formCad">
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			<table class="table">
				<tbody>
					<tr>
						<td>Nome:</td>
						<td>{{{@$search->nome}}}<input type="hidden" name="nome" id="nome" value="{{{@$search->nome}}}" ></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td>{{{@$search->email}}}<input type="hidden" name="email" id="email" value="{{{@$search->email}}}" ></td>
					</tr>
					<tr>
						<td>Título:</td>
						<td>{{{@$search->titulo}}}</td>
					</tr>
					<tr>
						<td>Mensagem:</td>
						<td>{{{@$search->mensagem}}}</td>
					</tr>
					<tr>
						<td>Resposta:</td>
						<td><textarea name="mensagem" id="mensagem" rows="5" cols="90" placeholder="Mensagem"></textarea></td>
					</tr>
				</tbody>
			</table>
          
          	<div class="form-group">
		    <div class="col-xs-offset-0 col-sm-10 col-md-10 col-xs-11">
			      	<button type="button" 	id="btnCadCli" class="btn btn-primary btnCad" >Enviar</button>
	          		<button type="reset" 	id="btnCancCli" class="btn btn-warning btnCad">Cancelar</button>
	          		<button type="button" 	id="btnDelCli" class="btn btn-danger btnCad">Excluir</button>
	          		<a class="btn btn-default" href="/admin/mensagem">Voltar</a>
		    </div>
		  </div>
          	<input type="hidden" name="id_mensagem" id="id_mensagem" value="{{{@$search->id_mensagem}}}">
          	<input type="hidden" name="id" id="id" value="{{{@$search->id}}}">  
          </form>
        </div>
      </div>
    </div>
    
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
    function marcardesmarcar(obj) 
    {
        if(obj.checked == true)
        {
        	$('.marcar').each(function () {
        		this.checked = true;
            });
        }
        else
        {
        	$('.marcar').each(function () {
        		this.checked = false;
            });
        }
    }
    </script>
    
@endsection


