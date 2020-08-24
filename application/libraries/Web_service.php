<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_service{
    public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->load->library('debug');
    }
	
 	public function getInfo($params){
		$dados = array(
						'method' 			=> $params['url']
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
	private function serializeParams($dados)
	{
		$params = $dados;
		unset($params['method']); 
		# chamar a API e decodifica a resposta
		$url = $dados['method'].http_build_query($params);
		$rsp = file_get_contents($url);
		$rsp = $this->xml_to_array($rsp);
		//$this->ci->debug->show($rsp);
		return $rsp;
	}
	
	function xml_to_array($xml,$main_heading = '') {
	    $deXml = simplexml_load_string($xml);
	    $deJson = json_encode($deXml);
	    $xml_array = json_decode($deJson,TRUE);
	    if (! empty($main_heading)) {
	        $returned = $xml_array[$main_heading];
	        return $returned;
	    } else {
	        return $xml_array;
	    }
	}
}
?>