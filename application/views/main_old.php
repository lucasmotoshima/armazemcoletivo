<script type="text/javascript">
	function isNumeric(str) {
		var er = /^[0-9]+$/;
		return (er.test(str));
	}
	function addCart(viewName){
		var min_quantity 	= 0;
		var id	 			= $('#id').val();
		var opt_color 		= $('#opt_color').val();
		var quantity 		= $('#quantity').val();
		var qty_colors 		= parseInt($('#qty_colors').val());
		var type_prints 	= $('#type_prints').val();
		if((quantity >= min_quantity) && (isNumeric(quantity)))
		{
			quantity =parseInt($('#quantity').val());
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			var dados		= {id:id,opt_color:opt_color,quantity:quantity, qty_colors: qty_colors, type_prints:type_prints};
			$('#status').html(iconCarregando);
			jQuery.ajax({
			type: "POST",
			url:  viewName,
			data: dados,
			dataType: 'json',
			success: function(resp){
				if(resp.error == null || resp.error == '' || !resp.error || resp.error == false)
				{
					$('#status').html('');
					$('#status').html(resp.msg);
					$('#status').css('color','green');
					$('#carro').append(resp.line);
					$('.sendCart').css('display','block');
				}
				else
				{
					$('#status').html('');
					$('#status').css('color','red');
					$('#status').html(resp.msg);
				}
				},
				async: true
			});
		}
		else
		{
			$('#status').html('...');
			$('#status').html('Verifique la candidad mínima.');
		}
	}
 </script>
<div class="container" >
	<div class="row" style="background-color: #ca9a0026; padding: 0px 15px; border: 1px solid #eadaa7;">
		<div class="col-md-11 col-sm-11 col-xs-11 form-group" style="padding: 15px 0px 0px 0px;">
			<form action="<?=base_url('product/getList')?>" method="post" accept-charset="utf-8" style="margin-bottom: 0;">
				<input type="text" name='search' value="<?=isset($_REQUEST['search'])?$_REQUEST['search']:''?>" class="form-control" />
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1 form-group" style="padding: 15px 0px 0px 0px; text-align: right;">
			<button class="btn btn-success" type="submit">Buscar</button>
			</form>
		</div>
	</div>
	<div>
		<img src="<?=base_url('public/images/sombra_busca.png')?>" style="margin: 0px 0px 0px -10px;" class="d-block img-fluid">
	</div>
</div>
  <!-- Page Content -->
  <div class="container">

    <div class="row">

		<div class="col-lg-12 col-md-12 mb-12" style="border: 1px solid #e8e8e8; margin: 20px 0px 20px 0px; padding: 10px; background-color: #b9b9b933; box-shadow: 2px 2px 2px 2px #88888814;">
			<center>
				<h3>
					Comprar no <b>Armazém Coletivo</b> é <b>fácil</b> e <b>rápido</b>. <br>
					Feche o seu pedido diretamente com o Produtor e pelo <b>WHATSAPP</b>!
				</h3>	
			</center>
		</div>

		<!--div class="col-md-12" style="margin-top: 15px;">
			<img class="d-block img-fluid" src="<?=base_url('public/images/steps_home.jpg')?>">
		</div-->

  		<div class="col-lg-3">
			<?php $this->load->helper('left_sidebar');?>
  		</div>

      	<div class="col-lg-9">
			
			<div class="row">
				<?php echo $this->banner->show();?>
				<div class="alertaHome">Proteja-se contra a COVID-19. Siga as instruções de precaução e fique em casa. </div>
			</div>
	        <div class="row">
			<?php foreach($result as $index => $row){?>
	          <div class="col-lg-4 col-md-6 mb-4">
	            <div class="card h-100">
	            	<p class="card-img-top"><a href="<?php echo base_url('product/detail/'.$row['id'])?>"><img class="card-img-top" src="<?php echo $row['photo_url']?>" alt="<?php echo $row['name']?>" width='<?php echo $row['photo_w']?>' height='<?php echo $row['photo_h']?>'></a></p>
	              	<div class="card-body">
		                <h2><a href="<?php echo base_url('product/detail/'.$row['id'])?>"><?php echo $row['name']?></a></h2>
		                <p class="card-text"><a href="<?php echo base_url('product/detail/'.$row['id'])?>"><?php echo $row['description']?></a></p>
		                <p class="card-text">
		                	<div style="background-color: #f7f7f7; padding: 10px 10px 15px 10px;">
			                	<center>
									<a title="Compartilhar página de <?=$row['provider'];?> no WhatsApp" href="https://api.whatsapp.com/send?text=<?=base_url('product/detail/'.$row['id'])?>"><img src="<?=base_url('public/images/whatsapp_share.gif')?>"></a>
									<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?=base_url('product/detail/'.$row['id'])?>" target="_blank" title="Compartilhar página de <?=$row['provider'];?> no Facebook"><img src="<?=base_url('public/images/facebook_share.gif')?>"></a>
								</center>
							</div>		                		
		                </p>		                
		                <p>
	                		<center><a href="<?php echo base_url('product/getByProvider/'.$row['provider_id'])?>"><img src="<?=base_url('admin/public/images/provider/'.$row['provider_image'])?>" style="width: 80px; height: 40px; border-radius: 20px; margin: 0px 5px 0px 0px;"></a></center>
	                		<center><a href="<?php echo base_url('product/getByProvider/'.$row['provider_id'])?>"><small><?php echo $row['provider']?></small></a></center>
		                </p>
	              	</div>
	              <div class="card-footer">
	                <small class="text-muted"><h4><a href="<?php echo base_url('product/detail/'.$row['id'])?>">R$ <?php echo str_replace('.', ',', $row['price']) ?></a></h4></small>
	              </div>
	            </div>
	          </div>
			<?php }?>
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