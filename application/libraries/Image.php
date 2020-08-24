<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class image {
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
	public function index()
	{}
	
    public function thumb_generate($dados)
    {
		$config_thumb['image_library'] 	= 'GD';
		$config_thumb['source_image'] 	= $dados['path'];
		$config_thumb['create_thumb'] 	= TRUE;
		$config_thumb['maintain_ratio'] = TRUE;
		$config_thumb['width'] 			= $dados['width'];
		$config_thumb['height'] 		= $dados['height'];
		
		$this->load->library('image_lib', $config_thumb);
		$this->image_lib->initialize($config_thumb);
		if($this->image_lib->resize())
			return true;
		else
			return false;
	}
	
    public function crop($dados)
    {
		$config['image_library'] 		= 'imagemagick';
		$config['library_path'] 		= '/usr/X11R6/bin/';
		$config['source_image'] 		= $dados['path'];
		$config['width'] 				= $dados['width'];
		$config['height'] 				= $dados['height'];
		
		$this->image_lib->initialize($config);
		if (!$this->image_lib->crop())
		    return false;
		else
			return true;
	}

	public function get_mainPhoto($code,$w,$h)
	{
		$fotoList 	= array();
		$filename 	= SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'.jpg';
		if (file_exists($filename)){
			$photo				= $this->resize($code,$w,$h);
			$foto['path'] 		= $filename;
			$foto['url'] 		= base_url('public/images/product/'.$code.'.jpg');
			$foto['h'] 			= $photo['h'];
			$foto['w'] 			= $photo['w'];
		}
		else{
			$foto['path'] 		= '#';
			$foto['url'] 		= base_url('public/images/product/default.gif');
		    $foto['w'] 			= $w;
			$foto['h'] 			= $h;
		}
		return $foto;
	}
	
 	function getBannerUrl($id){
 		$this->ci->load->model('Banner_model', '', TRUE);
		$banner = $this->ci->Banner_model->staticGet($id);
    	if($banner[0]['image']!=''){
    		$img = base_url('public/images/banner').'/'.$banner[0]['image'];
    	}else{
    		$img = base_url('public/images/banner/default.jpg');
    	}
 		$imagem 	 = $img;
		return $imagem;
 	}
	
 	function getProviderUrl($id){
 		$this->ci->load->model('Provider_model', '', TRUE);
		$provider = $this->ci->Provider_model->staticGet($id);
    	if($provider[0]['image']!=''){
    		$img = base_url('public/images/provider').'/'.$provider[0]['image'];
    	}else{
    		$img = base_url('public/images/provider/default.gif');
    	}
 		$imagem 	 = $img;
		return $imagem;
 	}
	

	function get_listPhotos($code,$w,$h) {
		$fotoList 	= array();
		for ($i=1; $i <= 4; $i++) {
			$filename 	= SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'_'.$i.'.jpg';
			if (file_exists($filename)){
				$photo					= $this->resize($code.'_'.$i,$w,$h);
				$fotoList[$i]['path'] 		= $filename;
				$fotoList[$i]['url'] 		= base_url('admin/public/images/product/'.$code.'_'.$i.'.jpg');
				$fotoList[$i]['download'] 	= base_url('admin/product/download/'.$code.'/'.$i);
				$fotoList[$i]['h'] 			= $photo['h'];
				$fotoList[$i]['w'] 			= $photo['w'];
			}
		}
		return $fotoList;
	}

	public function resize($code,$maxW,$maxH) {
		$filename 	= base_url('admin/public/images/product/'.$code.'.jpg');
		$path 		= SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'.jpg';
		//$this->ci->debug->show($path);
		 	$foto['url'] 	= $filename;
			$foto['path'] 	= $path;
		 	$imnfo 			= @getimagesize($path);
			$width 			= $imnfo[0];
			$height			= $imnfo[1];
			if($height>=$width){// if this image is higher than larger	
				$perc 		= $this->percentage($height,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}else {
				$perc 		= $this->percentage($width,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}
		return $foto;
	}

	public function resizeFunc($image,$maxW,$maxH) {
 		//$this->ci->load->model('Funcionario_model', '', TRUE);
		//$funcionario = $this->ci->Funcionario_model->staticGet($id);
		print_r(base_url('assets/images/user').'/'.$image);
    	if($image!=''){
    		//$img 				= base_url('assets/images/funcionario').'/'.$funcionario[0]['id'].$funcionario[0]['ext'];
			//$path				= SYS_IMAGE_PATH."funcionario".DIRECTORY_SEPARATOR.$id.$funcionario[0]['ext'];
			$img 				= base_url('public/images/user').'/'.$image ;
			$path 				= SYS_IMAGE_PATH."/user/".$image.'.gif'; 
    	}else{
    		$img 				= base_url('public/images/user/default.gif');
			$path 				= SYS_IMAGE_PATH."user/default.gif";
    	}
		if (file_exists($path)){
			$foto['path'] 		= $path;
			$foto['img'] 		= $img;
			$imnfo 				= @getimagesize($path);
			$width 				= $imnfo[0];
			$height				= $imnfo[1];
			if($height>=$width){// if this image is higher than larger	
				//$this->ci->debug->show($imnfo,false);
				$perc 		= $this->percentage($height,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}else {
				$perc 		= $this->percentage($width,$maxH);
				$foto['h'] 	= $height*($perc/100);
				$foto['w'] 	= $width*($perc/100);
			}
		}else{
			print_r('erro');
		}
		return $foto;
	}
	
	public function get_type($file_type){
		switch ($file_type) {
			case 'image/jpeg':
				$return = 'jpg';
				break;
			case 'image/jpg':
				$return = 'jpg';
				break;
			case 'image/gif':
				$return = 'gif';
				break;
			case 'image/png':
				$return = 'png';
				break;
			
			default:
				$return = '';
				break;
		}
		return $return;
		
	}
	
	function percentage ($nCur, $nTot){
		return number_format((($nTot * 100)/(($nCur==0)?1:$nCur)),0);
	}

}