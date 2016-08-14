(function($){

	$('.next').on('click', nextStep);
	$('#subm').on('click', complete);

	function permissions() {
		$('.step-data').removeClass('active');
		$('.step-data').eq(1).addClass('active');
		$('#steps #step-2').addClass('active').siblings().removeClass('active');
	}

	function nextStep() {
		$this = $(this);
		if( $('.step-data').eq(0).hasClass('active') ) {
			permissions(); 
		} else { 
			$('#next').text('Loading...');
			$.ajax({
				url: $('.form-signin').attr('action'),
				type: 'POST',
				data: {
					host: $('#host').val(),
					dbname: $('#dbname').val(),
					dbuser: $('#dbuser').val(),
					dbpass: $('#dbpass').val(),
					step: 1
				},
				success: function(data) {
					$('.step-data.active input').each(function(){
						if( $(this).val() === '' ) {
							$(this).addClass('error');
						}
					});
					if( data.indexOf('DONE') != -1 && $('#dbname').val() !== '' && $('#dbuser').val() !== ''  ) {		
						$this.closest('.step-data').removeClass('active');
						$('.step-data').eq(2).addClass('active');
						$('.step-data.active input').attr('required', 'required');
						$('#steps #step-3').addClass('active').siblings().removeClass('active');
						$('.msg').css('display', 'none');
					} else if( $('#dbname').val() === '' || $('#dbuser').val() === '' ) { 
						$('.msg').css('display', 'block').html('You must enter database name and database user.');
						$('.next').text('Next');
					} else {
						d = data.replace('FAIL', '');
						$('.msg').css('display', 'block').html(d);
						$('.next').text('Next');
					}
				}
			});
		}
	}

	function complete() { 
		$this = $(this);
		$('#subm').text('Loading...');
		var error = false;
		$('.step-data.active input').each(function(){
			if( $(this).val() === '' ) {
				$(this).addClass('error');
				error = true;
			}
		});
		if( !error ) {
			$.ajax({
				url: $('.form-signin').attr('action'),
				type: 'POST',
				data: {	
					user: $('#admin').val(),
					pass: $('#inputPassword').val(),
					rpass: $('#rinputPassword').val(),
					step: 2	
				},
				success: function(data) { console.log(data)
					if( data.indexOf('FAIL') != -1 ) {
						d = data.replace('FAIL', '');
						$('.msg').css('display', 'block').html(d);
						$('#subm').text('Next');
						error = true;
					}
					if( !error ) {
						$('.msg').css('display', 'block').addClass('done').html(data);
						$('#subm').text('Done');
						$('.form-signin').animate({opacity: 0}, 560);
					}
				}
			});
		} else {
			$('.msg').css('display', 'block').html('You must fill all fields');
			$('#subm').text('Next');
		}
	}

})(jQuery);