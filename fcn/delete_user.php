<?php
// File called by class?

if ( isset( $this ) == false || get_class( $this ) != 'plugin_delete_me' ) {
	
	exit;
	
}

// Does user have the capability?

if ( current_user_can( $this->info['cap'] ) == false ) {
	
	return; // stop executing file
	
}

// Does the trigger value match the currently logged in user ID?

if ( empty( $this->user_ID ) || $this->GET[$this->info['trigger']] != $this->user_ID ) {
	
	return; // stop executing file
	
}

// Nonce

if ( isset( $this->GET[$this->info['nonce']] ) == false || wp_verify_nonce( $this->GET[$this->info['nonce']], $this->info['nonce'] ) == false ) {
	
	return; // stop executing file
	
}

// Delete user

include_once( ABSPATH . 'wp-admin/includes/user.php' );

wp_delete_user( $this->user_ID );

// Redirect to landing URL

( is_admin() ) ? wp_redirect( $this->option['settings']['your_profile_landing_url'] ) : wp_redirect( $this->option['settings']['shortcode_landing_url'] );

exit;
?>