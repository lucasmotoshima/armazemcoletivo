<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTsD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Armazém Coletivo</title>
		<style>
	* {
		margin: 0px;
		padding: 0px;
	}
html, body {
		width: 800px;
		font-family:Geneva, Arial, Helvetica, sans-serif;
		text-align: left;
		font-size: 14px;
		color: #000;
		margin: 0px;
		padding: 0px;
		background: #FFF;
		background-repeat: repeat-x;
	}

body{
	border: 0px solid #808080;
	width: 800px; /*Width of main container*/
	margin: 0 auto; /*Center container on page*/
	margin-bottom: 20px;
}

#maincontainer{
	border: 0px solid red;
	width: 800px; /*Width of main container*/
	margin: 0 auto; /*Center container on page*/
}

#header{
	border: 0px solid red;
	font-size: 10px;
}

	#header #data
	{
		border: 0px solid green;
		width: 745px;
		margin: 15px 00px 0px 20px;
	}

#conteudo{
	border-top: 0px solid gray;
	border-bottom: 0px solid gray;
	margin: 0px 0px 0px 30px;
	width: 735px;
}

	#conteudo #versao
	{
		border: 0px solid black;
		padding: 5px 5px 5px 5px;
		margin-top: 5px;
		background-color: #DDD;
		width: 720px;
	}
	#conteudo div
	{
		border: 0px solid black;
		padding: 3px 0px;
		font-size: 12px;
	}
	#conteudo div div
	{
		border: 0px solid black;
		padding: 7px 0px 0px 15px;
	}
	#conteudo #assinatura
	{
		border: 0px solid black;
		text-align: left;
		width: 720px;
		font-size: 13px;
		padding-top: 15px;
	}
	#conteudo #detalhes
	{
		border-right: 0px solid #BBBBBB;
		border-bottom: 1px solid #DDDDDD;
	}
		#conteudo #detalhes table
		{
			border: 0px solid black;
			width: 730px;
			margin: 10px 0px 0px 0px;
			text-align: left;
		}
			#conteudo #detalhes table tr th
			{
				border-right: 1px solid #BBBBBB;
				border-bottom: 1px solid #BBBBBB;
				background-color: #EEE;
			}
			#conteudo #detalhes table tr td
			{
				border-right: 1px solid #BBBBBB;
				border-bottom: 1px solid #BBBBBB;
				padding: 5px;
				font-size: 10px
			}
	#conteudo #detalhesck
	{
		border-bottom: 1px solid #DDDDDD;
		margin: 0px 0px 10px 0px;
		font-size: 12px;
	}
		#conteudo #detalhesck table
		{
			border: 0px solid black;
			width: 730px;
			margin: 10px 0px 10px 0px;
		}
			#conteudo #detalhesck table tr th
			{
				border-right: 1px solid #444444;
				border-bottom: 0px solid #444444;
				text-align: center;
			}
			#conteudo #detalhesck table tr td
			{
				border-right: 1px solid #BBBBBB;
				border-bottom: 1px solid #BBBBBB;
				padding: 5px;
				text-align: center;
			}
p {
	margin: 0px 0px 0px 30px;
}
#footer{
	margin: 0px 0px 20px 30px;
	width: 735px;	
	padding: 7px 0px 7px 0px;
	background-color: #FFF;
	border-top: 1px solid #666;
	color: black;
	text-align: center;
	font-size: 10px;
}
		</style>
	</head>
<body>
	<div id="maincontainer">
		<div id="header">
			<table border="0">
				<tr>
					<td width="350"><img src="<?=SYS_IMAGE_PATH.'config'.DIRECTORY_SEPARATOR.'logo_mini.png';?>"></td>
					
					<td>				
						São Bento do Sapucaí - SP<br>
					</td>
				</tr>
			</table>
			<div id="data"><?=date('d/m/Y H:i:s')?></div>
			<br><br>
		</div>
		<div id="conteudo">
			<div id="versao">
				<h3>Cliente: <?=$cart[0]['client_name']?></h3>
				<h3>E-mail: <?=$cart[0]['email']?></h3>
				<h3>Telefone: <?=$cart[0]['phone']?></h3>
				<h3>Endereco: <?=$cart[0]['adress'].', '.$cart[0]['number'].', '.$cart[0]['city']?></h3>    
			</div>
			<div id="detalhes">
				<table border='0'>
					<tr>
						<th align="center">Produto</th>
						<th align="center">Quantidade</th>
						<th align="center">Preço Unitátio</th>
						<th align="center">Total</th>
					</tr>
						<?if(count($cart_product)>0){?>
							<?$total_geral = 0;?>
							<?php foreach($cart_product as $index => $row):?>
							<tr>
								<td align="center">
									<img src='<?=$row['photo']['url']?>' width='<?=$row['photo']['w']?>' height='<?=$row['photo']['y']?>'>
									<?=$row['prod_name']?>
								</td>
								<td align="center">*<?=$row['quantity']?></td>
								<td align="center">R$ <?=number_format($row['product_unit_price'], 2, ',', ' ')?></td>
								<td align="center">R$ <?=number_format($row['product_unit_price'] * $row['quantity'], 2, ',', ' ')?></td>
								<?$total_geral =  $total_geral + ($row['product_unit_price'] * $row['quantity'])?>
							</tr>
							<?php endforeach;?>
						<?}else{?>
							<tr class='line1'?>
								<td colspan="6" align="center">not found</td>
							</tr>
						<?}?> 
				</table>
			</div>
			<div style="text-align: right"><h3>Valor Total: R$ <?=(isset($total_geral) and ($total_geral!=0))?number_format($total_geral, 0, ',', ' '):'0'?></h3></div-->
			<div>
				<div>* Estoque sujeito a disponibilidade no momento da compra.</div>
			</div>
		</div>
		<div id="footer">www.armazemcoletivo.vbsbs.com.br</div>
	</div>
</body>
</html>		