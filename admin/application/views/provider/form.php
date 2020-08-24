<?
  			//$this->debug->show($provider);
			if(isset($provider[0]['id'])){
				$hidden = array('id' => $provider[0]['id']);
			}
			$code = array(
              'name'        => 'code',
              'id'          => 'code',
              'value'       => (isset($provider[0]['code'])?$provider[0]['code']:''),
              'class'       => 'form-control',
            );
			$name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => (isset($provider[0]['name'])?$provider[0]['name']:''),
              'class'       => 'form-control',
            );
			$name_contact = array(
              'name'        => 'name_contact',
              'id'          => 'name_contact',
              'value'       => (isset($provider[0]['name_contact'])?$provider[0]['name_contact']:''),
              'class'       => 'form-control',
            );
			$url_friendly = array(
              'name'        => 'url_friendly',
              'id'          => 'url_friendly',
              'value'       => (isset($provider[0]['url_friendly'])?$provider[0]['url_friendly']:''),
              'class'       => 'form-control',
            );
			$active = array(
              '1'  		=> 'Sim',
              '0'    	=> 'Não',
           	);
			$description = array(
              'name'        => 'description',
              'id'          => 'description',
              'value'       => (isset($provider[0]['description'])?$provider[0]['description']:''),
              'class'       => 'form-control',
			);
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => (isset($provider[0]['email'])?$provider[0]['email']:''),
              'class'       => 'form-control',
			);
			$web_site = array(
              'name'        => 'web_site',
              'id'          => 'web_site',
              'value'       => (isset($provider[0]['web_site'])?$provider[0]['web_site']:''),
              'class'       => 'form-control',
			);
			$phone1 = array(
              'name'        => 'phone1',
              'id'          => 'phone1',
              'value'       => (isset($provider[0]['phone1'])?$provider[0]['phone1']:''),
              'class'       => 'form-control',
			);
			$phone2 = array(
              'name'        => 'phone2',
              'id'          => 'phone2',
              'value'       => (isset($provider[0]['phone2'])?$provider[0]['phone2']:''),
              'class'       => 'form-control',
			);	
			$fax = array(
              'name'        => 'fax',
              'id'          => 'fax',
              'value'       => (isset($provider[0]['fax'])?$provider[0]['fax']:''),
              'class'       => 'form-control',
			);	
			$tax = array(
              'name'        => 'tax',
              'id'          => 'tax',
              'value'       => (isset($provider[0]['tax'])?$provider[0]['tax']:''),
              'class'       => 'form-control',
			);	
			$tipo_discuento = array(
              '1'  		=> 'por Produto',
              '2'    	=> 'Desconto único',
              '3'    	=> 'por Fornecedor',
              '4'    	=> 'por Web Service',
              'X'    	=> '',
           	);
			$descuento = array(
              'name'        => 'descuento',
              'id'          => 'descuento',
              'value'       => ((isset($provider[0]['discount'])and($provider[0]['discount']!=''))?$provider[0]['discount']:'0'),
              'class'       => 'form-control',
           	);
			if(isset($provider[0]['type_discount'])and($provider[0]['type_discount']!='2'))
				$descuento['disabled'] = '';
			$url_ws = array(
              'name'        => 'url_ws',
              'id'          => 'url_ws',
              'value'       => ((isset($provider[0]['url_ws'])and($provider[0]['url_ws']!=''))?$provider[0]['url_ws']:''),
              'class'       => 'form-control',
           	);
			$tp_producao = array(
              'S'  		=> 'Semanal',
              'SD'    	=> 'Sob Demanda',
           	);
			$obs = array(
              'name'        => 'obs',
              'id'          => 'obs',
              'value'       => ((isset($provider[0]['obs'])and($provider[0]['url_ws']!=''))?$provider[0]['obs']:''),
              'class'       => 'form-control',
           	);
//=======================================================================================
		
		if(isset($provider[0]['dia_entrega'])){
			$dia_entrega = explode(',', $provider[0]['dia_entrega']);
			
		}
			$segunda = array(
			    'descricao'   	=> 'Segunda',
			    'name'        	=> 'diaSemanaSeg',
			    'id'          	=> 'diaSemanaSeg',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[0])?(($dia_entrega[0]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$terca = array(
			    'descricao'   	=> 'Terca',
			    'name'        	=> 'diaSemanaTer',
			    'id'          	=> 'diaSemanaTer',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[1])?(($dia_entrega[1]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$quarta = array(
			    'descricao'   	=> 'Quarta',
			    'name'        	=> 'diaSemanaQua',
			    'id'          	=> 'diaSemanaQua',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[2])?(($dia_entrega[2]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$quinta = array(
			    'descricao'   	=> 'Quinta',
			    'name'        	=> 'diaSemanaQui',
			    'id'          	=> 'diaSemanaQui',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[3])?(($dia_entrega[3]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$sexta = array(
			    'descricao'   	=> 'Sexta',
			    'name'        	=> 'diaSemanaSex',
			    'id'          	=> 'diaSemanaSex',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[4])?(($dia_entrega[4]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$sabado = array(
			    'descricao'   	=> 'Sábado',
			    'name'        	=> 'diaSemanaSab',
			    'id'          	=> 'diaSemanaSab',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[5])?(($dia_entrega[5]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$domingo = array(
			    'descricao'   	=> 'Domingo',
			    'name'        	=> 'diaSemanaDom',
			    'id'          	=> 'diaSemanaDom',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($dia_entrega[6])?(($dia_entrega[6]=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
//=======================================================================================
			$tp_pagto_dinheiro = array(
			    'descricao'   	=> 'Dinheiro',
			    'name'        	=> 'tp_pagto_dinheiro',
			    'id'          	=> 'tp_pagto_dinheiro',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($provider[0]['tp_pagto_dinheiro'])?(($provider[0]['tp_pagto_dinheiro']=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$tp_pagto_debito = array(
			    'descricao'   	=> 'Débito',
			    'name'        	=> 'tp_pagto_debito',
			    'id'          	=> 'tp_pagto_debito',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($provider[0]['tp_pagto_debito'])?(($provider[0]['tp_pagto_debito']=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$tp_pagto_credito = array(
			    'descricao'   	=> 'Crédito',
			    'name'        	=> 'tp_pagto_credito',
			    'id'          	=> 'tp_pagto_credito',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($provider[0]['tp_pagto_credito'])?(($provider[0]['tp_pagto_credito']=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$tp_pagto_boleto = array(
			    'descricao'   	=> 'Boleto',
			    'name'        	=> 'tp_pagto_boleto',
			    'id'          	=> 'tp_pagto_boleto',
			    'value'       	=> 'accept',
			    'checked'     	=> (isset($provider[0]['tp_pagto_boleto'])?(($provider[0]['tp_pagto_boleto']=='1')?'checked':'0'):'0'),
			    'style'       	=> 'margin:0px',
			    );
			$tp_pagto_transferencia = array(
			    'descricao'   	=> 'Transferência Bancária',
			    'name'        	=> 'tp_pagto_transferencia',
			    'id'          	=> 'tp_pagto_transferencia',
			    'value'       	=> (isset($provider[0]['tp_pagto_transferencia'])?(($provider[0]['tp_pagto_transferencia']=='1')?'checked':'0'):'0'),
			    'checked'     	=> '0',
			    'style'       	=> 'margin:0px',
			    );

	$months_installment = array();
			
	$months = array(
    	'name'        => 'months',
      	'id'          => 'months',
      	'value'       => (isset($product['providerPlan'][0]['months'])?($product['providerPlan'][0]['months']):''),
      	'class'		  => 'form-control',
      	'readonly'	  => 'readonly',
    );
	
	$discount = array(
    	'name'        => 'discount',
      	'id'          => 'discount',
      	'value'       => (isset($product['providerPlan'][0]['discount'])?($product['providerPlan'][0]['discount']):''),
      	'class'		  => 'form-control',
    );
	
	$price_month = array(
    	'name'        => 'price_month',
      	'id'          => 'price_month',
      	'value'       => (isset($product['providerPlan'][0]['price_month'])?(str_replace('.', ',', $product['providerPlan'][0]['price_month'])):''),
      	'class'		  => 'form-control',
      	'readonly'	  => 'readonly',
    );
	
	$price_total = array(
    	'name'        => 'price_total',
      	'id'          => 'price_total',
      	'value'       => (isset($product['providerPlan'][0]['price_total'])?(str_replace('.', ',', $product['providerPlan'][0]['price_total'])):''),
      	'class'		  => 'form-control',
      	'readonly'	  => 'readonly',
    );
	
	$dt_start_installment = array(
    	'name'        => 'dt_start_installment',
      	'id'          => 'dt_start_installment',
      	'value'       => (isset($product['providerPlan'][0]['dt_start_installment'])?($product['providerPlan'][0]['dt_start_installment']):''),
      	'class'		  => 'form-control',
    );
	
	$dt_end_installment = array(
    	'name'        => 'dt_end_installment',
      	'id'          => 'dt_end_installment',
      	'value'       => (isset($product['providerPlan'][0]['dt_end_installment'])?($product['providerPlan'][0]['dt_end_installment']):''),
      	'class'		  => 'form-control',
      	'readonly'	  => 'readonly',
    );
	
	//=================================================
	
	$dt_start = array(
    	'name'        => 'dt_start',
      	'id'          => 'dt_start',
      	'value'       => (isset($product['providerPlan'][0]['dt_start'])?($product['providerPlan'][0]['dt_start']):''),
      	'class'		  => 'form-control',
    );
	
	$dt_end = array(
    	'name'        => 'dt_end',
      	'id'          => 'dt_end',
      	'value'       => (isset($product['providerPlan'][0]['dt_end'])?($product['providerPlan'][0]['dt_end']):''),
      	'class'		  => 'form-control',
      	'readonly'	  => 'readonly',
    );
	
	$obsPlan = array(
    	'name'        => 'obsPlan',
      	'id'          => 'obsPlan',
      	'value'       => (isset($product['providerPlan'][0]['obs'])?($product['providerPlan'][0]['obs']):''),
      	'class'		  => 'form-control',
    );
			
	$plans = array();
	foreach ($plansList as $key => $row) 
		$plans[$row['id']] = $row['name'];
			
	//========CAMPOS EM DESTAQUE (VALIDACAO)==============
	if(isset($input_error))
	{
		if(in_array('email', $input_error))
			$email['class'] = 'target';
	}
?>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://www.homolog.armazemcoletivo.com.br/admin/assets/js/maskedinput.js" type="text/javascript" charset="utf-8"></script>
<script src="https://www.homolog.armazemcoletivo.com.br/admin/assets/build/js/moment.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
      window.onload = function()  {
        CKEDITOR.replace('description');
      };
 
	$('#phone1').mask("(99) 9 9999-9999");
	$('#phone2').mask("(99) 9 9999-9999");
    $(document).ready( function() {
    	
    	
    	$("#providerForm").submit(function (event){
        	var msg = 'Campos obrigatórios: ';
        	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        	var erro = false;
			if ( $("#name" ).val() == "" ) {
				msg = msg + 'Nombre ';
				erro = true;
			}
			if ( $("#email" ).val() == "" ) {
				msg = msg + ',Email ';
				erro = true;
			}
			if ( $("#tipo_descuento" ).val() == "2" ) {
				if ( $("#descuento" ).val() == "" ) {
					msg = msg + ',Descuento ';
					erro = true;
				}
			}
			if ( $("#tipo_descuento" ).val() == "4" ) {
				if ( $("#url_ws" ).val() == "" ) {
					msg = msg + ',URL web Service ';
					erro = true;
				}
			}
			if ( $("#tipo_descuento" ).val() == "X" ) {
					msg = msg + ',Descuento ';
					erro = true;
			}
			if( ($("#providerfile" ).val() != "" )&&( $("#ck_imagem" ).prop('checked')== false))
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
		
		$('input[type="file"]').change(function(){
			var ext = $(this).val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['jpg','jpeg']) == -1) {
			    alerta('extensão de imagem inválida.');
			}else{
				trocarFoto();
			}
			
		});
		
		function trocarFoto()
		{
			var formulario = document.getElementById('providerForm');
			var formData = new FormData(formulario);
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('provider/carregaFoto')?>',
				data: formData,
				dataType: 'json',
				success: function(returnedData){
					if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
					{
						$("#imgprovider").val(returnedData.file_name+'.'+returnedData.type);
						$(".img_provider").attr("src",returnedData.upload_path+'\\'+returnedData.file_name+'.'+returnedData.type);
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
		
		
		$('#fk_plan').change(function(){
			var id				= $(this).val(); 
			var formularioPlan 	= document.getElementById('providerPlanForm');
			//var formDataPlan 	= new FormData(formularioPlan);
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('plan/staticGetJson')?>',
				data: 'id='+id,
				dataType: 'json',
				success: function(returnedData){
					if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
					{
						$("#months").val(returnedData.period);
						$("#price_month").val(returnedData.price_period);
						$("#price_total").val(returnedData.price_total);
						$("#price_total_original").val(returnedData.price_total);
						$("#description").val(returnedData.description);
						$("#discount").val('0');
						var i = 1;
						for(i=1;i<=parseInt(returnedData.period);i++){
							$('#months_installment').append('<option value='+i+'>'+i+'</option>');
						}
						$("#months_installment").val(parseInt(returnedData.period)).change();
						now = new Date();
						let atual	= moment(now);
						
						var day 	= atual.format('DD');
						var month 	= atual.format('MM');
						var year 	= atual.format('YYYY');
						
						let d 			= moment([year, month, day]);
						let d_end_ins 		= moment([year, month, day]);
						d.add(returnedData.period-1,'month');
						d_end_ins.add(returnedData.period-2,'month');
						$("#dt_end").val(d.format('DD/MM/YYYY'));
						$("#dt_start").val(atual.format('DD/MM/YYYY'));
						$("#dt_end_installment").val(d_end_ins.format('DD/MM/YYYY'));
						$("#dt_start_installment").val(atual.format('DD/MM/YYYY'));
						
						alerta('Sucesso!','Plano '+returnedData.name+' resgatados.');
					}
					else
					{
						alerta('warning','Erro ao retornar dados dos Planos.');
					}
				},
				async: true
			});
		});
		
		$('#icoAdd').click(function(){
			var id						= $('input:hidden[name=id]').val();
			var price_total_original	= $('input:hidden[name=price_total_original]').val();
			var plans					= $('#plans').val(); //id do produtor
			var months					= $('#months').val(); //id do produtor
			var dt_start				= $('#dt_start').val(); //id do produtor
			var dt_end					= $('#dt_end').val(); //id do produtor
			var months_installment		= $('#months_installment').val(); //id do produtor
			var discount				= $('#discount').val(); //id do produtor
			var price_month				= $('#price_month').val(); //id do produtor
			var price_total				= $('#price_total').val(); //id do produtor
			var dt_start_installment	= $('#dt_start_installment').val(); //id do produtor
			var dt_end_installment		= $('#dt_end_installment').val(); //id do produtor
			var obs						= $('#obsPlan').val(); //id do produtor
			alert(obs);
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('plan/savePagto')?>',
				data: {
					fk_provider : id,
					price_total_original : price_total_original,
					fk_plan : plans,
					months : months,
					dt_start : dt_start,
					dt_end : dt_end,
					months_installment : months_installment,
					discount : discount,
					price_month : price_month,
					price_total : price_total,
					dt_start_installment : dt_start_installment,
					dt_end_installment : dt_end_installment,
					obs : obs
					},
				dataType: 'json',
				success: function(returnedData){
					if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
					{
						alerta('Sucesso!','Dados salvos.');
					}
					else
					{
						alerta('warning','Erro ao retornar dados dos Planos.');
					}
				},
				async: true
			});
		});
		
		$('#tipo_descuento').change(function(){
			var selection = $('#tipo_descuento').val();
			switch(selection){
				case '1'://descuento por producto
					$('#rangos_descuento').css('display','none');
					$("#descuento").prop('disabled', true);
					$("#descuento").val('');
				break;
				case '2'://descuento único
					$('#rangos_descuento').css('display','none');
					$("#descuento").removeAttr('disabled');
				break;
				case '3'://descuento por provedor
					$('#rangos_descuento').css('display','block');
					$("#descuento").prop('disabled', true);
					$("#descuento").val('');
				break;
				case '4'://valores de descuento y precios por webservice
					$('#web_service').css('display','block');
					$('#rangos_descuento').css('display','none');
					$("#descuento").prop('disabled', true);
					$("#descuento").val('');
				break;				
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
			<h3>Fornecedor</h3>
  		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Dados do Fornecedor</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?$attributes = array('name' => 'providerForm', 'id' => 'providerForm','enctype'=>'multipart/form-data');?>
						<?=form_open('provider/save',$attributes,isset($hidden)?$hidden:'');?>
						<input type="hidden" name="imgprovider" id="imgprovider" value="<?=(isset($provider[0]['foto'])?$provider[0]['foto']:'')?>"/>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<table id="table">
								<tr>
									<td align="center">
										<div class="col-md-12 col-sm-12 col-xs-12 form-group">
											<div id="preview" class="provider">
												<?
													if(isset($provider[0]['id']))
														$image = $this->image->getProviderUrl($provider[0]['id']);
													else
														$image = base_url('public/images/provider/default.gif');
												?>
												<img class="img_provider" width="500" height="260" src='<?=$image?>' />
											</div>
										</div>
										<label for="imagem">
										      <span class="glyphicon glyphicon-retweet" ></span>
										      <input type="file" id="imagem" name="providerfile" style="display:none"></br>
										      <small>somente formato .jpg</small>
										</label>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Código<small> Para acessar pedidos</small></label>
							<?=form_input($code)?>
						</div>
						<div class="col-md-9 col-sm-12 col-xs-12 form-group">
							<label>Nome</label>
							<?=form_input($name)?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 form-group">
							<label>Contato</label>
							<?=form_input($name_contact)?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 form-group">
							<label>URL Amigável <small>www.armazemcoletivo.com.br/<b>minha_loja</b></small></label>
							<?=form_input($url_friendly)?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Descrição</label>
							<?=form_textarea($description)?>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<label>Web Site</label>
							<?=form_input($web_site)?>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 form-group">
							<label>E-mail</label>
							<?=form_input($email)?>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12 form-group">
							<label>Telefone1</label>
							<?=form_input($phone1)?>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12 form-group">
							<label>Telefone2</label>
							<?=form_input($phone2)?>
						</div>	
						<div class="col-md-4 col-sm-12 col-xs-12 form-group">
							<label>Fax</label>
							<?=form_input($fax)?>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Ativo</label>
							<?=form_dropdown('active',$active,isset($provider[0]['active'])?$provider[0]['active']:'1','class="form-control"')?>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Taxa Armazém Coletivo</label>
							<?=form_input($tax)?>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Tipo de Desconto</label>
							<?=form_dropdown('tipo_discuento',$tipo_discuento,isset($provider[0]['type_discount'])?$provider[0]['type_discount']:'2','class="form-control" id="tipo_descuento"')?>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Desconto</label>
							<?=form_input($descuento)?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Pagamentos Aceitos</label><br>
							<?='Dinheiro '.form_checkbox($tp_pagto_dinheiro).'| Débito '.form_checkbox($tp_pagto_debito).'| Crédito '.form_checkbox($tp_pagto_credito).'| Boleto '.form_checkbox($tp_pagto_boleto).'| Transferência '.form_checkbox($tp_pagto_transferencia);?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Dia de Fornadas</label><br>
							<?='Seg '.form_checkbox($segunda).'| Ter '.form_checkbox($terca).'| Qua '.form_checkbox($quarta).'| Qui '.form_checkbox($quinta).'| Sex '.form_checkbox($sexta).'| Sab '.form_checkbox($sabado).'| Dom '.form_checkbox($domingo);?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>OBS</label>
							<?=form_textarea($obs)?>
						</div>

						<table class="table">
							<tr>				
								<td align="left">
	                                <button type="reset" id="reset" class="btn btn-success">Limpar</button>
	                                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
								</td>
							</tr>
						</table>
						<?=form_close()?>
					</div>
					
				</div>
			</div>
			
			<?if(!(count($provider['providerPlan'])>0)){?>
		        <script type="text/javascript">
		            $(function () {
		            	function calc(){
							var dt_start = $("#dt_start_installment").val();
							var day 	= dt_start.substring(0,2);
							var month 	= dt_start.substring(3,5);
							var year 	= dt_start.substring(6,10);
							
							let dt 		= moment([year, month, day]);
							dt.add(($('#months_installment').val()-1),'month');
							console.log('sadasd');
							//alert(dt);
							//$("#dt_end_installment").val(dt.format('DD/MM/YYYY'));
					
							var discount 			= $('#discount').val(); 
							var price_total 		= $('input:hidden[name=price_total_original]').val();
							var months_installment 	= $('#months_installment').val();
							var new_price_total 	= 0;
							
							price_total 			= price_total.replace("R$","");
							price_total 			= price_total.replace(",",".");
							discount 				= discount.replace("R$","");
							discount 				= discount.replace(",",".");
							
							new_price_total			= parseFloat(price_total) - parseFloat(discount);
							months_installment 		= months_installment.replace(",",".");
							var price_month			= new_price_total / parseInt(months_installment);
							$('#price_month').val(price_month.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
							$('#price_total').val(new_price_total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
		            	}
		            	
			            $('#datetimepicker1').datetimepicker({
			                viewMode: 'days',
			                format: 'DD/MM/YYYY'
			            });
			            $('#discount').on('change', function(e){
			            	calc();
			            });
			            
			            $('#months_installment').on('change', function(e){
							calc();
			            });
			            
			            $('#datetimepicker1').on('dp.change', function(e){
							var dt_start = $("#dt_start_installment").val();
							var day 	= dt_start.substring(0,2);
							var month 	= dt_start.substring(3,5);
							var year 	= dt_start.substring(6,10);
							let dt 		= moment([year, month, day]);
							dt.add(($('#months_installment').val()-2),'month');
							//$("#dt_end").val(dt.format('DD/MM/YYYY'));
							$("#dt_end_installment").val(dt.format('DD/MM/YYYY'));
			            });
		            });
		        </script>
				
				
				
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title"><strong>&#9679; Dados do Plano</strong>
	                    <ul class="nav navbar-right panel_toolbox">
	                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                    </ul>
	                    <div class="clearfix"></div>
					</div>
					<div class="x_content" style="display:<?=(isset($provider['providerPlan'][0])?'none':'block')?>">
						<form action="<?=base_url('plan/savePagto/'.$provider[0]['id'])?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="providerPlanForm">
						<input type="hidden" name="fk_provider" id="fk_provider" value="<?=($provider[0]['id']);?>"/>
						<fieldset>
							<div class="col-md-3 col-sm-3 col-xs-3 form-group">
								<label>Planos</label>
								<?=form_dropdown('fk_plan',$plans,'','class="form-control" id="fk_plan"')?>
							</div>
	
							<div class="col-md-3 col-sm-3 col-xs-3 form-group">
								<label>Vigencia do Plano<small>(meses)</small></label>
								<?=form_input($months)?>
							</div>
							
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Data de Início do Plano</label>
			                <?=form_input($dt_start)?>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-3 form-group">
							<label>Data Fim do Plano</label>
		                    <?=form_input($dt_end)?>
						</div>
						</fieldset>
	
						
						<fieldset>
							<legend>Dados Financeiros</legend>
							
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Parcelas</label>
								<?=form_dropdown('months_installment',$months_installment,'','class="form-control" id="months_installment"')?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Desconto</label>
								<?=form_input($discount)?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Valor/mês</label>
								<?=form_input($price_month)?>
							</div>
							
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Valor Total</label>
								<?=form_input($price_total)?>
								<input type="hidden" name="price_total_original" id = "price_total_original">
							</div>
							
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Data de Início</label>
				                <div class='input-group date' id='datetimepicker1'>
				                    <?=form_input($dt_start_installment)?>
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
							
							<div class="col-md-2 col-sm-2 col-xs-2 form-group">
								<label>Data Fim</label>
			                    <?=form_input($dt_end_installment)?>
							</div>
							
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<label>Obs</label>
								<?=form_textarea($obsPlan)?>
							</div>
							
							<table class="table">
								<tr>				
									<td align="left">
		                                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
									</td>
								</tr>
							</table>
							
						</fieldset>
	
						<?=form_close()?>

						
					</div>
				</div>
			</div>
			<?}?>
			<?if(count($provider['providerPlan'])>0){?>
				<div class="col-md-12">
					<div class="x_panel">
						<div class="x_title"><strong>&#9679; Dados do Plano Contratado - <?=(isset($provider[0]['name'])?$provider[0]['name']:'')?></strong>
		                    <ul class="nav navbar-right panel_toolbox">
		                      	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		                      	<li><a class="close-link"><i class="fa fa-close"></i></a></li>
		                    </ul>
		                    <div class="clearfix"></div>
						</div>
						<div class="x_content" style="display:<?=(isset($provider)?'block':'none')?>">
							<table border="0" cellspacing="5" cellpadding="5" style="width: 100%">
								<tr>
									<th colspan="6"><center><h2>Plano: <u><?=$plan[0]['name']?><u></h2></center></th>
								</tr>
								<tr>
									<th rowspan="3">Dados do Plano Original</th>
									<th>Parcelamento</th>
									<th>$ por período</th>
									<th>$ Total</th>
									<th>Início Plano</th>
									<th>Fim Plano</th>
								</tr>
								<tr>
									<td><?=$plan[0]['period']?> <?=(($plan[0]['tp_period']=='month')?'meses':'')?></td>
									<td>R$ <?=$plan[0]['price_period']?></td>
									<td>R$ <?=$plan[0]['price_total']?></td>
									<td><?=$this->format_date->us2br($provider['providerPlan'][0]['dt_start'])?></td>
									<td><?=$this->format_date->us2br($provider['providerPlan'][0]['dt_end'])?></td>
								</tr>
								<tr style="border-bottom: 1px solid #CCC;">
									<td colspan="6">
										<?=$provider['providerPlan'][0]['obs']?>
									</td>
								</tr>
								<tr>
									<th rowspan="3">Dados de Pagamento do Cliente</th>
									<th>Parcelamento</th>
									<th>$ por período</th>
									<th>$ Total</th>
									<th>Pagamento Inicial</th>
									<th>Pagamento Final</th>
								</tr>
								<tr>
									<td><?=$provider['providerPlan'][0]['months_installment']?> x (<?=($provider['providerPlan'][0]['tp_installment']=='0')?'À vista':'Parcelado'?>)</td>
									<td>R$ <?=$provider['providerPlan'][0]['price_month']?></td>
									<td>R$ <?=$provider['providerPlan'][0]['price_total']?><br> <small>(Desconto: R$ <?=$provider['providerPlan'][0]['discount']?>)</small></td>
									<td><?=$this->format_date->us2br($provider['providerPlan'][0]['dt_start_installment'])?></td>
									<td><?=$this->format_date->us2br($provider['providerPlan'][0]['dt_end_installment'])?></td>
								</tr>
								<tr>
									<td colspan="6">
										<?=$plan[0]['description']?>
									</td>
								</tr>

							</table>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?}?>

		</div>
	</div>
	<div class="clearfix"></div>
</div>
