<?php
class profissional_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('profissional', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('profissional', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados){
		$nome						= (isset($dados['nome'])?$dados['nome']:'');
		$fk_plan					= (isset($dados['fk_plan'])?$dados['fk_plan']:'');
		$namepage					= (isset($dados['namepage'])?$dados['namepage']:'');
		$url_friendly				= (isset($dados['url_friendly'])?$dados['url_friendly']:'');
		$codigo						= (isset($dados['codigo'])?$dados['codigo']:'');
		$especialidades				= (isset($dados['especialidades'])?$dados['especialidades']:'');
		$diasemana					= (isset($dados['diasemana'])?$dados['diasemana']:'');
		$hrinicio					= (isset($dados['hrinicio'])?$dados['hrinicio']:'');
		$qtdeatendimentos			= (isset($dados['qtdeatendimentos'])?$dados['qtdeatendimentos']:'');
		$tempoconsulta				= (isset($dados['tempoconsulta'])?$dados['tempoconsulta']:'');
		$intervalo					= (isset($dados['intervalo'])?$dados['intervalo']:'');
		$sexo						= (isset($dados['sexo'])?$dados['sexo']:'');
		$tel1						= (isset($dados['tel1'])?$dados['tel1']:'');
		$tel2						= (isset($dados['tel2'])?$dados['tel2']:'');
		$email						= (isset($dados['email'])?$dados['email']:'');
		$rua						= (isset($dados['rua'])?$dados['rua']:'');
		$numero						= (isset($dados['numero'])?$dados['numero']:'');
		$estado						= (isset($dados['estado'])?$dados['estado']:'');
		$cidade						= (isset($dados['cidade'])?$dados['cidade']:'');
		$ativo						= (isset($dados['ativo'])?$dados['ativo']:'');
		$imagem						= (isset($dados['imagem'])?$dados['imagem']:'');
		$description				= (isset($dados['description'])?$dados['description']:'');
		$obs						= (isset($dados['obs'])?$dados['obs']:'');
		
		(isset($dados['nome']))?$this->db->set('nome',$nome):'';
		(isset($dados['fk_plan']))?$this->db->set('fk_plan',$fk_plan):'';
		(isset($dados['namepage']))?$this->db->set('namepage',$namepage):'';
		(isset($dados['url_friendly']))?$this->db->set('url_friendly',$url_friendly):'';
		(isset($dados['codigo']))?$this->db->set('codigo',$codigo):'';
		(isset($dados['diasemana']))?$this->db->set('diasemana',$diasemana):'';
		(isset($dados['especialidades']))?$this->db->set('especialidades',$especialidades):'';
		(isset($dados['hrinicio']))?$this->db->set('hrinicio',$hrinicio):'';
		(isset($dados['qtdeatendimentos']))?$this->db->set('qtdeatendimentos',$qtdeatendimentos):'';
		(isset($dados['tempoconsulta']))?$this->db->set('tempoconsulta',$tempoconsulta):'';
		(isset($dados['intervalo']))?$this->db->set('intervalo',$intervalo):'';
		(isset($dados['sexo']))?$this->db->set('sexo',$sexo):'';
		(isset($dados['tel1']))?$this->db->set('tel1',$tel1):'';
		(isset($dados['tel2']))?$this->db->set('tel2',$tel2):'';
		(isset($dados['email']))?$this->db->set('email',$email):'';
		(isset($dados['email']))?$this->db->set('emailmd5',md5($email)):'';
		(isset($dados['rua']))?$this->db->set('rua',$rua):'';
		(isset($dados['numero']))?$this->db->set('numero',$numero):'';
		(isset($dados['estado']))?$this->db->set('estado',$estado):'';
		(isset($dados['cidade']))?$this->db->set('cidade',$cidade):'';
		(isset($dados['ativo']))?$this->db->set('ativo',$ativo):'';
		(isset($dados['imagem']))?$this->db->set('imagem',$imagem):'';
		(isset($dados['description']))?$this->db->set('description',$description):'';
		(isset($dados['obs']))?$this->db->set('obs',$obs):'';
	}
	
	public function save()
	{
		if(isset($_REQUEST['id']))
		{
			$this->db->where('id',$_REQUEST['id']);
			$ex = $this->db->update("profissional");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("profissional");
			$id = $this->db->insert_id();
		}
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('profissional.*');
		if(isset($dados['url_friendly']))
			$this->db->where('profissional.url_friendly',$dados['url_friendly']);
		if(isset($dados['especialidades']))
			$this->db->like('profissional.especialidades',$dados['especialidades']);
		if(isset($_SESSION['armazem']['user']['uf']))
			$this->db->where('profissional.estado',$_SESSION['armazem']['user']['uf']);
		if(isset($dados['email']))
			$this->db->where('profissional.email',$dados['email']);		
		if(isset($dados['ativo']))
			$this->db->where('profissional.ativo',$dados['ativo']);
		if((isset($dados['maximo']))and(isset($dados['inicio'])))
			$query = $this->db->get('profissional',$dados['maximo'],$dados['inicio']);
		else
			$query = $this->db->get('profissional');
		//$this->debug->show($this->db->last_query());
		return $query->result_array();
	}
	
	public function changeStatus($id,$status)
	{
		$this->db->set('ativo',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('profissional'); 
		//$this->debug->show($this->db->last_query());
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Profisisonal alterado con sucesso! ';
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