<?
	if(isset($product[0]['id'])){
		$hidden = array(
		'id' => $product[0]['id']
		);
	}

	if(isset($product[0]['id']))
		$code['readonly'] = '';

	$code_origin = array(
      	'name'        => 'code_origin',
      	'id'          => 'code_origin',
      	'value'       => (isset($product[0]['code_origin'])?$product[0]['code_origin']:''),
      	'class'		=> 'form-control',
    );
	$name = array(
      	'name'        => 'name',
      	'id'          => 'name',
      	'value'       => (isset($product[0]['name'])?$product[0]['name']:'' ),
      	'class'		  => 'form-control',
    );
	
	$description = array(
      	'name'        => 'description',
      	'id'          => 'description',
      	'value'       => (isset($product[0]['description'])?$product[0]['description']:''),
      	'class'		  => 'form-control',
    );
	
	$height = array(
      	'name'        => 'height',
      	'id'          => 'height',
      	'value'       => (isset($product[0]['height'])?$product[0]['height']:''),
      	'class'		  => 'form-control',
    );
	
	$width = array(
		'name'        => 'width',
		'id'          => 'width',
		'value'       => (isset($product[0]['width'])?$product[0]['width']:''),
		'class'		  => 'form-control',
    );
	
	$depth = array(
    	'name'        => 'depth',
      	'id'          => 'depth',
      	'value'       => (isset($product[0]['depth'])?$product[0]['depth']:''),
      	'class'		  => 'form-control',
    );
	
	$active = array(
      '1'  			  => 'Si',
      '0'    		  => 'No',
   	);
	
	$qty_min = array(
    	'name'        => 'qty_min',
      	'id'          => 'qty_min',
      	'value'       => (isset($product[0]['qty_min'])?$product[0]['qty_min']:''),
      	'class'		  => 'form-control',
    );
	$productprice = array(
    	'name'        => 'price',
      	'id'          => 'price',
      	'value'       => (isset($product['productProvider'][0]['price'])?(str_replace('.', ',', $product['productProvider'][0]['price'])):''), 
      	'class'		  => 'form-control',
    );
	$delivery_time = array(
    	'name'        => 'delivery_time',
      	'id'          => 'delivery_time',
      	'value'       => (isset($product['productProvider'][0]['delivery_time'])?(str_replace('.', ',', $product['productProvider'][0]['delivery_time'])):''),
      	'class'		  => 'form-control',
    );
	
	$categoris = array();
	$categoris['X'] 		  = '';
	foreach ($categoryList as $key => $row) 
		$categoris[$row['id']] = $row['name'];
	
	$providers = array();
	foreach ($providerList as $key => $row) 
		$providers[$row['id']] = $row['name'];
	
	
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
		      'placeholder' => '%',
		      'class'		=> 'form-control',
		    );
			$delivery_time[$key] = array(
		      'name'        => 'delivery_time'.$key,
		      'id'          => 'delivery_time'.$key,
		      'value'       => (isset($row['delivery_time'])?$row['delivery_time']:''),
		      'placeholder' => '%',
		      'class'		=> 'form-control',
		    );	
			$descuento[$key] = array(
		      'name'        => 'descuento'.$key,
		      'id'          => 'descuento'.$key,
		      'value'       => ((isset($row['discount'])and($row['discount']!=''))?$row['discount']:''),
		      'class'		=> 'form-control',
		      'readonly'	=> ''
		   	);
			$code_prodProv[$key] = array(
		      'name'        => 'code'.$key,
		      'id'          => 'code'.$key,
		      'value'       => ((isset($row['code'])and($row['code']!=''))?$row['code']:''),
		      'class'		=> 'form-control',
		   	);
			$url_ws[$key] = array(
		      'name'        => 'url_ws'.$key,
		      'id'          => 'url_ws'.$key,
		      'value'       => ((isset($row['url_ws'])and($row['url_ws']!=''))?$row['url_ws']:''),
		      'readonly'	=> '',
		      'class'		=> 'form-control',
		   	);
			$range1[$key] = array(
		      'name'        => 'range1_price'.$key,
		      'id'          => 'range1_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_price'])?$row['range1_price']:''):($row['range1_price_p']),
		      'placeholder' => '%',
		      'class'		=> 'form-control',
		    );	
			$range1_start[$key] = array(
		      'name'        => 'range1_start'.$key,
		      'id'          => 'range1_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_start'])?$row['range1_start']:''):($row['range1_start_p']),
		      'placeholder' => 'inicio',
		      'class'		=> 'form-control',
		    );	
			$range1_end[$key] = array(
		      'name'        => 'range1_end'.$key,
		      'id'          => 'range1_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range1_end'])?$row['range1_end']:''):($row['range1_end_p']),
		      'placeholder' => 'fin',
		      'class'		=> 'form-control',
		    );
			$range2[$key] = array(
		      'name'        => 'range2_price'.$key,
		      'id'          => 'range2_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_price'])?$row['range2_price']:''):($row['range2_price_p']),
		      'placeholder' => '%',
		      'class'		=> 'form-control',
		    );	
			$range2_start[$key] = array(
		      'name'        => 'range2_start'.$key,
		      'id'          => 'range2_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_start'])?$row['range2_start']:''):($row['range2_start_p']),
		      'placeholder' => 'inicio',
		      'class'		=> 'form-control',
		    );	
			$range2_end[$key] = array(
		      'name'        => 'range2_end'.$key,
		      'id'          => 'range2_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range2_end'])?$row['range2_end']:''):($row['range2_end_p']),
		      'placeholder' => 'fin',
		      'class'		=> 'form-control',
		    );	
			$range3[$key] = array(
		      'name'        => 'range3_price'.$key,
		      'id'          => 'range3_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_price'])?$row['range3_price']:''):($row['range3_price_p']),
		      'placeholder' => '%',
		      'class'		=> 'range',
		      'class'		=> 'form-control',
		    );	
			$range3_start[$key] = array(
		      'name'        => 'range3_start'.$key,
		      'id'          => 'range3_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_start'])?$row['range3_start']:''):($row['range3_start_p']),
		      'placeholder' => 'inicio',
		      'class'		=> 'form-control',
		    );	
			$range3_end[$key] = array(
		      'name'        => 'range3_end'.$key,
		      'id'          => 'range3_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range3_end'])?$row['range3_end']:''):($row['range3_end_p']),
		      'style'       => 'width:30px',
		      'placeholder' => 'fin',
		      'class'		=> 'form-control',
		    );	
			$range4[$key] = array(
		      'name'        => 'range4_price'.$key,
		      'id'          => 'range4_price'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_price'])?$row['range4_price']:''):($row['range4_price_p']),
		      'class'		=> 'form-control',
		    );	
			$range4_start[$key] = array(
		      'name'        => 'range4_start'.$key,
		      'id'          => 'range4_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_start'])?$row['range4_start']:''):($row['range4_start_p']),
		      'placeholder' => 'inicio',
		      'class'		=> 'form-control',
		    );	
			$range4_end[$key] = array(
		      'name'        => 'range4_end'.$key,
		      'id'          => 'range4_end'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range4_end'])?$row['range4_end']:''):($row['range4_end_p']),
		      'placeholder' => 'fin',
		      'class'		=> 'form-control',
		    );	
			$range5[$key] = array(
		      'name'        => 'range5_price'.$key,
		      'id'          => 'range5_price'.$key,
		      'line'        => $key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range5_price'])?$row['range5_price']:''):($row['range5_price_p']),
		      'placeholder' => '%',
		      'class'		=> 'form-control',
		    );	
			$range5_start[$key] = array(
		      'name'        => 'range5_start'.$key,
		      'id'          => 'range5_start'.$key,
		      'value'       => ($row['type_discount']=='1')?(isset($row['range5_start'])?$row['range5_start']:''):($row['range5_start_p']),
		      'placeholder' => 'inicio',
		      'class'		=> 'form-control',
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
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">

      window.onload = function()  {
        CKEDITOR.replace('description');
      };

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
	
	$('.industry').click(function(){
		if($("#addIndustry").is(":visible"))
		  	$( "#addIndustry" ).fadeOut( "slow", function() {});
		else
			$('#addIndustry').fadeIn( "slow", function() {});
	})
	
	$('.color').click(function(){
		if($("#addColor").is(":visible"))
			$('#addColor').fadeOut( "slow", function() {});
		else
			$('#addColor').fadeIn( "slow", function() {});
	})
	
	$('.provider').click(function(){
		if($("#addProvider").is(":visible"))
			$('#addProvider').fadeOut( "slow", function() {});
		else
			$('#addProvider').fadeIn( "slow", function() {});
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
				$(link).attr('value', returnedData.label);
				$(link).attr('class', ((returnedData.active=='1')?'btn btn-success':'btn btn-warning'));
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
				$(link).attr('value', returnedData.label);
				$(link).attr('class', ((returnedData.active=='1')?'btn btn-success':'btn btn-warning'));
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
				$(link).attr('value', returnedData.label);
				$(link).attr('class', ((returnedData.active=='1')?'btn btn-success':'btn btn-warning'));

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
				$(link).attr('value', returnedData.label);
				$(link).attr('class', ((returnedData.active=='1')?'btn btn-success':'btn btn-warning'));
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

<div class>
	<div class="page-title">
  		<div class="title_left">
			<h3>Lista de Arquivos</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Produtos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'productForm', 'id' => 'productForm','enctype'=>'multipart/form-data');?>
						<?=form_open('product/save',$attributes,isset($hidden)?$hidden:'');?>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Nome</label>
								<?=form_input($name)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Descrição</label>
								<?=form_textarea($description)?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 form-group">
								<label>Categoria</label>
								<?=form_dropdown('fk_category',$categoris,isset($product[0]['fk_category'])?$product[0]['fk_category']:'X','class="form-control"')?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 form-group">
								<label>Cod. Foto</label>
								<?=form_input($code_origin)?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Qtde. min.</label>
								<?=form_input($qty_min)?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Dias p/ produção</label>
								<?=form_input($delivery_time)?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Ativo</label>
								<?=form_dropdown('active',$active,isset($product[0]['active'])?$product[0]['active']:'1','class="form-control"')?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Largura</label>
								<?=form_input($width)?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Altura</label>
								<?=form_input($height)?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Profundidade</label>
								<?=form_input($depth)?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Preço</label>
								<?=form_input($productprice)?>
							</div>
							
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
							</div>

						<?=form_close()?>
						
						<div id='atributes'>
							<?if(isset($product[0]['id'])){?>
							
							<div id='separator' class='industry'>Lista de RUBROS para el Producto</div>
							<div id='addIndustry'>
								<form action="<?=base_url('product/addIndustries/'.$product[0]['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<label>Fabricação (Grupo de Itens)</label>
									<?=form_dropdown('industry',$industry,'','class="form-control" id="industry"')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if(count($product['productIndustry'])>0){?>
									<?foreach ($product['productIndustry'] as $key => $row) {?>
										<table id='product_industry<?=$row['id']?>' class="table">
											<tr>
												<td align="center" colspan="5">
													<strong><u><?=$row['code']?> - <?=$row['name']?></u></strong>
												</td>
												<td colspan="4" >
													<input type="button" class="btn btn-<?=($row['active'])?'success':'warning'?>" name='ativo' value="<?=($row['active'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatusIndustry_<?=$row['id']?>" onclick="javascript: alteraStatusIndustry(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluirIndustry' idproductindustry='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
										</table>
									<?}?>
								<?}?>
							</div>
							
							<div id='separator' class='color'>Lista de Cores para o Producto</div>
							<div id='addColor'>
								<form action="<?=base_url('product/addColors/'.$product[0]['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<label>Variação de Cores do Produto</label>
									<?=form_dropdown('colors',$colors,'','class="form-control" id="colors"')?>
									<input type="image" name="icoAdd" value="" id="icoAdd" src="<?=base_url('public/images/icones/ico_add.jpg')?>"/>
								</form>
								<?if(count($product['productColor'])>0){?>
									<?foreach ($product['productColor'] as $key => $row) {?>
										<table id='product_color<?=$row['id']?>' class="table">
											<tr>
												<td align="center" colspan="5">
													<strong><u><?=$row['code']?> - <?=$row['name']?></u></strong>
												</td>
												<td align="center" colspan="0">
													<div id="color_preview" style="background-color:<?=$row['hexa']?>"></div>
												</td>
												<td colspan="4" >
													<input type="button" class="btn btn-<?=($row['active'])?'success':'warning'?>" name='ativo' value="<?=($row['active'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatusColor_<?=$row['id']?>" onclick="javascript: alteraStatusColor(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluirColor' idproductcolor='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
										</table>
									<?}?>
								<?}?>
							</div>
							
							
							<div id='separator' class='provider'>Lista de Fornecedores para o Producto</div>
							<div id='addProvider'>
								<form action="<?=base_url('product/addProvider/'.$product[0]['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<label>Fornecedores</label>
									<?=form_dropdown('providers',$providers,'','class="form-control" id="providers"')?>
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
														alerta('Operação concluída',returnedData.msg);
													}
													else
													{
														alerta('Atenção',returnedData.msg);
													}
												},
												async: true
												});
												}else{
													alerta('Atenção','Campos incompletos.');
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
										<table id='product_provider<?=$row['id']?>' class="table">
											<tr>
												<td align="center" colspan="10"><strong><u><?=$row['name']?></u></strong></td>
												<td colspan="4" >
													<input type="button" class="btn btn-success" name='save' value="Save" title="Salvar" onclick="javascript: save<?=$key?>(<?=$row['id']?>,'<?=base_url()?>product');">
													<input type="button" class="btn btn-<?=($row['activeProductProvider'])?'success':'warning'?>" name='ativo' value="<?=($row['activeProductProvider'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
													<a href="" class='excluir' idproductprovider='<?=$row['id']?>'>
														<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
													</a>
												</td>
											</tr>
									<?switch ($row['type_discount']) {
										case '1': // 1->por rango de Producto;?>
												<tr>
													<td colspan="13" align="center"><strong>Ranges de desconto por produto</strong></td>
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
													<td colspan="13" align="center"><strong>Ranges de descontos por fornecedor</strong></td>
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
													<td colspan="13" align="center"><strong>Preços retornados por Web Service</strong></td>
												</tr>
												<tr>
													<td align="center" width="90">URL</td>
													<td colspan="2" align="center"><?=form_input($url_ws[$key])?></td>
												</tr>
											</table>
										<?break;?>
										
										<?default:?>
											<table class="table">
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
			</div>
		</div>
	</div>
</div>