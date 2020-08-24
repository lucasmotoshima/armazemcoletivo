<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class imagem_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//==== helpres =====
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('form');
		$this->load->helper('email');
		//==== librarys =====
		$this->load->library('upload');
		$this->load->library('flickr');
		$this->load->library('breadcrumb');
		$this->load->library('format_date');
		$this->load->library('pagination');
		$this->load->library('menu');
		$this->load->library('envia_email');
		$this->load->library('msg');
		$this->load->library('head');
		$this->load->library('perfil');
		$this->load->library('clearstring');
		$this->load->library('ultimas_noticias');
		$this->load->library('quiz');
		$this->load->library('image_mask');
		//==== models =====
		$this->load->model('imagem_model', '', TRUE);
		$this->load->model('tpveiculo_model', '', TRUE);
		$this->load->model('album_model', '', TRUE);
		$this->load->model('usuario_model', '', TRUE);
		$this->load->model('veiculo_model', '', TRUE);
		$this->load->model('solicitacao_model', '', TRUE);
		$this->load->model('noticia_model', '', TRUE);
		$this->load->model('quiz_model', '', TRUE);
		$this->load->model('quizresposta_model', '', TRUE);
		$this->load->model('quizrespostausuario_model', '', TRUE);
	}
	
	public function index()
	{}
	
	public function lista($photoset_id)
	{
		if($this->validaAcesso())
		{
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$data['menu'] 			= $this->menu->show_menu();
			$data['quiz']  			= $this->quiz_model->getLastQuiz();
			$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
			$album 					= $this->album_model->staticGet($photoset_id);
			$dados 					= array('ativo'=>'Y', 'fk_album'=>$album['id']);
			$result 				= $this->imagem_model->listar($dados);
			foreach ($result as $index => $row) {
				$dt 						= array('fk_usuario'=>$_SESSION['imagebank']['user']['id'],
													'fk_album'	=>$album['id'],
													'key_flickr'=>$row['id']
													);
				$solicitacao = $this->solicitacao_model->listar($dt);
				$res[$index]['id'] 			= $row['id'];
				$res[$index]['server'] 		= $row['server'];
				$res[$index]['secret'] 		= $row['secret'];
				$res[$index]['farm'] 		= $row['farm'];
				$res[$index]['title'] 		= $row['title'];
				$res[$index]['isprimary'] 	= $row['isprimary'];
				$res[$index]['ativo'] 		= $row['ativo'];
				$res[$index]['aprovado'] 	= (count($solicitacao)>0)?$solicitacao[0]['ativo']:'N';
			}
			$data['result']			= $res;
			$data['alb']			= $this->album_model->staticGet($photoset_id);
			$data['album'] 			= $this->album_model->listar(array('ativo'=>'Y'));
			$this->load->view('imagem/busca',$data);
			$this->load->view('imagem/lista',$data);
			$this->load->view('footer');
		}
		else
		{redirect();}
	}
	
	/*
	public function detalhe($idFoto)
	{
		if($this->validaAcesso())
		{
			$this->load->view('header');
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$params = array('controller'=>'imagem');
			$data['menu'] = $this->menu->show_menu($params);
			$dados = array('photo_id'=> $idFoto);
			$data['result'] = $this->flickr->photosGetInfo($dados);
			$this->load->view('imagem/detalhe',$data);
			$this->load->view('footer');
		}
		else
		{redirect();}
	}
	 */

	public function detalheDownload($idFoto)
	{
		if($this->validaAcesso())
		{
			$this->load->view('header');
			$params = array('controller'=>'imagem');
			$data['menu'] = $this->menu->show_menu($params);
			$data['quiz']  			= $this->quiz_model->getLastQuiz();
			$data['quizresposta']	= $this->quizresposta_model->listar(array('fk_quiz'=>$data['quiz']['id']));
			$usuario = $this->usuario_model->staticGet($_SESSION['imagebank']['user']['id']);
			$tpveiculo = $this->tpveiculo_model->staticGet($usuario['fk_tpveiculo']);
			$dados = array('photo_id'=> $idFoto);
			$data['foto'] = $this->flickr->photosGetInfo($dados);
			$result = $this->flickr->photosGetSizes($dados);
			foreach ($result['sizes']['size'] as $index => $row):
				$indice = strtolower(str_replace(' ', '', $row['@attributes']['label']));
				if($tpveiculo[$indice]==TRUE)
				{
					$res[$index]['label'] 			= $row['@attributes']['label'];
					$res[$index]['width'] 			= $row['@attributes']['width'];
					$res[$index]['height'] 			= $row['@attributes']['height'];
					$res[$index]['source'] 			= $row['@attributes']['source'];
					$res[$index]['url'] 			= $row['@attributes']['url'];
					$res[$index]['media'] 			= $row['@attributes']['media'];
					$res[$index]['imageInfo']		= $this->flickr->photosGetInfo($dados);
				}
			endforeach;
			$data['result']						= $res;
			$imagem								= $this->imagem_model->staticGet($idFoto);
			$data['photo_id']					= $idFoto;
			$data['fk_album']					= $imagem['fk_album'];
			$data['user_id']					= $usuario['id'];
			$this->load->view('imagem/detalheDownload',$data);
			$this->load->view('footer');
		}
		else
		{redirect();}

	}

	public function download()
	{
		if($this->validaAcesso())
		{
			if(isset($_REQUEST['photo_id']))
			{
				$imagem 	= $this->imagem_model->staticGet($_REQUEST['photo_id']);
				$album 		= $this->album_model->staticGet($_REQUEST['fk_album']);
				$usuario 	= $this->usuario_model->staticGet($_SESSION['imagebank']['user']['id']);
				$link 		= $_REQUEST['link'];
				if(($imagem>0)and($usuario>0)and($album>0))
				{
					$dados = array( 'fk_usuario'	=>$usuario['id'],
									'photo_id'		=>$imagem['id'],
									'fk_album'		=>$album['id'],
									'ativo'			=>(($usuario['qtdedownload'] < $usuario['limitedownload']) and ($usuario['tipoDownload']=='A'))?'Y':'N',
									'dt_aprovado'	=>($usuario['tipoDownload']=='A')?date("Y-m-d H:i:s"):'');
					$this->solicitacao_model->set($dados);
					$res = $this->solicitacao_model->gravar($dados);
	
					if($res[0])//se gravou com sucesso
					{
						if(($usuario['tipoDownload']=='M')or($usuario['qtdedownload'] >= $usuario['limitedownload']))
						{
							$liberado 					= 'Download a ser autorizado.';
							$jsonReturn['error']		= TRUE;
						}
						else
						{
							$liberado 		= 'Download liberado.';
							$download = array(	'fk_usuario'	=>$usuario['id'],
												'photo_id'		=>$imagem['id'],
												'fk_album'		=>$album['id'],
												'qtdedownload'	=>$usuario['qtdedownload']+1
												);
							$this->usuario_model->contabilizaDownload($download);
							$jsonReturn['error']		= FASLE;
						}
						
						if(($usuario['limitedownload'] - ($usuario['qtdedownload']+1))>0)
							$qtdeRestante = ($usuario['limitedownload'] - ($usuario['qtdedownload']+1));
						else
							$qtdeRestante = 0;
						$jsonReturn['msg']		= 'Solicitação de download "#'.$res[1].'" gravada com sucesso. '.'<strong>'.$qtdeRestante.'</strong> downloads restantes. '.$liberado.'';
						$jsonReturn['ativo']	= 'Y';
						$jsonReturn['label']	= 'ativo';
					}
					else
					{
						$solicitacao = array(	'fk_usuario'		=>$usuario['id'],
												'key_flickr'		=>$imagem['id'],
												'fk_album'			=>$album['id']
												);
						$sol = $this->solicitacao_model->get($solicitacao);
						if($sol['ativo']=='Y')
						{
							$jsonReturn['msg']		= 'Download autorizado.';
							$jsonReturn['error']	= false;
						}
							
						else
						{
							$jsonReturn['msg']		= 'Desculpe, download aguardando aprovação.';
							$jsonReturn['error']	= true;
						}
					}
				}
				else {
					$jsonReturn['msg']		= 'Desculpe, imagem e/ou usuário não encontrado(s).';
					$jsonReturn['ativo']	= 'N';
					$jsonReturn['label']	= 'inativo';
					$jsonReturn['error']	= true;
				}
			}
			else
			{
				$jsonReturn['msg']		= 'Desculpe, imagem e/ou usuário não encontrado(s).';
				$jsonReturn['ativo']	= ($novo['ativo']=='Y')?'N':'Y';
				$jsonReturn['label']	= ($novo['ativo']=='Y')?'ativo':'inativo';
				$jsonReturn['error']	= true;
			}
			header('Content-Type: application/json');
			print json_encode($jsonReturn);
		}
		else
		{}
	}

	public function buscar()
	{
		if($this->validaAcesso())
		{
			$data['album'] 	= $this->album_model->listar(array('ativo'=>'Y'));
			$usuario	= isset($_SESSION['imagebank']['user']['id'])?$this->usuario_model->staticGet($_SESSION['imagebank']['user']['id']):'';
			$tag 		= (isset($_REQUEST['tag']))?$_REQUEST['tag']:'';
			$gallery 	= (isset($_REQUEST['gallery']))?$_REQUEST['gallery']:false;
			$this->load->view('header');
			$data['menu'] 	= $this->menu->show_menu();
			if (isset($_POST['ck_filtro']) && $_POST['ck_filtro'] == '1')
				$result 	= $this->flickr->photosSearch($tag,$gallery);
			else
				$result 	= $this->flickr->photosSearch($tag);
			$resultArray 	= array();
			if(isset($result['photos']['photo']))
			{
				foreach ($result['photos']['photo'] as $index => $row) {
					$param 	= array('id'=>$row['@attributes']['id']);
					$imagem = $this->imagem_model->busca($param);
					if($imagem>0)
					{
						if($imagem['ativo']=='Y')
						{
							$dt 						= array('fk_usuario'=>(isset($usuario['id']))?$usuario['id']:'X',
																'fk_album'	=>$imagem['fk_album'],
																'key_flickr'=>$row['@attributes']['id']
																);
							$solicitacao = $this->solicitacao_model->listar($dt);
							$resultArray[$index]['id']				= $row['@attributes']['id'];
							$resultArray[$index]['server']			= $row['@attributes']['server'];
							$resultArray[$index]['secret']			= $row['@attributes']['secret'];
							$resultArray[$index]['farm']			= $row['@attributes']['farm'];
							$resultArray[$index]['title']			= $row['@attributes']['title'];
							$resultArray[$index]['fk_album']		= $imagem['fk_album'];
							$resultArray[$index]['album']			= $this->album_model->staticGet($imagem['fk_album']);
							$resultArray[$index]['ativo'] 			= $imagem['ativo'];
							$resultArray[$index]['aprovado'] 		= (count($solicitacao)>0)?$solicitacao[0]['ativo']:'N';
						}
					}
					else
					{
						$data['erro']	= false;
						$data['msg']	= 'Não há nada que atende a '.$tag.'.';
					}
				}
				$data['result']			= isset($resultArray)?$resultArray:array();
				$data['tag']			= $tag;
			}
			else
			{
				$data['result']			= isset($resultArray)?$resultArray:array();
				$data['tag']			= $tag;
				$data['erro']			= true;
				$data['msg']			= 'Não há nada que atende a '.$tag.'.';
			}
			$this->load->view('imagem/busca',$data);
			$this->load->view('imagem/listaBusca',$data);
			$this->load->view('footer');
		}
		else
		{redirect();}
	}

	//====================================================================
	public function setPaginacao($maximo)
	{
		$config['base_url'] = base_url('imagem/lista');
		$config['total_rows'] = count($this->imagem_model->listar());
		$config['per_page'] = '10';
		$config['uri_segment']  = '3';
		$config['first_link'] = 'Primeiro';
		$config['last_link'] = 'Último';
		$config['next_link'] = 'Próximo';
		$config['prev_link'] = 'Anterior';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	private function validaAcesso()
	{
		if((!isset($_SESSION['imagebank']['user']['email']))or($_SESSION['imagebank']['user']['email']=='')or(!isset($_SESSION['imagebank']['user']['email'])))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
//===========================================================================
	
}