<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
		$this->load->library('head');
		$this->load->library('debug');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
	}
	public function index()
	{
		if(!$this->User_model->checkLogin())
		{
			$this->load->view('login');
		}
		else
		{
			$this->_checkPermission();
		}
	}

	public function doLogin()
	{
		$data = $_REQUEST;
		//$this->debug->show($_REQUEST);
		$pf = new user_model();
		if(isset($data['email']) && isset($data['password']))
		{
			$pf->email 			 = $data['email'];
			$pf->password   	 = md5($data['password']);
		}
		if($pf->doLogin())
		{
			$this->_checkPermission();
		}
		else
		{
			$data['msg'] = 'Email o Clave inválidos!';
			$this->load->view('login',$data);
		}
	}


	private function _checkPermission()
	{
		redirect('user/getList');
	}

	public function logout()
	{
		session_destroy(); //pei!!! destruimos a sessão ;)
		session_unset(); //limpamos as variaveis globais das sessões
		unset($_SESSION['adm_armazem']['user']['id']);
		unset($_SESSION['adm_armazem']['user']['name']);
		unset($_SESSION['adm_armazem']['user']['email']);
		unset($_SESSION['adm_armazem']['user']['password']);
		unset($_SESSION['adm_armazem']['user']['type']);
		redirect();
	}
	
//===========================================================================

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */