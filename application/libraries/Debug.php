<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Debug{
    public function __construct()
    {
        $this->ci =& get_instance();
    }
 	function show($dados=null,$die=true){
 	    echo "<pre>";
 	    if($die==true)
 	        die(print_r($dados, TRUE));
        else
            print_r($dados);
		echo "</pre>";
	}
}
?>

