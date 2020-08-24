<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class envia_email {
		function enviar($params)
		{
			$this->ci =& get_instance();
			$this->ci->load->library('email');
			$this->ci->email->initialize(); // Aqui carrega todo config criado anteriormente
			
			if(isset($params['to'])){
				$this->ci->email->to('contato@armazemcoletivo.com.br'); //quem recebe
			}else{
				$this->ci->email->to($params['to']); //quem recebe
			}
			
			if(isset($params['assunto'])){
				$this->ci->email->subject('Seja bem vindo ao Armazém Coletivo.');
			}else{
				$this->ci->email->subject($params['assunto']); //quem recebe
			}
			
			$this->ci->email->from('contato@armazemcoletivo.com.br'); //quem mandou
			$this->ci->email->message($params['msg']); //corpo da mensagem
			 
			if($this->ci->email->send())
			{
				$erro['msg']	= 'Enviado com sucesso!  ';
				$erro['status']	= TRUE;
			}
			else {
				$erro['msg']	= 'Erro '.$this->ci->email->print_debugger();
				$erro['status']	= FALSE;
			}
			return $erro;
		}
	}
?>