@extends('master.layoutAdmin')
@section('title', 'Imob - Licenciado para Imobiliária Shima')
@section('content')
		<style>
			input.notEdit{
				width:80%;
				height:30px;
				visibility:hidden;
			}
			input[type="email"],input[type="password"]
			{
				height:30px;
			}
			table tr  td
			{
				padding:5px !important;
			}
		</style>

        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-2 col-xs-10 main" >
          <h2 class="sub-header">Dados do usuário</h2> 
				 <form name="formCadusuarios" id="formCadusuarios" class="formCad">
          	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          	<div class="form-group">
          		<label for="nome">Nome</label><br>
          		<input type="text" class="form-control " name="nome" id="nome" size="45" value="{{{@$search->nome}}}">
          		
          	</div>
          	
          	<div class="form-group">
          		<label for="nome">Login</label><br>
          		<input type="text" class="form-control " name="login" id="login" size="45" value="{{{@$search->login}}}">
          		
          	</div>
          	
          	<div class="form-group">
          		<label for="cnpj">Senha</label>
          		<input type="password" 	class="form-control" name="senha" id="senha" value="">
          		<input type="hidden" 	name="painelCliente" id="painelCliente" value="true">
          	</div>
          	
          	<div class="form-group">
          		<label for="cnpj">Confirma senha</label>
          		<input type="password" 	class="form-control" name="confSenha" id="confSenha" value="">
          		<input type="hidden" 	name="painelCliente" id="painelCliente" value="true">
          	</div>
          	
          	<div class="form-group">
		    <div class="col-xs-offset-0 col-sm-10 col-md-10 col-xs-11">
			      	<button type="button" id="btnCadCli" class="btn btn-primary btnCad" >Gravar</button>
	          		<button type="button" id="btnCancCli" class="btn btn-warning btnCad">Cancelar</button>
	          		<a class="btn btn-default" href="/admin/usuarios">Voltar</a>
		    </div>
		  </div>
          <input type="hidden" name="id" id="id" value="{{{@$search->id}}}"> 
          </form>
        </div>
      </div>
    </div>
@endsection