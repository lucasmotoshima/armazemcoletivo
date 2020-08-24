<?php
	$this->ci =& get_instance();
	$this->ci->load->model('category_model', '', TRUE);
	$dados = array('active'=>'1');
	$category 	= $this->ci->category_model->getList($dados);
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
<!-- End Sidebar -->