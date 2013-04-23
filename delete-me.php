<?php
/*
Plugin Name: Delete Me
Plugin URI: http://wordpress.org/extend/plugins/delete-me/
Description: Allow specific WordPress roles to delete themselves on the WordPress <code>Users &rarr; Your Profile</code> subpanel or on any Post or Page using the Shortcode <code>[plugin_delete_me /]</code>. Settings for this plugin are found on the <code>Settings &rarr; Delete Me</code> subpanel. Multisite and Network Activation supported.
Version: 1.3
Author: Clinton Caldwell
Author URI: http://wordpress.org/
License: GPL2 http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Copyright (c) 2013 - Clinton Caldwell <cmc3215@gmail.com>

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

// Prevent this plugin file from being accessed directly (should be loaded by WordPress)

if ( realpath( __FILE__ ) === realpath( $_SERVER['SCRIPT_FILENAME'] ) ) exit;

//--------------------------------------------------------------------------------------------------------------------------------------
//   
//   THIS PLUGIN IS ONE CLASS (plugin_delete_me)
//   
// - The "fcn" directory contains functions (or methods) within the class that are not required to be loaded on every page so they're
//   only loaded when needed to make things faster.
//   
// - The "license" directory contains a copy of the GPL2 license this plugin is released under.
//   
// - The "screenshot-{digit}" files in this directory are just my screenshots of this plugin and are not required for the plugin to work.
//   
//--------------------------------------------------------------------------------------------------------------------------------------

if ( class_exists( 'plugin_delete_me' ) == false ) :

class plugin_delete_me {
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// PROPERTIES
	//-------------------------------------------------------------------------------------------------------------------------------
	
	private $wp_roles;
	private $wp_version;
	private $wpdb;
	private $user_ID;
	private $user_login;
	private $user_email;
	
	private $info;
	private $option;
	private $admin_message_class;
	private $admin_message_content;
		
	private $GET;
	private $POST;
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// METHODS
	//-------------------------------------------------------------------------------------------------------------------------------
	
	public function __construct() {
		
		// Reference WordPress globals ( just to allow easier access, don't have to keep setting them global inside each method )
		
		global $wp_roles, $wp_version, $wpdb, $user_ID, $user_login, $user_email;
		
		$this->wp_roles = &$wp_roles;
		$this->wp_version = &$wp_version;
		$this->wpdb = &$wpdb;
		$this->user_ID = &$user_ID;
		$this->user_login = &$user_login;
		$this->user_email = &$user_email;
		
		// Info
		
		$this->info = array(
			'name' => 'Delete Me',
			'uri' => 'http://wordpress.org/extend/plugins/delete-me/',
			'version' => '1.3',
			'php_version_min' => '5.2.4',
			'wp_version_min' => '3.5.1',
			'option' => 'plugin_delete_me',
			'shortcode' => 'plugin_delete_me',
			'slug_prefix' => 'plugin_delete_me',
			'cap' => 'plugin_delete_me',
			'trigger' => 'plugin_delete_me',
			'nonce' => 'plugin_delete_me_nonce',
			'dirname' => dirname( __FILE__ )
		);
		
		// Compatible?
		
		if ( $this->is_compatible() == false ) {				
			
			add_action( ( ( version_compare( $this->wp_version, '3.1', '>=' ) == true ) ? 'all_admin_notices' : 'admin_notices' ), array( &$this, 'is_compatible_notice' ) );
			return; // stop object construction
			
		}
		
		// Option
		
		$this->option = $this->fetch_option();
		
		// Register Activate & Deactivate Hooks
		
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
		
		// Initialize plugin after WordPress has loaded
		
		add_action( 'wp_loaded', array( &$this, 'init' ) );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// WP LOADED - INIT
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Init
	
	public function init() {
		
		include_once( $this->info['dirname'] . '/fcn/init.php' );
		
	}
	
	// Admin init
	
	private function admin_init() {
		
		include_once( $this->info['dirname'] . '/fcn/admin_init.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// FRONT-END
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Add shortcode
	
	public function add_shortcodes() {
		
		add_shortcode( $this->info['shortcode'], array( &$this, 'shortcode_' . $this->info['shortcode'] ) );
		
	}
	
	// Shortcode
	
	public function shortcode_plugin_delete_me( $atts = array(), $content = '', $code = '' ) {
		
		include_once( $this->info['dirname'] . '/fcn/shortcode_plugin_delete_me.php' );
		
		return ( isset( $longcode ) ) ? $longcode : $content;
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// ADMIN - PAGE CALLBACKS
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Settings
	
	public function admin_page_settings() {
		
		include_once( $this->info['dirname'] . '/fcn/admin_page_settings.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// ADMIN - ACTION CALLBACKS
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// @ admin_menu
	
	public function action_admin_menu() {
		
		include_once( $this->info['dirname'] . '/fcn/action_admin_menu.php' );
		
	}
	
	// @ show_user_profile
	
	public function action_show_user_profile( $profileuser ) {
		
		include_once( $this->info['dirname'] . '/fcn/action_show_user_profile.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// ADMIN & FRONT-END
	//-------------------------------------------------------------------------------------------------------------------------------
	
	private function delete_user() {
		
		include_once( $this->info['dirname'] . '/fcn/delete_user.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// PLUGIN OPERATIONS
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Activate
	
	public function activate( $network_wide = false ) {
		
		include_once( $this->info['dirname'] . '/fcn/activate.php' );
		
	}
	
	// Deactivate
	
	public function deactivate( $network_wide = false ) {
		
		include_once( $this->info['dirname'] . '/fcn/deactivate.php' );
		
	}
	
	// New Blog
	
	public function new_blog( $blog_id ) {
		
		$plugin = basename( $this->info['dirname'] );
		
		if ( is_plugin_active_for_network( $plugin . '/' . $plugin . '.php' ) ) {
			
			switch_to_blog( $blog_id );
			
			$this->activate();
			
			restore_current_blog();
			
		}
		
	}
	
	// Upgrade
	
	private function upgrade() {
		
		include_once( $this->info['dirname'] . '/fcn/upgrade.php' );
		
	}
	
	// Downgrade notice
	
	public function downgrade_notice() {
		
		include_once( $this->info['dirname'] . '/fcn/downgrade_notice.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// PLUGIN OPTION
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Default
	
	private function default_option() {
		
		return array(
			
			// Settings
			
			'settings' => array(
				'your_profile_class' => NULL,
				'your_profile_style' => NULL,
				'your_profile_anchor' => 'Delete Profile',
				'your_profile_js_confirm' => 'WARNING!\n\nAll your Posts and Links will be deleted.\n\nAre you sure you want to delete user %username%?',
				'your_profile_landing_url' => home_url(),
				'shortcode_class' => NULL,
				'shortcode_style' => NULL,
				'shortcode_anchor' => 'Delete Profile',
				'shortcode_js_confirm' => 'WARNING!\n\nAll your Posts and Links will be deleted.\n\nAre you sure you want to delete user %username%?',
				'shortcode_landing_url' => home_url(),
				'ms_delete_from_network' => true,
				'delete_comments' => false,
				'email_notification' => false,
				'uninstall_on_deactivate' => false
				
			),
			
			// Version
			
			'version' => $this->info['version']
			
		);
		
	}
	
	// Fetch
	
	private function fetch_option() {
		
		return get_option( $this->info['option'], array() );
		
	}
	
	// Save
	
	private function save_option() {
		
		return update_option( $this->info['option'], $this->option );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// COMPATIBILITY
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Is compatible
	
	private function is_compatible() {
		
		if ( version_compare( PHP_VERSION, $this->info['php_version_min'], '<' ) == true ) {
			
			return false;
			
		} elseif ( version_compare( $this->wp_version, $this->info['wp_version_min'], '<' ) == true ) {
			
			return false;
			
		} else {
			
			return true;
			
		}
		
	}
	
	// Is compatible notice
	
	public function is_compatible_notice() {
		
		include_once( $this->info['dirname'] . '/fcn/is_compatible_notice.php' );
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------
	// UTILITIES
	//-------------------------------------------------------------------------------------------------------------------------------
	
	// Admin message
	
	public function admin_message() {
		
		include_once( $this->info['dirname'] . '/fcn/admin_message.php' );
		
	}
	
	// Sync arrays
	
	private function sync_arrays( $sync_to, $sync_from ) {
		
		foreach ( $sync_from as $key => $value ) {
			
			if ( array_key_exists( $key, $sync_to ) ) {
				
				if ( is_array( $sync_to[$key] ) && is_array( $value ) ) {
					
					$sync_to[$key] = $this->sync_arrays( $sync_to[$key], $sync_from[$key] );
					
				} else {
					
					$sync_to[$key] = $value;
					
				}
				
			}
			
		}
		
		return $sync_to;
		
	}
	
	// Striptrim deep
	
	private function striptrim_deep( $value ) {
		
		if ( is_array( $value ) ) {
			
			$value = array_map( array( &$this, 'striptrim_deep' ), $value );
			
		} elseif ( is_object( $value ) ) {
			
			$vars = get_object_vars( $value );
			
			foreach ($vars as $key => $data) {
				
				$value->{$key} = striptrim_deep( $data );
				
			}
			
		} else {
			
			$value = trim( stripslashes( $value ) );
			
		}
		
		return $value;
		
	}
	
}

// Instaniate plugin class

new plugin_delete_me();

endif; // class_exists
