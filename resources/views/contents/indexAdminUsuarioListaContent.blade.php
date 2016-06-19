@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Usuários do sistema &nbsp;
          </h2> 
          <form action="/admin/usuarios" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          <input type="text" placeholder="Pesquise por nome ou login" name="dado" id="dado" size="40" value="{{{$dado}}}">
          <button class="btn btn-primary" type="submit">Pesquisar</button>
          <a class="btn btn-primary" href="/admin/usuarios/cadastro">Incluir</a>
          </form>
          <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                  <td width="10%" align="left">#</td>
                  <td width="60%">Nome</td>
                  <td>Login</td>
                  <td align="center">Cadastrado em</td>
                </tr>
              <tbody>
                <?php foreach ($search as $value){ 
                	$data		= $value->created_at;
                	echo '<tr>
	                  <td align="left"><a href="/admin/usuarios/show/'.$value->id.'">'.$value->id.'</a></td>
	                  <td align="left">'.$value->nome.'</td>
	                  <td align="left">'.$value->login.'</td>
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