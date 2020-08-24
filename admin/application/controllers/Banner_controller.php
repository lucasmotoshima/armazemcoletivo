<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner_controller extends CI_Controller
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
		//$this->load->library('m2brimagem');
		$this->load->library('image');
		$this->load->library('image_lib');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Banner_model', '', TRUE);
	}
	
	public function index()
	{redirect('banner/list');}
	
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
			$param = array('controller'=>'banner','function'=>'list');
			$inicio = (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Banner_model->getList($dados);
			$this->load->view('banner/list',$data);
		}
		else
		{
			$data['erro']['status'] = false;
			$data['erro']['msg'] = 'Permisión negado!';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}

	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'banner','function'=>((isset($id))?'':'new'));
		$dados = array();
		if($this->validaAcesso())
		{
			if(isset($id))
				$dados['banner']	= $this->Banner_model->staticGet($id);
			$this->load->view('banner/form',$dados);
		}
		else
		{
			redirect('main/');
		}
		$this->load->view('footer');
	}

	public function save()
	{
		$params = array('controller'=>'banner','function'=>'new');
		$this->load->view('header');
		if($this->validaAcesso())
		{
			$this->Banner_model->set($_REQUEST);
			$res = $this->Banner_model->save($_REQUEST);
			if($res[0])
			{

				$data['erro']['status'] = TRUE;
				$data['erro']['msg'] 	= 'Registro Alterado com sucesso.';
				$this->load->view('msg',$data);
			}
			else
			{
				$data['erro']['status'] = FALSE;
				$data['erro']['msg'] = 'Error en la grabación.';
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
	
	public function carregaFoto(){
		$config['upload_path'] 		= SYS_IMAGE_PATH.'banner';
		//$this->debug->show($config['upload_path']);
		$config['file_name'] 		= md5(date('Y-m-d H:i:s'));
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '1500';
		$config['max_height'] 		= '1500';
		$config['field'] 			= 'bannerfile';
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		if(!is_dir($config['upload_path']))
		{
			mkdir($config['upload_path'], 0777, true);
		}
		if(!$this->upload->do_upload($config['field']))
		{
			$jsonReturn['msg']			= array(FALSE,$this->upload->display_errors());
		}
		else
		{
			$type = $this->image->get_type($_FILES['bannerfile']['type']);
			$result = array('upload_data' => $this->upload->data());
			$dados = array(	'width'			=> '855',
							'height'		=> '250',
							'upload_path'	=> $config['upload_path'],
							'path'			=> $config['upload_path'].'/'.$config['file_name'].'.'.$type,
							'file_name'		=> $config['file_name'],
							'ext' 			=> '.'.$type,
							);
			//$this->crop($dados);
			//$this->create_thumb($dados);
			//unlink($config['upload_path'].'/'.$config['file_name'].$dados['ext']);
			//unlink($config['upload_path'].'/'.$config['file_name'].'_cropped'.$dados['ext']);
			$jsonReturn['msg']			= $result;
			$jsonReturn['upload_path']	= SYS_FILE_URL.'banner';
			$jsonReturn['file_name']	= $dados['file_name'];
			$jsonReturn['type']			= 'jpg';
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	public function crop($dados){
		$new = imagecreatefromjpeg($dados['path']);
	    $crop_width = imagesx($new);
	    $crop_height = imagesy($new);
        $size = min($crop_width, $crop_height);
        if($crop_width >= $crop_height) {
       	 	$newx= ($crop_width-$crop_height)/2;
       	 	$dimensoes = array(
	        	'x'			=> $newx,
				'y'			=> 0,
				'width' 	=> $size,
				'height'	=> $size
			);
        	$im2 = imagecrop($new, $dimensoes);
        }
        else {
            $newy= ($crop_height-$crop_width)/2;
            $im2 = imagecrop($new, $dimensoes);
       	}
		$novonome = $dados['upload_path'].'/'.$dados['file_name'].'_cropped'.$dados['ext'];
	    imagejpeg($im2, $novonome,90);
	}

	public function create_thumb($dados)
	{
		$config_thumb['image_library'] 	= 'gd2';
		$config_thumb['source_image'] 	= $dados['upload_path'].'/'.$dados['file_name'].'_cropped'.$dados['ext'];
		$config_thumb['new_image'] 		= $dados['upload_path'].'/'.$dados['file_name'].'.jpg';
		$config_thumb['create_thumb'] 	= TRUE;
		$config_thumb['maintain_ratio'] = TRUE;
		$config_thumb['width'] 			= $dados['width'];
		$config_thumb['height'] 		= $dados['height'];
		$this->image_lib->initialize($config_thumb);
		if ( ! $this->image_lib->resize())
			echo $this->image_lib->display_errors();
	}
	
	public function delete($id)
	{
		$res = $this->Banner_model->delete($id);
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
		$banner = $this->Banner_model->staticGet($id);
		if(count($banner)>0)
		{
			$res = $this->Banner_model->changeStatus($id,(($banner[0]['active']=='1')?'0':'1'));
			$novo=  $this->Banner_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo[0]['active']=='1')?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active']=='1')?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo[0]['active']=='1')?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active']=='1')?'Ativo':'Inativo';
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
		$config['allowed_types'] 	= 'jpeg|png|JPG|jpg';
		$config['max_size']			= '2000';
		$config['overwrite'] 		= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$config['max_width'] 		= '855';
		$config['max_height'] 		= '250';
		//$this->debug->show($config);
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
			$x = array(TRUE,$result);
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
		$config['base_url'] = base_url().'banner/getList';
		$config['total_rows'] = count($this->Banner_model->getList());
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
		if(($_SESSION['adm_armazem']['user']['email']=='')or(!isset($_SESSION['adm_armazem']['user']['email'])))
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