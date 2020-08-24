<?php
class cart_product_m_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('cart_product_m', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('cart_product_m', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set($dados)
	{
		$fk_cart_product				= (isset($dados['fk_cart_product'])?$dados['fk_cart_product']:'');
		$product_unit_price				= (isset($dados['product_unit_price'])?$dados['product_unit_price']:'');
		$print_unit_price				= (isset($dados['print_unit_price'])?$dados['print_unit_price']:'');
		$color_quantity					= (isset($dados['color_quantity'])?$dados['color_quantity']:'');
		$product_total					= (isset($dados['product_total'])?$dados['product_total']:'');
		$profit							= (isset($dados['profit'])?$dados['profit']:'');
		$sale_total						= (isset($dados['sale_total'])?$dados['sale_total']:'');

		(isset($dados['fk_cart_product']))?$this->db->set('fk_cart_product',$fk_cart_product):'';
		(isset($dados['product_unit_price']))?$this->db->set('product_unit_price',$product_unit_price):'';
		(isset($dados['print_unit_price']))?$this->db->set('print_unit_price',$print_unit_price):'';
		(isset($dados['color_quantity']))?$this->db->set('color_quantity',$color_quantity):'';
		(isset($dados['product_total']))?$this->db->set('product_total',$product_total):'';
		(isset($dados['profit']))?$this->db->set('profit',$profit):'';
		(isset($dados['sale_total']))?$this->db->set('sale_total',$sale_total):'';

//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("cart_product_m");
			$id = $dados['id'];
		}
		else
		{
			$ex = $this->db->insert("cart_product_m");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('cart_product_m.*');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('cart_product_m',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('cart_product_m');
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('cart_product_m', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Iten Borrado!';
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
	
	public function clearString($string)
	{
	    $what = array( ' ','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    $by   = array( '_','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    return str_replace($what, $by, $string);
	}
}