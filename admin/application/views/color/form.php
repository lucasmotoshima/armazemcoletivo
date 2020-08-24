<?
			if(isset($_REQUEST['id'])){
				$hidden = array('id' => $_REQUEST['id']);
			}
			
			$code = array(
              'name'        => 'code',
              'id'          => 'code',
              'value'       => (isset($_REQUEST['code'])?$_REQUEST['code']:''),
              'class'       => 'form-control',
              'maxlength'   => '2',
            );
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
               'class'       => 'form-control',
            );
			$hexa = array(
              'name'        => 'hexa',
              'id'          => 'hexa',
              'value'       => (isset($_REQUEST['hexa'])?$_REQUEST['hexa']:''),
               'class'       => 'form-control',
              'readonly'	=> 'true',
            );
			$listColor['X'] = '';
			foreach($colorList as $index => $row):
				$listColor[$row['code']] = $row['name'];
			endforeach;
			
?>
<script type="text/javascript">
    $(document).ready( function() {
    	$("#colorForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#code" ).val() == "" ) {
				msg = msg + 'Código, ';
				erro = true;
			}
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre, ';
				erro = true;
			}
			if ( $("#hexa" ).val() == "" ) {
				msg = msg + 'Color. ';
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
<script type="text/javascript"> 
$(document).ready(function(){
	$('#status').css('display','block');
	$('#color').change(function(e) {
		var code = $('#color').val();
		e.preventDefault();
		$('#color_preview').ajaxStart(function() {
			var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/mini_loading.gif" class="icon" />');
			$(this).html(iconCarregando);
		});
		$.get('<?=base_url()?>color/getByCode/'+code, 
		function(data) {
			var returnedData = JSON.parse(data);
			$('#color_preview').css('background-color',returnedData.hexa);
			$('#hexa').val(returnedData.hexa);
			$('#code').val(returnedData.code);
			$('#name').val(returnedData.name);
			return true;
		},
		'html');
		return true;
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
						<?$attributes = array('name' => 'colorForm', 'id' => 'colorForm','enctype'=>'multipart/form-data');?>
						<?=form_open('color/save/',$attributes,isset($hidden)?$hidden:'');?>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Cores</label>
								<div id='color_preview' style="background-color:<?=isset($_REQUEST['hexa'])?$_REQUEST['hexa']:''?>"></div>
								<?=form_dropdown('colorList',$listColor,isset($_REQUEST['code'])?$_REQUEST['code']:'','class="form-control" id="color"')?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Hexa</label>
								<?=form_input($hexa)?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Nome</label>
								<?=form_input($name)?>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Código</label>
								<?=form_input($code)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                            <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
	                        </div>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
