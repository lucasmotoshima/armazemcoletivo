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
			var id = $(this).attr('idcart');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>cart/delete/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#cart'+id).fadeOut(200);
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
	
	<?if($result[0]['id']!=''){?>
	var intervalo = window.setInterval(function() {
	jQuery.ajax({
		type: "POST",
		url: '<?=base_url('cart/getPedidosJson')?>',
		data: {
			lastId:<?=$result[0]['id']?>,
			},
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.status == '1'){
				alert('Temos novos pedidos.');
				location.reload();
			}
			},
		async: true
		});
	}, 15000);
	<?}?>
	
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
					<div class="x_title"><strong>&#9679; Lista de Pedidos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table border="0" class='table'>
							<tr>
								<th align="center">#</th>
								<!--th align="center">Logo</th-->
								<th align="center">Data</th>
								<th align="center">Cliente</th>
								<th align="center">Telefone</th>
								<th align="center">Status</th>
								<th align="center" width="110">Ações</th>
							</tr>
							<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr id='cart<?=$row['id']?>'>
									<?$img=((isset($row['ext']))and($row['ext']!=''))?$row['id'].$row['ext']:'default.gif'?>
									<td align="center">#<?=$row['id']?></td>
									<td><?=$this->format_date->us2br($row['date'])?></td>
									<td><?=$row['client_name']?></td>
									<td><?=$row['phone']?></td>
									<td><?=($row['status']=='N')?'Não Avaliado':'Avaliado'?></td>
									<td width="150">
										<!--input type="button" class=" btn btn-<?=($row['status']=='N')?'warning':'success'?>" name='ativo' value="<?=($row['status']=='N')?'Não Enviado':'Enviado'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: changeStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>cart');"-->
										<?if($row['status']=='Y'){?>
											<a href="<?=base_url('cart/budgetDownload/'.$row['id'])?>" class='Presupesto' idproduct='<?=$row['id']?>'>
												<img src="<?=base_url('public/images/icones/ico_pdf.png')?>">
											</a>
										<?}?>
										<a href="<?=base_url('cart_product/getList/'.$row['id'].'')?>" class='Detalles' idproduct='<?=$row['id']?>'>
											<img src="<?=base_url('public/images/icones/ico_carro.png')?>">
										</a>
										<a href="<?=base_url('cart/delete/'.$row['id'].'')?>" class='excluir' idcart='<?=$row['id']?>'>
											<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
										</a>
									</td>
								</tr>
								<?endforeach?>
							<?}else{?>
								<tr>
									<td colspan="8"><center>Nenhum registro encontrado</center></td>
								</tr>
							<?}?>
						</table>
						<?if(isset($paginacao)){?>
							<nav aria-label="Page navigation">
								<?=$paginacao?>
							</nav>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
