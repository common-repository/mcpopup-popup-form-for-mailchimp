<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_form_api(){
        if( !session_id() ){
            session_start();
        }

        if( isset($_SESSION['mcpup_done']) ){
            echo '<div class="mcpup-msg mcpup-error">'.__('You cannot subscribe frequently! Error code is "#YCSF2".', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        $api_key = get_option('mcpup_api_key');
        $auth = base64_encode('user:'.$api_key);

        $list_id = get_option('mcpup_list_id');
        $data_center = substr($api_key, strpos($api_key, '-') + 1);
        $api_url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/';

        $get_email = sanitize_text_field($_POST['mcpup-email']);
        $email = strtolower($get_email);

        if( get_option('mcpup_fname') and (get_option('mcpup_fname') == 'r' or get_option('mcpup_fname') == 'o') ){
            $f_name = sanitize_text_field($_POST['mcpup-fname']);
        }else{
            $f_name = '';
        }

        if( get_option('mcpup_lname') and (get_option('mcpup_lname') == 'r' or get_option('mcpup_lname') == 'o') ){
            $l_name = sanitize_text_field($_POST['mcpup-lname']);
        }else{
            $l_name = '';
        }

        $data = array(
                    'email_address' => $email,
                    'status'        => 'pending',
                    'merge_fields'  => array('FNAME' => $f_name, 'LNAME' => $l_name)
                );

        $json_data = json_encode($data);

        $oauth_args = array("headers" => array("Authorization" =>  "Basic $auth", "Content-Type" => "Content-Type: application/json"), 'body' => $json_data);

        $add_subscriber = wp_remote_retrieve_body( wp_remote_post($api_url, $oauth_args) );

        $json_result = json_decode($add_subscriber, true);

        if( !empty($json_result['status']) ){
            if( $json_result['status'] != 400 ){

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
                setcookie("mcpup_cookie", "mcpup_cookie", time() + $total, '/');
                $_SESSION['mcpup_registered_email'] = $email;
                $_SESSION['mcpup_done'] = 1;
                unset($_SESSION['mcpup_secure']);

                $script_js = "<script>jQuery(function() { jQuery('#McPopupAjax').delay(5000).fadeOut(250).queue(function() {
            jQuery(this).remove(); jQuery('#McPopup-Ajax').remove();
        }); }); </script>";

                $status_message = '<div class="mcpup-msg mcpup-done">'.__('Thanks for subscribing!<br>Please check your Email for the confirmation link.', 'mcpopup-popup-form-for-mailchimp').'</div>'.$script_js;
    
                echo $status_message;
                exit();
            }else{
                $_SESSION['mcpup_registered_email'] = $email;
                echo '<div class="mcpup-msg mcpup-done">'.__('This email is already subscribed, or has unsubscribed by the owner of email. If the email status is "unsubscribed", go to the mailing list in your Mailchimp account, search for the previous email, delete and archive it so that it can re-subscribe, or chnage the email status to "subscribed".', 'mcpopup-popup-form-for-mailchimp').'</div>';
                exit();
            }
        }else{
            $_SESSION['mcpup_error'] = 1;
            echo '<div class="mcpup-msg mcpup-error">'.__('Something went wrong! Please try again. Error code is "#SWW2".', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }
}
add_filter('mcpup_form_api_fi', 'mcpup_form_api', 1);


function mcpup_form_processing(){
    if( isset($_GET['mcpup']) ){
        if( !empty($_GET['mcpup']) and $_GET['mcpup'] == 'cookie' and !isset($_COOKIE["mcpup_cookie"]) ){

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
            setcookie("mcpup_cookie", "mcpup_cookie", time() + $total, '/');
            exit();
        }

        exit();
    }

    if( isset($_POST['mcpup_secure']) ){

        if( !session_id() ){
            session_start();
        }

        if( isset($_SESSION['mcpup_done']) ){
            echo '<div class="mcpup-msg mcpup-error">'.__('You cannot subscribe frequently! Error code is "#YCSF1".', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( empty($_POST['mcpup_secure']) or isset($_SESSION['mcpup_secure']) and $_POST['mcpup_secure'] != $_SESSION['mcpup_secure'] or !isset($_SESSION['mcpup_secure']) ){
            echo '<div class="mcpup-msg mcpup-error">'.__('This session has expired! Please refresh the page.', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( !get_option('mcpup_api_key') ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please administration, enter your API Key in McPopup Settings page.', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( !get_option('mcpup_list_id') ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please administration, enter your List ID in McPopup Settings page.', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( empty($_POST['mcpup-fname']) and get_option('mcpup_fname') == 'r' ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please enter your First Name!', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( empty($_POST['mcpup-lname']) and get_option('mcpup_lname') == 'r' ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please enter your Last Name!', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( empty($_POST['mcpup-email']) ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please enter your Email!', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( !filter_var($_POST['mcpup-email'], FILTER_VALIDATE_EMAIL) === true ){
            echo '<div class="mcpup-msg mcpup-error">'.__('Please enter a valid Email!', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( isset($_SESSION['mcpup_registered_email']) and $_POST['mcpup-email'] == $_SESSION['mcpup_registered_email'] ){
            echo '<div class="mcpup-msg mcpup-done">'.__('This email is already subscribed, or has unsubscribed by the owner of email. If the email status is "unsubscribed", go to the mailing list in your Mailchimp account, search for the previous email, delete and archive it so that it can re-subscribe, or chnage the email status to "subscribed".', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        if( isset($_SESSION['mcpup_error']) ){
            unset($_SESSION['mcpup_error']);
            echo '<div class="mcpup-msg mcpup-error">'.__('Something went wrong! Please try again. Error code is "#SWW1".', 'mcpopup-popup-form-for-mailchimp').'</div>';
            exit();
        }

        return apply_filters('mcpup_form_api_fi', '1');
        exit();

    }
}
add_action('init', 'mcpup_form_processing');