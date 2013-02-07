<?php
// File called by class?

if ( isset( $this ) == false || get_class( $this ) != 'plugin_delete_me' ) {
	
	exit;
	
}
?>
<div class="error">
	
	<p><strong>Plugin <em style="text-decoration: underline;"><?php echo $this->info['name']; ?></em> cannot be downgraded.</strong></p>
	
	<p>Previously installed version = <?php echo $this->option['version']; ?></p>
	
	<p>Currently installed version = <?php echo $this->info['version']; ?></p>
	
	<p><a href="<?php echo esc_url( $this->info['uri'] ); ?>">Visit plugin site</a> for the latest version or deactivate this plugin on the WordPress <code>Plugins</code> panel.</p> 
	
</div>