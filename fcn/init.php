<?php
// File called by class?

if ( isset( $this ) == false || get_class( $this ) != 'plugin_delete_me' ) exit;

//-------------------------------------------------------------------------------------------------------------------------------
// ADMIN & FRONT-END
//-------------------------------------------------------------------------------------------------------------------------------

// Version

if ( isset( $this->option['version'] ) ) {
	
	if ( version_compare( $this->option['version'], $this->info['version'], '<' ) ) {
		
		// Upgrade
		
		$this->upgrade();
		
	} elseif ( version_compare( $this->option['version'], $this->info['version'], '>' ) ) {
		
		// Downgrade detected
		
		add_action( 'all_admin_notices', array( &$this, 'downgrade_notice' ) );
		return; // stop executing file
		
	}
	
}

// Copy $_GET | stripslashes, trim

$this->GET = $this->striptrim_deep( $_GET );

// Delete user if trigger in URL

if ( isset( $this->GET[$this->info['trigger']] ) ) $this->delete_user();

// Actions

add_action( 'wpmu_new_blog', array( &$this, 'new_blog' ) );

//-------------------------------------------------------------------------------------------------------------------------------
// ADMIN
//-------------------------------------------------------------------------------------------------------------------------------

if ( is_admin() ) {
	
	$this->POST = $this->striptrim_deep( $_POST ); // Copy $_POST | stripslashes, trim
	$this->admin_init();	
	return;
	
}

//-------------------------------------------------------------------------------------------------------------------------------
// FRONT-END
//-------------------------------------------------------------------------------------------------------------------------------

// Actions

add_action( 'wp', array( &$this, 'add_shortcodes' ) );
