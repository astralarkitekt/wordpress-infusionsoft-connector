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
define( 'INFUSIONVENDORKEY', '7df953fdfa57d53f68fed1a86b88fd5a' );

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
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
		// establish the text domain
		load_plugin_textdomain( 'infusionsoft-connector', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_scripts' ) );
		
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array(&$this, 'uninstall') );
		
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
	    add_action( 'TODO', array( $this, 'action_method_name' ) );
	    add_filter( 'TODO', array( $this, 'filter_method_name' ) );

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
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		// TODO change 'plugin-name' to the name of your plugin
		wp_register_style( 'plugin-name-admin-styles', plugins_url( 'plugin-name/css/admin.css' ) );
		wp_enqueue_style( 'plugin-name-admin-styles' );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		// TODO change 'plugin-name' to the name of your plugin
		wp_register_script( 'plugin-name-admin-script', plugins_url( 'plugin-name/js/admin.js' ) );
		wp_enqueue_script( 'plugin-name-admin-script' );
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		// TODO change 'plugin-name' to the name of your plugin
		wp_register_style( 'plugin-name-plugin-styles', plugins_url( 'plugin-name/css/display.css' ) );
		wp_enqueue_style( 'plugin-name-plugin-styles' );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		// TODO change 'plugin-name' to the name of your plugin
		wp_register_script( 'plugin-name-plugin-script', plugins_url( 'plugin-name/js/display.js' ) );
		wp_enqueue_script( 'plugin-name-plugin-script' );
	
	} // end register_plugin_scripts
	
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