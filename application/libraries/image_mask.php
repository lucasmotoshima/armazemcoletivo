<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class image_mask{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
 	function getMask($params=null){
		$this->ci->load->model('config_model', '', TRUE);
		$config = $this->ci->config_model->staticGet();
		if($config['mask_ext']!='')
			$imagem = '<img src="'.base_url('admin/public/images/config/mask'.$config['mask_ext'].'').'" class="mask"/>';
		else
			$imagem = '';
  		return $imagem;
 	}
	
 	function getMask_p($params=null){
 		$this->ci->load->model('config_model', '', TRUE);
		$config = $this->ci->config_model->staticGet();
		if($config['mask_p_ext']!='')
  			return '<img src="'.base_url('admin/public/images/config/mask_p'.$config['mask_p_ext'].'').'" class="mask"/>';
		else
			return '';
 	}
	
}
?>