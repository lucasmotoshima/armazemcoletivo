<?php
class Provider_plan_model extends CI_Model {
	var $fk_provider	= '';
	var $fk_plan		= '';

	
	public function __construct()
	{
		parent::__construct();
	}
	 
	public $messages = array();


  	public function staticGet($pk, $pkValue=null)
  	{
		if($pkValue==null) 
		 	$query = $this->db->get_where('provider_plan', array('id'=>$pk));
		else
		 	$query = $this->db->get_where('provider_plan', array($pk=>$pkValue));
    	return $query->result_array();
  	}
	
	public function set($dados)
	{
		
		$fk_provider					= (isset($dados['fk_provider'])?$dados['fk_provider']:'');
		$fk_plan						= (isset($dados['fk_plan'])?$dados['fk_plan']:'');
		$months_installment				= (isset($dados['months_installment'])?$dados['months_installment']:'');
		$discount						= (isset($dados['discount'])?$dados['discount']:'');
		$price_month					= (isset($dados['price_month'])?$dados['price_month']:'');
		$price_total					= (isset($dados['price_total'])?$dados['price_total']:'');
		$tp_installment					= (isset($dados['tp_installment'])?$dados['tp_installment']:'');
		$dt_start						= (isset($dados['dt_start'])?$dados['dt_start']:'');
		$dt_end							= (isset($dados['dt_end'])?$dados['dt_end']:'');
		$dt_start_installment			= (isset($dados['dt_start_installment'])?$dados['dt_start_installment']:'');
		$dt_end_installment				= (isset($dados['dt_end_installment'])?$dados['dt_end_installment']:'');
		$obsPlan						= (isset($dados['obsPlan'])?$dados['obsPlan']:'');
		
		(isset($dados['fk_provider']))?$this->db->set('fk_provider',$fk_provider):'';
		(isset($dados['fk_plan']))?$this->db->set('fk_plan',$fk_plan):'';
		(isset($dados['months_installment']))?$this->db->set('months_installment',$months_installment):'';
		(isset($dados['discount']))?$this->db->set('discount',$discount):'';
		(isset($dados['price_month']))?$this->db->set('price_month',$price_month):'';
		(isset($dados['price_total']))?$this->db->set('price_total',$price_total):'';
		(isset($dados['tp_installment']))?$this->db->set('tp_installment',$tp_installment):'';
		(isset($dados['dt_start']))?$this->db->set('dt_start',$dt_start):'';
		(isset($dados['dt_end']))?$this->db->set('dt_end',$dt_end):'';
		(isset($dados['dt_start_installment']))?$this->db->set('dt_start_installment',$dt_start_installment):'';
		(isset($dados['dt_end_installment']))?$this->db->set('dt_end_installment',$dt_end_installment):'';
		(isset($dados['obsPlan']))?$this->db->set('obs',$obsPlan):'';
//=================================================================
	}
	
	public function save($dados)
	{
		if(isset($dados['id']))
		{
			$this->db->where('id',$dados['id']);
			$ex = $this->db->update("provider_plan");
			$id = $_REQUEST['id'];
		}
		else
		{
			$ex = $this->db->insert("provider_plan");
			$id = $this->db->insert_id();
		}
		//print_r($this->db->last_query());die;
		return array($ex,$id);
	}
	
	public function getList($dados=null)//
	{
		$this->db->select('provider_plan.*');
		if(isset($dados['fk_provider']))
			$this->db->where('provider_plan.fk_provider',$dados['fk_provider']);
		if(isset($dados['fk_plan']))
			$this->db->where('provider_plan.fk_plan',$dados['fk_plan']);
		if(isset($dados['active']))
			$this->db->where('provider_plan.active',$dados['active']);
		$query = $this->db->get('provider_plan');
		return $query->result_array();
	}

	public function changeStatus($id,$status)
	{
		$this->db->set('active',$status);
		$this->db->where('id',$id);
		$ex = $this->db->update('provider_plan'); 
		if(!$ex){
		    $msg 		= 'Erro nº:'.$this->db->_error_number().' / '.$this->db->_error_message();
			return array(TRUE,$msg);
		}
		else{
			$msg		= 'Plano alterado con sucesso! ';
			return array(FALSE,$msg);
		}
	}
	
	public function delete($id)
	{
		$ex = $this->db->delete('provider_plan', array('id'=>$id)); 
		if($ex){
			$msg 	= 'Plano excluído.';
			return array(TRUE,$msg);
		}
		else
		{
		    $msgdb 	= $this->db->_error_message();
		    $num 	= $this->db->_error_number();
			$msg = 'Error: '.$msgdb;
			return array(FALSE,$msg);
		}
	}
}