<?php
// File called by class?

if ( isset( $this ) == false || get_class( $this ) != 'plugin_delete_me' ) {
	
	exit;
	
}

// Does user have the capability?

if ( $profileuser->has_cap( $this->info['cap'] ) == false || ( is_multisite() && is_super_admin() ) ) {
	
	return; // stop executing file
	
}

// User has capability, prepare delete link

$delete_warning = 'All your Posts' . ( ( $this->option['settings']['delete_comments'] == true ) ? ', Links, and Comments' : ' and Links' ) . ' will be deleted.';

$attributes = array();
$attributes['href'] = esc_url( add_query_arg( array( $this->info['trigger'] => $profileuser->ID, $this->info['nonce'] => wp_create_nonce( $this->info['nonce'] ) ) ) );
$attributes['onclick'] = "if ( confirm( 'WARNING!" . '\n\n' . $delete_warning . '\n\n' . "Are you sure you want to delete user " . $profileuser->user_login . "?' ) ) { window.location.href=this.href } return false;";
$attributes['class'] = $this->option['settings']['your_profile_class'];
$attributes['style'] = $this->option['settings']['your_profile_style'];

// Remove empty attributes

$attributes = array_filter( $attributes );

// Assemble attributes in key="value" pairs

foreach ( $attributes as $key => $value ) {
	
	$paired_attributes[] = $key . '="' . $value . '"';
	
}

// Output delete link
?>
<table class="form-table">
	
	<tr>
		<th>&nbsp;</th>
		<td><?php echo '<a ' . implode( ' ', $paired_attributes ) . '>' . $this->option['settings']['your_profile_anchor'] . '</a>'; ?></td>
	</tr>
	
</table>