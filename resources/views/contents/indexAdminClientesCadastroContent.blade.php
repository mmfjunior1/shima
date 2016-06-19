@extends('master.layoutAdmin')
@section('title', 'Imob Admin - Licenciado para Imobiliária Shima')
@section('content')
		<style>
			input{
				width:80%;
				height:30px;
			}
			table tr  td
			{
				padding:5px !important;
			}
		</style>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Cadastro - Clientes</h2> 

          <div class="table-responsive">
          	<form name="formCadclientes" id="formCadclientes" class="formCad">
          	<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>">
            <fieldset>
            <legend>Dados Básicos</legend>
            <table class="table">
              <tbody>
                <tr>
                  <td width="10%">Nome:</td>
                  <td><input type="text" name="nome" id="nome" size="45" value="{{{@$search->nome}}}"></td>
                  <td><!-- Nascimento:--></td>
                  <td colspan="5"><!-- <input type="text" name="data_nascimento" id="data_nascimento" value="{{{@$search->data_nascimento}}}">--></td>
                </tr>
                <tr>
                  <td>RG:</td>
                  <td><input type="text" name="rg" id="rg" value="{{{@$search->rg}}}"></td>
                  <td>CPF:</td>
                  <td><input type="text" name="cpf" id="cpf" value="{{{@$search->cpf}}}"></td>
                  <td>CNPJ:</td>
                  <td><input type="text" name="cnpj" id="cnpj" value="{{{@$search->cnpj}}}"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                 <tr>
                  <td>Email:</td>
                  <td><input type="email" name="email" id="email" value="{{{@$search->email}}}"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
            </table>
            </fieldset>
            <fieldset>
            <legend>Endereço e contato</legend>
            <table class="table">
              <tbody>
                <tr>
                  <td width="10%">CEP:</td>
                  <td><input type="text" name="cep" class="cep" id="cep" size="45" value="{{{@$search->cep}}}"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="10%">Endereço:</td>
                  <td><input type="text" name="logradouro" id="logradouro" value="{{{@$search->logradouro}}}"></td>
                  <td><input type="text" name="numero" id="numero" size="5" value="{{{@$search->numero}}}"></td>
                  <td>Bairro:</td>
                  <td><input type="text" name="bairro" id="bairro" value="{{{@$search->bairro}}}"></td>
                   <td>Cidade:</td>
                   <td><input type="text" name="localidade" id="localidade" value="{{{@$search->localidade}}}"></td>
                   <td>Estado:</td>
                   <td><input type="text" name="uf" id="uf" size="3" value="{{{@$search->uf}}}"></td>
                </tr>
                <tr>
                  <td width="10%">Telefone:</td>
                  <td><input type="text" name="telefone1" id="telefone1" value="{{{@$search->telefone1}}}"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
                  <td>Celular:</td>
                  <td><input type="text" name="telefone2" id="telefone2" value="{{{@$search->telefone2}}}"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
            </table>
            </fieldset>
            <table class="table">
            	<tr>
            		<td><button type="button" id="btnCadCli" class="btn btn-primary btnCad" >Gravar</button></td>
            		<td><button type="button" id="btnDelCli" class="btn btn-danger btnCad">Excluir</button></td>
            		<td><button type="button" id="btnCancCli" class="btn btn-default btnCad">Cancelar</button></td>
            		<td><a class="btn btn-default" href="/admin/clientes">Voltar</a></td>
            	</tr>
            </table>
            <input type="hidden" name="id" id="id" value="{{{@$search->id}}}"> 
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection