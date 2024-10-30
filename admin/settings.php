<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_add_settings(){
    add_settings_section('mcpup_settings_fields', false, false, 'mcpup_s_api');
    add_settings_section('mcpup_settings_fields', false, false, 'mcpup_s_form');
    add_settings_section('mcpup_settings_fields', false, false, 'mcpup_s_display');

	add_settings_field( "mcpup_api_key", __('API Key (required)', 'mcpopup-popup-form-for-mailchimp'), "mcpup_api_key_cb", "mcpup_s_api", "mcpup_settings_fields", array('label_for' => 'mcpup_api_key') );
    register_setting( 'mcpup_settings_fields', 'mcpup_api_key', 'sanitize_text_field');

    add_settings_field( "mcpup_list_id", __('Audience ID (required)', 'mcpopup-popup-form-for-mailchimp'), "mcpup_list_id_cb", "mcpup_s_api", "mcpup_settings_fields", array('label_for' => 'mcpup_list_id') );
    register_setting( 'mcpup_settings_fields', 'mcpup_list_id', 'sanitize_text_field');

    add_settings_field( "mcpup_h_title", __('Heading Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_h_title_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_h_title') );
    register_setting( 'mcpup_settings_fields', 'mcpup_h_title', 'sanitize_text_field');

    add_settings_field( "mcpup_para", __('Paragraph Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_para_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_para') );
    register_setting( 'mcpup_settings_fields', 'mcpup_para', 'sanitize_text_field');

    add_settings_field( "mcpup_promise", __('Short Message Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_promise_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_promise') );
    register_setting( 'mcpup_settings_fields', 'mcpup_promise', 'sanitize_text_field');

    add_settings_field( "mcpup_fname_text", __('First Name Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_fname_text_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_fname_text') );
    register_setting( 'mcpup_settings_fields', 'mcpup_fname_text', 'sanitize_text_field');

    add_settings_field( "mcpup_lname_text", __('Last Name Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_lname_text_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_lname_text') );
    register_setting( 'mcpup_settings_fields', 'mcpup_lname_text', 'sanitize_text_field');

    add_settings_field( "mcpup_email_text", __('Email Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_email_text_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_email_text') );
    register_setting( 'mcpup_settings_fields', 'mcpup_email_text', 'sanitize_text_field');

    add_settings_field( "mcpup_submit_text", __('Submit Text', 'mcpopup-popup-form-for-mailchimp'), "mcpup_submit_text_cb", "mcpup_s_form", "mcpup_settings_fields", array('label_for' => 'mcpup_submit_text') );
    register_setting( 'mcpup_settings_fields', 'mcpup_submit_text', 'sanitize_text_field');

    add_settings_field( "mcpup_fname", __('First Name Field Type', 'mcpopup-popup-form-for-mailchimp'), "mcpup_fname_cb", "mcpup_s_form", "mcpup_settings_fields" );
    register_setting( 'mcpup_settings_fields', 'mcpup_fname', 'mcpup_radio_validation');

    add_settings_field( "mcpup_lname", __('Last Name Field Type', 'mcpopup-popup-form-for-mailchimp'), "mcpup_lname_cb", "mcpup_s_form", "mcpup_settings_fields" );
    register_setting( 'mcpup_settings_fields', 'mcpup_lname', 'mcpup_radio_validation');

    add_settings_field( "mcpup_c_time", __('Display Time', 'mcpopup-popup-form-for-mailchimp'), "mcpup_c_time_cb", "mcpup_s_display", "mcpup_settings_fields", array('label_for' => 'mcpup_c_time') );
    register_setting( 'mcpup_settings_fields', 'mcpup_c_time', 'mcpup_number_validation');

    add_settings_field( "mcpup_e_users", __('Exclude Users', 'mcpopup-popup-form-for-mailchimp'), "mcpup_e_users_cb", "mcpup_s_display", "mcpup_settings_fields", array('label_for' => 'mcpup_e_users') );
    register_setting( 'mcpup_settings_fields', 'mcpup_e_users', 'mcpup_checkbox_validation');
}
add_action( 'admin_init', 'mcpup_add_settings' );


function mcpup_api_key_cb(){
	$mc_signup_link = 'https://mailchimp.com/?utm_source=freemium_newsletter&utm_medium=email&utm_campaign=monkey_rewards&aid=3aad27f15f3f79b016c79f6fb&afl=1';
	$mc_signup_text = sprintf( __('Do not have a Mailchimp account? <a href="%1$s" target="_blank">Sign Up</a> for free!', 'mcpopup-popup-form-for-mailchimp'), $mc_signup_link );
    ?>
        <input class="regular-text" name="mcpup_api_key" type="text" id="mcpup_api_key" value="<?php echo esc_attr( get_option('mcpup_api_key') ); ?>">
        <p class="description"><?php _e('Enter your API Key. Get your', 'mcpopup-popup-form-for-mailchimp'); ?> <a href="https://wp-plugins.in/mcpupup-get-mailchimp-api-key" target="_blank"><?php _e('API Key', 'mcpopup-popup-form-for-mailchimp'); ?></a>. <?php echo $mc_signup_text; ?></p>
    <?php
}


function mcpup_list_id_cb(){
    ?>
        <input class="regular-text" name="mcpup_list_id" type="text" id="mcpup_list_id" value="<?php echo esc_attr( get_option('mcpup_list_id') ); ?>">
        <p class="description"><?php _e('Enter your Audience ID (it is same List ID). Get your', 'mcpopup-popup-form-for-mailchimp'); ?> <a href="https://wp-plugins.in/mcpupup-get-mailchimp-audience-id" target="_blank"><?php _e('Audience ID', 'mcpopup-popup-form-for-mailchimp'); ?></a>.</p>
    <?php
}


function mcpup_h_title_cb(){
    ?>
        <input style="width:100%;" class="regular-text" name="mcpup_h_title" type="text" id="mcpup_h_title" value="<?php echo esc_attr( get_option('mcpup_h_title') ); ?>">
        <p class="description"><?php _e('Enter your heading text. If you want to remove the heading from the Popup form, leave this field blank.', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_para_cb(){
    ?>
        <input style="width:100%;" class="regular-text" name="mcpup_para" type="text" id="mcpup_para" value="<?php echo esc_attr( get_option('mcpup_para') ); ?>">
        <p class="description"><?php _e('Enter your paragraph text. If you want to remove the paragraph from the Popup form, leave this field blank.', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_promise_cb(){
    ?>
        <input style="width:100%;" class="regular-text" name="mcpup_promise" type="text" id="mcpup_promise" value="<?php echo esc_attr( get_option('mcpup_promise') ); ?>">
        <p class="description"><?php _e('Enter your short message text. If you want to remove the short message from the Popup form, leave this field blank.', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_fname_text_cb(){
    if( get_option('mcpup_fname_text') ){
        $mcpup_fname = get_option('mcpup_fname_text');
    }else{
        $mcpup_fname = __('First Name', 'mcpopup-popup-form-for-mailchimp');
    }
    ?>
        <input class="regular-text" name="mcpup_fname_text" type="text" id="mcpup_fname_text" value="<?php echo esc_attr($mcpup_fname); ?>">
        <p class="description"><?php _e('Enter the placeholder text for the First Name field. Enter what you want, or translate the text into your language, for example, enter "Nombre de pila" (this text in Spanish and means "First Name"). Default is "First Name".', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_lname_text_cb(){
    if( get_option('mcpup_lname_text') ){
        $mcpup_lname = get_option('mcpup_lname_text');
    }else{
        $mcpup_lname = __('Last Name', 'mcpopup-popup-form-for-mailchimp');
    }
    ?>
        <input class="regular-text" name="mcpup_lname_text" type="text" id="mcpup_lname_text" value="<?php echo esc_attr($mcpup_lname); ?>">
        <p class="description"><?php _e('Enter the placeholder text for the Last Name field. Enter what you want, or translate the text into your language. Default is "Last Name".', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_email_text_cb(){
    if( get_option('mcpup_email_text') ){
        $mcpup_email = get_option('mcpup_email_text');
    }else{
        $mcpup_email = __('Email', 'mcpopup-popup-form-for-mailchimp');
    }
    ?>
        <input class="regular-text" name="mcpup_email_text" type="text" id="mcpup_email_text" value="<?php echo esc_attr($mcpup_email); ?>">
        <p class="description"><?php _e('Enter the placeholder text for the Email field. Enter what you want, or translate the text into your language. Default is "Email".', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_submit_text_cb(){
    if( get_option('mcpup_submit_text') ){
        $mcpup_submit = get_option('mcpup_submit_text');
    }else{
        $mcpup_submit = __('Subscribe', 'mcpopup-popup-form-for-mailchimp');
    }
    ?>
        <input class="regular-text" name="mcpup_submit_text" type="text" id="mcpup_submit_text" value="<?php echo esc_attr($mcpup_submit); ?>">
        <p class="description"><?php _e('Enter the subscribing button text. For example "Join" or "Download" or "Get Coupon".. Enter what you want. Default is "Subscribe".', 'mcpopup-popup-form-for-mailchimp'); ?></p>
    <?php
}


function mcpup_fname_cb(){
    ?>
        <p style="margin-bottom:0.50em !important;"><?php _e('Choose the field type from the following options:', 'mcpopup-popup-form-for-mailchimp'); ?></p>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('First Name Field', 'mcpopup-popup-form-for-mailchimp'); ?></span></legend>
            <label for="mcpup_fname_r">
                <input type="radio" id="mcpup_fname_r" name="mcpup_fname" value="r" <?php checked( get_option('mcpup_fname'), 'r', true ); ?>><?php _e('Required Field (the first name field will be required for subscribing).', 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
            <br>
            <label for="mcpup_fname_o">
                <input type="radio" id="mcpup_fname_o" name="mcpup_fname" value="o" <?php checked( get_option('mcpup_fname'), 'o', true ); ?>><?php _e('Optional Field (the first name field will be optional for subscribing).', 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
            <br>
            <label for="mcpup_fname_h">
                <input type="radio" id="mcpup_fname_h" name="mcpup_fname" value="h" <?php checked( get_option('mcpup_fname'), 'h', true ); ?>><?php _e("I don't want this field (this field will not appear).", 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
        </fieldset>
    <?php
}

function mcpup_lname_cb(){
    ?>
        <p style="margin-bottom:0.50em !important;"><?php _e('Choose the field type from the following options:', 'mcpopup-popup-form-for-mailchimp'); ?></p>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Last Name Field', 'mcpopup-popup-form-for-mailchimp'); ?></span></legend>
            <label for="mcpup_lname_r">
                <input type="radio" id="mcpup_lname_r" name="mcpup_lname" value="r" <?php checked( get_option('mcpup_lname'), 'r', true ); ?>><?php _e('Required Field (the last name field will be required for subscribing).', 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
            <br>
            <label for="mcpup_lname_o">
                <input type="radio" id="mcpup_lname_o" name="mcpup_lname" value="o" <?php checked( get_option('mcpup_lname'), 'o', true ); ?>><?php _e('Optional Field (the last name field will be optional for subscribing).', 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
            <br>
            <label for="mcpup_lname_h">
                <input type="radio" id="mcpup_lname_h" name="mcpup_lname" value="h" <?php checked( get_option('mcpup_lname'), 'h', true ); ?>><?php _e("I don't want this field (this field will not appear).", 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
        </fieldset>
    <?php
}


function mcpup_c_time_cb(){
    if( get_option('mcpup_c_time') ){
        $cookie_time = get_option('mcpup_c_time');
    }else{
        $cookie_time = 168;
    }

    $rc_link = esc_url( admin_url('/?mcpup_reset_cookie=1') );
    $remove_cookie = sprintf( __('If you want to test the Popup form, and you can not wait for hours, <a href="%1$s" target="_blank">remove McPopup Cookies and Sessions</a>.', 'mcpopup-popup-form-for-mailchimp'), $rc_link );
    ?>
        <input class="small-text" name="mcpup_c_time" type="text" id="mcpup_c_time" value="<?php echo esc_attr( $cookie_time ); ?>">
        <p class="description"><?php _e('Enter the display time, for example enter number "24", which means that the Popup form will be displayed once per visitor, and the Popup form will be displayed again to the same visitor after the 24 hours. Default is "168" (168 hours = 7 days).', 'mcpopup-popup-form-for-mailchimp'); ?> <?php echo $remove_cookie; ?></p>
    <?php   
}


function mcpup_e_users_cb(){
    ?>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Exclude Users', 'mcpopup-popup-form-for-mailchimp'); ?></span></legend>
            <label for="mcpup_e_users">
                <input type="checkbox" id="mcpup_e_users" name="mcpup_e_users" value="1" <?php checked( get_option('mcpup_e_users'), '1', true ); ?>><?php _e('If the current visitor is a logged-in user (whether he is an author, subscriber, editor, moderator, or administrator, etc..), the Popup form will not appear to him.', 'mcpopup-popup-form-for-mailchimp'); ?>
            </label>
        </fieldset>
    <?php
}