<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_default_options_for_settings($value){
    if( get_option('mcpup_h_title') === false ){
        add_option( 'mcpup_h_title', __('Newsletter', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_para') === false ){
        add_option( 'mcpup_para', __('Subscribe to the mailing list and get the fresh content!', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_promise') === false ){
        add_option( 'mcpup_promise', __('We will not send spam! We promise you.', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_fname_text') === false ){
        add_option( 'mcpup_fname_text', __('First Name', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_lname_text') === false ){
        add_option( 'mcpup_lname_text', __('Last Name', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_email_text') === false ){
        add_option( 'mcpup_email_text', __('Email', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_submit_text') === false ){
        add_option( 'mcpup_submit_text', __('Subscribe', 'mcpopup-popup-form-for-mailchimp') );
    }

    if( get_option('mcpup_fname') === false ){
        add_option('mcpup_fname', 'o');
    }

    if( get_option('mcpup_lname') === false ){
        add_option('mcpup_lname', 'o');
    }

    if( get_option('mcpup_c_time') === false ){
        add_option('mcpup_c_time', 168);
    }

    if( get_option('mcpup_e_users') === false ){
        add_option('mcpup_e_users', '');
    }

    if( get_option('mcpup_settings_reset') === false ){
        add_option('mcpup_settings_reset', 'no');
    }
}
add_action( 'admin_init', 'mcpup_default_options_for_settings' );


function mcpup_reset_settings(){
    if( isset($_GET['mcpup_reset_settings']) and $_GET['mcpup_reset_settings'] == 'true' ){

        update_option( 'mcpup_h_title', __('Newsletter', 'mcpopup-popup-form-for-mailchimp') );
        update_option( 'mcpup_para', __('Subscribe to the mailing list and get the fresh content!', 'mcpopup-popup-form-for-mailchimp') );
        update_option( 'mcpup_promise', __('We will not send spam! We promise you.', 'mcpopup-popup-form-for-mailchimp') );

        update_option( 'mcpup_fname_text', __('First Name', 'mcpopup-popup-form-for-mailchimp') );
        update_option( 'mcpup_lname_text', __('Last Name', 'mcpopup-popup-form-for-mailchimp') );

        update_option( 'mcpup_email_text', __('Email', 'mcpopup-popup-form-for-mailchimp') );
        update_option( 'mcpup_submit_text', __('Subscribe', 'mcpopup-popup-form-for-mailchimp') );
        
        update_option('mcpup_fname', 'o');
        update_option('mcpup_lname', 'o');
        
        update_option('mcpup_c_time', 168);
        update_option('mcpup_e_users', '');

        update_option('mcpup_settings_reset', 'yes');

        $wp_redirect_url = admin_url("/admin.php?page=mcpup_general_settings&mcpup_reset_settings=reset");
        wp_redirect( $wp_redirect_url );

        exit();
    }
}
add_action( 'admin_init', 'mcpup_reset_settings' );