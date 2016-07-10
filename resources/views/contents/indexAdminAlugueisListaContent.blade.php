@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Imóveis alugados &nbsp;
          </h2> 
          <form action="/admin/aluguel" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          <input type="text" placeholder="Pesquise por cpf,nome ou código do imóvel" name="dado" id="dado" size="40" value="{{{$dado}}}">
          <button class="btn btn-primary" type="submit">Pesquisar</button>
          </form>
          <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                  <td width="10%" align="left">#</td>
                  <td width="50%">Cliente</td>
                  <td width="20%">Cód. Imóvel</td>
                  <td>Valor do aluguel</td>
                </tr>
              <tbody>
              	<?php foreach ($search as $value){
                	echo '<tr>
	                  <td align="left"><a href="/admin/aluguel/show/'.@$value->id.'">'.@$value->id.'</a></td>
	                  <td align="left">'.@$value->nome.'</td>
          				<td align="left"><a href="/admin/aluguel/show/'.@$value->id.'">'.@$value->codigo_imobiliaria.'</a></td>
	                  <td align="left">'.@$value->valor_imovel.'</td>
	                </tr>';
                }
                ?>
              </tbody>
              <tr><td colspan="4">{!! $search->links() !!}</td></tr>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection