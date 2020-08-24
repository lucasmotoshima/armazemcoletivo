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
		$this->load->model('User_model', '', TRUE);
		$this->load->model('File_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Print_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
		$this->load->model('Product_color_model', '', TRUE);
		$this->load->model('Product_industry_model', '', TRUE);
		$this->load->model('Product_print_model', '', TRUE);
		$this->load->model('Product_provider_model', '', TRUE);
	}
	
	public function index()
	{}
	
	public function form($id=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header');
		$param = array('controller'=>'category','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			$params = array('active'=>'1');
			$data['providerList']			= $this->Provider_model->getList($params);
			$data['categoryList']			= $this->Category_model->getList($params);
			//$data['printList']				= $this->Print_model->getList($params);
			$data['colorList']				= $this->Color_model->getList($params);
			$data['industryList']			= $this->Industry_model->getList($params);
			if(isset($id))
			{
				$data['product']					= $_REQUEST = $this->Product_model->staticGet($id);
				$dados 								= array('fk_product' => $id);
				$data['product']['productProvider']	= $this->Product_provider_model->getList($dados);
				//$data['product']['productPrint']	= $this->Product_print_model->getList($dados);
				$data['product']['productColor']	= $this->Product_color_model->getList($dados);
				$data['product']['productIndustry']	= $this->Product_industry_model->getList($dados);
			}
			//$this->debug->show($data);
			$this->load->view('product/form',$data);
		}
		else
		{
			redirect(base_url());
		}
		$this->load->view('footer');
	}
	
	public function getList()
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
			$param = array('controller'=>'product','function'=>'list');
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
			$products 		= $this->Product_model->getList($dados);
			$productList = array();
			foreach ($products as $key => $value) {
				$x = ($value['code_origin'].'_1');
				$photo	= $this->image->get_mainPhoto($x,80,80);
				$productProvider	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
				$productList[$key] = array(
									'id'						=>$value['id'],
									'code_origin'				=>$value['code_origin'],
									'name'						=>$value['name'],
									'price'						=>$productProvider[0]['price'],
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
		$permissao = $this->validaAcesso();
		//if($permissao[0])//se permissao concedida
		//{
			$this->Product_model->set($_REQUEST);
			$res = $this->Product_model->save($_REQUEST);
			//===========================
			$productProviderStatic 	= $this->Product_provider_model->staticGet('fk_product',$res[1]);
			$paramsProductProvider 	= array('id'=>$productProviderStatic[0]['id'],'delivery_time'=>$_REQUEST['delivery_time'],'price'=>$_REQUEST['price']);
			$this->Product_provider_model->set($paramsProductProvider);
			$res_pp = $this->Product_provider_model->save($paramsProductProvider);
			
			if($res[0] and $res_pp[0]){
				$data['erro']['msg']	= 'Producto '.((isset($_REQUEST['id']))?'alterado':'incluído').' con suceso!';
				$data['erro']['status']	= TRUE;
				$this->externalTranslates = $data['erro'];
				if(!isset($_REQUEST['id']))
					redirect('product/form/'.$res[1]);
				else
					redirect('product/getList/');
			}
			else
			{
				$data['erro']['msg'] = 'Desculpe, erro na gravação.'.$res[1];
				$data['erro']['status'] = FALSE;
				redirect('product/form/'.$res[1]);
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
		$this->Product_provider_model->set($dados);
		$res = $this->Product_provider_model->save($dados);
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
		$this->Product_industry_model->set($dados);
		$res = $this->Product_industry_model->save($dados);
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
		$this->Product_color_model->set($dados);
		$res = $this->Product_color_model->save($dados);
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
		if($permissao)//se permissao concedida
		{
			$this->Product_provider_model->set($_REQUEST);
			$res = $this->Product_provider_model->save($_REQUEST);
			if($res[0]){
				$jsonReturn['msg']		= 'Fornecedor '.((isset($_REQUEST['id']))?'alterado':'incluído').' com sucesso para o produto! Relação #'.$res[1];
				$jsonReturn['error']	= FALSE;
			}
			else
			{
				$jsonReturn['msg'] 		= 'Desculpe, erro ao gravar registro.'.$res[1];
				$jsonReturn['error'] 	= TRUE;
			}
		}
		else
		{
			$jsonReturn['msg'] 			= 'Permissão negada.';
			$jsonReturn['error'] 		= TRUE;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	function sync($id)
	{
		$file = $this->excel->getContent($id);
		$dados = array();
		//$this->debug->show($file);
		foreach ($file as $key => $row) {
			$category 					= $this->Category_model->staticGet(preg_replace("/[^0-9\s]/", "", $row['category_code']));
			$dados['fk_category'] 		= $category[0]['id'];
		    $dados['name'] 				= utf8_encode($row['product_name']);
		    $dados['description'] 		= utf8_encode($row['product_desc']);
			$dados['code_origin'] 		= $row['code_origin'];
			$dados['qty_min'] 			= $row['qty_min'];
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
				$dados['depth'] 		= null;
			//$dados['colors_available'] 	= $row['colors_available'];
			$dados['delivery_time'] 	= $row['delivery_time'];
			$dados['price'] 			= str_replace(',', '.', $row['price']);
			$dados['provider_code']		= $row['provider_code'];
		    //$dados['print_types'] 		= $row['print_types'];
			$dados['industry_types'] 	= $row['industry_types'];
			$dados['validity'] 			= ($row['validity']=='')?'':$this->format_date->br2us($row['validity']);
		    $dados['fk_file'] 			= $row['fk_file'];
			$dados['active'] 			= '0';
			$this->Product_model->set($dados);
			$prd = $this->Product_model->save($dados);

			//====== popula base de produto_color ==========================
			//$colors = explode(',', $dados['colors_available']);
			//$a = $b = $c = $d = 0;
			//if($dados['colors_available']==''){
				//$color = $this->Color_model->staticGet('id','30');//color indefined
				//$params = array('fk_product'=>$prd[1],'fk_color'=>$color[0]['id']);
				//$this->Product_color_model->set($params);
				//$this->Product_color_model->save($params);
			//}
			//else{
				//while ($a < count($colors)) {
					//$color = $this->Color_model->staticGet('name',trim($colors[$a]));
					//$params = array('fk_product'=>$prd[1],'fk_color'=>$color[0]['id']);
					//$this->Product_color_model->set($params);
					//$this->Product_color_model->save($params);
					//$a++;
				//}
			//}
			//====== popula base de tipos de producto_impressao ====================
			/*
			$print_types = explode(',', $dados['print_types']);
			while ($b < count($print_types)) {
				$print = $this->print_model->staticGet('code',$print_types[$b]);
				$params = array('fk_product'=>$prd[1],'fk_print'=>$print['id']);
				$this->product_print_model->set($params);
				$this->product_print_model->save($params);
				$b++;
			}
			 */
			//====== popula base de tipos de producto_rubro ====================
			$industry_types = explode(',', $dados['industry_types']);
			$d = 0;
			while ($d < count($industry_types)) {
				$industry = $this->Industry_model->staticGet('code',trim($industry_types[$d]));
				$params = array('fk_product'=>$prd[1],'fk_industry'=>$industry[0]['id']);
				$this->Product_industry_model->set($params);
				$this->Product_industry_model->save($params);
				$d++;
			}
			//====== popula base de tipos de producto_provider ====================
			$provider = $this->Provider_model->staticGet(preg_replace("/[^0-9\s]/", "", $row['provider_code']));
			$params = array(
				'code'			=>$dados['code_origin'],
				'price'			=>$dados['price'],
				'delivery_time'	=>$dados['delivery_time'],
				'fk_product'	=>$prd[1],
				'fk_provider'	=>$provider[0]['id'],
				);		
			$this->Product_provider_model->set($params);
			$this->Product_provider_model->save($params);
			unset($dados);
		}
		$data = array('id'=>$id,'sync_st'=>'1','date_sync'=>date("Y-m-d H:i:s"));
		$this->File_model->set($data);
		$this->File_model->save($data);
		// Read the first workbook in the file
		$jsonReturn['msg']		= 'Produtos incluidos com sucesso.';
		$jsonReturn['status']	= '1';
		$jsonReturn['label']	= 'sync';
		$jsonReturn['error']	= FALSE;

		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function changeStatus($id)
	{
		$product = $this->Product_model->staticGet($id);
		if(count($product)>0)
		{
			$res = $this->Product_model->changeStatus($id,(($product[0]['active'])?'0':'1'));
			$novo=  $this->Product_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['status']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['status']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
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
		$product_provider = $this->Product_provider_model->staticGet($id);
		if(count($product_provider)>0)
		{
			$res = $this->Product_provider_model->changeStatus($id,(($product_provider[0]['active'])?'0':'1'));
			$novo=  $this->Product_provider_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo['active'])?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
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
			$res = $this->product_print_model->changeStatus($id,(($product_print[0]['active'])?'0':'1'));
			$novo=  $this->product_print_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo['active'])?'Ativo':'Inactivo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo['active'])?'Ativo':'Inactivo';
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
		$product_industry = $this->Product_industry_model->staticGet($id);
		if(count($product_industry)>0)
		{
			$res = $this->Product_industry_model->changeStatus($id,(($product_industry[0]['active'])?'0':'1'));
			$novo=  $this->Product_industry_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['ativo']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inactivo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['active']	= ($novo[0]['active'])?'1':'0';
				$jsonReturn['label']	= ($novo[0]['active'])?'Ativo':'Inativo';
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
		$product_color = $this->Product_color_model->staticGet($id);
		if(count($product_color)>0)
		{
			$res = $this->Product_color_model->changeStatus($id,(($product_color['active'])?'0':'1'));
			$novo=  $this->Product_color_model->staticGet($id);
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
	
	public function delete($id)
	{
		$res = $this->Product_model->delete($id);
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
		$res = $this->Product_provider_model->delete($id);
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
		$res = $this->Product_industry_model->delete($id);
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
		$res = $this->Product_color_model->delete($id);
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
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('product/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getList($dados));
		$config['per_page'] = '20';
		$config['uri_segment']  = '3';
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_link'] = 'First';
		
		$config['first_tag_open'] = '<li class="page_link">';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li class="page_link">';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li class="page_link">';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li class="page_link">';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}