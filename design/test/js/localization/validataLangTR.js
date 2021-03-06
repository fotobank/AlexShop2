(function($){
	$.fn.validataLanguage = {};
	$.validataLanguage = {
		init : function(){
			$.validataLanguage.messages = {
				required	: 'Bu alanı doldurmanız gerekli. Lütfen kontrol ediniz.',
				email		: 'Eposta adresiniz geçersiz görünüyor. Lütfen kontrol ediniz.',
				number		: 'Bu alana sadece rakam girişi yapabilirsiniz.',
				maxLength	: 'En fazla {count} karakter girebilirsiniz !',
				minLength	: 'En az {count} karakter girmelisiniz!',
				maxChecked	: 'En fazla {count} seçim yapabilirsiniz. Lütfen kontrol ediniz.',
				minChecked	: 'En az {count} seçim yapmalısınız. Lütfen kontrol ediniz.',
				maxSelected : 'En fazla {count} seçim yapabilirsiniz. Lütfen kontrol ediniz.',
				minSelected : 'En az {count} seçim yapmalısınız. Lütfen kontrol ediniz.',
				notEqual	: 'Alanlar birbiriyle oyuşmuyor. Lütfen kontrol ediniz',
				different   : 'Alanlar birbirlerinden farklı olmalı.',
				creditCard	: 'Kredi kartı numarası geçersiz. Lütfen kontrol ediniz.',
                tel         : 'Geçersiz telefon numarası (örnek: (999) 999-99-99).'
			};
		}
	};
	$.validataLanguage.init();
})(jQuery);