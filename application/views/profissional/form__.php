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
		'Manicure/Pedicure' 		=> 'Manicure/Pedicure',
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
	$obs = array(
      'name'        => 'obs',
      'id'          => 'obs',
      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
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
	$tempoconsulta = array(
      'name'        => 'tempoconsulta',
      'id'          => 'tempoconsulta',
      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
      'class'       => 'form-control',
    );
	$sexo = array(
		'M' 		=> 'M',
		'F' 		=> 'F',
	);
?>
<script type="text/javascript"> 
$(document).ready(function(){
	
	$('#phone').mask('(99) 9 9999 9999');
	$('#hrinicio').mask('99:99');
	$('#hrfim').mask('99:99');
	
	$("#contactForm").submit(function (event){
    	var msg = 'Campos obrigatórios: ';
    	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
    	var erro = false;
		if ( $("#name" ).val() == "" ) {
			msg = msg + 'Nome, ';
			erro = true;
		}
		if ( $("#email" ).val() == "" ) {
			msg = msg + 'Email, ';
			erro = true;
		}
		if( $("#termo_uso").prop('checked') == false){
			msg = msg + 'Leia e Aceite os "Termos de Uso", ';
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

});
</script>
<!-- Page Content -->
<div class="container">
	<div class="row" style="text-align: center;">
		<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 30px; margin-top: 30px; padding: 30px; background-color: #FFD242;border-radius: 10px;">
			<center>
				<h2><b>Preste serviços para os Produtores do Armazém Coletivo.</b></h2>
				<p><h4>Se você faz entregas no seu bairro ou sua cidade, se cadastre aqui e tenha o seu contato disponível para produtores de sua região.<h4></p>
			</center>
		</div>
	</div>
	<div class="row">
		<!-- Begin Products -->
		<div class="col-lg-12">
			<h1><center>Cadastro de Parceiros Prestadores de Serviços</center></h1>			
		</div>
		<div class="col-lg-12">
			<?php $attributes = array('name' => 'contactForm', 'id' => 'contactForm','enctype'=>'multipart/form-data');?>
			<?php echo form_open('contact/sendLead',$attributes,isset($hidden)?$hidden:'');?>
			<div class="col-lg-6">
				<h3><b>Dados Pessoais</b></h3>	
				<div class="col-lg-12 col-md-12 mb-12">
					<label>Nome *</label>
					<?php echo form_input($name)?>
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
	  				<?=form_dropdown('adresscity', $listaCidade,'','style="" class="form-control" id="adresscity"');?>
	  			</div>
				<div class="col-lg-12 col-md-12 mb-12">
					<label>Observação *</label>
					<?php echo form_textarea($obs)?>
				</div>
				
			</div>
			<div class="col-lg-6">
				<h3><b>Dados Profissionais</b></h3>	
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-6">
						<b>Serviços de Salão</b><br>
						<?=form_checkbox($tpservice['Manicure/Pedicure']).$tpservice['Manicure/Pedicure']?><br>
						<?=form_checkbox($tpservice['Cabeleireira(o)']).$tpservice['Cabeleireira(o)']?>
					</div><br>
					<div class="col-lg-6">
						<b>Serviços Gerais</b><br>
						<?=form_checkbox($tpservice['Serviços residenciais']).$tpservice['Serviços residenciais']?><br>
						<?=form_checkbox($tpservice['Encanador']).$tpservice['Encanador']?>
					</div>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-6">
						<b>Terapeutas</b><br>
						<?=form_checkbox($tpservice['Psicóloga(o)']).$tpservice['Psicóloga(o)']?><br>
						<?=form_checkbox($tpservice['Terapeuta Ocupacional']).$tpservice['Terapeuta Ocupacional']?><br>
						<?=form_checkbox($tpservice['Coach']).$tpservice['Coach']?>
					</div><br>
					<div class="col-lg-6">
						<b>Entregas</b><br>
						<?=form_checkbox($tpservice['Entregas Delivery']).$tpservice['Entregas Delivery']?>
					</div>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-6">
						<b>Serviços Médicos</b><br>
						<?=form_checkbox($tpservice['Médico da Família']).$tpservice['Médico da Família']?><br>
						<?=form_checkbox($tpservice['Enfermeira(o)']).$tpservice['Enfermeira(o)']?>
					</div><br>
					<div class="col-lg-6">
						<b>Outros</b><br>
						<?=form_checkbox($tpservice['Fotógrafo']).$tpservice['Fotógrafo']?><br>
						<?=form_checkbox($tpservice['Cuidador de Idosos']).$tpservice['Cuidador de Idosos']?><br>
						<?=form_checkbox($tpservice['Cuidador de Crianças']).$tpservice['Cuidador de Crianças']?>
					</div>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-12">
						<b>Dia de Atendimento</b><br>
						<?='<small>Dom</small> '.form_checkbox($domingo).'| <small>Seg</small> '.form_checkbox($segunda).'| <small>Ter</small> '.form_checkbox($terca).'| <small>Qua</small> '.form_checkbox($quarta).'| <small>Qui</small> '.form_checkbox($quinta).'| <small>Sex</small> '.form_checkbox($sexta).'| <small>Sab</small> '.form_checkbox($sabado);?>
					</div>
				</div>
				<div class="cl">&nbsp;</div>
				<div class="row" style="margin-left: 0px;">
					<b>Dados dos Agendamentos</b>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-8">
						<label>Hora de Inicio dos Atendimentos</label>
					</div>
					<div class="col-lg-4">
						<label for="qtdeatendimentos">Atend/dia</label>
					</div>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-4">
								<?=form_dropdown('hrinicio_h', $hora,'','style="" class="form-control" id="htinicio_h"');?>
							</div>
							<div class="col-lg-4">
								<?=form_dropdown('hrinicio_m', $minuto,'','style="" class="form-control" id="htinicio_m"');?>
							</div>
							<div class="col-lg-4">
								<?=form_dropdown('qtdeatendimentos', $qtdeatendimentos,'','style="" class="form-control" id="qtdeatendimentos"');?>								
							</div>
						</div>
					</div>
				</div>
	
				<br>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-8">
						<label>Tempo de Cada Agendamento</label>
					</div>
					<div class="col-lg-4">
						<label for="intervalo">Intervalo</label> <small>entre atendimentos (min)</small>
					</div>
				</div>
				<div class="row" style="margin-left: 0px;">
					<div class="col-lg-4">
						<?=form_dropdown('tempoconsulta_h', array('HORA','0','1','2'),'','style="" class="form-control" id="tempoconsulta_h"');?>
					</div>
					<div class="col-lg-4">
						<?=form_dropdown('tempoconsulta_m', $minuto,'','style="" class="form-control" id="tempoconsulta_m"');?>
					</div>
					<div class="col-lg-4">
						<?=form_dropdown('intervalo', $minuto,'','style="" class="form-control" id="intervalo"');?>
					</div>
				</div>
			</div>
			
			<div class="cl">&nbsp;</div>
			
			<?php echo form_close()?>
		</div>
	</div>
</div>