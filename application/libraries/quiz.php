<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quiz{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
 	function show($quiz=null,$quizresposta=null){
 		if(isset($quiz)and isset($quizresposta))
		{
			$this->ci->load->model('quizrespostausuario_model', '', TRUE);
			$dados = array('cookie'=>$_COOKIE["PHPSESSID"]);
			$qtde = count($this->ci->quizrespostausuario_model->listar($dados));
			if($qtde==0)
			{
		  		$obj =& get_instance();
		  		$obj->load->helper('url');
				$quiz_bar  = "<div id='quiz'>"
		  						."<p class='chamada'>Quiz</p>"
		  						."<form action='/'>"
		  							."<input type='hidden' name='fk_quiz' value='".$quiz['id']."'>"
		  							."<label class='pergunta'>".$quiz['pergunta']."</label>";
						            if(count($quizresposta)!=0){
										foreach($quizresposta as $index => $resposta){
										$quiz_bar .="<div class='respostas'><input type='radio' value='".$resposta['id']."' name='resposta' class='bt_res'/> <p>".$resposta['resposta']."</p></div>";
										}
									}
									$quiz_bar .="<input type='button' class='enviar' value='Enviar' />"
		  						."</form>"
		  						."<div id='resposta'></div>"
		  					."</div>";
		  		return $quiz_bar;
			}

		}
 	}
}
?>

