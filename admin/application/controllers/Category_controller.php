<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class category_controller extends CI_Controller
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
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
	}
	
	public function index()
	{}
	

	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'category','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST		= $this->Category_model->staticGet($id);
			$this->load->view('category/form');
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] 	= 'Desculpe. Permisión negada.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function getList($inicio=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'category','function'=>'list');
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Category_model->getList($dados);
			$this->load->view('category/list',$data);
		}
		else
		{
			$data['erro']['status'] = false;
			$data['erro']['msg'] = 'Permisión negado!';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function save()
	{
		$this->load->view('header');
		$params = array('controller'=>'category','function'=>'');
		$permissao = $this->validaAcesso();
		if($permissao[0])//se permissao concedida
		{
			$this->Category_model->set($_REQUEST);
			$res = $this->Category_model->save($_REQUEST);
			if($res[0]){
				if(isset($_FILES['categoryfile']['type'])and($_FILES['categoryfile']['type']!=''))
				{
					$dados_logo		= array(
										'nome'	=> $res[1],
										'tipo'	=> $_FILES['categoryfile']['type'],
										'ext'	=> $this->get_file_extension($_FILES['categoryfile']['name']),
										'path'	=> SYS_IMAGE_PATH."category".DIRECTORY_SEPARATOR,
										'field' => 'categoryfile');
					$resLogo = $this->do_upload($dados_logo);
					$_REQUEST['id']		= $dados_logo['nome'];
					$_REQUEST['ext']	= $dados_logo['ext'];
					$this->Category_model->set($_REQUEST);
					$this->Category_model->save();
				}
				$data['erro']['msg']	= 'Categoria '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data['erro'];
				$this->load->view('msg',$data);
			}
			else
				{
					$data['erro']['msg'] = 'Desculpe, error en la grabación.'.$res[1];
					$data['erro']['status'] = FALSE;
					$this->load->view('msg',$data);
				}
			
			if((isset($resLogo))and($resLogo==true))
				$_REQUEST['ext'] 	= $dados_logo['ext'];
				
		}
		else
		{
			$data['erro']['msg'] = 'Permisión negada.';
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
		$config['max_width'] 		= '35';
		$config['max_height'] 		= '35';
		
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
		$category = $this->Category_model->staticGet($id);
		if(count($category)>0)
		{
			$res = $this->Category_model->changeStatus($id,(($category[0]['active'])?'0':'1'));
			$novo=  $this->Category_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo[0]['active'])?'0':'1';
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
		$res = $this->category_model->delete($id);
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
		if(($_SESSION['adm_armazem']['user']['email']=='')or(!isset($_SESSION['adm_armazem']['user']['email'])))
		{
			return array(FALSE,"Usuário não logado.");
		}
		else
		{
			return array(TRUE);
		}
	}
//===========================================================================
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('category/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Category_model->getList($dados));
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