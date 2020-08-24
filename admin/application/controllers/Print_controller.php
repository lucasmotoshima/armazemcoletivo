<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class print_controller extends CI_Controller
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
		$this->load->model('print_model', '', TRUE);
		//==============================================
		$this->externalTranslates['msg'] 	= NULL;
		$this->externalTranslates['status']	= FALSE;
		$data['input_error']				= array();
	}
	
	public function index()
	{}
	

	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'print','function'=>((isset($id))?'':'new'));
		$data['menu'] = $this->menu->show_menu($param);
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST		= $this->print_model->staticGet($id);
			$this->load->view('print/form',$data);
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] 	= 'Desculpe. Permisión negada.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function getList($tipo=null)
	{
		$this->load->view('header');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'print','function'=>'list');
			$data['menu'] = $this->menu->show_menu($param);
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->print_model->getList($dados);
			$this->load->view('print/list',$data);
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
		$print			 		= $this->print->getByCode($code);
		$jsonReturn['code']		= $print['code'];
		$jsonReturn['hexa']		= $print['hexa'];
		$jsonReturn['name']		= $print['name'];
		$jsonReturn['erro']		= FALSE;
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function save()
	{
		$this->load->view('header');
		$params = array('controller'=>'print','function'=>'');
		$data['menu'] = $this->menu->show_menu($params);
		if($this->validaAcesso())//se permissao concedida
		{
			$isNum = $this->isNum($_REQUEST);
			if($isNum['status'])
			{
				$this->print_model->set($_REQUEST);
				$res = $this->print_model->save($_REQUEST);
				if($res[0]){
					$data['erro']['msg']	= 'Impresión '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
					$data['erro']['status']	= TRUE;
					$this->externalTranslates = $data['erro'];
					$this->load->view('msg',$data);
				}
				else
				{
					$data['erro']['msg'] = 'Error. Código duplicado.';
					$data['erro']['status'] = FALSE;
					$this->load->view('msg',$data);
				}
			}
			else
			{
				$data['erro']['msg']	= 'Desculpe, los campos destacadas no son numéricos.';
				$data['erro']['status']	= FALSE;
				$data['input_error'] = $isNum['campo_error'];				
				$this->load->view('print/form',$data);
			}
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
		$print = $this->print_model->staticGet($id);
		if(count($print)>0)
		{
			$res = $this->print_model->changeStatus($id,(($print['active'])?'0':'1'));
			$novo=  $this->print_model->staticGet($id);
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
		$res = $this->print_model->delete($id);
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
		if(($_SESSION['adm_promotions']['user']['email']=='')or(!isset($_SESSION['adm_promotions']['user']['email'])))
		{
			return array(FALSE,"Usuário não logado.");
		}
		else
		{
			return array(TRUE);
		}
	}
	
	private function isNum($campos=null)
	{
		$status = true;
		$campo_error = array();
		if(!is_numeric($campos['qty_limit'])){
			$status = false;
			array_push($campo_error,'qty_limit');
		}
		if(!is_numeric($campos['amount_limit'])){
			$status = false;
			array_push($campo_error,'amount_limit');
		}
		if(!is_numeric($campos['range1_end'])){
			$status = false;
			array_push($campo_error,'range1_end');
		}
		if(!is_numeric($campos['range1_price'])){
			$status = false;
			array_push($campo_error,'range1_price');
		}
		if(!is_numeric($campos['range2_end'])){
			$status = false;
			array_push($campo_error,'range2_end');
		}
		if(!is_numeric($campos['range2_price'])){
			$status = false;
			array_push($campo_error,'range2_price');
		}
		if(!is_numeric($campos['range3_end'])){
			$status = false;
			array_push($campo_error,'range3_end');
		}
		if(!is_numeric($campos['range3_price'])){
			$status = false;
			array_push($campo_error,'range3_price');
		}
		if(!is_numeric($campos['range4_end'])){
			$status = false;
			array_push($campo_error,'range4_end');
		}
		if(!is_numeric($campos['range5_price'])){
			$status = false;
			array_push($campo_error,'range5_price');
		}
		return array('status'=>$status,'campo_error'=>$campo_error);
	}
	
	
//===========================================================================
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('print/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->print_model->getList($dados));
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