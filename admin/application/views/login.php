<!DOCTYPE html>
<html lang="en">
  <head>
	<?php $this->load->helper('head');?>
  </head>

	<body class="login">
    	<div>
      		<a class="hiddenanchor" id="signup"></a>
      		<a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
        	<div style="text-align: center;">
        		<?=$this->head->getLogoMini();?>	
        	</div>
        	
          	<section class="login_content">
            <form id="form_login" action="<?=base_url('main/doLogin')?>" name="frmLogin" method="post" enctype="multipart/form-data" class='login'>
              <h1><?=$this->head->getNome();?></h1>
              <div>
                <input type="text" style="text-align: center" name="email" class="form-control" placeholder="E-mail" required=""/>
              </div>
              <div>
                <input type="password" style="text-align: center" name="password" class="form-control" placeholder="Password" required=""/>
              </div>
              <br />
              
              <div>
              	<a class="reset_pass" href="#">Perdeu a senha?</a>
              	<input type="submit" class="btn btn-primary" value="Entrar"/>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Novo no site?
                  <a href="#signup" class="to_register"> Criar Conta </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-bug"></i> <?=$this->head->getNome();?></h1>
                  <i class="fal fa-clinic-medical"></i>
                  <p>©2020 Todos os direitos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>
