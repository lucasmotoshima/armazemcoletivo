<?php
class product_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('product', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('product', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function getList($dados=null)
	{
		$this->db->select('product.*');
		$this->db->select('category.name as category_name');
		$this->db->select('product_provider.fk_provider as fk_provider');
		if(isset($dados['name']))
			$this->db->like('product.name',$dados['name']);
		if(isset($dados['search'])){
			$this->db->like('product.description',$dados['search']);
			$this->db->or_like('product.name',$dados['search']);
		}
		if(isset($dados['id'])and(count($dados['id'])>0))
			$this->db->where_in('product.id',$dados['id']);
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		//$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['uf']))
			$this->db->where('provider.uf',$dados['uf']);
		if(isset($dados['localidade']))
			$this->db->like('provider.city',$dados['localidade']);
		if(isset($_SESSION['armazem']['categoryList']))
			$this->db->where_in('category.id',$_SESSION['armazem']['categoryList']);
		$this->db->where('product.active','1');
		$this->db->where('category.active','1');
		$this->db->where('provider.active','1');
		$this->db->join('category', 'category.id = product.fk_category');
		$this->db->join('product_provider', 'product_provider.fk_product = product.id');
		$this->db->join('provider', 'provider.id = product_provider.fk_provider');
		$this->db->order_by('rand()');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product');
		//$this->debug->show($this->db->last_query(),0);
		return $query->result_array();
	}
	
	public function getListThumb($dados=null)//
	{
		$this->db->select('product.*');
		$this->db->select('category.name as category_name');
		$this->db->select('product_provider.fk_provider as fk_provider');
		if(isset($dados['name']))
			$this->db->like('product.name',$dados['name']);
		if(isset($dados['search'])){
			$this->db->like('product.description',$dados['search']);
			$this->db->or_like('product.name',$dados['search']);
		}
		if(isset($dados['id'])and(count($dados['id'])>0))
			$this->db->where_in('product.id',$dados['id']);
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		//$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['uf']))
			$this->db->where('provider.uf',$dados['uf']);
		if(isset($dados['localidade']))
			$this->db->like('provider.city',$dados['localidade']);
		$this->db->where('product.active','1');
		$this->db->where('category.active','1');
		$this->db->where('provider.active','1');
		$this->db->join('category', 'category.id = product.fk_category');
		$this->db->join('product_provider', 'product_provider.fk_product = product.id');
		$this->db->join('provider', 'provider.id = product_provider.fk_provider');
		$this->db->order_by('rand()');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function getListProvider($dados=null)//
	{
		$this->db->select('product.*');
		$this->db->select('category.name as category_name');
		$this->db->select('product_provider.fk_provider');
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['name']))
			$this->db->like('product.name',$dados['name']);
		if(isset($dados['search'])){
			$this->db->like('product.description',$dados['search']);
			$this->db->or_like('product.name',$dados['search']);
		}
		if(isset($dados['id'])and(count($dados['id'])>0))
			$this->db->where_in('product.id',$dados['id']);
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		if(isset($dados['fk_industry']))
			$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		if(isset($dados['active']))
			$this->db->where('product.active',$dados['active']);
		if(isset($_SESSION['armazem']['categoryList']))
			$this->db->where_in('category.id',$_SESSION['armazem']['categoryList']);
		$this->db->where('category.active','1');
		$this->db->where('product.active','1');
		$this->db->join('category', 'category.id = product.fk_category');
		if(isset($dados['fk_provider']))
			$this->db->join('product_provider', 'product_provider.fk_product = product.id');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function getListRubro($dados=null)//
	{
		$this->db->select('product.*');
		$this->db->select('category.name as category_name');
		$this->db->select('product_industry.fk_industry as fk_industry');
		$this->db->select('product_provider.fk_provider as fk_provider');
		if(isset($dados['fk_industry']))
			$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		if(isset($dados['name']))
			$this->db->like('product.name',$dados['name']);
		if(isset($dados['search'])){
			$this->db->like('product.description',$dados['search']);
			$this->db->or_like('product.name',$dados['search']);
		}
		if(isset($dados['id'])and(count($dados['id'])>0))
			$this->db->where_in('product.id',$dados['id']);
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		if(isset($dados['fk_industry']))
			$this->db->where('product_industry.fk_industry',$dados['fk_industry']);
		if(isset($dados['fk_provider']))
			$this->db->where('product_provider.fk_provider',$dados['fk_provider']);
		$this->db->where('category.active','1');
		$this->db->where('product.active','1');
		$this->db->where('provider.active','1');
		$this->db->join('category', 'category.id = product.fk_category');
		$this->db->join('product_provider', 'product_provider.fk_product = product.id');
		$this->db->join('provider', 'provider.id = product_provider.fk_provider');
		if(isset($dados['fk_industry']))
			$this->db->join('product_industry', 'product_industry.fk_product = product.id');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('product',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('product');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function getPrev($dados=null)//
	{
		$query = array();
		$this->db->select('product.*');
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		if(isset($dados['active']))
			$this->db->where('product.active',$dados['active']);
		$this->db->where('product.id <',$dados['id']);
		$this->db->order_by('id desc');
		$query = $this->db->get('product',$dados['maximo']);
		return $query->result_array();
	}
	
	public function getNext($dados=null)//
	{
		$query = array();
		$this->db->select('product.*');
		if(isset($dados['fk_category']))
			$this->db->where('product.fk_category',$dados['fk_category']);
		if(isset($dados['active']))
			$this->db->where('product.active',$dados['active']);
		$this->db->where('product.id >',$dados['id']);
		$query = $this->db->get('product',$dados['maximo']);
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('product', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Provedor borrado!';
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
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('product'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Producto alterado con suceso! ';
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