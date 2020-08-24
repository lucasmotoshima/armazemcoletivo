		<table border='1'>
			<tr>
			<?foreach ($result as $key => $value) {
				echo '<td rowspan="7">';
					echo '<img src="'.$value['product_photo']['url'].'" width="'.$value['product_photo']['w'].'" height="'.$value['product_photo']['h'].'">';
				echo '</td>';
				echo '<tr>';
					echo '<td>';
						echo '<strong>P'.str_pad($value['prod_id'], 4, "0", STR_PAD_LEFT).' - '.$value['prod_name'].'</strong>';
						echo '<br>';
						echo $value['product']['description'];
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Cantidad: '. $value['quantity'];
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Fecha: '.$this->format_date->us2br($cart['date']);
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Precio Original: '.number_format($value['product_original_sale_price'], 2, ',', '.');
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Precio com Descuento: '.number_format($value['cart_product_m']['product_total'], 2, ',', '.');
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<strong>Total: '.number_format($value['cart_product_m']['sale_total'], 2, ',', '.').'</strong>';
					echo '</td>';
			echo '</tr>';
			echo '<tr>';
					echo '<td colspan="2"></td>';
			echo '</tr>';			
			}?>
		</table>