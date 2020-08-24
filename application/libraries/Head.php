<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class head{
    public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->load->library('debug');
    }
 	function getLogo($params=null){
		$this->ci->load->model('Config_model', '', TRUE);
		$config = $this->ci->Config_model->staticGet();
		if($config[0]['logo_ext']!='')
			$imagem = '<img src="'.base_url('admin/public/images/config/logo'.$config[0]['logo_ext'].'').'" class="logo" title="'.$config[0]['name'].'" alt="Home"/>';
		else
			$imagem = '<img src="'.base_url('admin/public/images/config/logo_nf.png').'" class="logo" title="" alt=""/>';
  		return $imagem;
 	}
	
 	function getNome($params=null){
 		$this->ci->load->model('Config_model', '', TRUE);
		$config = $this->ci->Config_model->staticGet();
		if($config[0]['name']!='')
  			return $config[0]['name'];
		else
			return 'My Project';
 	}
	
 	function getBg($params=null){
		$this->ci->load->model('Config_model', '', TRUE);
		$config = $this->ci->Config_model->staticGet();
		if($config[0]['bg_ext']!='')
			$imagem = base_url('admin/public/images/config/bg'.$config['bg_ext'].'');
		else
			$imagem = base_url('admin/public/images/config/bg_nf.jpg');
  		return $imagem;
 	}
	
 	function getNumProd(){
 		$this->ci->load->model('Cart_model', '', TRUE);
		$this->ci->load->model('Cart_product_model', '', TRUE);
		$cart 					= $this->ci->Cart_model->staticGet('session_id',session_id());
		if(!isset($cart['id']))
			$cart[0]['id'] = 0;
		$params = array('fk_cart'=>$cart[0]['id'],'status'=>'W');
		$cart_product			= $this->ci->Cart_product_model->getList($params);
  		return count($cart_product);
 	}
}
?>