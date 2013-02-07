<?php
// File called by class?

if ( isset( $this ) == false || get_class( $this ) != 'plugin_delete_me' ) {
	
	exit;
	
}

// Only show message in admin area

if ( is_admin() == false ) {
	
	return; // stop executing file
	
}
?>
<div class="<?php echo $this->admin_message_class; ?>">
	<p><?php echo $this->admin_message_content; ?></p>
</div>