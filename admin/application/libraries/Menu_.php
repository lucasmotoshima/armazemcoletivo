<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menu{
    public function __construct()
    {

    }
 	function show_menu($params=null){
 		if(isset($_SESSION['adm_armazem']['user']['id']))
		{
			$tipo = $_SESSION['adm_armazem']['user']['type'];
			$inicio_menu  = "<div id='menu'>";
			$user  =
	  				"<dl><label>Usuários</label>"	
	  					."<dt class='".((($params['controller']=='user')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."user/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='user')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."user/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$config  =
	  				"<dl><label>Configuración</label>"	
	  					."<dt class='".((($params['controller']=='config')and($params['function']=='edit'))?'selected':'')."'><a href='".base_url()."config/form"."'>Edit</a></dt>"
	  				."</dl>";
			$cotizacion  =
	  				"<dl><label>Cotización</label>"	
	  					."<dt class='".((($params['controller']=='cart')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."cart/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$provider  =
	  				"<dl><label>Provedores</label>"	
	  					."<dt class='".((($params['controller']=='provider')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."provider/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='provider')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."provider/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$photo  =
	  				"<dl><label>Fotos</label>"	
	  					."<dt class='".((($params['controller']=='photo')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."photo/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='photo')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."photo/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$category  =
	  				"<dl><label>Categorias</label>"	
	  					."<dt class='".((($params['controller']=='category')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."category/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='category')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."category/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$industry  =
	  				"<dl><label>Rubros</label>"	
	  					."<dt class='".((($params['controller']=='industry')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."industry/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='industry')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."industry/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$color  =
	  				"<dl><label>Colores</label>"	
	  					."<dt class='".((($params['controller']=='color')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."color/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='color')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."color/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$print  =
	  				"<dl><label>Impresión</label>"
	  					."<dt class='".((($params['controller']=='print')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."print/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='print')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."print/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$product  =
	  				"<dl><label>Productos</label>"	
	  					."<dt style='".((($params['controller']=='producto')and($params['function']=='file'))?'selected':'')."'><a href='".base_url()."file/form"."'>Upload Archivo (Excel)</a></dt>"
	  					."<dt style='".((($params['controller']=='producto')and($params['function']=='file'))?'selected':'')."'><a href='".base_url()."file/getList"."'>Listado de Archivo (Excel)</a></dt>"
	  					."<dt style='".((($params['controller']=='producto')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."product/form"."'>Nuevo</a></dt>"
	  					."<dt style='".((($params['controller']=='producto')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."product/getList"."'>Listado</a></dt>"
	  				."</dl>";
	  		$banner  =
	  				"<dl><label>Banners</label>"	
	  					."<dt class='".((($params['controller']=='banner')and($params['function']=='new'))?'selected':'')."'><a href='".base_url()."banner/form"."'>Nuevo</a></dt>"
	  					."<dt class='".((($params['controller']=='banner')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."banner/getList"."'>Listado</a></dt>"
	  				."</dl>";
			$report  =
	  				"<dl><label>Relatórios</label>"	
	  					."<dt class='".((($params['controller']=='report')and($params['function']=='list'))?'selected':'')."'><a href='".base_url()."report/form"."'>Opciones de Relatórios</a></dt>"
	  				."</dl>";
			$fim_menu  =
					"</div>"
					;
					
				switch ($tipo) {
					case '1':
						$menu = $inicio_menu.
								'<div id="separator">Cotización</div>'.
								$cotizacion.
								'<div id="separator">Producto</div>'.
								$product.
								$photo.
								$industry.
								$color.
								$category.
								$provider.
								$print.
								'<div id="separator">Layout</div>'.
								$banner.
								'<div id="separator">Relatórios</div>'.
								//$report.
								'<div id="separator">Configuración</div>'.
								$user.
								$config.
								$fim_menu;
						break;
					case '0':
						$menu = $inicio_menu.
								'<div id="separator">Producto</div>'.
								$product.
								$industry.
								$color.
								$category.
								$provider.
								$print.
								'<div id="separator">Layout</div>'.
								$banner.
								'<div id="separator">Relatórios</div>'.
								$report.
								'<div id="separator">Configuración</div>'.
								$user.
								$config.
								$fim_menu;
						break;
					default:
						
						break;
				}
			
	  		return $menu;
	  	}
 	}
}
?>