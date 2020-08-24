<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('.excluir').click(function(e) {
		var r = confirm("Deseja realmente excluir?");
		if (r==true)
		{
			var id = $(this).attr('idproduct');
			var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
			var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>provider/delete/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#product'+id).fadeOut(200);
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
			function alteraStatus(id,elemento,viewName)
			{
				var iconAlerta 		= $('<img src="<?=base_url("public/images/icones/ico_alerta.png")?>" class="icon" />');
				var iconConf 		= $('<img src="<?=base_url("public/images/icones/ico_confirmado.png")?>" class="icon" />');
				var iconCarregando 	= $('<img src="<?=base_url("public/images/icones/loading.gif")?>" class="iconCarregando" />');
				var x 				= '#linkStatus_'+id;
				var boasvindas 		= '0';
				var value 			= $(x).attr('value');
				if(value=='Inativo'){
					var resp = confirm("Deseja enviar E-mail de Boas Vindas?");
					if (resp==true)
					{
						boasvindas = '1';
					}
				}
				$('#status').html(iconCarregando);
				jQuery.ajax({
				type: "POST",
				url: viewName+"/changeStatus/"+id+"/"+boasvindas,
				data: {
					id:id,
					boasvindas:boasvindas
					},
				dataType: 'json',
				success: function(returnedData){
					if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
					{
						$('#status').html(iconConf);
						$('#status').append(returnedData.msg);
						$(elemento).val(returnedData.label);
						link = "#linkStatus_"+id;
						$(link).attr('value', returnedData.label);
						$(link).attr('class', ((returnedData.active=='0')?'btn btn-success':'btn btn-warning'));  
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
			<h3>Fornecedores</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Lista de Fornecedores</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?//$this->debug->show($result);?>
						<table border="0" class='table'>
							<tr>
								<th align="center">Código</th>
								<th align="center">Logo</th>
								<th align="center">Nome</th>
								<th align="center">E-mail</th>
								<th align="center" width="130">Ações</th>
							</tr>
							<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr class='<?=($index%2)?'line2':'line1'?>' id='provider<?=$row['id']?>'>
									<?$img=($row['image']!='')?$row['image']:'default.gif'?>
									<td align="center">P<?=str_pad($row['id'],2)?></td>
									<td><img src="<?=base_url('public/images/provider/'.$img)?>" width='150' height='79'></td>
									<td><?=$row['name']?></td>
									<td><?=$row['email']?></td>
									<td>
										<input type="button" class="btn btn-<?=($row['active'])?'success':'warning'?>" name='ativo' value="<?=($row['active'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>provider');">
										<a href="<?=base_url('provider/form/'.$row['id'].'')?>">
											<img src='<?=base_url("public/images/icones/ico_edita.png")?>' title="Editar">
										</a>
										<a href="<?=base_url('product/delete/'.$row['id'].'')?>" class='excluir' idproduct='<?=$row['id']?>'>
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