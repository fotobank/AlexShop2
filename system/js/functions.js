function bookmarkthis(title, url) {
	if (window.sidebar) { // Firefox
		window.sidebar.addPanel(title, url, "");
	} else if (document.all) { // IE
		window.external.AddFavorite(url, title);
	} else if (window.opera && window.print) { // Opera
		alert("Нажмите CTRL-D, чтобы добавить страницу в закладки.");
		var mbm = a;
		mbm.setAttribute("rel", "sidebar");
		mbm.setAttribute("title", document.title);
		mbm.setAttribute("href", window.location.href);
		mbm.click();
	}
}


// фильтр входных даннных
(function ($) {
	$.fn.data_filter = function (html) {

		html = $.trim(html.match(/{{.*}}/g));
		html = html.slice(2, (html.length -2));
		return html;
	}
})(jQuery);

// исправление ошибки Safari при смене расположения на lancastre
var viewportmeta = document.querySelector && document.querySelector('meta[name="viewport"]'),
		ua = navigator.userAgent,
		gestureStart = function () {
			viewportmeta.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";
		},

		scaleFix = function () {
			if (viewportmeta && /iPhone|iPad/.test(ua) && !/Opera Mini/.test(ua)) {
				viewportmeta.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
				document.addEventListener("gesturestart", gestureStart, false);
			}
		};
scaleFix();

function log () {
	return 'console' in window ? console.info.apply(console, arguments) : null;
}

function SendForm() {
	document.getElementById('sendcalendar').submit();
}

function HomePage(page) {
	var HP = document.getElementById("HP");
	HP.onclick = document.all && !window.opera ?
			function () {
				this.style.behavior = 'url(#default#homepage)';
				this.setHomePage(HomePage)
			}
			: function () {
		if (window.netscape && window.netscape.security) {
			netscape.security.PrivilegeManager.enablePrivilege('UniversalPreferencesRead');
			if (navigator.preference('browser.startup.homepage') != HomePage) {
				netscape.security.PrivilegeManager.enablePrivilege('UniversalPreferencesWrite');
				navigator.preference('browser.startup.homepage', HomePage);
			}
		}
	}
}

var CanSlide = false;
function SetNew() {
	if (CanSlide == true) $.prettyPhoto.changePage('next');
	setTimeout("SetNew()", 3000);
}

function StartSlideShow() {
	CanSlide = true;
	$('.pp_play').css('opacity', '0.4');
	$('.pp_stop').css('opacity', '1');

}

function StopSlideShow() {
	CanSlide = false;
	$('.pp_play').css('opacity', '1');
	$('.pp_stop').css('opacity', '0.4');
}
setTimeout("SetNew()", 3000);
//Timer

function myclock() {
	var hours;
	var mins;
	var time;
	ndata = new Date();
// Получение данных о дате и времени
	monts = (ndata.getMonth() + 1)
	days = (ndata.getDate() )
	hours = ndata.getHours();
	mins = ndata.getMinutes();
	secs = ndata.getSeconds();
	year = ndata.getYear() + 1900;
// Дополнение нулем слева
	if (monts < 10) {
		monts = "0" + monts
	}
	if (days < 10) {
		days = "0" + days
	}
	if (hours < 10) {
		hours = "0" + hours
	}
	if (mins < 10) {
		mins = "0" + mins
	}
	if (secs < 10) {
		secs = "0" + secs
	}
// Данные для вывода
	datastr = '' + days + "." + monts + "." + year + '&nbsp;&nbsp;&nbsp;&nbsp;' + hours + ":" + mins + ":" + secs + '';
	$('#TimerDiv').html(datastr);
	setTimeout("myclock()", 1000);
}


function disableRightClick(element) {
	function preventer(event) {
		event.preventDefault();
		event.stopPropagation();
		event.cancelBubble = true;
	}

	if (element.addEventListener) {
		element.addEventListener('contextmenu', preventer, false);
	} else if (document.attachEvent) {
		element.attachEvent('oncontextmenu', preventer);
	}
}

var message = "Если вы хотите поделиться изображением, скиньте ссылку другу! Воровать фото некрасиво."; // Здесь введите свою надпись, которая появится в окне предупреждения
function click(e) {
	if (document.all) {
		if (event.button == 2) { // Чтобы отключить левую кнопку поставьте цифру 1
			alert(message);
			return false;
		}
	}
	if (document.layers) {
		if (e.which == 3) {
			alert(message);
			return false;
		}
	}
}
if (document.layers) {
	document.captureEvents(Event.MOUSEDOWN);
}
document.onmousedown = click;

/**
 * Функция для склонения слов
 * Пример использования: declination(5,'комментари|й|я|ев')
 * 
 * @param int    number число, для которого будет расчитано окончание
 * @param string words  слово и варианты окончаний для 1|2|1 (1 комментарий, 2 комментария, 100 комментариев)
 * 
 * @return string - слово с правильным окончанием
 */
function declination(number, words) {
	"use strict";
	var w = words.split('|'),
		n = Math.abs(number * 1); // abs на случай отрицательного значения
	return n % 10 == 1 && n % 100 != 11 ? w[0] + w[1] : (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? w[0] + w[2] : w[0] + w[3]);
}