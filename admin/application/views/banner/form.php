<?
			if(isset($_REQUEST['id'])){
				$hidden = array('id' => $_REQUEST['id']);
			}
			
			$title = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => (isset($_REQUEST['title'])?$_REQUEST['title']:''),
              'size'        => '50',
              'class'       => 'form-control',
            );
			$subtitle = array(
              'name'        => 'subtitle',
              'id'          => 'subtitle',
              'value'       => (isset($_REQUEST['subtitle'])?$_REQUEST['subtitle']:''),
              'size'        => '50',
              'class'       => 'form-control',
            );
			$active = array(
              '1'  		=> 'Si',
              '0'    	=> 'No',
           	);
			$bannerLogo = array(
              'name'        => 'bannerfile',
              'id'          => 'bannerfile',
            );
			
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('email', $input_error))
			$email['class'] = 'target';
	}
?>

<script type="text/javascript">

    $(document).ready( function() {
    	$("#bannerForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nome ';
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
    	
		$('input[type="file"]').change(function(){
			var ext = $(this).val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['jpg','jpeg']) == -1) {
			    alerta('extensão de imagem inválida.');
			}else{
				trocarFoto();
			}
			
		});
    	
	});
	
function trocarFoto()
{
	var formulario = document.getElementById('bannerForm');
	var formData = new FormData(formulario);
	jQuery.ajax({
		type: "POST",
		url: '<?=base_url('banner/carregaFoto')?>',
		data: formData,
		dataType: 'json',
		success: function(returnedData){
			if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
			{
				$("#imgbanner").val(returnedData.file_name+'.'+returnedData.type);
				$(".img_banner").attr("src",returnedData.upload_path+'\\'+returnedData.file_name+'.'+returnedData.type);
			}
			else
			{
				alerta('warning','Desculpe, ocorreu um erro ao abrir dispositivo de Troca de Foto de Perfil. Desculpe!');
			}
		},
		cache: false,
		contentType: false,
		processData: false,
        xhr: function() { // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function() {
                	alerta('warning','Arquivo selecionado. Processando operação.')
                }, false);
            }else{
            	alerta('error','Você não tem suporte para XMLHttpRequest')
            }
            return myXhr;
        }
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
					<div class="x_title"><strong>&#9679; Novo Arquivo - Base de Produtos</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'bannerForm', 'id' => 'bannerForm','enctype'=>'multipart/form-data');?>
						<?=form_open('banner/save',$attributes,isset($hidden)?$hidden:'');?>
							<input type="hidden" name="imgbanner" id="imgbanner" value="<?=(isset($banner[0]['foto'])?$banner[0]['foto']:'')?>"/>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								
									<table id="dadosdeacesso">
										<tr>
											<td align="center">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group">
													<div id="preview" class="banner">
														<?
															if(isset($banner[0]['id'])){
																$image = $this->image->getBannerUrl($banner[0]['id']);
															}
														?>
														<img class="img_banner" width="855" height="250" src='<?=(isset($image)?$image:(base_url('public/images/banner/default.jpg')))?>' />
													</div>
												</div>
												<label for="imagem">
												      <span class="glyphicon glyphicon-retweet" ></span>
												      <input type="file" id="imagem" name="bannerfile" style="display:none"></br>
												      <small>somente formato .jpg</small>
												</label>
											</td>
										</tr>
									</table>
								
							</div>
				 			
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Titulo</label>
								<?=form_input($title)?>
							</div>
				 			
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Subtitulo</label>
								<?=form_input($subtitle)?>
							</div>
	
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label>Ativo</label>
								<?=form_dropdown('active',$active,isset($_REQUEST['active'])?$_REQUEST['active']:'1','class="form-control""')?>
							</div>
							
							
	
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                            <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
							</div>
						<?=form_close()?>
						<div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" id="dialog" aria-hidden="true" style="display: none; padding-right: 17px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>