<?php

defined( 'ABSPATH' ) or die( ':)' );


if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();


delete_option('mcpup_api_key');
delete_option('mcpup_list_id');

delete_option('mcpup_h_title');
delete_option('mcpup_para');
delete_option('mcpup_promise');
        
delete_option('mcpup_fname_text');
delete_option('mcpup_lname_text');

delete_option('mcpup_email_text');
delete_option('mcpup_submit_text');
        
delete_option('mcpup_fname');
delete_option('mcpup_lname');
        
delete_option('mcpup_c_time');
delete_option('mcpup_e_users');

delete_option('mcpup_settings_reset');