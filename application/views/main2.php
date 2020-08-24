
<!doctype html>
<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="Author" content="<?=base_url()?>">
	
	<title><?=isset($meta_title)?(strip_tags($meta_title)):$this->head->getNome();?> - Landing Page</title>
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
	<meta property="fb:app_id" content="<?=isset($meta_fb_id)?($meta_fb_id):'2623777591233311'?>" />
	
	<!-- Twitter Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?=isset($meta_title)?(strip_tags($meta_title)):'Armazém Coletivo'?>" >
	<meta name="twitter:description" content="<?=isset($meta_description)?(str_replace(array('<p>','</p>','<p style="card-text">'), "", strip_tags(html_entity_decode($meta_description)))):'O Armazém Coletivo oferece ao pequeno produtor uma plataforma online de vendas simples, fácil e de grande alcance. Nossa propaganda é voltada para o consumo local aproximando o consumidor do produtor.'?>">
	<meta name="twitter:image" content="<?=isset($meta_logo)?($meta_logo):'https://armazemcoletivo.com.br/public/images/logo.jpg'?>">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/carousel/">

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('public/css/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('public/css/carousel.css')?>" rel="stylesheet">
</head>
	
  <body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?=base_url()?>">
        	<img src="https://www.armazemcoletivo.com.br/admin/public/images/config/logo.png" class="logo" title="Armazém Coletivo" alt="Home">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?=base_url('')?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.armazemcoletivo.com.br/cadastroprodutor">Quero ser Parceiro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.armazemcoletivo.com.br/contact/faq">FAQ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.armazemcoletivo.com.br/contact/form">Contato/SAC</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.armazemcoletivo.com.br/contact/purpose">Nosso Propósito</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="<?=base_url('public/images/banner2.png')?>" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Clique e comece a vender agora</h1>
                <!--p>Venda seus produtos por Delivery e receba seus pedidos pelo WhatsApp.</p-->
                <p><a class="btn btn-lg btn-primary" href="#planos" role="button">Veja mais</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="<?=base_url('public/images/carousel/8.jpg')?>" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>Mostre todo o seu Cardápio</h1>
                <p>O Armazém Coletivo facilita a sua venda mostrando todo o seu cardápio e aumentando o Valor Vendido por Venda.</p>
                <!--p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p-->
              </div>
            </div>
          </div>

        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="<?=base_url('public/images/home2/share.gif')?>" alt="Generic placeholder image" width="140" height="140"-->
            <h2>Compartilhe o Link da sua loja</h2>
            <p>Compartilhando o link da sua loja você fomenta as suas redes sociais e fica mais visível para o seu público.</p>
            <p><a class="btn btn-secondary" href="https://www.armazemcoletivo.com.br/contact/faq" role="button">Ver detalhes &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="<?=base_url('public/images/home2/catalogo.gif')?>" alt="Generic placeholder image" width="140" height="140">
            <h2>Seu cliente vê todo o seu catálogo</h2>
            <p>Compartilhando o link da sua loja em Redes Sociais você mostra todos o seu Catálogo ou Carápio para seu Cliente aumendo o seu Faturamento por Venda.</p>
            <p><a class="btn btn-secondary" href="https://www.armazemcoletivo.com.br/contact/faq" role="button">Ver detalhes &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="<?=base_url('public/images/home2/whatsapp.gif')?>" alt="Generic placeholder image" width="140" height="140">
            <h2>Você recebe o pedido pelo WhatsApp</h2>
            <p>Todos os pedidos feitos dentro das lojas do Armazém Coletivo são encaminhados pelo WhatsApp para o Telefone do Produtor.</p>
            <p><a class="btn btn-secondary" href="https://www.armazemcoletivo.com.br/contact/faq" role="button">Ver detalhes &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
        
        <hr class="featurette-divider">

        <!--div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Cerca de 40% dos empresários utilizam o app para vendas, <span class="text-muted">o que representa uma grande fatia do comércio eletrônico brasileiro.</span></h2>
            <p class="lead">O especialista em marketing digital, Conrado Adolpho, afirma que o WhatsApp como ferramenta de vendas tem muita relevância mercadológica. Uma das grandes vantagens é a possibilidade de faturar mais com baixo custo de investimento.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="<?=base_url('public/images/materia1.jpg')?>" alt="Cerca de 40% dos empresários utilizam o WhatsApp.">
          </div>
        </div>
        <br><br-->
        
     	<div class="row">
         	 <div class="col-lg-12">
         	 	<center><h1>Sua Loja fica assim</h1></center>
         	 </div>
        </div>
        
	<div class="album py-5 bg-light">
        <div class="container">
          <div class="row">
          	<img src="<?=base_url('public/images/print_loja.jpg')?>" class="featurette-image img-fluid mx-auto" style="border: 5px solid #CCCCCC" />
          </div>
        </div>
      </div>
        
        <!-- START THE FEATURETTES -->


        <!--hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Dicas para começar a  <span class="text-muted">sua venda no digital.</span></h2>
            <p class="lead">Vender pela internet ainda está longe de ser uma tarefa fácil e acessível para todos. O Empreendedor digital precisa estar atento aos desafios e particularidades deste tipo de venda porque muitas vezes os sinais que nos fazem mudar de foco e direcionar nossa operação a um futuro saudável pode ficar oculto e somente vir à tona quando for tarde demais para uma retomada ou torna esta retomada inviável financeira ou administrativamente falando.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="<?=base_url('public/images/materia2.jpg')?>" alt="Dicas para começar a sua venda online.">
          </div>
        </div>

        <hr class="featurette-divider"-->

        <!-- /END THE FEATURETTES -->
        
        <hr class="featurette-divider">
        
        <div class="row">
        	
     	 <div class="col-lg-12">
     	 	<center><h1 id="planos">Nossos Planos</h1></center>
     	 	<br>
     	 </div>
        	
			<div class="col-lg-4">
		        <div class="card mb-4 box-shadow">
		        	<div class="card-header">
		            	<h4 class="my-0 font-weight-normal">Grátis</h4>
		        	</div>
		          	<div class="card-body">
		   				<h1 class="card-title pricing-card-title">R$0 <small class="text-muted">/ mês</small></h1>
		        		<ul class="list-unstyled mt-3 mb-4">
			              <li>Cadastro Prestador de Serviços</li>
			              <li>Seja encontrado 24h por dia</li>
			              <li>Tenha seu Contato disponível para Fornecedores da sua Cidade.</li>
		            	</ul>
		            	<button type="button" href="<?=base_url('contact/parceiroForm');?>" class="btn btn-lg btn-block btn-outline-primary">Preencher Formulário</button>
		          	</div>
		   		</div>
			</div>

	   		<div class="col-lg-4">
		        <div class="card mb-4 box-shadow">
		     		<div class="card-header">
		            	<h4 class="my-0 font-weight-normal">12 Meses</h4>
		          	</div>
		          	<div class="card-body">
			    		<h1 class="card-title pricing-card-title">R$35 <small class="text-muted">/ mês</small></h1>
			            <ul class="list-unstyled mt-3 mb-4">
			              <li>12 Meses de Hospedagem de Loja Online</li>
			              <li>Suporte via WhatsApp</li>
			              <li>Catálogo online</li>
			              <li>Venda 24h por dia</li>
			            </ul>
			            <a href="https://pag.ae/7WdJ31Pw6/button" class="btn btn-lg btn-block btn-outline-primary" target="_blank">Comprar</a>
		          	</div>
		        </div>
	   		</div>

	        <div class="col-lg-4">
		        <div class="card mb-4 box-shadow">
		      		<div class="card-header">
		         		<h4 class="my-0 font-weight-normal">6 Meses</h4>
		          	</div>
		          	<div class="card-body">
		           		<h1 class="card-title pricing-card-title">R$40 <small class="text-muted">/ mês</small></h1>
		            	<ul class="list-unstyled mt-3 mb-4">
		              		<li>6 Meses de Hospedagem de Loja Online</li>
		              		<li>Suporte via WhatsApp</li>
		              		<li>Catálogo online</li>
		              		<li>Venda 24h por dia</li>
		            	</ul>
		            	<a href="https://pag.ae/7WdJ22UnQ/button" class="btn btn-lg btn-block btn-outline-primary" target="_blank">Comprar</a>
		          	</div>
				</div>
	        </div>
		</div>

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Voltar ao Topo</a></p>
        <p>&copy; 2019-2020 Armazém Coletivo &middot; <a href="https://www.armazemcoletivo.com.br/cart/getTermoPrivacidade">Privacidade</a> &middot; <a href="https://www.armazemcoletivo.com.br/cart/getTermoUso">Termos de Uso</a></p>
      </footer>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<?=base_url("assets/js/vendor/jquery-slim.min.js")?>')><\/script>')</script>
    <script src="<?=base_url('public/javascript/carousel/popper.min.js')?>"></script>
    <script src="<?=base_url('public/javascript/carousel/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('public/javascript/carousel/holder.min.js')?>"></script>
  </body>
</html>
