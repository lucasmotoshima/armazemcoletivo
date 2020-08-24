<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Provider{
    public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->load->library('debug');
		$this->ci->load->model('Provider_model', '', TRUE);
		$this->ci->load->model('Product_provider_model', '', TRUE);
    }
 	function getTags($params=null){
		$provider = $this->ci->Provider_model->getList(array('active'=>'1'));
		$return = "<div class='providerList'>"; 
		foreach ($provider as $key => $value) {
			$return .= "<div class='tag ".(isset($value['name'])?(($value['name']==$value['id'])?'active':''):'')."'>";
			$return .= '<a href="'.base_url('product/getByProvider/'.$value['id']).'">'.$value['name'].'</a>';
			$return .= "</div>";
		}
		$return .= "</div>";
		echo $return;
 	}
}
?>
