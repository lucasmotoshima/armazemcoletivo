<?php
	if(isset($_REQUEST['id'])){
		$hidden = array('id' => $_REQUEST['id']);
	}
	
	$codigo = array(
      'name'        => 'code',
      'id'          => 'code',
      'value'       => (isset($_REQUEST['code'])?$_REQUEST['code']:''),
      'class'       => 'form-control',
    );
	
	$email = array(
      'name'        => 'email',
      'id'          => 'email',
      'value'       => (isset($_REQUEST['email'])?$_REQUEST['email']:''),
      'class'       => 'form-control',
    );
	
	$phone = array(
      'name'        => 'phone',
      'id'          => 'phone',
      'value'       => (isset($_REQUEST['phone'])?$_REQUEST['phone']:''),
      'class'       => 'form-control',
    );
?>
<script type="text/javascript"> 
	$(document).ready(function () {
		$('#phone').mask('(99) 9 9999 9999');
		<?if($result[0]['fk_cart']!=''){?>
		var intervalo = window.setInterval(function() {
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url('cart/getPedidosJson')?>',
			data: {
				lastId:<?=$result[0]['fk_cart']?>,
				ProviderId:<?=$provider[0]['id']?>,
				},
			dataType: 'json',
			success: function(returnedData){
				if(	returnedData.status == '1'){
					alert('você possui novos pedidos.');
					location.reload();
				}
				},
			async: true
			});
		}, 15000);
		<?}?>
	});
</script>


<div class="container">
	<div class="row" style="text-align: center;">
		<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 30px; margin-top: 20px; padding: 30px; background-color: #FFD242; border-radius: 10px;">
			<center>
				<h4>Insira seu Código de Fornecedor, E-mail, Telefone cadastrados e liste todas os seus pedidos online.</h4>	
			</center>
		</div>
	</div>
	<div class="row">
		
		<div class="col-lg-8" style="">
			<h2 style="background-color: #e8e8e8; border-radius: 5px; padding: 5px 10px;"><?=(isset($provider[0]['name'])?$provider[0]['name']:'')?><small class="title-bottom">&nbsp;<?=(isset($provider[0]['description'])?$provider[0]['description']:'')?></small></h2>
			<!--center><h4>O Armazém Coletivo verificará os pedidos feitos de Segunda a Sábado das 9:00 às 17:00.</h4></center-->
			<!--label><b style="font-size: 16px; color: green;">Pedidos Verificados:</b> São pedidos confirmados via WhatsApp pelo Armazém Coletivo de Segunda a Sábado em horário comercial.</label-->
			<!--label><b style="font-size: 16px; color: red;">Pedidos Não Verificados:</b> São aqueles pedidos feitos fora de nosso horário comercial.</label-->
			<center><h2>Lista de Pedidos</h2></center>
			<?$tot = 0?>
			<?$cartAnt = ''?>
			<style type="text/css" media="screen">
				.cart tr td{padding: 0; font-size: 12px;}
				.cart tr th{padding: 3px; font-size: 13px;}
				.cart tr td label{margin-bottom: 0;}
			</style>
			<?//$this->debug->show($results);?>
			<?php if(isset($result)){?>
				<?php if(count($result)!=0){?>
					<table class='cart table'>
					<?php foreach($result as $index => $row){?>
						<?if($cartAnt != $row['fk_cart']){?>
							<?if($cartAnt != '' and $cartAnt != $row['fk_cart']){?>
								<tr>
									<td colspan="2" align="right" style="text-align: right;"><b style="font-size: 14px;">Total</b></td>
									<td id="td_total" colspan='2' align="center"><b style="font-size: 14px;">R$ <? echo number_format($tot, 2, ',', ' ');?></b></td>
								</tr>
							<?}?>
							<?$tot = 0?>
							<tr>
								<td colspan="5" style="font-size: 12px;">
									<?=(($row['cart_status']=='Y')?'<strong style="font-size: 16px; color: green;"> Verificado':'<strong style="font-size: 16px; color: red;"> Não Verificado')?></strong><br>
									<?
										$f = date('d/m/Y', strtotime("+".$row['deliveryTime']." day".(($row['deliveryTime']>1)?'s':''),strtotime(date('d-m-Y'))));
										$z = $this->format_date->diaSemana($f);
									?>
									<strong style="font-size: 16px;"><?= '#'.$row['fk_cart'].' '?></strong><label><b><?= $row['client_hour']?> | <?= $row['client_date']?></b></label><br>
									<label><b>Entrega: </b><strong style="font-size: 16px;"><?= $f?>, <?= $z[1]?></strong></label><br>
									<label><b>Cliente: </b><?= $row['client_name']?></label><br>
									<label><b>Telefone: </b><?= $row['client_phone']?></label><br>
									<label><b>E-mail: </b><?= $row['client_email']?></label><br>
									<label><b>Endereço: </b><?= $row['client_adress']?> ,<?=$row['client_number']?> - <?=$row['client_city']?></label>
								</td>
							</tr>
					
						<tr>
							<th>Produto</th>
							<th>Valor Unitário</th>
							<th align="center"><center>Subtotal</center></th>
						</tr>
						<?}?>
						<tr id='product<?php echo $row['id']?>'>
							<td>
								<i> <?php $row['prod_code_origin']?></i> 
									<?php echo $row['prod_name']?>	
							</td>
							<td>R$ <? echo number_format($row['product_unit_price'], 2, ',', ' ');?><input name="product_unit_price" id="product_unit_price" type="hidden" value="<?=number_format($row['product_unit_price'], 2, ',', ' ');?>">
								x <?=$row['quantity']?>
							</td>
							<?$tot = $tot + $row['product_total_price']?>
							<td align="center"><b>R$ <? echo number_format($row['product_total_price'], 2, ',', ' ');?><input name="product_total_price" id="product_total_price_<?=$row['id']?>" type="hidden" value="<?=number_format($row['product_total_price'], 2, ',', ' ');?>"></b></td>
							<!--td>
								<a href="<?php echo base_url('cart/deleteProduct/'.$row['id'].'')?>" class='excluir' idproduct='<?=$row['id']?>'>
									<img src="<?php echo base_url('public/images/icones/ico_excluir.png')?>">
								</a>
							</td-->
						</tr>
						<?$cartAnt = $row['fk_cart'];?>
					<?php }?>
					<tr>
						<td colspan="2" align="right" style="text-align: right;"><b style="font-size: 14px;">Total</b></td>
						<td id="td_total" colspan='2'><center><b style="font-size: 14px;">R$ <? echo number_format($tot, 2, ',', ' ');?></b></center></td>
					</tr>
				</table>
				<?php }else{?>
					<p><center><b style="color: red; font-size: 16px;"><?=isset($msg)?$msg:'Erro'?></b></center></p>
				<?}?>
			<?}else{?>
				<p><center><?=isset($msg)?$msg:'Erro'?></center></p>
			<?}?>
		</div>
		<div class="col-lg-4">
			<?php $attributes = array('name' => 'cartForm', 'id' => 'cartForm','enctype'=>'multipart/form-data');?>
			<?php echo form_open('cart/getPedidos',$attributes,isset($hidden)?$hidden:'');?>
			<h2 style="background-color: #e8e8e8; border-radius: 5px; padding: 5px 10px;">Insira seus dados<span class="title-bottom">&nbsp;</span></h2>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<label>Código *</label>
					<?php echo form_password($codigo)?>
				</div>
			
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<label>Email * </label>				
					<?php echo form_input($email)?>
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<label>Telefone *</label>
					<?php echo form_input($phone)?>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<b>Quer ajuda?</b><br>Clique aqui <b><a href="https://api.whatsapp.com/send?phone=5512997249283&text=Ol%C3%A1%2C%20estou%20com%20dificuldades%20em%20listar%20os%20meus%20pedidos%20no%20Armaz%C3%A9m%20Coletivo.%20Voc%C3%AA%20pode%20me%20ajudar%3F">(12) 9 9724 9283</a></b>.
					
				</div>
				<input type="submit" class="btn btn-success" value="Enviar" style="width: 100%"/><i>* Campos Obrigatórios</i>
			<?php echo form_close()?>
		</div>
	</div>
</div>
<br><br>
