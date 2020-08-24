<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="Author" content="<?=base_url()?>">
	
	<title><?=isset($meta_title)?(strip_tags($meta_title)):$this->head->getNome();?></title>
	<meta name="description" content="<?=isset($meta_description)?(str_replace(array('<p>','</p>','<p style="card-text">'), "", strip_tags(html_entity_decode($meta_description)))):'O Armazém Coletivo oferece ao pequeno produtor uma plataforma online de vendas simples, fácil e de grande alcance. Nossa propaganda é voltada para o consumo local aproximando o consumidor do produtor.'?>">
	
	<link rel="apple-touch-icon" sizes="57x57" href="<?=base_url('public/images/icos')?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?=base_url('public/images/icos')?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url('public/images/icos')?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url('public/images/icos')?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url('public/images/icos')?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?=base_url('public/images/icos')?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?=base_url('public/images/icos')?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?=base_url('public/images/icos')?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('public/images/icos')?>/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?=base_url('public/images/icos')?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('public/images/icos')?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?=base_url('public/images/icos')?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('public/images/icos')?>/favicon-16x16.png">
	
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?=base_url('public/images/icos')?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- Google / Search Engine Tags -->
	<meta itemprop="name" content="<?=isset($meta_url)?($meta_url):'https://www.armazemcoletivo.com.br'?>">
	
	<meta itemprop="description" content="<?=isset($meta_description)?(str_replace(array('<p>','</p>','<p style="card-text">'), "", strip_tags(html_entity_decode($meta_description)))):'O Armazém Coletivo oferece ao pequeno produtor uma plataforma online de vendas simples, fácil e de grande alcance. Nossa propaganda é voltada para o consumo local aproximando o consumidor do produtor.'?>">
	
	<meta itemprop="image" content="<?=isset($meta_logo)?($meta_logo):('https://armazemcoletivo.com.br/public/images/logo.jpg')?>">
	<!-- Facebook Meta Tags -->
	<meta property="og:locale" content="pt_BR" />
	
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?=isset($meta_title)?(strip_tags($meta_title)):'Armazém Coletivo'?>" />
	<meta property="og:description" content="<?=isset($meta_description)?(str_replace(array('<p>','</p>','<p style="card-text">'), "", strip_tags(html_entity_decode($meta_description)))):'O Armazém Coletivo oferece ao pequeno produtor uma plataforma online de vendas simples, fácil e de grande alcance. Nossa propaganda é voltada para o consumo local aproximando o consumidor do produtor.'?>">
	<meta property="og:url" content="<?=isset($meta_url)?($meta_url):'http://armazemcoletivo.com.br'?>" />
	<meta property="og:site_name" content="<?=isset($meta_title)?(strip_tags($meta_title)):'Armazém Coletivo'?>" />
	<meta property="og:image" content="<?=isset($meta_logo)?($meta_logo):'https://armazemcoletivo.com.br/public/images/logo.jpg'?>" />
	<meta property="og:image:width" content="<?=isset($meta_logo_width)?($meta_logo_width):'250px'?>" />
	<meta property="og:image:height" content="<?=isset($meta_logo_height)?($meta_logo_height):'250px'?>" />
	<meta property="fb:app_id" content="<?=isset($meta_fb_id)?($meta_fb_id):'2623777591233311'?>" />
	
	
	
	<!-- Twitter Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?=isset($meta_title)?(strip_tags($meta_title)):'Armazém Coletivo'?>" >
	<meta name="twitter:description" content="<?=isset($meta_description)?(str_replace(array('<p>','</p>','<p style="card-text">'), "", strip_tags(html_entity_decode($meta_description)))):'O Armazém Coletivo oferece ao pequeno produtor uma plataforma online de vendas simples, fácil e de grande alcance. Nossa propaganda é voltada para o consumo local aproximando o consumidor do produtor.'?>">
	<meta name="twitter:image" content="<?=isset($meta_logo)?($meta_logo):'https://armazemcoletivo.com.br/public/images/logo.jpg'?>">

  	<!-- Bootstrap core CSS -->
  	<link href="<?=base_url('public/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  	<link href="<?=base_url('public/vendor/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
  
  	<!-- Custom styles for this template -->
  	<link href="<?=base_url('public/css/shop-homepage.css')?>" rel="stylesheet">
  
	<script src="<?=base_url('public/vendor/jquery/jquery.min.js')?>"></script>
	<script src="<?=base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
	<script src="<?=base_url('/admin/assets/js/maskedinput.js')?>" type="text/javascript" charset="utf-8"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173125126-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-173125126-1');
	</script>

</head>

<body>

  <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
    	<a class="navbar-brand" href="<?=base_url()?>"><?=$this->head->getLogo();?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
      	</button>
      	<div class="collapse navbar-collapse" id="navbarResponsive">
        	<a href="https://api.whatsapp.com/send?phone=5512996684440&text=Oi%2C%20peguei%20seu%20contato%20no%20Armaz%C3%A9m%20Coletivo.%20Tudo%20bem%3F"><img src="<?=base_url('public/images/contato_wp_header.png')?>"></a>
      	</div>
      	<div class="collapse navbar-collapse" id="navbarResponsive">
        	<ul class="navbar-nav ml-auto">
          		<li class="nav-item <?=((isset($controller)))?(($controller=="contactParceiro")?'active':''):('')?>">
            		<a class="nav-link" href="<?=base_url('cadastroprodutor')?>">Quero ser Parceiro</a>
          		</li>
          		<li class="nav-item <?=((isset($controller)))?(($controller=="faq")?'active':''):('')?>">
            		<a class="nav-link" href="<?=base_url('contact/faq')?>">FAQ</a>
          		</li>
          		<li class="nav-item <?=((isset($controller)))?(($controller=="contact")?'active':''):('')?>">
            		<a class="nav-link" href="<?=base_url('contact/form')?>">Contato/SAC</a>
          		</li>
          		<li class="nav-item <?=((isset($controller)))?(($controller=="porpose")?'active':''):('')?>">
            		<a class="nav-link" href="<?=base_url('contact/purpose')?>">Nosso Propósito</a>
          		</li>
          		<li class="nav-item <?=((isset($controller)))?(($controller=="pedidos")?'active':''):('')?>">
            		<a class="nav-link" href="<?=base_url('cart/getPedidos')?>">Minhas Vendas</a>
          		</li>
        	</ul>
      	</div>
		<a href="<?=base_url('cart/detail')?>" title="Carro de Compras">
			<div id='ico_carro' style="border-radius: 5px; border: 1px solid #CCC; padding: 10px 15px 10px 10px; background-color: #ca9a00;">
				<img src="<?=base_url('public/images/icones/carro.png')?>">
			</div>
		</a>
	</div>
</nav>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
	var OneSignal = window.OneSignal || [];
	OneSignal.push(function() {
	  OneSignal.init({
	    appId: "1383e9c9-3381-4a8c-8702-7b7a2ed0b5c2",
	        notifyButton: {
	          enable: true,
	        },
	      });
	      OneSignal.showNativePrompt();
	    });
  </script>