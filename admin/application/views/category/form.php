<?
			if(isset($_REQUEST[0]['id'])){
				$hidden = array('id' => $_REQUEST[0]['id']);
			}
			
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($_REQUEST[0]['name'])?$_REQUEST[0]['name']:''),
              'size'        => '50',
              'class'       => 'form-control',
            );
			$active = array(
              '1'  		=> 'Si',
              '0'    	=> 'No',
           	);
			$description = array(
              'name'        => 'description',
              'id'          => 'description',
              'value'       => (isset($_REQUEST[0]['description'])?$_REQUEST[0]['description']:''),
              'class'       => 'form-control',
			);
			$phone1 = array(
              'name'        => 'phone1',
              'id'          => 'phone1',
              'value'       => (isset($_REQUEST[0]['phone1'])?$_REQUEST[0]['phone1']:''),
              'class'       => 'form-control',
			);
			$phone2 = array(
              'name'        => 'phone2',
              'id'          => 'phone2',
              'value'       => (isset($_REQUEST[0]['phone2'])?$_REQUEST[0]['phone2']:''),
              'class'       => 'form-control',
			);	
			$fax = array(
              'name'        => 'fax',
              'id'          => 'fax',
              'value'       => (isset($_REQUEST[0]['fax'])?$_REQUEST[0]['fax']:''),
              'class'       => 'form-control',
			);	
			$tipo_discuento = array(
              '1'  		=> 'por rango',
              '2'    	=> 'Descuento único',
              '3'    	=> 'por Producto',
              'X'    	=> '',
           	);
			$descuento = array(
              'name'        => 'descuento',
              'id'          => 'descuento',
              'value'       => ((isset($_REQUEST[0]['discount'])and($_REQUEST[0]['discount']!=''))?$_REQUEST[0]['discount']:''),
              'class'       => 'form-control',
           	);
			if(isset($_REQUEST[0]['type_discount'])and($_REQUEST[0]['type_discount']=='2'))
				$descuento['disabled'] = '';
			else
				$descuento['disabled'] = 'disabled';
			/*
			$range1 = array(
              'name'        => 'range1',
              'id'          => 'range1',
              'value'       => (isset($_REQUEST[0]['range1_price'])?$_REQUEST[0]['range1_price']:''),
              'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
              'placeholder' => '%',
              'class'		=> 'range',
            );	
			$range1_start = array(
              'name'        => 'range1_start',
              'id'          => 'range1_start',
              'value'       => (isset($_REQUEST[0]['range1_start'])?$_REQUEST[0]['range1_start']:''),
              'style'       => 'width:30px',
              'placeholder' => 'inicio',
            );	
			$range1_end = array(
              'name'        => 'range1_end',
              'id'          => 'range1_end',
              'value'       => (isset($_REQUEST[0]['range1_end'])?$_REQUEST[0]['range1_end']:''),
              'style'       => 'width:30px',
              'placeholder' => 'fin',
            );
			$range2 = array(
              'name'        => 'range2',
              'id'          => 'range2',
              'value'       => (isset($_REQUEST[0]['range2_price'])?$_REQUEST[0]['range2_price']:''),
              'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
              'placeholder' => '%',
              'class'		=> 'range',
            );	
			$range2_start = array(
              'name'        => 'range2_start',
              'id'          => 'range2_start',
              'value'       => (isset($_REQUEST[0]['range2_start'])?$_REQUEST[0]['range2_start']:''),
              'style'       => 'width:30px',
              'placeholder' => 'inicio',
            );	
			$range2_end = array(
              'name'        => 'range2_end',
              'id'          => 'range2_end',
              'value'       => (isset($_REQUEST[0]['range2_end'])?$_REQUEST[0]['range2_end']:''),
              'style'       => 'width:30px',
              'placeholder' => 'fin',
            );	
			$range3 = array(
              'name'        => 'range3',
              'id'          => 'range3',
              'value'       => (isset($_REQUEST[0]['range3_price'])?$_REQUEST[0]['range3_price']:''),
              'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
              'placeholder' => '%',
              'class'		=> 'range',
            );	
			$range3_start = array(
              'name'        => 'range3_start',
              'id'          => 'range3_start',
              'value'       => (isset($_REQUEST[0]['range3_start'])?$_REQUEST[0]['range3_start']:''),
              'style'       => 'width:30px',
              'placeholder' => 'inicio',
            );	
			$range3_end = array(
              'name'        => 'range3_end',
              'id'          => 'range3_end',
              'value'       => (isset($_REQUEST[0]['range3_end'])?$_REQUEST[0]['range3_end']:''),
              'style'       => 'width:30px',
              'placeholder' => 'fin',
            );	
			$range4 = array(
              'name'        => 'range4',
              'id'          => 'range4',
              'value'       => (isset($_REQUEST[0]['range4_price'])?$_REQUEST[0]['range4_price']:''),
              'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
              'placeholder' => '%',
              'class'		=> 'range',
            );	
			$range4_start = array(
              'name'        => 'range4_start',
              'id'          => 'range4_start',
              'value'       => (isset($_REQUEST[0]['range4_start'])?$_REQUEST[0]['range4_start']:''),
              'style'       => 'width:30px',
              'placeholder' => 'inicio',
            );	
			$range4_end = array(
              'name'        => 'range4_end',
              'id'          => 'range4_end',
              'value'       => (isset($_REQUEST[0]['range4_end'])?$_REQUEST[0]['range4_end']:''),
              'style'       => 'width:30px',
              'placeholder' => 'fin',
            );	
			$range5 = array(
              'name'        => 'range5',
              'id'          => 'range5',
              'value'       => (isset($_REQUEST[0]['range5_price'])?$_REQUEST[0]['range5_price']:''),
              'style'       => 'width:80px; text-align:center; font-size:14px; font-weight: bold;',
              'placeholder' => '%',
              'class'		=> 'range',
            );	
			$range5_start = array(
              'name'        => 'range5_start',
              'id'          => 'range5_start',
              'value'       => (isset($_REQUEST[0]['range5_start'])?$_REQUEST[0]['range5_start']:''),
              'style'       => 'width:30px',
              'placeholder' => 'inicio',
            );	
			$range5_end = array(
              'name'        => 'range5_end',
              'id'          => 'range5_end',
              'value'       => (isset($_REQUEST[0]['range5_end'])?$_REQUEST[0]['range5_end']:''),
              'style'       => 'width:30px',
              'placeholder' => 'fin',
              'disabled'	=> 'disabled',
            );	
			 */
			$categoryLogo = array(
              'name'        => 'categoryfile',
              'id'          => 'categoryfile',
              'class'       => 'form-control',
			);
			$obs = array(
              'name'        => 'obs',
              'id'          => 'obs',
              'value'       => (isset($_REQUEST[0]['obs'])?$_REQUEST[0]['obs']:''),
              'class'       => 'form-control',
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
    	$("#providerForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre ';
				erro = true;
			}
			if( ($("#categoryfile" ).val() != "" )&&( $("#ck_imagem" ).prop('checked')== false))
			{
				msg = msg + ',imagem (valide la imagen)".';
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
		$('#categoryfile').change(function(){
			$('#ck_imagem').prop('checked', false);
		    var oFReader = new FileReader();
		    oFReader.readAsDataURL(this.files[0]);
		    console.log(this.files[0]);
		    oFReader.onload = function (oFREvent) {
		        $('#preview').html('<img src="'+oFREvent.target.result+'" id="img">');
		    };
		});
	    
		$('#validaImagem').click(function(){
			var width = $('#img').width();
			var height = $('#img').height();
			if((width!='35')&&(height!='35'))
			{
				alert('Imagem deve ser de 35 X 35 pixels.'+'('+width+' x '+height+')');
				$('#ck_imagem').prop('checked', false);
    			$('#preview').html('');
    			document.getElementById("categoryfile").value = "";
    			return false;
			}
			else
			{
				$('#ck_imagem').prop('checked', true);
				return false;
			}
		});
		
		
		$('#range1_end').keyup(function(){
			if($('#range1_end').val()!='')
				$('#range2_start').attr('value',parseInt($('#range1_end').val())+1);
			else
				$('#range2_start').attr('value',0);
		});
		$('#range2_end').keyup(function(){
			if($('#range2_end').val()!='')
				$('#range3_start').attr('value',parseInt($('#range2_end').val())+1); 
			else
				$('#range3_start').attr('value',0);
		});
		$('#range3_end').keyup(function(){
			if($('#range3_end').val()!='')
				$('#range4_start').attr('value',parseInt($('#range3_end').val())+1);
			else
				$('#range4_start').attr('value',0);
		});
		$('#range4_end').keyup(function(){
			if($('#range4_end').val()!='')
				$('#range5_start').attr('value',parseInt($('#range4_end').val())+1);
			else
				$('#range5_start').attr('value',0);
		});
	});
 </script>
<div class>
	<div class="page-title">
  		<div class="title_left">
			<h3>Categorias</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Inserir nova Categorias</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'categoryForm', 'id' => 'categoryForm','enctype'=>'multipart/form-data');?>
						<?=form_open('category/save',$attributes,isset($hidden)?$hidden:'');?>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Nome</label>
								<?=form_input($name)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Descrição</label>
								<?=form_textarea($description)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Ativo</label>
								<?=form_dropdown('active',$active,isset($_REQUEST[0]['active'])?$_REQUEST[0]['active']:'1','style="width:50px;"')?>
							</div>
						
						<!--table id="rangos_descuento" width="660" style="display:block?>;">
							<tr>
								<th colspan="12" align="center">Rangos de Descuentos</th>
							</tr>
							<tr>
								<td align="center">Intervalos</td>
								<td align="center"><?=form_input($range1_start)?></td>
								<td align="center"><?=form_input($range1_end)?></td>
								<td align="center"><?=form_input($range2_start)?></td>
								<td align="center"><?=form_input($range2_end)?></td>
								<td align="center"><?=form_input($range3_start)?></td>
								<td align="center"><?=form_input($range3_end)?></td>
								<td align="center"><?=form_input($range4_start)?></td>
								<td align="center"><?=form_input($range4_end)?></td>
								<td align="center"><?=form_input($range5_start)?></td>
								<td align="center"><?=form_input($range5_end)?></td>
							</tr>
							<tr>
								<td align="center" width=120>Rangos</td>
								<td colspan="2" align="center"><?=form_input($range1)?></td>
								<td colspan="2" align="center"><?=form_input($range2)?></td>
								<td colspan="2" align="center"><?=form_input($range3)?></td>
								<td colspan="2" align="center"><?=form_input($range4)?></td>
								<td colspan="2" align="center"><?=form_input($range5)?></td>
							</tr>
						</table-->
						
							<?if(isset($_REQUEST[0]['ext'])and($_REQUEST[0]['ext']!=''))
							{
								$img = '<img src="';
								$img.=base_url("public/images/category/".$_REQUEST[0]['id'].$_REQUEST[0]['ext']);
								$img.= '">';
							}
							else
								$img = '';
							?>
							<!--table id="dadosdeacesso" height="100">
								<tr>
									<td align="center" rowspan="3"><div id="preview" class="category"><?=$img?></div><i>.jpg, .gif ou .png<br>(35px X 35px)</i></td>
								</tr>
								<tr>
									<td align="center"><?=form_upload($categoryLogo)?></td>
								</tr>
								<tr>
									<td>
										<div id='validaImagem'>Validar Imagem</div>
									</td>
									<td>
										<input type="checkbox" id="ck_imagem" disabled="disabled">
									</td>
								</tr>
							</table-->
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>OBS</label>
								<?=form_textarea($obs)?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                            <button type="reset" id="reset" class="btn btn-success">Limpar</button>
	                            <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
	                        </div>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>