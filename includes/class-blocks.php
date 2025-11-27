<?php
/**
 * Gutenberg Blocks Registration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PNS_Cars_Blocks {

	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_assets' ) );
		add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 10, 2 );
	}

	public function register_blocks() {
		$blocks = array(
			'hero',
			'how-it-works',
			'services',
			'vehicles',
			'pricing',
			'faq',
			'location',
		);

		foreach ( $blocks as $block ) {
			$block_path = get_template_directory() . '/blocks/' . $block . '-block';
			if ( file_exists( $block_path . '/block.json' ) ) {
				// Use register_block_type_from_metadata for block.json files (WordPress 5.5+)
				if ( function_exists( 'register_block_type_from_metadata' ) ) {
					$result = register_block_type_from_metadata( $block_path );
				} else {
					// Fallback for older WordPress versions
					$result = register_block_type( $block_path );
				}
				
				// Debug: Log if block registration fails
				if ( ! $result && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( 'Failed to register block: ' . $block_path );
				}
			}
		}
	}

	public function enqueue_block_assets() {
		// Enqueue shared editor script for all blocks (must load early to register blocks)
		wp_enqueue_script(
			'pns-cars-block-editor',
			get_template_directory_uri() . '/assets/js/block-editor.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
			wp_get_theme()->get( 'Version' ),
			true
		);

		// Enqueue script to pre-fill block attributes from ACF options (loads after block registration)
		wp_enqueue_script(
			'pns-cars-blocks',
			get_template_directory_uri() . '/assets/js/blocks.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-data', 'pns-cars-block-editor' ),
			wp_get_theme()->get( 'Version' ),
			true
		);

		// Pass ACF option data to JavaScript
		$acf_data = array(
			'hero' => array(
				'headline' => get_field( 'hero_headline', 'option' ) ?: '',
				'subheadline' => get_field( 'hero_subheadline', 'option' ) ?: '',
				'ctaPrimary' => get_field( 'hero_cta_primary', 'option' ) ?: '',
				'ctaSecondary' => get_field( 'hero_cta_secondary', 'option' ) ?: '',
			),
			'howItWorks' => array(
				'heading' => get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works',
				'steps' => $this->get_acf_repeater_data( 'steps', 'option' ),
			),
			'services' => array(
				'heading' => get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers',
				'services' => $this->get_acf_repeater_data( 'services_list', 'option' ),
			),
			'vehicles' => array(
				'heading' => get_field( 'vehicles_heading', 'option' ) ?: 'Available Vehicles',
				'count' => get_field( 'vehicles_count', 'option' ) ?: -1,
				'perRow' => get_field( 'vehicles_per_row', 'option' ) ?: 3,
			),
			'pricing' => array(
				'headline' => get_field( 'pricing_headline', 'option' ) ?: '',
				'content' => get_field( 'pricing_content', 'option' ) ?: '',
			),
			'faq' => array(
				'heading' => get_field( 'faq_heading', 'option' ) ?: 'Frequently Asked Questions',
				'faqs' => $this->get_acf_repeater_data( 'faqs', 'option' ),
			),
			'location' => array(
				'heading' => get_field( 'location_heading', 'option' ) ?: 'Find Us',
				'addressText' => get_field( 'address_text', 'option' ) ?: '',
				'mapLink' => get_field( 'map_link', 'option' ) ?: '',
				'googleMapsEmbedUrl' => get_field( 'google_maps_embed_url', 'option' ) ?: '',
			),
		);

		wp_localize_script( 'pns-cars-blocks', 'pnsCarsACFData', $acf_data );
	}

	private function get_acf_repeater_data( $field_name, $post_id = 'option' ) {
		$data = array();
		if ( function_exists( 'have_rows' ) && have_rows( $field_name, $post_id ) ) {
			while ( have_rows( $field_name, $post_id ) ) {
				the_row();
				$row = array();
				$sub_fields = get_row();
				if ( is_array( $sub_fields ) ) {
					foreach ( $sub_fields as $key => $value ) {
						$row[ $key ] = $value;
					}
				}
				if ( ! empty( $row ) ) {
					$data[] = $row;
				}
			}
		}
		return $data;
	}

	public function register_block_category( $categories, $editor_context ) {
		// Register block category
		array_unshift(
			$categories,
			array(
				'slug'  => 'pns-cars',
				'title' => 'PNS Cars',
				'icon'  => null,
			)
		);
		return $categories;
	}
}

new PNS_Cars_Blocks();

