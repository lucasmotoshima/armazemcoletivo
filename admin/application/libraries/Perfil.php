<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class perfil{
    public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->load->library('debug');
		$this->ci->load->model('User_model', '', TRUE);
    }
 	function getFoto($id){
 		$this->ci->load->model('User_model', '', TRUE);
		$usuario = $this->ci->User_model->staticGet($id);
		$mask = base_url('assets/images/user/mask.gif');
    	if($usuario[0]['ext']!=''){
    		$img = base_url('public/images/user').'/'.$usuario[0]['id'].$usuario[0]['ext'];
    	}else{
    		$img = base_url('public/images/user/default.gif');
    	}
		if($mask==false)
 			$imagem 	 = '<img src="'.$img.'" class="ft_perfil" class="img-circle profile_img"/>';
		else
		{
			$imagem 	 = '<img src="'.$img.'" class="ft_perfil" class="img-circle profile_img" "/>';
		}
		return $imagem;
 	}
	
 	function getFotoUrl($id){
		$user = $this->ci->User_model->staticGet($id);
		$mask = base_url('assets/images/user/mask.gif');
    	if($user[0]['ext']!=''){
    		$img = base_url('public/images/user').'/'.$user[0]['id'].$user[0]['ext'];
    	}else{
    		$img = base_url('public/images/user/default.gif');
    	}
		if($mask==false)
 			$imagem 	 = $img;
		else
		{
			$imagem 	 = $img;
		}
		return $imagem;
 	}
	
 	function getNome($id){
 		$this->ci->load->model('User_model', '', TRUE);
		$usuario = $this->ci->User_model->staticGet($id);
		
		return $usuario[0]['name'];
 	}
	
}
?>
