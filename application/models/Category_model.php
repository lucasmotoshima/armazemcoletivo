<?php
class category_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('category', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('category', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$name						= (isset($dados['name'])?$dados['name']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$active						= (isset($dados['active'])?$dados['active']:'');
		$ext						= (isset($dados['ext'])?$dados['ext']:'');
		/*
		$range1_start				= (isset($dados['range1_start'])?$dados['range1_start']:'');
		$range1_end					= (isset($dados['range1_end'])?$dados['range1_end']:'');
		$range1_price				= (isset($dados['range1'])?$dados['range1']:'');
		$range2_start				= (isset($dados['range2_start'])?$dados['range2_start']:'');
		$range2_end					= (isset($dados['range2_end'])?$dados['range2_end']:'');
		$range2_price				= (isset($dados['range2'])?$dados['range2']:'');
		$range3_start				= (isset($dados['range3_start'])?$dados['range3_start']:'');
		$range3_end					= (isset($dados['range3_end'])?$dados['range3_end']:'');
		$range3_price				= (isset($dados['range3'])?$dados['range3']:'');
		$range4_start				= (isset($dados['range4_start'])?$dados['range4_start']:'');
		$range4_end					= (isset($dados['range4_end'])?$dados['range4_end']:'');
		$range4_price				= (isset($dados['range4'])?$dados['range4']:'');
		$range5_start				= (isset($dados['range5_start'])?$dados['range5_start']:'');
		$range5_end					= (isset($dados['range5_end'])?$dados['range5_end']:'');
		$range5_price				= (isset($dados['range5'])?$dados['range5']:'');
		 */
		 
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['description']))?$this->db->set('description',$description):'';
		$this->db->set('date_insert',date("Y-m-d H:i:s"));
		(isset($dados['active']))?$this->db->set('active',$active):'';
		(isset($dados['ext']))?$this->db->set('ext',$ext):'';
		/*
		(isset($dados['range1_start']))?$this->db->set('range1_start',$range1_start):'';
		(isset($dados['range1_end']))?$this->db->set('range1_end',$range1_end):'';
		(isset($dados['range1']))?$this->db->set('range1_price',$range1_price):'';
		(isset($dados['range2_start']))?$this->db->set('range2_start',$range2_start):'';
		(isset($dados['range2_end']))?$this->db->set('range2_end',$range2_end):'';
		(isset($dados['range2']))?$this->db->set('range2_price',$range2_price):'';
		(isset($dados['range3_start']))?$this->db->set('range3_start',$range3_start):'';
		(isset($dados['range3_end']))?$this->db->set('range3_end',$range3_end):'';
		(isset($dados['range3']))?$this->db->set('range3_price',$range3_price):'';
		(isset($dados['range4_start']))?$this->db->set('range4_start',$range4_start):'';
		(isset($dados['range4_end']))?$this->db->set('range4_end',$range4_end):'';
		(isset($dados['range4']))?$this->db->set('range4_price',$range4_price):'';
		(isset($dados['range5_start']))?$this->db->set('range5_start',$range5_start):'';
		(isset($dados['range5_end']))?$this->db->set('range5_end',$range5_end):'';
		(isset($dados['range5']))?$this->db->set('range5_price',$range5_price):'';
		 */
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("category");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("category");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('category.*');
		if(isset($dados['name']))
			$this->db->like('category.name',$dados['name']);
		if(isset($dados['subtitle']))
			$this->db->like('category.description',$dados['description']);
		if(isset($dados['active']))
			$this->db->where('category.active',$dados['active']);
		$this->db->order_by('name asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('category',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('category');
		//$this->debug->show($this->db->last_query(),0);
		return $query->result_array();
	}
	
	public function getRand($dados=null)//
	{
		$this->db->select('category.*');
		if(isset($dados['name']))
			$this->db->like('category.name',$dados['name']);
		if(isset($dados['subtitle']))
			$this->db->like('category.description',$dados['description']);
		if(isset($dados['active']))
			$this->db->where('category.active',$dados['active']);
		$this->db->order_by('Rand()');
		$this->db->limit(1);
		$query = $this->db->get('category');
		//$this->debug->show($this->db->last_query(),0);
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('category', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Categoria borrada!';
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
		$ex = $this->db->update('category'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Categoria alterada con suceso! ';
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