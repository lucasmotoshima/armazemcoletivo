<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTsD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Author" content="aarmazemcoletivo.vbsbs.com.br">
	<title><?=$this->head->getName();?></title>
	
	<!--link rel="icon" type="image/ico" href="<?=base_url('public/images/favicon.ico')?>"/-->
		
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
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?=base_url('public/images/icos')?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
	<meta property="og:locale" content="pt_BR" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="armazemcoletivo" />
	<meta property="og:description" content="Armazém Coletivo" />
	<meta property="og:url" content="http://armazemcoletivo.vbsbs.com.br"/>
	<meta property="og:site_name" content="armazemcoletivo" />
	<meta property="og:image" content="http://armazemcoletivo.vbsbs.com.br/admin/public/images/config/logo.png" />
	<meta name="twitter:card" content="summary"/>
	<meta name="twitter:title" content="Armazem Coletivo"/>


	<!--link rel="SHORTCUT ICON" href="<?=base_url('public/images/favicon.ico')?>"/--> 
	<!--CSS-->
	<link rel="stylesheet" href="<?php echo SYS_BASE_URL; ?>public/css/style.css" type="text/css" media="all" />
	
	<!--SCRIPTS-->
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/maskedinput.js" type="text/javascript"></script>
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SYS_BASE_URL; ?>public/javascript/functions.js" type="text/javascript" charset="utf-8"></script>
	
    <!--================================ Bootstrap ================================-->
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url('assets/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?=base_url('assets/vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">
	<!--================================ Bootstrap ================================-->
	
	<script src="<?php echo base_url('assets/js/maskedinput.js'); ?>" type="text/javascript" charset="utf-8"></script>
    <!-- Custom Theme Style -->
    <link href="<?=base_url('assets/build/css/custom.css');?>" rel="stylesheet">
    
</head>

<body class="login">
<!--TOP-->
<div id="top" class="login">
	<?=$this->head->getLogo();?>
</div>
    
<!--BOX LOGIN-->
<div id="box_login">
    
    <!--FORM LOGIN-->
    <form id="form_login" action="<?=base_url('main/doLogin')?>" name="frmLogin" method="post" enctype="multipart/form-data" class='login'>
    	<input type="text" name="email" class="campo" placeholder="E-mail"/><br>
		<input type="password" name="password" class="campo" placeholder="Password" /><br>
		<a href="#" class="esqueceu">Esqueceu sua senha?</a><br>
		<input type="submit" class="enviar" value="OK"/>
        <p class="erro"><?=isset($msg)?$msg:''?></p>
    </form>
</div>

</body>
</html>		