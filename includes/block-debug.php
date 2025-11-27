<?php
/**
 * Block Registration Debug Helper
 * Add ?pns_debug_blocks=1 to any admin page to see registered blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_notices', function() {
	if ( ! isset( $_GET['pns_debug_blocks'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$pns_blocks = array_filter( $registered_blocks, function( $block ) {
		return strpos( $block->name, 'pns-cars/' ) === 0;
	});

	echo '<div class="notice notice-info"><p><strong>PNS Cars Blocks Debug:</strong></p>';
	echo '<p>Found ' . count( $pns_blocks ) . ' PNS Cars blocks registered:</p><ul>';
	foreach ( $pns_blocks as $block_name => $block ) {
		echo '<li><strong>' . esc_html( $block_name ) . '</strong> - ' . esc_html( $block->title ) . '</li>';
	}
	echo '</ul></div>';
});

