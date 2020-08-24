<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendario{
    public function __construct()
    {

    }
 	function show($dados=null){
 		$CI =& get_instance();
		$prefs = array (
		               	'start_day'    => 'saturday',
		               	'month_type'   => 'long',
		               	'day_type'     => 'short'
		             );
		$params = array (
          				'show_next_prev'  => false,
         				'next_prev_url'   => base_url('evento/exibe')
		             );
					 
		if(count($dados)>0)
		{
			foreach ($dados as $key => $row):
				if((date('m')==substr($row['data'], 5,2))and(date('Y')==substr($row['data'], 0,4)))
				{
					$dia 					= substr($row['data'], 8,2);
					$url 					= base_url('evento/exibe/'.$row['id']);
					$data[intval($dia)]		= $url;	
				}
			endforeach;
		}
		else
		{
			$data = array();
		}
		$CI->load->library('calendar', $prefs);
		$html_inicio = '<div id="calendario"><span class="chamada">Próximos Eventos</span>';
		$html_fim = '</div>';
		return $html_inicio.$CI->calendar->generate(date('Y'),date('m'),$data).$html_fim;
	}
}
?>

