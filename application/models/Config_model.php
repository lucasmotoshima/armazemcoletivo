<?php
class config_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();

	
  	public function staticGet()
  	{
		$query = $this->db->get_where('config');
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		$name								= (isset($dados['name'])?$dados['name']:'');
		$email_admin						= (isset($dados['email_admin'])?$dados['email_admin']:'');
		$logo_ext							= (isset($dados['logo_ext'])?$dados['logo_ext']:'');
		$bg_ext								= (isset($dados['bg_ext'])?$dados['bg_ext']:'');
		$range1								= (isset($dados['range1'])?$dados['range1']:'');
		$range1_ini							= (isset($dados['range1_ini'])?$dados['range1_ini']:'');
		$range1_fin							= (isset($dados['range1_fin'])?$dados['range1_fin']:'');
		$range2								= (isset($dados['range2'])?$dados['range2']:'');
		$range2_ini							= (isset($dados['range2_ini'])?$dados['range2_ini']:'');
		$range2_fin							= (isset($dados['range2_fin'])?$dados['range2_fin']:'');
		$range3								= (isset($dados['range3'])?$dados['range3']:'');
		$range3_ini							= (isset($dados['range3_ini'])?$dados['range3_ini']:'');
		$range3_fin							= (isset($dados['range3_fin'])?$dados['range3_fin']:'');
		$range4								= (isset($dados['range4'])?$dados['range4']:'');
		$range4_ini							= (isset($dados['range4_ini'])?$dados['range4_ini']:'');
		
		
		
		(isset($dados['name']))?$this->db->set('name',$name):'';
		(isset($dados['email_admin']))?$this->db->set('email_admin',$email_admin):'';
		(isset($dados['logo_ext']))?$this->db->set('logo_ext',$logo_ext):'';
		(isset($dados['bg_ext']))?$this->db->set('bg_ext',$bg_ext):'';
		(isset($dados['email_admin']))?$this->db->set('email_admin',$email_admin):'';
		(isset($dados['range1']))?$this->db->set('range1',$range1):'';
		(isset($dados['range1_ini']))?$this->db->set('range1_ini',$range1_ini):'';
		(isset($dados['range1_fin']))?$this->db->set('range1_fin',$range1_fin):'';
		(isset($dados['range2']))?$this->db->set('range2',$range2):'';
		(isset($dados['range2_ini']))?$this->db->set('range2_ini',$range2_ini):'';
		(isset($dados['range2_fin']))?$this->db->set('range2_fin',$range2_fin):'';
		(isset($dados['range3']))?$this->db->set('range3',$range3):'';
		(isset($dados['range3_ini']))?$this->db->set('range3_ini',$range3_ini):'';
		(isset($dados['range3_fin']))?$this->db->set('range3_fin',$range3_fin):'';
		(isset($dados['range4']))?$this->db->set('range4',$range4):'';
		(isset($dados['range4_ini']))?$this->db->set('range4_ini',$range4_ini):'';
	}
	
	public function gravar()
	{
		$ex = $this->db->update("config");
		return $ex;
	}
	
}
