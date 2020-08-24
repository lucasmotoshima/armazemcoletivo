<?php
class plan_model extends CI_Model {
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
	
	public function getList($dados=null)//
	{
		$this->db->select('plan.*');
		if(isset($dados['codpromocional']))
			$this->db->where('plan.codpromocional',$dados['codpromocional']);
		if(isset($dados['tp_plan']))
			$this->db->where('plan.tp_plan',$dados['tp_plan']);
		if(isset($dados['tp_cliente']))
			$this->db->like('plan.tp_cliente',$dados['tp_cliente']);
			$this->db->where('plan.active',$dados['active']);
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('plan',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('plan');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
}