<?php
class color_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('color', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('color', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set($dados)
	{
		$code						= (isset($dados['code'])?$dados['code']:'');
		$name						= (isset($dados['name'])?$dados['name']:'');
		$hexa						= (isset($dados['hexa'])?$dados['hexa']:'');
		
		(isset($dados['code']))?$this->db->set('code',$code):'';
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['hexa']))?$this->db->set('hexa',$hexa):'';
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("color");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("color");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('color.*');
		if(isset($dados['code']))
			$this->db->where('color.code',$dados['code']);
		if(isset($dados['name']))
			$this->db->like('color.name',$dados['name']);
		$this->db->order_by('code desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('color',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('color');
		return $query->result_array();
	}
	
	public function excluir($id)
	{
		$ex = $this->db->delete('color', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Color borrada!';
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
		$ex = $this->db->update('color'); 
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