(function($){

	$('.fls select').eq(0).on('change', select);
	$('.single-lock .save').on('click', { type: 'single'} , saveLock);
	$('.group-lock .save').on('click', { type: 'group'}, saveLock);
	$('.one button').on('click', { type: 'one'}, mail);
	$('.mass button').on('click', { type: 'mass'}, mail);
	$('.sbsend button').on('click', { type: 'subsend'}, mail);
	$('.sts').on('click', saveSetts);
	$('.single, .group, td').on('click', '.remove, .uns', remove);
	$('#export').on('click', Export);
	if( $('#import').length > 0 ) Import();
	$('#subdown').on('click', subdown);
	$('.tzb').on( 'change', allStat );
	$('#dash .id, #dash .group').on( 'change', dashStats );
	$('#delete').on( 'click', removeStats );
	dashStatsURL();

	function select() {
		if( !$(this).find('option:selected').attr('value') ) {
			var type = $(this).removeClass('error').find('option:selected').data('id');
			$(this).closest('.fls').find('.'+type).addClass('active').siblings().removeClass('active');
		}
	}

	function remove() {
		var $this = $(this);
		var ID = $this.closest('div').data('id');
		if( $this.hasClass('uns') ) {
			var Type = 'subs';
			ID = $this.data('id');
		} else {
			Type = 'locks';
		}
		$.ajax({
			url: '../inc/functions.php',
			type: 'POST',
			data: {
				action: 'remove',
				type: Type,
				id: ID
			},
			success: function(data) {
				if( Type === 'locks' ) {
					$this.closest('div').remove();
				} else {
					$this.closest('tr').remove();
				}
			}
		});
	}

	function saveLock(event) { 
		var lock_id = $('.'+event.data.type+'-lock input').eq(0).val();
		var ps = $('.'+event.data.type+'-lock input').eq(1).val();
		if( lock_id && ps ) {
			$.ajax({
				url: '../inc/functions.php',
				type: 'POST',
				data: {
					action: event.data.type,
					id: lock_id,
					pass: ps
				},
				success: function(data) {
					if( data ) {
						$('.'+event.data.type+'-lock input').eq(0).css('outline', '1px solid crimson');
						$('.col-md-5').append('<p id="del" style="margin-top: 25px; color: crimson; padding: 20px; border: 3px solid indianred">'+data+'</p>');
						setTimeout(function(){
							$('#del').remove();
							$('.'+event.data.type+'-lock input').eq(0).css('outline', 'none');
						},1900)
					} else {
						var html = '<div class="'+event.data.type+'-lock"> \
			 			 	<span> \
			 			 		'+event.data.type+' ID: \
			 			 		' + lock_id + ' \
			 			 	 </span> \
			 			 	<span> \
			 			 		Password: ' + ps + ' \
			 			 	</span> \
				 			<b class="remove">X</b> \
				 		</div>';
				 		if( $('.'+(event.data.type)+' .col-md-7 ' + '.'+event.data.type+'-lock').length <= 0 ) $('.col-md-7 p').remove();
				 		$('.col-md-7').append(html);
				 	}
				}
			});
		} else {
			$('.col-md-5').append('<p id="del" style="margin-top: 25px; color: crimson; padding: 20px; border: 3px solid indianred">You must enter values for both Lock-ID and password.</p>');
			$('.'+event.data.type+'-lock input').addClass('err');
			setTimeout(function(){
				$('#del').remove();
				$('.'+event.data.type+'-lock input').removeClass('err');
			},1900);
		}
	}

	function mail(event) { 
		var id = $('select.active option:selected').text();
		var ps = $('select.active option:selected').data('id');
		var To = $('.one input').val() ? $('.one input').val() : $('.mass textarea').val();
		var $this = $(this);
		if( ps ) {
			$this.attr('disabled', 'disabled').text('Sending...');
			$.ajax({
				url: '../inc/functions.php',
				type: 'POST',
				data: {
					action: event.data.type,
					to: To,
					pass: ps
				},
				success: function(data) { 
					if( data.indexOf('error') == -1 ) {
						$('.email-msg p').eq(0).text('Successfully sent ' + data + ' email(s)');
					} else {
						$('.email-msg p').eq(0).html('<span style="color: crimson;">Failed sending email. Please check you email settings from the <strong>Settings</strong> section. If your gmail credentials are correct you will need to allow less secure apps from your gmail account, and then try again. You can learn more in this <a href="https://support.google.com/mail/answer/14257" target="_BLANK">article</a></span>');
					}
					$this.removeAttr('disabled').text('Send Password'); 
				}
			});
		} else {
			alert('You need to select single lock ID or group password you want to send to the selected recepient(s)');
			$('.fls select').eq(0).addClass('error');
		}
	}

	function saveSetts() {
		var email = $('#email').val();
		var s = $('#smtp').val();
		var ps = $('#pasw').val();
		var p = $('#port').val();
		var sn = $('#sname').val();
		var psc = $('#psc').val();
		var psc2 = $('#psc2').val();
		var temp = $('.templ').find('textarea').val();
		if( s && ps && email ) {
			$.ajax({
				url: '../inc/functions.php',
				type: 'POST',
				data: {
					action: 'settings',
					sname: sn,
					mail: email,
					smtp: s,
					pass: ps,
					port: p,
					template: temp,
					psw: psc,
					psw2: psc2
				},
				success: function(data) {
					$('.sett p').css('opacity', 1).html(data);
				}
			});
		} else { 
			$('input').each(function(){
				var $this = $(this);
				if( $this.val() === '' && $this.attr('id') != 'psc' && $this.attr('id') != 'psc2' )
					$this.addClass('error');
			});
			if( $('#port').is(':empty') ) $('#port').removeClass('error');
		}
	}

	function Export() { window.location.href = '../inc/download.php?type=export'; }

	function subdown() { window.location.href = '../inc/download.php?type=subs'; }

	function Import() { 
		//ajax upload plugin
		//src = http://goo.gl/3eFy7M
		var options = { 
		    beforeSend: function() 
		    {
		    	$("#progress").show();
		    	//clear everything
		    	$("#bar").width('0%');
		    	$("#message").html("");
				$("#percent").html("0%");
		    },
		    uploadProgress: function(event, position, total, percentComplete) 
		    {
		    	$("#bar").width(percentComplete+'%');
		    	$("#percent").html(percentComplete+'%');

		    
		    },
		    success: function() 
		    {
		        $("#bar").width('100%');
		    	$("#percent").html('100%');

		    },
			complete: function(response) 
			{ 	
				var result = response.responseText;
				var a = result.indexOf(':');
				var z = result.indexOf('|');
				var total = result.substring(a+1,z); 
				total = parseInt(total,10);
				var n = 1;
				var z = ( 100 / total ); 
				$("#bar").width(0);
				var upd = setInterval(function(){ 
					if( n === total ) {
						clearInterval(upd);
						 $("#bar").width('100%');
		    			 $("#percent").html('100%');
					} else {
						var g = n * z;
						g = Math.round(g);
						$("#bar").width( g +'%'); 
		    			$("#percent").html(g+'%');
		    			n++; 
					}
				},1);
				upd;
				result = result.replace('total:'+total+'|total', '');
				$(".col-md-7 p").html("<font color='green'>"+result+"</font>");
				var elem = document.getElementById('result');
				elem.scrollTop = elem.scrollHeight;
			},
			error: function()
			{
				$(".col-md-7 p").html("<font color='red'> ERROR: unable to upload file</font>");

			}
		     
		}; 

     	$("#upload").ajaxForm(options);
	}

	function dashStatsURL() {
		var tt = $('#bzv span').text();
		if( tt !== 'All' ) {
			var tp = $('#bzv').data('tp');
			var val = $(tp).find('option[value='+tt+']').data('add'); 
			var prv = $('#prv').attr('href');
			var nxt = $('#nxt').attr('href');
			nxt = nxt.replace('#dates-nav', '');
			prv = prv.replace('#dates-nav', '');
			$('#prv').attr('href', prv + val);
			$('#nxt').attr('href', nxt + val);
		}
	}

	function dashStats() {
		var val = $(this).find('option:selected').data('id');
		window.location.href = val;
	}

	function allStat() { 
		if( $(this).find('option:selected').val() === 'all' ) window.location.href = ( $(this).find('option:selected').data('id') );
	}

	function removeStats() {
		var href = $(this).closest('div').find('select').data('href');
		var month = $(this).closest('div').find('select option:selected').val();
		href = href + '?delete=true&month=' + month;
		window.location.href = href;
	}



})(jQuery);