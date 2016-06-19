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
		   		width: 70%;
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
			
			.inputParcelas
			{
				height:25px;
				padding: 0px 12px !important;
			}
			.tableParcelas tr td
			{
				padding:5px !important;
			}
			.tableTitulo
			{
				font-weight:bold;
			}
			.addon-pointer
			{
				cursor:pointer;
			}
			
		</style>
		<form name="formCaddocs" id="formCaddocs" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Administração de documentos&nbsp;<button type="button"  data-target="#modalDocs" data-toggle="modal" class="btn btn-primary"  >Incluir</button></h2> 
          	<!--  Modal maps -->
          	<div class="modal fade" id="modalDocs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-parcela" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Gerencidador de documentos: {{{@$search->cpf}}} - {{{@$search->nome}}}</h4>
			      </div>
			      <div class="modal-body-parcelas">
			        	<fieldset>
			            <legend>&nbsp;&nbsp;&nbsp;Documentos</legend>
			            <table class="table tableParcelas">
			            	<tr class="tableTitulo">
			            		<td width="40%" align="left">Titulo do documento</td>
			            		<td>Documento</td>
			            	</tr>
			            	<tr>
			            		<td width="40%">
			            			  <input type="text" name="titulo[]" maxlength="20" id="titulo1" class="form-control inputParcelas">
								</td>
			            		<td><input type="file" name="documento[]" id="documento1"></td>
			            	</tr>
			            	<tr>
			            		<td width="40%">
			            			  <input type="text" name="titulo[]" maxlength="20" id="titulo2" class="form-control inputParcelas">
								</td>
			            		<td><input type="file" name="documento[]" id="documento2"></td>
			            	</tr>
			            	<tr>
			            		<td width="40%">
			            			  <input type="text" name="titulo[]" maxlength="20" id="titulo3" class="form-control inputParcelas">
								</td>
			            		<td><input type="file" name="documento[]" id="documento3"></td>
			            	</tr>
			            	<tr>
			            		<td width="40%">
			            			  <input type="text" name="titulo[]" maxlength="20" id="titulo4" class="form-control inputParcelas">
								</td>
			            		<td><input type="file" name="documento[]" id="documento4"></td>
			            	</tr>
			            	<tr>
			            		<td width="40%">
			            			  <input type="text" name="titulo[]" maxlength="20" id="titulo5" class="form-control inputParcelas">
								</td>
			            		<td><input type="file" name="documento[]" id="documento5"></td>
			            	</tr>
			            </table>
			           </fieldset>
			       </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary btnCadDocumento">Enviar documentos</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			      </div>
			    </div>
			  </div>
			</div>
          <div class="table-responsive">
          	<fieldset>
            <legend>Dados do inquilino</legend>
            <input type="hidden" name="id_cliente" id="id_cliente"  value="{{{@$search->id}}}">
            <table class="table">
              <tbody>
                <tr>
                  <td width="13%">CPF/Nome:</td>
                  <td width="20%">{{{@$search->cpf}}}</td> 
                  <td colspan="5">{{{@$search->nome}}}</td>
                </tr>
            </table>
            </fieldset>
            <fieldset>
            <legend>Documentos &nbsp;</legend>
            <table class="table">
              <tbody>
              	<thead>
                <tr>
                  <td width="10%">#</td>
                  <td width="85%">Título</td>
                  <td width="5%"><input type="checkbox" name="marcaTodos" onclick="marcardesmarcar(this)"></td>
                </tr>
                </thead>
                </tbody>
            </table>
           <table class="table">
           		
                <?php 
                	
	                foreach($documentos as $value)
	                {
                		echo '<tr>
			                  <td width="10%">'.$value->id_documento.'</td>
			                  <td width="85%">'.$value->titulo.'</td>
				              <td width="10%"><input class="marcar" type="checkbox" name="documentoLista['.$value->arquivo.']" value="'.$value->id_documento.'" ></td>
			                </tr>';		
	                }
                	
                ?>
                
            </table>
            <div class="row">
            	{!! $documentos->links() !!}
            </div>
            </fieldset>
           	<table class="table">
            	<tr>
            		<td width="10%"><button type="button" id="delDoc" class="btn btn-danger btnCad">Excluir</button></td>
            		<td><a class="btn btn-default" href="/admin/docs">Voltar</a></td>
            	</tr>
            </table>
            <input type="hidden" name="id" id="id" value="{{{@$search->id_cliente}}}"> 
          </div>
        </div>
        </form>
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
    document.ready = function (){
		alert("A");
      }
    </script>
    
@endsection


