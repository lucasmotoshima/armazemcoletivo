<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menu{
    public function __construct()
    {

    }
 	function show($params=null){
 		if(isset($_SESSION['adm_armazem']['user']['id']))
		{
			$tipo = $_SESSION['adm_armazem']['user']['type'];
			$painel = '
                	<ul class="nav side-menu">
                  		<li><a href="'.base_url().'"><i class="fa fa-dashboard"></i> Painel de Indicadores </span></a></li>
                  	</ul>';
			$user = '<ul class="nav side-menu">
                  		<li><a><i class="fa fa-group"></i> Usuários <span class="fa fa-chevron-down"></span></a>
                    		<ul class="nav child_menu">
                      			<li><a href="'.base_url('user/form').'">Novo Cadastro</a></li>
                      			<li><a href="'.base_url('user/getList').'">Lista de Usuários</a></li>
                    		</ul>
                  		</li>
               		</ul>';
			$config = '
                		<ul class="nav side-menu">
                  			<li><a><i class="fa fa-gear"></i> Configurações <span class="fa fa-chevron-down"></span></a>
                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('config/form').'">Editar Configurações</a></li>
                    			</ul>
                  			</li>
                  		</ul>';
        	$cotizacion = '<ul class="nav side-menu">
	                  			<li><a><i class="fa fa-file"></i> Pedidos <span class="fa fa-chevron-down"></span></a>
	                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('cart/getList').'">Lista de Pedidos</a></li>
	                    			</ul>
	                  			</li>
	                  		</ul>';	
         	$provider = '<ul class="nav side-menu">
	                  			<li><a><i class="fa fa-truck"></i> Fornecedores <span class="fa fa-chevron-down"></span></a>
	                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('provider/form').'">Novo Cadastro</a></li>
                      				<li><a href="'.base_url('provider/getList').'">Lista de Fornecedores</a></li>
	                    			</ul>
	                  			</li>
	                  		</ul>';
         	$category = '<ul class="nav side-menu">
	                  			<li><a><i class="fa fa-coffee"></i> Categorias <span class="fa fa-chevron-down"></span></a>
	                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('category/form').'">Novo Cadastro</a></li>
                      				<li><a href="'.base_url('category/getList').'">Lista de Categorias</a></li>
	                    			</ul>
	                  			</li>
	                  		</ul>';	
        	$industry = '<ul class="nav side-menu">
	                  			<li><a><i class="fa fa-cubes"></i> Grupos de Itens <span class="fa fa-chevron-down"></span></a>
	                    			<ul class="nav child_menu">
	                    				<li><a href="'.base_url('industry/form').'">Inserir Grupo</a></li>
	                      				<li><a href="'.base_url('industry/getList').'">Listar Grupos</a></li>
	                    			</ul>
	                  			</li>
	                  		</ul>';
        	$color = '<ul class="nav side-menu">
	                  			<li><a><i class="fa fa-adjust"></i> Variações de Cores <span class="fa fa-chevron-down"></span></a>
	                    			<ul class="nav child_menu">
	                    				<li><a href="'.base_url('color/form').'">Inserir Cores</a></li>
	                      				<li><a href="'.base_url('color/getList').'">Listar Cores</a></li>
	                    			</ul>
	                  			</li>
	                  		</ul>';
         	$product = '<ul class="nav side-menu">
                  			<li><a><i class="fa fa-repeat"></i> Atualização de estoque <span class="fa fa-chevron-down"></span></a>
                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('file/form').'">Upload Archivo (Excel)</a></li>
                      				<li><a href="'.base_url('file/getList').'">Listado de Archivo (Excel)</a></li>
                    			</ul>
                  			</li>
                  			<li><a><i class="fa fa-tag"></i> Produtos <span class="fa fa-chevron-down"></span></a>
                    			<ul class="nav child_menu">
                      				<li><a href="'.base_url('product/form').'">Novo</a></li>
                      				<li><a href="'.base_url('product/getList').'">Lista</a></li>
                    			</ul>
                  			</li>
	                  		</ul>';
			$banner = '	<ul class="nav side-menu">
              			<li><a><i class="fa fa-newspaper-o"></i> Biblioteca de Banners <span class="fa fa-chevron-down"></span></a>
                			<ul class="nav child_menu">
                  				<li><a href="'.base_url('banner/form').'">Inserir Banner</a></li>
                  				<li><a href="'.base_url('banner/getList').'">Lista de Banners</a></li>
                			</ul>
              			</li>
          			</ul>';
			$report = '	<h3>Exportação de Dados</h3>
                		<ul class="nav side-menu">
                  			<li><a href="'.base_url('report/form').'"><i class="fa fa-file-text-o"></i> Relatórios </span></a></li>
                  		</ul>';
					
				switch ($tipo) {
					case '1':
						$menu = '<div class="menu_section">'.
									'<h3>Pedidos</h3>'.
									$cotizacion.
								'</div>'.
								'<div class="menu_section">'.
									'<h3>Produto</h3>'.
									$product.
								'</div>'.
								'<div class="menu_section">'.
									'<h3>Configurações de Produtos</h3>'.
									$industry.
									$category.
									$provider.
									//$color.
								'</div>'.
								'<div class="menu_section">'.
									'<h3>Configurações do Sistema</h3>'.
									$banner.
									$user.
									$config.
								'</div>';
						break;
					case '0':
						$menu = $inicio_menu.
								'<div id="separator">Producto</div>'.
								$product.
								$industry.
								//$color.
								$category.
								$provider.
								$print.
								'<div id="separator">Layout</div>'.
								$banner.
								'<div id="separator">Relatórios</div>'.
								$report.
								'<div id="separator">Configuración</div>'.
								$user.
								$config;
						break;
					default:
						
						break;
				}
			
	  		return $menu;
	  	}
 	}
}
?>