<script type="text/javascript">
$(document).ready(function(){
	$('.phone').mask('(99) 9 9999 9999');
});
	
	
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

<section style="border: 1px solid #e8e8e8; margin: 20px 0px 20px 0px; padding: 10px; background-color: #f1f1f1; box-shadow: 2px 2px 2px 2px #88888814;">
		<center>
			<h3>
				Comprar no <b>Armazém Coletivo</b> é <b>fácil</b> e <b>rápido</b>. <br>
				Feche o seu pedido diretamente com o Produtor e pelo <b>WHATSAPP</b>!
			</h3>	
		</center>
</section>
  <!-- Page Content -->
  <div class="container">
    <div class="row">

		<!--div class="col-md-12" style="margin-top: 15px;">
			<img class="d-block img-fluid" src="<?=base_url('public/images/steps_home.jpg')?>">
		</div-->

  		<div class="col-lg-3">
  			<?if($controller=='main'){
				$this->load->view('cepForm');  				
  			}?>
			<?php $this->load->helper('left_sidebar');?>
  		</div>

      	<div class="col-lg-9">

			<div class="row">
				<?php echo $this->banner->show();?>
				<div  class="chamadaHome" style="color: #777777; width: 100%; display: table; border: 1px solid #CCC; padding: 10px; text-align: center; margin: 0px 0px 10px 0px; background-color: #f5f5f5;">
					<a href="https://www.blog.armazemcoletivo.com.br" style="text-decoration: none; color: #777777;">
						Clique aqui e se cadastre para participar da nossa <b style="color: #FFD242;">Aula Online Grátis</b>
					</a>
				</div>
				<div class="alertaHome">Proteja-se contra a COVID-19. Siga as instruções de precaução e fique em casa. </div>
				<div class="chamadaHome" style="color: #777777; width: 100%; display: table; border: 1px solid #CCC; padding: 10px; text-align: center; margin: 0px 0px 10px 0px; background-color: #f5f5f5;">
					<a href="<?=base_url('/profissional/cadastro')?>" style="text-decoration: none; color: #777777;">
						Sou <b style="color: #FFD242;">Profissional Liberal</b> e quero me cadastrar no <b style="color: #FFD242;">Armazém Coletivo</b>
					</a>
				</div>
			</div>
			<?//$this->debug->show($resultCat);?>
			<div class="row" style="background-color: #efefef; margin-bottom: 10px;">
				<div class="col-lg-12 col-md-12 mb-12">
					<small style="font-size: 12px; color: #888888;">Veja também <b><?=$resultCat[0]['category_name']?></b></small>
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

			<div class="row" style="background-color: #efefef; margin-bottom: 10px;">
				<div class="col-lg-12 col-md-12 mb-12">
					<small style="font-size: 12px; color: #888888;">Veja também os <b>SERVIÇOS</b> de Parceiros:</small>
				</div>
				<?$this->load->view('profissional/list',$prof);	?>
			</div>
	        	
	        <div class="row">	
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