(function($){
	$.fn.validataLanguage = {};
	$.validataLanguage = {
		init : function(){
			$.validataLanguage.messages = {
				required	: 'Preencha este campo.',
				email		: 'Insira um endereço de e-mail válido.',
				number		: 'Insira apenas números.',
				maxLength	: 'Insira no máximo {count} caracteres.',
				minLength	: 'Insira no mínimo {count} caracteres.',
				maxChecked	: 'Marque no máximo {count} opções.',
				minChecked	: 'Marque no mínimo {count} opções.',
				maxSelected : 'Selecione no máximo {count} itens',
				minSelected : 'Selecione no mínimo {count} itens',
				notEqual	: 'Os campos não são iguais.',
				different   : 'Fields cannot be the same as each other',
				creditCard	: 'Número do cartão de crédito inválido.',
                tel         : 'Número de telefone errado (exemplo: (999) 999-99-99).'
			};
		}
	};
	$.validataLanguage.init();
})(jQuery);