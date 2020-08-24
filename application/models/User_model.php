<?php
class User_model extends CI_Model {
	var $id					='';
	var $name				='';
	var $email				='';
	var $email_md5			='';
	var $password			='';
	var $birthday			='';
	var $phone				='';
	var $city				='';
	var $province			='';
	var $country			='';
	var $active				='';
	var $ext				='';
	var $type				='';
	var $obs				='';
	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();

  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null)
		 	$query = $this->db->get_where('user', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('user', array($pk=>$pkValue));
    	return array_shift($query->result_array());
  	}

  	public function getLastId()
  	{
    	return mysql_insert_id();//$obj->id;
  	}

	public function doLogin() {
		$this->db	->select('*')
					->from('user')
					->where('email', $this->email)
					->where('password',$this->password)
					->where('active','1');
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			$this->registerLoginSession(array_shift($query->result_array()));
			return true;
		} else {
			return false;
		}
	}

	public function checkLogin() {
		if (isset($_SESSION['adm_promotions']['user']['id'])) {//possui conteudo na session?
			$this->id 		= $this->id != null ? $this->id : $_SESSION['adm_promotions']['user']['id'];
			$this->email 	= $this->email != null ? $this->email : $_SESSION['adm_promotions']['user']['email'];
			$this->password 	= $this->senha != null ? $this->password : $_SESSION['adm_promotions']['user']['password'];
		}
		return $this->doLogin();
	}

	public function registerLoginSession($resultado) {
		$_SESSION['adm_promotions']['user']['id'] 			= $resultado['id'];
		$_SESSION['adm_promotions']['user']['name'] 		= $resultado['name'];
		$_SESSION['adm_promotions']['user']['email'] 		= $resultado['email'];
		$_SESSION['adm_promotions']['user']['password'] 	= $resultado['password'];
		$_SESSION['adm_promotions']['user']['type'] 		= $resultado['type'];
	}
	
	public function set($dados)
	{
		$name							= (isset($dados['name'])?$dados['name']:'');
		$email							= (isset($dados['email'])?$dados['email']:'');
		$email_md5						= (isset($dados['email'])?md5($dados['email']):'');
		$password						= (isset($dados['password'])?$dados['password']:'');
		$birthday						= (isset($dados['birthday'])?$dados['birthday']:'');
		$phone							= (isset($dados['phone'])?$dados['phone']:'');
		$city							= (isset($dados['city'])?$dados['city']:'');
		$province						= (isset($dados['province'])?$dados['province']:'');
		$country						= (isset($dados['country'])?$dados['country']:'');
		$active							= (isset($dados['active'])?$dados['active']:'');
		$ext							= (isset($dados['ext'])?$dados['ext']:'');
		$type							= (isset($dados['type'])?$dados['type']:'');
		$obs							= (isset($dados['obs'])?$dados['obs']:'');
		
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['email']))?$this->db->set('email',$email):'';
		(isset($dados['email']))?$this->db->set('email_md5',$email_md5):'';
		(isset($dados['password']))?$this->db->set('password',$password):'';
		(isset($dados['birthday']))?$this->db->set('birthday',$this->format_date->br2us($birthday)):'';
		(isset($dados['phone']))?$this->db->set('phone',$phone):'';
		(isset($dados['city']))?$this->db->set('city',$city):'';
		(isset($dados['province']))?$this->db->set('province',$province):'';
		(isset($dados['country']))?$this->db->set('country',$country):'';
		(isset($dados['active']))?$this->db->set('active',$active):'';
		(isset($dados['ext']))?$this->db->set('ext',$ext):'';
		(isset($dados['type']))?$this->db->set('type',$type):'';
		(isset($dados['obs']))?$this->db->set('obs',$obs):'';
	}

	public function gravar()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("user");
			$id = $_REQUEST['id'];
		}
		else
		{
			$password						= (isset($_REQUEST['password'])?md5($_REQUEST['password']):'');
			$this->db->set('password',$password);
			$ex = $this->db->insert("user");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}

	public function deletar($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete())
			return true;
		else {
			return false;
		}
	}
	
	public function changePass($id,$password)
	{
		$this->db->set('password',$password);
		$this->db->where('id',$id);
		$ex = $this->db->update('user');
		if($ex==TRUE)
			return TRUE;
		else
			return FALSE;
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('user'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Status de usuario ha cambiado con suceso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function getList($dados=null)
	{
		if(isset($dados['name']))
			$this->db->like('usuario.name',$dados['name']);
		if(isset($dados['active']))
			$this->db->where('user.active',$dados['active']);
		$this->db->order_by('name asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('user',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('user');
		return $query->result_array();
	}

	public function excluir($id)
	{
		$ex = $this->db->delete('user', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Usuario borrado con suceso!';
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

	public function buscar($dados=null)
	{
		if(isset($dados['busca']))
		{
			$this->db->like('name',$_REQUEST['busca']);
			$this->db->like('email',$_REQUEST['busca']);
		}
		$query = $this->db->get('user');
		return $query->result_array();
	}
	
	public function countBuscar($dados=null)
	{
		if(isset($dados['busca']))
			$this->db->like('name',$_REQUEST['busca']);
		if(isset($dados['busca']))
			$this->db->like('email',$_REQUEST['busca']);
		$this->db->from('user');
		return $this->db->count_all_results();
	}
	
}