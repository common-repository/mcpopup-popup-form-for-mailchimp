<?php
/*
Plugin Name: McPopup - Popup Form for Mailchimp
Plugin URI: https://wp-plugins.in/McPopup
Description: Increase your sales and your Mailchimp subscribers using McPupup plugin. The easiest and fastest way to display the Mailchimp Popup form, responsive Popup form, AJAX form, beautiful and clean design, easy to use, easy to setup, and more!
Version: 1.0.0
Author: Alobaidi
Author URI: https://wp-plugins.in
License: GPLv2 or later
Text Domain: mcpopup-popup-form-for-mailchimp
*/

/*  Copyright 2019 Alobaidi (email: wp-plugins@outlook.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_plugin_row_meta($links, $file) {
	if ( strpos( $file, 'mcpopup-popup-form-for-mailchimp.php' ) !== false ) {
		$new_links = array(
							'<a href="https://wp-plugins.in/McPopup-Usage" target="_blank" class="mcpup-exofuse">'.__('Explanation of Use', 'mcpopup-popup-form-for-mailchimp').'</a>',
							'<a href="https://wp-plugins.in/McPopup-Contact-and-Support" target="_blank" class="mcpup-exofuse" title="'.esc_attr__("Need help? Support? Or do you have a question? Contact us!", 'mcpopup-popup-form-for-mailchimp').'">'.__('Contact and Support', 'mcpopup-popup-form-for-mailchimp').'</a>',
							'<a href="https://wp-plugins.in" target="_blank">'.__('More Plugins', 'mcpopup-popup-form-for-mailchimp').'</a>'
						);
		
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'mcpup_plugin_row_meta', 10, 2 );


function mcpup_plugin_action_links( $actions, $plugin_file ){
	static $plugin;

	if ( !isset($plugin) ){
		$plugin = plugin_basename(__FILE__);
	}
		
	if ($plugin == $plugin_file) {
		$new_links = array(
						'<a title="'.esc_attr__("Get more settings, options, shortcode, and form themes for McPopup plugin with the Premium Extension. Get the Premium Extension at a low price, pay only once! Get it now!", 'mcpopup-popup-form-for-mailchimp').'" class="mcpup-get-premex" href="https://wp-plugins.in/Get-McPopup-Premium-Extension" target="_blank">'.__('Get the Premium Extension', 'mcpopup-popup-form-for-mailchimp').'</a>',
						'<a href="'.admin_url("/admin.php?page=mcpup_general_settings").'">'.__("Settings", 'mcpopup-popup-form-for-mailchimp').'</a>'
					);
		
		$actions = array_merge($new_links, $actions);
	}
	
	return $actions;
}
add_filter( 'plugin_action_links', 'mcpup_plugin_action_links', 10, 5 );


require_once dirname( __FILE__ ). '/form/form.php';
require_once dirname( __FILE__ ). '/admin/admin.php';