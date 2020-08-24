<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File_controller extends CI_Controller
{
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
		$this->load->library('menu');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('File_model', '', TRUE);
	}
	
	public function index()
	{redirect('file/getList');}
	
	public function getList($tipo=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'file','function'=>'list');
			$inicio = (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->File_model->getList($dados);
			$this->load->view('file/list',$data);
		}
		else
		{redirect();}
		$this->load->view('footer');
	}

	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'file','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
				$_REQUEST		= $this->File_model->staticGet($id);
			$this->load->view('file/form');
		}
		else
		{
			redirect('main/');
		}
		$this->load->view('footer');
	}

	public function save()
	{
		$params = array('controller'=>'file','function'=>'new');
		$this->load->view('header');
		if($this->validaAcesso())
		{
			$this->File_model->set($_REQUEST);
			$res = $this->File_model->save($_REQUEST);
			if($res[0])
			{
				if($_FILES['file']['name']!=''){
					//==== UPLOAD da IMAGEM ====
					$dados		= array('nome'	=> $res[1],
										'tipo'	=> $_FILES['file']['type'],
										'ext'	=> $this->get_file_extension($_FILES['file']['name']),
										'path'	=> SYS_FILE_PATH,
										'field' => 'file'
										);
					$res_upload = $this->do_upload($dados);
					if($res_upload[0]==TRUE){
						//atualiza o registro com os dados do arquivo.
						$_REQUEST['id']			= $res[1];
						$_REQUEST['ext']		= $dados['ext'];
						$_REQUEST['path']		= $dados['path'];
						$this->File_model->set($_REQUEST);
						$res = $this->File_model->save($_REQUEST);
						$data['erro']['status'] = TRUE;
						$data['erro']['msg'] 	= 'Registro incluído con sucesso!';
						$this->load->view('msg',$data);
					}
					else
					{
						$this->File_model->delete($res[1]);
						$data['erro']['status'] = FALSE;
						$data['erro']['msg'] = 'Erro ao efetuar Upload do Arquivo!'.$res_upload[1].' -- '.$_FILES['file']['type'];
						$this->load->view('file/form',$data);
					}
				}
				else
				{
					$this->File_model->delete($res[1]);
					$data['erro']['status'] = TRUE;
					$data['erro']['msg'] = 'Erro ao efetuar Upload do Arquivo! Nome vazio.';
					$this->load->view('msg',$data);
				}
			}
			else
			{
				$data['erro']['status'] = FALSE;
				$data['erro']['msg'] = 'Error na gravação.';
				$this->load->view('msg',$data);
			}			
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] = 'Error.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function delete($id)
	{
		$res = $this->File_model->delete($id);
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

	public function changeStatus($id)
	{
		$file = $this->File_model->staticGet($id);
		if(count($file)>0)
		{
			$res = $this->File_model->changeStatus($id,(($file['active'])?'0':'1'));
			$novo=  $this->File_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo['active'])?'0':'1';
				$jsonReturn['label']	= ($novo['active'])?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo['active'])?'0':'1';
				$jsonReturn['label']	= ($novo['active'])?'Ativo':'Inativo';
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

	function do_upload($dados)
	{
		$config['upload_path'] 		= $dados['path'];
		$config['file_name'] 		= $dados['nome'];
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		
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
	public function setPagination($maximo)
	{
		$config['base_url'] = base_url().'file/getList';
		$config['total_rows'] = count($this->File_model->getList());
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