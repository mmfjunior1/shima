@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">{!!$viewDefinition['titulo']!!} &nbsp;
          </h2> 
          <form action="{{$viewDefinition['actionForm']}}" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          <input type="text" placeholder="Pesquise por cpf ou nome" name="dado" id="dado" size="40" value="{{{$dado}}}">
          <button class="btn btn-primary" type="submit">Pesquisar</button>
          {!!$viewDefinition['btnIncluir']!!}
          </form>
          <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                  <td width="10%" align="left">#</td>
                  <td width="60%">Cliente</td>
                  <td>CPF</td>
                  <td align="center">Cadastrado em</td>
                </tr>
              <tbody>
                <?php foreach ($search as $value){ 
                	$data		= $value->created_at;
                	
                	echo '<tr>
	                  <td align="left"><a href="'.$viewDefinition['urlEdit'].''.$value->id.'">'.$value->id.'</a></td>
	                  <td align="left">'.$value->nome.'</td>
	                  <td align="left">'.$value->cpf.'</td>
	                  <td align="center">'.Helpers::dateFormat($data).'</td>
	                </tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="row">{!! $search->links() !!}</div>
        </div>
      </div>
    </div>
@endsection