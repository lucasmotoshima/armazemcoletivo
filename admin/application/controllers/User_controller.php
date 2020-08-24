<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class user_controller extends CI_Controller
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
		$this->load->library('image');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		//==============================================
		$this->externalTranslates['msg'] 	= NULL;
		$this->externalTranslates['status']	= FALSE;
		$data['input_error']				= array();
	}	
	
	public function index()
	{
		$this->load->view('header');
		$permissao = $this->validaAcesso();
		if($permissao[0])//se permissao concedida
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
	
	public function getList($tipo=null)
	{
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'user','function'=>'list');
			$inicio = (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->User_model->getList($dados);
			$this->load->view('header');
			$this->load->view('user/list',$data);
			$this->load->view('footer');
		}
		else
		{
			redirect();
		}
	}

	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'user','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST		= $this->user_model->staticGet($id);
			$this->load->view('user/form',$_REQUEST);
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] 	= 'Desculpe. Permisión negada.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}

	public function save()
	{
		$this->load->view('header');
		$params = array('controller'=>'usuario','function'=>'list');
		$data['menu'] = $this->menu->show_menu($params);
		if($this->validaAcesso())//se permissao concedida
		{
			if(($this->checkEmail($_REQUEST['email']))or(isset($_REQUEST['id'])))
			{
				$this->user_model->set($_REQUEST);
				$res = $this->user_model->save($_REQUEST);
				if($res[0]){
					$data['erro']['msg']	= 'Usuário '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
					$data['erro']['status']	= TRUE;
					$this->externalTranslates = $data['erro'];
					$this->load->view('msg',$data);
				}
				else
				{
					$this->externalTranslates['msg'] 	= 'Error en la inclusión.';
					$this->externalTranslates['status'] = FALSE;
					$data['erro']	= $this->externalTranslates;
					$this->load->view('msg',$data);
				}
			}
			else
			{
				$data['erro']['msg']	= 'Desculpe, e-mail ya utilizado.';
				$data['erro']['status']	= FALSE;
				$data['input_error'] = array('email');
				$this->load->view('user/form',$data);
			}
		}
		else
		{
			$data['erro']['msg'] 	= 'Hala el Login;';
			$data['erro']['status'] = FALSE;
			$this->load->view('msg',$data);
		}
	}

	public function delete($id)
	{
		$res = $this->user_model->excluir($id);
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

	public function changePass($md5)//usuario clicou no link em seu email e abre o form da senha
	{
		$data['userData'] 		= $this->user_model->staticGet('email_md5',$md5);
		if($data['userData']!='')
		{
			$data['user']		= $this->user_model->staticGet($data['userData']['id']);
			$data['md5']		= $md5;
		}
		else
		{
			$data['msg']			= 'Desculpe, error en la URL!';
		}
		$this->load->view('header');
		$this->load->view('user/changePass',$data);
		$this->load->view('footer');
	}
	
	public function recorPass()//Usuario clicou no botao de trocar a senha
	{
		$this->usuario_model->staticGet($_REQUEST['id']);
		if($this->usuario_model->changePass($_REQUEST['id'],md5($_REQUEST['senha'])))
			redirect();
		else{
			$this->changePass($_REQUEST['md5']);
		}
	}

	public function reenviaSenha($id)//Superior reenvia a senha para o email do usuario
	{
		if(isset($id))
		{
			$user 	= $this->user_model->staticGet($id);
			
			$texto = base_url();
			$posicao = strpos($texto, 'admin');
			$caminho = substr($texto, 0,$posicao);

			$url		= $caminho.'usuario/alteraSenha/'.md5($user['email']);
			//tenta enviar o email para o usuario
			$params['email'] 		= $usuario['email'];
			$params['url'] 			= $url;
			$params['assunto']		= 'Trocar senha Image Bank - Stock Car';
			$params['nome']			= $usuario['nome'];
			$params['msg']			=	'Olá '.$usuario['nome'].','.chr(10).
										'Por favor, clique no link baixo para alterar a senha de acesso ao sistema Image Bank - Stock Car.'.chr(10).
										''.$url.''.chr(10).
										'Obrigado,'.chr(10).'EQUIPE STOCKCAR'.chr(10).
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

	public function changeStatus($id)
	{
		$usuario = $this->user_model->staticGet($id);
		if(count($usuario)>0)
		{
			$res = $this->user_model->changeStatus($id,(($usuario['active'])?'0':'1'));
			$novo=  $this->user_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Item inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['name'];
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

	public function setPagination($dados)
	{
		$config['base_url'] = base_url('user/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->User_model->getList($dados));
		$config['per_page'] = '10';
		$config['uri_segment']  = '4';
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	public function checkEmail($email)
	{
		$res = $this->user_model->staticGet('email',$email);
		if(count($res)==0)
			$res = TRUE;
		else
			$res = FALSE;
		return $res;
	}
	
//===========================================================================

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
}
?>
