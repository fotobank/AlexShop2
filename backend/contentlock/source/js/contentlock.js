(function($){
    $.fn.contentlock = function(options) {
        var defaults = {
            url: '',
            container: '',
            heading: 'This Content Is Locked',
            unlockText: 'Enter a password to unlock it:',
            subContainer : "",
            subText: 'Subscribe to unlock this content. <small class="cl-small">Password will be automatically emailed to you.</small>',
            subCall: 'GET IT',
            subPlaceholder: 'Enter your email',
            successMsg: 'Thanks. Password Has been emailed to you.',
            failMsg: 'Please, check your email address again, you must enter propper email.',
            sendSucc : 'Sent',
            sent: 'Send Again',
            sendAnimation: true,
            subscribeBox : '',
            beforeSubmit: function(){},
            onSuccess : function(){},
            passChecked : function(){}
        }
        var option = $.extend({}, defaults, options);

        var fetchURL = option.url + '/pages/404.php',
            heading = option.heading,
            unlockText = option.unlockText,
            subText = option.subText,
            subCall = option.subCall,
            subPlc = option.subPlaceholder,
            success = option.successMsg,
            failed = option.failMsg,
            sendSucc = option.sendSucc,
            sent = option.sent,
            subscribeBox = option.subscribeBox,
            before = option.beforeSubmit,
            succseed = option.onSuccess,
            sendAnm = option.sendAnimation,
            subBox = '<div class="cl-subs"> \
            <p><span class="cl-simg" style="background: url('+ option.url +'/assets/images/subs.png); background-size: 100% 100%"></span> '+ subText +'</p> \
            <input class="cl-mail" type="text" placeholder="'+subPlc+'" /> \
            <span class="cl-call" data-text="'+subCall+'">'+ subCall +'</span> \
            <em class="cl-succ"></em> \
            </div>',
            checked = option.passChecked,
            containers = option.container.split(',');
        var initiliazed = 0;    
        if( option.subContainer ) {
            if( subscribeBox ) {
                $(option.subContainer).append(subscribeBox);
            } else {
                $(option.subContainer).append(subBox);
            }
        } 
        //loop through every container
        $.each(containers, function(key, value){
            init($.trim(value));
        });

        function init(id) {
            //cache the selected container
            var container = $(id);
            var call = container.find('.cl-call');
            var wrapper = container.wrapInner('<div class="cl-wrap" />');
            var content = wrapper.html();
            var keys = {};
            var SBox = container.data('subox');
            var link = container.data('dwn');
            var inct = option.subContainer ? option.subContainer : '.inct';
            container.find('.cl-wrap').remove();
            container.append( '<div class="locked"><div><span class="cl-icon"></span><h4>'+ heading +'</h4><div class="cl-inner">' + unlockText +' <input type="password" /><b class="wrng"></b></div></div></div>' );
            if( SBox ) {
                if( subscribeBox ) {
                    container.append(subscribeBox);
                } else {
                    container.append(subBox);
                } 
            }
            obtainPass();
            container.addClass('inct'); 
            container.on( 'change keyup input', '.locked div input', checkPass );
            if( initiliazed === 0 ) {
                $('body').on('click', '.cl-call', subscribe); 
                initiliazed++;
            }

            function obtainPass() {
                var $cache = $('<div>');
                $cache.load(fetchURL, function(){
                    $(this).find('.key').each(function(){
                        var pair = $(this).text();
                        var key = pair.split(':');
                        var id = key[0];
                        var pass = key[1];
                        keys[id] = pass;
                    });
                });
            }

            function checkPass() {
                var input = $.trim( $(this).val() );
                var key = $(this).closest(id).data('cl');
                if( !key ) key = $(this).closest(id).data('group'); 
                if( $(this).closest(id).data('cl') ) {
                  var type = 'lock_id';
                } else {
                  var type = 'group';
                }
                if( keys[key] === input ) {
                   checked;
                   container.find('.locked div .wrng').html("&#10003;").css('color', 'green');
                   setTimeout(function(){
                     if( container.hasClass('inct') ) {
                         container.removeClass('inct');
                         container.append(content);
                        if( link ) download(link);
                         sendStat(key, type);
                         unlocked(type, key);
                     }
                     container.find('.locked, .cl-subs').remove();
                   },500);
                } else {
                  container.find('.locked div .wrng').text('X');
                }
            }

            function sendStat(k, v) {
                $.ajax({
                    url: option.url + '/inc/functions.php',
                    type: 'POST',
                    data: {
                        action: 'stats',
                        id: k,
                        type: v
                    }
                });
            }

            function unlocked(k, v) {
                $.ajax({
                    url: option.url + '/inc/functions.php',
                    type: 'POST',
                    data: {
                        action: 'unlocked',
                        id: v,
                        type: k
                    }
                });
            }

            function subscribe() {
                //var e = container.find('.cl-mail').val();
                var gr = ($(this).closest('.inct').length > 0) ? gr = '.inct' : inct;
                var e = $(gr).find('.cl-mail').val();
                var r = $(this).closest(gr).data('cl') ? $(this).closest(gr).data('cl') : $(this).closest(gr).data('group');
                var t = 'group';
                if( $(this).closest(gr).data('cl') ) t = 'cl';
                before;
                var dots = {
                    0: '.',
                    1: '..',
                    2: '...'
                }
                var n = 0;
                $(gr).find('.cl-call').addClass('cl-sndn');
                if( sendAnm ) {
                    var animate = setInterval(function(){
                        if( n === 3 ) n = 0;
                        $(gr).find('.cl-call').text('Sending' + dots[n]);
                        n++;
                    },230);
                    animate;
                }
                console.log('called')
                if( isValidEmailAddress(e) && $(gr).find('.cl-call').hasClass('cl-sndn') ) {
                     $.ajax({
                        url: option.url + '/inc/functions.php',
                        type: 'POST',
                        data: {
                            action: 'subs',
                            email: e,
                            refferer: r,
                            type : t
                        },
                        success: function(response) { 
                            if( response.indexOf('DONE') != -1 ){
                                $(gr).find('.cl-succ').removeClass('fail').text(success);
                                if( sendAnm ) clearInterval(animate);
                                succseed;
                                $(gr).find('.cl-call').removeClass('cl-sndn').text(sendSucc);
                                setTimeout(function(){
                                    $(gr).find('.cl-call').text(sent);
                                },420);
                            }
                        }
                    });
                 } else {
                    if( sendAnm ) clearInterval(animate);
                    $(gr).find('.cl-call').removeClass('cl-sndn').text(subCall);
                    $(gr).find('.cl-succ').addClass('fail').text(failed);
                 }
            }

            //regex to validate email
            // src = http://goo.gl/gcVoA6
            function isValidEmailAddress(email) {
                var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                return pattern.test(email);
            };

            //downloads
            function download(url) {
                window.location.href = url;
            }

        }//init();
    }
})(jQuery);