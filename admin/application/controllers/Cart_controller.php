<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cart_controller extends CI_Controller
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
		$this->load->library('pdf');
		//$this->load->library('html2pdf');  
		//==== models =====
		$this->load->model('User_model', '', TRUE); 
		$this->load->model('Config_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Print_model', '', TRUE);
		$this->load->model('Color_model', '', TRUE);
		$this->load->model('Product_color_model', '', TRUE);
		$this->load->model('Product_print_model', '', TRUE);
		//$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Cart_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Cart_product_m_model', '', TRUE);
	}
	
	public function index()
	{redirect();}
	
	public function getList()
	{
		if($this->validaAcesso())//se permissao concedida
		{
			$this->output->set_header('HTTP/1.0 200 OK');
			$this->output->set_header('HTTP/1.1 200 OK');
			$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
			$this->load->view('header');
			$param = array('controller'=>'cart','function'=>'list');
			$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
			$dados = array('maximo'=>20,'inicio'=>$inicio);
			$data['paginacao']		= $this->setPagination($dados);
			$data['result'] 		= $this->Cart_model->getList($dados);
			$this->load->view('cart/list',$data);
			$this->load->view('footer');
		}
		else
		{
			redirect(base_url());
		}
		
	}
	
	public function getPedidosJson(){
		$_REQUEST['lastId']; //lastCardId
		$params 				= array('id'=>$_REQUEST['lastId'],'dateUpTo'=>date('Y-m-d'),'status_N'=>'W',);
		$cart					= $this->Cart_model->getListJson($params);
		if(count($cart)>0){
			$data['status'] = '1';
		}else{
			$data['status'] = '0';
		}
		
		header('Content-Type: application/json');
		print json_encode($data);
	}
	
	public function detail($id)
	{
		$this->load->view('header');
		if($this->validaAcesso())//se permissao concedida
		{
			$param = array('controller'=>'cart','function'=>'list');
			$data['menu'] = $this->menu->show_menu($param);
			$cart 					= $_REQUEST = $this->Cart_model->staticGet($id);
			$params = array('fk_cart'=>$cart['id']);
			$data['result']			= $this->Cart_product_model->getList($params);
		}
		else
		{
			$data['erro']['status'] = false;
			$data['erro']['msg'] = 'Permisión negado!';
			$this->load->view('msg',$data);
		}
		$this->load->view('cart_product/list',$data);
		$this->load->view('footer');
	}
		
	public function changeStatus($id)
	{
		$cart = $this->Cart_model->staticGet($id);
		if(count($cart)>0)
		{
			$res = $this->Cart_model->changeStatus($id,(($cart['status']=='Y')?'N':'Y'));
			$novo=  $this->Cart_model->staticGet($id);
			if($res[0]==TRUE)//se ocorreu erro
			{
				$jsonReturn['msg']		= 'Error. '.$res[1];
				$jsonReturn['status']	= ($novo[0]['status'])?'Y':'N';
				$jsonReturn['label']	= ($novo[0]['status'])?'Ativo':'Inativo';
				$jsonReturn['error']	= true;
			}
			else
			{
				$jsonReturn['msg']		= $res[1];
				$jsonReturn['status']	= ($novo[0]['status'])?'Y':'N';
				$jsonReturn['label']	= ($novo[0]['status'])?'Ativo':'Inativo';
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
	
	public function save()
	{
		$params = array('controller'=>'cart','function'=>'new');
		$this->load->view('header');
		if($this->validaAcesso())
		{
			$this->Cart_model->set($_REQUEST);
			$res = $this->Cart_model->save($_REQUEST);
			if($res[0])
				redirect('cart_product/getList/'.$_REQUEST['id']);
			else
			{
				$data['erro']['status'] = FALSE;
				$data['erro']['msg'] = 'Erro na gravação.';
				$this->load->view('header');
				$this->load->view('msg',$data);
				$this->load->view('footer');
			}			
		}
		else
		{
			$data['erro']['status'] = FALSE;
			$data['erro']['msg'] = 'Error.';
			$this->load->view('header');
			$this->load->view('msg',$data);
			$this->load->view('footer');
		}
	}
		
	public function delete($id)
	{
		$res = $this->Cart_model->delete($id);
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

	public function budgetDownload($id){
		$data['cart'] 				= $this->Cart_model->staticGet($id);
		$data['cart_product'] 		= $this->Cart_product_model->getList(array('fk_cart'=>$data['cart'][0]['id']));
			
		$data['config'] 			= $this->Config_model->staticGet();
		$data['user']				= $this->User_model->staticGet($_SESSION['adm_armazem']['user']['id']);
		
		if($data['cart_product']>0){
			foreach ($data['cart_product'] as $key => $value){
				$foto 											= $this->get_photos($data['cart_product'][$key]['prod_code_origin'],100,100);
				$data['cart_product'][$key]['photo']['url']		= $foto['url'];
				$data['cart_product'][$key]['photo']['w']		= $foto['w'];
				$data['cart_product'][$key]['photo']['h']		= $foto['h'];
				$data['cart_product'][$key]['cart_product'] 	= $this->Cart_product_model->staticGet($value['id']);
			}
		}
		else{
			$data['cart_product'][$key]['cart_product_m'] = null;
		}
		
		$path 						= SYS_FILE_PATH.'pdf'.DIRECTORY_SEPARATOR;
		$arquivo 					= $path.$id.'.pdf'; // caminho absoluto do arquivo
		//$this->debug->show($this->Cart_model->changeStatus($id,'Y'));
		/*
		if(!file_exists($arquivo)){
			mkdir($path, 0777, true);
			$this->html2pdf->folder($path);
			$this->html2pdf->filename($id.'.pdf');
			$this->html2pdf->paper('p','a4', 'en');
			$this->html2pdf->html($this->load->view('cart/budget', $data,true));
			$this->html2pdf->create('save');
		}
		 */ 
		if(file_exists($arquivo)){
			header("Content-Type: application/pdf");
			header("Content-Length: ".filesize($arquivo));
			header("Content-Disposition: attachment; filename=".$id.'.pdf');
			readfile($arquivo);
			exit;
		}
	}
	
	public function budget($id){
		$data['cart'] 				= $this->Cart_model->staticGet($id);
		$data['cart_product'] 		= $this->Cart_product_model->getList(array('fk_cart'=>$data['cart'][0]['id']));
			
		$data['config'] 			= $this->Config_model->staticGet();
		$data['user']				= $this->User_model->staticGet($_SESSION['adm_armazem']['user']['id']);
		
		if($data['cart_product']>0){
			foreach ($data['cart_product'] as $key => $value){
				$foto 											= $this->get_photos($data['cart_product'][$key]['prod_code_origin'],100,100);
				$data['cart_product'][$key]['photo']['url']		= $foto['url'];
				$data['cart_product'][$key]['photo']['w']		= $foto['w'];
				$data['cart_product'][$key]['photo']['h']		= $foto['h'];
				$data['cart_product'][$key]['cart_product'] 	= $this->Cart_product_model->staticGet($value['id']);
			}
		}
		else{
			$data['cart_product'][$key]['cart_product_m'] = null;
		}
		
		$path 						= SYS_FILE_PATH.'pdf'.DIRECTORY_SEPARATOR;
		$arquivo 					= $path.$id.'.pdf'; // caminho absoluto do arquivo
		//$this->debug->show($this->Cart_model->changeStatus($id,'Y'));
		if(!file_exists($arquivo)){
			mkdir($path, 0777, true);
			$this->html2pdf->folder($path);
			$this->html2pdf->filename($id.'.pdf');
			$this->html2pdf->paper('p','a4', 'en');
			$this->html2pdf->html($this->load->view('cart/budget', $data,true));
			$this->html2pdf->create('save');
		}
/*
		if(file_exists($arquivo)){
			header("Content-Type: application/pdf");
			header("Content-Length: ".filesize($arquivo));
			header("Content-Disposition: attachment; filename=".$id.'.pdf');
			readfile($arquivo);
			exit;
		}
 */
		 redirect('cart/getList');
		
	}

	public function sendEmail($id){
		$cart					= $this->Cart_model->staticGet($id);
		$params 				= array('fk_cart'=>$cart[0]['id']);
		$cart_product			= $this->Cart_product_model->getList($params);
		$prodProv				= array();
		//$this->debug->show($cart_product);
		foreach ($cart_product as $key => $value) {
			$product 						= $this->Product_model->staticGet($value['fk_product']);
			$product_provider				= $this->Product_provider_model->staticGet('fk_product',$product[0]['id']);
			$product_photo		 			= $this->image->get_mainPhoto($value['prod_code_origin'].'_1',145,145);
			$result[$key] 					= array(
				'id'							=> $value['id'],
				'fk_cart'						=> $cart[0]['id'],
				'fk_product'					=> $cart_product[0]['fk_product'],
				'fk_provider'					=> $product_provider[0]['fk_provider'],
				'delivery_time'					=> $product_provider[0]['delivery_time'],
				'quantity'						=> $value['quantity'],
				'prod_id'						=> $value['prod_id'],
				'prod_name'						=> $value['prod_name'],
				'prod_code_origin'				=> $value['prod_code_origin'],
				'product'						=> $product,
				'product_photo'					=> $product_photo,
				'product_provider'				=> $product_provider
				);
		}
		$data['cart']			= $cart;
		$data['result']			= $result;
		//tenta enviar o email para o usuario
		$params['to'] 			= $cart[0]['email'];
		$params['assunto']		= 'Carrinho de Compras - id:'.$cart[0]['id'];
		$params['nome']			= $cart[0]['client_name'];
		
		$config = $this->Config_model->staticGet();
		$font='style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"';
		$msg = '';
		$msg .= '<strong '.$font.'> Pedido: </strong>'.$cart[0]['id'].'<br>';
		$msg .= '<strong '.$font.'> Nome: </strong>'.$cart[0]['client_name'].'<br>';
		$msg .= '<strong '.$font.'> Telefone: </strong>'.$cart[0]['phone'].'<br>';
		$msg .= '<strong '.$font.'> E-mail: </strong>'.$cart[0]['email'].'<br>';
		$msg .= '<strong '.$font.'> Cidade: </strong>'.$cart[0]['city'].'<br>';
		$msg .= '<strong '.$font.'> Data: </strong>'.$this->format_date->us2br($cart[0]['date']).'<br>';
		$msg .= '<strong '.$font.'> Mensagem: </strong>'.$cart[0]['obs'].'<br>';
		$msg .=
		'<img src="'.base_url('public/images/config/presupuesto.jpg').'"></img>';
		$msg.= '<br>Pedido: #'.date('dmY').'_'.str_pad($cart[0]['id'], 4, "0", STR_PAD_LEFT);
		$totGeral 				= 0;
		$deliveryTime 			= 0;
		$index 					= 0;
		$msg.= 
			'<table border=0 style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; width: 550px;">';
		foreach ($cart_product as $results => $value) {
			//$this->debug->show($result[$key]['product_photo']['url']);
			$product_provider		= $this->Product_provider_model->staticGet('fk_product',$value['fk_product']);
			$deliveryTime			= ($deliveryTime <= $result[$key]['delivery_time'])?$result[$key]['delivery_time']:$deliveryTime;
			$ProductProviderList 	= $this->Cart_product_model->getListProductProvider(array('fk_cart'=>$id,'fk_provider'=>$product_provider[0]['fk_provider']));
			//$this->debug->show($ProductProviderList);
			$msg.= 
					'<tr><td colspan="3" style="height: 5px; border-bottom:1px solid #616161;"></td></tr>'.
					'<tr>'.
						'<td rowspan="5" style="border:1px solid #d9d9d9; text-align: center;" align="center">'.
							'<img src="'.$result[$results]['product_photo']['url'].'" width="'.$result[$results]['product_photo']['w'].'" height="'.$result[$results]['product_photo']['h'].'">'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="2">'.
							'<strong style="color:#616161;font-weight:bold;">'.$result[$results]['prod_name'].'<small> '.$result[$results]['product'][0]['description'].'</small>'.' <small>('.$result[$results]['prod_code_origin'].')</small>'.'</strong>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Quantidade </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;">'.number_format($value['quantity'],0, ',', '.').'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Valor Unitário </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($value['product_unit_price']),2, ',', '.').'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Subtotal</div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($value['product_total_price']),2, ',', '.').'</div>'.
						'</td>'.
					'</tr>';
				$totGeral = $totGeral + $value['product_total_price'];
			}
			$msg.= 
			'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #616161;"></td></tr>'.
			'<tr>'.
				'<td>'.
					'<div style="color: #828385; font-weight: bold;">Entrega:</div>'.
				'</td>'.
				'<td colspan="2">'.
					//'<div style="color: #616161; font-weight: bold; text-align:right;"> '.$deliveryTime[0]['delivery_time'].' dias</div>'.
					$data = date('d/m/Y'); 
					'<div style="color: #616161; font-weight: bold; text-align:right;"> '.date('d/m/Y', strtotime("+".$deliveryTime[0]['delivery_time']." days",strtotime($data))).' dias</div>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td>'.
					'<div style="color: #828385; font-weight: bold;">Total</div>'.
				'</td>'.
				'<td colspan="2">'.
					'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($totGeral),2, ',', '.').'</div>'.
				'</td>'.
			'</tr>';
		$msg.= '</table>';
		$msg.= '<i '.$font.'></i><br>';
		$msg = str_replace("%Array%", "", $msg);
		//print_r($msg);die();
		$params['msg']			= $msg;
		//$enviar = $this->envia_email->enviar($params);
		//$this->sendEmailProvider($id);
		//$this->debug->show($params['msg'],1);
		//redirect(base_url('cart/getList/'));
	}


	public function sendEmailProvider($cartId){
		$cart = $this->Cart_model->staticGet($cartId);
		$prov = $this->Cart_product_model->getListProvider(array('fk_cart'=>$cartId));
		foreach ($prov as $key => $val) {
			$provedor 				= $this->Provider_model->staticGet($val['fk_provider']);
			$params['to'] 			= $provedor[0]['email'];
			$params['assunto']		= $provedor[0]['name'].' - Carrinho de Compras - id:'.$cartId;
			$params['cc']			= $cart[0]['email'];
			
			$product_providerList 	= $this->Cart_product_model->getListProductProvider(array('fk_cart'=>$cartId, 'fk_provider'=>$provedor[0]['id']));
			$deliveryTime 			= 0;
			$font='style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"';
			$msg = '';
			$msg .= '<strong '.$font.'> Pedido: </strong>'.$cart[0]['id'].'<br>';
			$msg .= '<strong '.$font.'> Cliente: </strong>'.$cart[0]['client_name'].'<br>';
			$msg .= '<strong '.$font.'> Telefone: </strong>'.$cart[0]['phone'].'<br>';
			$msg .= '<strong '.$font.'> Rua: </strong>'.$cart[0]['adress'].', '.$cart[0]['number'].'<br>';
			$msg .= '<strong '.$font.'> Cidade: </strong>'.$cart[0]['city'].'<br>';
			$msg .= '<strong '.$font.'> Data: </strong>'.$this->format_date->us2br($cart[0]['date']).'<br>';
			$msg .= '<strong '.$font.'> Mensagem: </strong>'.$cart[0]['obs'].'<br>';
			$msg .=
			'<img src="'.base_url('public/images/config/presupuesto.jpg').'"></img>';
			$totGeral 				= 0;
			$msg .= 
				'<table border=0 style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; width: 550px;">';
			$msg.= 
				'<tr><td colspan="3" style="height: 5px; border-bottom:1px solid #616161;"><h3>Fornecedor: '.$val['name'].'<h3></td></tr>';
			foreach ($product_providerList as $key => $value) {
				$product_provider		= $this->Product_provider_model->staticGet('fk_product',$value['fk_product']);
				$deliveryTime		 	= ($deliveryTime <= $product_provider[0]['delivery_time'])?$product_provider[0]['delivery_time']:$deliveryTime;
				$product_photo		 	= $this->image->get_mainPhoto($value['code_origin'].'_1',145,145);
				//$this->debug->show($product_photo);
				$msg.= 
					'<tr><td colspan="3" style="height: 5px; border-bottom:1px solid #616161;"></td></tr>'.
					'<tr>'.
						'<td rowspan="5" style="border:1px solid #d9d9d9; text-align: center;" align="center">'.
							'<img src="'.$product_photo['url'].'" width="'.$product_photo['w'].'" height="'.$product_photo['h'].'">'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="2">'.
							'<strong style="color:#616161;font-weight:bold;">'.$value['name'].'<small> '.$value['description'].'</small>'.' <small>('.$value['code_origin'].')</small>'.'</strong>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Quantidade </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;">'.number_format($value['quantity'],0, ',', '.').'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Valor Unitário </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($value['product_unit_price']),2, ',', '.').'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Subtotal</div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($value['product_total_price']),2, ',', '.').'</div>'.
						'</td>'.
					'</tr>';
				$totGeral = $totGeral + $value['product_total_price'];
			}
			$f = date('d/m/Y', strtotime("+".$deliveryTime." day".(($deliveryTime>1)?'s':''),strtotime(date('d-m-Y'))));
			$z = $this->format_date->diaSemana($f);
			$pagtos = (($provedor[0]['tp_pagto_dinheiro'])?' Dinheiro |':'');
			$pagtos .= (($provedor[0]['tp_pagto_credito'])?' Crédito |':'');
			$pagtos .= (($provedor[0]['tp_pagto_boleto'])?' Boleto |':'');
			$pagtos .= (($provedor[0]['tp_pagto_transferencia'])?' Transferência |':'');
			$msg.= 
			'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #616161;"></td></tr>'.
			'<tr>'.
				'<td>'.
					'<div style="color: #828385; font-weight: bold;">Aceitamos:</div>'.
				'</td>'.
				'<td colspan="2" align="right"><b>'.
				'<div style="color: #616161; font-weight: bold; text-align:right;">'.$pagtos.'</div>'.
				'</b></td>'.
			'</tr>'.
			'<tr>'.
				'<td>'.
					'<div style="color: #828385; font-weight: bold;">Data da Entrega:</div>'.
				'</td>'.
				'<td colspan="2" align="right"><b>'.
				'<div style="color: #616161; font-weight: bold; text-align:right;">'.$f.' ('.$z[1].')</div>'.
				'</b></td>'.
			'</tr>'.
			'<tr>'.
				'<td>'.
					'<div style="color: #828385; font-weight: bold;">Total</div>'.
				'</td>'.
				'<td colspan="2">'.
					'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($totGeral),2, ',', '.').'</div>'.
				'</td>'.
			'</tr>';
			$msg.= '</table>';
			$msg = str_replace("%Array%", "", $msg);
			$params['msg']			= $msg;
			
			//$enviar = $this->envia_email->enviar($params);
			
			$this->Cart_model->changeStatus($cartId,'Y');
			//$this->debug->show($params['msg']);

			//=========================================================
			/*
			 * $path 						= SYS_FILE_PATH.'pdf'.DIRECTORY_SEPARATOR;
			$arquivo 					= $path.$cartId.'_'.$val['fk_provider'].'.pdf'; // caminho absoluto do arquivo
			//$this->debug->show($arquivo);
			
			if(!file_exists($arquivo)){
				$this->Cart_model->changeStatus($cartId,'Y');
				mkdir($path, 0777, true);
				$this->html2pdf->folder($path);
				$this->html2pdf->filename($cartId.'.pdf');
				$this->html2pdf->paper('p','a4', 'en');
				$this->html2pdf->html($this->load->view('cart/budget', $data,true));
				$this->html2pdf->create('save');
			}
			 */
			//=========================================================

			unset($params);
		}
		//$this->budget($cartId);
	}
	
	public function get_photos($code,$maxW,$maxH) {
		$fotos = array();
		$filename = SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'_1.jpg';
		if (file_exists($filename)) {
		 	$foto['url'] = $filename;
		 	$imnfo = getimagesize($filename);
			$width 		= $imnfo[0];
			$height		= $imnfo[1];
			if($height>=$width){// if this image is higher than larger		
				$perc 		= $this->percentage($height,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}else {
				$perc 		= $this->percentage($width,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}
		}else{
			$foto['url'] 	= base_url('admin/public/images/product/'.$code.'_1.jpg');
		    $foto['w'] 	= $imnfo[0];
			$foto['h'] 	= $imnfo[1];
		}
		return $foto;
	}
	
	function percentage ($nCur, $nTot){
		return number_format((($nTot * 100)/$nCur),0);
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
		$config['total_rows'] = count($this->Cart_model->getList($dados));
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
		
		//$config['data_page_attr'] = '<span class="page-link">';
		
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}