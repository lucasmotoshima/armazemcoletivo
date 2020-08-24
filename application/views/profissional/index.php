  <!-- Page Content -->
  <script async src="https://github.com/zenorocha/clipboard.js.git"></script>
  <div class="container">
	<br>
    <div class="row">
  		<div class="col-lg-3">
			<?php $this->load->helper('left_sidebar');?>
  		</div>
	<div class="col-lg-9">	 
	<?if(isset($profissional)){?>
		<h1 style="background-color: #e8e8e8; padding: 5px 0px 7px 10px; border-radius: 5px;"><?=$profissional[0]['namepage'];?></h1>
      	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
      			<p style="font-size: 21px;">
      				<img src="<?=base_url('admin/public/images/profissional/'.(($profissional[0]['imagem']!='')?$profissional[0]['imagem']:'default.jpg'))?>" style="border-radius: 5px;float: left;margin: 10px 20px 0px 0px;" class="d-block img-fluid" alt="<?=$profissional[0]['nome']?>"/><br>
      				<h1><?=$profissional[0]['nome'];?></h1>
					<a href="https://api.whatsapp.com/send?phone=55<?=str_replace(' ','',preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $profissional[0]['tel1']))?>&text=Oi%2C%20peguei%20seu%20contato%20pelo%20Armaz%C3%A9m%20Coletivo.%20Tudo%20bem%3F"><img src="<?=base_url('public/images/whatsapp_contato.gif')?>"></a></b><br>
					<a target="_blank" title="Compartilhar página de <?=$profissional[0]['nome'];?> no WhatsApp" href="https://api.whatsapp.com/send?text=<?=base_url('profissional/nome/'.$profissional[0]['url_friendly'])?>%20Reserve%20o%20seu%20atendimento%20aqui."><img src="<?=base_url('public/images/whatsapp_share.gif')?>"></a><br>
					<!--small style="float: right; font-size: 11px; color: #888888;"><?=base_url($profissional[0]['url_friendly'])?></small><br-->
					<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?=base_url('profissional/nome/'.$profissional[0]['url_friendly'])?>" target="_blank" title="Compartilhar página de <?=$profissional[0]['nome'];?> no Facebook"><img src="<?=base_url('public/images/facebook_share.gif')?>"></a><br>
					<b><?=$profissional[0]['email'];?></b>
					<br>
					<script type="text/javascript"> 
					$(document).ready(function(){
						$('#btncopy').click(function(){
							var copyTextarea = document.getElementById("foo");
							copyTextarea.select(); //select the text area
							document.execCommand("copy"); //copy to clipboard
							alert('URL Copiada.');
						});
					});
					</script>
					
					<!-- Target -->
					<input id="foo" style="font-size: 11px; width: 300px;" value="<?=base_url('profissional/nome/'.$profissional[0]['url_friendly'])?>">
					
					<!-- Trigger -->
					<button class="btn" id="btncopy" data-clipboard-target="#foo" style="background-color: #CCCCCC;">
					    Copiar link
					</button>
					
      			</p>	
      			<p><?=$profissional[0]['description'];?></p>
      		</div>
      	</div>
		<?//php echo $this->banner->show();?>
	<?}?>
	<div class="row">
		<div style="color: #777777; width: 100%; display: table; border: 1px solid #CCC; padding: 10px; text-align: center; margin: 0px 0px 10px 0px; background-color: #f5f5f5;">
			<a href="https://www.blog.armazemcoletivo.com.br" style="font-size: 26px; text-decoration: none; color: #777777;">
				Clique aqui e se cadastre para participar da nossa <b style="color: #FFD242;">Aula Online Grátis</b>
			</a>
		</div>
		<div class="alertaHome">Proteja-se contra a COVID-19. Siga as instruções de precaução e fique em casa. </div>
	</div>
    <div class="row">

<script type="text/javascript"> 
$(document).ready(function(){
	
	$('.phone').mask('(99) 9 9999 9999');
	
	$('.diasemana').change(function(){
		var id = $(this).attr("row");
		$('.formProfissional_'+id+'').removeAttr('style');
	});
	
	$("#contactForm").submit(function (event){
    	var msg = 'Campos obrigatórios: ';
    	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
    	var erro = false;
		if ( $("#name" ).val() == "" ) {
			msg = msg + 'Nome, ';
			erro = true;
		}
		if ( $("#email" ).val() == "" ) {
			msg = msg + 'Email, ';
			erro = true;
		}
		if( $("#termo_uso").prop('checked') == false){
			msg = msg + 'Leia e Aceite os "Termos de Uso", ';
			erro = true;
		}
		if(erro){
			alert(msg);
			event.preventDefault();
			return false;
		}
		else{
			return true;
		}
	});


});
</script>
<?php foreach($prof as $index => $row){?>
<div class="col-lg-12 col-md-12 mb-12">
    <div class="card h-100" style="width:100%">
  		<div class="card-body">
  			<h1><center>Faça a sua reserva.</center></h1>
            <!--h2><a href="<?=base_url('profissional/nome/'.$row['url_friendly'])?>"><?=$row['nome']?></a></h2-->
            <p class="card-text">
				<?php $attributes = array('name' => 'profissionalForm', 'id' => 'contactForm','enctype'=>'multipart/form-data');?>
				<?php echo form_open('profissional/reserva/'.$row['id'],$attributes,isset($hidden)?$hidden:'');?>
					<?php
						$client_name = array(
					      'name'        => 'client_name',
					      'id'          => 'client_name',
					      'value'       => (isset($_REQUEST['client_name'])?$_REQUEST['client_name']:''),
					      'class'       => 'form-control',
					    );
						$phone = array(
					      'name'        => 'phone',
					      'id'          => 'phone',
					      'value'       => (isset($_REQUEST['phone'])?$_REQUEST['phone']:''),
					      'class'       => 'form-control phone',
					    );
						$email = array(
					      'name'        => 'email',
					      'id'          => 'email',
					      'value'       => (isset($_REQUEST['email'])?$_REQUEST['email']:''),
					      'class'       => 'form-control',
					    );
						$obs = array(
					      'name'        => 'obs',
					      'id'          => 'obs',
					      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
					      'class'       => 'form-control',
					    );
					?>
					<?
					$listEspecialidades = array();
					$listEspecialidades['X'] = '';
					$i = 0;
					$r = '';
					$row['especialidades'] = explode(',', str_replace(' ', '', $row['especialidades']));
					foreach($row['especialidades'] as $i => $r):
						$listEspecialidades[$r] = $r;
					endforeach;
					?>
					<label style="margin-bottom:0; font-size: 11px;">Especialidades: </label>
					<?=form_dropdown('especilidadesList',$listEspecialidades,'','class="form-control" id="especialidade"')?>
            		<?
            		$listDiasemana['X'] = '';
					$row['diasemana'] = explode(',', $row['diasemana']);
					
					$i = $dia = $d= 0;
					do {
						//===============================
						$dia = date('d/m/Y', strtotime('+'.$i.' days', strtotime(date('d-m-Y'))));
						$d = $this->format_date->diaSemana($dia);
						//echo $d[0].'-'.$row['diasemana'][$d[0]].'<br>';
						if($row['diasemana'][$d[0]]=='1')
							$listDiasemana[$dia] = $dia.' - '.$d[1];
						//===============================
						$i++;
					} while ($i <= 7);
					?>
            		<label style="margin-bottom:0; font-size: 11px;">Selecione o dia</label>
            		<?=form_dropdown('diasemanaList',$listDiasemana,'','class="form-control diasemana" row="'.$row['id'].'" id="diasemana_'.$row['id'].'"')?>
            		<?$listDiasemana = array();?>
            		<?
            		/*
            		$horario = array();
            		for ($i = 0, $h = strtotime($row['hrinicio']); $h <= strtotime($row['hrfim']); $i++) {
            			$hrtemp 			= $this->format_date->somaMinuto(substr($row['hrinicio'], 0,5),'00:'.$row['tempoconsulta'],$i);
						$hrtemp 			= $this->format_date->somaMinuto(substr($hrtemp, 0,5),'00:'.$row['intervalo'],$i);
						$h 					= strtotime($hrtemp);
						$hrtemp 			= substr($hrtemp, 0,5);
						$horario[$hrtemp] 	= $hrtemp;
					}
					 */ 
    				$horario = array();
        			for ($i = 0; $i < $row['qtdeatendimentos']; $i++) {
            			$hrtemp 			= $this->format_date->somaMinuto(substr($row['hrinicio'], 0,5),'00:'.$row['tempoconsulta'],$i);
						$hrtemp 			= $this->format_date->somaMinuto(substr($hrtemp, 0,5),'00:'.$row['intervalo'],$i);
						$h 					= strtotime($hrtemp);
						$hrtemp 			= substr($hrtemp, 0,5);
						$horario[$hrtemp] 	= $hrtemp;
					}
            		?>
                	<div class="formProfissional_<?=$row['id']?>" style="display: block;">
                		<label style="margin-bottom:0; font-size: 11px;">Horários <small>(tempo de consulta: <b><?=$row['tempoconsulta']?> min</b>)</small></label>
                		<?=form_dropdown('horario',$horario,'','class="form-control" id="horario"'); ?>
						<label style="margin-bottom:0; font-size: 11px;">Seu nome *</label>
						<?php echo form_input($client_name)?>
						<label style="margin-bottom:0; font-size: 11px;">Seu telefone *</label>
						<?php echo form_input($phone)?>
						<label style="margin-bottom:0; font-size: 11px;">Seu e-mail *</label>
						<?php echo form_input($email)?><br>
						<input type="submit" name="Enviar" class="btn btn-success" value="enviar" id="some_name"/>
					</div>

				<?php echo form_close()?>
            </p>
 		</div>
    </div>
</div>
 <?php }?>
 <br><br>
    </div>
        <!-- /.row -->

	</div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->