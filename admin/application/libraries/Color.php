<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Color{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
	public function getListColors(){
   	$colorList = array();
		$this->ci =& get_instance();
		//===========BLANCO=============
		$colorList[] = array(
					'code'=>'ND',
					'hexa'=>'#FFFFFF',
					'name'=>'NÃO DEFINIDA',
					);
		$colorList[] = array(
					'code'=>'BR',
					'hexa'=>'#FFFFFF',
					'name'=>'Branco',
					);
		//===========NEGRO=============
		$colorList[]= array(
					'code'=>'PT',
					'hexa'=>'#000000',
					'name'=>'Preto',
					);
		//===========GRIS=============
		$colorList[] = array(
					'code'=>'GR',
					'hexa'=>'#c0c0c0',
					'name'=>'Cinza',
					);
		//===========Amarelo=============
		$colorList[] = array(
					'code'=>'AM',
					'hexa'=>'#e2df00',
					'name'=>'Amarelo',
					);
		$colorList[] = array(
					'code'=>'AC',
					'hexa'=>'#fcffcb',
					'name'=>'Amarelo Claro',
					);
		$colorList[] = array(
					'code'=>'AE',
					'hexa'=>'#9ca200',
					'name'=>'Amarelo Escuro',
					);
		//===========Vermelho=============
		$colorList[] = array(
					'code'=>'VM',
					'hexa'=>'#c70000',
					'name'=>'Vermelho',
					);
		$colorList[] = array(
					'code'=>'RC',
					'hexa'=>'#c66262',
					'name'=>'Vermelho Claro',
					);
		$colorList[] = array(
					'code'=>'RE',
					'hexa'=>'#9e0303',
					'name'=>'Vermelho Escuro',
					);
		//===========AZUL=============
		$colorList[] = array(
					'code'=>'AZ',
					'hexa'=>'#0005da',
					'name'=>'Azul',
					);
		$colorList[] = array(
					'code'=>'AC',
					'hexa'=>'#6a97e0',
					'name'=>'Azul Claro',
					);
		$colorList[] = array(
					'code'=>'AE',
					'hexa'=>'#000084',
					'name'=>'Azul Escuro',
					);
		$colorList[] = array(
					'code'=>'AR',
					'hexa'=>'#0a05d3',
					'name'=>'Azul Marinho',
					);
		//===========VERDE=============
		$colorList[] = array(
					'code'=>'VD',
					'hexa'=>'#00dc0a',
					'name'=>'Verde',
					);
		$colorList[] = array(
					'code'=>'VC',
					'hexa'=>'#b2e7b2',
					'name'=>'Verde Claro',
					);
		$colorList[] = array(
					'code'=>'VE',
					'hexa'=>'#1a5513',
					'name'=>'Verde Escuro',
					);
		$colorList[] = array(
					'code'=>'VE',
					'hexa'=>'#55ba5f',
					'name'=>'Verde Esmeralda',
					);
		//===========PLATA=============
		$colorList[] = array(
					'code'=>'PR',
					'hexa'=>'#d4d4d4',
					'name'=>'Prata',
					);
		//===========Laranja=============
		$colorList[] = array(
					'code'=>'LR',
					'hexa'=>'#d69e31',
					'name'=>'Laranja',
					);
		$colorList[] = array(
					'code'=>'LE',
					'hexa'=>'#a17500',
					'name'=>'Laranja Escuro',
					);
		$colorList[] = array(
					'code'=>'LC',
					'hexa'=>'#ffd790',
					'name'=>'Laranja Claro',
					);
		$colorList[] = array(
					'code'=>'LE',
					'hexa'=>'#796932',
					'name'=>'Laranja Encobrizado',
					);
		$colorList[] = array(
					'code'=>'NT',
					'hexa'=>'#f9ecdb',
					'name'=>'Natural',
					);
		//===========CELESTE=============					
		$colorList[] = array(
					'code'=>'CL',
					'hexa'=>'#99e4f1',
					'name'=>'Celeste',
					);
		//===========ROSADO=============	
		$colorList[] = array(
					'code'=>'RS',
					'hexa'=>'#da77e3',
					'name'=>'Rosado',
					);
		//===========MORADO=============	
		$colorList[] = array(
					'code'=>'MR',
					'hexa'=>'#4a3616',
					'name'=>'Marrom',
					);
		//===========ENCOBRIZADO=============
		$colorList[] = array(
					'code'=>'CO',
					'hexa'=>'#814913',
					'name'=>'Cobre',
					);
		//===========LILA=============
		$colorList[] = array(
					'code'=>'LL',
					'hexa'=>'#754e9b',
					'name'=>'Lilas',
					);
		//===========DORADO=============
		$colorList[] = array(
					'code'=>'DR',
					'hexa'=>'#c49f0b',
					'name'=>'Dourado',
					);
		return $colorList;
	}
	
	 function getColorOptions(){
	 	$lista = $this->getListColors();
		return $lista;
	}
	
	function getByCode($code=null){
		if($code!='')
		{
			$list = $this->getListColors();
			foreach ($list as $key => $row) {
				if($row['code']==$code)
				$return = array(
							'code'=>$row['code'],
							'name'=>$row['name'],
							'hexa'=>$row['hexa']
							);
			}
		}
		else
		{
			$return = array(
				'code'=>'X',
				'name'=>'no defined',
				'hexa'=>'#FFFFFF',
				);
		}
		return $return;
	}
}

