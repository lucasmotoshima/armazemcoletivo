<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class photo_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('form');
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
		$this->load->library('my_upload');
		//==== models =====
		$this->load->model('user_model', '', TRUE);
	}
	
	public function index()
	{redirect('file/list');}
	
	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'photo','function'=>((isset($id))?'':'new'));
		$data['menu'] = $this->menu->show_menu($param);
		if($this->validaAcesso())
			$this->load->view('photo/form',$data);
		else
			redirect('main/');
		$this->load->view('footer');
	}

	public function save()
	{
		$params = array('controller'=>'photo','function'=>'new');
		$data['menu'] = $this->menu->show_menu($params);
		$this->load->view('header');
		$file_error = 'Arquivos con error: ';
		$file_sucess = 'Arquivos sin error: ';
		if($_FILES['file']['name'])
		{
			$file = $_FILES['file'];
			for ($i=0; $i < count($file['name']); $i++) {
				$_FILES['file']['tmp_name'] = $file['tmp_name'][$i]; 
				$_FILES['file']['name']		= $file['name'][$i];
				$_FILES['file']['type']    	= $file['type'][$i];
				$_FILES['file']['error']  	= $file['error'][$i];
				$_FILES['file']['size']    	= $file['size'][$i];
				//==== UPLOAD da IMAGEM ====
				$dados		= array('nome'	=> $file['name'][$i],
									'tipo'	=> $_FILES['file']['type'][$i],
									'ext'	=> $this->get_file_extension($_FILES['file']['name'][$i]),
									'path'	=> SYS_PRODUCT_PATH.'teste',
									'field' => 'file'
									);
				$res_upload = $this->do_upload($dados);
			}

			if($res_upload[0]==TRUE){
				$data['erro']['status'] = TRUE;
				$data['erro']['msg'] 	= 'Registro incluído con suceso!';
				$this->load->view('msg',$data);
			}
			else
			{
				$data['erro']['status'] = FALSE;
				$data['erro']['msg'] = 'Erro ao efectuar Upload do Arquivo!'.$res_upload[1];
				$this->load->view('photo/form',$data);
			}
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] = 'Error.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['nome'];
		$config['allowed_types'] 	= 'jpg';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;

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
	
	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
	function get_file_extension($file_name) {
		return '.'.substr(strrchr($file_name,'.'),1);
	}
//====================================================================
	public function setPagination($maximo)
	{
		$config['base_url'] = base_url().'file/getList';
		$config['total_rows'] = count($this->file_model->getList());
		$config['per_page'] = '10';
		$config['uri_segment']  = '3';
		$config['first_link'] = 'Primeiro';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	private function validaAcesso()
	{
		if(($_SESSION['adm_promotions']['user']['email']=='')or(!isset($_SESSION['adm_promotions']['user']['email'])))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
//===========================================================================
	
}