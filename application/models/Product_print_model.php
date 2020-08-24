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
	
	public function set()
	{
		$fk_product					= (isset($_REQUEST['fk_product'])?$_REQUEST['fk_product']:'');
		$fk_print					= (isset($_REQUEST['fk_print'])?$_REQUEST['fk_print']:'');
		
		(isset($_REQUEST['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($_REQUEST['fk_print']))?$this->db->set('fk_print',$fk_print):'';
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
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
		$this->db->select('print.code');
		$this->db->select('print.name');
		$this->db->select('print.description');
		if(isset($dados['fk_product']))
			$this->db->where('product_print.fk_product',$dados['fk_product']);
		if(isset($dados['product_print']))
			$this->db->where('product_print.fk_print',$dados['fk_print']);
		if(isset($dados['active']))
			$this->db->like('product_print.active',$dados['active']);
		$this->db->join('print', 'product_print.fk_print = print.id');
		$this->db->order_by('fk_print asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product_print',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product_print');
		return $query->result_array();
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