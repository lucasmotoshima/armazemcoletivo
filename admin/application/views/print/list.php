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
			var id = $(this).attr('idcolor');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>print/delete/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#color'+id).fadeOut(200);
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
});
</script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label>Listado de Tipos de Impresión</label></div>
				<div id="box_dir">
					<table border="0" class='grid'>
						<tr>
							<th align="center">Limites</th>
							<th colspan="14" align="center">Rangos de Costo</th>
						</tr>
						<?if(count($result)!=0){?>
							<?php foreach($result as $index => $row):?>
							<tr class='<?=($index%2)?'line2':'line1'?>' class='print<?=$row['id']?>'>
								<td class="head" align="center"><strong>#<?=$row['code']?></strong></td>
								<td class="head" align="center" colspan="12"><strong><?=$row['description']?></strong></td>
							</tr>
							</tr>
							<tr class='<?=($index%2)?'line2':'line1'?>' class='print<?=$row['id']?>'>
								<td align="center"><?=$row['qty_limit']?></td>
								<td align="center">Intervalos</td>
								<td align="center"><?=$row['range1_start']?></td>
								<td align="center"><?=$row['range1_end']?></td>
								<td align="center"><?=$row['range2_start']?></td>
								<td align="center"><?=$row['range2_end']?></td>
								<td align="center"><?=$row['range3_start']?></td>
								<td align="center"><?=$row['range3_end']?></td>
								<td align="center"><?=$row['range4_start']?></td>
								<td align="center"><?=$row['range4_end']?></td>
								<td align="center"><?=$row['range5_start']?></td>
								<td align="center">...</td>
								<td rowspan="2">
									<a href="<?=base_url('print/form/'.$row['id'].'')?>">
										<img src='<?=base_url("public/images/icones/ico_edita.png")?>' title="Editar">
									</a>
									<a href="<?=base_url('print/delete/'.$row['id'].'')?>" class='excluir' idcolor='<?=$row['id']?>'>
										<img src="<?=base_url('public/images/icones/ico_excluir.png')?>">
									</a>
								</td>
							</tr>
							<tr class='print<?=$row['id']?>'>
								<td align="center"><?=$row['amount_limit']?></td>
								<td align="center" width=120>Rangos</td>
								<td colspan="2" align="center"><?=$row['range1_price']?></td>
								<td colspan="2" align="center"><?=$row['range2_price']?></td>
								<td colspan="2" align="center"><?=$row['range3_price']?></td>
								<td colspan="2" align="center"><?=$row['range4_price']?></td>
								<td colspan="2" align="center"><?=$row['range5_price']?></td>
							</tr>
							<?endforeach?>
						<?}else{?>
							<tr>
								<td colspan="8"><center>Nenhum registro encontrado</center></td>
							</tr>
						<?}?>
					</table>
					<?if(isset($paginacao)){?>
						<div id="paginacao"><?=$paginacao?></div>
					<?}?>
				</div>
			</div>
