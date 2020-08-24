<?php
class product_provider_model extends CI_Model {
	var $fk_product		= '';
	var $fk_provider	= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('product_provider', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('product_provider', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$fk_product					= (isset($dados['fk_product'])?$dados['fk_product']:'');
		$fk_provider				= (isset($dados['fk_provider'])?$dados['fk_provider']:'');
		$price						= (isset($dados['price'])?$dados['price']:'');
		$active						= (isset($dados['active'])?$dados['active']:'');
		$delivery_time				= (isset($dados['delivery_time'])?$dados['delivery_time']:'');
		$range1_start				= (isset($dados['range1_start'])?$dados['range1_start']:'');
		$range1_end					= (isset($dados['range1_end'])?$dados['range1_end']:'');
		$range1_price				= (isset($dados['range1_price'])?$dados['range1_price']:'');
		$range2_start				= (isset($dados['range2_start'])?$dados['range2_start']:'');
		$range2_end					= (isset($dados['range2_end'])?$dados['range2_end']:'');
		$range2_price				= (isset($dados['range2_price'])?$dados['range2_price']:'');
		$range3_start				= (isset($dados['range3_start'])?$dados['range3_start']:'');
		$range3_end					= (isset($dados['range3_end'])?$dados['range3_end']:'');
		$range3_price				= (isset($dados['range3_price'])?$dados['range3_price']:'');
		$range4_start				= (isset($dados['range4_start'])?$dados['range4_start']:'');
		$range4_end					= (isset($dados['range4_end'])?$dados['range4_end']:'');
		$range4_price				= (isset($dados['range4_price'])?$dados['range4_price']:'');
		$range5_start				= (isset($dados['range5_start'])?$dados['range5_start']:'');
		$range5_price				= (isset($dados['range5'])?$dados['range5']:'');

		(isset($dados['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($dados['fk_provider']))?$this->db->set('fk_provider',$fk_provider):'';
		(isset($dados['price']))?$this->db->set('price',$price):'';
		(isset($dados['active']))?$this->db->set('active',$active):'';
		(isset($dados['delivery_time']))?$this->db->set('delivery_time',$delivery_time):'';
		(isset($dados['range1_start']))?$this->db->set('range1_start',$range1_start):'';
		(isset($dados['range1_end']))?$this->db->set('range1_end',$range1_end):'';
		(isset($dados['range1_price']))?$this->db->set('range1_price',$range1_price):'';
		(isset($dados['range2_start']))?$this->db->set('range2_start',$range2_start):'';
		(isset($dados['range2_end']))?$this->db->set('range2_end',$range2_end):'';
		(isset($dados['range2_price']))?$this->db->set('range2_price',$range2_price):'';
		(isset($dados['range3_start']))?$this->db->set('range3_start',$range3_start):'';
		(isset($dados['range3_end']))?$this->db->set('range3_end',$range3_end):'';
		(isset($dados['range3_price']))?$this->db->set('range3_price',$range3_price):'';
		(isset($dados['range4_start']))?$this->db->set('range4_start',$range4_start):'';
		(isset($dados['range4_end']))?$this->db->set('range4_end',$range4_end):'';
		(isset($dados['range4_price']))?$this->db->set('range4_price',$range4_price):'';
		(isset($dados['range5_start']))?$this->db->set('range5_start',$range5_start):'';
		(isset($dados['range5_price']))?$this->db->set('range5_price',$range5_price):'';
//=================================================================
	}
	
	public function save()
	{
		if((isset($_REQUEST['fk_product']))and(isset($_REQUEST['fk_provider'])))
		{
			$this->db->where('fk_product',$_REQUEST['fk_product']);
			$this->db->where('fk_provider',$_REQUEST['fk_provider']);
			$ex = $this->db->update("product_provider");
		}
		else
		{
			$ex = $this->db->insert("product_provider");
		}
		return $ex;
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product_provider.*');
		if(isset($dados['fk_product']))
			$this->db->where('product_provider.fk_product',$dados['fk_product']);
		if(isset($dados['product_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['active']))
			$this->db->where('product_provider.active',$dados['active']);
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product_provider',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product_provider');
		return $query->result_array();
	}
	
	public function getListDistinctCategory($id)//
	{
		$this->db->select('product.fk_category');
		$this->db->where('provider.id',$id);
		$this->db->where('product_provider.active','1');
		$this->db->join('product', 'product.id = product_provider.fk_product');
		$this->db->join('provider', 'provider.id = product_provider.fk_provider');
		$this->db->join('category', 'category.id = product.fk_category');
		$this->db->group_by('product.fk_category');
		$query = $this->db->get('product_provider');
		//$this->debug->show($this->db->last_query(),0);
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product_provider', array('id'=>$id)); 
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