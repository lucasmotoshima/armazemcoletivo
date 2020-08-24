<?php
class product_industry_model extends CI_Model {
	var $fk_product			= '';
	var $fk_industry		= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('product_industry', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('product_industry', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$fk_product					= (isset($dados['fk_product'])?$dados['fk_product']:'');
		$fk_industry				= (isset($dados['fk_industry'])?$dados['fk_industry']:'');
		
		(isset($dados['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($dados['fk_industry']))?$this->db->set('fk_industry',$fk_industry):'';
		$this->db->set('active','1');
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("product_industry");
			$id = $dados['id'];
		}
		else
		{
			$ex = $this->db->insert("product_industry");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product_industry.*');
		$this->db->select('industry.code');
		$this->db->select('industry.name');
		if(isset($dados['fk_product']))
			$this->db->where('product_industry.fk_product',$dados['fk_product']);
		if(isset($dados['product_industry']))
			$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		$this->db->join('industry', 'industry.id = product_industry.fk_industry');
		$query = $this->db->get('product_industry');
		return $query->result_array();
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('product_industry'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Rubro alterado con suceso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product_industry', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Rubro borrado con suceso!';
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