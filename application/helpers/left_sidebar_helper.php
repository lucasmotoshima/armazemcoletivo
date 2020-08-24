<?php
	$this->ci =& get_instance();
	$this->ci->load->model('category_model', '', TRUE);
	$this->load->library('provider');
	$this->load->library('industry');
	$dados = array('active'=>'1');
	$category 	= $this->ci->category_model->getList($dados);
?>
<!-- Begin Left Sidebar -->
        <!--h1 class="my-4"><?=$this->head->getLogo();?></h1-->
        <script type="text/javascript">
        $(document).ready(function(){
        	if($('#categories_tags').is(":visible")){
        		$('#categories_ico').attr('src','<?=base_url('public/images/seta_cima.gif')?>');
        	}else{
        		$('#categories_ico').attr('src','<?=base_url('public/images/seta_baixo.gif')?>');
        	}
        	if($('#providers_tags').is(":visible")){
        		$('#providers_ico').attr('src','<?=base_url('public/images/seta_cima.gif')?>');
        	}else{
        		$('#providers_ico').attr('src','<?=base_url('public/images/seta_baixo.gif')?>');
        	}
        	if($('#industries_tags').is(":visible")){
        		$('#industry_ico').attr('src','<?=base_url('public/images/seta_cima.gif')?>');
        	}else{
        		$('#industry_ico').attr('src','<?=base_url('public/images/seta_baixo.gif')?>');
        	}
        
	    	$('.btn-list-group').click(function(e) {
	    		focus = $(this).attr('id');
	        	if($('#'+focus+'_tags').is(":visible")){
	        		$('#'+focus+'_tags').fadeOut('slow');
	        		$('#'+focus+'_ico').attr('src','<?=base_url('public/images/seta_baixo.gif')?>');
	        	}else{
	        		$('#'+focus+'_tags').fadeIn('slow');
	        		$('#'+focus+'_ico').attr('src','<?=base_url('public/images/seta_cima.gif')?>');
	        	}
	        });
	        
	        
	        
			$('.category:checkbox').click(function(){
				var categoryList = new Array();
	            $("#categories_tags input:checkbox[type=checkbox]:checked").each(function() { 
					categoryList.push($(this).attr('valor'));
	            }); 
				//console.log(categoryList);
				//var categoryList = $('.categoryList:checkbox').serializeArray();
				jQuery.ajax({
					type: "POST",            
					url: '<?=base_url("product/setCategory")?>',
					data: {categoryList:categoryList},
					dataType: 'json',
					success: function(returnedData){
						if(	returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
						{
						}
						else
						{
						}
					},
					async: true
				});
	        });       
	        
        });
        </script>
        
        <p class="btn-list-group" id="categories" label="categories">
        	Categorias
        	<img src="<?=base_url('public/images/seta_baixo.gif')?>" id="categories_ico" class="img_seta"/>
        </p>
        <div class="list-group" id="categories_tags">
			<?php foreach($category as $index => $row){?>
				<!--a href="<?php echo base_url('product/getByCategory/'.$row['id'])?>" class="list-group-item"><?php echo substr($row['name'],0,30)?></a-->
				<? $js = 'valor='.$row['id'].' class="category" id="cat_'.$row['id'].'"';?>
				<label for="cat_<?=$row['id']?>" class="list-group-item"><?=form_checkbox('category[]','',(isset($_SESSION['armazem']['categoryList'])?(in_array($row['id'],$_SESSION['armazem']['categoryList'])?TRUE:FALSE):(FALSE)), $js)?> <?php echo substr($row['name'],0,30)?></label>
			<?php }?>
			<button onClick="window.location.reload();" class="btn btn-success">Filtrar</button>
        </div>
		
    	<p class="btn-list-group" id="providers" label="providers">
    		Produtores
    		<img src="<?=base_url('public/images/seta_baixo.gif')?>" id="providers_ico" class="img_seta"/>
    	</p>
    	<div class="list-group" id="providers_tags">
    		<?php $this->ci->provider->getTags();?>
    	</div>
    	
    	<p class="btn-list-group" id="industries" label="industries">
    		Corredor de Sessão
    		<img src="<?=base_url('public/images/seta_baixo.gif')?>" id="industry_ico" class="img_seta"/>
    	</p>
    	<div class="list-group" id="industries_tags">
    		<?php $this->ci->industry->getTags();?>
    	</div>
    	<br>
<!-- End Sidebar -->