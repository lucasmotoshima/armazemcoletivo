<?php
class Plan_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('plan', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('plan', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$name						= (isset($dados['name'])?$dados['name']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$dt_insert					= (isset($dados['dt_insert'])?$dados['dt_insert']:'');
		$active						= (isset($dados['active'])?$dados['active']:'');
		
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['description']))?$this->db->set('description',$description):'';
		(isset($dados['dt_insert']))?$this->db->set('dt_insert',$dt_insert):'';
		(isset($dados['active']))?$this->db->set('active',$active):'';
//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("plan");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("plan");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('plan.*');
		if(isset($dados['name']))
			$this->db->where('plan.name',$dados['name']);
		$this->db->order_by('id asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('plan',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('plan');
		return $query->result_array();
	}
	
	public function excluir($id)
	{
		$ex = $this->db->delete('plan', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Plano excluído!';
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
		$ex = $this->db->update('plan'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Plano alterado com sucesso. ';
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