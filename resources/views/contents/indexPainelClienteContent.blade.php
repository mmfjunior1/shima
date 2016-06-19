@extends('master.layoutPainelCliente')
@section('title', 'Imob - Mário Miranda')
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

        <div class="col-sm-9 col-sm-offset-0 col-md-12 col-md-offset-0 col-xs-12 main" >
          <h2 class="sub-header">Meus dados</h2> 
				 <form name="formCadclientesuser" id="formCadclientesuser" class="formCad">
          	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
          	<div class="form-group">
          		<label for="nome">Nome</label><br>
          		<input type="hidden" class="form-control notEdit" name="nome" id="nome" size="45" value="{{{@$user->nome}}}">
          		{{{@$user->nome}}}
          	</div>
          	<div class="form-group">
          		<label for="rg">RG</label><br>
          		<input type="hidden" class="form-control notEdit" name="rg" id="rg" value="{{{@$user->rg}}}" readonly>
          		{{{@$user->rg}}}
          	</div>
          	<div class="form-group">
          		<label for="cpf">CPF</label><br>
          		<input type="hidden" class="form-control notEdit" name="cpf" id="cpf" value="{{{@$user->cpf}}}" readonly>
          		{{{@$user->cpf}}}
          	</div>
          	<div class="form-group">
          		<label for="cnpj">CNPJ</label><br>
          		<input type="hidden" class="form-control notEdit" name="cnpj" id="cnpj" value="{{{@$user->cnpj}}}" readonly>
          		{{{@$user->cnpj}}}
          	</div>
          	<div class="form-group">
          		<label for="cnpj">Email</label>
          		<input type="email" 	class="form-control" name="email" id="email" value="{{{@$user->email}}}">
          		<input type="hidden" 	name="painelCliente" id="painelCliente" value="true">
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
	          		<a class="btn btn-default" href="/painelCliente">Voltar</a>
		    </div>
		  </div>
          <input type="hidden" name="id" id="id" value="{{{@$user->id}}}"> 
          </form>
        </div>
      </div>
    </div>
@endsection