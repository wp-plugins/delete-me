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

// E-mail notification

if ( $this->option['settings']['email_notification'] == true ) :
	
	// Posts
	
	$posts = $this->wpdb->get_results( "SELECT `ID`, `post_title`, `post_type` FROM " . $this->wpdb->posts . " WHERE `post_author`='" . $this->user_ID . "'", ARRAY_A );
	
	$posts_formatted = array();
	
	foreach ( $posts as $post ) {
		
		$posts_formatted[] = html_entity_decode( $post['post_title'], ENT_QUOTES, get_option( 'blog_charset' ) ) . "\n" . ucwords( $post['post_type'] ) . ' ' . get_permalink( $post['ID'] );
		
	}
	
	if ( empty( $posts ) ) {
		
		$posts_formatted = array( '( None )' );
		
	}
	
	// Links
	
	$links = $this->wpdb->get_results( "SELECT `link_url`, `link_name` FROM " . $this->wpdb->links . " WHERE `link_owner`='" . $this->user_ID . "'", ARRAY_A );
	
	$links_formatted = array();
	
	foreach ( $links as $link ) {
		
		$links_formatted[] = html_entity_decode( $link['link_name'], ENT_QUOTES, get_option( 'blog_charset' ) ) . "\n" . $link['link_url'];
		
	}
	
	if ( empty( $links ) ) {
		
		$links_formatted = array( '( None )' );
		
	}
	
	// E-mail
	
	$email = array();
	$email['to'] = get_option( 'admin_email' );
	$email['subject'] = '[' . get_option( 'blogname' ) . '] Deleted User Notification';
	$email['message'] =
	'Deleted user on your site ' . get_option( 'blogname' ) . ':' . "\n\n" .
	
	'Username: ' . $this->user_login . "\n\n" .
	
	'E-mail: ' . $this->user_email . "\n\n" .
	
	'This user deleted themselves using the WordPress plugin ' . $this->info['name'] . "\n\n" .
	
	count( $posts ) . ' Posts' . "\n" .
	'----------------------------------------------------------------------' . "\n" .
	implode( "\n\n", $posts_formatted ) . "\n\n" .
	
	count( $links ) . ' Links' . "\n" .
	'----------------------------------------------------------------------' . "\n" .
	implode( "\n\n", $links_formatted );
	
	wp_mail( $email['to'], $email['subject'], $email['message'] );
	
endif;

// Delete user ( including each Post & Link belonging to the user )

include_once( ABSPATH . WPINC . '/post.php' ); // wp_delete_post
include_once( ABSPATH . 'wp-admin/includes/bookmark.php' ); // wp_delete_link
include_once( ABSPATH . 'wp-admin/includes/user.php' ); // wp_delete_user

wp_delete_user( $this->user_ID );

// Redirect to landing URL

( is_admin() ) ? wp_redirect( $this->option['settings']['your_profile_landing_url'] ) : wp_redirect( $this->option['settings']['shortcode_landing_url'] );

exit;
?>