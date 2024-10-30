/*
    McPopup AJAX Script - By Alobaidi
    https://wp-plugins.in | https://wp-plugins.in/McPopup
    Copyright (c) 2019, Alobaidi.
*/


jQuery(document).ajaxComplete(function() {

    jQuery('.mcpup-ajax-form').submit( function(e) {
        var this_form = this;

        if( jQuery(this_form).find('.mcpup-ajax-submit').hasClass('mcpup-disable') ){
            return false;
        }

        jQuery(this_form).find('.mcpup-ajax-submit').addClass('mcpup-disable');

        jQuery(this_form).find('.mcpup-ajax-submit, .mcpup-ajax-result').slideUp(350);

        jQuery(this_form).find('.mcpup-ajax-icon').slideDown(350);

        jQuery.ajax({
            type: 'POST',
            url: jQuery(this_form).attr('action'),
            data: jQuery(this_form).serialize(),
            cache: false,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            processData: true,
            success: function(result) {
                jQuery(this_form).find('.mcpup-ajax-submit').removeClass('mcpup-disable');
                jQuery(this_form).find('.mcpup-ajax-result').html(result);
                jQuery(this_form).find('.mcpup-ajax-submit, .mcpup-ajax-result').slideDown(350);
                jQuery(this_form).find('.mcpup-ajax-icon').slideUp(350);
            }
        });

        e.preventDefault();
    });

            
    jQuery('.mcpup-ajax-close').one('click', function(e) {
        var this_link = this;

        jQuery('#McPopupAjax').fadeOut(250).queue(function() {
            jQuery(this).remove();
            jQuery("#McPopup-Ajax").remove();
        });

        jQuery.ajax({
            type: 'GET',
            url: jQuery(this_link).attr('mcpup-ajax'),
            data: false,
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });


    jQuery('.mcpup-ajax-wrap *').click( function(e) {
        e.stopPropagation();
    });


    jQuery(document).keyup(function(e) {
        if ( e.keyCode == 27 && jQuery('#McPopupAjax').is(':visible') ){
            jQuery('.mcpup-ajax-close').click();
        }
    });


    jQuery('#McPopupAjax').one('click', function() {
        jQuery('.mcpup-ajax-close').click();
    });

});