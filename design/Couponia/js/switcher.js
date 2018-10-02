var btnWide = $('#demo_changer #btn-wide');
var btnBoxed = $('#demo_changer #btn-boxed');
(function($) {
    $(document).ready(function() {
        $('#styleswitch_area .styleswitch').click(function() {
            switchStylestyle(this.getAttribute("data-source"));
            return false;
        });
        var c = readCookie('style');
	var bi = readCookie('background-image');
	var l = readCookie('layout');
	var p = readCookie('cover');
//alert(p);
        if (p)     $('body').addClass('bg-cover');
        else     $('body').removeClass('bg-cover');
        if (c) switchStylestyle(c);
        if (l)     $('body').addClass('boxed');
        else     $('body').removeClass('boxed');
	if (bi) $('body').css('background-image', bi);

if ($('body').hasClass('boxed')|| readCookie('layout')) {
    btnBoxed.addClass('btn-primary');
} else {
    btnWide.addClass('btn-primary');
}
    owlReinit();
    });

    function switchStylestyle(styleName) {
        $('link[rel*=style][title]').each(function(i) {
            this.disabled = true;
            if (this.getAttribute('title') == styleName) this.disabled = false;
        });
        createCookie('style', styleName, 365);
    }
})(jQuery);

// Cookie functions
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

// Switcher
jQuery('#demo_changer .demo-icon').click(function() {

    if (jQuery('.demo_changer').hasClass("active")) {
        jQuery('.demo_changer').animate({
            "left": "-230px"
        }, function() {
            jQuery('.demo_changer').toggleClass("active");
        });
    } else {
        jQuery('.demo_changer').animate({
            "left": "0px"
        }, function() {
            jQuery('.demo_changer').toggleClass("active");
        });
    }
});

var owlReinit = function() {
    var owlSlider = $('#owl-carousel-slider');
    var owl = $('#owl-carousel');
    if(owlSlider.length) {
    	owlSlider.owlCarousel();
    	var owlSliderInst = owlSlider.data('owlCarousel');
    	owlSliderInst.reinit();
    }
    if(owl.length) {
        owl.owlCarousel();
        var owlInst = owl.data('owlCarousel');
        owlInst.reinit();
    }
}



btnWide.click(function(event) {
    event.preventDefault();
    $('body').removeClass('boxed');
    $(this).addClass('btn-primary');
    btnBoxed.removeClass('btn-primary');
    owlReinit();
	eraseCookie('layout');
	return false;
});

btnBoxed.click(function(event) {
    event.preventDefault();
    $('body').addClass('boxed');
    $(this).addClass('btn-primary');
    btnWide.removeClass('btn-primary');
	if(!readCookie('cover'))
    $('body').removeClass('bg-cover');
	if(readCookie('background-image'))
    $('body').css('background-image', readCookie('background-image'));
	else
    $('body').css('background-image', 'url("design/couponia/img/patterns/binding_light.png")');
    owlReinit();
	createCookie('layout', 'boxed', 365);
	return false;
});


$('#patternswitch_area .patternswitch').click(function(event) {
    $('body').removeClass('bg-cover');
    btnBoxed.trigger('click');
    $('body').css('background-image', $(this).css('background-image'));
	createCookie('background-image', $(this).css('background-image'), 365);
	eraseCookie('cover');
	return false;
});

$('#bgimageswitch_area .bgimageswitch').click(function(event) {
    btnBoxed.trigger('click');
    $('body').addClass('bg-cover');
    $('body').css('background-image', 'url("' + $(this).attr('data-source') + '")');
	createCookie('background-image', 'url("' + $(this).attr('data-source') + '")', 365);
	createCookie('cover', 'yes', 365);
	return false;
});