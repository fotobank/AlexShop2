$(document).ready(function () {
    // маска для номера телефона
    // $('.user-phone').mask("(999) 999-99-99");

    // автодополнеение email
    $(document).ready(function () {
        new Awesomplete('input[type="email"]', {
            list: ["aol.com", "att.net", "i.ua", "yandex.ru", "rambler.ru", "comcast.net", "facebook.com", "gmail.com", "gmx.com", "googlemail.com", "google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com", "live.com", "sbcglobal.net", "verizon.net", "yahoo.com", "yahoo.co.uk", "mail.ru"],
            data: function (text, input) {
                return input.slice(0, input.indexOf("@")) + "@" + text;
            },
            filter: Awesomplete.FILTER_STARTSWITH
        });
        $(".order_form").validata({
            showErrorMessages : true, // If you dont want to display error messages set this option false
            /** You can display errors as inline or bubble */
            display : 'bubble', // bubble or inline
            /**
             * Error template class
             * This is the class which will be added to the error message window template.
             * If you want special style, you can change class name as you like with this option.
             * Error message window template : <span class="errorTemplateClass">Error messages will be here !</span>
             */
            errorTemplateClass : 'validata-bubble',
            /** Class that would be added on every failing validation field */
            errorClass : 'validata-error',
            /** Same for valid validation */
            validClass : 'validata-valid', // Same for valid validation
            bubblePosition: 'bottom', // Bubble position // right / bottom
            bubbleGapLeft: 15, // Right gap of bubble (px unit)
            bubbleGapTop: 0, // Top gap of bubble (px unit)
            /* To enable real-time form control, set this option true. */
            realTime : true,
            validators: {}, // Custom validators stored in this variable
            /** Callback functions */
            onValid : function(){},
            onError : function(){}
        });
    });

    function log() {
        var msg = "[jquery.form] " + Array.prototype.join.call(arguments, "");
        if (window.console && window.console.log) window.console.log(msg);
        else if (window.opera && window.opera.postError) window.opera.postError(msg)
    }

});