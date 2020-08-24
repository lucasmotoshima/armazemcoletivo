<?php
class Product_model extends CI_Model {
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
	
	public function set($dados)
	{
		$code_origin				= (isset($dados['code_origin'])?$dados['code_origin']:'');		
		$name						= (isset($dados['name'])?$dados['name']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$height						= (isset($dados['height'])?$dados['height']:'');
		$width						= (isset($dados['width'])?$dados['width']:'');
		$depth						= (isset($dados['depth'])?$dados['depth']:'');
		$active						= (isset($dados['active'])?$dados['active']:'');
		$qty_min					= (isset($dados['qty_min'])?$dados['qty_min']:'');
		$validity					= (isset($dados['validity'])?$dados['validity']:'');
		$price						= (isset($dados['price'])?$dados['price']:'');
		$fk_category				= (isset($dados['fk_category'])?$dados['fk_category']:'');
		$fk_industry				= (isset($dados['fk_industry'])?$dados['fk_industry']:'');
		$fk_file					= (isset($dados['fk_file'])?$dados['fk_file']:'');
		
		(isset($dados['code_origin']))?$this->db->set('code_origin',$code_origin):'';
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['description']))?$this->db->set('description',$description):'';
		(isset($dados['height']))?$this->db->set('height',$height):'';
		(isset($dados['width']))?$this->db->set('width',$width):'';
		(isset($dados['depth']))?$this->db->set('depth',$depth):'';
		(isset($dados['active']))?$this->db->set('active',$active):'';
		(isset($dados['qty_min']))?$this->db->set('qty_min',$qty_min):'';
		(isset($dados['validity']))?$this->db->set('validity',$validity):'';
		(isset($dados['price']))?$this->db->set('price',$price):'';
		(isset($dados['fk_category']))?$this->db->set('fk_category',$fk_category):'';
		(isset($dados['fk_industry']))?$this->db->set('fk_industry',$fk_industry):'';
		(isset($dados['fk_file']))?$this->db->set('fk_file',$fk_file):'';
//=================================================================
	}
	
	public function save($dados)
	{
		
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("product");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("product");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('product.*');
		$this->db->select('category.id as category_id');
		$this->db->select('category.name as category_name');
		if(isset($dados['fk_category']) and $dados['fk_category']!=null)
			$this->db->where('product.fk_category',$dados['fk_category']);
		if(isset($dados['name']))
			$this->db->like('product.name',$dados['name']);
		if(isset($dados['active']))
			$this->db->where('product.active',$dados['active']);
		if(isset($dados['search']))
		{
			if(is_numeric(ltrim(preg_replace("/[^0-9\s]/", "", $dados['search']), "0")))
			{
				$this->db->where('(category.id',ltrim(preg_replace("/[^0-9\s]/", "", $dados['search']), "0"));
				$this->db->or_where('product.id',ltrim(preg_replace("/[^0-9\s]/", "", $dados['search']), "0"));
				//$this->db->bracket('close','where');
				$this->db->group_end();
			}
			else
			{
				$this->db->like('(product.name',$dados['search']);
				$this->db->or_like('category.name',$dados['search']);
				$this->db->or_like('product.description',$dados['search']);
				$this->db->or_like('product.code_origin',$dados['search']);
				//$this->db->bracket('close','like');
				$this->db->group_end();
			}
			$this->db->join('category', 'category.id = product.fk_category');
			$this->db->order_by('id desc');
			$query = $this->db->get('product');
		}
		else
		{
			$this->db->join('category', 'category.id = product.fk_category');
			$this->db->order_by('id desc');
			if((isset($dados['maximo']))and(isset($dados['inicio'])))
				$query = $this->db->get('product',$dados['maximo'],$dados['inicio']);
			else
				$query = $this->db->get('product');
		}
		//print_r($this->db->last_query());die;
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