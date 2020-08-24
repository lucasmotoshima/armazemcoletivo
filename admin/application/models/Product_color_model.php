<?php
class product_color_model extends CI_Model {
	var $fk_product		= '';
	var $fk_color		= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('product_color', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('product_color', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$fk_product					= (isset($dados['fk_product'])?$dados['fk_product']:'');
		$fk_color					= (isset($dados['fk_color'])?$dados['fk_color']:'');
		
		(isset($dados['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($dados['fk_color']))?$this->db->set('fk_color',$fk_color):'';
//=================================================================
	}
	
	public function save()
	{
		$ex = $this->db->insert("product_color");
		$id = $this->db->insert_id();
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product_color.*');
		$this->db->select('color.code');
		$this->db->select('color.name');
		$this->db->select('color.hexa');
		if(isset($dados['fk_product']))
			$this->db->where('product_color.fk_product',$dados['fk_product']);
		if(isset($dados['product_color']))
			$this->db->where('product_color.fk_color',$dados['fk_color']);
		$this->db->join('color', 'color.id = product_color.fk_color');
		$query = $this->db->get('product_color');
		return $query->result_array();
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('product_color'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Color alterado con suceso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product_color', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Color borrado con suceso!';
			return array(TRUE,$msg);
		}
		else
		{
		    $msgdb 	= $this->db->_error_message();
		    $num 	= $this->db->_error_number();
			$msg = 'Error: '.$msgdb;
			return array(FALSE,$msg);
		}
	}
}