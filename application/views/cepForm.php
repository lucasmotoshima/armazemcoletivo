	<div class="container cep" style="margin: 0px 0px 10px 0px">
		<div class="row" style="background-color: #f7f0d9;border: 1px solid #eadaa7; padding: 0px 15px; border: 1px solid #eadaa7;">
			<div class="col-md-7 col-sm-6 col-xs-7 form-group" style="padding: 15px 0px 0px 0px;">
				<form action="<?=base_url('product/buscaCEP')?>" method="post" accept-charset="utf-8" style="margin-bottom: 0;">
					<input type="text" id="search" name='search' value="<?=isset($_SESSION['armazem']['user']['cep'])?$_SESSION['armazem']['user']['cep']:''?>" class="form-control" placeholder="Insira seu CEP"/>
			</div>
			<div class="col-md-5 col-sm-6 col-xs-5 form-group" style="padding: 15px 0px 0px 0px; text-align: right;">
				<button class="btn btn-success" type="submit">Buscar</button>
				</form>
			</div>
			<?if(isset($_SESSION['armazem']['user']['localidade'])){?>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="color: #666666; font-size: 14px; margin: 0px 0px 5px 0px;">
					<strong><?=isset($_SESSION['armazem']['user']['localidade'])?$_SESSION['armazem']['user']['localidade'].' - '.$_SESSION['armazem']['user']['uf']:''?></strong>
					<a href="<?=base_url('product/unsetCEP')?>">
						<img src="<?=base_url('public/images/ico_excluir.png')?>" style="float: right;">
					</a>
				</div>
			<?}?>
		</div>
		<div>
			<img src="<?=base_url('public/images/sombra_busca.png')?>" style="margin: 0px 0px 0px -10px;" class="d-block img-fluid">
		</div>
	</div>	
