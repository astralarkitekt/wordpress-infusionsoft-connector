<?php
/*
Plugin Name: Infusionsoft Plugin Boilerplate
Plugin URI: http://innerbot.com/wordpress-plugins/infusionsoft-plugin-boilerplate
Description: A simple WordPress Plugin for Developers that need to build plugins that consume the InfusionSoft API. 
Version: 0.1
Author: Greg Johnson
Author URI: http://innerbot.com/ 
Author Email: greg@innerbot.com
License: GPL v3
*/

/**
 * Copyright 2012, Greg Johnson(greg@innerbot.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

// TODO: Replace the definition value below with YOUR InfusionSoft Vendor API Key
// if you do not have one yet, you can get one here:
// http://help.infusionsoft.com/developers/vendorkey
// Comment Out if Using Traditional API-Key style calls
define( 'INFUSIONVENDORKEY', '7df953fdfa57d53f68fed1a86b88fd5a' );

// Valid values:
// 'cfgCon' - use the traditional API-KEY method
// 'vendorCon' - connect using a vendor Key (default)
define( 'INFUSIONAUTHMETHOD', 'vendorCon' );

/**
 * Wrapper Class for Integrating Infusionsoft into Your WP Plugin
 *
 * The InfusionsoftConnector class allows you, the developer to 
 * integrate InfusionSoft Functionality into your WordPress Plugin
 * by extending this class and adding in your custom functionality
 * 
 * @package InfusionsoftConnector
 * @since 0.1
 * @version 0.1
 * @link http://innerbot.com/wordpress-plugins/infusionsoft-plugin-boilerplate
 * @author Greg Johnson 
 */
class InfusionsoftConnector {

	public $settings_page_slug;
	public $settings_page_hook;
	public $plugin_pre = 'ibic_';
	public $text_domain = 'ibiclang';
	public $isdk; // Holds an instance of the PHP Infusionsoft API
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
		// establish the text domain
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
		// register a slug for the settings page (used by InfusionsoftConnector::register_settings_page )
		$this->settings_page_slug = $this->plugin_pre . 'api_connection_settings';

		// register plugin settings
		add_action('admin_init', array( &$this, 'register_plugin_options') );
		
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_scripts' ) );

		// Register a Settings Page
		add_action( 'admin_menu', array( &$this, 'register_settings_page' ) );
		
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

		// Uncomment the line below if you wish to use an uninstall hook
		// register_uninstall_hook( __FILE__, array( &$this, 'uninstall') );
		
	    /*
	     * TODO:
	     * Define the custom functionality for your plugin. The first parameter of the
	     * add_action/add_filter calls are the hooks into which your code should fire.
	     *
	     * The second parameter is the function name located within this class. See the stubs
	     * later in the file.
	     *
	     * For more information: 
	     * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
	     */
	    //add_action( 'TODO', array( $this, 'action_method_name' ) );
	    //add_filter( 'TODO', array( $this, 'filter_method_name' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here		
	} // end deactivate

	public function uninstall() {
		// TODO define uninstall functionality here
	} // end uninstall method
	
	/**
	 * Register your plugin's options/settings here
	 */
	public function register_plugin_options() {

		// all of our plugin settings will be wrapped inside of this option as an array
		register_setting($this->plugin_pre . 'settings', $this->plugin_pre . 'settings', array( &$this, 'sanitize_settings') );

		// We're going to use a work-around on the Settings API and render all the settings for this
		// section in one function so that we can have more control over the design.
		// We'll use this boilerplate's render_settings_page() method for the below call to
		// add_settings_section, and for each field we will pass the render_null() method
		// to output nothing for each individual field. Our admin.js javascript will contain
		// some code to remove the resulting empty table from the bottom of our settings page.
		// It's not perfect, but it keeps our BoilerPlate class nice & clean while also
		// making the front-end coding of the form a lot more fluid.
		add_settings_section($this->plugin_pre . 'settings', '', array( &$this, 'render_settings_page'), $this->settings_page_slug );

			// To make use of the new(ish) Vendor Key style connections, 
			// you'll want to store - at least - these three fields
			// To use this method you should have already obtained a Vendor Key
			// from infusionsoft here: http://help.infusionsoft.com/developers/vendorkey
			// Once Infusionsoft has provided you with a vendor key, be sure to define
			// it above (just below the plugin header & license in this file)
			add_settings_field('infusionsoft_application_name', '', array( &$this, 'render_null'), $this->settings_page_slug, $this->plugin_pre . 'settings' );
			add_settings_field('infusionsoft_username', '', array( &$this, 'render_null'), $this->settings_page_slug, $this->plugin_pre . 'settings' );
			add_settings_field('infusionsoft_password', '', array( &$this, 'render_null'), $this->settings_page_slug, $this->plugin_pre . 'settings' );

			// To use the original API Key style connection, comment out
			// the three lines above, then uncomment the lines below to use 
			// the API Key style connection instead
			// add_settings_field('infusionsoft_api_key', '', array(&$this, 'render_null'), $this->settings_page_slug, $this->plugin_pre . 'settings' );
			// add_settings_field('infusionsoft_application_name', '', array(&$this, 'render_null'), $this->settings_page_slug, $this->plugin_pre . 'settings' );

		

	} // end register_plugin_options

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		// I've provided a default admin stylesheet specifically for this plugin, here
		wp_register_style( 'infusionsoft-connector-admin-styles', plugins_url( 'infusionsoft-plugin-boilerplate/css/admin.css' ) );
		wp_enqueue_style( 'infusionsoft-connector-admin-styles' );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		// I've provided a default admin javascript file specifically for this plugin, here
		// If needed, replace with your own!
		wp_register_script( 'infusionsoft-connector-admin-script', plugins_url( 'infusionsoft-plugin-boilerplate/js/admin.js' ) );
		wp_enqueue_script( 'infusionsoft-connector-admin-script' );
	
	} // end register_admin_scripts

	/**
	 * Creates an Admin Page to Manage Connection Settings to the Infusionsoft API
	 */
	public function register_settings_page() {
		$this->settings_page_hook = add_options_page( __('Infusionsoft API Settings', $this->text_domain), __('InfusionSoft API', $this->text_domain ), 'manage_options', $this->settings_page_slug, array( &$this, 'render_settings_wrapper' ) );
	}
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		// I've also included a default stylesheet for the frontend as well
		// If needed, replace with your own!
		wp_register_style( 'infusionsoft-connector-plugin-styles', plugins_url( 'infusionsoft-plugin-boilerplate/css/display.css' ) );
		wp_enqueue_style( 'infusionsoft-connector-plugin-styles' );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		// Here is a default javascript file for this plugin that runs on the frontend.
		wp_register_script( 'infusionsoft-connector-plugin-script', plugins_url( 'infusionsoft-plugin-boilerplate/js/display.js' ) );
		wp_enqueue_script( 'infusionsoft-connector-plugin-script' );
	
	} // end register_plugin_scripts

	/**
	 * Outputs the InfusionsoftConnector Settings Page 
	 */
	public function render_settings_wrapper() {

		global $current_user;
		get_current_user();

		if( ! current_user_can('manage_options') )
			wp_die('Y u no Admin? Only Admin come in here!');

		// ensure that we have an instance of the Infusionsoft API to Play with
		if( !isset( $this->isdk ) ) $this->get_isdk();

		// If your plugin requires default settings, use the defaults
		// array below 
		$this->default_options = array(
			'infusionsoft_application_name' => '',
			'infusionsoft_username' => '',
			'infusionsoft_password' => ''
			);

		// grab your plugin options 
		$this->options = get_option($this->plugin_pre . 'settings', $this->default_options);

		// this var tells us if we're ready to attempt a connection
		// by simply checking to ensure all fields starting with 'infusionsoft_'
		// are not empty.
		$ready = true;
		foreach( $this->options as $field => $option ) {

			// not a field related to connecting via API, so move on
			if( strpos($field, 'infusionsoft_') === FALSE )
				continue;

			// if the option is empty, we're missing Connection info,
			// set not ready = true and break.
			if( empty( $option ) )
				$ready = false;
				break;
		}

		if( !$ready ) {

			//add_action('admin_notice', );

		} else {



		}

		// edit the output of the settings page in views/settings_page.php
		include_once plugin_dir_path(__FILE__) . 'views/settings_page.php';
	}

	/**
	 * Outputs the primary settings section associated with the settings page
	 */
	public function render_settings_page() {
		global $current_user;
		get_current_user();

		if( ! current_user_can('manage_options') )
			wp_die('Y u no Admin? Only Admin come in here!');

		// ensure that we have an instance of the Infusionsoft API to Play with
		if( !isset( $this->isdk ) ) $this->get_isdk();

		// make sure the options have been initialised
		if( !isset( $this->options ) )
			$this->options = get_options( $this->plugin_pre . 'settings', $this->default_options );

		// grab the settings section page fragment and output to user
		include_once plugin_dir_path(__FILE__) . 'views/_settings_page_form.php';

	}
	
	// Dummy function for WP SETTINGS API Workaround
	public function render_null() {}

	/**
	 * Clean your settings before storing in the Database.
	 * @param  Array $setting
	 * @return Array
	 */
	public function sanitize_settings( $setting ) {
		return $setting;
	}

	/**
	 * Sets up an instance of Infusionsoft's API wrapper class if one
	 * has not already been defined and assigns it to $this->isdk
	 */
	public function get_isdk() {
		if( !class_exists('iSDK') )
			require_once plugin_dir_path(__FILE__) . 'lib/isdk/isdk.php';

		if( !isset($this->isdk) ) 
			$this->isdk = new iSDK();

		return true;
	}
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
 	 * Note:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *		  WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *		  Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 */
	function action_method_name() {
    	// TODO define your action method here
	} // end action_method_name
	
	/**
	 * Note:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *		  WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *		  Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 */
	function filter_method_name() {
	    // TODO define your filter method here
	} // end filter_method_name
  
} // end class

// TODO: update the instantiation call of your plugin to the name given at the class definition
new InfusionsoftConnector();