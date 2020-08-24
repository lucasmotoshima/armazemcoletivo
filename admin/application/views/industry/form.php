<?
			if(isset($_REQUEST[0]['id'])){
				$hidden = array('id' => $_REQUEST[0]['id']);
			}
			
			$code = array(
              'name'        => 'code',
              'id'          => 'code',
              'value'       => (isset($_REQUEST[0]['code'])?((isset($_REQUEST[0]['id']))?$_REQUEST[0]['code']:$_REQUEST[0]['code']+1):''),
              'class'       => 'form-control',
              'readonly'    => '',
            );
			
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($_REQUEST[0]['name'])?$_REQUEST[0]['name']:''),
              'class'       => 'form-control',
            );
			
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('code', $input_error))
			$code['class'] = 'target';
		if(in_array('name', $input_error))
			$name['class'] = 'target';
	}
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#industryForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#code" ).val() == "" ) {
				msg = msg + 'Codigo ';
				erro = true;
			}
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre ';
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
			<h3>Grupo de Produtos</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; <?=isset($_REQUEST[0]['id'])?'Edição de':'Novo'?> Grupo</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'industryForm', 'id' => 'industryForm','enctype'=>'multipart/form-data');?>
						<?=form_open('industry/save',$attributes,isset($hidden)?$hidden:'');?>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Código</label>
								<?=form_input($code)?>
							</div>
							<div class="col-md-9 col-sm-12 col-xs-12 form-group">
								<label>Nome</label>
								<?=form_input($name)?>
							</div>
							<div class="col-md-9 col-sm-12 col-xs-12 form-group">
								<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
							</div>
						<?=form_close()?>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
						