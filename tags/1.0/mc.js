function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	return pattern.test(emailAddress);
}


jQuery(document).ready(function($) {   
	
	$(".defaultText").focus(function(srcc) {
        if ($(this).val() == $(this)[0].title) {
            $(this).val("");
        }
    });
    $(".defaultText").blur(function() {
        if ($(this).val() == "") {
            $(this).val($(this)[0].title);
        }
    });
    $(".defaultText").blur();
	
	$('#subbutton').click(function() {
		$('#submsg').html('<img src="' + ajax_object.plugin_base_path + 'loading.gif" alt="' + ajax_object.js_alt_loading + '">');
		$.ajax({
			type: 'POST',
			url: ajax_object.ajax_url,
			data: $('#subscribeform').serialize(),
			dataType: 'json',
			beforeSend: function() {
				var name = $('#firstname').val();
				var email = $('#emailaddress').val();
				if (!name || name == ajax_object.js_default_firstname || !email) {
					$('#submsg').html(ajax_object.js_msg_enter_email_name);
					return false;
				}
				if (!isValidEmailAddress(email)) {
					$('#submsg').html(ajax_object.js_msg_invalid_email);
					return false;
				}
			},
			success: function(response) {
				//alert(response);
				if (response.status == 'success') {
					$('#subscribeform')[0].reset();
					if (ajax_object.googleanalytics) {
						_gaq.push(['_trackPageview', ajax_object.googleanalytics]);
					}
					if (ajax_object.clickyanalytics) {
						clicky.goal( ajax_object.clickyanalytics );
						clicky.pause( 500 );
					}
				}
				$('#submsg').html(response.errmessage);
			}
		});
	});
});
