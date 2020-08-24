<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class flickr{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
 	function photosGetInfo($params){
		$dados = array(
						'method' 	=> 'flickr.photos.getInfo',
						'api_key' 	=> true,
						'photo_id' 	=> $params['photo_id'],
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
 	function photosetsGetInfo($params){
		$dados = array(
						'method' 	=> 'flickr.photosets.getInfo',
						'api_key' 	=> true,
						'photoset_id'	=> $params['photoset_id'],
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
 	function getUserPhotos($params){
		$dados = array(
						'method' 	=> 'flickr.urls.getUserPhotos',
						'api_key' 	=> true,
						'user_id' 	=> true,
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
 	function getListUser($params){
		$dados = array(
						'method' 	=> 'flickr.tags.getListUser',
						'api_key' 	=> true,
						'user_id' 	=> true,
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
 	function photoSetsGetList($params){
		$dados = array(
						'method' 	=> 'flickr.photosets.getList',
						'api_key' 	=> true,
						'user_id' 	=> true,
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
 	function photoSetsGetPhotos($params){
		$dados = array(
						'method' 		=> 'flickr.photosets.getPhotos',
						'api_key' 		=> true,
						'user_id' 		=> true,
						'format' 		=> 'rest',
						'photoset_id'	=> $params['photoset_id'],
						);
 		$return = $this->serializeParams($dados);
		return $return;
 	}
	
	
	private function serializeParams($dados)
	{
		$this->ci->load->model('config_model', '', TRUE);
		$configuracao = $this->ci->config_model->staticGet();
		/*
 		$params = array(
						'api_key'			=> '9738dd1f9fc3f70dda0cf6dc323247cb',
						'method'			=> $dados['method'],
						'user_id'			=> '24554013@N05',
						'per_page'			=> isset($dados['per_page'])?$dados['per_page']:null,
						'page'				=> isset($dados['page'])?$dados['page']:null,
						'photo_id'			=> isset($dados['photo_id'])?$dados['photo_id']:null,
						'photoset_id'		=> isset($dados['photoset_id'])?$dados['photoset_id']:null,
						'format'			=> 'rest',
						'secret'			=> '5299a165cbcb3ba7'
						);
						
		 * 
		 */
 		$params = array(
						'api_key'			=> $configuracao['api_key'],
						'method'			=> $dados['method'],
						'user_id'			=> $configuracao['user_id'],
						'per_page'			=> isset($dados['per_page'])?$dados['per_page']:null,
						'page'				=> isset($dados['page'])?$dados['page']:null,
						'photo_id'			=> isset($dados['photo_id'])?$dados['photo_id']:null,
						'photoset_id'		=> isset($dados['photoset_id'])?$dados['photoset_id']:null,
						'format'			=> 'rest',
						'secret'			=> $configuracao['secret']
						);
		
		foreach($dados as $index => $row){
			$encoded_params[$index] = $params[$index];
		}
		if(isset($dados['api_key']))
			$encoded_params['api_key'] 		= $params['api_key'];
		if(isset($dados['user_id']))
			$encoded_params['user_id'] 		= $params['user_id'];
		if(isset($dados['format']))
			$encoded_params['format'] 		= $params['format'];
		if(isset($dados['secret']))
			$encoded_params['secret'] 		= $params['secret'];
		if(isset($dados['photo_id']))
			$encoded_params['photo_id'] 	= $dados['photo_id'];
		
		# chamar a API e decodifica a resposta
		$url = "https://api.flickr.com/services/rest/?".http_build_query($encoded_params);
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