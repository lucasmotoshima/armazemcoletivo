<?php
	if(isset($_REQUEST['id'])){
		$hidden = array('id' => $_REQUEST['id']);
	}
	
	$client_name = array(
      'name'        => 'client_name',
      'id'          => 'client_name',
      'value'       => (isset($_REQUEST['client_name'])?$_REQUEST['client_name']:''),
      'class'       => 'form-control',
    );
	
	$city = array(
      'name'        => 'city',
      'id'          => 'city',
      'value'       => (isset($_REQUEST['city'])?$_REQUEST['city']:''),
      'class'       => 'form-control',
    );
	
	$email = array(
      'name'        => 'email',
      'id'          => 'email',
      'value'       => (isset($_REQUEST['email'])?$_REQUEST['email']:''),
      'class'       => 'form-control',
    );
	
	$ddd = array(
	  '11'			=> '11',
	  '12'			=> '12',
	  '13'			=> '13',
	  '14'			=> '14',
	  '15'			=> '15',
	  '19'			=> '19',
	  '35'			=> '35',
	 );
	
	$phone = array(
      'name'        => 'phone',
      'id'          => 'phone',
      'value'       => (isset($_REQUEST['phone'])?$_REQUEST['phone']:'9'),
      'class'       => 'form-control',
    );

	$adress = array(
      'name'        => 'adress',
      'id'          => 'street',
      'value'       => (isset($_REQUEST['adress'])?$_REQUEST['adress']:''),
      'class'       => 'form-control',
    );
	$number = array(
      'name'        => 'number',
      'id'          => 'number',
      'value'       => (isset($_REQUEST['number'])?$_REQUEST['number']:''),
      'class'       => 'form-control',
    );
	$obs = array(
      'name'        => 'obs',
      'id'          => 'obs',
      'value'       => (isset($_REQUEST['obs'])?$_REQUEST['obs']:''),
      'class'       => 'form-control',
    );
?>
<script type="text/javascript"> 
// jQuery Mask Plugin v1.14.16
// github.com/igorescobar/jQuery-Mask-Plugin
var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.findInternal=function(a,n,f){a instanceof String&&(a=String(a));for(var p=a.length,k=0;k<p;k++){var b=a[k];if(n.call(f,b,k,a))return{i:k,v:b}}return{i:-1,v:void 0}};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;
$jscomp.defineProperty=$jscomp.ASSUME_ES5||"function"==typeof Object.defineProperties?Object.defineProperty:function(a,n,f){a!=Array.prototype&&a!=Object.prototype&&(a[n]=f.value)};$jscomp.getGlobal=function(a){return"undefined"!=typeof window&&window===a?a:"undefined"!=typeof global&&null!=global?global:a};$jscomp.global=$jscomp.getGlobal(this);
$jscomp.polyfill=function(a,n,f,p){if(n){f=$jscomp.global;a=a.split(".");for(p=0;p<a.length-1;p++){var k=a[p];k in f||(f[k]={});f=f[k]}a=a[a.length-1];p=f[a];n=n(p);n!=p&&null!=n&&$jscomp.defineProperty(f,a,{configurable:!0,writable:!0,value:n})}};$jscomp.polyfill("Array.prototype.find",function(a){return a?a:function(a,f){return $jscomp.findInternal(this,a,f).v}},"es6","es3");
(function(a,n,f){"function"===typeof define&&define.amd?define(["jquery"],a):"object"===typeof exports&&"undefined"===typeof Meteor?module.exports=a(require("jquery")):a(n||f)})(function(a){var n=function(b,d,e){var c={invalid:[],getCaret:function(){try{var a=0,r=b.get(0),h=document.selection,d=r.selectionStart;if(h&&-1===navigator.appVersion.indexOf("MSIE 10")){var e=h.createRange();e.moveStart("character",-c.val().length);a=e.text.length}else if(d||"0"===d)a=d;return a}catch(C){}},setCaret:function(a){try{if(b.is(":focus")){var c=
b.get(0);if(c.setSelectionRange)c.setSelectionRange(a,a);else{var g=c.createTextRange();g.collapse(!0);g.moveEnd("character",a);g.moveStart("character",a);g.select()}}}catch(B){}},events:function(){b.on("keydown.mask",function(a){b.data("mask-keycode",a.keyCode||a.which);b.data("mask-previus-value",b.val());b.data("mask-previus-caret-pos",c.getCaret());c.maskDigitPosMapOld=c.maskDigitPosMap}).on(a.jMaskGlobals.useInput?"input.mask":"keyup.mask",c.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){b.keydown().keyup()},
100)}).on("change.mask",function(){b.data("changed",!0)}).on("blur.mask",function(){f===c.val()||b.data("changed")||b.trigger("change");b.data("changed",!1)}).on("blur.mask",function(){f=c.val()}).on("focus.mask",function(b){!0===e.selectOnFocus&&a(b.target).select()}).on("focusout.mask",function(){e.clearIfNotMatch&&!k.test(c.val())&&c.val("")})},getRegexMask:function(){for(var a=[],b,c,e,t,f=0;f<d.length;f++)(b=l.translation[d.charAt(f)])?(c=b.pattern.toString().replace(/.{1}$|^.{1}/g,""),e=b.optional,
(b=b.recursive)?(a.push(d.charAt(f)),t={digit:d.charAt(f),pattern:c}):a.push(e||b?c+"?":c)):a.push(d.charAt(f).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));a=a.join("");t&&(a=a.replace(new RegExp("("+t.digit+"(.*"+t.digit+")?)"),"($1)?").replace(new RegExp(t.digit,"g"),t.pattern));return new RegExp(a)},destroyEvents:function(){b.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(a){var c=b.is("input")?"val":"text";if(0<arguments.length){if(b[c]()!==a)b[c](a);
c=b}else c=b[c]();return c},calculateCaretPosition:function(a){var d=c.getMasked(),h=c.getCaret();if(a!==d){var e=b.data("mask-previus-caret-pos")||0;d=d.length;var g=a.length,f=a=0,l=0,k=0,m;for(m=h;m<d&&c.maskDigitPosMap[m];m++)f++;for(m=h-1;0<=m&&c.maskDigitPosMap[m];m--)a++;for(m=h-1;0<=m;m--)c.maskDigitPosMap[m]&&l++;for(m=e-1;0<=m;m--)c.maskDigitPosMapOld[m]&&k++;h>g?h=10*d:e>=h&&e!==g?c.maskDigitPosMapOld[h]||(e=h,h=h-(k-l)-a,c.maskDigitPosMap[h]&&(h=e)):h>e&&(h=h+(l-k)+f)}return h},behaviour:function(d){d=
d||window.event;c.invalid=[];var e=b.data("mask-keycode");if(-1===a.inArray(e,l.byPassKeys)){e=c.getMasked();var h=c.getCaret(),g=b.data("mask-previus-value")||"";setTimeout(function(){c.setCaret(c.calculateCaretPosition(g))},a.jMaskGlobals.keyStrokeCompensation);c.val(e);c.setCaret(h);return c.callbacks(d)}},getMasked:function(a,b){var h=[],f=void 0===b?c.val():b+"",g=0,k=d.length,n=0,p=f.length,m=1,r="push",u=-1,w=0;b=[];if(e.reverse){r="unshift";m=-1;var x=0;g=k-1;n=p-1;var A=function(){return-1<
g&&-1<n}}else x=k-1,A=function(){return g<k&&n<p};for(var z;A();){var y=d.charAt(g),v=f.charAt(n),q=l.translation[y];if(q)v.match(q.pattern)?(h[r](v),q.recursive&&(-1===u?u=g:g===x&&g!==u&&(g=u-m),x===u&&(g-=m)),g+=m):v===z?(w--,z=void 0):q.optional?(g+=m,n-=m):q.fallback?(h[r](q.fallback),g+=m,n-=m):c.invalid.push({p:n,v:v,e:q.pattern}),n+=m;else{if(!a)h[r](y);v===y?(b.push(n),n+=m):(z=y,b.push(n+w),w++);g+=m}}a=d.charAt(x);k!==p+1||l.translation[a]||h.push(a);h=h.join("");c.mapMaskdigitPositions(h,
b,p);return h},mapMaskdigitPositions:function(a,b,d){a=e.reverse?a.length-d:0;c.maskDigitPosMap={};for(d=0;d<b.length;d++)c.maskDigitPosMap[b[d]+a]=1},callbacks:function(a){var g=c.val(),h=g!==f,k=[g,a,b,e],l=function(a,b,c){"function"===typeof e[a]&&b&&e[a].apply(this,c)};l("onChange",!0===h,k);l("onKeyPress",!0===h,k);l("onComplete",g.length===d.length,k);l("onInvalid",0<c.invalid.length,[g,a,b,c.invalid,e])}};b=a(b);var l=this,f=c.val(),k;d="function"===typeof d?d(c.val(),void 0,b,e):d;l.mask=
d;l.options=e;l.remove=function(){var a=c.getCaret();l.options.placeholder&&b.removeAttr("placeholder");b.data("mask-maxlength")&&b.removeAttr("maxlength");c.destroyEvents();c.val(l.getCleanVal());c.setCaret(a);return b};l.getCleanVal=function(){return c.getMasked(!0)};l.getMaskedVal=function(a){return c.getMasked(!1,a)};l.init=function(g){g=g||!1;e=e||{};l.clearIfNotMatch=a.jMaskGlobals.clearIfNotMatch;l.byPassKeys=a.jMaskGlobals.byPassKeys;l.translation=a.extend({},a.jMaskGlobals.translation,e.translation);
l=a.extend(!0,{},l,e);k=c.getRegexMask();if(g)c.events(),c.val(c.getMasked());else{e.placeholder&&b.attr("placeholder",e.placeholder);b.data("mask")&&b.attr("autocomplete","off");g=0;for(var f=!0;g<d.length;g++){var h=l.translation[d.charAt(g)];if(h&&h.recursive){f=!1;break}}f&&b.attr("maxlength",d.length).data("mask-maxlength",!0);c.destroyEvents();c.events();g=c.getCaret();c.val(c.getMasked());c.setCaret(g)}};l.init(!b.is("input"))};a.maskWatchers={};var f=function(){var b=a(this),d={},e=b.attr("data-mask");
b.attr("data-mask-reverse")&&(d.reverse=!0);b.attr("data-mask-clearifnotmatch")&&(d.clearIfNotMatch=!0);"true"===b.attr("data-mask-selectonfocus")&&(d.selectOnFocus=!0);if(p(b,e,d))return b.data("mask",new n(this,e,d))},p=function(b,d,e){e=e||{};var c=a(b).data("mask"),f=JSON.stringify;b=a(b).val()||a(b).text();try{return"function"===typeof d&&(d=d(b)),"object"!==typeof c||f(c.options)!==f(e)||c.mask!==d}catch(w){}},k=function(a){var b=document.createElement("div");a="on"+a;var e=a in b;e||(b.setAttribute(a,
"return;"),e="function"===typeof b[a]);return e};a.fn.mask=function(b,d){d=d||{};var e=this.selector,c=a.jMaskGlobals,f=c.watchInterval;c=d.watchInputs||c.watchInputs;var k=function(){if(p(this,b,d))return a(this).data("mask",new n(this,b,d))};a(this).each(k);e&&""!==e&&c&&(clearInterval(a.maskWatchers[e]),a.maskWatchers[e]=setInterval(function(){a(document).find(e).each(k)},f));return this};a.fn.masked=function(a){return this.data("mask").getMaskedVal(a)};a.fn.unmask=function(){clearInterval(a.maskWatchers[this.selector]);
delete a.maskWatchers[this.selector];return this.each(function(){var b=a(this).data("mask");b&&b.remove().removeData("mask")})};a.fn.cleanVal=function(){return this.data("mask").getCleanVal()};a.applyDataMask=function(b){b=b||a.jMaskGlobals.maskElements;(b instanceof a?b:a(b)).filter(a.jMaskGlobals.dataMaskAttr).each(f)};k={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,keyStrokeCompensation:10,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&
k("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}};a.jMaskGlobals=a.jMaskGlobals||{};k=a.jMaskGlobals=a.extend(!0,{},k,a.jMaskGlobals);k.dataMask&&a.applyDataMask();setInterval(function(){a.jMaskGlobals.watchDataMask&&a.applyDataMask()},k.watchInterval)},window.jQuery,window.Zepto);
</script>
<script type="text/javascript"> 
$(document).ready(function(){
	$('#phone').mask('9 9999 9999');
	
	$('#status').css('display','block');
	$('.excluir').click(function(e) {
		var r = confirm("Deseja realmente excluir?");
		if (r==true)
		{
			var id 				= $(this).attr('idproduct');
			var iconAlerta 		= $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
			var iconConf 		= $('<img src="<?=base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
			var iconCarregando 	= $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
			var total			= 0;
			var priceProd		= 0;
			var novoTotal		= 0;
			e.preventDefault();
			$('#status').ajaxStart(function() {
				var iconCarregando = $('<img src="<?=base_url()?>public/images/icones/loading.gif" class="icon" /> aguarde...');
				$('#status').html(iconCarregando);
			});
			$.get('<?=base_url()?>cart/deleteProduct/'+id, 
				function(data) {
					var returnedData = JSON.parse(data);
					if(returnedData.erro==false)
					{
						$('#status').html(returnedData.msg);
						$("#status").prepend(iconConf).show();
						var field					= 'product_total_price_'+id;
						
				        var num1 = document.getElementById('total').value;
				        num1 = num1.replace(",", ".");

				        var num2 = document.getElementById(field).value;
				        num2 = num2.replace(",", ".");
				        
						var result = parseFloat(num1) - parseFloat(num2);
				        if (!isNaN(result)) {
				            document.getElementById('total').value = result;
							$('#td_total').html();
							$('#td_total').html('<b> '+result.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+'</b>');
							$('#product'+id).fadeOut(200);
				        }
						return true;
					}
					else
					{
						$("#status").html(iconAlerta).show();
						$('#status').prepend(returnedData.msg);
						return false;
					}
				},
			'html');
		}
		return false;
	});

	$("#cartForm").submit(function (event){
    	var msg = 'Campos obrigatórios: ';
    	var iconAlerta = $('<img src="<?=base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
    	var erro = false;
		if ( $("#client_name" ).val() == "" ) {
			msg = msg + 'Nome, ';
			erro = true;
		}
		if ( $("#email" ).val() == "" ) {
			msg = msg + 'Email, ';
			erro = true;
		}
		if ( $("#phone" ).val() == "" ) {
			msg = msg + 'Telefone, ';
			erro = true;
		}
		if ( $("#adress" ).val() == "" ) {
			msg = msg + 'Rua, ';
			erro = true;
		}
		if ( $("#number" ).val() == "" ) {
			msg = msg + 'n.';
			erro = true;
		}
		if ( $("city" ).val() == "" ) {
			msg = msg + 'Cidade.';
			erro = true;
		}
		if($("#termo_uso").prop('checked') == false){
			msg = msg + 'Leia e Aceite os "Termos de Uso", ';
			erro = true;
		}
		if($("#politica_privacidade").prop('checked') == false){
			msg = msg + 'Leia e Aceite os "Políticas de Privacidade", ';
			erro = true;
		}
		if(erro){
			alert(msg);
			event.preventDefault();
			return false;
		}
		else{
			return true;
		}
	});

});
</script>

<!-- Page Content -->
<div class="container">
	<div class="row" style="text-align: center;">
		<div class="col-lg-12 col-md-12 mb-12" style="margin: 20px 0px 30px 0px; padding: 30px; background-color: #FFD242; border-radius: 10px;">
			<center>
				<h4>Já estamos finalizando o seu pedido. <br>Basta inserir seus dados e clicar em ENVIAR e o seu <b>WhatsApp</b> vai abrir no contato do Produtor com a sua lista de produtos.</h4>	
			</center>
		</div>
	</div>
	<div class="row">
		
		<div class="col-lg-6">
			<h2 style="background-color: #e8e8e8; border-radius: 5px; padding: 5px 10px;">Seu carrinho de compras<span class="title-bottom">&nbsp;</span></h2>
			<div class="budget" style="border: 0;">
				<span id="status" style="display: block; text-align: center;">
					<?php if(isset($_REQUEST[0]['status'])){?>
						<?php echo ($_REQUEST[0]['status']!='W')?'Pedido enviado...':''?>
					<?php }else{?>
						<?php echo '<b style="color: #d60000;">Carro de compras vazio.</b>'?>
					<?php }?>
				</span>
				<?$tot = 0?>
				<?php if(count($result)!=0){?>
					<table class='cart table'>
						<tr>
							<th>Produto</th>
							<th align="center">Quantidade</th>
							<th>Valor Unitário</th>
							<th>Valor Total</th>
							<th align="center">Ações</th>
						</tr>
					<?php foreach($result as $index => $row){?>
						<tr id='product<?php echo $row['id']?>'>
							<td>
								<i> <?php $row['prod_code_origin']?></i> 
									<?php echo $row['prod_name']?>	
							</td>
							<td><?php echo $row['quantity']?></td>
							<td>R$ <? echo number_format($row['product_unit_price'], 2, ',', ' ');?><input name="product_unit_price" id="product_unit_price" type="hidden" value="<?=number_format($row['product_unit_price'], 2, ',', ' ');?>"></td>
							<?$tot = $tot + $row['product_total_price']?>
							<td>R$ <? echo number_format($row['product_total_price'], 2, ',', ' ');?><input name="product_total_price" id="product_total_price_<?=$row['id']?>" type="hidden" value="<?=number_format($row['product_total_price'], 2, ',', ' ');?>"></td>
							<td>
								<a href="<?php echo base_url('cart/deleteProduct/'.$row['id'].'')?>" class='excluir' idproduct='<?=$row['id']?>'>
									<img src="<?php echo base_url('public/images/icones/ico_excluir.png')?>">
								</a>
							</td>
						</tr>
					<?php }?>
						<tr>
							<td colspan="3" align="right" style="text-align: right;"><b>Total</b></td>
							<td id="td_total"><b>R$ <? echo number_format($tot, 2, ',', ' ');?></b></td>
							<td></td>
						</tr>
					</table>
					<input name="total" id="total" type="hidden" value="<?=$tot;?>">
				<?php }else{}?>
			</div>
			
			<?php if(count($result)!=0){?>
				<?php $attributes = array('name' => 'cartForm', 'id' => 'cartForm','enctype'=>'multipart/form-data');?>
				<?php echo form_open('cart/save',$attributes,isset($hidden)?$hidden:'');?>
				<h2 style="background-color: #e8e8e8; border-radius: 5px; padding: 5px 10px;">Insira seus dados<span class="title-bottom">&nbsp;</span></h2>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Nome </label>
						<?php echo form_input($client_name)?>
					</div>
				
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Email * </label>				
						<?php echo form_input($email)?>
					</div>
					
					<div class="row" style="margin: 0;">
						<div class="col-md-5 col-sm-5 col-xs-5 form-group">
							<label>Telefone (DDD) * </label>
							<?php echo form_dropdown('ddd',$ddd,'11','class="form-control"')?>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7 form-group">
							<label>Telefone (Whatsapp) * </label>
							<?php echo form_input($phone)?>
						</div>
					</div>

					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Rua * </label>
						<?php echo form_input($adress)?>
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Número * </label>
						<?php echo form_input($number)?>
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Cidade * </label>
						<?php echo form_input($city)?>
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label>Mensagem </label>
						<?php echo form_textarea($obs)?>
					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="background-color: #e8e8e8; padding: 20px 10px 2px 10px;">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<input type="checkbox" name="termo_uso" id="termo_uso"/>
							<label>Lí e aceito os <a target="_blank" style="color: #3C3C3C; text-decoration: underline;" href="<?=base_url('cart/getTermoUso')?>">"Termos de Uso"</a> .</label>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<input type="checkbox" name="politica_privacidade" id="politica_privacidade"/>
							<label>Lí e aceito as <a target="_blank" style="color: #3C3C3C; text-decoration: underline;" href="<?=base_url('cart/getTermoPrivacidade')?>">"Políticas de Privacidade"</a> .</label>
						</div>
					</div>

					<input type="submit" class="btn btn-success" value="Enviar" style="width: 100%"/><i>* Campos Obrigatórios</i>
				<?php echo form_close()?>
			<?php }?>
			
		</div>
		
		<div class="col-lg-6">
			
			<div class="col-lg-12 col-md-12 mb-12" style="margin-bottom: 20px; padding: 20px 20px 20px 20px; border-radius: 5px; background-color: #e8e8e8">
				<center>
					<h4>Forma de Pagamento:</h4>	
					Recebemos os <b>pagamentos</b> na entrega em <b>dinheiro</b>, <b>cartão</b> ou <b>outra maneira</b> que vamos combinar por Whatsapp.
				</center>
			</div>
			<div class="col-md-12">
				<center><a href='<?php echo base_url()?>' class="btn btn-success" style="width: 100%;">Continuar Comprando</a></center>
				<br>
			</div>
			
		</div>
	</div>
</div>
