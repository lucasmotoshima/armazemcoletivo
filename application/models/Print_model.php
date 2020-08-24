<?php
class print_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('print', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('print', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}
	
	public function set($dados)
	{
		$code						= (isset($dados['code'])?$dados['code']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$qty_limit					= (isset($dados['qty_limit'])?$dados['qty_limit']:'');
		$amount_limit				= (isset($dados['amount_limit'])?$dados['amount_limit']:'');
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
		(isset($dados['description']))?$this->db->set('description',$description):'';
		(isset($dados['qty_limit']))?$this->db->set('qty_limit',$qty_limit):'';
		(isset($dados['amount_limit']))?$this->db->set('amount_limit',$amount_limit):'';
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
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("print");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("print");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('print.*');
		if(isset($dados['code']))
			$this->db->where('print.code',$dados['code']);
		$this->db->order_by('id asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('print',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('print');
		print_r($this->db->last_query());
		return $query->result_array();
	}
	
	public function excluir($id)
	{
		$ex = $this->db->delete('print', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Tipo de Impresión borrado!';
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
		$ex = $this->db->update('print'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Tipo de impresión alterados con suceso! ';
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