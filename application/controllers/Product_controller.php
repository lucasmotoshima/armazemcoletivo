<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_controller extends CI_Controller
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
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		$this->load->library('pagination');
		$this->load->library('image');
		$this->load->library('banner');
		$this->load->library('industry');
		$this->load->library('debug');
		$this->load->library('web_service');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Print_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->load->model('Product_color_model', '', TRUE);
		$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Product_print_model', '', TRUE);
		$this->load->model('Cart_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
	}
	
	
	public function index()
	{}
	
	function BuscaCEP(){
		//echo $_REQUEST['search'].'<br>';
		$cep = preg_replace("/[^0-9]/", "", $_REQUEST['search']);
		//echo $cep;
		$endereco = $this->web_service->getInfo(array('url'=>'https://viacep.com.br/ws/'.$cep.'/xml/'));
		$this->setCEP($endereco);
		return $endereco;	
	}
	
	function setCEP($endereco){
		$_SESSION['armazem']['user']['cep'] 			= $endereco['cep'];			
		$_SESSION['armazem']['user']['localidade'] 		= $endereco['localidade'];
		$_SESSION['armazem']['user']['uf'] 				= $endereco['uf'];
		redirect(base_url());
		//$this->debug->show($_SESSION);
	}
	
	function unsetCEP(){
		unset($_SESSION['armazem']['user']['cep']);
		unset($_SESSION['armazem']['user']['localidade']);
		unset($_SESSION['armazem']['user']['uf']);
		redirect(base_url());
		//$this->debug->show($_SESSION);
	}
	
	
	function setCategory(){
		$this->debug->show($_REQUEST['categoryList'],0);
		if (isset($_SESSION['armazem']['categoryList'])){
			unset($_SESSION['armazem']['categoryList']);
		}
		$_SESSION['armazem']['categoryList'] =  $_REQUEST['categoryList'];
		header('Content-Type: application/json');
		print json_encode($_SESSION['armazem']['categoryList']);
		//$this->debug->show($_SESSION['armazem']['categoryList']);
	}
	
	function unsetCategory(){
		unset($_SESSION['armazem']['user']['cep']);
		unset($_SESSION['armazem']['user']['localidade']);
		unset($_SESSION['armazem']['user']['uf']);
		redirect(base_url());
		//$this->debug->show($_SESSION);
	}
	
	public function getList()
	{
	  	/* Bread crum */
		static $breadcrumb         = array();

		if(isset($_REQUEST['search'])){
			$breadcrumb['Home'] 				= '/main';
			$breadcrumb['Produtos'] 			= '/product/getList';
			$breadcrumb['busca'] 				= '/product/getList';
			$breadcrumb[$_REQUEST['search']] 	= '';
		}else{
			$breadcrumb['Home'] 				= '/main';
			$breadcrumb['Produtos'] 			= '/product/getList';
		}
		
		/* Bread crum */
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 						= $this->Industry_model->getList();
		$data['rubros']					= $industry;
		$this->load->view('header',$data);
		$inicio 						= (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
		$dados 							= array('function'=>'getList','active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio);
		$data['pagination']				= $this->setPagination($dados);
		/*
		if(!isset($_REQUEST['search']))
		{
			$param = array('controller'=>'product','function'=>'list');
			if(isset($id_categoria)){
				if($id_categoria!=null){
					$dados 					= array('active'=>'1','fk_category'=>$id_categoria);
					$cat 					= $this->Category_model->staticGet($id_categoria);
					$data['category']		= $cat[0];
					//$this->debug->show($data);
					$breadcrumb[$data['category']['name']] = '';
				}
				else{
					$dados = array('active'=>'1');
				}
			}
			$dados = array('active'=>'1');

		}
		else
		{
			$data['search'] 	= $_REQUEST['search'];
			$dados 				= array('search'=>$data['search'],'active' => '1');
		}
		*/
		$products 				= $this->Product_model->getList($dados);
		//$this->debug->show($products);
		$productList = array();		
		
		foreach ($products as $key => $value) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$x = ($value['code_origin'].'_1');
			$photo  = $this->image->resize($x,100,100);
			$productList[$x] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}		
		//echo date(":i").' - '.date(":s").' / ';
		unset($photo);
		//======SHUFFLE NO RESULATDO======
        $keys = array_keys($productList);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $productList[$key];
        }
        $productList = $new;
		//====FIM SHUFFLE NO RESULATDO====
		$data['result']					= $productList;
		
		do {
			$category 				= $this->Category_model->getRand();
			$dados 					= array('fk_category'=>$category[0]['id'],'active'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>0,'main'=>'true');
			$productCategoryList	= $this->Product_model->getListThumb($dados);
		} while (count($productCategoryList) < 4);

		foreach ($productCategoryList as $x => $val) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$val['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$code_origin = ($val['code_origin'].'_1');
			//$photo	= $this->get_photo($x,208,115);
			$photo  = $this->image->resize($code_origin,100,100);
			$productCatList[$x] = array(
								'id'						=>$val['id'],
								'code_origin'				=>$val['code_origin'],
								'name'						=>$val['name'],
								'description'				=>$val['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$val['qty_min'],
								'fk_category'				=>$val['fk_category'],
								'category_name'				=>$category[0]['name'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		$data['resultCat']			= $productCatList;
		
		$data['breadcrumb'] 			= $breadcrumb;
		$data['industry'] 				= '';
		$this->load->view('product/list',$data);
		$this->load->view('footer');	
}

	public function getByCategory($id_categoria=null)
	{
		$cat = $this->Category_model->staticGet($id_categoria);
	  	/* Bread crum */
		static $breadcrumb         = array();
		if(isset($_REQUEST['search'])){
			$breadcrumb['Home'] 				= '/';
			$breadcrumb['Categoria'] 			= '/product/getByCategory'.$id_categoria;
			$breadcrumb['busca'] 				= '/product/getByCategory';
			$breadcrumb[$_REQUEST['search']] 	= '';
		}else{
			$breadcrumb['Home'] 				= '/';
			$breadcrumb['Categoria'] 			= '/product/getByCategory/'.$id_categoria;
			$breadcrumb[$cat[0]['name']] 		= '';
		}
		/* Bread crum */
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 						= $this->Industry_model->getList();
		$data['rubros']					= $industry;
		$data['controller'] 			= 'product';
		$this->load->view('header',$data);
		
		$inicio 						= (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
		$dados 							= array('function'=>'getByCategory','fk_category'=>$id_categoria,'active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio);
		$data['pagination']				= $this->setCategoryPagination($dados);
		
		$products 						= $this->Product_model->getList($dados);
		//$this->debug->show($products);
		$productList			= array();
		foreach ($products as $key => $value) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$x = ($value['code_origin'].'_1');
			$photo  = $this->image->resize($x,155,255);
			$productList[$x] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}		
		//->debug->show($productList);
		//echo date(":i").' - '.date(":s").' / ';
		unset($photo);
		//======SHUFFLE NO RESULATDO======
        $keys = array_keys($productList);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $productList[$key];
        }
        $productList = isset($new)?$new:array();
		//====FIM SHUFFLE NO RESULATDO====
		$data['result']					= $productList;
		$data['breadcrumb'] 			= $breadcrumb;
		$data['industry'] 				= '';
		$this->load->view('product/list',$data);
		$this->load->view('footer');	
}

	public function getByIndustry($id=null)
	{
	  	/* Bread crum */
		$ind = $this->Industry_model->staticGet($id);
		static $breadcrumb         = array();
		if(isset($_REQUEST['search'])){
			$breadcrumb['Home'] 				= '/main';
			$breadcrumb['Sessão'] 			= '/product/getByIndustry'.$id;
			$breadcrumb['busca'] 				= '/product/getByIndustry';
			$breadcrumb[$_REQUEST['search']] 	= '';
		}else{
			$breadcrumb['Home'] 				= '/main';
			$breadcrumb['Sessão'] 			= '/product/getByIndustry/'.$id;
			$breadcrumb[$ind[0]['name']] 		= '';
		}
		/* Bread crum */
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 						= $this->Industry_model->staticGet($id);
		$data['rubros']					= $industry;
		$data['controller'] 			= 'product';
		$this->load->view('header',$data);
		$param = array('controller'=>'product','function'=>'list');
		$inicio = (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
		$data['industry']				= $this->Industry_model->staticGet($id);
		$data['search']					= $data['industry'][0]['name'];
		
		$inicio 						= (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
		$dados 							= array('function'=>'getByIndustry','fk_industry'=>$id,'active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio);
		$data['pagination']				= $this->setIndustryPagination($dados);

		$products 				= $this->Product_model->getListRubro($dados);
		$productList			= array();
		foreach ($products as $key => $value) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$x = ($value['code_origin'].'_1');
			$photo  = $this->image->resize($x,155,255);
			//$photo	= $this->image->get_mainPhoto($x,179,147);
			$productList[$key] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}		
		//echo date(":i").' - '.date(":s").' / ';
		unset($photo);
		//======SHUFFLE NO RESULATDO======
        $keys = array_keys($productList);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $productList[$key];
        }
        $productList = $new;
		//====FIM SHUFFLE NO RESULATDO====
		$data['result']					= $productList;
		$data['breadcrumb'] 			= $breadcrumb;
		$data['industry']				= array('industry'=>$data['industry'][0]['id']);
		$this->load->view('product/list',$data);
		$this->load->view('footer');	
}

	public function getByProvider($id)
	{
		if(is_numeric($id)){
			$provider 					= $this->Provider_model->staticGet($id);
			$inicio 					= (!$this->uri->segment("4")) ? 0 : $this->uri->segment("4");
			$dados 						= array('function'=>'getByProvider','fk_provider'=>$id,'active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio,'main'=>'true');
			$data['pagination']			= $this->setProviderPagination($dados);
			/*===carrega metatags da header===*/
			$data['meta_title']			= $provider[0]['name'];
			$data['meta_url']			= base_url('product/getByProvider/'.$provider[0]['id']);		
			$data['meta_description']	= $provider[0]['description'];
			$data['meta_logo']			= base_url('admin/public/images/provider/'.$provider[0]['image']);
			$data['meta_fb_id']			= '2623777591233311';
			/*===carrega metatags da header===*/
		}else{
			$provider 					= $this->Provider_model->getByUrl((($id=='')?'*':str_replace('%20', '_', $id)));
			if(empty($provider)){
				redirect('profissional/ref/'.$id);
			}
			$inicio 					= '0';
			$dados 						= array('function'=>'getByProvider','fk_provider'=>(($provider[0]['id']==0)?'*':$provider[0]['id']),'active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio,'main'=>'true');
			$data['pagination']			= $this->setProviderPagination($dados);
			/*===carrega metatags da header===*/
			$data['meta_title']			= $provider[0]['name'];
			$data['meta_url']			= base_url('/'.$provider[0]['url_friendly']);		
			$data['meta_description']	= $provider[0]['description'];
			$data['meta_logo']			= base_url('admin/public/images/provider/'.$provider[0]['image']);
			$data['meta_fb_id']			= '2623777591233311';
			/*===carrega metatags da header===*/
		}
		$data['controller'] 			= 'product';
		$data['provider']				= $provider;
		
		$this->load->view('header',$data);
		$productList = array();
		
		$products 						= $this->Product_model->getListProvider($dados);
		
		$categoryList = array();
		foreach ($products as $key => $value) {
			$x = ($value['code_origin'].'_1');
			$photo  = $this->image->resize($x,100,100);
			$productList[$key] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$value['price'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'fk_provider'				=>$value['fk_provider'],
								'provider'					=>$data['provider'][0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$data['provider'][0]['id'],
								'provider_image'			=>$data['provider'][0]['image'],
								'category_name'				=>$value['category_name'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		unset($photo);
		//======SHUFFLE NO RESULATDO======
        $keys = array_keys($productList);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $productList[$key];
        }
        $productList = (isset($new))?$new:array();
		//====FIM SHUFFLE NO RESULATDO====
		$data['result']				= $productList;
		
		//======== thumbs de categoria shuffle =============================
		$categoryIdList 			= $this->Product_provider_model->getListDistinctCategory(((is_numeric($id))?$id:$provider[0]['id']));
		$k = array_keys($categoryIdList);
	 	shuffle($k);
		//$this->debug->show($categoryIdList[$k[0]]['fk_category'],0);
		$d 						= array('fk_provider'=>((is_numeric($id))?$id:$provider[0]['id']),'active'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>0,'main'=>'true');
		if(isset($k[0]))
			$d['fk_category']	= $categoryIdList[$k[0]]['fk_category'];
		$productCategoryList	= $this->Product_model->getListThumb($d);
		//$this->debug->show($productCategoryList,0);
		
		foreach ($productCategoryList as $x => $val) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$val['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			$category 			= $this->Category_model->staticGet($categoryIdList[$k[0]]['fk_category']);
			
			$code_origin = ($val['code_origin'].'_1');
			//$photo	= $this->get_photo($x,208,115);
			$photo  = $this->image->resize($code_origin,100,100);
			$productCatList[$x] = array(
								'id'						=>$val['id'],
								'code_origin'				=>$val['code_origin'],
								'name'						=>$val['name'],
								'description'				=>$val['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$val['qty_min'],
								'fk_category'				=>$val['fk_category'],
								'category_name'				=>$category[0]['name'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		$data['resultCat']		= isset($productCatList)?$productCatList:array();
		//==============================================================
		//$this->debug->show($productCategoryList);
		$this->load->view('product/list',$data);
		$this->load->view('footer');	
}
	
	public function getQColors($id=null)
	{
		$print = $this->print_model->staticGet($id);
		$options = '';
		if($print['qty_max_color']>0){
			for ($i=1; $i <= $print['qty_max_color']; $i++) {
				$options 		.= '<option value="'.$i.'">'.$i.'</option>';
			}
			$jsonReturn['options']		= $options;
			$jsonReturn['error']		= FALSE;
		}
		else {
			$jsonReturn['options']		= '<option value="X">n/a</option>';;
			$jsonReturn['error']		= TRUE;
		}
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
	
	public function detail($id)
	{
		
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 							= $this->Industry_model->getList();
		$data['rubros']						= $industry;
		$data['result'] = $product 			= $this->Product_model->staticGet($id);
		$data['category'] = $category 		= $this->Category_model->staticGet($product[0]['fk_category']);
		
		$product_provider 					= $this->Product_provider_model->staticGet('fk_product',$id);
		$data['product_provider']			= $product_provider;
		$provider 							= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
		$data['provider']					= $provider;
		
		$photos 							= $this->image->get_listPhotos($product[0]['code_origin'],300,300);
		//$this->debug->show($photos);
		$data['photos'] 					= $photos;
		
		$data['colors_available'] 			= $this->Product_color_model->getList(array('fk_product'=>$product[0]['id'], 'active'=>1));
		$data['print_available'] 			= $this->Product_print_model->getList(array('fk_product'=>$product[0]['id'], 'active'=>1));

		$cart = $data['cart']				= $this->Cart_model->staticGet('session_id',session_id());
		$params 							= array('fk_cart'=>(isset($cart[0]['id'])?$cart[0]['id']:'#'));
		$data['cartList']					= $this->Cart_product_model->getList($params);
		
		$params								= array('id'=>$product[0]['id'],'active'=>'1','maximo'=>1);
		$prev 								= $this->Product_model->getPrev($params);
		$next 								= $this->Product_model->getNext($params);

		$data['prev']						= (isset($prev[0]['id']))?base_url('product/detail/'.$prev[0]['id']):null;
		$data['next']						= (isset($next[0]['id']))?base_url('product/detail/'.$next[0]['id']):null;
		//$this->debug->show($data['cartList']);
		/*===carrega metatags da header===*/
		$data['meta_title']				= $product[0]['name'].' - R$'.str_replace('.', ',', $product_provider[0]['price']).' - '.$provider[0]['name'];
		$data['meta_url']				= base_url('product/detail/'.$product[0]['id']);		
		$isso_array 					= array('<p>','</p>','<ul>','</ul>','<li>','</li>','<strong>','</strong>','<b>','</b>');
		$aquilo_array 					= array('','','','','-','','','','','');
		$data['meta_description']		= str_replace($isso_array, $aquilo_array, $product[0]['description']);
		$data['meta_logo']				= $photos[1]['url'];
		$data['meta_fb_id']				= '2623777591233311';
		/*===carrega metatags da header===*/
		//$this->debug->show($data['cartList']);
				
		$this->load->view('header',$data);
		$this->load->view('product/detail',$data);
		$this->load->view('footer');
	}

//===========================================================================
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('product/getList');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getList($dados));
		$config['per_page'] = $dados['per_page'];
		$config['uri_segment']  = '3';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a href="#" aria-controls="datatable" data-dt-idx="" tabindex="0">';
		$config['cur_tag_close'] = '</li>';
		$config['first_link'] = 'Primeiro';
		$config['first_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Próximo';
		$config['next_tag_open'] = '<li class="paginate_button next" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<li class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	public function setCategoryPagination($dados)
	{
		$config['base_url'] = base_url('product/getByCategory');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getList($dados));
		$config['per_page'] = $dados['per_page'];
		$config['uri_segment']  = '4';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a href="#" aria-controls="datatable" data-dt-idx="" tabindex="0">';
		$config['cur_tag_close'] = '</li>';
		$config['first_link'] = 'Primeiro';
		$config['first_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Próximo';
		$config['next_tag_open'] = '<li class="paginate_button next" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<li class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	public function setIndustryPagination($dados)
	{
		$config['base_url'] = base_url('product/getByIndustry/'.$dados['fk_industry']);
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getListRubro($dados));
		$config['per_page'] = $dados['per_page'];
		$config['uri_segment']  = '4';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a href="#" aria-controls="datatable" data-dt-idx="" tabindex="0">';
		$config['cur_tag_close'] = '</li>';
		$config['first_link'] = 'Primeiro';
		$config['first_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Próximo';
		$config['next_tag_open'] = '<li class="paginate_button next" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<li class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	public function setProviderPagination($dados)
	{
		$config['base_url'] = base_url('product/getByProvider/'.$dados['fk_provider']);
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getListProvider($dados));
		$config['per_page'] = $dados['per_page'];
		$config['uri_segment']  = '4';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a href="#" aria-controls="datatable" data-dt-idx="" tabindex="0">';
		$config['cur_tag_close'] = '</li>';
		$config['first_link'] = 'Primeiro';
		$config['first_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Próximo';
		$config['next_tag_open'] = '<li class="paginate_button next" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<li class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
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
	
	function download($code,$num){
		$file = SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'_'.$num.'.jpg';
	   	if(isset($file) && file_exists($file)){
	   		header("Content-Type: application/JPG");
			header("Content-Length: ".filesize($file));
			header("Content-Disposition: attachment; filename=".$code.'_'.$num.'.jpg');
			readfile($file);
			exit();
		}
		else {
			echo "<script>alert('Arquivo inexistente.')</script>";
		}
	}
}