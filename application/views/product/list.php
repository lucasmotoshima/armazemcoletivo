  <!-- Page Content -->
  <div class="container">
	<br>
    <div class="row">
  		<div class="col-lg-3">
			<?php $this->load->helper('left_sidebar');?>
  		</div>
	<div class="col-lg-9">	 
	<?if(isset($provider)){?>
		<h1 style="background-color: #e8e8e8; padding: 5px 0px 7px 10px; border-radius: 5px;"><?=$provider[0]['name'];?></h1>
      	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
      			<p style="font-size: 21px;">
      				<img src="<?=base_url('admin/public/images/provider/'.(($provider[0]['image']!='')?$provider[0]['image']:'default.jpg'))?>" style="border-radius: 5px;float: left;margin: 10px 20px 0px 0px;" class="d-block img-fluid" alt="<?=$provider[0]['name']?>"/>
					<a href="https://api.whatsapp.com/send?phone=55<?=str_replace(' ','',preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $provider[0]['phone1']))?>&text=Oi%2C%20peguei%20seu%20contato%20pelo%20Armaz%C3%A9m%20Coletivo.%20Tudo%20bem%3F"><img src="<?=base_url('public/images/whatsapp_contato.gif')?>"></a></b>.
					<a target="_blank" title="Compartilhar página de <?=$provider[0]['name'];?> no WhatsApp" href="https://api.whatsapp.com/send?text=<?=base_url($provider[0]['url_friendly'])?>"><img src="<?=base_url('public/images/whatsapp_share.gif')?>"></a>
					<!--small style="float: right; font-size: 11px; color: #888888;"><?=base_url($provider[0]['url_friendly'])?></small-->
					<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?=base_url($provider[0]['url_friendly'])?>" target="_blank" title="Compartilhar página de <?=$provider[0]['name'];?> no Facebook"><img src="<?=base_url('public/images/facebook_share.gif')?>"></a>
					<br><b><?=$provider[0]['email'];?></b>
      			</p>	
      			<p><?=$provider[0]['description'];?></p>
      		</div>
      	</div>
		<?//php echo $this->banner->show();?>
	<?}?>
	<div class="row">
		<div style="color: #777777; width: 100%; display: table; border: 1px solid #CCC; padding: 10px; text-align: center; margin: 0px 0px 10px 0px; background-color: #f5f5f5;">
			<a href="https://www.blog.armazemcoletivo.com.br" style="font-size: 26px; text-decoration: none; color: #777777;">
				Clique aqui e se cadastre para participar da nossa <b style="color: #FFD242;">Aula Online Grátis</b>
			</a>
		</div>
		<div class="alertaHome">Proteja-se contra a COVID-19. Siga as instruções de precaução e fique em casa. </div>
	</div>
	<?php if(count($resultCat)>0){?>
	<div class="row" style="background-color: #efefef; margin-bottom: 10px;">
		<div class="col-lg-12 col-md-12 mb-12">
			<small style="font-size: 12px; color: #888888;">Veja também:</small> <?=$resultCat[0]['category_name']?>
		</div>
		<?php foreach($resultCat as $index => $row){?>
     		<div class="col-lg-6 col-md-6 mb-6">
	            <div class="card h-50">
	            	<div class="card-img-top" style="width:<?=$row['photo_w']?>px">
	            		<a href="<?php echo base_url('product/detail/'.$row['id'])?>"><img class="card-img-top" src="<?php echo $row['photo_url']?>" alt="<?php echo $row['name']?>"></a>
	            	</div>
	          		<div class="card-body">
		                <h2><a href="<?php echo base_url('product/detail/'.$row['id'])?>"><?=$row['name']?></a></h2>
		                <p class="card-text"><a href="<?php echo base_url('product/detail/'.$row['id'])?>"> <?=substr(strip_tags($row['description'],'<br>'),0,105);?><?=(strlen($row['description'])>105)?'<small>...</small>':'';?></a></p>
		                <p class="provider">
	                		<a href="<?php echo base_url('product/getByProvider/'.$row['provider_id'])?>"><b><?php echo $row['provider']?></b></a></br>
	                		<small style="color:#888888;"><?php echo $row['provider_city']?>/<?php echo $row['provider_uf']?></small>
		                </p>
	         		</div>
	              	<div class="card-footer" style="display: table; width: 100%;">
	              		<small class="text-muted"><a href="<?php echo base_url('product/detail/'.$row['id'])?>">R$ <?php echo str_replace('.', ',', $row['price']) ?></a></small>
	              	</div>
	            </div>
    		</div>
     <?php }?>
	</div>
	<?}?>
    <div class="row">
      	<div class="container-fluid">
         <?php
            if(isset($breadcrumb)&&  !is_null($breadcrumb)){
            ?>   
         <div class="row-fluid">
            <div class="span12">
               <div class="span2">
               </div>
               <div class="span10" style="margin-left:0px;">
                  <div>
                     <ul class="breadcrumb">
                        <?php
                           foreach ($breadcrumb as $key=>$value) {
                            if($value!=''){
                           ?>
	                        <li><a href="<?=$value; ?>"><?=$key; ?></a> <span class="divider">></span></li>
	                        <?php }else{?>
	                        <li class="active"><?=$key; ?></li>
	                        <?php }
                           }
                           ?>     
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <?php 
            }
            ?>    
      </div>
      
  		<?php if(count($result)>0){?>
			<?php foreach($result as $index => $row){?>
	     		<div class="col-lg-6 col-md-6 mb-6">
		            <div class="card h-50">
		            	<div class="card-img-top" style="width:<?=$row['photo_w']?>px">
		            		<a href="<?php echo base_url('product/detail/'.$row['id'])?>"><img class="card-img-top" src="<?php echo $row['photo_url']?>" alt="<?php echo $row['name']?>"></a>
		            	</div>
		          		<div class="card-body">
			                <h2><a href="<?php echo base_url('product/detail/'.$row['id'])?>"><?=$row['name']?></a></h2>
			                <p class="card-text"><a href="<?php echo base_url('product/detail/'.$row['id'])?>"> <?=substr(strip_tags($row['description'],'<br>'),0,105);?><?=(strlen($row['description'])>105)?'<small>...</small>':'';?></a></p>
			                <p class="provider">
		                		<a href="<?php echo base_url('product/getByProvider/'.$row['provider_id'])?>"><b><?php echo $row['provider']?></b></a></br>
		                		<small style="color:#888888;"><?php echo $row['provider_city']?>/<?php echo $row['provider_uf']?></small>
			                </p>
		         		</div>
		              	<div class="card-footer" style="display: table; width: 100%;">
		              		<small class="text-muted"><a href="<?php echo base_url('product/detail/'.$row['id'])?>">R$ <?php echo str_replace('.', ',', $row['price']) ?></a></small>
		              	</div>
		            </div>
	    		</div>
			<?php }?>
		<?php }else{?>
 			<div class="col-lg-12 col-md-12 mb-12">
 				<p><center><b>Nenhum produto encontrado com o filtro selecionado.</b></center></p>
 			</div>
 		<?}?>
		<?php if(isset($pagination)){?>
			<div id="pagination"><?php echo $pagination?></div>
		<?php }?>
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->