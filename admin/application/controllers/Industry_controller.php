<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class industry_controller extends CI_Controller
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
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
	}
	
	public function index()
	{}
	

	public function form($id=null)
	{
		$this->load->view('header',$this->externalTranslates);
		$param = array('controller'=>'industry','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST					= $this->Industry_model->staticGet($id);
			else {
				
				$_REQUEST					= $this->Industry_model->getLastId($id);
				unset($_REQUEST[0]['id']);
				unset($_REQUEST[0]['name']);
			}
			//$this->debug->show($_REQUEST);
			$this->load->view('industry/form',$_REQUEST);
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
		$this->load->view('header',$this->externalTranslates);
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'industry','function'=>'list');
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Industry_model->getList($dados);
			$this->load->view('industry/list',$data);
		}
		else
		{
			redirect();
		}
		$this->load->view('footer');
	}
	
	public function save()
	{
		$params = array('controller'=>'industry','function'=>'');
		if($this->validaAcesso())//se permissao concedida
		{
			$this->Industry_model->set($_REQUEST);
			$res = $this->Industry_model->save($_REQUEST);
			if($res[0]){
				$data['erro']['msg']	= 'Grupo '.((isset($_REQUEST['id']))?'alterado':'incluído').' com sucesso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data;
				$this->getList();
			}
			else
			{
				$data['erro']['msg'] = 'Desculpe, erro na gravação.'.$res[1];
				$data['erro']['status'] = FALSE;
				$this->externalTranslates = $data;
				$this->getList();
			}
			if((isset($resLogo))and($resLogo==true))
				$_REQUEST['ext'] 	= $dados_logo['ext'];
		}
		else
		{
			$data['erro']['msg'] = 'Permissão Negada.';
			$data['erro']['status'] = false;
			$this->externalTranslates = $data;
			$this->getList();
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
		$industry = $this->Industry_model->staticGet($id);
		if(count($industry)>0)
		{
			$res = $this->Industry_model->changeStatus($id,(($industry['active'])?'0':'1'));
			$novo=  $this->Industry_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo['active'])?'0':'1';
				$jsonReturn['label']	= ($novo['active'])?'Activo':'Inactivo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo['active'])?'0':'1';
				$jsonReturn['label']	= ($novo['active'])?'Activo':'Inactivo';
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
		$res = $this->Industry_model->delete($id);
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
		$config['base_url'] = base_url('industry/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Industry_model->getList($dados));
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