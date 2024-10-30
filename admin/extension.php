<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_add_prmex_submenu() {
    add_submenu_page(
        "mcpup_general_settings",
        __('Premium Settings for McPopup Plugin', 'mcpopup-popup-form-for-mailchimp'),
        __('Premium Extension', 'mcpopup-popup-form-for-mailchimp'),
        'manage_options',
        'mcpup_premium_extension',
        'mcpup_premium_extension_cb'
    );
}
add_action('admin_menu', 'mcpup_add_prmex_submenu');


function mcpup_premium_extension_cb(){
    $prm_link = 'https://wp-plugins.in/Get-McPopup-Premium-Extension';
    $paragraph_text = sprintf( __('Get more settings, options, shortcode, and form themes for McPopup plugin with the <a target="_blank" href="%1$s">Premium Extension</a>. Get the <a target="_blank" href="%1$s">Premium Extension</a> at a low price, pay only once! <a target="_blank" href="%1$s">Get it</a> now!<br>The Premium Settings is:', 'mcpopup-popup-form-for-mailchimp'), $prm_link );
    ?>
        <div class="wrap">
            <h1><?php _e('Premium Settings for McPopup Plugin', 'mcpopup-popup-form-for-mailchimp'); ?></h1>
            <p style="font-size: 16px !important;"><?php echo $paragraph_text; ?></p>
            <p><a target="_blank" href="<?php echo plugins_url( '/images/premium-extension.png', __FILE__ ); ?>" style="display: block !important;"><img style="display: block !important;max-width: 100% !important;" src="<?php echo plugins_url( '/images/premium-extension.png', __FILE__ ); ?>"></a></p>
        </div>
    <?php
}