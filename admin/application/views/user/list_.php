<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('.excluir').click(function(e) {
		var r = confirm("Deseja realmente excluir?");
		if (r==true)
		{
			var id = $(this).attr('idusuario');
			var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
			var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$(this).html(iconCarregando);
			});
			$.get('<?=base_url()?>user/delete/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$("#status").html(iconConf).show();
						$('#status').prepend(returnedData.msg);
						$('#usuario'+id).fadeOut(200);
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
			function reenviaSenha(id,elemento,viewName)
			{
				var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
				var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
				var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
				var x;
				$('#status').html(iconCarregando);
				jQuery.ajax({
				type: "POST",
				url: viewName+"/reenviaSenha/"+id,
				data: 'id='+id,
				dataType: 'json',
				success: function(msg){
					if(msg.error == null || msg.error == '' || !msg.error || msg.error == false)
					{
						$('#status').html(iconCarregando);
						$('#status').html(msg.msg);
					}
					else
					{
						$('#status').html(msg.msg);
					}
					},
					async: true
				});
			}
			function alteraStatus(id,elemento,viewName)
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
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label>Listado de Usuários </label></div>
				<div id="box_dir">
					<table border="0" class='grid'>
						<tr>
							<th align="center">Nome</th>
							<th align="center">Email</th>
							<th align="center" class='ativo'>Status</th>
							<th align="center" width="115">Ações</th>
						</tr>
						<?if(count($result)!=0){?>
							<?php foreach($result as $index => $row):?>
							<tr class='<?=($index%2)?'line2':'line1'?>' id='usuario<?=$row['id']?>'>
								<td><?=$row['name']?></td>
								<td><?=$row['email']?></td>
								<td align="center">
									<input type="button" class="<?=($row['active'])?'activo':'inactivo'?>" name='ativo' value="<?=($row['active'])?'Activo':'Inactivo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>user');">
								</td>
								<td>
									<input type="button" class="activo" name='ativo' value="Pass" title="Reenvia Senha" id="linkSenha_<?=$row['id']?>" onclick="javascript: reenviaSenha(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>usuario');">
									<a href="<?=base_url('user/form/'.$row['id'].'')?>">
										<img src='<?=base_url("public/images/icones/ico_edita.png")?>' title="Editar">
									</a>
									<a href="<?=base_url('usuario/exclui/'.$row['id'].'')?>" class='excluir' idusuario='<?=$row['id']?>'>
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
