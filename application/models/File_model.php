<?php
class file_model extends CI_Model {
	var $id 			= '';
	var $name			= '';
	var $ext 			= '';
	var $date_upload 	= '';
	var $date_sync		= '';
	var $sync_st		= '';
	var $active			= '';
	var $description	= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('file', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('file', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set()
	{
		$name							= (isset($_REQUEST['name'])?$_REQUEST['name']:'');
		$ext							= (isset($_REQUEST['ext'])?$_REQUEST['ext']:'');
		$date_upload					= (isset($_REQUEST['date_upload'])?$_REQUEST['date_upload']:'');
		$date_sync						= (isset($_REQUEST['date_sync'])?$_REQUEST['date_sync']:'');
		$sync_st						= (isset($_REQUEST['sync_st'])?$_REQUEST['sync_st']:'');
		$description					= (isset($_REQUEST['description'])?$_REQUEST['description']:'');
		
		(isset($_REQUEST['name']))?$this->db->set('name',$name):'';
		(isset($_REQUEST['ext']))?$this->db->set('ext',$ext):'';
		$this->db->set('date_upload',date("Y-m-d H:i:s"));
		(isset($_REQUEST['date_sync']))?$this->db->set('date_sync',$date_sync):'';
		(isset($_REQUEST['sync_st']))?$this->db->set('sync_st',$sync_st):'';
		(isset($_REQUEST['description']))?$this->db->set('description',$description):'';
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("file");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("file");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('file.*');
		if(isset($dados['nome']))
			$this->db->like('file.name',$dados['name']);
		if(isset($dados['subtitle']))
			$this->db->like('file.description',$dados['description']);
		if(isset($dados['sync_st']))
			$this->db->where('file.sync_st',$dados['sync_st']);
		if(isset($dados['active']))
			$this->db->where('file.active',$dados['active']);
		$this->db->order_by('id desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('file',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('file');
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('file', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Archivo borrado con suceso!';
			return array(TRUE,$msg);
		}
		else
		{
		    $msgdb 	= $this->db->_error_message();
		    $num 	= $this->db->_error_number();
			$msg = 'Error ao deletar: '.$msgdb;
			return array(FALSE,$msg);
		}
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('file'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Archivo alterado con suceso! ';
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