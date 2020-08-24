<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class envia_email {
		function enviar($params)
		{
			$this->ci =& get_instance();
			$this->ci->load->library('email');
			 
			$this->ci->email->initialize(); // Aqui carrega todo config criado anteriormente
			$this->ci->email->subject($params['assunto']); //assunto
			$this->ci->email->from('comercial@vbsbs.com.br'); //quem mandou
			$this->ci->email->to((isset($params['to']))?$params['to']:'comercial@vbsbs.com.br'); //quem recebe
			$this->ci->email->cc((isset($params['cc']))?$params['cc']:'comercial@vbsbs.com.br'); //quem recebe
			$this->ci->email->message($params['msg']); //corpo da mensagem
			 
			if($this->ci->email->send())
			{
				$erro['msg']	= 'Email enviado com sucesso!  ';
				$erro['status']	= TRUE;
			}
			else {
				$erro['msg']	= 'Erro ao enviar email: '.$correio.'  ';
				$erro['status']	= FALSE;
			}
			return $erro;
		}
	}
?>