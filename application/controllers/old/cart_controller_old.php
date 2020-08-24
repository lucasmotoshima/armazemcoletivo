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
		//==== models =====
		$this->load->model('user_model', '', TRUE);
		$this->load->model('config_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('provider_model', '', TRUE);
		$this->load->model('category_model', '', TRUE);
		$this->load->model('print_model', '', TRUE);
		$this->load->model('color_model', '', TRUE);
		$this->load->model('product_color_model', '', TRUE);
		$this->load->model('product_print_model', '', TRUE);
		$this->load->model('cart_model', '', TRUE);
		$this->load->model('cart_product_model', '', TRUE);
		$this->load->model('cart_product_m_model', '', TRUE);
		$this->load->model('industry_model', '', TRUE);
	}
	
	public function index()
	{redirect();}
	
	public function add()
	{
		$calc_total 	= $this->prod_cost->calc_total($_REQUEST);
		$ico_alert 		= '<img src="'.base_url('public/images/icones/ico_alerta.png').'">';
		$ico_conf 		= '<img src="'.base_url('public/images/icones/ico_confirmado.png').'">';
		
		$session_id = session_id();
		$product 	= $this->product_model->staticGet($_REQUEST['id']);
		$print		= $this->print_model->staticGet($_REQUEST['type_prints']);
		$color		= $this->color_model->staticGet($_REQUEST['opt_color']);
		$id 		= 'C'.$product['fk_category'].str_pad($_REQUEST['id'], 4, "0", STR_PAD_LEFT);
		
		$cart = $this->cart_model->staticGet('session_id',$session_id);
		if((count($cart)==0) or ($cart['status']!='W'))
		{
			$dados = array(
				'session_id'    => $session_id,
			    'id'      		=> $id,
			    'price'			=> $calc_total['product_original_sale_price'] + $calc_total['print_unit_total'],
			    'name'    		=> (isset($product['name']))?$product['name']:NULL,
			    'options' 		=> array('qty_colors' => $_REQUEST['qty_colors'],'type_prints' => $_REQUEST['type_prints'])
        	);
			unset($dados['id']);
			$this->cart_model->set($dados);
			$resp_cart = $this->cart_model->save($dados);
		}
		$calc_total['cart_id']	= (isset($resp_cart))?$resp_cart[1]:$cart['id'];
		if($calc_total['product_original_price']!=0){
			$this->cart_product_model->set($calc_total);
			$resp_cart_product = $this->cart_product_model->save($calc_total);
			if((isset($resp_cart)) and ($resp_cart[0]==FALSE) or ((isset($resp_cart_product)) and ($resp_cart_product[0]==FALSE)) )
			{
				$data['msg']		= $ico_alert.' Error. Cotización ya gravada.';
				$data['error']		= TRUE;
			}
			else
			{
				$base_url = base_url('cart/deleteCot/'.$resp_cart_product[1].'');
				$js = 'onclick="javascript: excluir('.$base_url.');"';
				$data['msg']		= $ico_conf.' Product agregado correctamente al presupuesto';
				$data['line']		= '<tr id=cot'.$resp_cart_product[1].'>';
				$data['line']		.= '<td>'.'P'.str_pad($product['id'], 4, "0", STR_PAD_LEFT).' - '.$product['name'].'</td>';
				$data['line']		.= '<td>'.$_REQUEST['quantity'].'</td>';
				//$data['line']		.= '<td><div id="color_box" title="'.$color['name'].'" style="background-color: '.$color['hexa'].'"></div></td>';
				$qty_color			 = $calc_total['color_quantity'];
				$label				 = (($calc_total['color_quantity']==1)?' color':' colores');
				$description		 = (($print['name']!='')?$print['name']:'sin impressión');
				
				$data['line']		.= '<td>'.$description.' - '.$qty_color.$label.'</td>';
				$data['line']		.= '</tr>';
				$data['error']		= FALSE;
			}
		}else{
			$data['msg']			= $ico_alert.' Producto Agotado!';
			$data['error']			= TRUE;
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

		header('Content-Type: application/json');
		print json_encode($data);
	}
	
	public function deleteProduct($id)
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
	
	public function save(){
		$_REQUEST['status'] = 'N';
		$this->cart_model->set($_REQUEST);
		$result_cart 			= $this->cart_model->save($_REQUEST);
		$id						= $result_cart[1];
		$cart 					= $this->cart_model->staticGet('id',$result_cart[1]);
		$params = array('fk_cart'=>$result_cart[1]);
		$cart_product			= $this->cart_product_model->getList($params);
		$ids					= array();
		foreach ($cart_product as $key => $value) {
			$product 			= $this->product_model->staticGet($value['fk_product']);
			$product_provider	= $this->product_provider_model->staticGet('fk_product',$value['fk_product']);
			$cart_product_m		= $this->cart_product_m_model->staticGet('fk_cart_product',$value['id']);
			$product_photo 		= $this->image->get_mainPhoto($product['code_origin'].'_1',145,145);
			array_push($ids, $value['id']);
			$result[$key] 		= array(
				'id'							=> $value['id'],
				'fk_cart'						=> $value['fk_cart'],
				'fk_product'					=> $value['fk_product'],
				'fk_provider'					=> $value['fk_provider'],
				'fk_print'						=> $value['fk_print'],
				'fk_color'						=> $value['fk_color'],
				'quantity'						=> $value['quantity'],
				'tax_perc'						=> $value['tax_perc'],
				'profit_perc'					=> $value['profit_perc'],
				'product_original_price'		=> $value['product_original_price'],
				'product_original_sale_price'	=> $value['product_original_sale_price'],
				'product_unit_price_old'		=> $value['product_unit_price_old'],
				'product_unit_price'			=> $value['product_unit_price'],
				'product_unit_tax'				=> $value['product_unit_tax'],
				'product_unit_profit'			=> $value['product_unit_profit'],
				'provider_discount'				=> $value['provider_discount'],
				'print_name'					=> $value['print_name'],
				'print_description'				=> $value['print_description'],
				'print_unit_price'				=> $value['print_unit_price'],
				'print_unit_tax'				=> $value['print_unit_tax'],
				'print_unit_total'				=> $value['print_unit_total'],
				'color_quantity'				=> $value['color_quantity'],
				'prod_id'						=> $value['prod_id'],
				'prod_name'						=> $value['prod_name'],
				'prod_code_origin'				=> $value['prod_code_origin'],
				'color_name'					=> $value['color_name'],
				'color_hexa'					=> $value['color_hexa'],
				'cart_product_m'				=> $cart_product_m,
				'product'						=> $product,
				'product_photo'					=> $product_photo,
				'product_provider'				=> $product_provider,
				
				'imprimido'						=> '0'
			);
		}

		$data['cart']		= $cart;

		$data['result']		= $result;
		//tenta enviar o email para o usuario
		$params['email'] 		= 'felipe@logoideas.cl';
		$params['assunto']		= 'Cotización';
		$params['nome']			= $cart['client_name'];
		
		$config = $this->config_model->staticGet();
		
		$font='style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"';
		$msg = '';
		$msg .= '<strong '.$font.'> Nombre: </strong>'.$cart['client_name'].'<br>';
		$msg .= '<strong '.$font.'> Teléfono: </strong>'.$cart['phone'].'<br>';
		$msg .= '<strong '.$font.'> Email: </strong>'.$cart['email'].'<br>';
		$msg .= '<strong '.$font.'> Empresa: </strong>'.$cart['company'].'<br>';
		$msg .= '<strong '.$font.'> Ciudad: </strong>'.$cart['ciudad'].'<br>';
		$msg .= '<strong '.$font.'> Fecha: </strong>'.$this->format_date->us2br($cart['date']).'<br>';
		$msg .= '<strong '.$font.'> Mensaje: </strong>'.$cart['obs'].'<br>';
		$msg .=
		'<img src="'.base_url('admin/public/images/config/presupuesto.jpg').'"></img>';
		//print_r($msg);die;
		$unique_products		= $this->unique_prod($cart_product);
		$unique_budget = '0';
		foreach ($unique_products as $key => $value) {
			if($unique_budget=='0'){
				$msg.= '<br>Presupuesto: #'.date('Ym').'_'.str_pad($value['id'], 4, "0", STR_PAD_LEFT);
				$unique_budget = '1';
			}
			$msg.= 
				'<table border=0 style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; width: 550px;">'.
					//'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #EB2026;">'.'Presupuesto: #'.date('Ym').'_'.str_pad($value['id'], 4, "0", STR_PAD_LEFT).'</td></tr>'.
					'<tr><td colspan="4" style="height: 5px; border-bottom:1px solid #EB2026;"></td></tr>'.
					'<tr>'.
						'<td rowspan="6" style="border:1px solid #d9d9d9; min-width: 250px; text-align: center;" align="center" width=250>'.
							'<img src="'.$result[$key]['product_photo']['url'].'" width="'.$result[$key]['product_photo']['w'].'" height="'.$result[$key]['product_photo']['h'].'">'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="2">'.
							'<strong style="color:#EB2026;font-weight:bold;">P'.str_pad($result[$key]['prod_id'], 4, "0", STR_PAD_LEFT).' - '.$result[$key]['prod_name'].'</strong>'.
							'<br>'.
							'<div style="color: #818284">'.$result[$key]['product']['description'].'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="2" style="height: 10px;">'.
						'</td>'.
					'</tr>'.
					
					'<tr>'.
						'<td>'.
							'<div style="color: #828385;">Dimensiones </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #EB2026; text-align:right;">'.
							 $result[$key]['product']['height'].' x '.
							 $result[$key]['product']['width'].' x '.
							 $result[$key]['product']['depth'].
							'</div>'.
						'</td>'.
					'</tr>'.
					
					'<tr>'.
						'<td>'.
							'<div style="color: #828385;">Fecha </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #EB2026; text-align:right;">'.$this->format_date->us2br($cart['date']).'</div>'.
						'</td>'.
					'</tr>'.
					'<tr>'.
						'<td>'.
							'<div style="color: #828385; font-weight: bold;">Tiempo de Entrega </div>'.
						'</td>'.
						'<td>'.
							'<div style="color: #EB2026;text-align:right;">'.$result[$key]['product_provider']['delivery_time'].' días'.
						'</td>'.
					'</tr>'.
				'</table>';
			 
											
				foreach ($result as $chave => $row) {
					if($result[$key]['prod_id'] == $row['prod_id']){
						
						$price_original_equal = strval(floatval($row['product_original_sale_price']));
						$price_original_equal = explode('.', $price_original_equal);
							
						$descuento_equal = strval(floatval($row['product_original_sale_price']) - floatval($row['product_unit_profit']));
						$descuento_equal = explode('.', $descuento_equal);
						
						$precio_descuento_equal = floatval($row['product_unit_profit']);
						$precio_descuento_equal = explode('.', $precio_descuento_equal);
						
						$total_equal = strval(floatval($row['product_unit_profit']) * floatval($row['quantity']));
						$total_equal = explode('.', $total_equal);
						
						
						$msg .=
						'<table border=0 style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; width: 550px;">'.
							'<tr>'.
								'<td style="height: 5px; border-bottom:1px solid #EB2026;"></td>'.
								'<td style="height: 5px; border-bottom:1px solid #EB2026;"></td>'.
							'</tr>'.
							'</tr>'.
							'<tr>'.
								'<td>'.
									'<div style="color: #828385; font-weight: bold;">Personalización </div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; text-align:right;">'.$row['print_name'].' '.$row['color_quantity'].(($row['color_quantity']>1)?' Colores':' Color').'</div>'.
								'</td>'.
							'</tr>'.
							'<tr>'.
								'<td>'.
									'<div style="color: #828385; font-weight: bold;">Cantidad </div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; font-weight: bold; text-align:right;">'.number_format($row['quantity'],0, ',', '.').'</div>'.
								'</td>'.
							'</tr>'.
							'<tr>'.
								'<td>'.
									'<div style="color: #828385; font-weight: bold;">Precio Neto Original </div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; font-weight: bold; text-align:right;"> $ '.number_format(intval($price_original_equal[0]),0, ',', '.').'</div>'.
								'</td>'.
							'</tr>'.
							'<tr>'.
								'<td>'.
									'<div style="color: #828385; font-weight: bold;">Descuento por volumen</div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; font-weight: bold; text-align:right;"> $ '.number_format(intval($descuento_equal[0]),0, ',', '.').'</div>'.
								'</td>'.
							'</tr>'.
							'<tr>'.
								'<td width="200">'.
									'<div style="color: #828385; font-weight: bold;">Precio Neto con Dscto</div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; font-weight: bold; text-align:right;"> $ '.number_format(intval($precio_descuento_equal[0]),0, ',', '.').'</div>'.
								'</td>'.
							'<tr>'.
								'<td colspan="2" style="height: 10px;">'.
								'</td>'.
							'</tr>'.
							'<tr>'.
								'<td>'.
									'<div style="color: #828385; font-weight: bold;">Total</div>'.
								'</td>'.
								'<td>'.
									'<div style="color: #EB2026; font-weight: bold; text-align:right;"> $ '.number_format(intval($total_equal[0]),0, ',', '.').'</div>'.
								'</td>'.
							'</tr>'.
						'</table>';
						$price_original_equal 		= 0;
						$descuento_equal 			= 0;
						$precio_descuento_equal	 	= 0;
						$total_equal 				= 0;
						 
					}
				}
						
			}	
		$msg.= '<i '.$font.'>Presupuesto válido por 30 días, stock sujeto a disponibilidad al momento de la compra.</i><br>';
		$msg = str_replace("%Array%", "", $msg);
		$params['msg']			= $msg;
		$enviar = $this->envia_email->enviar($params);
		session_regenerate_id();
		
		$data['erro']['msg'] = 'Presupuesto enviado correctamente!';
		$industry 						= $this->industry_model->getList();
		$data['rubros']					= $industry;
		$this->load->view('header',$data);
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}
	
	public function detail()
	{
		$cart 					= $_REQUEST = $this->cart_model->staticGet('session_id',session_id());
		if(!isset($cart['id']))
			$cart['id'] = 0;
		$params = array('fk_cart'=>$cart['id'],'status'=>'W');
		$data['result']			= $this->cart_product_model->getList($params);
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