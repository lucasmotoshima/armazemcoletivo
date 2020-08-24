<?php 
	if(isset($result['id'])){
		$hidden = array('id' => $result['id']);
	}
	
	$quantity = array(
      'name'        => 'quantity',
      'id'          => 'quantity',
      'value'       => '1',
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
	function abreThumb(src,w,h){
		$('#preview').attr('src',src);
		$('#preview').attr('width',w);
		$('#preview').attr('height',h);
	};
 </script>
 <script type="text/javascript">
	function alerta(type,msg){
		alert(msg);
	}
	function addCart(viewName){
		var min_quantity 	= <?php echo $result[0]['qty_min']?>;
		var id	 			= $('#id').val();
		var quantity 		= parseInt($('#quantity').val());
		if((quantity >= min_quantity) && (isNumeric(quantity)))
		{
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			var dados			= {id:id,quantity:quantity};
			$('#status').html(iconCarregando);
			jQuery.ajax({
				type: "POST",
				url:  viewName,
				data: dados,
				dataType: 'json',
				success: function(resp){
					if(resp.error == null || resp.error == '' || !resp.error || resp.error == false)
					{
						$('#carro').append(resp.line);
						$('.sendCart').css('display','block');
					}
					else
					{
						alerta('warning',resp.msg);
					}
				},
				async: true
			});
		}
		else
		{
			alert('Verifique a quantidade mínima.');
		}
	}
	
	function isNumeric(str) {
		var er = /^[0-9]+$/;
		return (er.test(str));
	}
	
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
	
	$('.plans').click(function(){
		if($("#addPlan").is(":visible"))
			$('#addPlan').fadeOut( "slow", function() {});
		else
			$('#addPlan').fadeIn( "slow", function() {});
	})
	
</script>
 
 <div class="container" >
	<div class="row" style="background-color: #ca9a0026; padding: 0px 15px; min-height: 15px; margin-bottom: 20px;border: 1px solid #eadaa7;"></div>
	<div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" id="dialog" aria-hidden="true" style="display: none; padding-right: 17px; margin: 150px 0px 0px 0px; "></div>
</div>
<!-- Page Content -->
<div class="container">
	<div class="row">

		<div class="col-lg-3">
			<?php $this->load->helper('left_sidebar');?>
  		</div>

		<div class="col-lg-9">
			<?if(isset($provider)){?>
				<h1 style="background-color: #e8e8e8; padding: 5px 0px 7px 10px;"><?php echo $result[0]['name']?> <small><?=$provider[0]['name'];?> </small></h1>
				<small style="margin-left: 10px;"><a href="<?=base_url('product/getByProvider/'.$provider[0]['id']);?>">ver mais de <b><?=$provider[0]['name'];?></b></a></small>
			<?}?>
        	<div class="row">
        		<div class="col-md-12">
					<div id='nav'>
						<a href="<?php echo (isset($prev))?$prev:'#'?>" class='prev'>
							<< Produto Anterior
						</a>
						<a href="<?php echo (isset($next))?$next:'#'?>" class='next'>
							Próximo Produto >>
						</a>
					</div>
        		</div>
				<div class="col-md-6">
					<?php if(count($photos)>0){?>

					<div align="center">
						<img id="preview" class="preview" src="<?=$photos[1]['url']?>" alt="<?=$result[0]['name']?>" width="<?=$photos[1]['w']?>" height="<?=$photos[1]['h']?>"/></a></li>
					</div>
					
					<div class="thumbnails">
						<?php foreach ($photos as $key => $value) {?>
							 <img class="mini" onclick="javascript: abreThumb('<?php echo $value['url']?>','<?php echo $value['w']?>','<?php echo $value['h']?>');" x="<?php echo $value['w']?>" y="<?php echo $value['h']?>" src="<?php echo $value['url']?>" download="<?php echo $value['download']?>" />
						<?php }?>
					</div>
					
					<?php }else{?>
						no photos found
					<?php }?>
				</div>
				<div class="col-md-6">
					<div id='detail'>
						<input type="hidden" name="id" value="<?=$result[0]['id']?>" id="id"/>
						<p><h3><strong>R$ <?php echo str_replace('.', ',', $result[0]['price']) ?></strong></h3></p>
						<p><strong>Produto: </strong><?php echo $result[0]['name']?><small> (<?php echo $result[0]['code_origin']?>)</small></p>
						<p><strong>Descrição </strong><?php echo $result[0]['description']?></p>
						<p><strong>Dimensões: </strong>
							<?php echo (isset($result[0]['height']) and ($result[0]['height']!=0))?$result[0]['height']:'-'?>
							<?php echo (isset($result[0]['width']) and ($result[0]['width']!=0))?' x '.$result[0]['width']:'-'?>
							<?php echo (isset($result[0]['depth']) and ($result[0]['depth']!=0))?' x '.$result[0]['depth']:''?>
							<i>(cm)</i>
						</p>
						<p><strong>Tempo de Entrega:</strong> <?php echo $product_provider[0]['delivery_time']?> dias</p>
						<p><strong>Quantidade Mínima:</strong> <?php echo $result[0]['qty_min']?></p>
						<p><strong>Quantidade: </strong><?php echo form_input($quantity)?></p>
						<button class="btn btn-success" onclick="javascript: addCart('<?php echo base_url()?>cart/add');">Adicionar ao Carrinho</button>
					</div>
					<div class="cl">&nbsp;</div>
					<div class='budget'>
						<p class='title'>Carrinho de Compras</p>
						<table width="100%" class='carro' id="carro">
							<tr>
								<th>Produto</th>
								<th align="center">Qtde. de unidades</th>
								<th width="80" align="center">Preço/un.</th>
							</tr>
							<?php if(isset($cart[0])){?>
								<?php if($cart[0]['status']=='W'){?>
									<?$tot = 0;?>
									<?php foreach($cartList as $index => $row){?>
										<?$tot = $tot + $row['product_unit_price'];?>
										<tr>
											<td><i>P<?php echo str_pad($row['fk_product'], 4, "0", STR_PAD_LEFT);?></i> - <?=$row['prod_name'].'<small> '.$row['prod_description'].'</small>'?>	</td>
											<td><?php echo $row['quantity']?></td>
											<td><?php echo 'R$ '.number_format($row['product_unit_price'], 2, ',', ' ') ?></td>
										</tr>
									<?php }?>
								<?php }?>
							<?php }?>
						</table>
						<p class='sendCart'><a href='<?php echo base_url('cart/detail')?>'>Finalizar</a></p>
					</div>
					<div style="background-color: #f7f7f7; margin: 0px 0px 20px 0px; padding: 10px 10px 20px 10px;">
						<center><a href="https://api.whatsapp.com/send?phone=55<?=str_replace(' ','',preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $provider[0]['phone1']))?>&text=Oi%2C%20peguei%20seu%20contato%20pelo%20Armaz%C3%A9m%20Coletivo.%20Tudo%20bem%3F"><img src="<?=base_url('public/images/ContatoWhatsapp.png')?>"></a></b>.</center>					
						<center>
							<a title="Compartilhar página de <?=$provider[0]['name'];?> no WhatsApp" href="https://api.whatsapp.com/send?text=<?=base_url('product/detail/'.$result[0]['id'])?>"><img class="wp_share" src="<?=base_url('public/images/whatsapp_share2_off.gif')?>"></a>
							<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?=base_url('product/detail/'.$result[0]['id'])?>" target="_blank" title="Compartilhar página de <?=$provider[0]['name'];?> no Facebook"><img class="fb_share"  src="<?=base_url('public/images/facebook_share2_off.gif')?>"></a>
						</center>	
					</div>
				</div>
				<div class="col-md-12">
					<center><a href='<?php echo base_url()?>' class="btn btn-success" style="width: 100%;">Continuar Comprando</a></center>
					<br>
					<br>
				</div>
				<br>
				<br>

        	</div>
        <!-- /.row -->
      	</div>
      	<!-- /.col-lg-9 -->
	</div>
	<!-- /.row -->
</div>
<!-- /.container -->