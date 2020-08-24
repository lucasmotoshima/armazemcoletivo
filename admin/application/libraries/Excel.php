<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excel{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
	function getContent($id)//recebe o ID do arquivo
	{
		$this->ci->load->model('file_model', '', TRUE);
		$file = $this->ci->File_model->staticGet($id);
		$path = SYS_FILE_PATH.$file[0]['id'].$file[0]['ext'];
		$obj = fopen($path, 'r');
		$cont = 0;
		while (($data = fgetcsv($obj,1000,';')) !== FALSE) {
			if($cont!=0)
			{
				$matriz[$cont]['provider_code'] 			= $data[0];
				$matriz[$cont]['category_code'] 			= $data[1];
				$matriz[$cont]['code_origin'] 				= $data[2];
				$matriz[$cont]['qty_min'] 					= $data[3];
				$matriz[$cont]['product_name'] 				= $data[4];
				$matriz[$cont]['product_desc'] 				= $data[5];
				$matriz[$cont]['product_measures'] 			= $data[6];
				$matriz[$cont]['delivery_time'] 			= $data[7];
				$matriz[$cont]['price'] 					= str_replace('.', ',', $data[8]);
				$matriz[$cont]['industry_types'] 			= $data[9];
				$matriz[$cont]['validity'] 					= $data[10];
				$matriz[$cont]['fk_file'] 					= $id;
			}
			$cont++;
		}
		return $matriz;
	}
}

