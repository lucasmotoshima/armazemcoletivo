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
			$.get('<?=base_url()?>color/delete/'+id, 
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
<div class>
	<div class="page-title">
  		<div class="title_left">
			<h3>Cores</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Lista de Cores</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table border="0" class='table'>
							<tr>
								<th>Cor</th>
								<th>Código</th>
								<th>Nome</th>
								<th>Ações</th>
							</tr>
							<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr class='<?=($index%2)?'line2':'line1'?>' id='color<?=$row['id']?>'>
									<td><div id='color_preview' style="background-color: <?=$row['hexa']?>"></div></td>
									<td><?=$row['code']?></td>
									<td><?=$row['name']?></td>
									<td>
										<a href="<?=base_url('color/form/'.$row['id'].'')?>">
											<img src='<?=base_url("public/images/icones/ico_edita.png")?>' title="Editar">
										</a>
										<a href="<?=base_url('color/delete/'.$row['id'].'')?>" class='excluir' idcolor='<?=$row['id']?>'>
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
							<div id="paginacao"><?=$paginacao?></div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
