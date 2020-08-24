<?php
class banner_model extends CI_Model {
	var $id 			= '';
	var $titulo			= '';
	var $chamada 		= '';
	var $dt_inserido 	= '';
	var $ativo			= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('banner', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('banner', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set()
	{
		$title							= (isset($_REQUEST['title'])?$_REQUEST['title']:'');
		$subtitle						= (isset($_REQUEST['subtitle'])?$_REQUEST['subtitle']:'');
		$ext							= (isset($_REQUEST['ext'])?$_REQUEST['ext']:'');
		$foto							= (isset($_REQUEST['imgbanner'])?$_REQUEST['imgbanner']:'');
		$active							= (isset($_REQUEST['active'])?$_REQUEST['active']:'');
		
		(isset($_REQUEST['title']))?$this->db->set('title',$title):'';
		(isset($_REQUEST['subtitle']))?$this->db->set('subtitle',$subtitle):'';
		(isset($_REQUEST['ext']))?$this->db->set('ext',$ext):'';
		$this->db->set('date_insert',date("Y-m-d H:i:s"));
		(isset($_REQUEST['imgbanner']))?$this->db->set('image',$foto):'';
		(isset($_REQUEST['active']))?$this->db->set('active',$active):'';
//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("banner");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("banner");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('banner.*');
		if(isset($dados['nome']))
			$this->db->like('banner.title',$dados['title']);
		if(isset($dados['subtitle']))
			$this->db->like('banner.subtitle',$dados['subtitle']);
		if(isset($dados['active']))
			$this->db->where('banner.active',$dados['active']);
		$this->db->order_by('id desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('banner',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('banner');
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('banner', array('id'=>$id)); 
		//print_r($this->db->last_query());die;
		if($ex){
			$msg 	= 'Banner excluído com sucesso!';
			return array(TRUE,$msg);
		}
		else
		{
		    $msgdb 	= $this->db->_error_message();
		    $num 	= $this->db->_error_number();
			$msg = 'Erro ao deletar: '.$msgdb;
			return array(FALSE,$msg);
		}
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('banner'); 
		//print_r($this->db->last_query());die;
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Banner alterado con suceso! ';
			return array(FALSE,$msg);
		}
	}	
	
	
	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
}