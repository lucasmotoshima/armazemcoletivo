<?
	$search = array(
      'name'        => 'search',
      'id'          => 'search',
      'value'       => (isset($_REQUEST['search'])?$_REQUEST['search']:''),
      'class'		=> 'form-control',
    );
?>

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
			$.get('<?=base_url()?>product/delete/'+id, 
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
			function pageBusy(maincontainer,status) {
				var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
				if (status == true) {
					$('#status').html(iconCarregando);
				} else {
					$('#status').html('');
				}
			};
			</script>
			
			<link rel="stylesheet" href="<?php echo SYS_BASE_URL; ?>public/css/lightbox.css" type="text/css" />
			<script src="<?php echo SYS_BASE_URL; ?>public/javascript/jquery-1.11.0.min.js"></script>
			<script src="<?php echo SYS_BASE_URL; ?>public/javascript/lightbox.min.js" type="text/javascript" charset="utf-8"></script>
<div class>
	<div class="page-title">
  		<div class="title_left">
			<h3>Produtos</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Buscar</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div id="search" style="margin: 10px 0px 10px 0px;">
							<?$attributes = array('name' => 'searchForm', 'id' => 'searchForm','enctype'=>'multipart/form-data');?>
							<?=form_open('product/getList',$attributes);?>
								<div class="col-md-11 col-sm-12 col-xs-12 form-group">
									<?=form_input($search)?>
								</div>
								<div class="col-md-1 col-sm-12 col-xs-12 form-group">
									<button type="submit" id="salvar" class="btn btn-success">buscar</button>
								</div>
							<?=form_close()?>
						</div>
					</div>
				</div>
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Lista de Produtos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table border="0" class='table'>
							<tr>
								<th>Categoria</th>
								<th>Foto</th>
								<th>Descrição</th>
								<th wudth="160">Ações</th>
							</tr>
							<?if(count($result)!=0){?>
								<?php foreach($result as $index => $row):?>
								<tr class='<?=($index%2)?'line2':'line1'?>' id='provider<?=$row['id']?>'>
									<td><strong>C<?=$row['category_id']?> - <?=$row['category_name']?></strong></td>
									<td align='center'>
										<a href="<?=$row['photo_url']?>" data-lightbox="image-1" data-title="<?=$row['name']?>">
											<img src="<?=$row['photo_url']?>" width='<?=$row['photo_w']?>' height='<?=$row['photo_h']?>'>
										</a>
									</td>
									<td>
										<strong><div style= 'color: #005a51; font-size: 14px;'><?=$row['name']?> - R$<?=$row['price']?></div>
										</strong>
										<?=$row['description']?>
										<br>
										<i><small><?=$row['code_origin']?></small></i>
									</td>
									<td>
										<input type="button" class=" btn btn-<?=($row['active'])?'success':'warning'?>" name='ativo' value="<?=($row['active'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>product');">
										<a href="<?=base_url('product/form/'.$row['id'].'')?>">
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
						

