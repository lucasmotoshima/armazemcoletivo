<?php
class product_print_model extends CI_Model {
	var $fk_product		= '';
	var $fk_print		= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('product_print', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('product_print', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set($dados)
	{
		$fk_product					= (isset($dados['fk_product'])?$dados['fk_product']:'');
		$fk_print					= (isset($dados['fk_print'])?$dados['fk_print']:'');
		
		(isset($dados['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($dados['fk_print']))?$this->db->set('fk_print',$fk_print):'';
//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("product_print");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("product_print");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product_print.*');
		$this->db->select('print.name');
		$this->db->select('print.description');
		$this->db->select('print.qty_limit');
		$this->db->select('print.amount_limit');
		$this->db->select('print.qty_max_color');
		if(isset($dados['fk_product']))
			$this->db->where('product_print.fk_product',$dados['fk_product']);
		if(isset($dados['product_print']))
			$this->db->like('product_print.fk_print',$dados['fk_print']);
		if(isset($dados['active']))
			$this->db->like('product_print.active',$dados['active']);
		$this->db->join('print', 'print.id = product_print.fk_print');
		$query = $this->db->get('product_print');
		return $query->result_array();
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('product_print'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Tipo de Impresión alterado con suceso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product_print', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Impresión borrado con suceso!';
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