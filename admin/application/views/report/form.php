<?
			//======================================
			//======RELATORIO DE USUARIOS===========
			//======================================
			$tipo = array(
                  'X'  		=> 'Todos',
                  'ADM'  	=> 'Administrador',
                  'FUN'    	=> 'Funcionário',
                  'IMP'    	=> 'Imprensa',
            );
			$ativo = array(
				  'X'  		=> 'Todos',
                  'Y'  		=> 'Sim',
                  'N'    	=> 'Não',
            );
			
			$options['X'] = 'Todos';
			$options['Y'] = 'Outros';
			foreach($veiculo as $index => $row):
				$options[$row['id']] = $row['nome'];
			endforeach;
			$fk_veiculo = $options;
			
			$tipoDownload = array(
				  'X'  		=> 'Todos',
                  'M'  		=> 'Manual',
                  'A'    	=> 'Automático',
            );
			
			//======================================
			//====RELATORIO DE IMAGENS/ALBUNS=======
			//======================================
			$isPrimary = array(
				  'X'  		=> 'Todos',
                  '1'  		=> 'Sim',
                  '0'    	=> 'Não',
            );
			
			$opt['X'] = 'Todos';
			foreach($album as $index => $row):
				$opt[$row['id']] = $row['title'];
			endforeach;
			$fk_album = $opt;
			
			//======================================
			//====RELATORIO DE SOLICITAÇÕES--=======
			//======================================
			
			$lst['X'] = 'Todos';
			foreach($usuario as $index => $row):
				$lst[$row['id']] = $row['nome'];
			endforeach;
			$fk_usuario = $lst;
			
			$dt_aprovado_ini = array(
              'name'        => 'dt_aprovado_ini',
              'id'          => 'dt_aprovado_ini',
              'value'       => '',
              'style'       => 'width:110px',
            );
			$dt_aprovado_fim = array(
              'name'        => 'dt_aprovado_fim',
              'id'          => 'dt_aprovado_fim',
              'value'       => '',
              'style'       => 'width:110px',
            );
			
			$dt_solicitado_ini = array(
              'name'        => 'dt_solicitado_ini',
              'id'          => 'dt_solicitado_ini',
              'value'       => '',
              'style'       => 'width:110px',
            );
			$dt_solicitado_fim = array(
              'name'        => 'dt_solicitado_fim',
              'id'          => 'dt_solicitado_fim',
              'value'       => '',
              'style'       => 'width:110px',
            );
?>
			<script type="text/javascript">
			    $(document).ready( function() {
					$(function() {
					    $("#dt_aprovado_ini").mask("99/99/9999");
						$('#dt_aprovado_fim').mask("99/99/9999");
					    $("#dt_solicitado_ini").mask("99/99/9999");
						$('#dt_solicitado_fim').mask("99/99/9999");
					});
				});
			</script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<!--==========================================-->
				<div id="titulo_dir"><label>Relatório de Usuários</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'usuarioForm', 'id' => 'usuarioForm','enctype'=>'multipart/form-data');?>
					<?=form_open('relatorio/usuario',$attributes,isset($hidden)?$hidden:'');?>
					<table class="grid">
						<tr>
							<th>Perfil</th>
							<th>Veículo</th>
							<th>Ativo</th>
							<th>Download<br>Automatico/Manual</th>
						</tr>
						<tr>
							<td><p><?=form_dropdown('tipo',$tipo,'','style="width:150px;"')?></p></td>
							<td><p><?=form_dropdown('fk_veiculo',$fk_veiculo,'','style="width:150px;"')?></p></td>
							<td><p><?=form_dropdown('ativo',$ativo,'','style="width:150px;"')?></p></td>
							<td><p><?=form_dropdown('tipoDownload',$tipoDownload,'','style="width:150px;"')?></p></td>
						</tr>
					</table>
					
					<table border=0>
						<tr>				
							<td align="left">
                                <button type="reset" id="reset" class="enviar">Limpar</button>
                                <button type="submit" id="salvar" class="enviar">Enviar</button>
							</td>
						</tr>
					</table>
					<?=form_close()?>
				</div>
				
				<!--==========================================-->
				<div id="titulo_dir"><label>Relatório de Solicitações</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'solicitacaoForm', 'id' => 'solicitacaoForm','enctype'=>'multipart/form-data');?>
					<?=form_open('relatorio/solicitacao',$attributes,isset($hidden)?$hidden:'');?>
					<table class="grid">
						<tr>
							<th>Usuário</th>
							<th>Ativo</th>
							<th>Data Aprovado</th>
							<th>Data Solicitado</th>
						</tr>
						<tr>
							<td><p><?=form_dropdown('fk_usuario',$fk_usuario,'','style="width:310px;"')?></p></td>
							<td><p><?=form_dropdown('ativo',$ativo,'','style="width:70px;"')?></p></td>
							<td>
								<p>
								<?=form_input($dt_aprovado_ini)?>
								<?=form_input($dt_aprovado_fim)?>
								</p>
							</td>
							<td>
								<p>
								<?=form_input($dt_solicitado_ini)?>
								<?=form_input($dt_solicitado_fim)?>
								</p>
							</td>
						</tr>
					</table>
					
					<table border=0>
						<tr>				
							<td align="left">
                                <button type="reset" id="reset" class="enviar">Limpar</button>
                                <button type="submit" id="salvar" class="enviar">Enviar</button>
							</td>
						</tr>
					</table>
					<?=form_close()?>
				</div>
				<!--==========================================-->
			</div>
