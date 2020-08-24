<?php
	$this->ci =& get_instance();
	$this->ci->load->model('product_model', '', TRUE);
	$this->ci->load->library('image', '', TRUE);
	$dados 		= array('active'=>'1','maximo'=>'10','inicio'=>'0');
	$product 	= $this->ci->product_model->getList($dados);
	$productList = array();
	foreach ($product as $x => $value) {
		$x = ($value['code_origin'].'_1');
		//$photo	= $this->image->get_mainPhoto($x,49,47);
		$photo	= $this->image->resize($value['code_origin'].'_1',49,47);
		$productList[$x] = array(
							'id'						=>$value['id'],
							'code_origin'				=>$value['code_origin'],
							'name'						=>$value['name'],
							'description'				=>$value['description'],
							'qty_min'					=>$value['qty_min'],
							'fk_category'				=>$value['fk_category'],
							'photo_url' 				=>$photo['url'],
							'photo_path' 				=>$photo['path'],
							'photo_w' 					=>$photo['w'],
							'photo_h' 					=>$photo['h']
							);
	}
	
	function get_photo($code,$w,$h) {
		$fotoList = array();
		$filename = SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR.$code.'.jpg';
		if (file_exists($filename)){
			$photo				= $this->image->resize($code,$w,$h);
			$fotoList['path'] 	= $filename;
			$fotoList['url'] 	= base_url('admin/public/images/product/'.$code.'.jpg');
			$fotoList['h'] 		= $photo['h'];
			$fotoList['w'] 		= $photo['w'];
			print_r($fotoList['path'] .' Existe dsfdsfds');die;
		}
		else{
			$fotoList['path']	= SYS_IMAGE_PATH."product".DIRECTORY_SEPARATOR."default.gif";
			$fotoList['url'] 	= base_url('admin/public/images/product/default.gif');
		    $fotoList['w'] 		= $w;
			$fotoList['h'] 		= $h;
		}
		return $fotoList;
	}
	
?>
					<!-- Begin Right Sidebar -->
					<div id="right-sidebar" class="sidebar">
						<ul>
							<li class="widget products-box">
								<h2>Mas Cotizados</h2>
								<div class="widget-entry">
									<ul>
										<?php foreach($productList as $index => $row){?>
										<li>
											<a href="#" title="<?=$row['name'];?>">
												<div style='width: 49px; height: 49px; text-align: center;float:left;'>
													<?php if($row['name']!=''){?>
														<img src="<?php echo $row['photo_url'];?>" alt="" width='<?php echo $row['photo_w'];?>' height='<?php echo $row['photo_h'];?>'/>
													<?php }?>
												</div>
												<span class="info">
													<span class="title"><?php echo $row['name'];?></span>
												</span>
												<span class="cl">&nbsp;</span>
											</a>
										</li>
										<?php }?>
									</ul>
									<div class="cl">&nbsp;</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- End Sidebar -->
					<div class="cl">&nbsp;</div>