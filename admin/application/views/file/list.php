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
			$.get('<?=base_url()?>file/delete/'+id,
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('.file'+id).fadeOut(200);
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
<script>
	function sincroniza(id,elemento,viewName)
	{
		var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
		var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
		var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
		var urlImage		= "<?=base_url("imagem/lista/")?>/";
		linkSync 		= "#linkSync_"+id;
		linkStatus 		= "#linkStatus_"+id;
		$('#status').html(iconCarregando);
		jQuery.ajax({
		type: "POST",
		url: viewName+"/sync/"+id,
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
				$(link).attr('class', ((returnedData.status=='1')?'btn btn-success':'btn btn-warning'));  
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
					<div class="x_title"><strong>&#9679; Lista de Arquivos - Base de Produtos</strong>
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
								<th align="center">Name</th>
								<th align="center">Descrição</th>
								<th align="center">Data de Upload</th>
								<th align="center">Data de Sincronismo</th>
								<th align="center">Ações</th>
							</tr>
							<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr class='file<?=$row['id']?>'>
									<td align="center"><strong>#<?=$row['id']?></td>
									<td align="center"><?=$row['name']?></td>
									<td align="center"><?=$row['description']?></td>
									<td align="center"><?=$this->format_date->us2br($row['date_upload'])?></td>
									<td align="center"><?=($row['sync_st']==TRUE)?$this->format_date->us2br($row['date_sync']):'#';?></td>
									<td>
										<input type="button" class="btn btn-<?=($row['sync_st'])?'success':'warning'?>" name='ativo' value="<?=($row['sync_st'])?'ativo':'inativo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: sincroniza(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
										<a href="<?=base_url('file/delete/'.$row['id'].'')?>" class='excluir' idcolor='<?=$row['id']?>'>
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
