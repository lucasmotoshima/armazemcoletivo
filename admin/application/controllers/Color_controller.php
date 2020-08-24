<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class color_controller extends CI_Controller
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
		$this->load->library('color');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->externalTranslates['session'] 		= $_SESSION;
	}
	
	public function index()
	{}
	

	public function form($id=null)
	{
		$this->load->view('header',$this->externalTranslates);
		$param = array('controller'=>'color','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST		= $this->Color_model->staticGet($id);
			$data['colorList']	= $this->color->getColorOptions(); // aqui estan las opciones de colores para cadastrar
			$this->load->view('color/form',$data);
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] 	= 'Desculpe. Permisión negada.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function getList()
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header',$this->externalTranslates);
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'color','function'=>'list');
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Color_model->getList($dados);
			$this->load->view('color/list',$data);
		}
		else
		{
			$data['erro']['status'] = false;
			$data['erro']['msg'] = 'Permisión negado!';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function getByCode($code)
	{
		$color			 		= $this->color->getByCode($code);
		$jsonReturn['code']		= $color['code'];
		$jsonReturn['hexa']		= $color['hexa'];
		$jsonReturn['name']		= $color['name'];
		$jsonReturn['erro']		= FALSE;
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function save()
	{
		$params = array('controller'=>'color','function'=>'');
		if($this->validaAcesso())//se permissao concedida
		{
			$this->Color_model->set($_REQUEST);
			$res = $this->Color_model->save($_REQUEST);
			if($res[0]){
				$data['erro']['msg']	= 'Cor '.((isset($_REQUEST['id']))?'alterado':'incluída').' com sucesso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data;
				$this->getList();
			}
			else
			{
				$data['erro']['msg'] = 'Erro. Código duplicado.';
				$data['erro']['status'] = FALSE;
				$this->externalTranslates = $data;
				$this->form();
			}
		}
		else
		{
			$data['erro']['msg'] = 'Permissão negada.';
			$data['erro']['status'] = false;
			$this->externalTranslates = $data;
			$this->getList();
		}
	}

	
	public function changeStatus($id)
	{
		$color = $this->Color_model->staticGet($id);
		if(count($color)>0)
		{
			$res = $this->Color_model->changeStatus($id,(($color['active'])?'0':'1'));
			$novo=  $this->Color_model->staticGet($id);
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
		$res = $this->Color_model->delete($id);
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
		$config['base_url'] = base_url('color/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Color_model->getList($dados));
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