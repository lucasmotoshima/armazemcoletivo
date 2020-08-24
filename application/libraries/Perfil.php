<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Perfil{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
 	function getFoto($id){
 		$this->ci->load->model('usuario_model', '', TRUE);
		$usuario = $this->ci->usuario_model->staticGet($id);
		
		$mask = base_url('public/images/usuarios/mask.gif');
    	if($usuario['ext']!=''){
    		$img = base_url('public/images/usuarios').'/'.$usuario['id'].$usuario['ext'];
    	}else{
    		$img = base_url('public/images/usuarios/default.gif');
    	}
		if($mask==false)
 			$imagem 	 = '<img src="'.$img.'" class="ft_perfil"/>';
		else
		{
			$imagem 	 = '<img src="'.$img.'" class="ft_perfil"/>';
		}
		return $imagem;
 	}
}
?>
