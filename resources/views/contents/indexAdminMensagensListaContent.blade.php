<?php
use App\helpers\Helpers;
?>
@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')
<style>
	.emailNaoLido
	{
		font-weight:bold;
	}
</style>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Mensagens&nbsp;
          </h2> 
          <form action="/admin/mensagem" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          <input type="text" placeholder="Pesquise por email ou nome" name="dado" id="dado" size="40" value="{{{$dado}}}">
          <button class="btn btn-primary" type="submit">Pesquisar</button>
          </form>
          <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                  <td width="30%" align="left">Nome</td>
                  <td width="60%">Título</td>
                  <td>Data</td>
                </tr>
              <tbody>
              	<?php foreach ($search as $value){
              		$class	= (!$value->lido  ?'class="emailNaoLido"':'');
                	echo '<tr '.$class.'>
	                  <td align="left"><a href="/admin/mensagem/show/'.@$value->id_mensagem.'">'.@$value->nome.'</a></td>
	                  <td align="left">'.@$value->titulo.'</td>
	                  <td align="left">'.Helpers::dateFormat(@$value->created_at).'</td>
	                </tr>';
                }
                ?>
              </tbody>
              <tr>
              <td colspan="3">
              {!! $search->links() !!}
              </td>
              </tr>
            </table>
          
          </div>
          
        </div>
      </div>
    </div>
@endsection