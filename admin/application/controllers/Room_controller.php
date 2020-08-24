<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class product_controller extends CI_Controller
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
		$this->load->library('excel');
		$this->load->library('image');
		//==== models =====
		$this->load->model('user_model', '', TRUE);
		$this->load->model('file_model', '', TRUE);
		$this->load->model('config_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('provider_model', '', TRUE);
		$this->load->model('category_model', '', TRUE);
		$this->load->model('print_model', '', TRUE);
		$this->load->model('color_model', '', TRUE);
		$this->load->model('industry_model', '', TRUE);
		$this->load->model('product_color_model', '', TRUE);
		$this->load->model('product_industry_model', '', TRUE);
		$this->load->model('product_print_model', '', TRUE);
		$this->load->model('product_provider_model', '', TRUE);
	}
	
	public function index()
	{}
	
	public function form($id=null)
	{
		$this->load->view('header');
		$param = array('controller'=>'product','function'=>((isset($id))?'':'new'));
		$data['menu'] = $this->menu->show_menu($param);
		if($this->validaAcesso())
		{
			$params = array('active'=>'1');
			$data['providerList']			= $this->provider_model->getList($params);
			$data['categoryList']			= $this->category_model->getList($params);
			$data['printList']				= $this->print_model->getList($params);
			$data['colorList']				= $this->color_model->getList($params);
			$data['industryList']			= $this->industry_model->getList($params);
			if(isset($id))
			{
				$data['product']					= $_REQUEST = $this->product_model->staticGet($id);
				$dados 								= array('fk_product' => $id);
				$data['product']['productProvider']	= $this->product_provider_model->getList($dados);
				$data['product']['productPrint']	= $this->product_print_model->getList($dados);
				$data['product']['productColor']	= $this->product_color_model->getList($dados);
				$data['product']['productIndustry']	= $this->product_industry_model->getList($dados);
			}
			$this->load->view('product/form',$data);
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] 	= 'Desculpe. Permisión negada.';
			$this->load->view('msg',$data);
		}
		$this->load->view('footer');
	}
	
	public function getList()
	{
		$this->load->view('header');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'product','function'=>'list');
			$data['menu'] = $this->menu->show_menu($param);
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			if(!isset($_REQUEST['search']))
			{
				$category = (isset($_REQUEST['id_category']))?$_REQUEST['id_category']:null;
				if(isset($category))
					$dados = array('maximo'=>20,'inicio'=>$inicio,'fk_category'=>$category);
				else
					$dados = array('maximo'=>20,'inicio'=>$inicio);
				$data['paginacao']		= $this->setPagination($dados);
				
			}
			else
			{
				$data['search'] = $_REQUEST['search'];
				$dados = array('search'=>$data['search']);
			}
			//=============================================================================
			$products 		= $this->product_model->getList($dados);
			$productList = array();
			foreach ($products as $key => $value) {
				$x = ($value['code_origin'].'_1');
				$photo	= $this->image->get_mainPhoto($x,80,80);
				$productList[$key] = array(
									'id'						=>$value['id'],
									'code_origin'				=>$value['code_origin'],
									'name'						=>$value['name'],
									'description'				=>$value['description'],
									'qty_min'					=>$value['qty_min'],
									'category_id'				=>$value['fk_category'],
									'category_name'				=>$value['category_name'],
									'active'					=>$value['active'],
									'photo_url' 				=>$photo['url'],
									'photo_path' 				=>$photo['path'],
									'photo_w' 					=>$photo['w'],
									'photo_h' 					=>$photo['h']
									);
			}
			unset($photo);
			//=============================================================================
			$data['result'] = $productList;
			$this->load->view('product/list',$data);
		}
		else
		{
			redirect(base_url('main/doLogin'));
		}
		$this->load->view('footer');
	}
	
	
	
	public function save()
	{
		$this->load->view('header');
		$params = array('controller'=>'product','function'=>'');
		$data['menu'] = $this->menu->show_menu($params);
		$permissao = $this->validaAcesso();
		//if($permissao[0])//se permissao concedida
		//{
			$this->product_model->set($_REQUEST);
			$res = $this->product_model->save($_REQUEST);
			if($res[0]){
				$data['erro']['msg']	= 'Producto '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data['erro'];
				if(!isset($_REQUEST['id']))
					redirect('product/form/'.$res[1]);
				else
					$this->load->view('msg',$data);
			}
			else
			{
				$data['erro']['msg'] = 'Desculpe, error en la grabación.'.$res[1];
				$data['erro']['status'] = FALSE;
				$this->load->view('msg',$data);
			}
		/*	
		}
		else
		{
			$data['erro']['msg'] = 'Permisión negada.';
			$data['erro']['status'] = false;
			$this->load->view('msg',$data);
		}
		 */
	}

	public function addProvider($idProd)
	{
		$idProv = $_REQUEST['providers'];
		$dados = array(
			'fk_product' 	=> $idProd,
			'fk_provider' 	=> $idProv
		);
		$this->product_provider_model->set($dados);
		$res = $this->product_provider_model->save($dados);
		if($res[0]==FALSE){
			echo "<script> javascript:alert('Provedor ya cadastrado para el Producto.');</script>";
			echo "<script> window.location='".base_url('product/form/'.$idProd)."'</script>";
		}
		else {
			redirect(base_url('product/form/'.$idProd));
		}
	}
	
	public function addPrint($idProd)
	{
		$idPrint = $_REQUEST['prints'];
		$dados = array(
			'fk_product' 	=> $idProd,
			'fk_print' 		=> $idPrint
		);
		$this->product_print_model->set($dados);
		$res = $this->product_print_model->save($dados);
		if($res[0]==FALSE){
			echo "<script> javascript:alert('Tipo de Impressión ya cadastrado para el Producto.');</script>";
			echo "<script> window.location='".base_url('product/form/'.$idProd)."'</script>";
		}
		else {
			redirect(base_url('product/form/'.$idProd));
		}
	}
	
	public function addIndustries($idProd)
	{
		$idIndustry = $_REQUEST['industry'];
		$dados = array(
			'fk_product' 		=> $idProd,
			'fk_industry' 		=> $idIndustry
		);
		$this->product_industry_model->set($dados);
		$res = $this->product_industry_model->save($dados);
		if($res[0]==FALSE){
			echo "<script> javascript:alert('Rubro ya cadastrado para el Producto.');</script>";
			echo "<script> window.location='".base_url('product/form/'.$idProd)."'</script>";
		}
		else {
			redirect(base_url('product/form/'.$idProd));
		}
	}
	
	public function addColors($idProd)
	{
		$idColor = $_REQUEST['colors'];
		$dados = array(
			'fk_product' 	=> $idProd,
			'fk_color' 		=> $idColor
		);
		$this->product_color_model->set($dados);
		$res = $this->product_color_model->save($dados);
		if($res[0]==FALSE){
			echo "<script> javascript:alert('Color ya cadastrado para el Producto.');</script>";
			echo "<script> window.location='".base_url('product/form/'.$idProd)."'</script>";
		}
		else {
			redirect(base_url('product/form/'.$idProd));
		}
	}

	public function savePP()
	{
		$permissao = $this->validaAcesso();
		if($permissao[0])//se permissao concedida
		{
			$this->product_provider_model->set($_REQUEST);
			$res = $this->product_provider_model->save($_REQUEST);
			if($res[0]){
				$jsonReturn['msg']		= 'Provedor '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso para el producto! Relacción #'.$res[1];
				$jsonReturn['error']	= FALSE;
			}
			else
			{
				$jsonReturn['msg'] 		= 'Desculpe, error en la grabación.'.$res[1];
				$jsonReturn['error'] 	= TRUE;
			}
		}
		else
		{
			$jsonReturn['msg'] 			= 'Permisión negada.';
			$jsonReturn['error'] 		= TRUE;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	function sync($id)
	{
		$file = $this->excel->getContent($id);
		$dados = array();
		foreach ($file as $key => $row) {
			$category 							= $this->category_model->staticGet(preg_replace("/[^0-9\s]/", "", $row['category_code']));
			$dados['fk_category'] 		= $category['id'];
		    $dados['name'] 					= utf8_encode($row['product_name']);
		    $dados['description'] 		= utf8_encode($row['product_desc']);
			$dados['code_origin'] 		= $row['code_origin'];
			$dados['qty_min'] 				= $row['qty_min'];
			$medidas = explode('x', $row['product_measures']);
			if(isset($medidas[0]) and $medidas[0]!= '')
		   		$dados['height'] 		= trim($medidas[0]);
			else
				$dados['height'] 		= null;
			if(isset($medidas[1]) and $medidas[1]!= '')
				$dados['width'] 		= trim($medidas[1]);
			else
				$dados['width'] 		= null;
			if(isset($medidas[2]) and $medidas[2]!= '')
				$dados['depth'] 		= trim($medidas[2]);
			else
				$dados['depth'] 					= null;
			$dados['colors_available'] 	= $row['colors_available'];
			$dados['delivery_time'] 			= $row['delivery_time'];
			$dados['price'] 						= $row['price'];
			$dados['provider_code']			= $row['provider_code'];
		    $dados['print_types'] 				= $row['print_types'];
			$dados['industry_types'] 		= $row['industry_types'];
		    $dados['fk_file'] 						= $row['fk_file'];
			$dados['active'] 						= '0';
			$this->product_model->set($dados);
			$prd = $this->product_model->save($dados);

			//====== popula base de produto_color ==========================
			$colors = explode(',', $dados['colors_available']);
			$a = $b = $c = $d = 0;
			if($dados['colors_available']==''){
				$color = $this->color_model->staticGet('id','30');//color indefined
				$params = array('fk_product'=>$prd[1],'fk_color'=>$color['id']);
				$this->product_color_model->set($params);
				$this->product_color_model->save($params);
			}
			else{
				while ($a < count($colors)) {
					$color = $this->color_model->staticGet('name',trim($colors[$a]));
					$params = array('fk_product'=>$prd[1],'fk_color'=>$color['id']);
					$this->product_color_model->set($params);
					$this->product_color_model->save($params);
					$a++;
				}
			}
			//====== popula base de tipos de producto_impressao ====================
			$print_types = explode(',', $dados['print_types']);
			while ($b < count($print_types)) {
				$print = $this->print_model->staticGet('code',$print_types[$b]);
				$params = array('fk_product'=>$prd[1],'fk_print'=>$print['id']);
				$this->product_print_model->set($params);
				$this->product_print_model->save($params);
				$b++;
			}
			//====== popula base de tipos de producto_rubro ====================
			$industry_types = explode(',', $dados['industry_types']);
			while ($d < count($industry_types)) {
				$industry = $this->industry_model->staticGet('code',$industry_types[$d]);
				$params = array('fk_product'=>$prd[1],'fk_industry'=>$industry['id']);
				$this->product_industry_model->set($params);
				$this->product_industry_model->save($params);
				$d++;
			}
			//====== popula base de tipos de producto_provider ====================
			$providers = explode(',', $dados['provider_code']);
			while ($c < count($providers)) {
				$provider = $this->provider_model->staticGet(preg_replace("/[^0-9\s]/", "", $row['provider_code']));
				if(count($providers)>1)
					$params = array(
						'fk_product'	=>$prd[1],
						'fk_provider'	=>$provider['id'],
						'active'		=>$dados['active'],
						);
				else
					$params = array(
						'code'			=>$dados['code_origin'],
						'price'			=>$dados['price'],
						'delivery_time'	=>$dados['delivery_time'],
						'fk_product'	=>$prd[1],
						'fk_provider'	=>$provider['id'],
						);
				$this->product_provider_model->set($params);
				$this->product_provider_model->save($params);
				$c++;
			}
			unset($dados);
		}
		$data = array('id'=>$id,'sync_st'=>'1','date_sync'=>date("Y-m-d H:i:s"));
		$this->file_model->set($data);
		$this->file_model->save($data);
		// Read the first workbook in the file
		$jsonReturn['msg']		= 'Productos incluidos con suceso.';
		$jsonReturn['active']	= '1';
		$jsonReturn['label']	= 'sync';
		$jsonReturn['error']	= FALSE;

		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatus($id)
	{
		$product = $this->product_model->staticGet($id);
		if(count($product)>0)
		{
			$res = $this->product_model->changeStatus($id,(($product['active'])?'0':'1'));
			$novo=  $this->product_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatusPP($id)
	{
		$product_provider = $this->product_provider_model->staticGet($id);
		if(count($product_provider)>0)
		{
			$res = $this->product_provider_model->changeStatus($id,(($product_provider['active'])?'0':'1'));
			$novo=  $this->product_provider_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatusPrint($id)
	{
		$product_print = $this->product_print_model->staticGet($id);
		if(count($product_print)>0)
		{
			$res = $this->product_print_model->changeStatus($id,(($product_print['active'])?'0':'1'));
			$novo=  $this->product_print_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatusIndustry($id)
	{
		$product_industry = $this->product_industry_model->staticGet($id);
		if(count($product_industry)>0)
		{
			$res = $this->product_industry_model->changeStatus($id,(($product_industry['active'])?'0':'1'));
			$novo=  $this->product_industry_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatusColor($id)
	{
		$product_color = $this->product_color_model->staticGet($id);
		if(count($product_color)>0)
		{
			$res = $this->product_color_model->changeStatus($id,(($product_color['active'])?'0':'1'));
			$novo=  $this->product_color_model->staticGet($id);
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
			$jsonReturn['msg']		= 'Error! Iten inexistente!';
			$jsonReturn['erro']		= true;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function delete($id)
	{
		$res = $this->product_model->delete($id);
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
	
	public function deletePP($id)
	{
		$res = $this->product_provider_model->delete($id);
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
	public function deletePrint($id)
	{
		$res = $this->product_print_model->delete($id);
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
	public function deleteIndustry($id)
	{
		$res = $this->product_industry_model->delete($id);
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

	public function deleteColor($id)
	{
		$res = $this->product_color_model->delete($id);
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

	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
	function get_file_extension($file_name) {
		return '.'.substr(strrchr($file_name,'.'),1);
	}
	
	private function validaAcesso()
	{
		if(!isset($_SESSION['adm_promotions']['user']['email']))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
//===========================================================================
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('product/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->product_model->getList($dados));
		$config['per_page'] = '20';
		$config['uri_segment']  = '3';
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}