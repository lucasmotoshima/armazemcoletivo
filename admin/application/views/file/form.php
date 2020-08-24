<?
	$name = array(
      'name'        => 'name',
      'id'          => 'name',
      'value'       => '',
      'class'		=> 'form-control',
    );
	
	$description = array(
      'name'        => 'description',
      'id'          => 'description',
      'value'       => '',
      'class'		=> 'form-control',
	);
	
	$file = array(
      'name'        => 'file',
      'id'          => 'file',
      'class'		=> 'form-control',
    );
	
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#fileForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre ';
				erro = true;
			}
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
					<div class="x_title"><strong>&#9679; Novo Arquivo - Base de Produtos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'fileForm', 'id' => 'fileForm','enctype'=>'multipart/form-data');?>
						<?=form_open('file/save',$attributes)?>
							<fieldset>
								<legend>Dados da Empresa:</legend>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Nome</label>
									<?=form_input($name)?>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Arquivo</label>
									<?=form_upload($file)?>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Descrição</label>
									<?=form_textarea($description)?>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
								</div>
							</filedset>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>