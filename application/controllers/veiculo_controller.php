<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class veiculo_controller extends CI_Controller
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
	{redirect('veiculo/form');}
	
	public function lista()
	{
		$res = $this->validaAcesso();
		if($res[0]==TRUE)
		{
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$params = array('controller'=>'veiculo');
			$data['menu'] = $this->menu->show_menu($params);
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>10,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPaginacao(10);
			$lista 					= $this->veiculo_model->listar($dados);
			$data['result'] 		= $lista;
			$this->load->view('veiculo/lista',$data);
			$this->load->view('footer');
		}
		else
		{
			redirect('main/');
		}
	}

	public function novo()
	{
		$res = $this->validaAcesso();
		if($res[0]==TRUE)
		{
			$params = array('controller'=>'veiculo');
			$data['menu'] = $this->menu->show_menu($params);
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$this->load->view('veiculo/form',$data);
		}
		else
		{
			redirect('main/');
		}
		$this->load->view('footer');
	}

	public function edita($id)
	{
		if($res[0]==TRUE)
		{
			$params = array('controller'=>'veiculo');
			$data['menu'] = $this->menu->show_menu($params);
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$res = $this->validaAcesso();
			$data['result'] 		= $this->veiculo_model->staticGet($id);
			$this->load->view('veiculo/form',$data);
		}
		else
		{
			$data['msg'] = $res[1];
			$this->load->view('veiculo/lista',$data);
		}
		$this->load->view('footer');
	}
	
	public function inclui()
	{
		$permissao = $this->validaAcesso();
		if($permissao[0])//se permissao concedida
		{
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$params = array('controller'=>'veiculo');
			$data['menu'] = $this->menu->show_menu($params);
			$dados = $_REQUEST;
			$this->veiculo_model->set($dados);
			$res = $this->veiculo_model->gravar();
			if($res[0]){
				if($_FILES['userfile']['name']!=''){
					//==== UPLOAD da IMAGEM ====
					$dados		= array('nome'	=> $res[1],
										'tipo'	=> $_FILES['userfile']['type'],
										'ext'	=> $this->get_file_extension($_FILES['userfile']['name']),
										'path'	=> SYS_FILE_PATH."veiculos".DIRECTORY_SEPARATOR);
					$res = $this->do_upload($dados);
					if($res[0]==TRUE){
						$_REQUEST['id']		= $dados['nome'];
						$_REQUEST['ext']	= $dados['ext'];
						$this->usuario_model->set($_REQUEST);
						$this->usuario_model->gravar();
						$data['erro']['msg'] 	= 'Registro Inserido/Alterado com alteração de Foto.';
						$data['erro']['status'] = true;
						$this->load->view('msg',$data);
					}
					else
					{
						$data['erro']['msg'] 	= 'Erro ao efetuar Upload da foto! <i>'.$res[1].'</i>';
						$data['erro']['status'] = false;
						$this->load->view('msg',$data);
					}
				}
				else
				{
					$data['erro']['msg'] 	= 'Registro Inserido/Alterado sem alteração da foto.';
					$data['erro']['status'] = true;
					$this->load->view('msg',$data);
				}
			}
			else
			{
				$data['erro']['msg'] 	= $res[1];
				$data['erro']['status'] = false;
				$this->load->view('msg',$data);
			}
		}
		else
		{
			$data['erro'] = $permissao[1];
			$data['erro']['status'] = false;
			$this->load->view('msg',$data);
		}
	}
	
	public function exclui($id)
	{
		$res = $this->veiculo_model->excluir($id);
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

	public function alteraStatus($id)
	{
		$veiculo = $this->veiculo_model->staticGet($id);
		if(count($veiculo)>0)
		{
			$res = $this->veiculo_model->alteraStatus($id,(($veiculo['ativo']=='Y')?'N':'Y'));
			$novo=  $this->veiculo_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo['ativo']=='Y')?'N':'Y';
				$jsonReturn['label']	= ($novo['ativo']=='Y')?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['ativo']	= ($novo['ativo']=='Y')?'N':'Y';
				$jsonReturn['label']	= ($novo['ativo']=='Y')?'Ativo':'Inativo';
				$jsonReturn['error']	= false;
			}
		}
		else
		{
			$jsonReturn['label']	= ($quizresposta['ativo']=='Y')?'Ativo':'Inativo';
			$jsonReturn['msg']		= 'Error! Item inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	public function download($id)
	{
		$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
		$data['arquivo'] = $this->veiculo_model->staticGet($id);
		$arquivo = $data['arquivo']['path'].$data['arquivo']['id'].$data['arquivo']['ext']; // caminho absoluto do arquivo
	   	if(isset($arquivo) && file_exists($arquivo)){
			header("Content-Type: ".$data['arquivo']['type']);
			header("Content-Length: ".filesize($arquivo));
			header("Content-Disposition: attachment; filename=".$this->veiculo_model->clearString($data['arquivo']['nome']).$data['arquivo']['ext']);
			readfile($arquivo);
			exit;
		}
		else {
			$this->load->view('header');
			$params = array('controller'=>'veiculo');
			$data['menu'] = $this->menu->show_menu($params);
			$data['msg'] = 'Arquivo não encontrado.';
			$this->load->view('msg',$data);
			$this->load->view('footer');
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
		$config['max_width'] 		= '150';
		$config['max_height'] 		= '100';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		if(!is_dir($dados['path']))
		{
			mkdir($dados['path'], 0777, true);
		}
		if(!$this->upload->do_upload())
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
	public function setPaginacao($maximo)
	{
		$config['base_url'] = base_url().'index.php/veiculo/form';
		$config['total_rows'] = count($this->veiculo_model->listar());
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
		if((!isset($_SESSION['imagebank']['user']['email']))or($_SESSION['imagebank']['user']['email']=='')or(!isset($_SESSION['imagebank']['user']['email'])))
		{
			return array(FALSE,"Usuário não logado.");
		}
		else
		{
			return array(TRUE);
		}
	}
//===========================================================================
	
}