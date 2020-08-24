<!DOCTYPE html>
<html lang="en">
  <head>
  	<?$this->load->helper('head');?>
	<script type="text/javascript">
	
	function alerta(type,msg){
		var msg1 	= '<div class="col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="alert alert-'+type+' alert-dismissible fade in" id="status" role="alert">';
		var button 	= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		var msg2 	= '<strong>'+msg+'</strong>';
		var msg3	= '</div></div></div>';
		$('.right_col').fadeIn().prepend(msg1+button+msg2+msg3);
        setTimeout(function() {
            $(".alert").fadeOut().empty();
        }, 10000);
	}	
	
    function alteraLido(id,elemento,viewName)
    {
        var iconAlerta                  = $('<img src="<?php echo base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        var iconConf                    = $('<img src="<?php echo base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
        var iconCarregando              = $('<img src="<?php echo base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
        var viewName                    = '<?php echo base_url("mensagem/alteraLido")?>';
        var valAntigo 					= $('.badge').text();
        $('#msg').html(iconCarregando);
        jQuery.ajax({
        type: "POST",
        url: viewName,
        data:   {id:id},
        dataType: 'json',
        success: function(returnedData){
            if( returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
            {
                $('#status').html(iconConf);
                $('#status').append(returnedData.msg);
                var valNovo = parseInt(valAntigo)-1;
                $('.badge').html(valNovo);
                $('#mensagem_'+id).fadeOut();
                if(valNovo=='0'){
                	$('.alert').fadeOut('slow');
                }else{
                	$('.ui-pnotify-text').html('Você tem '+valNovo+' novas mensagens.');
                }
            }
            else
            {
                $('#status').html('');
                $('#status').html(iconAlerta);
                $('#status').append(returnedData.msg);
            }
            },
            async: true
        });
    }
    
    function excluir(id,elemento,viewName)
    {
        var iconAlerta                  = $('<img src="<?php echo base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        var iconConf                    = $('<img src="<?php echo base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
        var iconCarregando              = $('<img src="<?php echo base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
        var viewName                    = '<?php echo base_url("mensagem/delete")?>';
        $('#msg').html(iconCarregando);
        jQuery.ajax({
        type: "POST",
        url: viewName,
        data:   {
                id:id
                },
        dataType: 'json',
        success: function(returnedData){
            if( returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
            {
                $('#msg_'+id).fadeOut(200);
                $('#status').html(iconConf);
                $('#status').append(returnedData.msg);
            }
            else
            {
                $('#status').html('');
                $('#status').html(iconAlerta);
                $('#status').append(returnedData.msg);
            }
            },
            async: true
        });
    }
 	</script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
      	
      	<!-- LEFT SIDEBAR -->
      	<div class="col-md-3 left_col">
      	<?//$this->load->helper('left_sidebar')?>
      	</div>
      	<!-- LEFT SIDEBAR -->

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="<?=$_SESSION['adm_armazem']['user']['name'];?>">
                  	<?$pos = strpos($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), ' ')?>
                    <?=$this->perfil->getFoto($_SESSION['adm_armazem']['user']['id']);?><?=substr($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), 0,$pos)?><?=(($pos<strlen($this->perfil->getNome($_SESSION['adm_armazem']['user']['id'])))?'...':'')?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=base_url('user/form/').$_SESSION['adm_armazem']['user']['id'];?>"> Perfil</a></li>
                    <li><a href="<?=base_url('main/logout')?>"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                  </ul>
                </li>
				<!--li role="presentation" class="dropdown"-->
              	<?if(isset($fk_unidade)){
              		$params = array('fk_funcionario_lidos'=>$_SESSION['adm_armazem']['user']['id'],'fk_unidade'=>$fk_unidade,'fk_funcionario'=>$_SESSION['adm_armazem']['user']['id']);
              	}else{
              		$params = array('fk_funcionario'=>$_SESSION['adm_armazem']['user']['id']);
              	}?>
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-envelope-o"></i>
                    <?if(isset($fk_unidade)){
                    	echo '<span class="badge bg-green">';
						echo $this->inbox->getTotMensagens($params);
						echo '</span>';
                    }?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  	<?if(isset($fk_unidade)){
                  		echo $this->inbox->showNavigation($params);
                  	}else{
                  		echo '<li><a>Nenhuma mensagem encontrada.</a></li>';
                  	}?>
                  	<?//=$this->inbox->showNavigation($params);?>
                    <?//=(isset($fk_unidade)?$this->inbox->showNavigation($params):$this->inbox->showNavigation())?>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
      	
		<link href="<?=base_url('assets/vendors/pnotify/dist/pnotify.css');?>" rel="stylesheet">
		<link href="<?=base_url('assets/vendors/pnotify/dist/pnotify.buttons.css');?>" rel="stylesheet">
		<link href="<?=base_url('assets/vendors/pnotify/dist/pnotify.nonblock.css');?>" rel="stylesheet">
      	<script src="<?=base_url('assets/vendors/pnotify/dist/pnotify.js');?>"></script>
      	<script src="<?=base_url('assets/vendors/pnotify/dist/pnotify.buttons.js');?>"></script>
      	<script src="<?=base_url('assets/vendors/pnotify/dist/pnotify.nonblock.js');?>"></script>
      	
      	<?if(isset($fk_unidade)){?>
	      	<?$getTotMensagens = $this->inbox->getTotMensagens($params);?>
	      	<?if($getTotMensagens>0){?>
				<div class="ui-pnotify dark ui-pnotify-fade-normal ui-pnotify-in ui-pnotify-fade-in ui-pnotify-move" aria-live="assertive" aria-role="alertdialog" style="display: block; width: 200px; right: 36px; top: 36px; cursor: auto;">
					<div class="alert ui-pnotify-container alert-info ui-pnotify-shadow" role="alert" style="min-height: 16px;">
						<div class="ui-pnotify-icon">
							<span class="glyphicon glyphicon-info-sign"></span>
						</div>
						<h4 class="ui-pnotify-title">Atenção</h4>
						<div class="ui-pnotify-text" aria-role="alert">
							Você tem <?=$getTotMensagens?> <?=($getTotMensagens>1)?' novas mensagens':'nova mensagem'?>.
						</div>
					</div>
				</div>
	      	<?}?>
      	<?}?>
      	
      	<?if(isset($erro)){?>
			<div class="ui-pnotify dark ui-pnotify-fade-normal ui-pnotify-in ui-pnotify-fade-in ui-pnotify-move" aria-live="assertive" aria-role="alertdialog" style="display: block; width: 200px; right: 36px; top: 36px; cursor: auto;">
				<div class="alert ui-pnotify-container alert-info ui-pnotify-shadow" role="alert" style="min-height: 16px;">
					<div class="ui-pnotify-icon">
						<span class="glyphicon glyphicon-info-sign"></span>
					</div>
					<h4 class="ui-pnotify-title">Atenção</h4>
					<div class="ui-pnotify-text" aria-role="alert">
						<?=$erro['msg']?>
					</div>
				</div>
			</div>
      	<?}?>
      	
        <div class="right_col" role="main">