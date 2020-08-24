<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner{
    public function __construct()
    {
		$this->ci =& get_instance();
    }
	
 	function show(){
		$this->ci->load->model('Banner_model', '', TRUE);
		$dados 		= array('active'=>'1','maximo'=>'4','inicio'=>'0');
		$banner 	= $this->ci->Banner_model->getList($dados);
		$caminho 	= base_url('admin/public/images/banner/');
		$link 		= base_url('produto/exibe/').'/';
		//Begin Slider
		
        echo '<div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel" style="margin-top: 0px!important;">';
        echo '  <ol class="carousel-indicators">';
		foreach($banner as $index => $row){
	        echo '    <li data-target="#carouselExampleIndicators" data-slide-to="'.$index.'" class="'.($index=='0'?'active':'').'"></li>';
		}
        echo '  </ol>';
        echo '  <div class="carousel-inner" role="listbox">';
		foreach($banner as $index => $row){
	        echo '<div class="carousel-item '.(($index==0)?'active':'').'">';
	        echo '	<a href="http://www.armazemcoletivo.com.br/cadastroprodutor"><img class="d-block img-fluid " src="'.$caminho.$row['image'].'" alt="'.$row['subtitle'].'" /></a>';
	        echo '</div>';
		}
        echo '  </div>';
        echo '  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
        echo '    <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '    <span class="sr-only">Previous</span>';
        echo '  </a>';
        echo '  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
        echo '    <span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '    <span class="sr-only">Next</span>';
        echo '  </a>';
        echo '</div>';
		
		
	}
}