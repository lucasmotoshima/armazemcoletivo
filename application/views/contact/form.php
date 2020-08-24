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
      'class'       => 'form-control',
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
<script type="text/javascript"> 
$(document).ready(function(){
	
	$('#phone').mask('(99) 9 9999 9999');
	
	$("#cartForm").submit(function (event){
    	var msg = 'Campos obligatórios: ';
    	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
    	var erro = false;
		if ( $("#client_name" ).val() == "" ) {
			msg = msg + 'Nombre, ';
			erro = true;
		}
		if ( $("#email" ).val() == "" ) {
			msg = msg + 'Email, ';
			erro = true;
		}
		if(erro){
			$("#status").html(iconAlerta).show();
			$("#status").prepend(msg);
			event.preventDefault();
			return false;
		}
		else{
			return true;
		}
	});

});
</script>
<!-- Page Content -->
<div class="container">
	<div class="row" style="text-align: center;">
		<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 30px; margin-top: 30px; padding: 30px; background-color: #FFD242;border-radius: 10px;">
			<center>
				<h2><b>Fale com a gente.</b></h2>
				<p><h4>Nós acreditamos que a empatia e a proximidade entre nós pode mudar o mundo. <br>Teremos o maior prazer em conversar com você.<h4></p>
			</center>
		</div>
	</div>
	<div class="row">
		<!-- Begin Products -->
		<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 30px; padding: 30px; background-color: #FFF;border-radius: 10px;">
			<h2>Contato<span class="title-bottom">&nbsp;</span></h2>
				<?php $attributes = array('name' => 'contactForm', 'id' => 'contactForm','enctype'=>'multipart/form-data');?>
				<?php echo form_open('contact/send',$attributes,isset($hidden)?$hidden:'');?>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Nome *</label>
						<?php echo form_input($client_name)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Telefone *</label>
						<?php echo form_input($phone)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>E-mail *</label>
						<?php echo form_input($email)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Observação *</label>
						<?php echo form_textarea($obs)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<br>
						<input type="submit" class="btn btn-success" value="Enviar"/>
						<br>
						<i>* Campos obrigatórios</i>
					</div>
				<?php echo form_close()?>
			<div class="cl">&nbsp;</div>
		</div>
		<!-- End Products -->
	</div>

</div>