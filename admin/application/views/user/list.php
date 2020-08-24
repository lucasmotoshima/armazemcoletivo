	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title"></div>
				<div class="x_content">
					<fieldset>
						<legend>Usuários</legend>
						<div class="row">
							<div class="col-sm-12">
								<table border="0" class='table'>
									<thead>
										<tr>
											<th align="center">Name</th>
											<th align="center">Email</th>
											<th align="center">Nascimento</th>
											<th align="center">Telefone</th>
											<th align="center">Cidade</th>
											<th align="center">Estado</th>
											<th align="center">País</th>
											<th align="center" class='ativo'>Status</th>
											<th align="center" width="145">Ações</th>
										</tr>
									</thead>
	
									<?if(count($result)!=0){?>
										<tbody>
										<?php foreach($result as $index => $row):?>
										<tr class='<?=($index%2)?'line2':'line1'?>' id='usuario<?=$row['id']?>'>
											<td>
												<img src='<?=$this->perfil->getFotoUrl($_SESSION['adm_armazem']['user']['id']);?>' alt="<?=$this->perfil->getNome($_SESSION['adm_armazem']['user']['id']);?>" class="img-circle profile_img"/>
												<?=$row['name']?></td>
											<td><?=$row['email']?></td>
											<td><?=$row['birthday']?></td>
											<td><?=$row['phone']?></td>
											<td><?=$row['city']?></td>
											<td><?=$row['province']?></td>
											<td><?=$row['country']?></td>
											<td align="center">
												<input type="button" class="btn btn-<?=($row['active'])?'success':'default'?>" name='ativo' value="<?=($row['active'])?'Ativo':'Inativo'?>" title="Altera Status" id="linkStatus_<?=$row['id']?>" onclick="javascript: alteraStatus(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>index.php/user');">
											</td>
											<td align="center">
												<button class="btn btn-info" name='ativo' title="Reenvia Senha" id="linkSenha_<?=$row['id']?>" onclick="javascript: reenviaSenha(<?=$row['id']?>,'#link_<?=$row['id']?>','<?=base_url()?>index.php/user');">
													<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
												</button>
												<a href="<?=base_url('user/form/'.$row['id'].'')?>">
													<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
												</a>
												<a href="<?=base_url('user/exclui/'.$row['id'].'')?>" class='excluir' idusuario='<?=$row['id']?>'>
													<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
												</a>
											</td>
										</tr>
										<?endforeach?>
									<?}else{?>
										<tr>
											<td colspan="8"><center>Nenhum registro encontrado</center></td>
										</tr>
									<?}?>
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
					<div class="row">
						<div class="col-sm-7">
							<div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate" >
								<?if(isset($paginacao)){?>
									<?=$paginacao?>
								<?}?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	