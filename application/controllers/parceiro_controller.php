<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class parceiro_controller extends CI_Controller
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
		$this->load->library('clearstring');
		$this->load->library('ultimas_noticias');
		$this->load->library('quiz');
		//==== models =====
		$this->load->model('imagem_model', '', TRUE);
		$this->load->model('album_model', '', TRUE);
		$this->load->model('usuario_model', '', TRUE);
		$this->load->model('veiculo_model', '', TRUE);
		$this->load->model('solicitacao_model', '', TRUE);
		$this->load->model('noticia_model', '', TRUE);
		$this->load->model('quiz_model', '', TRUE);
		$this->load->model('quizresposta_model', '', TRUE);
		$this->load->model('quizrespostausuario_model', '', TRUE);
	}
	
	public function index()
	{
		$this->load->view('header');
		$params = array('controller'=>'parceiro');
		$data['menu'] = $this->menu->show_menu($params);
		$data['quiz']  			= $this->quiz_model->getLastQuiz();
		$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
		$data['album'] 			= $this->album_model->listar(array('ativo'=>'Y'));
		$this->load->view('parceiro/lista',$data);
		$this->load->view('footer');
	}
	

//===========================================================================
	private function validaAcesso()
	{
		if((!isset($_SESSION['imagebank']['user']['email']))or($_SESSION['imagebank']['user']['email']=='')or(!isset($_SESSION['imagebank']['user']['email'])))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}