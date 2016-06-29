@extends('master.layout')

@section('content')

@section('title', "Agradecemos seu contato - Imobiliaria Shima")
<style>
	.preco  {
    color: #E92922 !important;
    font-size: 2.5em !important;
    font-weight: bold !important;
    line-height: 1em !important;
    margin: 0 0 20px !important;
    background-color: none !important;
	}
	.labelFormContato
	{
		color: #444;
		padding-top:60% !important;
	}
	table.form {
    	border: 0 none;
    	width: 100%;
	}
	table input
	{
		 background: #fff none repeat scroll 0 0;
	    border: 1px solid #ccc;
	    border-radius: 5px;
	    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	    box-sizing: border-box;
	    color: #444;
	    display: block;
	    font-family: "Open Sans",Arial,sans-serif;
	    font-size: 1em;
	    font-weight: 400;
	    height: 34px;
	    line-height: 1.4;
	    padding: 5px 10px;
	    width: 100%;
	}
	table textarea
	{
		width: 100%;
		height: 100px;
	}
	table.form td label {
	    font-size: 0.85em;
	    text-align: left;
	    color: #444 !important;
	}
	
	table.form td {
    	padding: 5px 10px 5px 0;
    	vertical-align: middle;
	}
	.btnContato
	{
		width:100%;
		height:40px;
	}
	.conteinerAnuncio
	{
		width:95%;
	}
	.h3Anuncio
	{
		margin-bottom: 15px;
    	margin-top: 15px;
	}
	
	.col-md-3 li
	{
		color:#555555;
		list-style:none;
		text-align:left;
		font-size:20px;
		line-height:2.865em;;
		margin-left:-40px
	}
</style>
<section class="content" id="section-introduction">
	<div class="container">
	    <h2>Agradecemos o seu contato! &nbsp;<i class="fa fa-thumbs-o-up"></i></h2>
		<p>Seu contato é muito importante para nós. Responderemos em breve!</p>
		<p><a href ="/" style="background:#E92922" class="btn btn-danger">Ir para a páina principal </a></p>
	</div>
</section>


@endsection