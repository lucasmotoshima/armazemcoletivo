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
    	return array_shift($query->result_array());
  	}
	
	public function set()
	{
		$fk_product					= (isset($_REQUEST['fk_product'])?$_REQUEST['fk_product']:'');
		$fk_color					= (isset($_REQUEST['fk_color'])?$_REQUEST['fk_color']:'');
		
		(isset($_REQUEST['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($_REQUEST['fk_color']))?$this->db->set('fk_color',$fk_color):'';
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("product_color");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("product_color");
			$id = $this->db->insert_id();
		}
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
		if(isset($dados['active']))
			$this->db->where('product_color.active',$dados['active']);
		$this->db->join('color', 'product_color.fk_color = color.id');
		$this->db->order_by('fk_color asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product_color',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product_color');
		return $query->result_array();
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