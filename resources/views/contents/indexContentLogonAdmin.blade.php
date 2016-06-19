@extends('master.layoutLogonFail')
@section('title', 'Acesso ao painel - Imobiliaria Shima')
@section('content')
<section class="jumbotron jumbotron5 jumbotron5LogonFail" style="height:450px">
	<div class="container" >
		<div class="row">
			<div class="container">
				<div class="row">
	                <div  class="col-md-4"></div>
    	            <div class="col-md-8" style="width:100%; margin-top:12%">
        		        <form name="frm_main_searching" id="frm_main_searching" method="post" method="post" action="/logonSistema">
        		        	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                		    <div class="search-job">
        						<div class="search-job-inner" style="margin-top: 27px; background-color:rgba(29, 29, 29, 0.32)">
	                       			<h1 class="text-center" style="margin-bottom:0px; margin-top:0px !important; font-size:29px; background:none; width:100%; text-align: center; padding:0px;       color:white; margin-bottom:15px">Acesso ao painel administrativo</h1> 
									 <div class="search-fild" style="border-radius: 5px 0px 0px 5px;">
	                 					<input name="email" id="email" placeholder="email" class="select-search" style="text-align:center ; border-radius: 5px 0 0 5px; font-size:17px" />
	          	    				</div>
		    			             <div class="search-fild">
		                				<input id="password" name="password" class="select-search" placeholder="senha" type="password" style="text-align:center;font-size:17px">
		               		 		</div>
				                    <input type="hidden" id="logradouro" name="logradouro" value="" />
		                		<div class="search-fild-last">
									<button class="search-now" name="btn_front_search" id="btn_front_search" type="submit" style="background:#E92922">entrar</button>
								</div>  
		            	  		<div class="clr"></div>
            				</div>
       				 	</div>
                    </form>
                </div>  
					<div class="col-md-12" style="text-align:center">
						<br>
						<br>
	                </div>
                </div>  
			</div>
        </div>
	</div>
</section>
<!-- <section class="content" id="section-introduction">
	<div class="container">
	    <h2>O melhor imóvel está aqui!</h2>
		<p>Nós temos os melhores imóveis. Garantimos isso pois selecionamos, um a um, os imóveis anunciados, unindo qualidade com o melhor preço. Confira!</p>
	</div>
</section>
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>Quer vender ou alugar seu imóvel? Fale com a gente!</h2>
		<p>Se você tem um imóvel e deseja fazer negócio com ele, deixe que a Imobiliária Shima cuide de tudo. Iremos analisar seu imóvel e dispor em nossa plataforma. Você não paga para anunciar com a gente!</p>
	</div>
</section>
-->
@endsection