<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class msg{
    public function __construct()
    {

    }
 	function show($params=null){
		if(isset($params['msg'])){
			if($params['status']==TRUE){
				$icon = base_url('public/images/icones/ico_confirmado.png');
			}else{
				$icon = base_url('public/images/icones/ico_alerta.png');
			}
		}
	
		$html = '';
		if(isset($params['msg']))
			$html .= '<div id="status" style="display: block;"><img src="'.$icon.'"> '. $params['msg'].'</div>';
		else 
			$html .= '<div id="status" style="display: none;"></div>';
  		return $html;
 	}
}
?>