<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ws_pagseguro{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
	
	
	
 	public function getInfo($params){
		$dados 		= array('method' => $params['url']);
 		$return 	= $this->serializeParams($dados);
		return $return;
 	}
	
	private function serializeParams($dados)
	{
		$params = $dados;
		//print_r($params['method']);
		unset($params['method']); 
		# chamar a API e decodifica a resposta
		$url = $dados['method'].http_build_query($params);
		//print_r($url);
		$rsp = file_get_contents($url);
		$rsp = $this->xml_to_array($rsp);
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