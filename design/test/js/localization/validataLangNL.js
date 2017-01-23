(function($){
	$.fn.validataLanguage = {};
	$.validataLanguage = {
		init : function(){
			$.validataLanguage.messages = {
				required	: 'Dit veld is verplicht.',
				email		: 'Vul een geldig email adres in.',
				number		: 'Vul een geldig nummer in.',
				maxLength	: 'Dit veld moet maximaal {count} karakters bevatten.',
				minLength	: 'Dit veld moet minimaal {count} karakters bevatten.',
				maxChecked	: 'Er mogen maximaal {count} opties geselecteerd zijn.',
				minChecked	: 'Er moeten minimaal {count} opties geselecteerd zijn.',
				maxSelected	: 'Er mogen maximaal {count} opties geselecteerd zijn.',
				minSelected	: 'Er moeten minimaal {count} opties geselecteerd zijn.',
				notEqual	: 'Velden komen niet overeen.',
				creditCard	: 'Ongeldig creditcard nummer.',
                tel         : 'Verkeerd telefoonnummer (voorbeeld: (999) 999-99-99).'
			};
		}
	};
	$.validataLanguage.init();
})(jQuery);
