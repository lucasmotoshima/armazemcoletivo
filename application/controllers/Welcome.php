<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		echo 'sadasdasd';die();
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('head');
		//==== librarys =====
        $this->load->library('debug');
		$this->load->library('navbar');
		//==== models =====
		//$this->load->model('Funcionario_model', '', TRUE);
	}
	public function index()
	{
		echo 'sadasdasd';die();
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}
}