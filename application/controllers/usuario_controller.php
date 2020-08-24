<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class usuario_controller extends CI_Controller
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
		if($res[0]==TRUE)
		{
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			if($this->validaAcesso())//se permissao concedida
			{
				$this->load->view('login');
			}
			else
			{
				$data['msg'] = $permissao;
				$this->load->view('msg',$data);
			}
			$this->load->view('footer');
		}
		else
		{redirect();}
	}
	

	public function edita()
	{
		if($this->validaAcesso())
		{
			$id = $_SESSION['imagebank']['user']['id'];
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$params = array('controller'=>'usuario');
			$data['menu'] = $this->menu->show_menu($params);
			$data['quiz']  			= $this->quiz_model->getLastQuiz();
			$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
			$this->load->view('imagem/busca',$data);
			if($this->validaAcesso())
			{
				$data['result'] 							= $this->usuario_model->staticGet($id);
				$data['veiculo'] 							= $this->veiculo_model->listar(array('ativo'=>'Y'));
				$data['tpveiculo'] 							= $this->tpveiculo_model->listar();
				$this->load->view('usuario/form',$data);
			}
			else
			{
				$data['erro']['status'] = FALSE;
				$data['erro']['msg'] 	= 'Desculpe. Você nao tem permissão para esta operação.';
				$this->load->view('msg',$data);
			}
			$this->load->view('footer');
		}
		else
		{redirect();}

	}

	public function novo()
	{
		$this->load->view('header');
		$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
		$params = array('controller'=>'usuario');
		$data['menu'] = $this->menu->show_menu($params);
		$data['quiz']  			= $this->quiz_model->getLastQuiz();
		$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
		$data['veiculo'] 		= $this->veiculo_model->listar();
		$data['tpveiculo'] 		= $this->tpveiculo_model->listar();
		$configuration 			= $this->config_model->staticGet(); 
		$data['limitedownload']	= $configuration['limitedownload'];
		$this->load->view('usuario/form',$data);
		$this->load->view('footer');
	}

	public function inclui()
	{
		$this->load->view('header');
		if($this->validaAcesso())
		{
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$params = array('controller'=>'usuario');
			$data['menu'] = $this->menu->show_menu($params);
			$data['quiz']  			= $this->quiz_model->getLastQuiz();
			$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
			$x = (isset($_REQUEST['id']))?'update':'insert';
			if(($this->verificaEmail($_REQUEST['email']))or(isset($_REQUEST['id'])))
			{
				$configuration = $this->config_model->staticGet();
				$dados = $_REQUEST;
				$dados['limitedownload'] = $configuration['limitedownload'];
				$this->usuario_model->set($dados);
				$res = $this->usuario_model->gravar();
				if($res[0]){
					if($x=='insert')
						$this->informaAdm($res[1]);
					if($_FILES['userfile']['name']!=''){
						//==== UPLOAD da IMAGEM ====
						$dados		= array('nome'	=> $res[1],
											'tipo'	=> $_FILES['userfile']['type'],
											'ext'	=> $this->get_file_extension($_FILES['userfile']['name']),
											'path'	=> SYS_FILE_PATH."usuarios".DIRECTORY_SEPARATOR);
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
				$data['erro']['msg'] 	= 'Desculpe! Email já cadastrado!';
				$data['erro']['status'] = false;
				$this->load->view('msg',$data);
			}
		}
		else
		{redirect();}
	}

	public function reenviaSenha()//Superior reenvia a senha para o email do usuario
	{
		$usuario 	= $this->usuario_model->staticGet('email',$_REQUEST['email']);
		if(count($usuario)>0)
		{
			$url		= base_url().'usuario/alteraSenha/'.md5($_REQUEST['email']);
			//tenta enviar o email para o usuario
			$params['email'] 		= $_REQUEST['email'];
			$params['url'] 			= $url;
			$params['assunto']		= 'Trocar senha Image Bank - Stock Car';
			$params['nome']			= $usuario['nome'];
			$params['msg']			=	'Olá '.$usuario['nome'].','.chr(10).
										'Por favor, clique no link baixo para alterar a senha de acesso ao sistema Image Bank.'.chr(10).
										'->'.$url.'<-'.chr(10).
										'Obrigado,'.chr(10).'EQUIPE Image Bank - Stock Car'.chr(10).
										'PS: Este e-mail é enviado automaticamente pelo sistema. Por favor, não responda.'
										;
			$enviar = $this->envia_email->enviar($params);
			$jsonReturn['msg']							= $enviar['msg'];
			$jsonReturn['status']						= $enviar['status'];
		}
		else
		{
			$jsonReturn['msg']							= 'Usuário não identificado';
			$jsonReturn['status']						= false;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	public function alteraSenha($md5)//usuario clicou no link em seu email e abre o form da senha
	{
		$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
		$data['userData'] 		= $this->usuario_model->staticGet('email_md5',$md5);
		if($data['userData']!='')
		{
			$data['usuario']	= $this->usuario_model->staticGet($data['userData']['id']);
			$data['md5']		= $md5;
		}
		else
		{
			$data['msg']			= 'Desculpe, ocorreu um erro na leitura da URL!';
		}
		$this->load->view('usuario/trocaSenha',$data);
		$this->load->view('footer');
	}
	public function trocaSenha()//Usuario clicou no botao de trocar a senha
	{
		$this->usuario_model->staticGet($_REQUEST['id']);
		if($this->usuario_model->trocaSenha($_REQUEST['id'],md5($_REQUEST['senha'])))
			redirect();
		else{
			$this->alteraSenha($_REQUEST['md5']);	
		}
	}

	public function informaAdm($id=null)
	{
		if((isset($id)) and ($id!=null))
		{
			$usuario				= $this->usuario_model->staticGet($id);
			$adm					= $this->config_model->staticGet();
			$params['email'] 		= $adm['email_admin'];
			$url					= base_url('admin');
			$params['assunto']		= 'Novo usuário - Image Bank - Stock Car';
			$params['nome']			= $usuario['nome'];
			$params['msg']			=	'Olá Admin,'.chr(10).
										'Novo usuário cadastrado no sistema Image Bank - Stock Car.'.chr(10).
										''.$url.''.chr(10).
										'Obrigado,'.chr(10).'EQUIPE Image Bank - Stock Car'.chr(10).
										'PS: Este e-mail é enviado automaticamente pelo sistema. Por favor, não responda.'
										;
			$enviar = $this->envia_email->enviar($params);
			if($enviar['status'])
				return true;
			else
				return false;
		}
		else
		{
			return false;
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
		$config['max_width'] 		= '140';
		$config['max_height'] 		= '140';
		
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

	public function setPaginacao($dados)
	{
		$config['base_url'] = base_url('usuario/lista/'.(isset($dados["tipo"])?$dados["tipo"]:'').'');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->usuario_model->listar($dados));
		$config['per_page'] = '10';
		$config['uri_segment']  = '4';
		$config['first_link'] = 'Primeiro';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	public function verificaEmail($email)
	{
		$res = $this->usuario_model->staticGet('email',$email);
		if(count($res)==0)
			$res = TRUE;
		else
			$res = FALSE;
		return $res;
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
//===========================================================================
}
?>
