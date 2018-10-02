'use strict';

(function ($) {
	var $configs = $('#configs'),
	    tmp = '';

	$.get('./php/configs.php').done(function (data) {
		data = JSON.parse(data);
		data.files.forEach(function (el, i) {
			$.ajax({
				url: './js/config/' + el,
				dataType: 'text',
				success: function success(data) {
					var isValid = isValidJSON(data),
					    cls = isValid === true ? 'success' : 'danger',
					    details = isValid === true ? '' : isValid;

					$configs.html($configs.html() + ('<li class=\'list-group-item list-group-item-' + cls + '\'>' + el + '<div class=\'list-group-item-text\'>' + details + '</div></li>'));
				}
			});
		});
	});
})(jQuery);

var isValidJSON = function isValidJSON(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return e;
	}
	return true;
};
