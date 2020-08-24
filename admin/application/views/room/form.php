<?
	if(isset($_REQUEST['id'])){
		$hidden = array(
		'id' => $_REQUEST['id']
		);
	}

	if(isset($_REQUEST['id']))
		$code['readonly'] = '';

	$code_origin = array(
      	'name'        => 'code_origin',
      	'id'          => 'code_origin',
      	'value'       => (isset($_REQUEST['code_origin'])?$_REQUEST['code_origin']:''),
      	'style'       => 'width:60px;'
    );
	$name = array(
      	'name'        => 'name',
      	'id'          => 'name',
      	'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
      	'style'       => 'width:650px;'
    );
	
	$description = array(
      	'name'        => 'description',
      	'id'          => 'description',
      	'value'       => (isset($_REQUEST['description'])?$_REQUEST['description']:''),
      	'style'       => 'width:650px; height: 60px;'
    );
	
	$height = array(
      	'name'        => 'height',
      	'id'          => 'height',
      	'value'       => (isset($_REQUEST['height'])?$_REQUEST['height']:''),
      	'style'       => 'width:80px;'
    );
	
	$width = array(
		'name'        => 'width',
		'id'          => 'width',
		'value'       => (isset($_REQUEST['width'])?$_REQUEST['width']:''),
		'style'       => 'width:80px;'
    );
	
	$depth = array(
    	'name'        => 'depth',
      	'id'          => 'depth',
      	'value'       => (isset($_REQUEST['depth'])?$_REQUEST['depth']:''),
      	'style'       => 'width:80px;'
    );
	
	$active = array(
      '1'  		=> 'Si',
      '0'    	=> 'No',
   	);
	
	$qty_min = array(
    	'name'        => 'qty_min',
      	'id'          => 'qty_min',
      	'value'       => (isset($_REQUEST['qty_min'])?$_REQUEST['qty_min']:''),
      	'style'       => 'width:70px;'
    );
	
	$categoris = array();
	$categoris['X'] 		  = '';
	foreach ($categoryList as $key => $row) 
		$categoris[$row['id']] = $row['name'];
	
	$providers = array();
	foreach ($providerList as $key => $row) 
		$providers[$row['id']] = $row['name'];
	
	$prints = array();
	foreach ($printList as $key => $row) 
		$prints[$row['id']] = $row['description'];
	
	$colors = array();
	foreach ($colorList as $key => $row) 
		$colors[$row['id']] = $row['name'];
	
	$industry = array();
	$industry['X'] 			= '';
	foreach ($industryList as $key => $row) 
		$industry[$row['id']] = $row['name'];
	
	//==================================================================
	if((isset($product['productProvider']))and(count($product['productProvider'])>0)){
		foreach ($product['productProvider'] as $key => $row) {
			//==== PRODUCTO ============================================
			$price[$key] = array(
		      'name'        => 'price'.$key,
		      'id'          => 'price'.$key,
		      'value'       => (isset($row['price'])?$row['price']:''),
		      'style'       => 'width:50px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );
			$delivery_time[$key] = array(
		      'name'        => 'delivery_time'.$key,
		      'id'          => 'delivery_time'.$key,
		      'value'       => (isset($row['delivery_time'])?$row['delivery_time']:''),
		      'style'       => 'width:50px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$descuento[$key] = array(
		      'name'        => 'descuento'.$key,
		      'id'          => 'descuento'.$key,
		      'value'       => ((isset($row['discount'])and($row['discount']!=''))?$row['discount']:''),
		      'style'       => 'width: 80px;',
		      'readonly'	=> ''
		   	);
			$code_prodProv[$key] = array(
		      'name'        => 'code'.$key,
		      'id'          => 'code'.$key,
		      'value'       => ((isset($row['code'])and($row['code']!=''))?$row['code']:''),
		      'style'       => 'width: 30px;',
		   	);
			$url_ws[$key] = array(
		      'name'        => 'url_ws'.$key,
		      'id'          => 'url_ws'.$key,
		      'value'       => ((isset($row['url_ws'])and($row['url_ws']!=''))?$row['url_ws']:''),
		      'style'       => 'width: 370px;',
		      'readonly'	=> ''
		   	);
			$range1[$key] = array(
		      'name'        => 'range1_price'.$key,
		      'id'          => 'range1_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_price'])?$row['range1_price']:''):($row['range1_price_p']),
		      'style'       => 'width:70px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$range1_start[$key] = array(
		      'name'        => 'range1_start'.$key,
		      'id'          => 'range1_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_start'])?$row['range1_start']:''):($row['range1_start_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'inicio'
		    );	
			$range1_end[$key] = array(
		      'name'        => 'range1_end'.$key,
		      'id'          => 'range1_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_end'])?$row['range1_end']:''):($row['range1_end_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'fin',
		    );
			$range2[$key] = array(
		      'name'        => 'range2_price'.$key,
		      'id'          => 'range2_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_price'])?$row['range2_price']:''):($row['range2_price_p']),
		      'style'       => 'width:70px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$range2_start[$key] = array(
		      'name'        => 'range2_start'.$key,
		      'id'          => 'range2_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_start'])?$row['range2_start']:''):($row['range2_start_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'inicio',
		    );	
			$range2_end[$key] = array(
		      'name'        => 'range2_end'.$key,
		      'id'          => 'range2_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_end'])?$row['range2_end']:''):($row['range2_end_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'fin',
		    );	
			$range3[$key] = array(
		      'name'        => 'range3_price'.$key,
		      'id'          => 'range3_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_price'])?$row['range3_price']:''):($row['range3_price_p']),
		      'style'       => 'width:70px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$range3_start[$key] = array(
		      'name'        => 'range3_start'.$key,
		      'id'          => 'range3_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_start'])?$row['range3_start']:''):($row['range3_start_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'inicio',
		    );	
			$range3_end[$key] = array(
		      'name'        => 'range3_end'.$key,
		      'id'          => 'range3_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_end'])?$row['range3_end']:''):($row['range3_end_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'fin',
		    );	
			$range4[$key] = array(
		      'name'        => 'range4_price'.$key,
		      'id'          => 'range4_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_price'])?$row['range4_price']:''):($row['range4_price_p']),
		      'style'       => 'width:70px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$range4_start[$key] = array(
		      'name'        => 'range4_start'.$key,
		      'id'          => 'range4_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_start'])?$row['range4_start']:''):($row['range4_start_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'inicio',
		    );	
			$range4_end[$key] = array(
		      'name'        => 'range4_end'.$key,
		      'id'          => 'range4_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_end'])?$row['range4_end']:''):($row['range4_end_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'fin',
		    );	
			$range5[$key] = array(
		      'name'        => 'range5_price'.$key,
		      'id'          => 'range5_price'.$key,
		      'line'        => $key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range5_price'])?$row['range5_price']:''):($row['range5_price_p']),
		      'style'       => 'width:70px; text-align:center; font-size:14px; font-weight: bold;',
		      'placeholder' => '%',
		      'class'		=> 'range',
		    );	
			$range5_start[$key] = array(
		      'name'        => 'range5_start'.$key,
		      'id'          => 'range5_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range5_start'])?$row['range5_start']:''):($row['range5_start_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'inicio',
		    );
			if($row['type_discount']=='3' or $row['type_discount']=='4'){
				$range1[$key]['readonly'] 		= '';
				$range1_start[$key]['readonly']	= '';
				$range1_end[$key]['readonly']	= '';
				$range2[$key]['readonly'] 		= '';
				$range2_start[$key]['readonly']	= '';
				$range2_end[$key]['readonly']	= '';
				$range3[$key]['readonly'] 		= '';
				$range3_start[$key]['readonly']	= '';
				$range3_end[$key]['readonly']	= '';
				$range4[$key]['readonly'] 		= '';
				$range4_start[$key]['readonly']	= '';
				$range4_end[$key]['readonly']	= '';
				$range5[$key]['readonly'] 		= '';
				$range5_start[$key]['readonly']	= '';
			}
		}
	}

	
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#productForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre ';
				erro = true;
			}
			if ( $("#email" ).val() == "" ) {
				msg = msg + ',Email ';
				erro = true;
			}
			if ( $("#email" ).val() == "" ) {
				msg = msg + ',Email ';
				erro = true;
			}
			if(($("input").prop('disabled', false)) && ($("#code" ).val()=='')){
				msg = msg + ',Codigo ';
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
			$('#phone1').mask("+99(99) 9999-9999");
			$('#phone2').mask("+99(99) 9999-9999");
			$('#descuento').mask("99");
		});
		
	$('.excluir').click(function(e) {
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var r = confirm("Desea realmente borrar?");
		if (r==true)
		{
			var id = $(this).attr('idproductprovider');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>product/deletePP/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#product_provider'+id).fadeOut(200);
						return true;
					}
					else
					{
						$("#status").html(iconAlerta).show();
						$('#status').prepend(returnedData.msg);
						return false;
					}
				},
			'html');
		}
		return false;
	});
	
	$('.excluirPrint').click(function(e) {
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var r = confirm("Desea realmente borrar?");
		if (r==true)
		{
			var id = $(this).attr('idproductprint');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>product/deletePrint/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#product_print'+id).fadeOut(200);
						return true;
					}
					else
					{
						$("#status").html(iconAlerta).show();
						$('#status').prepend(returnedData.msg);
						return false;
					}
				},
			'html');
		}
		return false;
	});
	
	$('.excluirIndustry').click(function(e) {
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var r = confirm("Desea realmente borrar?");
		if (r==true)
		{
			var id = $(this).attr('idproductindustry');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>product/deleteIndustry/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#product_industry'+id).fadeOut(200);
						return true;
					}
					else
					{
						$("#status").html(iconAlerta).show();
						$('#status').prepend(returnedData.msg);
						return false;
					}
				},
			'html');
		}
		return false;
	});
	
	$('.excluirColor').click(function(e) {
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var r = confirm("Desea realmente borrar?");
		if (r==true)
		{
			var id = $(this).attr('idproductcolor');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>product/deletePrint/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#product_color'+id).fadeOut(200);
						return true;
					}
					else
					{
						$("#status").html(iconAlerta).show();
						$('#status').prepend(returnedData.msg);
						return false;
					}
				},
			'html');
		}
		return false;
	});
	
	$('.print').click(function(){
		if($("#addPrintType").is(":visible"))
			$('#addPrintType').css('display','none');
		else
			$('#addPrintType').css('display','block');
	})
	
	$('.industry').click(function(){
		if($("#addIndustry").is(":visible"))
			$('#addIndustry').css('display','none');
		else
			$('#addIndustry').css('display','block');
	})
	
	$('.color').click(function(){
		if($("#addColor").is(":visible"))
			$('#addColor').css('display','none');
		else
			$('#addColor').css('display','block');
	})
	
	$('.provider').click(function(){
		if($("#addProvider").is(":visible"))
			$('#addProvider').css('display','none');
		else
			$('#addProvider').css('display','block');
	})
	
	});
 </script>
<script>
	function alteraStatusColor(id,elemento,viewName)
	{
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		$('#status').html(iconCarregando);
		jQuery.ajax({
		type: "POST",
		url: viewName+"/changeStatusColor/"+id,
		data: 'id='+id,
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
			{
				$('#status').html(iconConf);
				$('#status').append(returnedData.msg);
				$(elemento).val(returnedData.label);
				link = "#linkStatusColor_"+id;
				var status = returnedData.label;
				$(link).attr('value', returnedData.label);
				$(link).attr('class', status.toLowerCase());  

			}
			else
			{
				$(link).attr('disabled', false); 
				$('#status').html(returnedData.msg);
			}
			},
			async: true
		});
	}
	function alteraStatusIndustry(id,elemento,viewName)
	{
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		$('#status').html(iconCarregando);
		jQuery.ajax({
		type: "POST",
		url: viewName+"/changeStatusIndustry/"+id,
		data: 'id='+id,
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
			{
				$('#status').html(iconConf);
				$('#status').append(returnedData.msg);
				$(elemento).val(returnedData.label);
				link = "#linkStatusIndustry_"+id;
				var status = returnedData.label;
				$(link).attr('value', returnedData.label);
				$(link).attr('class', status.toLowerCase());  

			}
			else
			{
				$(link).attr('disabled', false); 
				$('#status').html(returnedData.msg);
			}
			},
			async: true
		});
	}
	function alteraStatusPrint(id,elemento,viewName)
	{
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		$('#status').html(iconCarregando);
		jQuery.ajax({
		type: "POST",
		url: viewName+"/changeStatusPrint/"+id,
		data: 'id='+id,
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
			{
				$('#status').html(iconConf);
				$('#status').append(returnedData.msg);
				$(elemento).val(returnedData.label);
				link = "#linkStatusPrint_"+id;
				var status = returnedData.label;
				$(link).attr('value', returnedData.label);
				$(link).attr('class', status.toLowerCase());  

			}
			else
			{
				$(link).attr('disabled', false); 
				$('#status').html(returnedData.msg);
			}
			},
			async: true
		});
	}
	function alteraStatus(id,elemento,viewName)
	{
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		$('#status').html(iconCarregando);
		jQuery.ajax({
		type: "POST",
		url: viewName+"/changeStatusPP/"+id,
		data: 'id='+id,
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
			{
				$('#status').html(iconConf);
				$('#status').append(returnedData.msg);
				$(elemento).val(returnedData.label);
				link = "#linkStatus_"+id;
				var status = returnedData.label;
				$(link).attr('value', returnedData.label);
				$(link).attr('class', status.toLowerCase());  

			}
			else
			{
				$(link).attr('disabled', false); 
				$('#status').html(returnedData.msg);
			}
			},
			async: true
		});
	}
	function pageBusy(maincontainer,status) {
		var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
		if (status == true) {
			$('#status').html(iconCarregando);
		} else {
			$('#status').html('');
		}
	};
</script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label><?=isset($_REQUEST['id'])?'Edición de':'Nuevo'?> Producto</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'productForm', 'id' => 'productForm','enctype'=>'multipart/form-data');?>
					<?=form_open('product/save',$attributes,isset($hidden)?$hidden:'');?>
					<table>
						<tr>
							<td>Nombre</td>									
						</tr>
						<tr>
							<td><?=form_input($name)?></td>
						</tr>
					</table>
					
					<table>
						<tr>
							<td><p>Category</p></td>
							<td><p>Cod. Foto</p></td>
							<td><p>Cantidad Min.</p></td>
							<td><p>Active</p></td>
							<td><p>Largura:</p></td>
							<td><p>Alto:</p></td>
							<td><p>Ancho:</p></td>
						</tr>
						<tr>
							<td><?=form_dropdown('fk_category',$categoris,isset($_REQUEST['fk_category'])?$_REQUEST['fk_category']:'X','style="width:80px;"')?></td>
							<td><?=form_input($code_origin)?></td>
							<td><?=form_input($qty_min)?></td>
							<td><?=form_dropdown('active',$active,isset($_REQUEST['active'])?$_REQUEST['active']:'1','style="width:50px;"')?></td>
							<td><?=form_input($width)?></td>
							<td><?=form_input($height)?></td>
							<td><?=form_input($depth)?></td>
						</tr>
					</table>
					
					<table>
						<tr><td>OBS</td></tr>
						<tr><td><?=form_textarea($description)?></td></tr>
					</table>
					
					<table border=0>
						<tr>				
							<td align="left">
                                <button type="submit" id="salvar" class="enviar">Salvar</button>
							</td>
						</tr>
					</table>
					<?=form_close()?>
					
						<div id='atributes'>
							<?if(isset($_REQUEST['id'])){?>
							<div id='separator' class='print'>Listado de 'Tipo de Impresión' para el Producto</div>
							<div id='addPrintType'>
								<form action="<?=base_url('product/addPrint/'.$_REQUEST['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<?=form_dropdown('prints',$prints,'','style="width:300px;" id=prints')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if((isset($product['productPrint']))and (count($product['productPrint'])>0)){?>
									<?foreach ($product['productPrint'] as $key => $row) {?>
										<table id='product_print<?=$row['id']?>'>
											<tr>
												<td align="center" colspan="5" style='width:280px;'>
													<strong><u><?=$row['description']?></u></strong>
												</td>
												<td align="center" colspan="0">
													Max. Colores: <?=$row['qty_max_color']?>
												</td>
												<td align="center" colspan="0">
													Min. Cantidad: <?=$row['qty_limit']?> o CLP <?=$row['amount_limit']?>)
												</td>
												<td colspan="4" >
													<input type="button" class="<?=($row['active'])?'activo':'inactivo'?>" name='ativo' value="<?=($row['active'])?'Activo':'Inactivo'?>" title="Altera Status" id="linkStatusPrint_<?=$row['id']?>" onclick="javascript: alteraStatusPrint(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluirPrint' idproductprint='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
										</table>
									<?}?>
								<?}?>
							</div>
							
							<div id='separator' class='industry'>Listado de RUBROS para el Producto</div>
							<div id='addIndustry'>
								<form action="<?=base_url('product/addIndustries/'.$_REQUEST['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<?=form_dropdown('industry',$industry,'','style="width:300px;" id="industry"')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if(count($product['productIndustry'])>0){?>
									<?foreach ($product['productIndustry'] as $key => $row) {?>
										<table id='product_industry<?=$row['id']?>'>
											<tr>
												<td align="center" colspan="5" style='width:430px;'>
													<strong><u><?=$row['code']?> - <?=$row['name']?></u></strong>
												</td>
												<td colspan="4" >
													<input type="button" class="<?=($row['active'])?'activo':'inactivo'?>" name='ativo' value="<?=($row['active'])?'Activo':'Inactivo'?>" title="Altera Status" id="linkStatusIndustry_<?=$row['id']?>" onclick="javascript: alteraStatusIndustry(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluirIndustry' idproductindustry='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
										</table>
									<?}?>
								<?}?>
							</div>
							
							<div id='separator' class='color'>Listado de Colores para el Producto</div>
							<div id='addColor'>
								<form action="<?=base_url('product/addColors/'.$_REQUEST['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<?=form_dropdown('colors',$colors,'','style="width:300px;" id="colors"')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if(count($product['productColor'])>0){?>
									<?foreach ($product['productColor'] as $key => $row) {?>
										<table id='product_color<?=$row['id']?>'>
											<tr>
												<td align="center" colspan="5" style='width:430px;'>
													<strong><u><?=$row['code']?> - <?=$row['name']?></u></strong>
												</td>
												<td align="center" colspan="0">
													<div id="color_preview" style="background-color:<?=$row['hexa']?>"></div>
												</td>
												<td colspan="4" >
													<input type="button" class="<?=($row['active'])?'activo':'inactivo'?>" name='ativo' value="<?=($row['active'])?'Activo':'Inactivo'?>" title="Altera Status" id="linkStatusColor_<?=$row['id']?>" onclick="javascript: alteraStatusColor(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluirColor' idproductcolor='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
										</table>
									<?}?>
								<?}?>
							</div>
							
							
							<div id='separator' class='provider'>Listado de Provedor para el Producto</div>
							<div id='addProvider'>
								<form action="<?=base_url('product/addProvider/'.$_REQUEST['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<?=form_dropdown('providers',$providers,'','style="width:300px;" id=providers')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if(count($product['productProvider'])>0){?>
									<?foreach ($product['productProvider'] as $key => $row) {?>
										<script>
											function save<?=$key?>(id,viewName){
												var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
												var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
												var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
												var id				= id;
												var code 			= $("#code<?=$key?>").val();
												var price 			= $("#price<?=$key?>").val();
												var delivery_time	= $('#delivery_time<?=$key?>').val();
												var range1_start 	= $('#range1_start<?=$key?>').val();
												var range1_end 		= $('#range1_end<?=$key?>').val();
												var range1_price 	= $('#range1_price<?=$key?>').val();
												var range2_start 	= $('#range2_start<?=$key?>').val();
												var range2_end 		= $('#range2_end<?=$key?>').val();
												var range2_price 	= $('#range2_price<?=$key?>').val();
												var range3_start 	= $('#range3_start<?=$key?>').val();
												var range3_end 		= $('#range3_end<?=$key?>').val();
												var range3_price 	= $('#range3_price<?=$key?>').val();
												var range4_start 	= $('#range4_start<?=$key?>').val();
												var range4_end 		= $('#range4_end<?=$key?>').val();
												var range4_price 	= $('#range4_price<?=$key?>').val();
												var range5_start 	= $('#range5_start<?=$key?>').val();
												var range5_price 	= $('#range5_price<?=$key?>').val();
												if(
													code			!= '' &&
													price 			!= '' &&
													delivery_time 	!= '' &&
													range1_start 	!= '' &&
													range1_end 		!= '' &&
													range1_price 	!= '' && 
													range2_start 	!= '' &&
													range2_end 		!= '' &&
													range2_price 	!= '' &&
													range3_start 	!= '' &&
													range3_end 		!= '' &&
													range3_price 	!= '' &&
													range4_start 	!= '' &&
													range4_end 		!= '' &&
													range4_price 	!= '' &&
													range5_start 	!= '' &&
													range5_price 	!= '')
												{
												jQuery.ajax({
												type: "POST",
												url: viewName+"/savePP/",
												data: {	
													id				: id,
													code			: code,
													price			: price,
													delivery_time	: delivery_time,
													range1_start	: range1_start,
													range1_end		: range1_end,
													range1_price	: range1_price,
													range2_start	: range2_start,
													range2_end		: range2_end,
													range2_price	: range2_price,
													range3_start	: range3_start,
													range3_end		: range3_end,
													range3_price	: range3_price,
													range4_start	: range4_start,
													range4_end		: range4_end,
													range4_price	: range4_price,
													range5_start	: range5_start,
													range5_price	: range5_price
													},
												dataType: 'json',
												success: function(returnedData){
													if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
													{
														$('#status').html('');
														$('#status').html(iconConf);
														$('#status').append(returnedData.msg);
													}
													else
													{
														$('#status').html(iconAlerta);
														$('#status').append(returnedData.msg);
													}
												},
												async: true
												});
												}else{
													$('#status').html('');
													$('#status').html(iconAlerta);
													$('#status').append('Campos incompletos.');
												}
											};
											$(document).ready( function() {
												$('#range1_end<?=$key?>').keyup(function(){
													if($('#range1_end<?=$key?>').val()!='')
														$('#range2_start<?=$key?>').attr('value',parseInt($('#range1_end<?=$key?>').val())+1);
													else
														$('#range2_start<?=$key?>').attr('value',0);
												});
												$('#range2_end').keyup(function(){
													if($('#range2_end<?=$key?>').val()!='')
														$('#range3_start<?=$key?>').attr('value',parseInt($('#range2_end<?=$key?>').val())+1); 
													else
														$('#range3_start<?=$key?>').attr('value',0);
												});
												$('#range3_end<?=$key?>').keyup(function(){
													if($('#range3_end<?=$key?>').val()!='')
														$('#range4_start<?=$key?>').attr('value',parseInt($('#range3_end<?=$key?>').val())+1);
													else
														$('#range4_start').attr('value',0);
												});
												$('#range4_end<?=$key?>').keyup(function(){
													if($('#range4_end<?=$key?>').val()!='')
														$('#range5_start<?=$key?>').attr('value',parseInt($('#range4_end<?=$key?>').val())+1);
													else
														$('#range5_start<?=$key?>').attr('value',0);
												});
											});
										</script>
										<table id='product_provider<?=$row['id']?>'>
											<tr>
												<td align="center" colspan="10" style='width:290px;'><strong><u><?=$row['name']?></u></strong></td>
												<td colspan="4" >
													<input type="button" class="save" name='save' value="Save" title="Salvar" onclick="javascript: save<?=$key?>(<?=$row['id']?>,'<?=base_url()?>product');">
													<input type="button" class="<?=($row['active'])?'activo':'inactivo'?>" name='ativo' value="<?=($row['activeProductProvider'])?'Activo':'Inactivo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluir' idproductprovider='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
									<?switch ($row['type_discount']) {
										case '1': // 1->por rango de Producto;?>
												<tr>
													<td colspan="13" align="center"><strong>Rangos de Descuentos por Producto</strong></td>
												</tr>
												<tr>
													<td align="center" width="90">Precio</td>
													<td align="center"><?=form_input($price[$key])?></td>
													<td align="center">Intervalos</td>
													<td align="center" width="40"><?=form_input($range1_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range1_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range2_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range2_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range3_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range3_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range4_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range4_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range5_start[$key])?></td>
													<td align="center" width="40">...</td>
												</tr>
												<tr>
													<td align="center">Tiempo Entrega</td>
													<td align="center"><?=form_input($delivery_time[$key])?></td>
													<td align="center">Rangos</td>
													<td colspan="2" align="center"><?=form_input($range1[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range2[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range3[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range4[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range5[$key])?></td>
												</tr>
											</table>
										<?break;?>
											
										<?case '2':// 2->descuento unico?> 
												<tr>
													<td colspan="12" align="center"><strong>Descuento único (%)</strong></td>
												</tr>
												<tr>
													<td colspan="12" align="center">
														<?=form_input($descuento[$key])?>
													</td>
												</tr>
											</table>
										<?break;?>
											
										<?case '3':// 3->por PROVEDOR?>
												<tr>
													<td colspan="13" align="center"><strong>Rangos de Descuentos por Provedor</strong></td>
												</tr>
												<tr>
													<td align="center" width="90">Código</td>
													<td align="center" width="90">Precio</td>
													<td align="center"><?=form_input($price[$key])?></td>
													<td align="center">Intervalos</td>
													<td align="center" width="40"><?=form_input($range1_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range1_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range2_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range2_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range3_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range3_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range4_start[$key])?></td>
													<td align="center" width="40"><?=form_input($range4_end[$key])?></td>
													<td align="center" width="40"><?=form_input($range5_start[$key])?></td>
													<td align="center" width="40">...</td>
												</tr>
												<tr>
													<td align="center"><?=form_input($code_prodProv[$key])?></td>
													<td align="center">Tiempo Entrega</td>
													<td align="center"><?=form_input($delivery_time[$key])?></td>
													<td align="center">Rangos</td>
													<td colspan="2" align="center"><?=form_input($range1[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range2[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range3[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range4[$key])?></td>
													<td colspan="2" align="center"><?=form_input($range5[$key])?></td>
												</tr>
											</table>
										<?break;?>
										
										<?case '4':// 4->por Web Service?>
												<tr>
													<td colspan="13" align="center"><strong>Precios retornados por Web Service</strong></td>
												</tr>
												<tr>
													<td align="center" width="90">URL</td>
													<td colspan="2" align="center"><?=form_input($url_ws[$key])?></td>
												</tr>
											</table>
										<?break;?>
										
										<?default:?>
											<table>
												<tr>
													<td><i>Tipo de descuento no encontrado</i></td>
												</tr>
											</table>
										<?break;?>
									<?}?>
								<?}?>
							<?}?>
							</div>
						
						</div><!-- FIN DE DIV QUE CONTIENE LOS ATRIBUTOS DEL PRODUCT-->
					<?}?>
				</div>
			</div>
