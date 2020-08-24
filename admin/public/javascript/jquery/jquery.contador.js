/**
 * Contador: Plugin jQuery para contagem de caracteres restantes num campo input ou textarea.
 *
 * Autor: tmferreira
 * Blog: http://www.tmferreira.com.br/blog/
 * E-mail: tmferreira@bol.com.br
 *
 */

jQuery.fn.contador = function(opcoes) {
	opcoes = jQuery.extend({
		max: $(this).attr('maxlength'),				//Número máximo de caracteres no campo.
		mensagem: 'Restam $cont caracteres.',		//Texto que será exibido para os caracteres restantes. Obrigatório o $cont.
		elemento: 'div',							//Tipo do elemento que mostrará a quantidade de caracteres restantes.
		elementoId: $(this).attr('id'),				//ID do elemento que mostrará a quantidade de caracteres restantes.
		elementoClasse: 'contador',					//Nome da classe CSS do elemento que mostrará a quantidade de caracteres restantes.
		elementoInsert: 'depois'					//Posição do elemento que mostrará a quantidade de caracteres restantes em relação ao campo texto. Aceita 'antes' ou 'depois'.
	}, opcoes);
	$(this).each(function() {
		var val = $(this).val().length;
		var cur = (val > 0) ? val : 0;
		var resta = opcoes.max - cur;
		var mensagem = opcoes.mensagem.replace('$cont', resta.toString());
		
		opcoes.elementoId += "_" + opcoes.elemento;
		var elemento = "<"+opcoes.elemento+" id='"+opcoes.elementoId+"' class='"+opcoes.elementoClasse+"'>"+mensagem+"</"+opcoes.elemento+">";
		if (opcoes.elementoInsert == 'depois') {
			$(this).after(elemento);
		} else if (opcoes.elementoInsert == 'antes') {
			$(this).before(elemento);
		}
		$(this).keyup(function(e) {
			atualiza($(this));
		});
		$(this).blur(function() {
			atualiza($(this));
		});
		var atualiza = function(campo) {
			var val = campo.val().length;
			var cur = (val > 0) ? val : 0;
			var resta = opcoes.max-cur;
			if (resta <= 0) {
				campo.val(campo.val().substr(0, opcoes.max));
				resta = 0;
			}
			var mensagem = opcoes.mensagem.replace('$cont', resta.toString());
			$("#"+opcoes.elementoId).text(mensagem);
			return campo;
		};
	});
	return this;
};