// Аяксовая корзина
$('form.variants').live('submit', function(e) {
	e.preventDefault();
	button = $(this).find('input[type="submit"]');
	if($(this).find('input[name=variant]:checked').size()>0)
		variant = $(this).find('input[name=variant]:checked').val();
	if($(this).find('select[name=variant]').size()>0)
		variant = $(this).find('select').val();
	$.ajax({
		url: "ajax/cart.php",
		data: {variant: variant},
		dataType: 'json',
		success: function(data){
			$('#cart_informer').html(data);
			if(button.attr('data-result-text'))
				button.val(button.attr('data-result-text'));
		}
	});
	var o1 = $(this).offset();
	var o2 = $('#cart_informer').offset();
	var dx = o1.left - o2.left;
	var dy = o1.top - o2.top;
	var distance = Math.sqrt(dx * dx + dy * dy);
	$(this).closest('.product').find('.image img').effect("transfer", { to: $("#cart_informer"), className: "transfer_class" }, distance);	
	$('.transfer_class').html($(this).closest('.product').find('.image').html());
	$('.transfer_class').find('img').css('height', '100%');
	return false;
});

$(document).ready(function() {

	// Выбор вариантов
	$('select[name=variant]').change(function() {
		price = $(this).find('option:selected').attr('price');
		compare_price = '';
		if(typeof $(this).find('option:selected').attr('compare_price') == 'string')
			compare_price = $(this).find('option:selected').attr('compare_price');
		$(this).find('option:selected').attr('compare_price');
		$(this).closest('.product').find('span.pr').html(price);
    $(this).closest('.product').find('span.old').html(compare_price);
if(compare_price)
{
var save = Math.round(100 - (price/compare_price) * 100);
$(this).closest('.product').find('span.save').html(save);
}
		return false;		
	});
	
});

  $(function() {
    $(window).scroll(function() {
      if($(window).scrollTop() > 500) $("#back_to_top").show(200);
      else $("#back_to_top").hide(200);
    })
 
    $("#back_to_top").click(function() {
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, 500
		);
	return false;
    })
  })
