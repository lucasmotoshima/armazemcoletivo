<?php
class industry_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('industry', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('industry', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$code						= (isset($dados['code'])?$dados['code']:'');
		$name						= (isset($dados['name'])?$dados['name']:'');
		
		(isset($dados['code']))?$this->db->set('code',$code):'';
		(isset($dados['name']))?$this->db->set('name',$name):'';
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("industry");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("industry");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getLastId()
	{
		$this->db->select('industry.*');
		$this->db->order_by('id desc');
		$query = $this->db->get('industry','1','0');
		return $query->result_array();
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('industry.*');
		if(isset($dados['code']))
			$this->db->where('industry.code',$dados['code']);
		if(isset($dados['name']))
			$this->db->like('industry.name',$dados['name']);
		$this->db->order_by('code desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('industry',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('industry');
		return $query->result_array();
	}
	
	public function excluir($id)
	{
		$ex = $this->db->delete('industry', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Rubro borrado!';
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