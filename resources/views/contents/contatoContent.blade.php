@extends('master.layout')
@section('title', 'Os melhores imóveis de São Paulo e região com excelentes preços - Imobiliaria Shima')
@section('content')

<section class="jumbotron jumbotron5 contato contatoForm" style="height:350px">
	
	<div class="container" >
		<div class="row">
			<div class="container">
				
				<div class="row">
	                <h2>FALE CONOSCO</h2>
	                <p>Se preferir ligue para nós:<strong>+55 (11) 3328-6022</strong></p>  
					<fieldset>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" name="contact_name1" id="contact_name1" placeholder="Nome:" class="form-control ">
                                	<div class="error" id="error_contact_name1"></div>
                                </div>                               
                            </div>
                            <div class="row">
                            	<div class="form-group col-sm-12">
									<input type="text" name="contact_email1" id="contact_email1" placeholder="E-mail:" class="form-control ">
                              		<div class="error" id="error_contact_email1"></div>
								</div>
                            </div>
                            <div class="row">
								<div class="form-group col-sm-12">
                                    <textarea name="contact_message1" id="contact_message1" placeholder="Mensagem:" class="form-control"></textarea>
                                    <div class="error" id="error_contact_message1"></div>
                                    <button style="background:#E92922" type="submit" id="btn_front_search" name="btn_front_search" class="send-now"><i class="fa fa-envelope"></i>&nbsp;Enviar</button>
                                </div>
                            </div>
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
