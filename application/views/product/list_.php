		<!-- Begin Main -->
		<div id="main">
			<!-- Begin Inner -->
			<div class="inner">
				<div class="shell">
					<?php
						$this->ci =& get_instance();
						$this->ci->load->model('category_model', '', TRUE);
						$dados = array('active'=>'1');
						$category 	= $this->ci->Category_model->getList($dados);
					?>
					<!-- Begin Left Sidebar -->
					<div id="left-sidebar" class="sidebar">
						<ul>
							<li class="widget">
								<h2>Categorias</h2>
								<div class="widget-entry">
									<ul>
										<?php foreach($category as $index => $row){?>
										<li><a href="<?php echo base_url('product/getList/'.$row['id'])?>"><span><?php echo substr($row['name'],0,30)?></span></a></li>
										<?php }?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
					<!-- Begin Content -->
					<div id="content">
						<!-- Begin Products -->
						<div id="products" class='inner'>
							<h2><?php (isset($category['name']))?$category['name']:(count($result).' produtos encontrados para "'.$search.'"')?><span class="title-bottom">&nbsp;</span></h2>
							<?php if(count($result)!=0){?>
								<?php foreach($result as $index => $row){?>
								<div class="product">
									<a href="<?php echo base_url('product/detail/'.$row['id'])?>">
										<div style='height: 147px; width: 184px;'>
											<img style='margin-top:<?php echo round((147 - $row['photo_h'])/2)?>px;' src="<?=$row['photo_url']?>" width='<?=($row['photo_w']==null)?'179':$row['photo_w']?>' height='<?=($row['photo_h']==null)?'147':$row['photo_h']?>'/>
										</div>
										<span class="title"><?php echo $row['name']?></span>
									</a>
								</div>
								<?php }?>
							<?php }else{?>
							<div class="product">
							</div>
							<?php }?>
							<div class="cl">&nbsp;</div>
						</div>
						<?php if(isset($pagination)){?>
							<div id="pagination"><?php echo $pagination?></div>
						<?php }?>
						<!-- End Products -->
					</div>
					<div class="cl">&nbsp;</div>
					<!-- End Content -->
				</div>
			</div>
			<!-- End Inner -->
		</div>
		<!-- End Main -->
