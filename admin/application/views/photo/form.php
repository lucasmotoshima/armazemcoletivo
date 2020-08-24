<script type="text/javascript">
    $(document).ready( function() {
    	$("#fileForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if(($("#file" ).val()) == "" )
			{
				msg = msg + ',Archivo.';
				erro = true;
			}
			if(erro){
				$("#status").html(iconAlerta).show();
				$("#status").prepend(msg);
				event.preventDefault();
				return false;
			}
			else{
				return true;
			}
    	});
	});
 </script>
			<?=isset($menu)?$menu:''?>
			<div id="main">
				<?=$this->msg->show(isset($erro)?$erro:'');?>
				<div id="titulo_dir"><label>Nuevo Archivo - Base de Productos</label></div>
				<div id="box_dir">
					<?$attributes = array('name' => 'photoForm', 'id' => 'fileForm','enctype'=>'multipart/form-data');?>
					<?=form_open('photo/save',$attributes)?>
					<table>
						<tr>
							<td><p>Archivos</p></td>
						</tr>
						<tr>
							<td><input id="file" type="file" value="" name="file[]" multiple></td>
						</tr>
					</table>
					<table border=0>
						<tr>				
							<td align="left">
                                <button type="reset" id="reset" class="enviar">Limpar</button>
                                <button type="submit" id="salvar" class="enviar">Salvar</button>
							</td>
						</tr>
					</table>
					<?=form_close()?>
				</div>
			</div>
