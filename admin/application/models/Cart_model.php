<?php
class cart_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('cart', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('cart', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$id							= (isset($dados['id'])?$dados['id']:'');
		$session_id					= (isset($dados['session_id'])?$dados['session_id']:'');
		$client_name				= (isset($dados['client_name'])?$dados['client_name']:'');
		$phone						= (isset($dados['phone'])?$dados['phone']:'');
		$email						= (isset($dados['email'])?$dados['email']:'');
		$adress						= (isset($dados['adress'])?$dados['adress']:'');
		$number						= (isset($dados['number'])?$dados['number']:'');
		$city						= (isset($dados['city'])?$dados['city']:'');
		$status						= (isset($dados['status'])?$dados['status']:'');
		$obs						= (isset($dados['obs'])?$dados['obs']:'');
		
		(isset($dados['id']))?$this->db->set('id',$id):'';
		(isset($dados['session_id']))?$this->db->set('session_id',$session_id):'';
		(isset($dados['id'])or(isset($dados['session_id'])))?$this->db->set('date_change',date("Y-m-d H:i:s")):'';
		(!isset($dados['id'])and(!isset($dados['session_id'])))?$this->db->set('date',date("Y-m-d H:i:s")):'';
		(isset($dados['client_name']))?$this->db->set('client_name',$client_name):'';
		(isset($dados['phone']))?$this->db->set('phone',$phone):'';
		(isset($dados['email']))?$this->db->set('email',$email):'';
		(isset($dados['city']))?$this->db->set('city',$city):'';
		(isset($dados['adress']))?$this->db->set('adress',$adress):'';
		(isset($dados['number']))?$this->db->set('number',$number):'';
		(isset($dados['status']))?$this->db->set('status',$status):'';
		(isset($dados['obs']))?$this->db->set('obs',$obs):'';
//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("cart");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("cart");
			$id = $this->db->insert_id();
		}
		//print_r($this->db->last_query());die;
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('cart.*');
		if(isset($dados['client_name']))
			$this->db->like('cart.client_name',$dados['client_name']);
		if(isset($dados['company']))
			$this->db->like('cart.company',$dados['company']);
		if(isset($dados['phone']))
			$this->db->like('cart.phone',$dados['phone']);
		if(isset($dados['status']))
			$this->db->where('cart.status',$dados['status']);
		else {
			$this->db->where('cart.status !=','W');
		}
		$this->db->order_by('date desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('cart',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('cart');
		return $query->result_array();
	}
	
	public function getListJson($dados=null)//
	{
		$this->db->select('cart.*');
		if(isset($dados['id']))
			$this->db->where('cart.id >',$dados['id']);
		if(isset($dados['dateUpTo']))
			$this->db->where('cart.date >=',$dados['dateUpTo']);
		if(isset($dados['status_N']))
			$this->db->where('cart.status != ',$dados['status_N']);
		$this->db->order_by('date desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('cart',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('cart');
		//print_r($this->db->last_query());die;
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('cart', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Item Apagado!';
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
		$this->db->set('status',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('cart'); 
		//print_r($this->db->last_query());die;
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Carro alterado com sucesso! ';
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