<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		$calc_print_cost 	= $this->calc_print_cost($dados);
	 	$calc_sale_profit 	= $this->calc_sale_profit($dados);
    	$config 		= $this->ci->config_model->staticGet();
		$data = array(
//==============================================================================
    public function calc_prod_cost($dados)
		$product 	= $this->ci->product_model->staticGet($dados['id']);
		$params = array('fk_product'=>$dados['id'],'active'=>'1');
					case '1': //desconto por PRODUTO
					case '2': //desconto ÚNICO
					case '3': //desconto por PROVEDOR
					case '4': //desconto por WEB SERVICE
						}
					default:
						break;
				}
		}
		$product_provedor_id 				= $prod['fk_provider'];
		$data = array(
//==============================================================================
		$print_unit_price 		= $this->calc_price_print($dados);
	private function calc_price_print($dados){
		}
//==============================================================================
	private function calc_val_gain($dados,$amount=null){
	
				$aux[$i] = $prod[$i]['price'];
		if(isset($aux)){
			$return = array(
		}
//$val = $params['total'];