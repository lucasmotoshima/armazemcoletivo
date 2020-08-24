
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
	     		<div class="col-lg-6 col-md-6 mb-6">
		            <div class="card h-50">
		            	<div class="card-img-top" style="width:100px">
		            		<img class="card-img-top" src="<?php echo base_url('admin/public/images/profissional/'.$row['imagem'])?>" alt="<?php echo $row['nome']?>">
		            	</div>
		          		<div class="card-body">
			                <h2><a href="<?=base_url('profissional/nome/'.$row['url_friendly'])?>"><?=$row['nome']?></a></h2>
			                <p class="card-text">
			                	<label>E-mail: <b><?=$row['email']?></b></label><br>
			                	<label>Atendo em: <b><?=$row['cidadenome'].'/'.$row['estado']?></b></label>
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
				                	<div class="formProfissional_<?=$row['id']?>" style="display: none;">
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