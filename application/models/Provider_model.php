<?php
class provider_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('provider', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('provider', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
  	public function getByUrl($value=null)
  	{
  		$this->db->like('provider.url_friendly',$value);
		$query = $this->db->get('provider');		
		//$this->debug->show($this->db->last_query(),0);	
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$name						= (isset($dados['name'])?$dados['name']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$active						= (isset($dados['active'])?$dados['active']:'');
		$email						= (isset($dados['email'])?$dados['email']:'');
		$web_site					= (isset($dados['web_site'])?$dados['web_site']:'');
		$phone1						= (isset($dados['phone1'])?$dados['phone1']:'');
		$phone2						= (isset($dados['phone2'])?$dados['phone2']:'');
		$fax						= (isset($dados['fax'])?$dados['fax']:'');
		$tipo_discuento				= (isset($dados['tipo_discuento'])?$dados['tipo_discuento']:'');
		$descuento					= (isset($dados['descuento'])?$dados['descuento']:'');
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
		$ext						= (isset($_REQUEST['ext'])?$_REQUEST['ext']:'');
		
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['description']))?$this->db->set('description',$description):'';
		(isset($dados['active']))?$this->db->set('active',$active):'';
		(isset($dados['email']))?$this->db->set('email',$email):'';
		(isset($dados['web_site']))?$this->db->set('web_site',$web_site):'';
		(isset($dados['phone1']))?$this->db->set('phone1',$phone1):'';
		(isset($dados['phone2']))?$this->db->set('phone2',$phone2):'';
		(isset($dados['fax']))?$this->db->set('fax',$fax):'';
		(isset($dados['tipo_discuento']))?$this->db->set('type_discount',$tipo_discuento):'';
		(isset($dados['descuento']))?$this->db->set('discount',$descuento):'';
		(isset($dados['range1_ini']))?$this->db->set('range1_start',$range1_start):'';
		(isset($dados['range1_fin']))?$this->db->set('range1_end',$range1_end):'';
		(isset($dados['range1']))?$this->db->set('range1_price',$range1_price):'';
		(isset($dados['range2_ini']))?$this->db->set('range2_start',$range2_start):'';
		(isset($dados['range2_fin']))?$this->db->set('range2_end',$range2_end):'';
		(isset($dados['range2']))?$this->db->set('range2_price',$range2_price):'';
		(isset($dados['range3_ini']))?$this->db->set('range3_start',$range3_start):'';
		(isset($dados['range3_fin']))?$this->db->set('range3_end',$range3_end):'';
		(isset($dados['range3']))?$this->db->set('range3_price',$range3_price):'';
		(isset($dados['range4_ini']))?$this->db->set('range4_start',$range4_start):'';
		(isset($dados['range4_fin']))?$this->db->set('range4_end',$range4_end):'';
		(isset($dados['range4']))?$this->db->set('range4_price',$range4_price):'';
		(isset($dados['range5_ini']))?$this->db->set('range5_start',$range5_start):'';
		(isset($dados['range5_fin']))?$this->db->set('range5_end',$range5_end):'';
		(isset($dados['range5']))?$this->db->set('range5_price',$range5_price):'';
		(isset($dados['ext']))?$this->db->set('ext',$ext):'';
//=================================================================
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("provider");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("provider");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('provider.*');
		if(isset($dados['name']))
			$this->db->like('provider.name',$dados['name']);
		if(isset($dados['tp_provider']))
			$this->db->where('provider.tp_provider',$dados['tp_provider']);
		if(isset($dados['code']))
			$this->db->where('provider.code',$dados['code']);
		if(isset($dados['phone']))
			$this->db->where('provider.phone1',$dados['phone']);
		if(isset($dados['email']))
			$this->db->like('provider.email',$dados['email']);
		if(isset($dados['chamada']))
			$this->db->like('provider.chamada',$dados['chamada']);
		if(isset($dados['active']))
			$this->db->where('provider.active',$dados['active']);
		$this->db->order_by('id desc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('provider',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('provider');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function getProvider($dados=null)//
	{
		$this->db->select('provider.*');
		if(isset($dados['code']))
			$this->db->where('provider.code',$dados['code']);
		if(isset($dados['phone']))
			$this->db->where('provider.phone1',$dados['phone']);
		if(isset($dados['email']))
			$this->db->where('provider.email',$dados['email']);
		if(isset($dados['active']))
			$this->db->where('provider.active',$dados['active']);
		$query = $this->db->get('provider',1,0);
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('provider', array('id'=>$id)); 
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
		$ex = $this->db->update('provider'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Provedor alterado con suceso! ';
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