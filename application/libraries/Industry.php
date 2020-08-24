<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Industry{
    public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->load->library('debug');
		$this->ci->load->model('Industry_model', '', TRUE);
    }
 	function getTags($params=null){
 		$this->ci->load->model('Industry_model', '', TRUE);
		$industry = $this->ci->Industry_model->getList(array('active'=>'1'));
		$return = "<div class='industriesList'>"; 
		foreach ($industry as $key => $value) {
			$return .= "<div class='tag ".(isset($params['industry'])?(($params['industry']==$value['id'])?'active':''):'')."'>";
			$return .= '<a href="'.base_url('product/getByIndustry/'.$value['id']).'">'.$value['name'].'</a>';
			$return .= "</div>";
		}
		$return .= "</div>";
		echo $return;
 	}
}
?>
