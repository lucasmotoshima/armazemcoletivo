<?
	if(isset($cart_product[0]['id'])){
		$hidden = array('id' => $cart_product[0]['id']);
	}
	
	$quantity = array(
      'name'        => 'quantity',
      'id'          => 'quantity',
      'value'       => (isset($cart_product[0]['quantity'])?number_format($cart_product[0]['quantity'], 0, ',', '.'):''),
      'style'       => 'width: 50px;',
    );
	
	$tax_perc = array(
      'name'        => 'tax_perc',
      'id'          => 'tax_perc',
      'value'       => (isset($cart_product[0]['tax_perc'])?number_format($cart_product[0]['tax_perc'], 0, ',', '.'):''),
      'style'       => 'width:50px;',
    );
	
	$profit_perc = array(
      'name'        => 'profit_perc',
      'id'          => 'profit_perc',
      'value'       => (isset($cart_product[0]['profit_perc'])?number_format($cart_product[0]['profit_perc'], 0, ',', '.'):''),
      'style'       => 'width:50px;',
    );
	
	$product_original_price = array(
      'name'        => 'product_original_price',
      'id'          => 'product_original_price',
      'value'       => (isset($cart_product[0]['product_original_price'])?number_format($cart_product[0]['product_original_price'], 0, ',', '.'):''),
      'style'       => 'width: 50px;',
    );
	
	$product_original_sale_price = array(
      'name'        => 'product_original_price',
      'id'          => 'product_original_price',
      'value'       => (isset($cart_product[0]['product_original_sale_price'])?number_format($cart_product[0]['product_original_sale_price'], 0, ',', '.'):''),
      'style'       => 'width: 50px;',
    );
	
	$product_unit_price_old = array(
      'name'        => 'product_unit_price_old',
      'id'          => 'product_unit_price_old',
      'value'       => (isset($cart_product[0]['product_unit_price_old'])?number_format($cart_product[0]['product_unit_price_old'], 0, ',', '.'):''),
      'style'       => 'width: 50px;',
    );
	
	$product_unit_price = array(
      'name'        => 'product_unit_price',
      'id'          => 'product_unit_price',
      'value'       => (isset($cart_product[0]['product_unit_price'])?number_format($cart_product[0]['product_unit_price'], 0, ',', '.'):''),
      'style'       => 'width:50px;',
      'readonly'	=> '',
    );
	
	$product_unit_tax = array(
      'name'        => 'product_unit_tax',
      'id'          => 'product_unit_tax',
      'value'       => (isset($cart_product[0]['product_unit_tax'])?$cart_product[0]['product_unit_tax']:''),
      'style'       => 'width: 50px;',
    );
	
	$product_unit_profit = array(
      'name'        => 'product_unit_profit',
      'id'          => 'product_unit_profit',
      'value'       => (isset($cart_product[0]['product_unit_profit'])?number_format($cart_product[0]['product_unit_profit'], 0, ',', '.'):''),
      'style'       => 'width: 50px;',
    );
	
	$provider_discount = array(
      'name'        => 'provider_discount',
      'id'          => 'provider_discount',
      'value'       => (isset($cart_product[0]['provider_discount'])?$cart_product[0]['provider_discount']:''),
      'style'       => 'width: 50px;',
    );
	
	$print_description = array(
      'name'        => 'print_description',
      'id'          => 'print_description',
      'value'       => (isset($cart_product[0]['print_description'])?$cart_product[0]['print_description']:''),
      'style'       => 'width: 50px;',
    );
	
	$print_unit_price = array(
      'name'        => 'print_unit_price',
      'id'          => 'print_unit_price',
      'value'       => (isset($cart_product[0]['print_unit_price'])?number_format($cart_product[0]['print_unit_price']*$cart_product[0]['color_quantity'], 0, ',', '.'):''),
      'style'       => 'width:50px;',
    );
	
	$print_unit_tax = array(
      'name'        => 'print_unit_tax',
      'id'          => 'print_unit_tax',
      'value'       => (isset($cart_product[0]['print_unit_tax'])?$cart_product[0]['print_unit_tax']:''),
      'style'       => 'width: 50px;',
    );
	
	$print_unit_total = array(
      'name'        => 'print_unit_total',
      'id'          => 'print_unit_total',
      'value'       => (isset($cart_product[0]['print_unit_total'])?$cart_product[0]['print_unit_total']:''),
      'style'       => 'width: 50px;',
    );
	
	$color_quantity = array(
      'name'        => 'color_quantity',
      'id'          => 'color_quantity',
      'value'       => (isset($cart_product[0]['color_quantity'])?$cart_product[0]['color_quantity']:''),
      'style'       => 'width: 50px;',
    );
?>

<script type="text/javascript">
$(document).ready(function(){
	$("#print_unit_price").keyup(function(){
		$("#print_unit_price").val(format($("#print_unit_price").val()));
		$('.recalc').css('display','');
		$('#save').attr('disabled','');
	});
	
	$("#dif").keyup(function(){
		$("#dif").val(format($("#dif").val()));
		$('.recalc').css('display','');
		$('#save').attr('disabled','');
	});
});
	
	function format(val){
	    v=val.replace(/\D/g,"");  //permite digitar apenas números
	    v=v.replace(/[0-9]{12}/,"inválido");   		//limita pra máximo 999.999.999,99
	    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2");  	//coloca ponto antes dos últimos 8 digitos
	    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2");  	//coloca ponto antes dos últimos 5 digitos
	    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2");	//coloca virgula antes dos últimos 2 digitos
		return v;
	};


	function recalc(viewName,idProd){
		var quantity			= $('#quantity').val();
		var idProd				= idProd;

		var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
		var dados = {
				quantity:quantity,
				idProd:idProd,
			};
		$('#status').html(iconCarregando);
		jQuery.ajax({
			type: "POST",
			url:  viewName,
			data: dados,
			dataType: 'json',
			success: function(resp){
				if(resp.error == null || resp.error == '' || !resp.error || resp.error == false)
				{
					$('#quantity').val(resp.quantity);
					$('#product_price').val(resp.product_price);
					$('#dif_perc').val(resp.dif_perc);
					$('#total').val(resp.total);
					$('#discount_limit_p').html(resp.discount_limit);
					
					$('#status').html('');
					$('#status').html(iconConf);
					$('#status').append(resp.msg);
					$('.recalc').css('display','none');
					$('.save').css('display','block');
				}
				else
				{
					$('#status').html('');
					$('#status').html(resp.msg);
					$('.recalc').css('display','none');
					$('.save').css('display','none');
				}
			},
			async: true
		});
	};
	
	function save(viewName){
		var fk_cart_product		= <?=$cart_product[0]['id']?>;
		var quantity			= $('#quantity').val();

		var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
		var dados = {	
			fk_cart_product:fk_cart_product,
			quantity:quantity,
		};
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
				$('.recalc').css('display','none');
				$('.save').css('display','block');
			}
			else
			{
				$('#status').html('');
				$('.recalc').css('display','none');
				$('.save').css('display','none');
			}
			},
		});
	};
	
 </script>

 
<?=isset($menu)?$menu:''?>
<div id="main">
	<?=$this->msg->show(isset($erro)?$erro:'');?>
	<h1><label><?=isset($cart_product[0]['id'])?'Edição de':'Novo'?> Carrinho de Compras</label></h1>
	<?//=$this->debug->show($product,0);?>
	<div id="box_dir">
		<div class="row">
			<a href="<?=base_url('cart_product/getList/'.$cart_product[0]['fk_cart'])?>">
				<img src="<?=base_url('public/images/icones/arrow_left.png')?>" title='Volver'>
			</a>
			<div class="col-lg-3 col-md-3 mb-3">
				<img src="<?=$cart_product[0]['photo']['url']?>" width="<?=$cart_product[0]['photo']['w']?>" height="<?=$cart_product[0]['photo']['h']?>">
			</div>
			<div class="col-lg-9 col-md-9 mb-9">
				<table class="table">
					<tr>
						<th>Produto: </th>
						<td><strong><?=$product[0]['code_origin']?> - <?=$product[0]['name']?></strong></td>
					</tr>
					<tr>
						<th>Preço Unitário: </th>
						<td><strong>R$ <?=number_format($cart_product[0]['product_unit_price'], 2, ',', '.')?></strong></td>
					</tr>
					<tr>
						<th>Taxa Preço Unitário: </th>
						<td><small>R$ <?=number_format(($cart_product[0]['product_unit_price']/100)*$cart_product[0]['tax_perc'],2,',','.')?></small></td>
					</tr>
					<tr>
						<th>Quantidade: </th>
						<td><strong><?=$cart_product[0]['quantity']?></strong></td>
					</tr>
					<tr>
						<th>Taxa Administrativa: </th>
						<td><strong><?=number_format($cart_product[0]['tax_perc'], 0, ',', '.')?> %</strong> </td>
					</tr>
					<tr>
						<th>Total: </th>
						<td><strong><?=number_format(($cart_product[0]['product_unit_price'])*($cart_product[0]['quantity']), 2, ',', '.')?></strong></td>
					</tr>
					<tr>
						<th>Taxa Total: </th>
						<td><small>R$<?=number_format($cart_product[0]['profit_perc'], 2, ',', '.')?></small></td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="row">

			<div class="col-lg-12 col-md-12 mb-12">
				<div  class="col-lg-4 col-md-4 mb-4" style="">
					<div class="col-lg-12 col-md-12 mb-12"><h4>Valores Brutos</h4></div>
					<div class="col-lg-4 col-md-4 mb-4">
						<label>Preço Unitário</label>
						<input type="text" name="product_unit_price" value="<?=number_format($cart_product[0]['product_unit_price'], 2, ',', '.')?>" id="product_unit_price" class="form-control" readonly=''/>
					</div>
					<div class="col-lg-4 col-md-4 mb-4" style="background-color: #e0e0e0; border: 1px solid #CCC;">
						<label>Quantidade</label>
						<input type="text" name="quantity" value="<?=$cart_product[0]['quantity']?>" class="form-control" id="quantity"/>
					</div>
					<div class="col-lg-4 col-md-4 mb-4">
						<label>Preço Total</label>
						<input type="text" name="product_price" readonly="" value="<?=number_format($cart_product[0]['quantity'] * $cart_product[0]['product_unit_price'], 2, ',', '.')?>" class="form-control" id="product_price"/>
					</div>
				</div>

				<div  class="col-lg-6 col-md-6 mb-6" style="">
					<div class="col-lg-12 col-md-12 mb-12"><h4>Margens de Lucro e Descontos</h4></div>
					<div class="col-lg-2 col-md-2 mb-2">
						<label>%</label>
						<input type="text" name="dif_real" readonly='' value="<?=number_format($cart_product[0]['tax_perc'], 0, ',', '.')?>" id="dif_real"  class="form-control"/>	
					</div>
					<div class="col-lg-3 col-md-3 mb-3">
						<label>R$</label>
						<?$taxReal = ( $cart_product[0]['product_unit_price'] * $cart_product[0]['quantity'] ) * ($cart_product[0]['tax_perc'] / 100 );?>
						<input type="text" name="dif_perc" readonly='' value="<?=number_format($taxReal, 2, ',', '.')?>" id="dif_perc"  class="form-control"/>	
					</div>	
					
					<div class="col-lg-4 col-md-4 mb-4" style="background-color: #ffeaa5; border: 1px solid #CCC;">
						<label style="color: #FF2626;">Limite Desconto</label>
						<p style="color: #FF2626; font-size: 20px;" id="discount_limit_p"><?=number_format($taxReal/2, 2, ',', '.')?></p>	
						<input type="hidden" name="discount_limit" value="" id="discount_limit"  class="form-control" style="font-size: 16px; font-weight: bold;"/>
					</div>	
					<div class="col-lg-3 col-md-3 mb-3" style="background-color: #e0e0e0; border: 1px solid #CCC;">
						<label>Desconto</label>
						<input type="text" name="discount" value="0" id="discount" readonly="" class="form-control" style="font-size: 16px; font-weight: bold;"/>	
					</div>	
				</div>
			
				<div  class="col-lg-2 col-md-2 mb-2" style="">
					<div class="col-lg-12 col-md-12 mb-12"><h4>Recálculos</h4></div>
					<div class="col-lg-3 col-md-3 mb-3">
						<label>.</label>
						<img style='display:block;' src='<?=base_url('public/images/icones/ico_recalc.png')?>' class='recalc' title='Recalcular' onclick="javascript: recalc('<?=base_url()?>cart_product/recalc',<?=$cart_product[0]['fk_product']?>);">
						<img style='display:none;' src='<?=base_url('public/images/icones/ico_save.png')?>' class='save' title='Salvar' onclick="javascript: save('<?=base_url()?>cart_product/saveRecalc');">
					</div>
					<div class="col-lg-9 col-md-9 mb-9">
						<label>Total</label>
						<input type="text" name="total" readonly='' value="<?=number_format(($cart_product[0]['product_unit_price'])*($cart_product[0]['quantity']), 2, ',', '.')?>" class="form-control" id="total" />				
					</div>
				</div>

			</div>			
							
			<table class="table">
				<tr>
					<th colspan="6">Provedores do Produto</th>
				</tr>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Site</th>
					<th>Tipo<br>Descuento</th>
				</tr>
				<?foreach ($providers as $key => $row) {?>
					<?switch ($row['type_discount']) {
						case '1':
							$type_discount = 'Por rango de Producto';
							break;
						case '2':
							$type_discount = 'Descuento unico';
							break;
						case '3':
							$type_discount = 'Por Provedor';
							break;
						case '4':
							$type_discount = 'Web Service';
							break;
						
						default:
							
							break;
					}?>
					<tr>
						<td align="center">#<?=$row['fk_provider']?></td>
						<td align="center"><?=$row['name']?></td>
						<td align="center"><?=$row['phone1']?><br><?=$row['phone2']?></td>
						<td align="center"><?=$row['web_site']?><br><?=$row['email']?></td>
						<td align="center"><?=$type_discount?></td>
					</tr>
				<?}?>
			</table>
		</div>
	</div>
</div>

