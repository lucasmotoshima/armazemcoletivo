<?
	if(isset($cart[0]['id'])){
		$hidden = array('id' => $cart[0]['id']);
	}
	$date = array(
      'name'        => 'date',
      'id'          => 'date',
      'value'       => (isset($cart[0]['date'])?($this->format_date->us2br($cart[0]['date'])):''),
      'class'       => 'form-control',
      'readonly'	=> ''
    );
	$client_name = array(
      'name'        => 'client_name',
      'id'          => 'client_name',
      'value'       => (isset($cart[0]['client_name'])?$cart[0]['client_name']:''),
      'class'       => 'form-control',
      'readonly'	=> ''
    );
	$adress = array(
      'name'        => 'adress',
      'id'          => 'adress',
      'value'       => (isset($cart[0]['adress'])?$cart[0]['adress']:''),
      'class'       => 'form-control',
    );
	$number = array(
      'name'        => 'number',
      'id'          => 'number',
      'value'       => (isset($cart[0]['number'])?$cart[0]['number']:''),
      'class'       => 'form-control',
    );	
	$city = array(
      'name'        => 'city',
      'id'          => 'city',
      'value'       => (isset($cart[0]['city'])?$cart[0]['city']:''),
      'class'       => 'form-control',
      'readonly'	=> ''
    );	
	$email = array(
      'name'        => 'email',
      'id'          => 'email',
      'value'       => (isset($cart[0]['email'])?$cart[0]['email']:''),
      'class'       => 'form-control',
    );
	$phone = array(
      'name'        => 'phone',
      'id'          => 'phone',
      'value'       => (isset($cart[0]['phone'])?$cart[0]['phone']:''),
      'class'       => 'form-control',
    );
	$obs = array(
      'name'        => 'obs',
      'id'          => 'obs',
      'value'       => (isset($cart[0]['obs'])?$cart[0]['obs']:''),
      'class'       => 'form-control',
    );
?>

<script type="text/javascript"> 
$(document).ready(function(){
	
	$('#status').css('display','block');
	
	$('.excluir').click(function(e) {
		var r = confirm("Deseja realmente excluir?");
		if (r==true){
			return true;
		}else{
			return false;			
		}
	});
	
	$("#adress").change(function() {
		$('#statusCart').html('<p style="color: red;">Dados NÃO salvos.</p>');
	});
	$("#number").change(function() {
		$('#statusCart').html('<p style="color: red;">Dados NÃO salvos.</p>');
	});
	$("#email").change(function() {
		$('#statusCart').html('<p style="color: red;">Dados NÃO salvos.</p>');
	});
	$("#phone").change(function() {
		$('#statusCart').html('<p style="color: red;">Dados NÃO salvos.</p>');
	});
	$("#obs").change(function() {
		$('#statusCart').html('<p style="color: red;">Dados NÃO salvos.</p>');
	});	
	
});
</script>
<script>
function changeStatus(id,elemento,viewName)
{
	var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
	var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
	var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
	$('#status').html(iconCarregando);
	jQuery.ajax({
	type: "POST",
	url: viewName+"/changeStatus/"+id,
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

function sendEmail(id)
{
	alert('asdasda');
	var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
	var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
	var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
	$('#status').html(iconCarregando);
	jQuery.ajax({
	type: "POST",
	url: viewName,
	data: {id:id},
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
			$('#status').html('');
			$('#status').html(returnedData.msg);
		}
		},
		async: true
	});
}

function saveCart(id)
{
	alert('asdasda');
	var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
	var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
	var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
	$('#status').html(iconCarregando);
	jQuery.ajax({
	type: "POST",
	url: viewName,
	data: {id:id},
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
			$('#status').html('');
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
			<h3>Pedidos</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Lista de Produtos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="col-md-7 col-sm-6 col-xs-6">
						<?$attributes = array('name' => 'cartForm', 'id' => 'cartForm','enctype'=>'multipart/form-data');?>
						<?=form_open('cart/save',$attributes,isset($hidden)?$hidden:'');?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label>Pedido: <h2><?='#'.$cart[0]['id'];?></h2></label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label>Data: <h3><?=(isset($cart[0]['date'])?($this->format_date->us2br($cart[0]['date'])):'')?></h3></label>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label>Cliente</label>
								<?=form_input($client_name)?>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<label>Rua</label>
								<?=form_input($adress)?>
							</div>				
							<div class="col-md-2 col-sm-12 col-xs-12">
								<label>Numero</label>
								<?=form_input($number)?>
							</div>	
							<div class="col-md-4 col-sm-12 col-xs-12">
								<label>Cidade</label>
								<?=form_input($city)?>
							</div>	
							<div class="col-md-8 col-sm-12 col-xs-12">
								<label>E-mail</label>
								<?=form_input($email)?>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<label>Phone</label>
								<?=form_input($phone)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label>Obs</label>
								<?=form_textarea($obs)?>
							</div>
							<div class="col-md-5 col-sm-5 col-xs-5" style="margin-top: 15px;">
								<input class="btn btn-success" value="Salvar Dados" type="submit">
							</div>
							<div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 15px;" id="statusCart">
								Dados Salvos
							</div>
						<?=form_close()?>
						</div>
						<div class="col-md-5 col-sm-6 col-xs-6">
							<h3>Mensagens de interação para WhatsApp</h3>
							<p>
								<?
								if(date('A')=='PM'){//tarde ou noite
									if(date('g') >= 1 and date('g') < 6){
										$saudacao = "Boa tarde";
									}else{
										$saudacao = "Boa noite";
									}	
								}else{
									$saudacao = "Bom dia";
								}
								?>
								<?$pos = strpos($cart[0]['client_name'], ' ')?>
								
								<?$x = rand();?>
								<?if($x%2){?>
									<?=$saudacao?> <?=substr($cart[0]['client_name'], 0,$pos)?>, tudo bem?! Aqui é o <?=substr($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), 0,$pos)?> do Armazém Coletivo.	
								<?}else{?>
									Oi <?=substr($cart[0]['client_name'], 0,$pos)?>, aqui é o <?=substr($this->perfil->getNome($_SESSION['adm_armazem']['user']['id']), 0,$pos)?> do Armazém Coletivo, <?=strtolower($saudacao)?> tudo bem?
								<?}?>
								
								<br>
								Vimos que essa é a sua <?=$qtde+1?>ª compra com a gente, muito obrigado.
							</p>
							<?
								$totTx 			= 0;
								$totValUnit 	= 0;
								$totVal 		= 0;
							?>
							
							*
							<p>
								<?if($qtdeProd!=1){?>
									Estes são os produtos que você escolheu. Vamos confirmar o seu pedido das <?=$qtdeProd?> unidades dos seus <?=$qtdeUnit?> produtos, tudo bem?<br>
								<?}else{?>
									Estes são os produtos que você escolheu. Vamos confirmar o seu pedido para inciarmos o processo de produção/entrega do seu produto, tudo bem?<br>
								<?}?>
								<?
									echo "Pedido: <b>(#".$cart[0]['id'].")</b><br>";
									if(count($result)!=0){
										foreach($result as $index => $row){
											$totTx 			= $totTx + $row['profit_perc'];
											$totValUnit 	= $totValUnit + ($row['product_total_price'] * $row['quantity']);
											$totVal 		= $totVal + ($row['product_total_price'] );
											echo $row['quantity'].' unidade'.(($row['quantity']>1)?'s':'').' de '.$row['prod_name'].' ('.$row['quantity'].' x R$'.number_format($row['product_total_price']/$row['quantity'], 2, ',', '.').')<br>';
										}
										echo '<b>Total: R$'. number_format($totVal, 2, ',', '.').'</b>';
									}
								?>
							</p>
							*
							<?if($prov>1){?>
								<p>
									Você comprou produtos de <?=($prov);?> fornecedores diferentes, mas isso não tem problema, pois você receberá um e-mail de cada fornecedor com valor, com descritivo e data de entega correspondentes.  
								</p>								
							<?}?>
							<p>
								<?=substr($cart[0]['client_name'], 0,$pos)?>, seu<?=(($prov==1)?'':'s');?> pedido<?=(($prov==1)?'':'s');?> fo<?=(($prov==1)?'i':'ram');?> confirmado<?=(($prov==1)?'':'s');?> e sua<?=(($prov==1)?'':'s');?> entrega<?=(($prov==1)?'':'s');?> ser<?=(($prov==1)?'á':'ão');?> entregue<?=(($prov==1)?'':'s');?> em até <?=$deliveryTime?> dias. Enviamos um e-mail com os detalhes de seu pedido. <br>
							</p>
							*
							<p>
								Muito Obrigado por escolher o Armazém Coletivo.<br>
								Posso te ajudar em algo mais?
							</p>
						</div>
					</div>
					<div class="x_content">
						<h3>Listagem de produtos do pedido.</h3>
						<table border="0" class='table'>
						<?
							$totTx 			= 0;
							$totValUnit 	= 0;
							$totVal 		= 0;
						?>
						<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr>
									<th>Fornecedor</th>
									<th>Produto</th>
									<th>Tempo Entrega</th>
									<th>Foto</th>
									<th>Quantidade</th>
									<th>Taxa</th>
									<th>Val Unit.</th>
									<th>Valor Total</th>
									<th>Ações</th>
								</tr>
								<?
								$totTx 			= $totTx + $row['profit_perc'];
								$totValUnit 	= $totValUnit + ($row['product_total_price'] * $row['quantity']);
								$totVal 		= $totVal + ($row['product_total_price']);
								?>
								<tr id='cart_product<?=$row['id']?>'>
									<td><?=$row['provider_name']?></td>
									<td align="left"><strong><?=$row['prod_name']?></strong><br><small><?=$row['prod_code_origin'];?></small></td>
									<td><strong><?=$row['delivery_time']?><br><?=$row['delivery_time_mes']?><br><?=$row['delivery_time_semana']?></strong></td>
									<td><img src="<?=$row['photo_url']?>" width="<?=$row['photo_w']?>" height="photo_h"></td>
									<td align="center"><?=$row['quantity']?></td>
									<td>R$ <?=number_format($row['profit_perc'], 2, ',', '.')?></td>
									<td>R$ <?=number_format($row['product_unit_price'], 2, ',', '.')?></td>
									<td>R$ <?=number_format($row['product_total_price'], 2, ',', '.')?></td>
									<td>
										<a href="<?php echo base_url('cart_product/form/'.$row['id'].'')?>">
											<img src="http://logoideas.cl/admin/public/images/icones/ico_edita.png" title="Editar">
										</a>
										<a href="<?php echo base_url('cart_product/deleteProduct/'.$row['id'].'')?>" class='excluir' idproduct='<?=$row['id']?>'>
											<img src="<?php echo base_url('public/images/icones/ico_excluir.png')?>">
										</a>									
									</td>
								</tr>
								<?endforeach?>
								<tr>
									<td colspan="4">Totais</td>
									<td><?=number_format($totTx, 2, ',', '.')?></td>
									<td></td>
									<td><?=number_format($totVal, 2, ',', '.')?></td>
								</tr>
							<?}else{?>
								<tr>
									<td colspan="8"><center>Nenhum registro encontrado</center></td>
								</tr>
							<?}?>
						</table>
					
					<?$enviado = base_url('public/images/icones/ico_mail.png')?>
					<?$noEnviado = base_url('public/images/icones/ico_mail_open.png')?>
					
					<div class='mail'>
						<a href='<?=base_url("cart/sendEmailProvider/".$cart[0]['id'])?>'>
							Enviar email <img class='sendEmail' src="<?=($cart[0]['status']=='N')?$noEnviado:$enviado?>" title='<?=($cart[0]['status']=='N')?'No Enviado':'Enviado'?>'>
						</a>
					</div>

					<?if(isset($paginacao)){?>
						<div id="paginacao"><?=$paginacao?></div>
					<?}?>
				</div>
			</div>
		</div>
	</div>	
</div>