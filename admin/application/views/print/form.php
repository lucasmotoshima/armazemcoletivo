<?
	if(isset($_REQUEST['id'])){
		$hidden = array('id' => $_REQUEST['id']);
	}
	
	$code = array(
      'name'        => 'code',
      'id'          => 'code',
      'value'       => (isset($_REQUEST['code'])?$_REQUEST['code']:''),
      'style'       => 'width:40px;',
      'maxlength'   => '2',
    );
	$description = array(
      'name'        => 'description',
      'id'          => 'description',
      'value'       => (isset($_REQUEST['description'])?$_REQUEST['description']:''),
      'style'       => 'width:655px;',
    );
	$name = array(
      'name'        => 'name',
      'id'          => 'name',
      'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
      'style'       => 'width:655px;',
    );
	$qty_max_color = array(
      'name'        => 'qty_max_color',
      'id'          => 'qty_max_color',
      'value'       => (isset($_REQUEST['qty_max_color'])?$_REQUEST['qty_max_color']:''),
      'style'       => 'width:60px;',
      'maxlength'   => '3',
      'placeholder' => 'Qtde',
    );
	$qty_limit = array(
      'name'        => 'qty_limit',
      'id'          => 'qty_limit',
      'value'       => (isset($_REQUEST['qty_limit'])?$_REQUEST['qty_limit']:''),
      'style'       => 'width:60px;',
      'maxlength'   => '5',
      'placeholder' => 'Qtde',
    );
	$amount_limit = array(
      'name'        => 'amount_limit',
      'id'          => 'amount_limit',
      'value'       => (isset($_REQUEST['amount_limit'])?$_REQUEST['amount_limit']:''),
      'style'       => 'width:60px;',
      'placeholder' => '$',
    );
	$range1_start = array(
      'name'        => 'range1_start',
      'id'          => 'range1_start',
      'value'       => (isset($_REQUEST['range1_start'])?$_REQUEST['range1_start']:'1'),
      'style'       => 'width:40px',
      'placeholder' => 'inicio',
      'readonly'	=> 'readonly',
    );	
	$range1_end = array(
      'name'        => 'range1_end',
      'id'          => 'range1_end',
      'value'       => (isset($_REQUEST['range1_end'])?$_REQUEST['range1_end']:''),
      'style'       => 'width:40px',
      'placeholder' => 'fin',
    );
	$range1_price = array(
      'name'        => 'range1_price',
      'id'          => 'range1_price',
      'value'       => (isset($_REQUEST['range1_price'])?$_REQUEST['range1_price']:''),
      'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
      'placeholder' => '$',
      'class'		=> 'range',
    );	
	$range2_start = array(
      'name'        => 'range2_start',
      'id'          => 'range2_start',
      'value'       => (isset($_REQUEST['range2_start'])?$_REQUEST['range2_start']:''),
      'style'       => 'width:40px',
      'placeholder' => 'inicio',
      'readonly'	=> 'readonly',
    );	
	$range2_end = array(
      'name'        => 'range2_end',
      'id'          => 'range2_end',
      'value'       => (isset($_REQUEST['range2_end'])?$_REQUEST['range2_end']:''),
      'style'       => 'width:40px',
      'placeholder' => 'fin',
    );	
	$range2_price = array(
      'name'        => 'range2_price',
      'id'          => 'range2_price',
      'value'       => (isset($_REQUEST['range2_price'])?$_REQUEST['range2_price']:''),
      'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
      'placeholder' => '$',
      'class'		=> 'range',
    );	
	$range3_start = array(
      'name'        => 'range3_start',
      'id'          => 'range3_start',
      'value'       => (isset($_REQUEST['range3_start'])?$_REQUEST['range3_start']:''),
      'style'       => 'width:40px',
      'placeholder' => 'inicio',
      'readonly'	=> 'readonly',
    );	
	$range3_end = array(
      'name'        => 'range3_end',
      'id'          => 'range3_end',
      'value'       => (isset($_REQUEST['range3_end'])?$_REQUEST['range3_end']:''),
      'style'       => 'width:40px',
      'placeholder' => 'fin',
    );	
	$range3_price = array(
      'name'        => 'range3_price',
      'id'          => 'range3_price',
      'value'       => (isset($_REQUEST['range3_price'])?$_REQUEST['range3_price']:''),
      'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
      'placeholder' => '$',
      'class'		=> 'range',
    );	
	$range4_start = array(
      'name'        => 'range4_start',
      'id'          => 'range4_start',
      'value'       => (isset($_REQUEST['range4_start'])?$_REQUEST['range4_start']:''),
      'style'       => 'width:40px',
      'placeholder' => 'inicio',
      'readonly'	=> 'readonly',
    );	
	$range4_end = array(
      'name'        => 'range4_end',
      'id'          => 'range4_end',
      'value'       => (isset($_REQUEST['range4_end'])?$_REQUEST['range4_end']:''),
      'style'       => 'width:40px',
      'placeholder' => 'fin',
    );	
	$range4_price = array(
      'name'        => 'range4_price',
      'id'          => 'range4_price',
      'value'       => (isset($_REQUEST['range4_price'])?$_REQUEST['range4_price']:''),
      'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
      'placeholder' => '$',
      'class'		=> 'range',
    );	
	$range5_start = array(
      'name'        => 'range5_start',
      'id'          => 'range5_start',
      'value'       => (isset($_REQUEST['range5_start'])?$_REQUEST['range5_start']:''),
      'style'       => 'width:40px',
      'placeholder' => 'inicio',
      'readonly'	=> 'readonly',
    );	
	$range5_price = array(
      'name'        => 'range5_price',
      'id'          => 'range5_price',
      'value'       => (isset($_REQUEST['range5_price'])?$_REQUEST['range5_price']:''),
      'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
      'placeholder' => '$',
      'class'		=> 'range',
    );	
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('qty_limit', $input_error))
			$qty_limit['class'] = 'target';
		if(in_array('amount_limit', $input_error))
			$amount_limit['class'] = 'target';
		if(in_array('qty_max_color', $qty_max_color))
			$amount_limit['class'] = 'target';
			
		if(in_array('range1_end', $input_error))
			$range1_end['class'] = 'target';
		if(in_array('range1_price', $input_error))
			$range1_price['class'] = 'target';
			
		if(in_array('range2_end', $input_error))
			$range2_end['class'] = 'target';
		if(in_array('range2_price', $input_error))
			$range2_price['class'] = 'target';
		
		if(in_array('range3_end', $input_error))
			$range3_end['class'] = 'target';
		if(in_array('range3_price', $input_error))
			$range3_price['class'] = 'target';
		
		if(in_array('range4_end', $input_error))
			$range4_end['class'] = 'target';
		if(in_array('range4_price', $input_error))
			$range4_price['class'] = 'target';
			
		if(in_array('range5_end', $input_error))
			$range5_end['class'] = 'target';
		if(in_array('range5_price', $input_error))
			$range5_price['class'] = 'target';

	}
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#printForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#code" ).val() == "" ) {
				msg = msg + 'Código, ';
				erro = true;
			}
			if ( $("#qty_max_color" ).val() == "" ) {
				msg = msg + 'Cuantidade máxima de colores, ';
				erro = true;
			}
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre, ';
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
<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('#range1_end').keyup(function(){
		if($('#range1_end').val()!='')
			$('#range2_start').attr('value',parseInt($('#range1_end').val())+1);
		else
			$('#range2_start').attr('value',0);
	});
	$('#range2_end').keyup(function(){
		if($('#range2_end').val()!='')
			$('#range3_start').attr('value',parseInt($('#range2_end').val())+1); 
		else
			$('#range3_start').attr('value',0);
	});
	$('#range3_end').keyup(function(){
		if($('#range3_end').val()!='')
			$('#range4_start').attr('value',parseInt($('#range3_end').val())+1);
		else
			$('#range4_start').attr('value',0);
	});
	$('#range4_end').keyup(function(){
		if($('#range4_end').val()!='')
			$('#range5_start').attr('value',parseInt($('#range4_end').val())+1);
		else
			$('#range5_start').attr('value',0);
	});
});
</script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label><?=isset($_REQUEST['id'])?'Edición de':'Nueva'?> Impresión</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'printForm', 'id' => 'printForm','enctype'=>'multipart/form-data');?>
					<?=form_open('print/save',$attributes,isset($hidden)?$hidden:'');?>
					<table>
						<tr>
							<td><p>Code: <?=form_input($code)?></p></td>
							<td><p>Maximo colores: <?=form_input($qty_max_color)?></p></td>
							<td><p>Minimo pedido: <?=form_input($qty_limit)?></p></td>
							<td><p>Minimo de monto ($): <?=form_input($amount_limit)?></p></td>
						</tr>
					</table>
					
					<table>
						<tr>
							<td width="400"><p>Name</p></td>
						</tr>
						<tr>
							<td><?=form_input($name)?></td>
						</tr>
						<tr>
							<td width="400"><p>Description</p></td>
						</tr>
						<tr>
							<td><?=form_input($description)?></td>
						</tr>
					</table>
					
					<table id="rangos_descuento" width="660" style="display:block?>;">
						<tr>
							<th align="center">Limites</th>
							<th colspan="12" align="center">Rangos de Costo</th>
						</tr>
						<tr>
							
							<td align="center">Intervalos</td>
							<td align="center"><?=form_input($range1_start)?></td>
							<td align="center"><?=form_input($range1_end)?></td>
							<td align="center"><?=form_input($range2_start)?></td>
							<td align="center"><?=form_input($range2_end)?></td>
							<td align="center"><?=form_input($range3_start)?></td>
							<td align="center"><?=form_input($range3_end)?></td>
							<td align="center"><?=form_input($range4_start)?></td>
							<td align="center"><?=form_input($range4_end)?></td>
							<td align="center"><?=form_input($range5_start)?></td>
							<td align="center">...</td>
						</tr>
						<tr>
							<td align="center" width=120>Rangos</td>
							<td colspan="2" align="center"><?=form_input($range1_price)?></td>
							<td colspan="2" align="center"><?=form_input($range2_price)?></td>
							<td colspan="2" align="center"><?=form_input($range3_price)?></td>
							<td colspan="2" align="center"><?=form_input($range4_price)?></td>
							<td colspan="2" align="center"><?=form_input($range5_price)?></td>
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
