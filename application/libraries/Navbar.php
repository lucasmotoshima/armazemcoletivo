<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class navbar{
    public function __construct()
    {
    	$this->ci =& get_instance();
		$this->ci->load->library('debug');
    }
	
	
	function show(){
		$tipo = 1;
		$inicio_menu  	= '<nav class="navbar navbar-expand navbar-dark bg-dark static-top">';
		$cadastro2 		= '
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt="">John Doe
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
							';
		
		
		$cadastro 		= '    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
							    <span class="navbar-toggler-icon"></span>
							  </button>
							  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
							    <a class="navbar-brand" href="#">Hidden brand</a>
							    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
							      <li class="nav-item active">
							        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link" href="#">Link</a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
							      </li>
							    </ul>
							    <form class="form-inline my-2 my-lg-0">
							      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
							      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
							    </form>
							  </div>';
		$fim_menu  		= "</nav>";
		
		switch ($tipo) {
			case 1://FULL
				$menu = //$inicio_menu.
						$cadastro2;
						//$fim_menu;
				break;
			default:
				
				break;
		}
		
		return $menu;
	}
}
?>



