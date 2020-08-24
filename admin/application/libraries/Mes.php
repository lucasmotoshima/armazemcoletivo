<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mes {
	public function index()
	{}
	
    public function num2month($mes,$language=null)
    {
    	if(isset($language))
		{
			if($language=='pt')
			{
			    switch ($mes) { 
			        case 1 : $mes='Janeiro'; 	break;
			        case 2 : $mes='Fevereiro';  break;
			        case 3 : $mes='Março';    	break;
			        case 4 : $mes='Abril';    	break;
			        case 5 : $mes='Maio';    	break;
			        case 6 : $mes='Junho';    	break;
			        case 7 : $mes='Julho';    	break;
			        case 8 : $mes='Agosto';    	break;
			        case 9 : $mes='Setembro'; 	break;
			        case 10 : $mes='Outubro'; 	break;
			        case 11 : $mes='Novembro'; 	break;
			        case 12 : $mes='Dezembro'; 	break;
				}	
			}
		}
		if (!isset($language)or($language=='en'))
		{
		    switch ($mes) { 
		        case 1 : $mes='January'; 		break;
		        case 2 : $mes='February';    	break;
		        case 3 : $mes='March';    		break;
		        case 4 : $mes='April';    		break;
		        case 5 : $mes='May';    		break;
		        case 6 : $mes='June';    		break;
		        case 7 : $mes='July';    		break;
		        case 8 : $mes='August';    		break;
		        case 9 : $mes='September'; 		break;
		        case 10 : $mes='October'; 		break;
		        case 11 : $mes='November';    	break;
		        case 12 : $mes='December'; 		break;
		    }
		}
    return $mes;
	}
}