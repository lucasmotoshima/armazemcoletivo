<div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
		<div style="text-align: center;">
			<a href="<?=base_url();?>" class="site_title">
				<h3><?=$this->head->getNome();?></h3>
			</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<!-- menu profile quick info -->
	<div class="profile clearfix">
		<div class="profile_pic">
			<img src='<?=$this->perfil->getFotoUrl($_SESSION['adm_armazem']['user']['id']);?>' alt="<?=$this->perfil->getNome($_SESSION['adm_armazem']['user']['id']);?>" class="img-circle profile_img" />
		</div>
		<div class="profile_info">
			<?$pos = strpos($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), ' ')?>
			<span>Olá, <h2><?=substr($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), 0,$pos)?></h2></span>
		</div>
	</div>
	
	<!-- /menu profile quick info -->
	<br />
	
	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
		<?=$this->menu->show();?>
	</div>
	<!-- sidebar menu -->
	
	<div class="sidebar-footer hidden-small">
		<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
		<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
		</a>
		<a data-toggle="tooltip" data-placement="top" title="" data-original-title="FullScreen">
		<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
		</a>
		<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Lock">
		<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
		</a>
		<a data-toggle="tooltip" data-placement="top" title="" href="login.html" data-original-title="Logout">
		<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
		</a>
	</div>
</div>