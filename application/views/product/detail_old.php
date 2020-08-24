<?php 
	if(isset($result['id'])){
		$hidden = array('id' => $result['id']);
	}
	
	$quantity = array(
      'name'        => 'quantity',
      'id'          => 'quantity',
      'value'       => '',
      'style'       => 'width:50px;',
    );
	$colors = array(
      'name'        => 'colors',
      'id'          => 'colors',
      'value'       => '',
      'style'       => 'width:60px;',
    );
	
	$opt_color = array();
	foreach($colors_available as $index => $row)
		$opt_color[$row['fk_color']] = $row['name'];
	
	$prints = array('X'=>'sin personalización');
	foreach($print_available as $index => $row)
		$prints[$row['fk_print']] = $row['name'];
	$colors = array();
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('email', $input_error)) 
			$email['class'] = 'target';
	}
?>

<script type="text/javascript">
	function isNumeric(str) {
		var er = /^[0-9]+$/;
		return (er.test(str));
	}
	function addCart(viewName){
		var min_quantity 	= <?=$result['qty_min']?>;
		var id	 			= $('#id').val();
		var opt_color 		= $('#opt_color').val();
		var quantity 		= $('#quantity').val();
		var qty_colors 		= parseInt($('#qty_colors').val());
		var type_prints 	= $('#type_prints').val();
		if((quantity >= min_quantity) && (isNumeric(quantity)))
		{
			quantity =parseInt($('#quantity').val());
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			var dados		= {id:id,opt_color:opt_color,quantity:quantity, qty_colors: qty_colors, type_prints:type_prints};
			$('#status').html(iconCarregando);
			jQuery.ajax({
			type: "POST",
			url:  viewName,
			data: dados,
			dataType: 'json',
			success: function(resp){
				if(resp.error == null || resp.error == '' || !resp.error || resp.error == false)
				{
					$('#status').html('');
					$('#status').html(resp.msg);
					$('#status').css('color','green');
					$('#carro').append(resp.line);
					$('.sendCart').css('display','block');
				}
				else
				{
					$('#status').html('');
					$('#status').css('color','red');
					$('#status').html(resp.msg);
				}
				},
				async: true
			});
		}
		else
		{
			$('#status').html('...');
			$('#status').html('Verifique la candidad mínima.');
		}
	}
 </script>
 
<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('.excluir').click(function(e) {
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var r = confirm("Desea realmente borrar?");
		if (r==true)
		{
			var id = $(this).attr('idcot');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>cart/deleteCot/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#cot'+id).fadeOut(200);
						return false;
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
});
</script>
 
<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('#type_prints').change(function(e) {
		var id = $('#type_prints').val();
		e.preventDefault();
		var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" />');
		$('#status').html(iconCarregando);
		$.get('<?=base_url()?>product/getQColors/'+id, 
		function(data) {
			var returnedData = JSON.parse(data);
			$('#status').html('');
			$('#qty_colors').html('');
			$('#qty_colors').html(returnedData.options);
			return true;
		},
		'html');
		return true;
	});
	
});
</script>
<!-- Page Content -->
<div class="container">
	<div class="row">

		<div class="col-lg-3">
			<?php $this->load->helper('left_sidebar');?>
  		</div>

		<div class="col-lg-9">
			<?php $this->industry->getTags(isset($industry)?$industry:'');?>
        	<div class="row">

			<div class="container-fluid">
  				<?php
            		if(isset($breadcrumb)&&  !is_null($breadcrumb)){
            	?>   
				<div class="row-fluid">
	    			<div class="span12">
	       				<div class="span2"></div>
	       				<div class="span10" style="margin-left:5px;">
	          				<div>
	             				<ul class="breadcrumb">
					                <?php
					                   foreach ($breadcrumb as $key=>$value) {
					                    if($value!=''){
					                   ?>
					                <li><a href="<?=$value; ?>"><?=$key; ?></a> <span class="divider">></span></li>
					                <?php }else{?>
					                <li class="active"><?=$key; ?></li>
					                <?php }
					                   }
					                   ?>     
	             				</ul>
	          				</div>
	       				</div>
	    			</div>
				</div>
		 		<?php 
		            }
		     	?>    
   			</div>

			<!-- Begin Products -->
			<div class="container-fluid">
				<h2><?php echo $result[0]['name']?><small style='margin: 0px 0px 0px 10px; font-size: 12px;'><i><?=$category[0]['name']?></i></small></h2>
				<div id='nav'>
					<a href="<?php echo (isset($prev))?$prev:'#'?>" class='prev'>
						<< Producto Anterior
					</a>
					<a href="<?php echo (isset($next))?$next:'#'?>" class='next'>
						Próximo Producto >>
					</a>
				</div>
				
				<div id='product_detail' class='image'>
					<?php if(count($photos)>0){?>
					<script>
					$(document).ready(function(){
						$('.thumb').click(function(e) {
							var src = $(this).attr('src');
							var x = $(this).attr('x');
							var y = $(this).attr('y');
							var download = $(this).attr('download');
							var path = $(this).attr('path');
							$('.preview').attr('src',src);
							$('.preview').attr('width',x);
							$('.preview').attr('height',y);
							$('#download').attr('href',download);
						})
					})
					</script>

					<div id="preview" align="center">
						<img class="preview" src="<?=$photos[1]['url']?>" alt="<?=$result[0]['name']?>" width="<?=$photos[1]['w']?>" height="<?=$photos[1]['h']?>"/></a></li>
					</div>
					
					<!--div class='download' title='Download'>
						<a id='download' href='<?=$photos[1]['download']?>' target='_blank'>
							<img src='<?=base_url('public/images/icones/ico_download.png')?>'>
						</a>
					</div-->
					
					<div class="thumbnails">
						<?php foreach ($photos as $key => $value) {?>
							 <img class='thumb' x='<?php echo $value['w']?>' y='<?php echo $value['h']?>'src="<?php echo $value['url']?>" download="<?php echo $value['download']?>" />
						<?php }?>
					</div>
					
					
					<?php }else{?>
						no photos found
					<?php }?>
				</div>
				<div id='product_detail' class='description'>
					<div id='detail'>
						<input type="hidden" name="id" value="<?=$result[0]['id']?>" id="id"/>
						<p><strong>Código: </strong>C<?php echo $result[0]['fk_category']?>P<?php echo str_pad($result[0]['id'], 4, "0", STR_PAD_LEFT);?> <?//=$result['code_origin']?></p>
						<p><strong>Producto: </strong><?php echo $result[0]['name']?></p>
						<p><i><?php echo $result[0]['description']?></i></p>
						<p><strong>Dimensiones: </strong>
							<?php echo (isset($result[0]['height']) and ($result[0]['height']!=0))?$result[0]['height']:'-'?>
							<?php echo (isset($result[0]['width']) and ($result[0]['width']!=0))?' x '.$result[0]['width']:'-'?>
							<?php echo (isset($result[0]['depth']) and ($result[0]['depth']!=0))?' x '.$result[0]['depth']:''?>
							<i>(cm)</i>
						</p>
						<p><strong>Cantidad Minima:</strong> <?php echo $result[0]['qty_min']?></p>
						<p><strong>Quantidade: </strong><?php echo form_input($quantity)?></p><img src='<?php echo base_url('public/images/icones/mais.png')?>' class='add' title='Agregar Producto' onclick="javascript: addCart('<?php echo base_url()?>cart/add');"><br>
					</div>
					<div class="cl">&nbsp;</div>
					<br>
					<div class='budget'>
						<p class='title'>Selecione a quantidade su Cotización</p>
						<table border="0" width="100%" class="carro">
							<tr>
								<th>Quantidade</th>
								<th></th>
							</tr>
							<tr>
								<td><?php echo form_input($quantity)?></td>
								<?php echo form_dropdown('opt_color',$opt_color,'','style="width: 50px; display: none;" id="opt_color"')?>
								<td></td>
							</tr>
							<tr>
								<td align="center">
									<span id='status'><?php echo (isset($cart[0]['status']) and $cart[0]['status']!='W')?'Presupuesto enviado!':''?></span>
								</td>
								<td align="right">
									<img src='<?php echo base_url('public/images/icones/mais.png')?>' class='add' title='Agregar Producto' onclick="javascript: addCart('<?php echo base_url()?>cart/add');">
									<br>
								</td>											
							</tr>
						</table>
						
						
					</div>
					<div class='budget'>
						<p class='title'>Productos Cotizados</p>
						<table width="100%" class='carro' id="carro">
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<!--th>Color</th-->
							</tr>
							<?php if(isset($cart[0])){?>
								<?php if($cart[0]['status']=='W'){?>
									<?php foreach($cartList as $index => $row){?>
										<tr>
											<td><i>P<?php echo str_pad($row['fk_product'], 4, "0", STR_PAD_LEFT);?></i> - <?=$row['prod_name']?>	</td>
											<td><?php echo $row['quantity']?></td>
											<!--td><div id='color_box' style='background-color: <?=$row['color_hexa']?>' title='<?=$row['color_name']?>'></div></td-->
											<!--td><?php echo ($row['print_name']=='' and $row['print_description']=='')?'sin personalización':(($row['print_name']!='')?$row['print_name']:$row['print_description'])?> - <i><?=$row['color_quantity']?> <?=($row['color_quantity']==1)?'color':'colores'?></i></td-->
										</tr>
									<?php }?>
								<?php }?>
							<?php }?>
						</table>
						<p class='sendCart'><a href='<?php echo base_url('cart/detail')?>'>Finalizar</a></p>
					</div>
				</div>
			<div class="cl">&nbsp;</div>
		</div>
		<!-- End Products -->

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->