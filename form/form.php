<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_script(){
    wp_enqueue_style( 'mcpup-css', plugins_url( '/css/style.css', __FILE__ ), array(), time() );
    wp_enqueue_script( 'mcpup-js', plugins_url( '/js/ajax.js', __FILE__ ), array('jquery'), time(), false);
}
add_action('wp_enqueue_scripts', 'mcpup_script');


function mcpup_js_fadein(){
    ?>
        <script>
            jQuery(function(){
                jQuery('#McPopup-Ajax').delay(1500).fadeIn(500);
            });
        </script>
    <?php
}
add_filter('mcpup_js_fadein_fi', 'mcpup_js_fadein', 1);


function mcpup_form(){
    if( !session_id() ){
        session_start();
    }
    
    if( isset($_COOKIE["mcpup_cookie"]) ) {
        exit();
    }

    if( !isset($_SESSION['mcpup_secure']) ){
        $_SESSION['mcpup_secure'] = rand();
    }
    ?>
        <div id="McPopupAjax" class="mcpup-env-theme"><div class="mcpup-wrap mcpup-ajax-wrap">
        <div class="mcpup-content">

            <div class="mcpup-close mcpup-ajax-close" mcpup-ajax="<?php echo esc_url( home_url('/?mcpup=cookie') ); ?>"></div>

                <form class="mcpup-form mcpup-ajax-form" action="<?php echo esc_url( home_url('/') ); ?>" method="POST" autocomplete="off">

                        <?php if( get_option('mcpup_h_title') ) : ?>
                            <?php
                                if( !get_option('mcpup_para') ){
                                    $class = ' class="mcpup-title-bottom"';
                                }else{
                                    $class = null;
                                }
                            ?>
                            <h3<?php echo $class; ?>><?php echo get_option('mcpup_h_title'); ?></h3>
                        <?php endif; ?>

                        <?php if( get_option('mcpup_para') ) : ?>
                            <p><?php echo get_option('mcpup_para'); ?></p>
                        <?php endif; ?>

                        <?php if ( get_option('mcpup_fname') and (get_option('mcpup_fname') == 'r' or get_option('mcpup_fname') == 'o') ) : ?>
                            <?php
                                if( get_option('mcpup_fname_text') ){
                                    $mcpup_fname = get_option('mcpup_fname_text');
                                }else{
                                    $mcpup_fname = __('First Name', 'mcpopup-popup-form-for-mailchimp');
                                }
                            ?>
                            <input class="mcpup-fname mcpup-input" type="text" name="mcpup-fname" value="" placeholder="<?php echo esc_attr($mcpup_fname); ?>">
                        <?php endif; ?>

                        <?php if ( get_option('mcpup_lname') and (get_option('mcpup_lname') == 'r' or get_option('mcpup_lname') == 'o') ) : ?>
                            <?php
                                if( get_option('mcpup_lname_text') ){
                                    $mcpup_lname = get_option('mcpup_lname_text');
                                }else{
                                    $mcpup_lname = __('Last Name', 'mcpopup-popup-form-for-mailchimp');
                                }
                            ?>
                            <input class="mcpup-lname mcpup-input" type="text" name="mcpup-lname" value="" placeholder="<?php echo esc_attr($mcpup_lname); ?>">
                        <?php endif; ?>

                        <?php
                            if( get_option('mcpup_email_text') ){
                                $mcpup_email = get_option('mcpup_email_text');
                            }else{
                                $mcpup_email = __('Email', 'mcpopup-popup-form-for-mailchimp');
                            }
                        ?>

                        <input class="mcpup-email mcpup-input" type="text" name="mcpup-email" value="" placeholder="<?php echo esc_attr($mcpup_email); ?>">
                        <input type="hidden" name="mcpup_secure" value="<?php echo $_SESSION['mcpup_secure']; ?>">

                        <?php if( get_option('mcpup_promise') ) : ?>
                            <p class="mcpup-short-msg"><?php echo get_option('mcpup_promise'); ?></p>
                        <?php endif; ?>

                        <?php
                            if( get_option('mcpup_submit_text') ){
                                $mcpup_submit = get_option('mcpup_submit_text');
                            }else{
                                $mcpup_submit = __('Subscribe', 'mcpopup-popup-form-for-mailchimp');
                            }
                        ?>

                        <input type="submit" name="mcpup-submit" class="mcpup-ajax-submit mcpup-submit mcpup-input" value="<?php echo esc_attr($mcpup_submit); ?>">

                        <div class="mcpup-icon mcpup-ajax-icon"><img src="<?php echo plugins_url( 'images/ajax-icon.gif', __FILE__ ); ?>"></div>
                        <div class="mcpup-result mcpup-ajax-result"></div>

                </form>

            </div></div></div>

            <?php echo apply_filters('mcpup_js_fadein_fi', '1'); ?>
    <?php
}


function mcpup_ajax_load_f(){
    if( isset($_GET['mcpup_on_pageload']) ){

        if( get_option('mcpup_e_users') and is_user_logged_in() ){
            exit();
        }

        mcpup_form();
        exit();
    }
}
add_action('template_redirect', 'mcpup_ajax_load_f');


function mcpup_display_form(){
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#McPopup-Ajax').load("?mcpup_on_pageload=t");
            });
        </script>
        <div id="McPopup-Ajax" style="display: none;"></div>
    <?php
}
add_action('wp_footer', 'mcpup_display_form');


require_once dirname( __FILE__ ). '/form_processing.php';