<?php
class industry_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('industry', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('industry', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function getList($dados=null)//
	{
		$this->db->select('industry.*');
		if(isset($dados['name']))
			$this->db->like('industry.name',$dados['name']);
		$this->db->order_by('name asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('industry',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('industry');
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('industry', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Categoria borrada!';
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
		$ex = $this->db->update('industry'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Categoria alterada con suceso! ';
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