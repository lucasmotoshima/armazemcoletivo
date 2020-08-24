<?
			if(isset($_REQUEST['id'])){
				$hidden = array('id' => $_REQUEST['id']);
			}
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
              'style'       => 'width:520px',
            );
			$email_admin = array(
              'name'        => 'email_admin',
              'id'          => 'email_admin',
              'value'       => (isset($_REQUEST['email_admin'])?$_REQUEST['email_admin']:''),
              'style'       => 'width:520px',
            );
			$tax = array(
              'name'        => 'tax',
              'id'          => 'tax',
              'value'       => (isset($_REQUEST['tax'])?$_REQUEST['tax']:'0'),
              'style'       => 'width:520px',
              'placeholder' => '%',
            );
			
			$range1 = array(
              'name'        => 'range1',
              'id'          => 'range1',
              'value'       => (isset($_REQUEST['range1'])?$_REQUEST['range1']:''),
              'style'       => 'width:152px',
              'placeholder' => 'CHP(%)',
            );	
			$range1_ini = array(
              'name'        => 'range1_ini',
              'id'          => 'range1_ini',
              'value'       => (isset($_REQUEST['range1_ini'])?$_REQUEST['range1_ini']:''),
              'style'       => 'width:70px',
              'placeholder' => 'inicio',
            );	
			$range1_fin = array(
              'name'        => 'range1_fin',
              'id'          => 'range1_fin',
              'value'       => (isset($_REQUEST['range1_fin'])?$_REQUEST['range1_fin']:''),
              'style'       => 'width:70px',
              'placeholder' => 'fin',
            );
			$range2 = array(
              'name'        => 'range2',
              'id'          => 'range2',
              'value'       => (isset($_REQUEST['range2'])?$_REQUEST['range2']:''),
              'style'       => 'width:152px',
              'placeholder' => 'CHP(%)',
            );	
			$range2_ini = array(
              'name'        => 'range2_ini',
              'id'          => 'range2_ini',
              'value'       => (isset($_REQUEST['range2_ini'])?$_REQUEST['range2_ini']:''),
              'style'       => 'width:70px',
              'placeholder' => 'inicio',
			  'readonly'	=> 'readonly',
            );	
			$range2_fin = array(
              'name'        => 'range2_fin',
              'id'          => 'range2_fin',
              'value'       => (isset($_REQUEST['range2_fin'])?$_REQUEST['range2_fin']:''),
              'style'       => 'width:70px',
              'placeholder' => 'fin',
            );	
			$range3 = array(
              'name'        => 'range3',
              'id'          => 'range3',
              'value'       => (isset($_REQUEST['range3'])?$_REQUEST['range3']:''),
              'style'       => 'width:152px',
              'placeholder' => 'CHP(%)',
            );	
			$range3_ini = array(
              'name'        => 'range3_ini',
              'id'          => 'range3_ini',
              'value'       => (isset($_REQUEST['range3_ini'])?$_REQUEST['range3_ini']:''),
              'style'       => 'width:70px',
              'placeholder' => 'inicio',
              'readonly'	=> 'readonly',
            );	
			$range3_fin = array(
              'name'        => 'range3_fin',
              'id'          => 'range3_fin',
              'value'       => (isset($_REQUEST['range3_fin'])?$_REQUEST['range3_fin']:''),
              'style'       => 'width:70px',
              'placeholder' => 'fin',
            );	
			$range4 = array(
              'name'        => 'range4',
              'id'          => 'range4',
              'value'       => (isset($_REQUEST['range4'])?$_REQUEST['range4']:''),
              'style'       => 'width:152px',
              'placeholder' => 'CHP(%)',
            );	
			$range4_ini = array(
              'name'        => 'range4_ini',
              'id'          => 'range4_ini',
              'value'       => (isset($_REQUEST['range4_ini'])?$_REQUEST['range4_ini']:''),
              'style'       => 'width:70px; float:left',
              'placeholder' => 'inicio',
              'readonly'	=> 'readonly',
            );	
			//========CAMPOS EM DESTAQUE (VALIDACAO)==============
			if(isset($input_error))
			{
				if(in_array('tax', $input_error))
					$tax['class'] = 'target';
					
				if(in_array('range1_fin', $input_error))
					$range1_fin['class'] = 'target';
				if(in_array('range1', $input_error))
					$range1['class'] = 'target';
					
				if(in_array('range2_fin', $input_error))
					$range2_fin['class'] = 'target';
				if(in_array('range2', $input_error))
					$range2['class'] = 'target';
				
				if(in_array('range3_fin', $input_error))
					$range3_fin['class'] = 'target';
				if(in_array('range3', $input_error))
					$range3['class'] = 'target';
				
				if(in_array('range4', $input_error))
					$range4['class'] = 'target';
			}
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#configForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#projeto" ).val() == "" ) {
				msg = msg + 'Nombre del Sistema ';
				$("#projeto" ).attr('class','target');
				erro = true;
			}
			if ( $("#tax" ).val() == "" ) {
				msg = msg + 'Impuesto ';
				$("#tax" ).attr('class','target');
				erro = true;
			}
			if ( $("#email_admin" ).val() == "" ) {
				msg = msg + 'Nombre del Sistema ';
				$("#email_admin" ).attr('class','target');
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
    	
	$('#range1_fin').keyup(function(){
		if($('#range1_fin').val()!='')
			$('#range2_ini').attr('value',parseInt($('#range1_fin').val())+1); 
		else
			$('#range2_ini').attr('value',0);
	});
	$('#range2_fin').keyup(function(){
		if($('#range2_fin').val()!='')
			$('#range3_ini').attr('value',parseInt($('#range2_fin').val())+1); 
		else
			$('#range3_ini').attr('value',0);
	});
	$('#range3_fin').keyup(function(){
		if($('#range3_fin').val()!='')
			$('#range4_ini').attr('value',parseInt($('#range3_fin').val())+1);
		else
			$('#range4_ini').attr('value',0);
	});
	$('#range4_fin').keyup(function(){
		if($('#range4_fin').val()!='')
			$('#range5_ini').attr('value',parseInt($('#range4_fin').val())+1);
		else
			$('#range5_ini').attr('value',0);
	});
    });
 </script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label>Configuraciones del Sistema</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'configForm', 'id' => 'configForm','enctype'=>'multipart/form-data');?>
					<?=form_open('config/save',$attributes,isset($hidden)?$hidden:'');?>
					<table>
						<tr>
							<th colspan="2" align="center">Configuraciones Gerais</th>
						</tr>
						<tr>
							<td width="160"><p>Nome do Projeto</p></td>
							<td><p><?=form_input($name)?></p></td>
						</tr>
						<tr>
							<td><p>Email de Autenticación</p></td>
							<td><p><?=form_input($email_admin)?></p></td>
						</tr>
						<tr>
							<td><p>Impuesto  (%)</p></td>
							<td><p><?=form_input($tax)?></p></td>
						</tr>
						<tr>
							<td>
								Logo
							</td>
							<td>
								<input name="logofile" id="logofile" type="file" value="" style="width: 520px;"/>
							</td>
						</tr>
						<!--tr>
							<td>
								Imagem de Background
							</td>
							<td>
								<input name="bgfile" id="bgfile" type="file" value="" style="width: 520px;"/>
							</td>
						</tr-->
					</table>
					
					<table>
						<tr>
							<th colspan="12" align="center">Rangos de Ganâncias</th>
						</tr>
						<tr>
							<th colspan="2" align="center"><?=form_input($range1)?></th>
							<th colspan="2" align="center"><?=form_input($range2)?></th>
							<th colspan="2" align="center"><?=form_input($range3)?></th>
							<th colspan="2" align="center"><?=form_input($range4)?></th>
						</tr>
						<tr>
							<th align="center"><?=form_input($range1_ini)?></th>
							<th align="center"><?=form_input($range1_fin)?></th>
							<th align="center"><?=form_input($range2_ini)?></th>
							<th align="center"><?=form_input($range2_fin)?></th>
							<th align="center"><?=form_input($range3_ini)?></th>
							<th align="center"><?=form_input($range3_fin)?></th>
							<th align="center"><?=form_input($range4_ini)?></th>
							<th align="center">...</th>
						</tr>
					</table>
					
					<table border=0>
						<tr>				
							<td align="left">
                                <button type="reset" id="reset" class="enviar">Limpar</button>
                                <button type="submit" id="salvar" class="enviar">Salvar</button>
							</td>
						</tr>
					</table>
					<?=form_close()?>
				</div>
			</div>
