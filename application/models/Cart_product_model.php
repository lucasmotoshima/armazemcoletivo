<?php
class cart_product_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();

  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('Cart_product', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('Cart_product', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$fk_cart					= (isset($dados['fk_cart'])?$dados['fk_cart']:'');
		$fk_product					= (isset($dados['fk_product'])?$dados['fk_product']:'');
		$fk_provider				= (isset($dados['fk_provider'])?$dados['fk_provider']:'');
		$quantity					= (isset($dados['quantity'])?$dados['quantity']:'');
		$tax_perc					= (isset($dados['tax_perc'])?$dados['tax_perc']:'');
		$profit_perc				= (isset($dados['profit_perc'])?$dados['profit_perc']:'');
		$product_unit_price			= (isset($dados['product_unit_price'])?$dados['product_unit_price']:'');
		$product_total_price		= (isset($dados['product_total_price'])?$dados['product_total_price']:'');

		(isset($dados['fk_cart']))?$this->db->set('fk_cart',$fk_cart):'';
		(isset($dados['fk_product']))?$this->db->set('fk_product',$fk_product):'';
		(isset($dados['fk_provider']))?$this->db->set('fk_provider',$fk_provider):'';
		(isset($dados['quantity']))?$this->db->set('quantity',$quantity):'';
		(isset($dados['tax_perc']))?$this->db->set('tax_perc',$tax_perc):'';
		(isset($dados['profit_perc']))?$this->db->set('profit_perc',$profit_perc):'';
		(isset($dados['product_unit_price']))?$this->db->set('product_unit_price',$product_unit_price):'';
		(isset($dados['product_total_price']))?$this->db->set('product_total_price',$product_total_price):'';

//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("cart_product");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("cart_product");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('cart_product.*');
		$this->db->select('product.id as prod_id');
		$this->db->select('product.name as prod_name');
		$this->db->select('product.description as prod_description');
		$this->db->select('product.code_origin as prod_code_origin');
		$this->db->select('cart.date');
		//$this->db->select('color.name as color_name');
		//$this->db->select('color.hexa as color_hexa');
		if(isset($dados['id']))
			$this->db->where('cart.id >',$dados['id']);
		if(isset($dados['session_id']))
			$this->db->where('cart_product.session_id',$dados['session_id']);
		if(isset($dados['fk_cart']))
			$this->db->where('cart_product.fk_cart',$dados['fk_cart']);
		if(isset($dados['fk_product']))
			$this->db->where('cart_product.fk_product',$dados['fk_product']);
		if(isset($dados['fk_provider']))
			$this->db->where('cart_product.fk_provider',$dados['fk_provider']);
		if(isset($dados['status_N']))
			$this->db->where('cart.status !=',$dados['status_N']);
		if(isset($dados['dateUpTo']))
			$this->db->where('cart.date >=',$dados['dateUpTo']);
		$this->db->order_by('cart_product.id desc');
		$this->db->join('product', 'product.id = cart_product.fk_product');
		$this->db->join('cart', 'cart.id = cart_product.fk_cart');
		//$this->db->join('color', 'color.id = cart_product.fk_color');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('cart_product',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('cart_product');
		//s$this->debug->show($this->db->last_query());
		return $query->result_array();
	}

	public function getListDistinctProvider($dados=null)//
	{
		$this->db->select('cart_product.*');
		$this->db->select('product.id as prod_id');
		$this->db->select('product.name as prod_name');
		$this->db->select('product.code_origin as prod_code_origin');
		if(isset($dados['fk_cart']))
			$this->db->where('fk_cart',$dados['fk_cart']);
		$this->db->join('product', 'product.id = cart_product.fk_product');
		$this->db->distinct();
		$query = $this->db->get('cart_product');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('cart_product', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Item Excluído!';
			return array(TRUE,$msg);
		}
		else
		{
		    $msgdb 	= $this->db->_error_message();
		    $num 	= $this->db->_error_number();
			$msg = 'Error al deletar: '.$msgdb;
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