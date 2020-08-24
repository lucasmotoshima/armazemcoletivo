<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class config_controller extends CI_Controller
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
	}
	
	public function index()
	{}
	

	public function form()
	{
		$params = array('controller'=>'config','function'=>'edit');
		$data['menu'] = $this->menu->show_menu($params);
		$this->load->view('header');
		$_REQUEST	 		= $this->config_model->staticGet();
		$this->load->view('config/form',$data);
		$this->load->view('footer');
	}
	
	public function save()
	{
		$this->load->view('header');
		$params = array('controller'=>'veiculo');
		$data['menu'] = $this->menu->show_menu($params);
		$permissao = $this->validaAcesso();
		if($permissao[0])//se permissao concedida
		{
			$isNum = $this->isNum($_REQUEST);
			if($isNum['status'])
			{
				if(isset($_FILES['logofile']['type'])and($_FILES['logofile']['type']!=''))
				{
					$dados_logo		= array('nome'	=> 'logo',
										'tipo'	=> $_FILES['logofile']['type'],
										'ext'	=> $this->get_file_extension($_FILES['logofile']['name']),
										'path'	=> SYS_IMAGE_PATH."config".DIRECTORY_SEPARATOR,
										'tipo'	=> 'logo',
										'field' => 'logofile');
					$resLogo = $this->do_upload($dados_logo);
				}
				
				if(isset($_FILES['bgfile']['type'])and($_FILES['bgfile']['type']!=''))
				{
					$dados_bg		= array('nome'	=> 'bg',
										'tipo'	=> $_FILES['bgfile']['type'],
										'ext'	=> $this->get_file_extension($_FILES['bgfile']['name']),
										'path'	=> SYS_IMAGE_PATH."config".DIRECTORY_SEPARATOR,
										'tipo'	=> 'bg',
										'field' => 'bgfile');
					$resBg = $this->do_upload($dados_bg);
				}
				
				if((isset($resLogo))and($resLogo==true))
					$_REQUEST['logo_ext'] 	= $dados_logo['ext'];
				if((isset($resBg))and($resBg==true))
					$_REQUEST['bg_ext'] 	= $dados_bg['ext'];
					
				$this->config_model->set($_REQUEST);
				$res = $this->config_model->save($_REQUEST);
				if($res){
					$data['erro']['msg'] 	= 'Arquivo de Configuração alterado com sucesso.';
					$data['erro']['status'] = TRUE;
					$this->load->view('msg',$data);
				}
				else
				{
					$data['erro']['msg'] = 'Desculpe, ocorreu um erro ao gravar registro.'.$res[1];
					$data['erro']['status'] = FALSE;
					$this->load->view('msg',$data);
				}
			}
			else
			{
				$data['erro']['msg']	= 'Desculpe, los campos destacadas no son numéricos.';
				$data['erro']['status']	= FALSE;
				$data['input_error'] = $isNum['campo_error'];				
				$this->load->view('config/form',$data);
			}
		}
		else
		{
			$data['erro']['msg'] = 'Permissão negada.';
			$data['erro']['status'] = false;
			$this->load->view('msg',$data);
		}
	}

	
	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['nome'];
		$config['allowed_types'] 	= 'jpeg|png|jpg|gif';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		if($dados['tipo']=='logo')
		{
			$config['max_width'] 		= '250';
			$config['max_height'] 		= '50';
		}
		if($dados['tipo']=='bg')
		{
			$config['max_width'] 		= '9000000';
			$config['max_height'] 		= '9000000';
		}
		
		if($dados['tipo']=='mask')
		{
			$config['max_width'] 		= '240';
			$config['max_height'] 		= '160';
		}
		if($dados['tipo']=='mask_p')
		{
			$config['max_width'] 		= '100';
			$config['max_height'] 		= '100';
		}

		
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

	private function isNum($campos=null)
	{
		$status = true;
		$campo_error = array();
		if(!is_numeric($campos['tax'])){
			$status = false;
			array_push($campo_error,'tax');
		}
		
		if(!is_numeric($campos['range1_ini'])){
			$status = false;
			array_push($campo_error,'range1_ini');
		}
		if(!is_numeric($campos['range1_fin'])){
			$status = false;
			array_push($campo_error,'range1_fin');
		}
		if(!is_numeric($campos['range1'])){
			$status = false;
			array_push($campo_error,'range1');
		}
		
		if(!is_numeric($campos['range2_ini'])){
			$status = false;
			array_push($campo_error,'range2_ini');
		}
		if(!is_numeric($campos['range2_fin'])){
			$status = false;
			array_push($campo_error,'range2_fin');
		}
		if(!is_numeric($campos['range2'])){
			$status = false;
			array_push($campo_error,'range2');
		}

		if(!is_numeric($campos['range3_ini'])){
			$status = false;
			array_push($campo_error,'range3_ini');
		}
		if(!is_numeric($campos['range3_fin'])){
			$status = false;
			array_push($campo_error,'range3_fin');
		}
		if(!is_numeric($campos['range3'])){
			$status = false;
			array_push($campo_error,'range3');
		}
	
		if(!is_numeric($campos['range4_ini'])){
			$status = false;
			array_push($campo_error,'range4_ini');
		}
		if(!is_numeric($campos['range4'])){
			$status = false;
			array_push($campo_error,'range4');
		}
		return array('status'=>$status,'campo_error'=>$campo_error);
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
		if(($_SESSION['adm_promotions']['user']['email']=='')or(!isset($_SESSION['adm_promotions']['user']['email'])))
		{
			return array(FALSE,"Usuário não logado.");
		}
		else
		{
			return array(TRUE);
		}
	}
//===========================================================================
	
}