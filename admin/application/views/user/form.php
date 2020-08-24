<?
			if(isset($_REQUEST['id'])){
				$hidden = array('id' => $_REQUEST['id']);
			}
			
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
              'size'        => '50',
              'style'       => 'width:650px;',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => (isset($_REQUEST['email'])?$_REQUEST['email']:''),
              'style'       => 'width: 320px;',
			);
			$password = array(
              'name'        => 'password',
              'id'          => 'password',
              'style'       => 'width: 320px;',
			);
				
			$birthday = array(
              'name'        => 'birthday',
              'id'          => 'birthday',
              'value'       => (isset($_REQUEST['birthday'])?((isset($_REQUEST['id']))?$this->format_date->us2br($_REQUEST['birthday']):$_REQUEST['birthday']):''),
              'style'       => 'width: 210px;',
			);
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => (isset($_REQUEST['phone'])?$_REQUEST['phone']:''),
              'style'       => 'width: 210px;',
			);
			$city = array(
              'name'        => 'city',
              'id'          => 'city',
              'value'       => (isset($_REQUEST['city'])?$_REQUEST['city']:''),
              'style'       => 'width: 210px;',
			);
			$province = array(
              'name'        => 'province',
              'id'          => 'province',
              'value'       => (isset($_REQUEST['province'])?$_REQUEST['province']:''),
              'style'       => 'width: 240px;',
			);
			$country = array(
              'name'        => 'country',
              'id'          => 'country',
              'value'       => (isset($_REQUEST['country'])?$_REQUEST['country']:''),
              'style'       => 'width: 225px;',
			);
			$active = array(
              '1'  		=> 'Si',
              '0'    	=> 'No',
           	);
			$type = array(
              '1'  		=> 'Administrador',
              '0'    	=> 'Assistant',
     		);
			$obs = array(
              'name'        => 'obs',
              'id'          => 'obs',
              'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
              'style'       => 'width: 645px; height: 80px;',
			);
			
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('email', $input_error))
			$email['class'] = 'target';
	}
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#userForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Name ';
				erro = true;
			}
			if ( $("#email" ).val() == "" ) {
				msg = msg + ',Email ';
				erro = true;
			}
			if ( $("#birthday" ).val() == "" ) {
				msg = msg + ',Data de Nascimento ';
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
		$(function() {
		    $("#birthday").mask("99/99/9999");
			$('#phone').mask("+56(99) 9999-9999?9");
		});
		$("#userForm").submit(function (event){
			
		});
    });
 </script>
 
<div class>
	<div class="page-title">
  		<div class="title_left">
			<h3>Usuários</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Lista de Usuários</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'userForm', 'id' => 'userForm','enctype'=>'multipart/form-data');?>
						<?=form_open('user/save',$attributes,isset($hidden)?$hidden:'');?>						
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Nome</label>
								<?=form_input($name)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>E-mail</label>
								<?=form_input($email)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Senha</label>
								<?if(isset($_REQUEST['id']))
									echo form_password($password,(isset($_REQUEST['id'])?$_REQUEST['password']:''),(isset($_REQUEST['id'])?'readonly':''));
								else
									echo form_input($password,(isset($_REQUEST['id'])?$_REQUEST['password']:''),(isset($_REQUEST['id'])?'readonly':''));
								?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Fecha de Nacimiento</label>
								<?=form_input($birthday)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Telefono</label>
								<?=form_input($phone)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Cidade</label>
								<?=form_input($city)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Comuna</label>
								<?=form_input($province)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>País</label>
								<?=form_input($country)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Activo</label>
								<?=form_dropdown('active',$active,isset($_REQUEST['active'])?$_REQUEST['active']:'1','style="width:50px;"')?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Tipo</label>
								<?=form_dropdown('type',$type,isset($_REQUEST['type'])?$_REQUEST['type']:'1','style="width:120px;"')?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Obs</label>
								<?=form_input($obs)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <button type="reset" id="reset" class="btn btn-success">Limpar</button>
                                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
							</div>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
