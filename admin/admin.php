<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_admin_enqueue_scripts(){
    wp_enqueue_style( 'mcpup-menu-icon', plugins_url( '/menu-icon/css/mail.css', __FILE__ ), array(), null);
    
    wp_enqueue_style( 'mcpup-admin-style', plugins_url('/css/style.css', __FILE__), array(), null, "all" );

    if( isset($_GET['page']) and $_GET['page'] == 'mcpup_general_settings' ){
        wp_enqueue_script( 'mcpup-reset-btn', plugins_url( '/js/reset-button.js', __FILE__ ), array('jquery'), null, false);
    }
}
add_action( 'admin_enqueue_scripts', 'mcpup_admin_enqueue_scripts' );


function mcpup_add_menu_page() {
    add_menu_page(
        __('McPopup Settings', 'mcpopup-popup-form-for-mailchimp'),
        __('McPopup', 'mcpopup-popup-form-for-mailchimp'),
        'manage_options',
        'mcpup_general_settings',
        '',
        ''
    );
}
add_action( 'admin_menu', 'mcpup_add_menu_page' );


function mcpup_add_settings_submenu() {
    add_submenu_page(
        "mcpup_general_settings",
        __('McPopup Settings', 'mcpopup-popup-form-for-mailchimp'),
        __('Settings', 'mcpopup-popup-form-for-mailchimp'),
        'manage_options',
        'mcpup_general_settings',
        'mcpup_settings_page_cb'
    );
}
add_action('admin_menu', 'mcpup_add_settings_submenu');


function mcpup_settings_page_cb(){
    ?>
        <div class="wrap">
            <h1><?php _e('McPopup Settings', 'mcpopup-popup-form-for-mailchimp'); ?></h1>

            <?php
            	$h2_content = __("The settings are easy and simple, and do not forget to look at", 'mcpopup-popup-form-for-mailchimp').' <a href="'.admin_url("/admin.php?page=mcpup_premium_extension").'">'.__('the Premium Extension', 'mcpopup-popup-form-for-mailchimp').'</a>.';
            	$h2_filter = apply_filters('mcpup_settings_form_h2', $h2_content);

                $prm_link = '<a title="'.esc_attr__('Premium Features for McPopup', 'mcpopup-popup-form-for-mailchimp').'" href="'.esc_url( admin_url('/admin.php?page=mcpup_premium_extension') ).'" class="mcpup-premex-btn button button-primary">'.__("Premium Features", 'mcpopup-popup-form-for-mailchimp').'</a>';
                $prm_filter = apply_filters('mcpup_settings_premex_link', $prm_link);

                if( isset($_GET['settings-updated']) and $_GET['settings-updated'] == 'true' ){
                    ?>
                        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
                            <p><strong><?php _e('Settings saved.'); ?></strong></p>
                            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.'); ?></span></button>
                        </div>
                    <?php
                }

                if( isset($_GET['mcpup_reset_settings']) and $_GET['mcpup_reset_settings'] == 'reset' and get_option('mcpup_settings_reset') == 'yes' ){
                    update_option('mcpup_settings_reset', 'no');
                    ?>
                        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
                            <p><strong><?php _e('The settings have been reset to the default options.', 'mcpopup-popup-form-for-mailchimp'); ?></strong></p>
                            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.'); ?></span></button>
                        </div>
                    <?php
                }
            ?>

            <h2 style="margin-bottom: 35px !important; display: block;"><?php echo $h2_filter; ?></h2>

            <form method="post" action="options.php" class="mcpopup-admin-form">
                <h3><?php _e('Mailchimp API Settings', 'mcpopup-popup-form-for-mailchimp'); ?></h3>
                <?php do_settings_sections("mcpup_s_api"); ?>

                <h3><?php _e('Form Settings', 'mcpopup-popup-form-for-mailchimp'); ?></h3>
                <?php do_settings_sections("mcpup_s_form"); ?>

                <h3><?php _e('Display Settings', 'mcpopup-popup-form-for-mailchimp'); ?></h3>
                <?php do_settings_sections("mcpup_s_display"); ?>

                <?php
                    settings_fields("mcpup_settings_fields");
                    submit_button();
                ?>

                <a title="<?php esc_attr_e('Read the Explanation of Use', 'mcpopup-popup-form-for-mailchimp'); ?>" href="https://wp-plugins.in/McPopup-Usage" class="mcpup-read-eou button button-primary" target="_blank"><?php _e('Explanation of Use', 'mcpopup-popup-form-for-mailchimp'); ?></a>


                <a title="<?php esc_attr_e('Reset the settings to the default options.', 'mcpopup-popup-form-for-mailchimp'); ?>" href="<?php echo esc_url( admin_url('/admin.php?page=mcpup_general_settings&mcpup_reset_settings=true') ); ?>" class="mcpup-reset-btn button button-primary"><?php _e('Reset Settings', 'mcpopup-popup-form-for-mailchimp'); ?></a>

                <?php echo $prm_filter; ?>

                <h2><?php _e('Note About Using McPopup With a Caching Plugin', 'mcpopup-popup-form-for-mailchimp'); ?></h2>

                <p style="font-size: 14px !important;"><?php _e('If you are use a caching plugin, this plugin is working well with any WordPress caching plugin such as "WP Super Cache", but when the first time you use McPopup plugin, you must to clear the cache in your website, one time only. When you want to delete McPopup plugin or you want to deactivate it in the future, also you must to clear the cache after deleting the McPopup plugin or after deactivate the McPopup plugin. Anyway, step by step, how to clear the cache in your website:', 'mcpopup-popup-form-for-mailchimp'); ?></p>
                <ul style="font-size: 14px !important;">
                    <li><a href="<?php echo plugins_url( '/images/wpsc-delete.png', __FILE__ ); ?>" target="_blank"><?php _e('Clear Cache in WP Super Cache', 'mcpopup-popup-form-for-mailchimp'); ?></a>.</li>
                    <li><a href="<?php echo plugins_url( '/images/w3t-delete.png', __FILE__ ); ?>" target="_blank"><?php _e('Clear Cache in W3 Total Cache', 'mcpopup-popup-form-for-mailchimp'); ?></a>.</li>
                    <li><a href="<?php echo plugins_url( '/images/wpengine-delete.png', __FILE__ ); ?>" target="_blank"><?php _e('Clear Cache on WPEngine', 'mcpopup-popup-form-for-mailchimp'); ?></a>.</li>
                    <li><a href="<?php echo plugins_url( '/images/sucuri-delete.jpg', __FILE__ ); ?>" target="_blank"><?php _e('Clear Cache in Sucuri', 'mcpopup-popup-form-for-mailchimp'); ?></a>.</li>
                </ul>
                <p style="font-size: 14px !important;"><?php _e("If you are not use a caching plugin at the current time, ignore the previous note.", 'mcpopup-popup-form-for-mailchimp'); ?></p>
            </form>
        </div>
    <?php
}


function mcpup_reset_cookie(){
    if( isset($_GET['mcpup_reset_cookie']) ){

        if( !session_id() ){
            session_start();
        }

        if( !current_user_can('manage_options') ){
            exit();
        }

		if( get_option('mcpup_c_time') ){
            $c_time = get_option('mcpup_c_time');
            if( is_numeric($c_time) ){
            	$hours = $c_time;
            }else{
            	$hours = 168;
            }
         }else{
            $hours = 168;
        }

        if( $hours == 0 or $hours == '0' ){
        	$get_hours = 168;
        }else{
        	$get_hours = $hours;
        }

        $total = $get_hours * 3600;

        unset($_SESSION['mcpup_secure']);
        unset($_SESSION['mcpup_error']);
        unset($_SESSION['mcpup_registered_email']);
        unset($_SESSION['mcpup_done']);

        setcookie("mcpup_cookie", "mcpup_cookie", time() - $total, '/');

        echo __("The sessions and cookie for the Popup form have been removed.", 'mcpopup-popup-form-for-mailchimp');
        exit();
    }
}
add_action('admin_init', 'mcpup_reset_cookie');


require_once dirname( __FILE__ ). '/extension.php';
require_once dirname( __FILE__ ). '/validation.php';
require_once dirname( __FILE__ ). '/default-options.php';
require_once dirname( __FILE__ ). '/settings.php';