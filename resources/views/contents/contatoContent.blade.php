@extends('master.layout')
@section('title', 'Os melhores imóveis de São Paulo e região com excelentes preços - Imobiliaria Shima')
@section('content')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Atenção</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn btn-primary" data-dismiss="modal" id="btnOkModal">Ok</button>
      </div>
    </div>
  </div>
</div>
<section class="jumbotron jumbotron5 contato contatoForm" style="height:430px">
	<div class="container" >
		<div class="row">
			<div class="container" style="padding:0px 30px 30px 30px;">
				<div class="row">
	                <h2>FALE CONOSCO</h2>
	                <p style="font-weight: 400">Ligue para <strong>(11) 2506-0305</strong><br>ou preencha o formulário abaixo.</p>  
					<fieldset>
						<form action="{{url('/obrigado')}}" method="post" id="formContato">
						<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                            <div class="row">
                                <div class="form-group col-sm-7">
                                    <input type="text" name="contact_name1" id="contact_name1" placeholder="Nome:" class="form-control " autofocus>
                                	<div class="error" id="error_contact_name1"></div>
                                </div>                               
                            </div>
                            <div class="row">
                            	<div class="form-group col-sm-7">
									<input type="text" name="telefone" id="telefone" placeholder="Telefone:" class="form-control ">
                              		<div class="error" id="error_telefone_email1"></div>
								</div>
                            </div>
                            <div class="row">
                            	<div class="form-group col-sm-7">
									<input type="text" name="contact_email1" id="contact_email1" placeholder="E-mail:" class="form-control ">
                              		<div class="error" id="error_contact_email1"></div>
								</div>
                            </div>
                            <div class="row">
								<div class="form-group col-sm-7">
                                    <textarea name="contact_message1" id="contact_message1" placeholder="Mensagem:" class="form-control"></textarea>
                                    <div class="error" id="error_contact_message1"></div>
                                    <button style="background:#E92922" type="button" id="btn_front_search" name="btn_front_search" class="send-now"><i class="fa fa-envelope fa-2x"></i>&nbsp;Enviar</button>
                                </div>
                            </div>
						</form>                           
                      </fieldset>
                </div>  
			</div>
        </div>
	</div>
</section>
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>Quer vender ou alugar seu imóvel? Fale com a gente!</h2>
		<p>Se você tem um imóvel e deseja fazer negócio com ele, deixe que a Imobiliária Shima cuide de tudo. Iremos analisar seu imóvel e dispor em nossa plataforma. Você não paga para anunciar com a gente!</p>
	</div>
</section>
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>O melhor imóvel está aqui!</h2>
		<p>Nós temos os melhores imóveis. Garantimos isso pois selecionamos, um a um, os imóveis anunciados, unindo qualidade com o melhor preço. Confira!</p>
	</div>
</section>

@endsection
