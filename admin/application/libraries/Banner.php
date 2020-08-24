<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
 	function show(){
		$this->ci->load->model('banner_model', '', TRUE);
		$dados 	= array('ativo'=>'Y','maximo'=>'5','inicio'=>'0');
		$banner = $this->ci->banner_model->listar($dados);
		$result = '<div id="banners">';
		$caminho = base_url('admin/public/images/banners/').'/';
		foreach($banner as $index => $row):
	        $result .= '<a href="'.$row['link'].'"><img src="'.$caminho.$row['id'].$row['ext'].'"/></a>';
        endforeach;
     	$result .= '</div>';
	 	return $result;
	}
}

