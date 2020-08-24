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
		$code						= (isset($dados['code'])?$dados['code']:'');	
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
		$range5_price				= (isset($dados['range5_price'])?$dados['range5_price']:'');

		(isset($dados['code']))?$this->db->set('code',$code):'';
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
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("product_provider");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("product_provider");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product_provider.*');
		$this->db->select('provider.name');
		$this->db->select('provider.email');
		$this->db->select('provider.web_site');
		$this->db->select('provider.description');
		$this->db->select('provider.phone1');
		$this->db->select('provider.phone2');
		$this->db->select('provider.type_discount');
		$this->db->select('provider.discount');
		$this->db->select('provider.url_ws');
		$this->db->select('provider.ext');
		$this->db->select('provider.active as activeProductProvider');
	  	$this->db->select('provider.range1_start as range1_start_p');
	  	$this->db->select('provider.range1_end as range1_end_p');
	  	$this->db->select('provider.range1_price as range1_price_p');
	  	$this->db->select('provider.range2_start as range2_start_p');
	  	$this->db->select('provider.range2_end as range2_end_p');
	  	$this->db->select('provider.range2_price as range2_price_p');
	  	$this->db->select('provider.range3_start as range3_start_p');
	  	$this->db->select('provider.range3_end as range3_end_p');
	  	$this->db->select('provider.range3_price as range3_price_p');
	  	$this->db->select('provider.range4_start as range4_start_p');
	  	$this->db->select('provider.range4_end as range4_end_p');
	  	$this->db->select('provider.range4_price as range4_price_p');
	  	$this->db->select('provider.range5_start as range5_start_p');
	  	$this->db->select('provider.range5_price as range5_price_p');
		if(isset($dados['fk_product']))
			$this->db->where('product_provider.fk_product',$dados['fk_product']);
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['orderBy']))
			$this->db->order_by($dados['orderBy']);
		if(isset($dados['active']))
			$this->db->where('product_provider.active',$dados['active']);
		$this->db->join('provider', 'provider.id = product_provider.fk_provider');
		$query = $this->db->get('product_provider');
		return $query->result_array();
	}

	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('product_provider'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Producto alterado con suceso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product_provider', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Producto x Provedor borrado con suceso!';
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