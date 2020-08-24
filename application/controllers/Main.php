<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('form');
		$this->load->helper('email');
		//==== librarys =====
		$this->load->library('banner');
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('Head');
		$this->load->library('perfil');
		$this->load->library('clearstring');
		$this->load->library('image');
		$this->load->library('pagination');
		$this->load->library('industry');
		$this->load->library('provider');
		$this->load->library('Web_service');
		//==== models =====
		$this->load->model('Banner_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Category_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Product_provider_model', '', TRUE);
		$this->load->model('Provider_model', '', TRUE);
		$this->load->model('Industry_model', '', TRUE);
		$this->load->model('Profissional_model', '', TRUE);
		$this->load->model('Cidade_model', '', TRUE);
	}
	public function index($msg=null)
	{
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$industry 						= $this->Industry_model->getList();
		$data['rubros']					= $industry;
		$data['controller'] 			= 'main';
		$this->load->view('header',$data);
		$inicio 						= (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
		$dados 							= array('active'=>'1','per_page'=>12,'maximo'=>12,'inicio'=>$inicio,'main'=>'true');
		$data['pagination']				= $this->setPagination($dados);
		if(isset($_SESSION['armazem']['user']['localidade'])){
			$dados['localidade'] 		= $_SESSION['armazem']['user']['localidade'];
		}
		$products 						= $this->Product_model->getList($dados);
		if(empty($products)){
			unset($dados['localidade']);
			$products 						= $this->Product_model->getList($dados);
		}
		if(empty($products)){
			$dados['uf']					= isset($_SESSION['armazem']['user']['uf'])?$_SESSION['armazem']['user']['uf']:null;
			$products 						= $this->Product_model->getList($dados);
		}
		
		$productList 					= array();
		foreach ($products as $x => $value) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$value['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$code_origin = ($value['code_origin'].'_1');
			//$photo	= $this->get_photo($x,208,115);
			$photo  = $this->image->resize($code_origin,100,100);
			//$this->debug->show($photo);
			$productList[$x] = array(
								'id'						=>$value['id'],
								'code_origin'				=>$value['code_origin'],
								'name'						=>$value['name'],
								'description'				=>$value['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$value['qty_min'],
								'fk_category'				=>$value['fk_category'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		$data['result']			= $productList;
		
		do {
			$category 				= $this->Category_model->getRand();
			$dados 					= array('fk_category'=>$category[0]['id'],'active'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>0,'main'=>'true');
			$productCategoryList	= $this->Product_model->getListThumb($dados);
		} while (count($productCategoryList) < 4);
		
		foreach ($productCategoryList as $x => $val) {
			$product_provider 	= $this->Product_provider_model->staticGet('fk_product',$val['id']);
			$provider 			= $this->Provider_model->staticGet($product_provider[0]['fk_provider']);
			
			$code_origin = ($val['code_origin'].'_1');
			//$photo	= $this->get_photo($x,208,115);
			$photo  = $this->image->resize($code_origin,100,100);
			$productCatList[$x] = array(
								'id'						=>$val['id'],
								'code_origin'				=>$val['code_origin'],
								'name'						=>$val['name'],
								'description'				=>$val['description'],
								'price'						=>$product_provider[0]['price'],
								'provider'					=>$provider[0]['name'],
								'provider_city'				=>$provider[0]['city'],
								'provider_uf'				=>$provider[0]['uf'],
								'provider_id'				=>$provider[0]['id'],
								'provider_image'			=>$provider[0]['image'],
								'qty_min'					=>$val['qty_min'],
								'fk_category'				=>$val['fk_category'],
								'category_name'				=>$category[0]['name'],
								'photo_url' 				=>$photo['url'],
								'photo_path' 				=>$photo['path'],
								'photo_w' 					=>$photo['w'],
								'photo_h' 					=>$photo['h']
								);
		}
		$data['resultCat']			= $productCatList;
		//=======================================================
		$dadosProf 				= array('ativo'=>'1','per_page'=>4,'maximo'=>4,'inicio'=>0,'main'=>'true');
		$profissional			= $this->Profissional_model->getList($dadosProf);
		//$this->debug->show($profissional);
		$profissionalList = array();
		foreach ($profissional as $y => $row) {
			$cidade = $this->Cidade_model->staticGet($row['cidade']);
			$profissionalList[$y] = array(
				'id' 				=> $row['id'],
	            'namepage'			=> $row['namepage'],
	            'nome'				=> $row['nome'],
	            'codigo' 			=> $row['codigo'],
	            'url_friendly' 		=> $row['url_friendly'],
	            'especialidades' 	=> $row['especialidades'],
	            'diasemana' 		=> $row['diasemana'],
	            'hrinicio' 			=> $row['hrinicio'],
	            'qtdeatendimentos' 	=> $row['qtdeatendimentos'],
	            'tempoconsulta' 	=> $row['tempoconsulta'],
	            'intervalo' 		=> $row['intervalo'],
	            'sexo' 				=> $row['sexo'],
	            'tel1' 				=> $row['tel1'],
	            'tel2' 				=> $row['tel2'],
	            'email' 			=> $row['email'],
	            'emailmd5' 			=> $row['emailmd5'],
	            'rua' 				=> $row['rua'],
	            'numero' 			=> $row['numero'],
	            'estado' 			=> $row['estado'],
	            'cidade' 			=> $row['cidade'],
	            'cidadenome'		=> $cidade[0]['nome'],
	            'ativo'				=> $row['ativo'],
	            'imagem' 			=> $row['imagem'],
	            'dtcadastro' 		=> $row['dtcadastro'],
	            'description' 		=> $row['description'],
	            'obs' 				=> $row['obs'],
			);

		}
		$data['prof']			= $profissionalList;
		//$this->debug->show($data['profissional'],0);
		//=======================================================
		
		$this->load->view('main',$data);
		//$this->load->view('main2',$data);
		$this->load->view('footer');
	}

	function get_photos($code,$w,$h) {
		$fotoList = array();
		$filename = SYS_ADMIN_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'.jpg';
		//$this->debug->show($filename);
		if (file_exists($filename)){
			$photo				= $this->image->resize($code,$w,$h);
			$fotoList['path'] 	= $filename;
			$fotoList['url'] 	= base_url('admin/public/images/product/'.$code.'.jpg');
			$fotoList['h'] 		= $photo['h'];
			$fotoList['w'] 		= $photo['w'];
		}
		else{
			$fotoList['path']	= SYS_ADMIN_IMAGE_PATH."product".DIRECTORY_SEPARATOR."default.gif";
			$fotoList['url'] 	= base_url('admin/public/images/product/default.gif');
		    $fotoList['w'] 		= $w;
			$fotoList['h'] 		= $h;
		}
		return $fotoList;
	}
	
	public function setPagination($dados)
	{
		$config['base_url'] = base_url('product/getList/');
		unset($dados['maximo']);
		$config['total_rows'] = count($this->Product_model->getList($dados));
		$config['per_page'] = $dados['per_page'];
		$config['uri_segment']  = '4';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a href="#" aria-controls="datatable" data-dt-idx="" tabindex="0">';
		$config['cur_tag_close'] = '</li>';
		$config['first_link'] = 'Primeiro';
		$config['first_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li class="paginate_button" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Próximo';
		$config['next_tag_open'] = '<li class="paginate_button next" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<li class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/main.php */