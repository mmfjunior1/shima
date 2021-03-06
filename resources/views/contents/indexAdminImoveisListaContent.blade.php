@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')
		<style>
			
			table tr  td
			{
				padding:5px !important;
			}
		</style>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <form action="/admin/imoveis/search" method="post" id="formListaRegistro">
          <h2 class="sub-header">Imóveis &nbsp;
          <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          </h2>
          <input type="text" placeholder="Pesquise por cpf, CEP, bairro, rua, cidade ou estado" name="dado" id="dado" size="40" value="{{{$dado}}}">
          <button class="btn btn-primary btnbusca" type="button">Pesquisar</button>
          <a href="/admin/imoveis/cadastro" class="btn btn-primary">Incluir</a> 
          </form>
          
          <div class="table-responsive">
            <table class="table table-striped" id="grid">
              <thead>
                <tr>
                  <td width="5%" >#</td>
                  <td width="15%" >Cód. Imóvel</td>
                  <td width="10%">Preço</td>
                  <td width="30%">Tipo</td>
                  <td width="10%">Operação</td>
                  <td>Cadastrado em</td>
                  <td>Status</td>
                </tr>
              </thead>
              <tbody id="bodyGrid">
                <?php 
                foreach ($search as $value)
                { 
                	
                	
                	$data		= $value->created_at;
                	$operacao	= $value->operacao ==1?'Venda':'Locação';
                	$tipoImovel	= "";
                	$status		= $value->status =='0' || $value->status == null?'Inativo':'Ativo';
                	switch($value->tipo)
                	{
                		case 1:
                			$tipoImovel = "Casa";
                			break;
                		case 2:
                			$tipoImovel = "Apartamento";
                			break;
                		case 3:
                			$tipoImovel = "Terreno";
                			break;
                		case 4:
                			$tipoImovel = "Salão comercial";
                			break;
                		case 5:
                			$tipoImovel = "Chácara";
                			break;
                		case 6:
                			$tipoImovel = "Sobrado";
                			break;
                		case 7:
                			$tipoImovel = "Kitnet";
                			break;
                		case 8:
                			$tipoImovel = "Cobertura";
                			break;
                		case 9:
                			$tipoImovel = "Casa de condomínio";
                			break;
                		case 10:
                			$tipoImovel = "Flat";
                			break;
                		case 11:
                			$tipoImovel = "Consultório";
                			break;
                	}
	                echo '<tr>
	                  <td align="left"><a href="/admin/imoveis/show/'.$value->id.'">'.$value->id.'</a></td>
                	  <td align="left"><a href="/admin/imoveis/show/'.$value->id.'">'.$value->codigo_imobiliaria.'</a></td>
	                  <td align="left">'.$value->valor_imovel.' </td>
	                  <td align="left">'.$tipoImovel.'</td>
              		   <td align="left">'.$operacao.'</td>
	                  <td>'.$data.'</td>
                  	  <td>'.$status.'</td>
	                </tr>';
                }
                ?>
              </tbody>
            </table>
            
          </div>
          <div class="row linkPages">
			{!! $search->links() !!}
			</div>
        </div>
      </div>
    </div>
@endsection