<!-- menu profile quick info -->
<div class="profile clearfix">
	<div class="profile_pic">
		<img src="<?$this->perfil->getFoto($_SESSION['adm_armazem']['user']['id']);?>" alt="<?$this->perfil->getNome($_SESSION['adm_armazem']['user']['id']);?>" class="img-circle profile_img">
	</div>
	<div class="profile_info">
		<span>Bem vindo,</span>
		<h2><?$this->perfil->getNome($_SESSION['adm_armazem']['user']['id']);?></h2>
	</div>
</div>
<!-- /menu profile quick info -->
