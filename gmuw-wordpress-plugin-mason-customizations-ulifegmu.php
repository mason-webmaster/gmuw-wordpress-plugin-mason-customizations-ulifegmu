<?php

/**
 * Main plugin file for the Mason WordPress customizations plugin for the instance: ulifegmu
 */

/**
 * Plugin Name:       Mason WordPress: Customizations Plugin: ulifegmu
 * Author:            Mason Web Administration
 * Plugin URI:        https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-customizations-ulifegmu
 * Description:       Mason WordPress Plugin to implement custom functionality for this website
 * Version:           1.0
 */


// Exit if this file is not called directly.
if (!defined('WPINC')) {
	die;
}

// Set up auto-updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
'https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-customizations-ulifegmu/',
__FILE__,
'gmuw-wordpress-plugin-mason-customizations-ulifegmu'
);


//redirect requests for certain URLs to login
add_action( 'wp', 'gmuw_customizations_ulifegmu_restrict_access_to_urls_by_pattern', 3 );
function gmuw_customizations_ulifegmu_restrict_access_to_urls_by_pattern(){

	//set login redirect url - will require a login which will redirect to the requested page
	$login_redirect_url=home_url() . '/wp-login.php?redirect_to=' . get_permalink();

	//create array of regex patterns to define URLs that should require a login
	$restricted_url_patterns=array();

	//add patterns to array

	//UL faculty fellows application form page
	$restricted_url_patterns[]='/^faculty-fellows\/faculty-fellows-form/i';

	// Get current page URL slug
	global $wp;
	$current_slug = add_query_arg( array(), $wp->request );

	//loop through restriction patterns
	foreach ($restricted_url_patterns as $restricted_url_pattern) {

		//is the requested URL one which matches this restriction pattern?
		if ( preg_match($restricted_url_pattern, $current_slug) ) {

		// is the user NOT logged in?
			if ( !is_user_logged_in() ) {

				//perform redirect to login page
				wp_redirect($login_redirect_url);
				exit;

			}

		}

	}

}
