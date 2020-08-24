<?php
	$uf = array(
		'X' => 'Escolha um Estado',
		'AC' => 'AC',
		'AL' => 'AL',
		'AM' => 'AM',
		'AP' => 'AP',
		'BA' => 'BA',
		'CE' => 'CE',
		'DF' => 'DF',
		'ES' => 'ES',
		'GO' => 'GO',
		'MA' => 'MA',
		'MG' => 'MG',
		'MS' => 'MS',
		'MT' => 'MT',
		'PA' => 'PA',
		'PB' => 'PB',
		'PE' => 'PE',
		'PI' => 'PI',
		'PR' => 'PR',
		'RJ' => 'RJ',
		'RN' => 'RN',
		'RO' => 'RO',
		'RR' => 'RR',
		'RS' => 'RS',
		'SC' => 'SC',
		'SE' => 'SE',
		'SP' => 'SP',
		'TO' => 'TO'
	);
	$listaCidade['X']	= '[X] ...escolha uma cidade...';
	if(isset($cidadeList)){
		foreach ($cidadeList as $key => $row){
			$listaCidade[$row['id']] = '['.$row['uf'].']'.' - '.$row['nome'];
		}
	}

	$namepage = array(
      'name'        => 'namepage',
      'id'          => 'namepage',
      'value'       => (isset($_REQUEST['namepage'])?$_REQUEST['namepage']:''),
      'class'       => 'form-control',
    );
	$codigo = array(
      'name'        => 'codigo',
      'id'          => 'codigo',
      'value'       => (isset($_REQUEST['codigo'])?$_REQUEST['codigo']:''),
      'class'       => 'form-control',
    );
	$name = array(
      'name'        => 'name',
      'id'          => 'name',
      'value'       => (isset($_REQUEST['name'])?$_REQUEST['name']:''),
      'class'       => 'form-control',
    );
	$phone = array(
      'name'        => 'phone',
      'id'          => 'phone',
      'value'       => (isset($_REQUEST['phone'])?$_REQUEST['phone']:''),
      'class'       => 'form-control',
    );
	$email = array(
      'name'        => 'email',
      'id'          => 'email',
      'value'       => (isset($_REQUEST['email'])?$_REQUEST['email']:''),
      'class'       => 'form-control',
    );
	$adress = array(
      'name'        => 'adress',
      'id'          => 'adress',
      'value'       => (isset($_REQUEST['adress'])?$_REQUEST['adress']:''),
      'class'       => 'form-control',
    );
	$numero = array(
      'name'        => 'numero',
      'id'          => 'numero',
      'value'       => (isset($_REQUEST['numero'])?$_REQUEST['numero']:''),
      'class'       => 'form-control',
    );
	$adressnumber = array(
      'name'        => 'adressnumber',
      'id'          => 'adressnumber',
      'value'       => (isset($_REQUEST['adressnumber'])?$_REQUEST['adressnumber']:''),
      'class'       => 'form-control',
    );
	$adressneighborhood = array(
      'name'        => 'adressneighborhood',
      'id'          => 'adressneighborhood',
      'value'       => (isset($_REQUEST['adressneighborhood'])?$_REQUEST['adressneighborhood']:''),
      'class'       => 'form-control',
    );
	$adressprovince = array(
      'name'        => 'adressprovince',
      'id'          => 'adressprovince',
      'value'       => (isset($_REQUEST['adressprovince'])?$_REQUEST['adressprovince']:''),
      'class'       => 'form-control',
    );
	$tpservice = array(
		'name'        => 'tpservice',
		'id'          => 'tpservice',
		'value'       => (isset($_REQUEST['tpservice'])?$_REQUEST['tpservice']:''),
		'class'       => 'form-control',
	  );
	$tpservice_ = array(
		'Manicure/Pedicure'			=> 'Manicure/Pedicure',
		'Professor Programação'		=> 'Professor Programação',
		'Professor Piano'			=> 'Professor Piano',
		'Professor Artesanato'		=> 'Professor Artesanato',
		'Cabeleireira(o)' 			=> 'Cabeleireira(o)',
		'Serviços residenciais' 	=> 'Serviços residenciais',
		'Fotógrafo' 				=> 'Fotógrafo',
		'Encanador' 				=> 'Encanador',
		'Psicóloga(o)' 				=> 'Psicóloga(o)',
		'Coach' 					=> 'Coach',
		'Terapeuta Ocupacional' 	=> 'Terapeuta Ocupacional',
		'Entregas Delivery' 		=> 'Entregas Delivery',
		'Médico da Família' 		=> 'Médico da Família',
		'Enfermeira(o)' 			=> 'Enfermeira(o)',
		'Cuidador de Crianças' 		=> 'Cuidador de Crianças',
		'Cuidador de Idosos' 		=> 'Cuidador de Idosos',
	);
	if(isset($provider[0]['dia_entrega'])){
		$dia_entrega = explode(',', $provider[0]['dia_entrega']);
		
	}
	$obs = array(
      'name'        => 'obs',
      'id'          => 'obs',
      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
      'class'       => 'form-control',
      'rows'      	=> '6',
    );
	$codpromocioanl = array(
      'name'        => 'codpromocioanl',
      'id'          => 'codpromocioanl',
      'value'       => (isset($_REQUEST['codpromocioanl'])?$_REQUEST['codpromocioanl']:''),
      'class'       => 'form-control',
    );
	$hrinicio = array(
      'name'        => 'hrinicio',
      'id'          => 'hrinicio',
      'value'       => (isset($_REQUEST['hrini'])?$_REQUEST['hrini']:''),
      'class'       => 'form-control',
    );
	$hrfim = array(
      'name'        => 'hrfim',
      'id'          => 'hrfim',
      'value'       => (isset($_REQUEST['hrini'])?$_REQUEST['hrini']:''),
      'class'       => 'form-control',
    );
	$codpromocional = array(
      'name'        => 'codpromocional',
      'id'          => 'codpromocional',
      'value'       => (isset($_REQUEST['codpromocional'])?$_REQUEST['codpromocional']:''),
      'class'       => 'form-control',
    );
	$qtdeatendimentos = array(
		'1'			=> '1',
		'2'			=> '2',
		'3' 		=> '3',
		'4' 		=> '4',
		'5' 		=> '5',
		'6' 		=> '6',
		'7' 		=> '7',
		'8' 		=> '8',
		'9' 		=> '9',
		'10' 		=> '10',
		'11' 		=> '11',
		'12' 		=> '12',
		'13' 		=> '13',
		'14' 		=> '14',
		'15' 		=> '15',
	);
	$hora = array(
		''			=> 'HORA',
		'06'		=> '06',
		'07'		=> '07',
		'08' 		=> '08',
		'09' 		=> '09',
		'10' 		=> '10',
		'11' 		=> '11',
		'12' 		=> '12',
		'13' 		=> '13',
		'14' 		=> '14',
		'15' 		=> '15',
		'16' 		=> '16',
		'17' 		=> '17',
		'18' 		=> '18',
		'19' 		=> '19',
		'20' 		=> '20',
		'21' 		=> '21',
		'22' 		=> '22',
		'23' 		=> '23',
	);
	$minuto = array(
		'' 			=> 'MINUTOS',
		'0' 		=> '00',
		'5' 		=> '05',
		'10' 		=> '10',
		'15' 		=> '15',
		'20' 		=> '20',
		'25' 		=> '25',
		'30' 		=> '30',
		'35' 		=> '35',
		'40' 		=> '40',
		'45' 		=> '45',
		'50' 		=> '50',
		'55' 		=> '55',
	);
	$minutoTpConsulta = array(
		'' 			=> 'MINUTOS',
		'0' 		=> '00',
		'5' 		=> '05',
		'10' 		=> '10',
		'15' 		=> '15',
		'20' 		=> '20',
		'25' 		=> '25',
		'30' 		=> '30',
		'35' 		=> '35',
		'40' 		=> '40',
		'45' 		=> '45',
		'50' 		=> '50',
		'55' 		=> '55',
		'60' 		=> '1:00',
		'65' 		=> '1:05',
		'70' 		=> '1:10',
		'75' 		=> '1:15',
		'80' 		=> '1:20',
		'85' 		=> '1:25',
		'90' 		=> '1:30',
		'95' 		=> '1:35',
		'100' 		=> '1:40',
		'105' 		=> '1:45',
		'110' 		=> '1:50',
		'115' 		=> '1:55',
		'120' 		=> '2:00',

	);
	$tempoconsulta = array(
      'name'        => 'tempoconsulta',
      'id'          => 'tempoconsulta',
      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
      'class'       => 'form-control',
    );
	$sexo = array(
		'X' 		=> 'Selecione',
		'M' 		=> 'M',
		'F' 		=> 'F',
	);
?>
<script type="text/javascript"> 
$(document).ready(function(){
	
	$('#phone').mask('(99) 9 9999 9999');
	$('#hrinicio').mask('99:99');
	$('#hrfim').mask('99:99');
	
	$("#profissionalForm").submit(function (event){
    	var msg = 'Campos obrigatórios: ';
    	var erro = false;
		if ( $("#namepage" ).val() == "" ) {
			msg = msg + 'Nome da Página, ';
			erro = true;
		}
		if ( $("#name" ).val() == "" ) {
			msg = msg + 'Nome, ';
			erro = true;
		}
		if ( $("#phone" ).val() == "(__)_ ____ _____" ) {
			msg = msg + 'Nome, ';
			erro = true;
		}
		if ( $("#sexo" ).val() == "X" ) {
			msg = msg + 'Sexo, ';
			erro = true;
		}
		if ( $("#email" ).val() == "" ) {
			msg = msg + 'Email, ';
			erro = true;
		}
		if ( $("#adress" ).val() == "" ) {
			msg = msg + 'Rua, ';
			erro = true;
		}
		if ( $("#adressnumber" ).val() == "" ) {
			msg = msg + 'Número, ';
			erro = true;
		}
		if ( $("#adressneighborhood" ).val() == "" ) {
			msg = msg + 'Bairro, ';
			erro = true;
		}
		if ( $("#adressprovince" ).val() == "X" ) {
			msg = msg + 'Estado, ';
			erro = true;
		}
		if ( $("#adresscity" ).val() == "X" ) {
			msg = msg + 'Cidade, ';
			erro = true;
		}
		if ( $("#tempoconsulta" ).val() == "" ) {
			msg = msg + 'Tempo de Consulta, ';
			erro = true;
		}
		if ( $("#intervalo" ).val() == "" ) {
			msg = msg + 'Intervalo, ';
			erro = true;
		}
		var tp_serviceIsChecked = $('input[name="tp_service[]"]:checked').length > 0;
		if(!tp_serviceIsChecked){
			msg = msg + 'Serviço Prestado, ';
			erro = true;
		}
		var diaSemanaIsChecked = $('input[name="diaSemana[]"]:checked').length > 0;
		if(!diaSemanaIsChecked){
			msg = msg + 'Dia da Semana, ';
			erro = true;
		}
		if(! $("input[type='radio'][name='plan']").is(':checked') ){
			msg = msg + 'Plano desejado,';
			erro = true;
		}
		var diaSemanaIsChecked = $('input[name="termo_uso"]:checked').length > 0;
		if(!diaSemanaIsChecked){
			msg = msg + 'Termo de Uso. ';
			erro = true;
		}
		
		if(erro){
			alert(msg);
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
			    $('#status').html('');
			    $('#status').html('extensão de imagem inválida.');
			}else{
				trocarFoto();
			}
			
		});
		
		function trocarFoto()
		{
			var formulario = document.getElementById('profissionalForm');
			var formData = new FormData(formulario);
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('profissional/carregaFoto')?>',
				data: formData,
				dataType: 'json',
				success: function(returnedData){
					if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
					{
						$("#imgprofissional").val(returnedData.file_name+'.'+returnedData.type);
						$(".img_profissional").attr("src",returnedData.upload_path+'\\'+returnedData.file_name+'.'+returnedData.type);
					}
					else
					{
						$('#status').html('');
						$('#status').html('Desculpe, ocorreu um erro ao abrir dispositivo de Troca de Foto de Perfil. Desculpe!');
					}
				},
				cache: false,
				contentType: false,
				processData: false,
		        xhr: function() { // Custom XMLHttpRequest
		            var myXhr = $.ajaxSettings.xhr();
		            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
		                myXhr.upload.addEventListener('progress', function() {
		                	$('#status').html('');
		                	$('#status').html('Arquivo selecionado. Processando operação.');
		                }, false);
		            }else{
		            	$('#status').html('');
		            	$('#status').html('Você não tem suporte para XMLHttpRequest');
		            }
		            return myXhr;
		        }
			});
		}


	$('#adressprovince').change(function() {
		buscaCidade();
	});

	function buscaCidade(){
		var iconCarregando              = $('<img src="<?php echo base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
		var element 					= document.getElementById("adressprovince");
    	var estado 						= element.options[element.selectedIndex].value;
		var viewName					= '<?=base_url("contact/getCityListJson")?>';
		var x 							= '';
		jQuery.ajax({
			type: "POST",
			url: viewName,
			data: 	{uf:estado},
			dataType: 'json',
			success: function(returnedData){
				if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
				{
					$("#adresscity").html('');
					$("#adresscity").append(returnedData.options);
					$("#adresscity").css('border', '1px solid rgba(168, 179, 0, 0.9)');
					$("#adresscity").css('background-color', '#fdffe2');
					setTimeout(function(){
						$("#adresscity").css('border', '1px solid #828385');
						$("#adresscity").css('background-color', '#FFFFFF');
					},4000);
					$('#adresscity').focus();
				}
				else
				{
					$("#adresscity").html('');
	 				$("#adresscity").html('<option value="X">[X] ...escolha uma cidade...</option>');
				}
			},
			async: true
		});
	}
	
	$('#buscaCodPromocional').click(function() {
		buscaCodPromocional();
	});
	
	function buscaCodPromocional(){
		var codpromocional 					= $('#codpromocional').val();
		var viewName						= '<?=base_url("profissional/getPromocao")?>';
		jQuery.ajax({
			type: "POST",
			url: viewName,
			data: 	{cod:codpromocional},
			dataType: 'json',
			success: function(returnedData){
				if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
				{
					//$('#tablePlan').html('');
					//$('#tablePlan').html(returnedData.planData);
					$('#msgCod').html('');
					$('#msgCod').html(returnedData.msg);
					//$('#planId').html('');
					$('#planId').val(returnedData.idPlan);
					$("#tablePlan").append(returnedData.planData);
					$radio = $('input:radio[value='+returnedData.idPlan+']');
					$radio.filter('[value='+returnedData.idPlan+']').prop('checked', true);
				}
				else
				{
					$('#tablePlan').html('');
					$('#msgCod').html('');
					$('#planId').html('');
					alert('Código Promocional não encontrado.');
				}
			},
			async: true
		});
	}

});
</script>
<!-- Page Content -->
<div class="container">
	<div class="row" style="text-align: center;">
		<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 30px; margin-top: 30px; padding: 30px; background-color: #FFD242;border-radius: 10px;">
			<center>
				<h1><b>Cadastro de Prestadores de Serviços.</b></h1>
				<p><h4>Aqui você se cadastra para divulgar os seus serviços no Armazém Coletivo. Após o cadastro enviamos um e-mail de confirmação para o e-mail cadastrado e liberação de seu cadastro. <h4></p>
			</center>
		</div>
	</div>
	<div class="row">
		<!-- Begin Products -->
		<div class="col-lg-12">
			<h1><center>Cadastro de Parceiros Prestadores de Serviços</center></h1>			
		</div>
		<div class="col-lg-12">
			<?php $attributes = array('name' => 'profissionalForm', 'id' => 'profissionalForm','enctype'=>'multipart/form-data');?>
			<?php echo form_open('profissional/send',$attributes,isset($hidden)?$hidden:'');?>
			<!--input type="hidden" name="planId" value="" id="planId"/-->
			<input type="hidden" name="imgprofissional" id="imgprofissional" value="<?=(isset($profissional[0]['foto'])?$profissional[0]['foto']:'')?>"/>
			<div class="row">
				<div class="col-lg-6">
					<h3><b>Dados Pessoais</b></h3>	
					<table id="table" style="width: 100%;">
						<tr>
							<td align="center">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div id="preview" class="profissional">
										<?
											if(isset($profissional[0]['id']))
												$image = $this->image->getProviderUrl($profissional[0]['id']);
											else
												$image = base_url('public/images/profissional/default.gif');
										?>
										<img class="img_profissional" width="300" height="300" src='<?=$image?>' />
									</div>
								</div>
								<label for="imagem">
								      <span class="glyphicon glyphicon-retweet btn btn-success" style="text-align: center;">Clique para inserir sua foto ou Logo</span>
								      <input type="file" id="imagem" name="profissionalfile" style="display:none"></br>
								      <small>somente formato .jpg (300px X 300px)</small>
								</label>
							</td>
						</tr>
					</table>
					<div id="status"></div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Nome da Página*</label>
						<?php echo form_input($namepage)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Senha de acesso</label>
						<?php echo form_input($codigo)?>
					</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<label>Descrição da sua Página</label>
							<?=form_textarea($obs)?>
						</div>
					<div class="row" style="margin: 0;">
						<div class="col-lg-10 col-md-10 mb-10">
							<label>Nome *</label>
							<?php echo form_input($name)?>
						</div>
						<div class="col-lg-2 col-md-2 mb-2">
							<label>Sexo *</label>
							<?=form_dropdown('sexo', $sexo,'X','style="" class="form-control" id="sexo"');?>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Telefone *</label>
						<?php echo form_input($phone)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>E-mail *</label>
						<?php echo form_input($email)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Rua</label>
						<?php echo form_input($adress)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Número</label>
						<?php echo form_input($adressnumber)?>
					</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Bairro</label>
						<?php echo form_input($adressneighborhood)?>
					</div>
		  			<div class="col-lg-12 col-md-12 mb-12">
		  				<label>Estado *</label>
		          		<?=form_dropdown('adressprovince', $uf,'X','style="" class="form-control" id="adressprovince"');?>
		  			</div>
		  			<div class="col-lg-12 col-md-12 mb-12">
		  				<label>Cidade *</label><small>Identifique corretamente a sua localidade porque assim você será melhor localizados pelos seus Clientes.</small>
		  				<?=form_dropdown('adresscity', $listaCidade,'X','style="" class="form-control" id="adresscity"');?>
		  			</div>
					<div class="col-lg-12 col-md-12 mb-12">
						<label>Observação *</label>
						<?php echo form_textarea($obs)?>
					</div>
				</div>
			
				<div class="col-lg-6">
					<h3><b>Dados Profissionais</b></h3>	

					<div class="row" style="margin-left: 0px;">
						<b>Especialidades <small>Tipos de atendimentos separados por vírgula</small></b><br>
						<?php echo form_input($tp_service)?>
					</div>
					
					<div class="cl">&nbsp;</div>
					
					<div class="row" style="margin-left: 0px;">
						<b>Dados dos Agendamentos</b>
					</div>					
					<div class="row" style="margin-left: 0px;">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-4">
									<label for="hrinicio_h">Hora de Inicio</label>
									<?=form_dropdown('hrinicio_h', $hora,'','style="" class="form-control" id="htinicio_h"');?>
								</div>
								<div class="col-lg-4">
									<label for="hrinicio_m">Minutos</label>
									<?=form_dropdown('hrinicio_m', $minuto,'','style="" class="form-control" id="htinicio_m"');?>
								</div>
								<div class="col-lg-4">
									<label for="qtdeatendimentos">Atend/dia</label>
									<?=form_dropdown('qtdeatendimentos', $qtdeatendimentos,'','style="" class="form-control" id="qtdeatendimentos"');?>								
								</div>
							</div>
						</div>
					</div>
					<br>
					
					<div class="row" style="margin-left: 0px;">
						<div class="col-lg-8">
							<label for="tempoconsulta_h">Tempo de Consulta</label>
							<?=form_dropdown('tempoconsulta', $minutoTpConsulta,'','style="" class="form-control" id="tempoconsulta"');?>
						</div>
						<div class="col-lg-4">
							<label for="intervalo">Intervalo<small> entre atends.</small></label>
							<?=form_dropdown('intervalo', $minuto,'','style="" class="form-control" id="intervalo"');?>
						</div>
					</div>
					
					<br>
					
					<div class="row" style="margin-left: 0px; background-color: #FFF9E7; padding: 10px 0px 5px 0px;" id="promocaoBox">
						<div class="col-lg-12">
							<label for="codpromocional"><h3>Insira seu código promocional</h3></label>
						</div>
						<div class="col-lg-6">
							<?php echo form_input($codpromocional)?>
						</div>
						<div class="col-lg-6">
							<input type="button" id="buscaCodPromocional" class="btn btn-success" value="Buscar Promoção" style="width: 100%;"/>
						</div>
						<div class="col-lg-12">
							<div id="msgCod" style="font-size: 13px; text-align: center; font-weight: bold;"></div>
						</div>
						<div class="col-lg-12"><center>ou</center></div>
						<div class="col-lg-12">
							
						<!--script type="text/javascript">
							$(document).ready(function(){
								$('input[type=radio][name=plan]').change(function(){
									selected_value = $("input[name='plan']:checked").val();
									$('#planId').val(selected_value);
						        });
							});
						
						</script-->
							</script>
							<table id="tablePlan" border='1' cellspacing='5' cellpadding='5' width='100%' style='margin: 0; border: 1px solid #CCCCCC;'>
								<tbody>
									<tr><th>Plano</th><th>Data Início</th><th>Qtde. de Parcelas</th><th>Valor da Parcela</th><th>Valor Total</th>
								<?foreach ($planos as $key => $value) {
									echo "</tr><tr><td>".form_radio(array('name'=>'plan','id'=>'plan','value'=>$value['id'])).' '.$value['name'].(($value['tp_plan']=='P')?'<b>(Promoção)</b>':'')."</td><td>".date('d-m-Y')."</td><td>".$value['period']."</td><td>".$value['price_period']."</td><td>".$value['price_total']."</td></tr>";
								}?>
								</tbody>
							</table>
						</div>
						
					</div>
					
					<br>
					
					<div class="row" style="margin-left: 0px;">
						<div class="col-lg-12">
							<input type="checkbox" name="termo_uso" id="termo_uso"/>
							<label>Lí e aceito os <a target="_blank" style="color: #3C3C3C; text-decoration: underline;" href="<?=base_url('cart/getTermoUso')?>">"Termos de Uso"</a> .</label>
						</div>
						<div class="col-lg-12">
							<br>
							<input type="submit" class="btn btn-success" value="Enviar"/>
							<br>
							<i>* Campos obrigatórios</i>
						</div>
					</div>
					
				</div>	
				
				<div class="cl">&nbsp;</div>	
				
			</div>
			<?php echo form_close()?>
		</div>
	</div>
</div>