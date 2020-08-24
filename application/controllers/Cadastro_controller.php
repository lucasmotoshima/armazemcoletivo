<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cadastro_controller extends CI_Controller
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
	}
	
	
	public function index($msg=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 						= $this->Industry_model->getList();
		$data['rubros']					= $industry;
		$data['controller'] 			= 'main';
		//$this->load->view('header',$data);
		$inicio 						= (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
		$dados 							= array('active'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>$inicio,'main'=>'true');
		if(isset($_SESSION['armazem']['user']['localidade'])){
			$dados['localidade'] 		= $_SESSION['armazem']['user']['localidade'];
		}
		$products 						= $this->Product_model->getList($dados);
		if(empty($products)){
			unset($dados['localidade']);
			$products 						= $this->Product_model->getList($dados);
		}
		if(empty($products)){
			$dados['uf']					= $_SESSION['armazem']['user']['uf'];
			$products 						= $this->Product_model->getList($dados);
		}
		$productList 					= array();
		foreach ($products as $x => $value) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$x = ($value['code_origin'].'_1');
			//$photo	= $this->get_photo($x,208,115);
			$photo  = $this->image->resize($x,155,255);
			$productList[$x] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		$data['result']			= $productList;
		//$this->load->view('main2',$data);
		$this->load->view('main2',$data);
		//$this->load->view('footer');
	}

	public function tipocliente(){//Choose a typo of member who u are. (Produtor ou Profissional Liberal)
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$params = array(
			'controller'		=>'Cadastro',
			'function'			=>'setp1',
			'meta_title'		=>'Cadastro - Armazém Coletivo',
			'meta_description'	=>'Faça seu cadastro no Armazém Coletivo e tenha um Cardápio Online para vender muito mais em suas redes sociais.',
			'meta_url'			=>base_url('cart/getPedidos')
			);
		$this->load->view('header',$params);
		//================================================
		$this->load->view('cadastro/step1');
		//================================================
		$this->load->view('footer');
	}

	public function step2($tipo=null){
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$params = array(
			'controller'		=> 'Cadastro',
			'function'			=> 'setp2',
			'meta_title'		=> 'Cadastro - Armazém Coletivo',
			'meta_description'	=> 'Faça seu cadastro no Armazém Coletivo e tenha um Cardápio Online para vender muito mais em suas redes sociais.',
			'meta_url'			=> base_url('cart/getPedidos')
			);
		$this->load->view('header',$params);

		if($tipo!=null){
			$this->load->view('cadastro/step1',$data);
		}else{
			$data['msg']		= "Selecione qual se você é <u>Prestador</u> de <u>Serviços ou Produtor</u>.";
			$this->load->view($data);
		}

		$this->load->view('footer');
	}


}