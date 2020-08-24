<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class format_date {
	public function index()
	{
		$this->load->helper('date');
	}
	
    public function us2br($date=null)
    {
    	if(strlen($date)>10)
		{
			$partes = explode(' ',$date);
			$partes_da_data = explode('-',$partes[0]);
			$data_br = $partes_da_data[2].'/'.$partes_da_data[1].'/'.$partes_da_data[0];
			$data_br = $data_br .' '. $partes[1];
		}
		else
		{
			$partes_da_data = explode('-',$date);
			$data_br = $partes_da_data[2].'/'.$partes_da_data[1].'/'.$partes_da_data[0];
			$data_br = $data_br;
		}
		return $data_br;
    }
	
    public function br2us($date=null)
    {
    	if(strlen ($date)>10)
		{
			$partes = explode(' ',$date);
			$partes_da_data = explode('/',$partes[0]);
			$data_us = $partes_da_data[2].'-'.$partes_da_data[1].'-'.$partes_da_data[0];
			$data_us = $data_us .' '. $partes[1];
		}
		else
		{
			$partes_da_data = explode('/',$date);
			$data_us = $partes_da_data[2].'-'.$partes_da_data[1].'-'.$partes_da_data[0];
			$data_us = $data_us;
		}
		return $data_us;
    }
	function somaMinuto($hora,$periodo,$multiplicador=null){
		$periodoTot	= $this->minutos($periodo) * (($multiplicador==null or $multiplicador==0)?0:$multiplicador);
		$novaHora = date('H:i:s', strtotime('+ '.$periodoTot.' minute', strtotime($hora)));
		return $novaHora;
	}
	
	function minutos($min){
		$horaTot 	= explode(':', $min);
		$hora 		= $horaTot[0];
		$min 		= $horaTot[1];
		
		$minutos	= ($hora * 60) + $min;
		return $minutos;
	}
	
	public function dead_line($data_inicio,$data_fim,$type='',$sep='-')
	//calcula tempo para dead line à partir de uma data em formatação
	{
		$d1 = explode($sep, $data_inicio);
		$d2 = explode($sep, $data_fim);
		switch ($type)
		{
			case 'A':
			$X = 31536000;
			break;
			case 'M':
			$X = 2592000;
			break;
			case 'D':
			$X = 86400;
			break;
			case 'H':
			$X = 3600;
			break;
			case 'MI':
			$X = 60;
			break;
			default:
			$X = 1;
		}
		return floor(((mktime(0,0,0,$d2[1],$d2[2],$d2[0]))-(mktime(0,0,0,$d1[1],$d1[2],$d1[0])))/$X);
	}

	public function diffTime($data_inicio,$data_fim,$sep='-')
	//calcula tempo para dead line à partir de uma data em formatação
	{
		$d1 			= explode($sep, $data_inicio);
		$d2 			= explode($sep, $data_fim);
		//$this->ci->debug->show($data_inicio,false);
		$hr1 			= explode(' ', $d1[2]);
		$hr2 			= explode(' ', $d2[2]);
		//$this->ci->debug->show($hr1,false);
		$hora1 			= explode(':',$hr1[1]);
		$hora2 			= explode(':',$hr2[1]);
		//$this->ci->debug->show($hora1,false);
		
		$timestamp1 	= mktime($hora1[0],$hora1[1],$hora1[2],$d1[1],$hr1[0],$d1[0]);
		$timestamp2 	= mktime($hora2[0],$hora2[1],$hora2[2],$d2[1],$hr2[0],$d2[0]);
		
		//diminuo a uma data a outra 
		$segundos_diferenca = $timestamp2 - $timestamp1; 
		//converto segundos em dias 
		$dias_diferenca 	= $segundos_diferenca / (60 * 60 * 24);
		//converto segundos em horas 
		$horas_diferenca 	= $segundos_diferenca / (60 * 60);  
		
		//obtenho o valor absoluto dos dias (tiro o possível sinal negativo) 
		//$dias_diferenca = abs($dias_diferenca); 
		
		//tiro os decimais aos dias de diferenca 
		//$dias_diferenca = floor($dias_diferenca); 
		$result['seconds'] 	= array($segundos_diferenca,floor($segundos_diferenca));
		$result['hours'] 	= array($horas_diferenca,floor($horas_diferenca));
		$result['days'] 	= array(number_format($dias_diferenca,17),floor($dias_diferenca)); 
		return $result;
	}
	
	function diaSemana($data){//  99/99/9999
		// Traz o dia da semana para qualquer data informada
		$dia =  substr($data,0,2);
		$mes =  substr($data,3,2);
		$ano =  substr($data,6,4);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana){
			case"0": 
				$retorno[0] = '0';
				$retorno[1] = "Domingo";
				$retorno[2] = "Sunday";
				break;  				
			case"1": 
				$retorno[0] = '1';
				$retorno[1] = "Segunda-Feira";
				$retorno[2] = "Monday";
				break;
			case"2": 
				$retorno[0] = '2';
				$retorno[1] = "Terça-Feira";
				$retorno[2] = "Tuesday";
				break;  				
			case"3": 
				$retorno[0] = '3';
				$retorno[1] = "Quarta-Feira";
				$retorno[2] = "Wednesday";  
				break;  				
			case"4": 
				$retorno[0] = '4';
				$retorno[1] = "Quinta-Feira";
				$retorno[2] = "Thursday";
				break;  				
			case"5": 
				$retorno[0] = '5';
				$retorno[1] = "Sexta-Feira";
				$retorno[2] = "Friday";
				break;  				
			case"6": 
				$retorno[0] = '6';
				$retorno[1] = "Sabado";
				$retorno[2] = "Saturday";
				break;  			 }
			return $retorno;
	}
	
	function mes_br($data){
		// Tras o mes
		
    	if(strlen($data)>10)
		{
			$partes 		= explode(' ',$data);
			$data 		= str_replace('-','/',$partes[0]);
			$partes		= explode('/',$data);
			$data_br 	= $partes[2].'/'.$partes[1].'/'.$partes[0];
		}
		else
		{
			$data 		= str_replace('-','/',$data);
			$partes		= explode('/',$data);
			$data_br 	= $partes[2].'/'.$partes[1].'/'.$partes[0];
		}
		
		$dia 		=  substr($data_br,0,2);
		$mes 	=  substr($data_br,3,2);
		$ano 	=  substr($data_br,6,4);
		$mescorrente = date("n", mktime(0,0,0,$mes,$dia,$ano) );
		switch($mescorrente){
			case 1: $retorno = "JANEIRO"; break;
			case 2: $retorno = "FEVEREIRO"; break;
			case 3: $retorno = "MARÇO"; break;
			case 4: $retorno = "ABRIL"; break;
			case 5: $retorno = "MAIO"; break;
			case 6: $retorno = "JUNHO"; break;
			case 7: $retorno = "JULHO"; break;
			case 8: $retorno = "AGOSTO"; break;
			case 9: $retorno = "SETEMBRO"; break;
			case 10: $retorno = "OUTUBRO"; break;
			case 11: $retorno = "NOVEMBRO"; break;
			case 12: $retorno = "DEZEMBRO"; break;
		}
		return $retorno;
	}	
	
	
	function showCalendario($data, $tamanho=null){
		$data = $this->diaSemana($data);
		$html =  (($data[0]=='1')?'<img src="'.base_url().'/public/images/icones/cal_seg'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='2')?'<img src="'.base_url().'/public/images/icones/cal_ter'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='3')?'<img src="'.base_url().'/public/images/icones/cal_qua'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='4')?'<img src="'.base_url().'/public/images/icones/cal_qui'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='5')?'<img src="'.base_url().'/public/images/icones/cal_sex'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='6')?'<img src="'.base_url().'/public/images/icones/cal_sab'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">')
				.(($data[0]=='7')?'<img src="'.base_url().'/public/images/icones/cal_dom'.(($tamanho=='peq')?'_peq':'').'.gif">':'<img src="'.base_url().'/public/images/icones/cinza'.(($tamanho=='peq')?'_peq':'').'.gif">');
		return $html;
	}

	function showDiasSemana($array, $tamanho=null){
		$serv_unid = explode(',',$array);
		$diaSemanaGrafico = '';
		$diaSemanaGrafico .= ($serv_unid[0]=='1')?('<img src="'.base_url().'public/images/icones/cal_seg'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[1]=='1')?('<img src="'.base_url().'public/images/icones/cal_ter'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[2]=='1')?('<img src="'.base_url().'public/images/icones/cal_qua'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[3]=='1')?('<img src="'.base_url().'public/images/icones/cal_qui'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[4]=='1')?('<img src="'.base_url().'public/images/icones/cal_sex'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[5]=='1')?('<img src="'.base_url().'public/images/icones/cal_sab'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		$diaSemanaGrafico .= ($serv_unid[6]=='1')?('<img src="'.base_url().'public/images/icones/cal_dom'.(($tamanho=='peq')?'_peq':'').'.gif">'):('<img src="'.base_url().'public/images/icones/cinza_peq.gif">');
		return $diaSemanaGrafico;
	}
	
	function comparaDatas($dtIni,$dtFim){
		$inicio = explode(' ', $dtIni);
		//print_r($this->br2us($dtIni));die;
		if(strlen($inicio[0])>'5'){
			$dtIni = ($this->br2us($dtIni));
			$dtFim = ($this->br2us($dtFim));
			$retorno = array();
			// Comparando as Datas
			if($dtIni>$dtFim){
				$retorno = true;
			}elseif($dtIni<$dtFim){
				$retorno = false;
			}else{
				$retorno = false;
			}
		}else{
			$retorno = false;
		}
		return $retorno;
	}
	
}

/* End of file Someclass.php */