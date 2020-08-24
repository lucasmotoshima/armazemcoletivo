<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cart_product_controller extends CI_Controller
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
		$this->load->library('email');
		$this->load->library('image');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		//==== models =====
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Print_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Product_color_model', '', TRUE);
		$this->load->model('Product_print_model', '', TRUE);
		$this->load->model('Cart_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Cart_product_m_model', '', TRUE);
	}
	
	public function index()
	{redirect();}
	
	public function form($id=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header');
		$param = array('controller'=>'cart','function'=>((isset($id))?'':'new'));
		if($this->validaAcesso())
		{
			if(isset($id))
			{
				$cart_product							= $this->Cart_product_model->staticGet($id);
				$data['cart_product']					= $cart_product;
				$data['cart_product_m']					= $this->Cart_product_m_model->staticGet('fk_cart_product',$cart_product[0]['id']);
				$data['product']						= $this->Product_model->staticGet($cart_product[0]['fk_product']);
				$x 										= ($data['product'][0]['code_origin'].'_1');
				$photo  								= $this->image->resize($x,150,150);
				$data['cart_product'][0]['photo']		= $photo;
				$data['providers']						= $this->Product_provider_model->getList(array('fk_product'=>$cart_product[0]['fk_product']));
				
			}
			$this->load->view('cart_product/form',$data);
		}
		else
		{
			redirect(base_url());
		}
		$this->load->view('footer');
	}
	
	public function getList($id)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->view('header');
		//$this->debug->show($this->validaAcesso());
		if($this->validaAcesso())//se permissao concedida
		{
			$cart 					= $this->Cart_model->staticGet($id);
			$qtde					= count($this->Cart_model->getList(array('phone'=>$cart[0]['phone'],'status'=>'N')));
			$params = array('fk_cart'=>$cart[0]['id'], 'orderBy'=>"quantity desc");
			$cart_product			= $this->Cart_product_model->getList($params);
			$qtdeProd 				= 0;
			$deliveryTime			= 0;
			$qtdeProvider			= 0;
			$prov					= 0;
			$provAnt				= 0;
			$pagtos					= '';
			foreach ($cart_product as $key => $value) {
				$qtdeProd						= $qtdeProd + $value['quantity'];
				$product 						= $this->Product_model->staticGet($value['fk_product']);
				$provider						= $this->Provider_model->staticGet($value['fk_provider']);
				$product_provider				= $this->Product_provider_model->getList(array('fk_product'=>$value['fk_product'],'fk_provider'=>$value['fk_provider']));
				$x 								= ($product[0]['code_origin'].'_1');
				$photo  						= $this->image->resize($x,150,150);				
				
				if($provAnt!=$value['fk_provider']){
					$prov++;
					$provAnt		= $value['fk_provider'];
					$f 				= date('d-m-Y', strtotime("+".$product_provider[0]['delivery_time']." day".(($product_provider[0]['delivery_time']>1)?'s':''),strtotime(str_replace('/', '-', substr($this->format_date->us2br($cart[0]['date']), 0,10)))));
					$z 				= $this->format_date->diaSemana($f);
					$pagtos 		= (($provider[0]['tp_pagto_dinheiro'])?' Dinheiro |':'');
					$pagtos 		.= (($provider[0]['tp_pagto_credito'])?' Crédito |':'');
					$pagtos 		.= (($provider[0]['tp_pagto_boleto'])?' Boleto |':'');
					$pagtos 		.= (($provider[0]['tp_pagto_transferencia'])?' Transferência |':'');
				}
					
				$result[$key] = array(
		            'id' 							=> $value['id'],
		            'date' 							=> $cart[0]['date'],
		            'fk_cart' 						=> $value['fk_cart'],
		            'fk_product' 					=> $value['fk_product'],
		            'fk_provider' 					=> $value['fk_provider'],
		            'delivery_time'					=> $product_provider[0]['delivery_time'],
		            'delivery_time_mes'				=> $f,
		            'delivery_time_semana'			=> $z[1],
		            'quantity' 						=> $value['quantity'],
		            'product_name' 					=> $product[0]['name'],
		            'tax_perc' 						=> $value['tax_perc'],
		            'provider_name' 				=> $provider[0]['name'],
		            'provider_tp_producao' 				=> $provider[0]['tp_producao'],
		            'provider_dia_entrega' 				=> $provider[0]['dia_entrega'],
		            'provider_tp_pagto_dinheiro'		=> $provider[0]['tp_pagto_dinheiro'],
		            'provider_tp_pagto_debito'			=> $provider[0]['tp_pagto_debito'],
		            'provider_tp_pagto_credito'			=> $provider[0]['tp_pagto_credito'],
		            'provider_tp_pagto_boleto'			=> $provider[0]['tp_pagto_boleto'],
		            'provider_tp_pagto_transferencia'	=> $provider[0]['tp_pagto_transferencia'],
		            'product_unit_price' 				=> $value['product_unit_price'],
		            'profit_perc' 					=> $value['profit_perc'],
		            'product_total_price' 			=> $value['product_total_price'],
		            'prod_id' 						=> $value['prod_id'],
		            'prod_name' 					=> $value['prod_name'],
		            'prod_code_origin' 				=> $value['prod_code_origin'],
					'photo_url' 					=> $photo['url'],
					'photo_path' 					=> $photo['path'],
					'photo_w' 						=> $photo['w'],
					'photo_h' 						=> $photo['h']
				);
			}
			//$this->debug->show($result);
			$data['prov']					= $prov;
			$data['result']					= $result;
			$data['qtde']					= $qtde;
			$data['qtdeUnit']				= count($cart_product);
			$data['cart']					= $cart;
			$data['qtdeProd']				= $qtdeProd;
			$data['deliveryTime']			= $deliveryTime;
			
			$this->load->view('cart_product/list',$data);
			$this->load->view('footer');
		}
		else
		{
			redirect(base_url());
		}
	}
		
	public function changeStatus($id)
	{
		$cart_product = $this->cart_product_model->staticGet($id);
		if(count($print)>0)
		{
			$res = $this->cart_product_model->changeStatus($id,(($cart_product['active'])?'0':'1'));
			$novo=  $this->cart_product_model->staticGet($id);
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

	public function reCalc(){
		$dados = $_REQUEST;
		$idProd					= $dados['idProd'];
		$quantity				= floatval(str_replace(".",",",$dados['quantity']));
		$product_provider		= $this->Product_provider_model->staticGet('fk_product',$idProd);
		$provider				= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
		
		
		$jsonReturn['product_unit_price']	= number_format($product_provider[0]['price'], 2, ',', '.');
		$jsonReturn['quantity']				= number_format($quantity, 0, ',', '.');
		$jsonReturn['product_price']		= number_format($product_provider[0]['price'] * $quantity, 2, ',', '.');
		$jsonReturn['dif_perc']				= number_format(($product_provider[0]['price'] * ($provider[0]['tax']/100)) * ($quantity), 2, ',', '.');
		$jsonReturn['total']				= number_format($product_provider[0]['price'] * $quantity, 2, ',', '.');
		$jsonReturn['discount_limit']		= number_format(((($product_provider[0]['price'] * ($provider[0]['tax']/100)) * ($quantity))/2), 2, ',', '.');

		$jsonReturn['msg']		= 'Produto Recalculado';
		$jsonReturn['error']	= FALSE;
		
		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}

	public function saveRecalc(){
		$dados = $_REQUEST;
		
		$cart_product 			= $this->Cart_product_model->staticGet($dados['fk_cart_product']);
		$dados = array(
			'id' 					=> $dados['fk_cart_product'],
			'product_total_price'	=> $cart_product[0]['product_unit_price'] * $dados['quantity'],
			'quantity'				=> $dados['quantity'],
			'profit_perc'			=> str_replace(",",".",(($dados['quantity'] * $cart_product[0]['product_unit_price']) * ( $cart_product[0]['tax_perc'] /100  ))),
			);
		$this->Cart_product_model->set($dados);
		$res = $this->Cart_product_model->save($dados);
		if($res[0]){
			$jsonReturn['msg']		= 'Produto Recalculado';
			$jsonReturn['error']	= FALSE;
		}
		else{
			$jsonReturn['msg']		= 'Error: '.$res[1];
			$jsonReturn['error']	= TRUE;
		}

		header('Content-Type: application/json');
		print json_encode($jsonReturn);
	}
		
	public function deleteProduct($id)
	{
		$cart_product = $this->Cart_product_model->staticGet($id);
		//$this->debug->show($cart_product);
		if($cart_product[0]['quantity']>1){
			$params = array('quantity'=>($cart_product[0]['quantity']-1),'id'=>$id);
			$this->Cart_product_model->set($params);
			$res 				= $this->Cart_product_model->save($params);
			$data['quantity'] 	= $cart_product[0]['quantity']-1;
			$data['msg'] 		= '1 unidade excuída com sucesso.';
			$data['erro'] 		= FALSE;   
		}else{
			$res = $this->Cart_product_model->delete($id); 
			$data['quantity'] 	= 0;
			$data['msg'] 		= $res[1];
			$data['erro'] 		= FALSE;
		}
		redirect(base_url('/cart_product/getList/'.$cart_product[0]['fk_cart']));
		//header('Content-Type: application/json');
		//print json_encode($data);
	}
		
	public function delete($id)
	{
		$res = $this->cart_product_model->delete($id);
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

//===========================================================================	
	private function validaAcesso()
	{
		if(!isset($_SESSION['adm_armazem']))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function setPagination($dados)
	{
		$config['base_url'] = base_url('cart/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->cart_model->getList($dados));
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