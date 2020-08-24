<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Provider_controller extends CI_Controller
{
	var $externalTranslates = array();
	public function __construct()
	{
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('form');
		$this->load->helper('email');
		//==== librarys =====
		$this->load->library('upload');
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('pagination');
		$this->load->library('menu');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		$this->load->library('image');
		$this->load->library('image_lib');
		//==== models =====
		$this->load->model('user_model', '', TRUE);
		$this->load->model('config_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Plan_model', '', TRUE);
		$this->load->model('Provider_plan_model', '', TRUE);
	}
	
	public function index()
	{}
	

	public function form($id=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$param = array('controller'=>'provider','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			$params 								= array('active'=>'1');
			$data['plansList']						= $this->Plan_model->getList($params);
			if(isset($id)){
				$data['provider']					= $this->Provider_model->staticGet($id);
				$dados 								= array('fk_provider' => $id);
				$data['provider']['providerPlan']	= $this->Provider_plan_model->getList($dados);
				$data['plan']						= ((isset($data['provider']['providerPlan'][0]))?$this->Plan_model->staticGet($data['provider']['providerPlan'][0]['fk_plan']):'');
			}
			//$this->debug->show($data['plan']);
			$this->load->view('header');
			$this->load->view('provider/form',isset($data)?$data:'');
			$this->load->view('footer');
		}
		else
		{redirect();}
	}
	
	public function getList($tipo=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'provider','function'=>'list');
			$inicio = (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Provider_model->getList($dados);
			$externalTranslates		= '';
			$this->load->view('header',$externalTranslates);
			$this->load->view('provider/list',$data);
			$this->load->view('footer');
		}
		else
		{redirect();}
	}
	
	public function save()
	{
		$externalTranslates = array();
		$params = array('controller'=>'provider','function'=>'');
		$permissao = $this->validaAcesso();
		if($permissao)//se permissao concedida
		{
			$diasSemanas = array(
				'0' => (isset($_REQUEST['diaSemanaDom']))?'1':'0',
				'1' => (isset($_REQUEST['diaSemanaSeg']))?'1':'0',
				'2' => (isset($_REQUEST['diaSemanaTer']))?'1':'0',
				'3' => (isset($_REQUEST['diaSemanaQua']))?'1':'0',
				'4' => (isset($_REQUEST['diaSemanaQui']))?'1':'0', 
				'5' => (isset($_REQUEST['diaSemanaSex']))?'1':'0',
				'6' => (isset($_REQUEST['diaSemanaSab']))?'1':'0'
				);
			$diaSemana			= implode(',',$diasSemanas);
			$_REQUEST['dia_entrega'] = $diaSemana;
			
			$this->Provider_model->set($_REQUEST);
			$res = $this->Provider_model->save($_REQUEST);
			if($res[0]){
				if(isset($_FILES['providerfile']['type'])and($_FILES['providerfile']['type']!=''))
				{
					$dados_logo		= array(
										'nome'	=> $res[1],
										'tipo'	=> $_FILES['providerfile']['type'],
										'ext'	=> $this->get_file_extension($_FILES['providerfile']['name']),
										'path'	=> SYS_IMAGE_PATH."provider".DIRECTORY_SEPARATOR,
										'field' => 'providerfile');
					$resLogo = $this->do_upload($dados_logo);
					$_REQUEST['id']		= $dados_logo['nome'];
					$_REQUEST['ext']	= $dados_logo['ext'];
					
					$this->Provider_model->set($_REQUEST);
					$this->Provider_model->save($_REQUEST);
				}
				$data['erro']['msg']	= 'Provedor '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data;
			}
			else
			{
				$data['erro']['msg'] = 'Desculpe, error en la grabación.'.$res[1];
				$data['erro']['status'] = FALSE;
			}
			if((isset($resLogo))and($resLogo==true))
				$_REQUEST['ext'] 	= $dados_logo['ext'];
			$this->getList();
		}
		else
		{redirect();}
	}

	public function carregaFoto(){
		$config['upload_path'] 		= SYS_IMAGE_PATH.'provider';
		//$this->debug->show($config['upload_path']);
		$config['file_name'] 		= md5(date('Y-m-d H:i:s'));
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '1500';
		$config['max_height'] 		= '1500';
		$config['field'] 			= 'providerfile';
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
			$type = $this->image->get_type($_FILES['providerfile']['type']);
			$result = array('upload_data' => $this->upload->data());
			$dados = array(	'width'			=> '500',
							'height'		=> '260',
							'upload_path'	=> $config['upload_path'],
							'path'			=> $config['upload_path'].'/'.$config['file_name'].'.'.$type,
							'file_name'		=> $config['file_name'],
							'ext' 			=> '.'.$type,
							);
			//$this->crop($dados);
			//$this->create_thumb($dados);
			//unlink($config['upload_path'].'/'.$config['file_name'].$dados['ext']);
			//unlink($config['upload_path'].'/'.$config['file_name'].'_cropped'.$dados['ext']);
			$jsonReturn['msg']			= $result;
			$jsonReturn['upload_path']	= SYS_FILE_URL.'provider';
			$jsonReturn['file_name']	= $dados['file_name'];
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
	
	public function changeStatus($id,$boasvindas)
	{
		$provider = $this->Provider_model->staticGet($id);
		if(count($provider)>0)
		{
			$res = $this->Provider_model->changeStatus($id,(($provider[0]['active'])?'0':'1'));
			$novo=  $this->Provider_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['active']	= ($novo[0]['active'])?'0':'1';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo[0]['active'])?'0':'1';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
				$jsonReturn['error']	= false;
			}
			
			if($novo[0]['active']=='1'){
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
				$msg .= 					'<p>Olá '.$novo[0]['name_contact'].'<p><br>';
				$msg .= 					'<p><center><b>Bem vinda(o) ao Armazém Coletivo</b></center></p>
										   <p><center>Estamos muito felizes com a sua escolha de dar um passo adiante e vender na internet.</center></p>
										   <p><center>Vamos te ajudar a enfrentar os novos desafios e para quaiquer dúvidas.</center></p>
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
										<td><p>https://api.whatsapp.com/send?phone=55'.str_replace(' ','',preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $provider[0]['phone1'])).'</p></td>
								 	</tr>
								 	<tr>
										<td><p>Link para Compartilhamento no Facebook:</p></td>
										<td><p>https://api.whatsapp.com/send?text='.base_url($novo[0]['url_friendly']).'</p></td>
								 	</tr>
								 	<tr>
								 		<td colspan="2" style=" margin-top: 10px; background-color: #CCCCCC;" height="3"></td>
								 	</tr>
								 	<tr>
										<td colspan="2"><p><center><b>Código de acesso aos Pedidos:</b></center></p></td>
								 	</tr>
								 	<tr>
										<td><p>Link:</p></td>
										<td><p><a href="https://www.armazemcoletivo.com.br/cart/getPedidos">https://www.armazemcoletivo.com.br/cart/getPedidos</p></a></td>
								 	</tr>
								 	<tr>
										<td><p>Código:</p></td>
										<td><p>'.$novo[0]['code'].'</p></td>
								 	</tr>
								 	<tr>
								 		<td><p>E-mail:</p></td>
								 		<td><p>'.$novo[0]['email'].'</p></td>
								 	</tr>
								 	<tr>
								 		<td><p>Telefone:</p></td>
								 		<td><p>'.$novo[0]['phone1'].'</p></td>
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
											<p><center>tecnologia@armazemcoletivo.com.br</center></p>
										</td>
								 	</tr>';
				$msg .= '		</table>
							</body>
						</html>';
				$params['to'] 			= $novo[0]['email'];
				$params['assunto']		= 'Bem Vinda(o) ao Armazém Coletivo!';
				$params['cc']			= 'financeiro@armazemcoletivo.com.br';
				$msg = str_replace("%Array%", "", $msg);
				$params['msg']			= $msg;
			
				if($boasvindas=='1'){
					$this->envia_email->enviar($params);
				}
				//===========================================================
			}
			
		}
		else
		{
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function delete($id)
	{
		$res = $this->Provider_model->delete($id);
		if($res[0])
		{
			$data['msg'] = $res[1];
			$data['erro'] = FALSE;
		}
		else
		{
			$data['msg'] = $res[1];
			$data['erro'] = TRUE;
		}
		header('Content-Type: application/json');
		print json_encode($data);
	}
	
	public function crop($dados){
		$new = imagecreatefromjpeg($dados['path']);
	    $crop_width = imagesx($new);
	    $crop_height = imagesy($new);
        $size = min($crop_width, $crop_height);
        if($crop_width >= $crop_height) {
       	 	$newx= ($crop_width-$crop_height)/2;
       	 	$dimensoes = array(
	        	'x'			=> $newx,
				'y'			=> 0,
				'width' 	=> $size,
				'height'	=> $size
			);
        	$im2 = imagecrop($new, $dimensoes);
        }
        else {
            $newy= ($crop_height-$crop_width)/2;
            $im2 = imagecrop($new, $dimensoes);
       	}
		$novonome = $dados['upload_path'].'/'.$dados['file_name'].'_cropped'.$dados['ext'];
	    imagejpeg($im2, $novonome,90);
	}

	public function create_thumb($dados)
	{
		$config_thumb['image_library'] 	= 'gd2';
		$config_thumb['source_image'] 	= $dados['upload_path'].'/'.$dados['file_name'].'_cropped'.$dados['ext'];
		$config_thumb['new_image'] 		= $dados['upload_path'].'/'.$dados['file_name'].'.jpg';
		$config_thumb['create_thumb'] 	= TRUE;
		$config_thumb['maintain_ratio'] = TRUE;
		$config_thumb['width'] 			= $dados['width'];
		$config_thumb['height'] 		= $dados['height'];
		$this->image_lib->initialize($config_thumb);
		if ( ! $this->image_lib->resize())
			echo $this->image_lib->display_errors();
	}
	
	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
	function get_file_extension($file_name) {
		return '.'.substr(strrchr($file_name,'.'),1);
	}
	
	private function validaAcesso()
	{
		if(!isset($_SESSION['adm_armazem']['user']['email']))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
//===========================================================================
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('provider/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Provider_model->getList($dados));
		$config['per_page'] = '20';
		$config['uri_segment']  = '3';
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}