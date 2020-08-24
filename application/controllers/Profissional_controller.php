<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profissional_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('form');
		$this->load->helper('email');
		//==== librarys =====
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		$this->load->library('pagination');
		$this->load->library('image');
		$this->load->library('banner');
		$this->load->library('industry');
		$this->load->library('debug');
		$this->load->library('web_service');
		$this->load->library('image_lib');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Print_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->load->model('Product_color_model', '', TRUE);
		$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Product_print_model', '', TRUE);
		$this->load->model('Cart_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
		$this->load->model('Plan_model', '', TRUE);
		$this->load->model('Profissional_model', '', TRUE);
		$this->load->model('Cidade_model', '', TRUE);
	}
	
	
	public function index(){}
	
	public function nome($url_friendly=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		
		//=======================================================
		$dados 							= array('url_friendly'=>$url_friendly,'tp_cliente'=>'S','ativo'=>'1','per_page'=>1,'maximo'=>1,'inicio'=>0,'main'=>'true');
		$profissional					= $this->Profissional_model->getList($dados);
		//$this->debug->show($profissional);
		$profissionalList = array();
		foreach ($profissional as $y => $row) {
			$cidade = $this->Cidade_model->staticGet($row['cidade']);
			$profissionalList[$y] = array(
				'id' 				=> $row['id'],
	            'namepage'			=> $row['namepage'],
	            'nome'				=> $row['nome'],
	            'codigo' 			=> $row['codigo'],
	            'url_friendly' 		=> $row['url_friendly'],
	            'especialidades' 	=> $row['especialidades'],
	            'diasemana' 		=> $row['diasemana'],
	            'hrinicio' 			=> $row['hrinicio'],
	            'qtdeatendimentos' 	=> $row['qtdeatendimentos'],
	            'tempoconsulta' 	=> $row['tempoconsulta'],
	            'intervalo' 		=> $row['intervalo'],
	            'sexo' 				=> $row['sexo'],
	            'tel1' 				=> $row['tel1'],
	            'tel2' 				=> $row['tel2'],
	            'email' 			=> $row['email'],
	            'emailmd5' 			=> $row['emailmd5'],
	            'rua' 				=> $row['rua'],
	            'numero' 			=> $row['numero'],
	            'estado' 			=> $row['estado'],
	            'cidade' 			=> $row['cidade'],
	            'cidadenome'		=> $cidade[0]['nome'],
	            'ativo'				=> $row['ativo'],
	            'imagem' 			=> $row['imagem'],
	            'dtcadastro' 		=> $row['dtcadastro'],
	            'description' 		=> $row['description'],
	            'obs' 				=> $row['obs'],
			);
		}
		//=======================================================
		$data['controller'] 			= 'main';
		$data['profissional']			= $profissionalList;
		$data['prof']					= $profissionalList;
		//$this->debug->show($profissional[0]['namepage']);
		/*===carrega metatags da header===*/
		$data['meta_title']			= $profissional[0]['namepage'];
		$data['meta_url']			= base_url('profissional/nome/'.$profissional[0]['url_friendly']);		
		$data['meta_description']	= 'Reserve um horário como '.$profissional[0]['especialidades'];
		$data['meta_logo']			= base_url('admin/public/images/profissional/'.$profissional[0]['imagem']);
		$data['meta_fb_id']			= '2623777591233311';
		$data['$meta_logo_width']	= '300';
		$data['$meta_logo_height']	= '300';
		/*===carrega metatags da header===*/
		
		$this->load->view('header',$data);
		$this->load->view('profissional/index',$data);
		$this->load->view('footer');
	}
	
	public function getPromocao(){
		$cod 				= $_REQUEST['cod']; 
		$dados 				= array('codpromocional'=>$cod,'tp_plan'=>'P','tp_cliente'=>'S','active'=>'1','per_page'=>1,'maximo'=>1,'inicio'=>0,'main'=>'true');
		$planList 			= $this->Plan_model->getList($dados);
		
		if(!empty($planList)){
			//$data['planData']		= '<table border="1" cellspacing="5" cellpadding="5" width="100%" style="margin: 0; border: 1px solid #CCCCCC;">';
			//$data['planData']		.= '<tr><th>Plano</th><th>Data Início</th><th>Qtde. de Parcelas</th><th>Valor da Parcela</th><th>Valor Total</th></tr>';
			$data['planData']		= '<tr><td>'.form_radio(array('name'=>'plan','id'=>'plan','value'=>$planList[0]['id'])).' '.$planList[0]['name'].(($planList[0]['tp_plan']=='P')?'<b> (Promoção)</b>':'').'</td><td>'.date('d-m-Y').'</td><td>'.$planList[0]['period'].'</td><td>'.$planList[0]['price_period'].'</td><td>'.$planList[0]['price_total'].'</td></tr>';
			//$data['planData']		.= '</table>';
			
			$data['idPlan']			= $planList[0]['id'];
			
			$data['msg']			= $planList[0]['description'];
			$data['error']			= FALSE;
		}else{
			$data['msg']			= 'Plano não encontrado.';
			$data['error']			= FALSE;
		}
		
		

		header('Content-Type: application/json');
		print json_encode($data);
	}

	public function send(){
		//$this->debug->show($_REQUEST);
		//dados recebidos via request
		//$dados['diasemana'] = ((($_REQUEST['diaSemanaDom']=='accept')?'1':'0').(($_REQUEST['diaSemanaSeg']=='accept')?',1':',0').(($_REQUEST['diaSemanaTer']=='accept')?',1':',0').(($_REQUEST['diaSemanaQua']=='accept')?',1':',0').(($_REQUEST['diaSemanaQui']=='accept')?',1':',0').(($_REQUEST['diaSemanaSeg']=='accept')?',1':',0').(($_REQUEST['diaSemanaSab']=='accept')?',1':',0'));
		//$this->debug->show($dados['diasemana']);
		$dados = array(
			'nome'				=> $_REQUEST['name'],
			'fk_plan'			=> $_REQUEST['plan'],
			'namepage'			=> $_REQUEST['namepage'],
			'url_friendly'		=> $this->limparString($_REQUEST['namepage']),
			'codigo'			=> $this->limparString($_REQUEST['codigo']),
			'especialidades'	=> rtrim(ltrim(((isset($_REQUEST['Manicure/Pedicure']))?'Manicure/Pedicure':'').((isset($_REQUEST['Cabeleireira(o)']))?',Cabeleireira(o)':'').((isset($_REQUEST['Serviços_residenciais']))?',Serviços_residenciais':'').((isset($_REQUEST['Encanador']))?',Encanador':'').((isset($_REQUEST['Psicóloga(o)']))?',Psicóloga(o)':'').((isset($_REQUEST['Terapeuta_Ocupacional']))?',Terapeuta_Ocupacional':'').((isset($_REQUEST['Coach']))?',Coach':'').((isset($_REQUEST['Entregas_Delivery']))?',Entregas_Delivery':'').((isset($_REQUEST['Médico_da_Família']))?',Médico_da_Família':'').((isset($_REQUEST['Enfermeira(o)']))?',Enfermeira':'').((isset($_REQUEST['Fotógrafo']))?',Fotógrafo':'').((isset($_REQUEST['Cuidador_de_Idosos']))?',Cuidador_de_Idosos':'').((isset($_REQUEST['Cuidador_de_Crianças']))?',Cuidador_de_Crianças':''),','),','),
			'hrinicio'			=> $_REQUEST['hrinicio_h'].':'.$_REQUEST['hrinicio_m'].':00',
			'qtdeatendimentos'	=> $_REQUEST['qtdeatendimentos'],
			'tempoconsulta'		=> $_REQUEST['tempoconsulta'],
			'intervalo'			=> $_REQUEST['intervalo'],
			'sexo'				=> $_REQUEST['sexo'],
			'tel1'				=> $_REQUEST['phone'],
			//'tel2'				=> $_REQUEST['phone2'],
			'email'				=> $_REQUEST['email'],
			'emailmd5'			=> md5($_REQUEST['email']),
			'rua'				=> $_REQUEST['adress'],
			'numero'			=> $_REQUEST['adressnumber'],
			'estado'			=> $_REQUEST['adressprovince'],
			'cidade'			=> $_REQUEST['adresscity'],
			'ativo'				=> '0',
			'imagem'			=> $_REQUEST['imgprofissional'],
			'description'		=> $_REQUEST['obs'],
		);
		$dados['especialidades']	= implode(",",$_REQUEST['tp_service']);
		$diaSem = '';
		if(in_array('diaSemanaDom', $_REQUEST['diaSemana'])){
			$diaSem .= '1';
		}else{
			$diaSem .= '0';
		}
		if(in_array('diaSemanaSeg', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		if(in_array('diaSemanaTer', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		if(in_array('diaSemanaQua', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		if(in_array('diaSemanaQui', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		if(in_array('diaSemanaSex', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		if(in_array('diaSemanaSab', $_REQUEST['diaSemana'])){
			$diaSem .= ',1';
		}else{
			$diaSem .= ',0';
		}
		$dados['diasemana']			= $diaSem;
		
		//trim((isset($_REQUEST['diaSemanaDom'])?'1':'0').(isset($_REQUEST['diaSemanaSeg'])?',1':',0').(isset($_REQUEST['diaSemanaTer'])?',1':',0').(isset($_REQUEST['diaSemanaQua'])?',1':',0').(isset($_REQUEST['diaSemanaQui'])?',1':',0').(isset($_REQUEST['diaSemanaSex'])?',1':',0').(isset($_REQUEST['diaSemanaSab'])?',1':',0'),',');
		//$dados['diasemana']		=  trim((isset($_REQUEST['diaSemanaDom'])?'1':'0').(isset($_REQUEST['diaSemanaSeg'])?',1':',0').(isset($_REQUEST['diaSemanaTer'])?',1':',0').(isset($_REQUEST['diaSemanaQua'])?',1':',0').(isset($_REQUEST['diaSemanaQui'])?',1':',0').(isset($_REQUEST['diaSemanaSex'])?',1':',0').(isset($_REQUEST['diaSemanaSab'])?',1':',0'),',');
		//$this->debug->show($dados);
		$this->Profissional_model->set($dados);
		$res = $this->Profissional_model->save($dados);
		if($res[0])
		{
			$data['erro']['status'] = TRUE;
			$data['erro']['msg'] 	= $data['erro']['msg'].'<br>Você receberá um e-mail de confirmação com um link de ativação de Cadastro. Clique nele e seu cadastro será ativado.<br>Dependendo de seu Plano você receberá neste email o Primeiro boleto para pagamento.<br>Obrigado por preferir o Armazém Coletivo.';
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] = 'Erro na gravação.';
		}	
		
		//=============== Enviar E-mail de verificação para o Parceiro ====================================
		$this->send_email($res[1]);//revisar o envio do email
		
		
		//=================================================================================================
		
		$param = array(
			'controller'		=>'Profissional',
			'function'			=>'form',
			'meta_title'		=>'Cadastro Profissional - Armazém Coletivo',
			'meta_url'			=>base_url('profissional/send')
			);
		$data['msg'] = $data['erro']['msg'];
		$this->load->view('header',$param);
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}
	
	public function reserva($id){
		$profissiona = $this->Profissional_model->staticGet($id);
		//$_REQUEST['client_name'];
		//$_REQUEST['diasemanaList'];
		//$_REQUEST['horario'];
		
		$pos = strpos($_REQUEST['client_name'], ' ');
		//$msgWhatsApp = 'Oi%20aqui%20é%20'.substr($_REQUEST['client_name'], 0,$pos).',%20fiz%20uma%reserva%20de%20horario%20no%20%2AArmazém%20Coletivo%2A';
		$dia_semana = $this->format_date->diaSemana($_REQUEST['diasemanaList']);
		$msgWhatsApp = urlencode('Olá, aqui é o '.substr($_REQUEST['client_name'], 0,$pos).'. Fiz uma reserva de seu serviço ('.$_REQUEST['especilidadesList'].') às '.$_REQUEST['horario'].' no dia '.$_REQUEST['diasemanaList'].' ('. $dia_semana[1].') Você tem este horário? Obrigado.');
		//$msgWhatsApp.= '%20%28No%20dia%20'.$_REQUEST['diasemanaList'].'%20no%20horario%20'.$_REQUEST['horario'].'%29%0D';
		
		$telProvider = str_replace(array('(',')',' '), array('','',''),$profissiona[0]['tel1']);
	    $redir_to = "https://wa.me/55$telProvider?text=".$msgWhatsApp;
		//$redir_to = "https://wa.me/55$telProvider";
		//$this->debug->show($redir_to);
	    //GRAVAR O CONTADOR PARA $redir_to EM BD OU txt conforme seu caso
	    header("Location: $redir_to");
	}
	
	public function send_email($id)
	{
		$profissional = $this->Profissional_model->staticGet($id);
		
		//$res = $this->Profissional_model->changeStatus($id,(($profissional[0]['ativo'])?'0':'1'));
		$novo=  $this->Profissional_model->staticGet($id);
		
		//===========================================================
		//$this->debug->show($product_photo);
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
				  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				  		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
				  		<title>Armazém Coletivo</title>
					</head>
					<body style="margin: 0; padding: 0;">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif;">
							<tr align="center">
								<td colspan="2" style="background-color: #fed03d;">
							  		<img src="https://www.armazemcoletivo.com.br/admin/public/images/config/logo.png" style="padding: 15px;"/>
							  	</td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #FFF;" height="3"></td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"></td>
						 	</tr>
						 	<tr>
							  	<td colspan="2">';
		$msg .= 					'<p>Olá '.$novo[0]['nome'].'<p><br>';
		$msg .= 					'<p><center><b>Bem vinda(o) ao Armazém Coletivo</b></center></p>
								   <p><center>Estamos muito felizes com a sua escolha de dar um passo adiante e usar o Armazém Coletivo como ferramenta para prestação de serviços.</center></p>
								   <p><center>Vamos te ajudar a enfrentar os novos desafios e para quaiquer dúvidas.</c enter></p>
							  	</td>
						 	</tr>
						 	<tr>
						  		<td colspan="2">
						  			<p><center>Abaixo são alguns dados que você usará para divulgar em suas redes sociais e para visualizar seus pedidos dentro do armazemcoletivo.com.br:</center></p>
						  		</td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"></td>
						 	</tr>
						 	<tr>
								<td colspan="2"><p><center><b>Links de Compartilhamento:</b></center></p></td>
						 	</tr>';
		$msg .= '		 	<tr>
								<td><p>Link de acesso:</p></td>
								<td><p>https://www.armazemcoletivo.com.br/'.$novo[0]['url_friendly'].'</p></td>
						 	</tr>		 	
						 	<tr>
								<td><p>Link para Compartilhamento no Whatsapp:</p></td>
								<td><p>https://api.whatsapp.com/send?phone=55'.str_replace(' ','',preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $profissional[0]['tel1'])).'</p></td>
						 	</tr>
						 	<tr>
								<td><p>Link para Compartilhamento no Facebook:</p></td>
								<td><p>https://api.whatsapp.com/send?text='.base_url($novo[0]['url_friendly']).'</p></td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"></td>
						 	</tr>
						 	<tr>
								<td><p>Código:</p></td>
								<td><p>'.$novo[0]['codigo'].'</p></td>
						 	</tr>
						 	<tr>
						 		<td><p>E-mail:</p></td>
						 		<td><p>'.$novo[0]['email'].'</p></td>
						 	</tr>
						 	<tr>
						 		<td><p>Telefone:</p></td>
						 		<td><p>'.$novo[0]['tel1'].'</p></td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: red;" height="3"></td>
						 	</tr>
						 	<tr>
								<td><p><b>URL de confirmação:</b></p></td>
								<td><p><a href="'.base_url('profissional/confirmaCadastro/'.md5($novo[0]['email'])).'">'.base_url('profissional/confirmaCadastro/'.md5($novo[0]['email'])).'</a></p></td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"></td>
						 	</tr>
						 	<tr>
						 		<td colspan="2" style=" margin-top: 10px; background-color: #FFFFFF;" height="3"></td>
						 	</tr>
						 	<tr>
								<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"><p><center>Este e-mail NÃO é automático, se você responder a gente vai ler, então se tiver alguma dúvida responda este e-mail ou mande um WhatsApp no número <a href="https://api.whatsapp.com/send?phone=5512997977951" style="color: #656565; text-decoration: none;"><b>+12 9 9797 7951</b></a></center></p></td>
						 	</tr>
						 	<tr>
								<td colspan="2">
									<p>
										<center>
											<a href="https://api.whatsapp.com/send?phone=5512997977951">
												<img src="https://www.armazemcoletivo.com.br/public/images/whatsapp_contato.gif">
											</a>
										</center>
									</p>
								</td>
						 	</tr>
						 	<tr>
								<td colspan="2">
									<p><center><b>Armazém Coletivo</b></center></p>
									<p><center>+55 (12)9 9668 4440</center></p>
									<p><center>contato@armazemcoletivo.com.br</center></p>
								</td>
						 	</tr>';
		$msg .= '		</table>
					</body>
				</html>';
		$params['to'] 			= $novo[0]['email'];
		$params['assunto']		= 'Bem Vinda(o) ao Armazém Coletivo!';
		//$params['cc']			= 'financeiro@armazemcoletivo.com.br';
		$msg = str_replace("%Array%", "", $msg);
		$params['msg']			= $msg;
	
		$returnEmail = $this->envia_email->enviar($params);
		//$this->debug->show($returnEmail);
		//===========================================================
			
	}

	public function confirmaCadastro($emailmd5){
		$profissional = $this->Profissional_model->staticGet('emailmd5',$emailmd5);
		$res = $this->Profissional_model->changeStatus($profissional[0]['id'],'1');
		$params['erro']['msg']			= 'Cadastro '.(($res[0])?'NÃO alterado. Contecte o suporte (12) 9 9724 9283.':'ATIVADO com sucesso').'.';
		$this->load->view('header',$params);
		$this->load->view('msg',$params);
		$this->load->view('footer');
	}
	
	public function carregaFoto(){
		$config['upload_path'] 		= SYS_IMAGE_PATH.'profissional';
		//$this->debug->show($config['upload_path']);
		$config['file_name'] 		= md5(date('Y-m-d H:i:s'));
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '2000';
		$config['max_height'] 		= '2000';
		$config['field'] 			= 'profissionalfile';
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		if(!is_dir($config['upload_path']))
		{
			mkdir($config['upload_path'], 0777, true);
		}
		if(!$this->upload->do_upload($config['field']))
		{
			$jsonReturn['msg']			= array(FALSE,$this->upload->display_errors());
		}
		else
		{
			$type = $this->image->get_type($_FILES['profissionalfile']['type']);
			$result = array('upload_data' => $this->upload->data());
			$dados = array(	'width'			=> '300',
							'height'		=> '300',
							'upload_path'	=> $config['upload_path'],
							'path'			=> $config['upload_path'].'/'.$config['file_name'].'.'.$type,
							'file_name'		=> $config['file_name'],
							'ext' 			=> '.'.$type,
							);
			//================================================
			//echo SYS_IMAGE_PATH.'profissional/'.$config['file_name'].'.jpg'.
			//$image = imagecreatefromjpeg(SYS_IMAGE_PATH.'profissional/'.$config['file_name'].'.jpg');
			$image 		= imagecreatefromstring(file_get_contents(SYS_IMAGE_PATH.'profissional/'.$config['file_name'].'.jpg'));
			$filename 	= SYS_IMAGE_PATH.'profissional/'.$config['file_name'].'_thumb.jpg';
			
			$thumb_width = 300;
			$thumb_height = 300;
			
			$width = imagesx($image);
			$height = imagesy($image);
			
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;
			
			if ( $original_aspect >= $thumb_aspect )
			{
			   // If image is wider than thumbnail (in aspect ratio sense)
			   $new_height = $thumb_height;
			   $new_width = $width / ($height / $thumb_height);
			}
			else
			{
			   // If the thumbnail is wider than the image
			   $new_width = $thumb_width;
			   $new_height = $height / ($width / $thumb_width);
			}
			
			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
			
			// Resize and crop
			imagecopyresampled($thumb,
			                   $image,
			                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
			                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
			                   0, 0,
			                   $new_width, $new_height,
			                   $width, $height);
			imagejpeg($thumb, $filename, 80);
			//================================================
			//$this->crop($dados);
			//$this->create_thumb($dados);
			//unlink($config['upload_path'].'/'.$config['file_name'].$dados['ext']);
			//unlink($config['upload_path'].'/'.$config['file_name'].'_cropped'.$dados['ext']);
			$jsonReturn['msg']			= $result;
			$jsonReturn['upload_path']	= SYS_FILE_URL.'profissional';
			$jsonReturn['file_name']	= $dados['file_name'].'_thumb';
			$jsonReturn['type']			= 'jpg';
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['nome'];
		$config['allowed_types'] 	= 'jpeg|png|jpg';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '855';
		$config['max_height'] 		= '250';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		if(!is_dir($dados['path']))
		{
			mkdir($dados['path'], 0777, true);
		}
		if(!$this->upload->do_upload($dados['field']))
		{
			$x = array(FALSE,$this->upload->display_errors());
		}
		else
		{
			$result = array('upload_data' => $this->upload->data());
			$x = array(TRUE,array_shift($result));
		}
		return $x;
	}
	
	public function cadastro(){
		
		//=======================================================
		$dadosPlan = array('tp_cliente'=>'S','tp_plan'=>'N','active'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>0,'main'=>'true');
		$data['planos']				= $this->Plan_model->getList($dadosPlan);
		//=======================================================
		
		$param = array(
			'controller'		=>'contactParceiro',
			'function'			=>'list',
			'meta_title'		=>'Cadastro Serviços - Armazém Coletivo',
			'meta_url'			=>base_url('contact/parceiroForm')
			);
		$this->load->view('header',$param);
		$this->load->view('profissional/form',$data);
		$this->load->view('footer');
	}
	
	private function limparString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return mb_strtolower(str_replace($what, $by, $string),'UTF-8');
	}

}