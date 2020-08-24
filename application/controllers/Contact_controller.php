<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_controller extends CI_Controller
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
		$this->load->library('prod_cost');
		$this->load->library('email');
		$this->load->library('image');
		//==== models =====
		$this->load->model('user_model', '', TRUE);
		$this->load->model('config_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('provider_model', '', TRUE);
		$this->load->model('category_model', '', TRUE);
		$this->load->model('print_model', '', TRUE);
		$this->load->model('color_model', '', TRUE);
		$this->load->model('industry_model', '', TRUE);
		$this->load->model('product_color_model', '', TRUE);
		$this->load->model('product_print_model', '', TRUE);
		$this->load->model('cart_model', '', TRUE);
		$this->load->model('cart_product_model', '', TRUE);
		$this->load->model('cart_product_m_model', '', TRUE);
		$this->load->model('Cidade_model', '', TRUE);
		$this->load->model('Lead_model', '', TRUE);
	}
	
	public function index()
	{redirect();}
	
	public function faq()
	{
		$industry 						= $this->industry_model->getList();
		$data['rubros']					= $industry;
		$param = array(
			'controller'		=>'faq',
			'function'			=>'list',
			'meta_title'		=>'Perguntas Frequentes - Armazém Coletivo',
			'meta_url'			=>base_url('contact/faq')
			);
		$data['category']		= $this->category_model->getList(array('active'=>'1'));
		
		$this->load->view('header',$param);
		$this->load->view('contact/faq',$data);
		$this->load->view('footer');
	}
	
	public function form()
	{
		$industry 						= $this->industry_model->getList();
		$data['rubros']					= $industry;
		$param = array(
			'controller'		=>'contact',
			'function'			=>'list',
			'meta_title'		=>'SAC - Armazém Coletivo',
			'meta_url'			=>base_url('contact/form')
			);
		$data['category']		= $this->category_model->getList(array('active'=>'1'));
		$this->load->view('header',$param);
		$this->load->view('contact/form',$data);
		$this->load->view('footer');
	}
	
	public function parceiroForm(){
		$param = array(
			'controller'		=>'contactParceiro',
			'function'			=>'list',
			'meta_title'		=>'Cadastro Serviços - Armazém Coletivo',
			'meta_url'			=>base_url('contact/parceiroForm')
			);
		$this->load->view('header',$param);
		$this->load->view('contact/parceiroForm');
		$this->load->view('footer');
	}
	
	public function getCityListJson()
	{
		$dados 						= array('uf' => '##');
		if(isset($_REQUEST['uf'])){
			$dados 					= array('uf' => $_REQUEST['uf']);
		}
		$cidadeList 				= $this->Cidade_model->getList($dados);
		$cont						= count($cidadeList);
		$jsonReturn['options']		= '<option value="X">[X] ...escolha uma cidade...</option>';
		foreach ($cidadeList as $key => $value) {
			$jsonReturn['options']		.= '<option value="'.$cidadeList[$key]['id'].'">'.$cidadeList[$key]['nome'].'- '.$cidadeList[$key]['uf'].'</option>';
		}
		$jsonReturn['error']			= false;
		$jsonReturn['msg'] 				= $cont.' Cidade(s) encontrada(s).';
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function purpose(){
		$params = array(
			'controller'	=>'porpose',
			'function'		=>'list',
			'meta_title'	=>'Nosso Propósito - Armazém Coletivo',
			'meta_url'		=>base_url('contact/purpose')
			);
		$this->load->view('header',$params);
		$this->load->view('purpose');
		$this->load->view('footer');
	}
	
	public function send(){
		//$this->debug->show($_REQUEST);
		$this->load->view('header',$data);
		//tenta enviar o email para o usuario
		$params['email'] 		= 'contato@armazemcoletivo.com.br';
		$params['assunto']		= 'Contato via Site';
		$params['nome']			= $_REQUEST['client_name'];
		$msg = '<strong> Nome: </strong>'.$_REQUEST['client_name'].'<br>';
		$msg .= '<strong> Telefone: </strong>'.$_REQUEST['phone'].'<br>';
		$msg .= '<strong> Email: </strong>'.$_REQUEST['email'].'<br>';
		$msg .= '<strong> Mensagem: </strong>'.$_REQUEST['obs'].'<br>';
		$msg .= date("d-m-Y H:i:s").'<br>';
		$params['msg']			= $msg;
		$enviar = $this->envia_email->enviar($params);
		if($enviar['status'])
			$data['erro']['msg'] = 'Mensagem enviada com sucesso!';
		else
			$data['erro']['msg'] = 'Erro ao enviar mensagem!';
		//$this->debug->show($data);
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}
	
	public function sendLead(){
		$this->load->view('header');
		$externalTranslates = array();
		$this->Lead_model->set($_REQUEST);
		$res = $this->Lead_model->save($_REQUEST);
		$data['erro']['msg'] = 'Obrigado por enviar sua mensagem. Em breve entraremos em contato.';
		$this->load->view('msg',$data);
		$this->load->view('footer');

	}

	public function success(){
		$industry 						= $this->industry_model->getList();
		$data['rubros']					= $industry;
		$this->load->view('header',$data);
		$data['erro']['msg'] = 'Obrigado por enviar sua mensagem. Em breve entraremos em contato.';
		$this->debug->show($data);
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}
}