<?php
use App\helpers\Helpers;
?>
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
		<form name="formCadaluguel" id="formCadaluguel" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Administração de aluguel&nbsp;<button type="button"  data-target="#modalFotos" data-toggle="modal" class="btn btn-primary"  >Incluir</button></h2> 
          	<!--  Modal maps -->
          	<div class="modal fade" id="modalFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-parcela" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Gerencidador de alguel: {{{@$search->cpf}}} - {{{@$search->nome}}}</h4>
			      </div>
			      <div class="modal-body-parcelas">
			        	<fieldset>
			            <legend>&nbsp;&nbsp;&nbsp;Parcelas</legend>
			            <table class="table tableParcelas">
			            	<tr class="tableTitulo">
			            		<td width="20%" align="center">Vencimento</td>
			            		<td width="20%" align="center">Valor</td>
			            		<td>Boleto</td>
			            	</tr>
			            	<tr>
			            		<td width="10%">
			            			<div class="input-group">
								      <input type="text" name="data[]" id="data1" class="form-control inputParcelas">
								      <div class="input-group-addon addon-pointer inputParcelas" onclick="$('#data1').focus()"><span class="glyphicon glyphicon-calendar"></span></div>
								    </div>
			            		</td>
			            		<td align="center"><input type="text" name="valor[]" id="valor1" value="{{{@$search->valor_imovel}}}" class="form-control inputParcelas valorReais " ></td>
			            		<td><input type="file" name="boleto[]" id="boleto"></td>
			            	</tr>
			            	<tr>
			            		<td>
			            			<div class="input-group">
								      <input type="text" name="data[]" id="data2" class="form-control inputParcelas" >
								      <div class="input-group-addon addon-pointer inputParcelas" onclick="$('#data2').focus()"><span class="glyphicon glyphicon-calendar"></span></div>
								    </div>
			            		</td>
			            		<td align="center"><input type="text" name="valor[]" id="valor2" value="{{{@$search->valor_imovel}}}" class="form-control inputParcelas valorReais " ></td>
			            		<td> <input type="file" name="boleto[]" ></td>
			            	</tr>
			            	<tr>
			            		<td>
			            			<div class="input-group">
								      <input type="text" name="data[]" id="data3" class="form-control inputParcelas">
								      <div class="input-group-addon addon-pointer inputParcelas" onclick="$('#data3').focus()"><span class="glyphicon glyphicon-calendar"></span></div>
								    </div>
			            		</td>
			            		<td align="center"><input type="text" name="valor[]" id="valor3" value="{{{@$search->valor_imovel}}}" class="form-control inputParcelas valorReais "></td>
			            		<td><input type="file" name="boleto[]" ></td>
			            	</tr>
			            	<tr>
			            		<td>
			            			<div class="input-group">
								      <input type="text" name="data[]" id="data4" class="form-control inputParcelas">
								      <div class="input-group-addon addon-pointer inputParcelas" onclick="$('#data4').focus()"><span class="glyphicon glyphicon-calendar"></span></div>
								    </div>
			            		</td>
			            		<td align="center"><input type="text" name="valor[]" id="valor4" value="{{{@$search->valor_imovel}}}" class="form-control inputParcelas valorReais "></td>
			            		<td><input type="file" name="boleto[]" ></td>
			            	</tr>
			            	<tr>
			            		<td>
			            			<div class="input-group">
								      <input type="text" name="data[]" id="data5"class="form-control inputParcelas" >
								      <div class="input-group-addon addon-pointer inputParcelas" onclick="$('#data5').focus()"><span class="glyphicon glyphicon-calendar"></span></div>
								    </div>
			            		</td>
			            		<td align="center"><input type="text" name="valor[]" id="valor5" value="{{{@$search->valor_imovel}}}" class="form-control inputParcelas valorReais "></td>
			            		<td><input type="file" name="boleto[]" ></td>
			            	</tr>
			            </table>
			            
			           </fieldset>
			       </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary btnCadParcela">Gerar parcelas</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			      </div>
			    </div>
			  </div>
			</div>
          <div class="table-responsive">
          	<fieldset>
            <legend>Dados do inquilino</legend>
            <input type="hidden" name="id_cliente" id="id_cliente"  value="{{{@$search->inquilino}}}">
            <input type="hidden" name="id_imovel" id="id_imovel"  value="{{{@$search->id}}}">
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
            <legend>Mensalidades &nbsp;</legend>
            <table class="table">
              <tbody>
              	<thead>
                <tr>
                  <td width="10%">#</td>
                  <td width="20%">Valor</td>
                  <td width="30%">Data de vencimento</td>
                  <td width="20%">Pago</td>
                  <td width="10%"><input type="checkbox" name="marcaTodos" onclick="marcardesmarcar(this)"></td>
                </tr>
                </thead>
                </tbody>
            </table>
           <table class="table">
           		
                <?php 
                	
	                	foreach($parcelas as $value)
	                	{
	                		$pago	= $value->pago == 't'?"Sim":"Não";
	                		$data	= explode("-",$value->data_vencimento);
	                		$data	= $data[2].'/'.$data['1'].'/'.$data[0];
	                		$selectPago		= $value->pago =='1'?'selected="selected"':'';
	                		$selectNPago	= $value->pago =='0' || $value->pago == null || $value->pago ==''?'selected="selected"':'';
	                		
	                		echo '<tr>
				                  <td width="10%">'.$value->id_lancamento.'</td>
				                  <td width="20%">'.Helpers::formatNumber($value->valor).'</td>
				                  <td width="30%">'.$data.'</td>
				                  <td width="20%"><select name="pago[]">
	        							<option value="t" '.$selectPago.' >Sim</option>
	        							<option value="f" '.$selectNPago.'>Não</option>
	        						</select></td>
				    			<td width="10%"><input class="marcar" type="checkbox" name="parcela[]" value="'.$value->id_lancamento.'" ></td>
				                </tr>';		
	                	}
                	
                ?>
             <tr><td colspan="5">{!! $parcelas->links() !!}</td></tr> 
            </table>
            
            </fieldset>
           	<table class="table">
            	<tr>
            		<td><button type="button" id="alteraAluguel" class="btn btn-primary btnCad" >Alterar</button></td>
            		<td><button type="button" id="delAluguel" class="btn btn-danger btnCad">Excluir</button></td>
            		<td><button type="button" id="btnCancCli" class="btn btn-default btnCad">Cancelar</button></td>
            		<td><a class="btn btn-default" href="/admin/aluguel">Voltar</a></td>
            	</tr>
            </table>
            <input type="hidden" name="id" id="id" value="{{{@$search->inquilino}}}"> 
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


