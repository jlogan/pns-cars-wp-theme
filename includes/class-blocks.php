<?php
/**
 * Register PNS Cars Blocks
 * Registers all blocks from block.json files in the blocks directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register PNS Cars block category
 */
function pns_cars_register_block_category( $categories, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		array_unshift(
			$categories,
			array(
				'slug'  => 'pns-cars',
				'title' => 'PNS Cars',
				'icon'  => 'car',
			)
		);
	}
	return $categories;
}
add_filter( 'block_categories_all', 'pns_cars_register_block_category', 10, 2 );

/**
 * Register all PNS Cars blocks from block.json files
 */
function pns_cars_register_blocks() {
	$blocks_dir = get_template_directory() . '/blocks';
	
	if ( ! is_dir( $blocks_dir ) ) {
		if ( WP_DEBUG ) {
			error_log( 'PNS Cars: Blocks directory does not exist: ' . $blocks_dir );
		}
		return;
	}
	
	// Get all block directories
	$block_dirs = glob( $blocks_dir . '/*', GLOB_ONLYDIR );
	
	if ( ! $block_dirs || empty( $block_dirs ) ) {
		if ( WP_DEBUG ) {
			error_log( 'PNS Cars: No block directories found in ' . $blocks_dir );
		}
		return;
	}
	
	foreach ( $block_dirs as $block_dir ) {
		$block_json = $block_dir . '/block.json';
		
		if ( ! file_exists( $block_json ) ) {
			if ( WP_DEBUG ) {
				error_log( 'PNS Cars: block.json not found at ' . $block_json );
			}
			continue;
		}
		
		$result = register_block_type_from_metadata( $block_json );
		if ( ! $result ) {
			if ( WP_DEBUG ) {
				error_log( 'PNS Cars: Failed to register block at ' . $block_dir );
			}
		} else {
			if ( WP_DEBUG ) {
				error_log( 'PNS Cars: Successfully registered block: ' . $result->name . ' at ' . $block_dir );
			}
		}
	}
}
// Register blocks early, before editor assets are enqueued
// Priority 9 ensures blocks are registered before WordPress core blocks (priority 10)
add_action( 'init', 'pns_cars_register_blocks', 9 );

