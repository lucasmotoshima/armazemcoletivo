<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profissional_controller extends CI_Controller
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
		//==== models =====
		$this->load->model('user_model', '', TRUE);
		$this->load->model('config_model', '', TRUE);
		$this->load->model('profissional_model', '', TRUE);
	}
	
	public function index($id)
	{}
	
	public function ref($id)
	{
		$this->debug->show($id);
		if(is_numeric($id)){
			$_REQUEST		= $this->Profissional_model->staticGet($id);
		}
		else{
			$_REQUEST		= $this->Profissional_model->staticGet('url_friendly',$id);
		}
		
	}

	public function sendMessage(){
		$_REQUEST;
	}

	public function form(){
		$param = array(
			'controller'		=>'profissional',
			'function'			=>'form',
			'meta_title'		=>'Cadastro Serviços - Armazém Coletivo',
			'meta_url'			=>base_url('profissional/form')
			);
		$this->load->view('header',$param);
		$this->load->view('profissional/form');
		$this->load->view('footer');
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
			$data['result'] 		= $this->Profissional_model->getList($dados);
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
			$this->Profissional_model->set($_REQUEST);
			$res = $this->Profissional_model->save($_REQUEST);
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
					$this->Profissional_model->set($_REQUEST);
					$this->Profissional_model->save($_REQUEST);
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

	
	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['nome'];
		$config['allowed_types'] 	= 'jpeg|png|jpg|gif';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '200';
		$config['max_height'] 		= '150';
		
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
	
	public function changeStatus($id)
	{
		$provider = $this->Profissional_model->staticGet($id);
		if(count($provider)>0)
		{
			$res = $this->Profissional_model->changeStatus($id,(($provider[0]['active'])?'0':'1'));
			$novo=  $this->Profissional_model->staticGet($id);
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
		$res = $this->Profissional_model->delete($id);
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
		$config['total_rows'] = count($this->Profissional_model->getList($dados));
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