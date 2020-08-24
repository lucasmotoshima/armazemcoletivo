<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = '';

$route['user'] = "User_controller";
$route['user/([a-zA-Z]+)'] = "User_controller/$1";
$route['user/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "User_controller/$1/$2";
$route['user/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "User_controller/$1/$2/$3";

$route['category'] = "Category_controller";
$route['category/([a-zA-Z]+)'] = "Category_controller/$1";
$route['category/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Category_controller/$1/$2";
$route['category/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Category_controller/$1/$2/$3";

$route['config'] = "Config_controller";
$route['config/([a-zA-Z]+)'] = "Config_controller/$1";
$route['config/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Config_controller/$1/$2";
$route['config/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Config_controller/$1/$2/$3";

$route['provider'] = "Provider_controller";
$route['provider/([a-zA-Z]+)'] = "Provider_controller/$1";
$route['provider/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Provider_controller/$1/$2";
$route['provider/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Provider_controller/$1/$2/$3";

$route['product'] = "Product_controller";
$route['product/([a-zA-Z]+)'] = "Product_controller/$1";
$route['product/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Product_controller/$1/$2";
$route['product/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Product_controller/$1/$2/$3";

$route['banner'] = "Banner_controller";
$route['banner/([a-zA-Z]+)'] = "Banner_controller/$1";
$route['banner/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Banner_controller/$1/$2";
$route['banner/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Banner_controller/$1/$2/$3";

$route['color'] = "Color_controller";
$route['color/([a-zA-Z]+)'] = "Color_controller/$1";
$route['color/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Color_controller/$1/$2";
$route['color/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Color_controller/$1/$2/$3";

$route['industry'] = "Industry_controller";
$route['industry/([a-zA-Z]+)'] = "Industry_controller/$1";
$route['industry/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Industry_controller/$1/$2";
$route['industry/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Industry_controller/$1/$2/$3";

$route['print'] = "Print_controller";
$route['print/([a-zA-Z]+)'] = "Print_controller/$1";
$route['print/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Print_controller/$1/$2";
$route['print/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Print_controller/$1/$2/$3";

$route['file'] = "File_controller";
$route['file/([a-zA-Z]+)'] = "File_controller/$1";
$route['file/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "File_controller/$1/$2";
$route['file/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "File_controller/$1/$2/$3";

$route['photo'] = "Photo_controller";
$route['photo/([a-zA-Z]+)'] = "Photo_controller/$1";
$route['photo/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Photo_controller/$1/$2";
$route['photo/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Photo_controller/$1/$2/$3";

$route['cart'] = "Cart_controller";
$route['cart/([a-zA-Z]+)'] = "Cart_controller/$1";
$route['cart/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Cart_controller/$1/$2";
$route['cart/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Cart_controller/$1/$2/$3";

$route['plan'] = "Plan_controller";
$route['plan/([a-zA-Z]+)'] = "Plan_controller/$1";
$route['plan/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Plan_controller/$1/$2";
$route['plan/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Plan_controller/$1/$2/$3";

$route['cart_product'] = "Cart_product_controller";
$route['cart_product/([a-zA-Z]+)'] = "Cart_product_controller/$1";
$route['cart_product/([a-zA-Z]+)/([a-zA-Z0-9 ]+)'] = "Cart_product_controller/$1/$2";
$route['cart_product/([a-zA-Z]+)/([a-zA-Z0-9 ]+)/([a-zA-Z0-9 ]+)'] = "Cart_product_controller/$1/$2/$3";

$route['default_controller'] = "Main";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */