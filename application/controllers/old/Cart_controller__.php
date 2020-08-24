<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart_controller extends CI_Controller
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
		$this->load->library('banner');
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		$this->load->library('pagination');
		$this->load->library('prod_cost');
		$this->load->library('email');
		$this->load->library('image');
		$this->load->library('industry');
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
		$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Cart_model', '', TRUE);
		$this->load->model('Cart_product_model', '', TRUE);
		$this->load->model('Cart_product_m_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
	}
	
	public function index()
	{redirect();}
	
	public function verificaProdutor(){
		$cart_id 				= $this->Cart_model->staticGet(session_id());
		$params					= array('fk_cart'=>((isset($cart_id[0]['id']))?$cart_id[0]['id']:''));
		$cartProdutList 		= $this->Cart_product_model->getListDistinctProvider($params);
		return $cartProdutList;
		
	}
	
	public function add()
	{
		$fk_provider 			= $this->verificaProdutor();
		
		$session_id 			= session_id();
		$ico_alert 				= '<img src="'.base_url('public/images/icones/ico_alerta.png').'">';
		$ico_conf 				= '<img src="'.base_url('public/images/icones/ico_confirmado.png').'">';
		
		$product 				= $this->Product_model->staticGet($_REQUEST['id']);
		
		$product_provider 		= $this->Product_provider_model->staticGet('fk_product',$product[0]['id']);
		//$this->debug->show($product_provider[0]['fk_provider']);
		
		if($product_provider[0]['fk_provider'] == ((isset($fk_provider[0]['fk_provider']))?$fk_provider[0]['fk_provider']:$product_provider[0]['fk_provider'])){
			$provider 				= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			$product[0]['price'] 	= $product_provider[0]['price'];
			$id 					= 'C'.$product[0]['fk_category'].str_pad($_REQUEST['id'], 4, "0", STR_PAD_LEFT);
			$cart 					= $this->Cart_model->staticGet('session_id',$session_id);
			if(!isset($cart[0]['id'])){
					$dados = array('session_id' => $session_id);
				$this->Cart_model->set($dados);
				$resp_cart = $this->Cart_model->save($dados);
			}
			$dados = $params = array(
				'fk_cart' 			=> (isset($resp_cart[1])?$resp_cart[1]:$cart[0]['id']),
				'fk_product' 		=> $product[0]['id'],
				'fk_provider'		=> $product_provider[0]['fk_provider'],
				'quantity'			=> $_REQUEST['quantity'],
				);
			unset($params['quantity']);
			unset($params['fk_provider']);			
			$cart_productList = $this->Cart_product_model->getList($params);
			//$this->debug->show($cart_productList);
			$tot = 0;
			if(count($cart_productList)>0){
				foreach ($cart_productList as $key => $value) {
					$tot = $tot + $value['quantity'];
					$this->Cart_product_model->delete($value['id']);
				}
				$tot = $tot + $_REQUEST['quantity'];
			}
			$params['quantity'] 			= ($tot!=0)?$tot:$_REQUEST['quantity'];
			$params['tax_perc']				= $provider[0]['tax'];
			$params['profit_perc']			= (($provider[0]['tax']/100) * $product[0]['price'])*$params['quantity'];
			$params['product_unit_price']	= $product[0]['price'];
			$params['product_total_price']	= $product[0]['price']*$params['quantity'];
			$params['fk_provider'] 			= $dados['fk_provider'];
			$this->Cart_product_model->set($params);
			$resp_cart_product = $this->Cart_product_model->save($params);
	
			if((isset($resp_cart)) and ($resp_cart[0]==FALSE) or ((isset($resp_cart_product)) and ($resp_cart_product[0]==FALSE)) )
			{
				$data['msg']		= $ico_alert.' Erro. Produto gravado.';
				$data['error']		= TRUE;
			}
			else
			{
				$base_url 				= base_url('cart/deleteCot/'.$resp_cart_product[1].'');
				$js 					= 'onclick="javascript: excluir('.$base_url.');"';
				$data['msg']			= $ico_conf.' Produto adicionado ao carrinho';
				$data['line']			= '<tr id=cot'.$resp_cart_product[1].'>';
				$data['line']			.= '<td>'.'P'.str_pad($product[0]['id'], 4, "0", STR_PAD_LEFT).' - '.$product[0]['name'].'<small> '.$product[0]['description'].'</small>'.'</td>';
				$data['line']			.= '<td>'.$_REQUEST['quantity'].'</td>';
				$data['line']			.= '<td>'.'R$ '.$params['product_unit_price'].'</td>';
				//$data['line']			.= '<td><div id="color_box" title="'.$color['name'].'" style="background-color: '.$color['hexa'].'"></div></td>';
				//$qty_color			 	= $calc_total['color_quantity'];
				//$label				 	= (($calc_total['color_quantity']==1)?' color':' colores');
				//$description		 	= (($print[0]['name']!='')?$print[0]['name']:'sin impressión');
				
				$data['line']			.= '</tr>';
				$data['error']			= FALSE;
			}
			unset($qty_color);
			unset($label);
			unset($calc_total);
			unset($cart);
			unset($dados);
			unset($product);
			unset($print);
			unset($color);
			unset($id);
		}else{
			$data['msg']		= 'Você possui um carrinho aberto. Finalize a compra aberta para iniciar outra, por favor.';
			$data['error']		= TRUE;
		}
		header('Content-Type: application/json');
		print json_encode($data);
	}
	
	public function getPedidos(){
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$data = array();
		if(isset($_REQUEST['email'])){
			if($_REQUEST['email']!=''){
				$params 				= array('email'=>$_REQUEST['email'],'phone'=>$_REQUEST['phone'],'code'=>$_REQUEST['code'],'active'=>'1');
				$provider 				= $this->Provider_model->getProvider($params);
				$data['provider'] 		= $provider;
				//$this->debug->show($provider);
				if($data['provider'][0]['id']!=''){
					$cartParams				= array('status_N'=>'W','fk_provider'=>(($provider[0]['id']=='')?'*':$provider[0]['id']),'dateUpTo'=>date('Y-m-d', strtotime('-7 days')));
					$cart_product			= $this->Cart_product_model->getList($cartParams);
					$deliveryTime 			= 0;
					if($cart_product[0]['id']!=''){
						foreach ($cart_product as $key => $value) {
							$cart 							= $this->Cart_model->staticGet('id',$value['fk_cart']);
							$product 						= $this->Product_model->staticGet($value['fk_product']);
							$product_provider				= $this->Product_provider_model->staticGet('fk_product',$product[0]['id']);
							$product_photo		 			= $this->image->get_mainPhoto($value['prod_code_origin'].'_1',145,145);
							$deliveryTime		 			= ($deliveryTime <= $product_provider[0]['delivery_time'])?$product_provider[0]['delivery_time']:$deliveryTime;
							$result[$key] 					= array(
								'id'							=> $value['id'],
								'cart_status'					=> $cart[0]['status'],
								'fk_cart'						=> $cart[0]['id'],
								'fk_product'					=> $cart_product[0]['fk_product'],
								'fk_provider'					=> $product_provider[0]['fk_provider'],
								'deliveryTime'					=> $deliveryTime,
								'quantity'						=> $value['quantity'],
								'client_name'					=> $cart[0]['client_name'],
								'client_date'					=> substr($this->format_date->us2br($cart[0]['date']), 0,10) ,
								'client_hour'					=> substr($this->format_date->us2br($cart[0]['date']), 10,6) ,
								'client_adress'					=> $cart[0]['adress'],
								'client_number'					=> $cart[0]['number'],
								'client_city'					=> $cart[0]['city'],
								'client_email'					=> $cart[0]['email'],
								'client_phone'					=> $cart[0]['phone'],
								'prod_id'						=> $value['prod_id'],
								'prod_name'						=> $value['prod_name'],
								'prod_code_origin'				=> $value['prod_code_origin'],
								'product_unit_price'			=> $product[0]['price'],
								'product_total_price'			=> $value['quantity'] * $product[0]['price'],
								'product'						=> $product,
								'product_photo'					=> $product_photo,
								'product_provider'				=> $product_provider
								);
							$data['result'] = $result;
							$data['msg']					="Fornecedor encontrado.";
						}
					}else{
						$result								= array();
						$data['msg']						="Nenhum pedido encontrado";
					}
				}else{
					$data['msg']							 ="Cadastro não encontrado.";
				}
			}
		}else{
			$data['msg']						="Bem vindo ao Armazém Coletivo.<br>Aqui você poderá ver todos seus pedidos dos últimos 7 dias.";
		}
		//$this->debug->show($data['msg']);
		$params = array(
			'controller'		=>'pedidos',
			'function'			=>'list',
			'meta_title'		=>'Meus Pedidos - Armazém Coletivo',
			'meta_description'	=>'Confira seus pedidos dos últimos 7 dias e deixe os seus pedidos organizados de acordo com o status de cada um.',
			'meta_url'			=>base_url('cart/getPedidos')
			);
		$this->load->view('header',$params);
		$this->load->view('cart/pedidos',$data);
		$this->load->view('footer');
	}
	
	public function getPedidosJson(){
		$_REQUEST['lastId']; //lastCardId
		$_REQUEST['ProviderId'];
		$provider 				= $this->Provider_model->staticGet($_REQUEST['ProviderId']);
		$cartParams				= array('id'=>$_REQUEST['lastId'],'status_N'=>'W','fk_provider'=>(($_REQUEST['ProviderId']=='')?'*':$_REQUEST['ProviderId']),'dateUpTo'=>date('Y-m-d'));
		$cart_product			= $this->Cart_product_model->getList($cartParams);		
		if(count($cart_product)>0){
			$data['status'] = '1';
		}else{
			$data['status'] = '0';
		}
			
		header('Content-Type: application/json');
		print json_encode($data);
	}
	
	public function getTermoUso(){
		$this->load->view('header');
		$this->load->view('cart/termo_de_uso');
		$this->load->view('footer');
	}
	
	public function getTermoPrivacidade(){
		$this->load->view('header');
		$this->load->view('cart/privacidade');
		$this->load->view('footer');
	}
	
	public function deleteProduct($id)
	{
		$res = $this->Cart_product_model->delete($id);
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
	
	public function save(){
		$cart					= $this->Cart_model->staticGet(session_id());
		$_REQUEST['status'] 	= 'N';
		$_REQUEST['id'] 		= $cart[0]['id'];
		$this->Cart_model->set($_REQUEST);
		$result_cart 			= $this->Cart_model->save($_REQUEST);
		$cart					= $this->Cart_model->staticGet(session_id());
		$params 				= array('fk_cart'=>$cart[0]['id']);
		$cart_product			= $this->Cart_product_model->getList($params);
		
		foreach ($cart_product as $key => $value) {
			$product 						= $this->Product_model->staticGet($value['fk_product']);
			$product_provider				= $this->Product_provider_model->staticGet('fk_product',$product[0]['id']);
			$provider						= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			$product_photo		 			= $this->image->get_mainPhoto($value['prod_code_origin'].'_1',145,145);
			$result[$key] 					= array(
				'id'							=> $value['id'],
				'fk_cart'						=> $cart[0]['id'],
				'fk_product'					=> $cart_product[0]['fk_product'],
				'fk_provider'					=> $product_provider[0]['id'],
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
		$params['assunto']		= 'Carrinho de Compras - id:'.$cart[0]['id'];
		$params['nome']			= $cart[0]['client_name'];
		
		$config = $this->Config_model->staticGet();
		//$this->debug->show($cart,1);
		$font='style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"';
		$msg = '';
		$msg .= '<strong '.$font.'> Nome: </strong>'.$cart[0]['client_name'].'<br>';
		$msg .= '<strong '.$font.'> Telefone: </strong>'.$cart[0]['phone'].'<br>';
		$msg .= '<strong '.$font.'> E-mail: </strong>'.$cart[0]['email'].'<br>';
		$msg .= '<strong '.$font.'> Endereço: </strong>'.$cart[0]['adress'].$cart[0]['number'].'-'.$cart[0]['city'].'<br>';
		$msg .= '<strong '.$font.'> Data: </strong>'.$this->format_date->us2br($cart[0]['date']).'<br>';
		$msg .= '<strong '.$font.'> Mensagem: </strong>'.$cart[0]['obs'].'<br>';
		$msg .=
		'<img src="'.base_url('admin/public/images/config/presupuesto.jpg').'"></img>';
		
		$msg.= '<br>Pedido: #'.date('dmY').'_'.str_pad($cart[0]['id'], 4, "0", STR_PAD_LEFT);
		$pos = strpos($cart[0]['client_name'], ' ');
		$msgWhatsApp = 'Oi,%20aqui%20é%20'.substr($cart[0]['client_name'], 0,$pos).',%20fiz%20uma%20compra%20no%20%2AArmazém%20Coletivo%2A';
		$msgWhatsApp.= '%20%28'.date('dmY').'_'.str_pad($cart[0]['id'], 4, "0", STR_PAD_LEFT).'%29%0D';
		$enderecoWhatsApp = '%0AEntrega%3A%20'.$cart[0]['adress'].'%2C'.$cart[0]['number'].'-'.$cart[0]['city'].'%0D';
		$totGeral = 0;
		
		foreach ($cart_product as $key => $value) {
			$msgWhatsApp .= '%0A'.$result[$key]['prod_name'].'%20%28'.number_format($value['quantity'],0, ',', '.').'xR%24'.number_format(floatval($value['product_unit_price']),2, ',', '.').'%29%20%3D%20R%24'.(number_format(floatval(($value['product_unit_price']*$value['quantity'])),2, ',', '.')).'%0A';
			$msg.= 
				'<table border=0 style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; width: 550px;">'.
					//'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #616161;">'.'Presupuesto: #'.date('Ym').'_'.str_pad($value['id'], 4, "0", STR_PAD_LEFT).'</td></tr>'.
					'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #616161;"></td></tr>'.
					'<tr>'.
						'<td rowspan="6" style="border:1px solid #d9d9d9; min-width: 250px; text-align: center;" align="center" width=250>'.
							'<img src="'.$result[$key]['product_photo']['url'].'" width="'.$result[$key]['product_photo']['w'].'" height="'.$result[$key]['product_photo']['h'].'">'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="2">'.
							'<strong style="color:#616161;font-weight:bold;">'.$result[$key]['prod_name'].'<small> '.$result[$key]['product'][0]['description'].'</small>'.' <small>('.$result[$key]['prod_code_origin'].')</small>'.'</strong>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Data </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #616161; text-align:right;">'.$this->format_date->us2br($cart[0]['date']).'</div>'.
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
					'<div style="color: #828385; font-weight: bold;">Total</div>'.
				'</td>'.
				'<td colspan="2">'.
					'<div style="color: #616161; font-weight: bold; text-align:right;"> R$ '.number_format(floatval($totGeral),2, ',', '.').'</div>'.
				'</td>'.
			'</tr>';
			$msgWhatsApp .= '%2ATOTAL%3A%2A%20R%24'.number_format(floatval($totGeral),2, ',', '.'); 
		$msg.= '</table>';
		$msg.= '<i '.$font.'></i><br>';
		$msg = str_replace("%Array%", "", $msg);
		$params['msg']			= $msg;
		//$enviar = $this->envia_email->enviar($params);
		//print_r($params['msg']);
		session_regenerate_id();
		//$this->debug->show($params['msg'],1);
		if(date('H') >= 17 or date('H') < 7 or date('W')==0){
			$mensagem = 'Estamos fora do horário de atendimento. Seu pedido foi repassado diretamente ao produtor.';
		}else{
			$mensagem = 'Em instantes entraremos em contato com você pelo telefone '. $cart[0]['phone']. ' para confirmar seu pedido.';
		}
		$data['erro']['msg'] = 'Obrigado por comprar com a gente. Seu carrinho enviado com sucesso!<br>'.$mensagem;
		//$industry 						= $this->industry_model->getList();
		//=============================================
		$telProvider = str_replace(array('(',')',' '), array('','',''), $provider[0]['phone1']);
	    $redir_to = "https://wa.me/55$telProvider?text=".$msgWhatsApp.$enderecoWhatsApp;
		//$this->debug->show($redir_to);
	    //GRAVAR O CONTADOR PARA $redir_to EM BD OU txt conforme seu caso
	    header("Location: $redir_to");
		//echo '<script type="text/javascript">window.open('.$redir_to.');</script>';
		//$this->debug->show($redir_to);
		//=============================================
		//$this->load->view('header',$data);
		//$this->load->view('msg',$data);
		//$this->load->view('footer');
	}
	
	public function detail()
	{
		$cart 					= $_REQUEST = $this->Cart_model->staticGet('session_id',session_id());
		if(!isset($cart[0]['id']))
			$cart[0]['id'] = 0;
		$params = array('fk_cart'=>$cart[0]['id'],'status'=>'W');
		$data['result']			= $this->Cart_product_model->getList($params);
		$this->load->view('header');
		$this->load->view('cart/detail',$data);
		$this->load->view('footer');
	}
	
		private function unique_prod($vector)
		{
			$x = array();
			foreach ($vector as $key => $value) {
				$x[$key] = $value['fk_product'];
			}
			return array_unique($x);
		}
	
}