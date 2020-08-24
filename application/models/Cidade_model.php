<?php
class cidade_model extends CI_Model {
	var $id					='';
	var $nome				='';
	var $descricao			='';
	var $rua				='';
	var $numero				='';
	var $complemento		='';
	var $uf					='';
	var $cep				='';
	var $subregiao			='';
	var $ativo				='';
	var $lat				='';
	var $long				='';
	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();

  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null)
		 	$query = $this->db->get_where('cidade', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('cidade', array($pk=>$pkValue));
        //print_r($this->db->last_query());
    	return $query->result_array();
  	}

  	public function getLastId()
  	{
    	return mysql_insert_id();//$obj->id;
  	}

	public function set($dados)
	{
		$id										= (isset($dados['id'])?$dados['id']:'');
		$nome									= (isset($dados['nome'])?$dados['nome']:'');
		$descricao								= (isset($dados['descricao'])?$dados['descricao']:'');
		$uf										= (isset($dados['uf'])?$dados['uf']:'');
		$subregiao								= (isset($dados['subregiao'])?$dados['subregiao']:'');
		$ativo							   		= (isset($dados['ativo'])?$dados['ativo']:'');
		$lat				        			= (isset($dados['lat'])?$dados['lat']:'');
		$long				        			= (isset($dados['long'])?$dados['long']:'');
		
		(isset($dados['id']))?$this->db->set('id',$id):'';
		(isset($dados['nome']))?$this->db->set('nome',$nome):'';
		(isset($dados['descricao']))?$this->db->set('descricao',$descricao):'';
		(isset($dados['uf']))?$this->db->set('uf',$uf):'';
		(isset($dados['subregiao']))?$this->db->set('subregiao',$subregiao):'';
		(isset($dados['ativo']))?$this->db->set('ativo',$ativo):'';
		(isset($dados['lat']))?$this->db->set('lat',$lat):'';
		(isset($dados['long']))?$this->db->set('long',$long):'';
		
	}

	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("cidade");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("cidade");
			$id = $this->db->insert_id();
		}
		//print_r($this->db->last_query());die;
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
	
	public function changePass($id,$senha)
	{
		$this->db->set('senha',$senha);
		$this->db->where('id',$id);
		$ex = $this->db->update('cidade');
		if($ex==TRUE)
			return TRUE;
		else
			return FALSE;
	}
	
	public function changeStatus($id,$status)
	{
		$registro =  $this->staticGet($id);
		$this->db->set('ativo',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('cidade'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Funcionário <strong>'.$registro[0]['nome'].' '.(($status=='0')?'desativado':'ativado').'</strong> com sucesso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function getList($dados=null)
	{
		//$this->debug->show($dados);
		if(isset($dados['nome']))
			$this->db->like('cidade.nome',$dados['nome']);
		if(isset($dados['uf']))
			$this->db->where('cidade.uf',$dados['uf']);

		if(isset($dados['tipoOr'])){
			$this->db->where('tipo',$dados["tipo1"]);
			$this->db->or_where('tipo',$dados["tipo2"]);
		}
		$this->db->order_by('nome asc');
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('cidade',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('cidade');
		//print_r($this->db->last_query());
		return $query->result_array();
	}

	public function excluir($id)
	{
		$ex = $this->db->delete('cidade', array('id'=>$id)); 
		if($ex){
			$msg 	= 'cidade excluído con sucesso!';
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
		$query = $this->db->get('cidade');
		return $query->result_array();
	}
	
	public function countBuscar($dados=null)
	{
		if(isset($dados['busca']))
			$this->db->like('name',$_REQUEST['busca']);
		if(isset($dados['busca']))
			$this->db->like('email',$_REQUEST['busca']);
		$this->db->from('cidade');
		return $this->db->count_all_results();
	}
	
	public function clearCPF($string)
	{
	    $what = array( ' ','.','-');
	    $by   = array( '','','');
	    return str_replace($what, $by, $string);
	}
	
}