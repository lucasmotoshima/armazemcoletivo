<?php
class lead_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('lead', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('lead', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set($dados)
	{
		//print_r($dados);
		$name 				= (isset($dados['name'])?$dados['name']:'');
		$phone 				= (isset($dados['phone'])?$dados['phone']:'');
		$email 				= (isset($dados['email'])?$dados['email']:'');
		$adress 			= (isset($dados['adress'])?$dados['adress']:'');
		$adressnumber 		= (isset($dados['adressnumber'])?$dados['adressnumber']:'');
		$adressneighborhood = (isset($dados['adressneighborhood'])?$dados['adressneighborhood']:'');
		$adressprovince 	= (isset($dados['adressprovince'])?$dados['adressprovince']:'');
		$adresscity 		= (isset($dados['adresscity'])?$dados['adresscity']:'');
		$tpservice 			= (isset($dados['tpservice'])?$dados['tpservice']:'');
		$obs 				= (isset($dados['obs'])?$dados['obs']:'');
		
		
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['phone']))?$this->db->set('phone',$phone):'';
		(isset($dados['email']))?$this->db->set('email',$email):'';
		(isset($dados['adress']))?$this->db->set('adress',$adress):'';
		(isset($dados['adressnumber']))?$this->db->set('adressnumber',$adressnumber):'';
		(isset($dados['adressneighborhood']))?$this->db->set('adressneighborhood',$adressneighborhood):'';
		(isset($dados['adressprovince']))?$this->db->set('adressprovince',$adressprovince):'';
		(isset($dados['adresscity']))?$this->db->set('adresscity',$adresscity):'';
		(isset($dados['tpservice']))?$this->db->set('tpservice',$tpservice):'';
		(isset($dados['obs']))?$this->db->set('obs',$obs):'';
		
	
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("lead");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("lead");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('lead.*');
		if(isset($dados['code']))
			$this->db->where('lead.code',$dados['code']);
		$this->db->order_by('id asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('lead',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('lead');
		print_r($this->db->last_query());
		return $query->result_array();
	}
	
	public function excluir($id)
	{
		$ex = $this->db->delete('lead', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Tipo de Impresión borrado!';
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
		$ex = $this->db->update('lead'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Tipo de impresión alterados con suceso! ';
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