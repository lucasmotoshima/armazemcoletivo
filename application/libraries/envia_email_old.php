<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class envia_email {
		function enviar($params)
		{
			$this->ci =& get_instance();
			$this->ci->load->library('email');
			 
			$this->ci->email->initialize(); // Aqui carrega todo config criado anteriormente
			$this->ci->email->subject($params['assunto']); //assunto
			$this->ci->email->from('felipe@logoideas.cl'); //quem mandou
			$this->ci->email->to('felipe@logoideas.cl'); //quem recebe
			//$this->ci->email->to($params['email']); //quem recebe
			//$this->ci->email->to('lucasmotoshima@yahoo.com.br'); //quem recebe
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