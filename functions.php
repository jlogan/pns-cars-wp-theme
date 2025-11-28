<?php
/**
 * PNS Cars Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Theme Setup
 */
function pns_cars_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Switch default core markup to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
}
add_action( 'after_setup_theme', 'pns_cars_setup' );

/**
 * 2. Include Blocks
 */
require_once get_template_directory() . '/includes/class-blocks.php';
require_once get_template_directory() . '/includes/block-debug.php';

/**
 * 3. Enqueue Assets
 */
function pns_cars_scripts() {
	$version = wp_get_theme()->get( 'Version' );

	// Google Fonts
	wp_enqueue_style( 'pns-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Oswald:wght@500;700&display=swap', array(), null );

	// Main CSS
	wp_enqueue_style( 'pns-cars-style', get_stylesheet_uri(), array(), $version );

	// Main JS
	wp_enqueue_script( 'pns-cars-main', get_template_directory_uri() . '/assets/js/main.js', array(), $version, true );
}
add_action( 'wp_enqueue_scripts', 'pns_cars_scripts' );

/**
 * Enqueue Block Editor Assets
 */
function pns_cars_block_editor_assets() {
	$version = wp_get_theme()->get( 'Version' );
	
	// Block editor script
	wp_enqueue_script(
		'pns-cars-block-editor',
		get_template_directory_uri() . '/assets/js/block-editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-hooks' ),
		$version,
		true
	);
	
	// Localize ACF data for block editor
	$acf_data = array();
	
	// Hero data - get partner logos from ACF
	$partners_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'hero_partner_logos', 'option' ) ) {
		while ( have_rows( 'hero_partner_logos', 'option' ) ) {
			the_row();
			$partners_data[] = array(
				'image' => get_sub_field( 'image' ) ?: '',
				'imageId' => null, // ACF stores URL, not ID
				'alt' => get_sub_field( 'alt' ) ?: '',
				'link' => get_sub_field( 'link' ) ?: '',
			);
		}
	}
	// Default partner logos if empty
	if ( empty( $partners_data ) ) {
		$theme_img_url = get_template_directory_uri() . '/assets/img/';
		$partners_data = array(
			array(
				'image' => $theme_img_url . 'uber-logo.svg',
				'imageId' => null,
				'alt' => 'Uber',
				'link' => 'https://www.uber.com',
			),
			array(
				'image' => $theme_img_url . 'lyft-logo.svg',
				'imageId' => null,
				'alt' => 'Lyft',
				'link' => 'https://www.lyft.com',
			),
			array(
				'image' => $theme_img_url . 'doordash-logo.svg',
				'imageId' => null,
				'alt' => 'DoorDash',
				'link' => 'https://www.doordash.com',
			),
			array(
				'image' => $theme_img_url . 'instacart-logo.svg',
				'imageId' => null,
				'alt' => 'Instacart',
				'link' => 'https://www.instacart.com',
			),
			array(
				'image' => $theme_img_url . 'shipt-logo.svg',
				'imageId' => null,
				'alt' => 'Shipt',
				'link' => 'https://www.shipt.com',
			),
		);
	}
	$acf_data['hero'] = array(
		'headline' => get_field( 'hero_headline', 'option' ) ?: 'Drive today. Earn this week.',
		'subheadline' => get_field( 'hero_subheadline', 'option' ) ?: 'Get behind the wheel of a reliable vehicle and start earning with Uber, Lyft, and DoorDash immediately. No credit checks, easy approval.',
		'ctaPrimary' => get_field( 'hero_cta_primary', 'option' ) ?: 'View Available Vehicles',
		'ctaPrimaryLink' => get_field( 'hero_cta_primary_link', 'option' ) ?: '#vehicles',
		'ctaSecondary' => get_field( 'hero_cta_secondary', 'option' ) ?: 'Start Your Booking',
		'ctaSecondaryLink' => get_field( 'hero_cta_secondary_link', 'option' ) ?: '#booking',
		'partnersText' => get_field( 'hero_partners_text', 'option' ) ?: 'Perfect for:',
		'partners' => $partners_data,
		'lifestyleImage' => get_field( 'hero_lifestyle_image', 'option' ) ?: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop',
		'lifestyleImageId' => null, // Will be set if image is uploaded via media library
		'earningsHeader' => get_field( 'hero_earnings_header', 'option' ) ?: 'Weekly Earnings',
		'earningsAmount' => get_field( 'hero_earnings_amount', 'option' ) ?: '1426.29',
		'earningsSubtext' => get_field( 'hero_earnings_subtext', 'option' ) ?: 'Oct 4 - Oct 10 • 33 Trips',
		'earningsOnline' => get_field( 'hero_earnings_online', 'option' ) ?: '20h 16m',
		'earningsTips' => get_field( 'hero_earnings_tips', 'option' ) ?: '+$187.24',
		'notification1Icon' => get_field( 'hero_notification1_icon', 'option' ) ?: '💰',
		'notification1Title' => get_field( 'hero_notification1_title', 'option' ) ?: 'Payout Processed',
		'notification1Sub' => get_field( 'hero_notification1_sub', 'option' ) ?: 'You received $999.41',
		'notification2Icon' => get_field( 'hero_notification2_icon', 'option' ) ?: '🚗',
		'notification2Title' => get_field( 'hero_notification2_title', 'option' ) ?: 'New Tip!',
		'notification2Sub' => get_field( 'hero_notification2_sub', 'option' ) ?: '+$15.00 from Sarah',
	);
	
	// How It Works data
	$steps_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'steps', 'option' ) ) {
		while ( have_rows( 'steps', 'option' ) ) {
			the_row();
			$steps_data[] = array(
				'title' => get_sub_field( 'title' ) ?: '',
				'description' => get_sub_field( 'description' ) ?: '',
				'icon' => get_sub_field( 'icon' ) ?: '',
			);
		}
	}
	$acf_data['howItWorks'] = array(
		'heading' => get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works',
		'steps' => $steps_data,
	);
	
	// Services data
	$services_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'services_list', 'option' ) ) {
		while ( have_rows( 'services_list', 'option' ) ) {
			the_row();
			$services_data[] = array(
				'title' => get_sub_field( 'title' ) ?: '',
				'description' => get_sub_field( 'description' ) ?: '',
			);
		}
	}
	$acf_data['services'] = array(
		'heading' => get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers',
		'services' => $services_data,
	);
	
	// Vehicles data
	$acf_data['vehicles'] = array(
		'heading' => get_field( 'vehicles_heading', 'option' ) ?: 'Available Vehicles',
		'count' => get_field( 'vehicles_count', 'option' ) !== false ? get_field( 'vehicles_count', 'option' ) : -1,
		'perRow' => get_field( 'vehicles_per_row', 'option' ) ?: 3,
	);
	
	// Pricing data
	$pricing_list_items = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'pricing_list_items', 'option' ) ) {
		while ( have_rows( 'pricing_list_items', 'option' ) ) {
			the_row();
			$item = get_sub_field( 'item' );
			if ( $item ) {
				$pricing_list_items[] = $item;
			}
		}
	}
	if ( empty( $pricing_list_items ) ) {
		$pricing_list_items = array(
			'$250 Refundable Deposit',
			'Weekly automatic payments',
			'Minimum 2-week rental'
		);
	}
	$acf_data['pricing'] = array(
		'headline' => get_field( 'pricing_headline', 'option' ) ?: 'Simple, Transparent Pricing',
		'introText' => get_field( 'pricing_intro_text', 'option' ) ?: 'No hidden fees. One weekly price covers the car, insurance, and maintenance.',
		'listItems' => $pricing_list_items,
		'buttonText' => get_field( 'pricing_button_text', 'option' ) ?: 'Choose Your Car',
		'buttonLink' => get_field( 'pricing_button_link', 'option' ) ?: '#vehicles',
	);
	
	// FAQ data
	$faqs_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'faqs', 'option' ) ) {
		while ( have_rows( 'faqs', 'option' ) ) {
			the_row();
			$faqs_data[] = array(
				'question' => get_sub_field( 'question' ) ?: '',
				'answer' => get_sub_field( 'answer' ) ?: '',
			);
		}
	}
	$acf_data['faq'] = array(
		'heading' => get_field( 'faq_heading', 'option' ) ?: 'Frequently Asked Questions',
		'faqs' => $faqs_data,
	);
	
	// Location data
	$acf_data['location'] = array(
		'heading' => get_field( 'location_heading', 'option' ) ?: 'Find Us',
		'addressText' => get_field( 'address_text', 'option' ) ?: "PNS Global Resources L.L.C<br>\n5872 New Peachtree Rd Ste 103<br>\nDoraville, GA 30340<br>\n<br>\nServing the Atlanta Metro Area",
		'servingText' => get_field( 'location_serving_text', 'option' ) ?: 'Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.',
		'mapLink' => get_field( 'map_link', 'option' ) ?: 'https://goo.gl/maps/place/5872+New+Peachtree+Rd+Ste+103,+Doraville,+GA+30340',
		'buttonText' => get_field( 'location_button_text', 'option' ) ?: 'Get Directions',
		'googleMapsEmbedUrl' => get_field( 'google_maps_embed_url', 'option' ) ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17969.587510091234!2d-84.29384894259061!3d33.90250098033048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f509c59cbfffff%3A0xfb53040bca7eb8ed!2s5872%20New%20Peachtree%20Rd%20Ste%20103%2C%20Doraville%2C%20GA%2030340!5e0!3m2!1sen!2sus!4v1764203567826!5m2!1sen!2sus',
	);
	
	wp_localize_script( 'pns-cars-block-editor', 'pnsCarsACFData', $acf_data );
}
add_action( 'enqueue_block_editor_assets', 'pns_cars_block_editor_assets' );

/**
 * 4. ACF Options Page & Fields
 * Note: Options page removed - blocks now manage their own data
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	// Register Fields Programmatically (fields still needed for block fallbacks)
	add_action( 'acf/init', 'pns_cars_register_fields' );
}

function pns_cars_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_pns_landing_page',
		'title' => 'Landing Page Content',
		'fields' => array(
			// Tab: Hero
			array(
				'key' => 'field_tab_hero',
				'label' => 'Hero Section',
				'type' => 'tab',
			),
			array(
				'key' => 'field_hero_headline',
				'label' => 'Headline',
				'name' => 'hero_headline',
				'type' => 'text',
			),
			array(
				'key' => 'field_hero_subheadline',
				'label' => 'Subheadline',
				'name' => 'hero_subheadline',
				'type' => 'textarea',
				'rows' => 3,
			),
			array(
				'key' => 'field_hero_cta_primary',
				'label' => 'Primary CTA Text',
				'name' => 'hero_cta_primary',
				'type' => 'text',
			),
			array(
				'key' => 'field_hero_cta_secondary',
				'label' => 'Secondary CTA Text',
				'name' => 'hero_cta_secondary',
				'type' => 'text',
			),
			array(
				'key' => 'field_hero_partners_text',
				'label' => 'Partners Text',
				'name' => 'hero_partners_text',
				'type' => 'text',
				'default_value' => 'Perfect for:',
			),
			array(
				'key' => 'field_hero_partner_logos',
				'label' => 'Partner Logos',
				'name' => 'hero_partner_logos',
				'type' => 'repeater',
				'layout' => 'table',
				'sub_fields' => array(
					array(
						'key' => 'field_partner_image',
						'label' => 'Image URL',
						'name' => 'image',
						'type' => 'url',
					),
					array(
						'key' => 'field_partner_alt',
						'label' => 'Alt Text',
						'name' => 'alt',
						'type' => 'text',
					),
					array(
						'key' => 'field_partner_link',
						'label' => 'Link URL',
						'name' => 'link',
						'type' => 'url',
					),
				),
			),
			
			// Tab: How It Works
			array(
				'key' => 'field_tab_how',
				'label' => 'How It Works',
				'type' => 'tab',
			),
			array(
				'key' => 'field_how_it_works_heading',
				'label' => 'Section Heading',
				'name' => 'how_it_works_heading',
				'type' => 'text',
				'default_value' => 'How It Works',
				'instructions' => 'Heading text displayed above the steps section',
			),
			array(
				'key' => 'field_steps',
				'label' => 'Steps',
				'name' => 'steps',
				'type' => 'repeater',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_step_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_step_desc',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'textarea',
						'rows' => 2,
					),
					array(
						'key' => 'field_step_icon',
						'label' => 'Icon Code (Dashicon/Emoji)',
						'name' => 'icon',
						'type' => 'text',
						'instructions' => 'Paste an emoji or dashicon class',
					),
				),
			),

			// Tab: Services
			array(
				'key' => 'field_tab_services',
				'label' => 'Services',
				'type' => 'tab',
			),
			array(
				'key' => 'field_services_heading',
				'label' => 'Section Heading',
				'name' => 'services_heading',
				'type' => 'text',
				'default_value' => 'Benefits for Drivers',
				'instructions' => 'Heading text displayed above the services section',
			),
			array(
				'key' => 'field_services_list',
				'label' => 'Service Cards',
				'name' => 'services_list',
				'type' => 'repeater',
				'sub_fields' => array(
					array(
						'key' => 'field_service_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_service_desc',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'textarea',
					),
				),
			),

			// Tab: Vehicles
			array(
				'key' => 'field_tab_vehicles',
				'label' => 'Vehicles',
				'type' => 'tab',
			),
			array(
				'key' => 'field_vehicles_heading',
				'label' => 'Section Heading',
				'name' => 'vehicles_heading',
				'type' => 'text',
				'default_value' => 'Available Vehicles',
				'instructions' => 'Heading text displayed above the vehicles grid',
			),
			array(
				'key' => 'field_vehicles_count',
				'label' => 'Number of Items to Show',
				'name' => 'vehicles_count',
				'type' => 'number',
				'default_value' => -1,
				'instructions' => 'Number of vehicles to display in the grid. Use -1 to show all available vehicles.',
				'min' => -1,
			),
			array(
				'key' => 'field_vehicles_per_row',
				'label' => 'Items Per Row',
				'name' => 'vehicles_per_row',
				'type' => 'number',
				'default_value' => 3,
				'instructions' => 'Number of vehicle cards to display per row in the grid',
				'min' => 1,
				'max' => 6,
			),

			// Tab: Pricing
			array(
				'key' => 'field_tab_pricing',
				'label' => 'Pricing',
				'type' => 'tab',
			),
			array(
				'key' => 'field_pricing_headline',
				'label' => 'Pricing Headline',
				'name' => 'pricing_headline',
				'type' => 'text',
			),
			array(
				'key' => 'field_pricing_content',
				'label' => 'Pricing Content',
				'name' => 'pricing_content',
				'type' => 'wysiwyg',
			),

			// Tab: FAQ
			array(
				'key' => 'field_tab_faq',
				'label' => 'FAQ',
				'type' => 'tab',
			),
			array(
				'key' => 'field_faq_heading',
				'label' => 'Section Heading',
				'name' => 'faq_heading',
				'type' => 'text',
				'default_value' => 'Frequently Asked Questions',
				'instructions' => 'Heading text displayed above the FAQ section',
			),
			array(
				'key' => 'field_faqs',
				'label' => 'FAQs',
				'name' => 'faqs',
				'type' => 'repeater',
				'sub_fields' => array(
					array(
						'key' => 'field_faq_q',
						'label' => 'Question',
						'name' => 'question',
						'type' => 'text',
					),
					array(
						'key' => 'field_faq_a',
						'label' => 'Answer',
						'name' => 'answer',
						'type' => 'textarea',
					),
				),
			),

			// Tab: Location
			array(
				'key' => 'field_tab_location',
				'label' => 'Location',
				'type' => 'tab',
			),
			array(
				'key' => 'field_location_heading',
				'label' => 'Section Heading',
				'name' => 'location_heading',
				'type' => 'text',
				'default_value' => 'Find Us',
				'instructions' => 'Heading text displayed in the location section',
			),
			array(
				'key' => 'field_address_text',
				'label' => 'Address Block',
				'name' => 'address_text',
				'type' => 'textarea',
			),
			array(
				'key' => 'field_map_link',
				'label' => 'Map Link URL',
				'name' => 'map_link',
				'type' => 'url',
			),
			array(
				'key' => 'field_google_maps_embed_url',
				'label' => 'Google Maps Embed URL',
				'name' => 'google_maps_embed_url',
				'type' => 'text',
				'instructions' => 'Paste the "src" attribute from the Google Maps embed iframe code here.',
			),

			// Tab: Contact
			array(
				'key' => 'field_tab_contact',
				'label' => 'Contact',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contact_email',
				'label' => 'Email Address',
				'name' => 'contact_email',
				'type' => 'email',
			),
			array(
				'key' => 'field_contact_phone',
				'label' => 'Phone Number',
				'name' => 'contact_phone',
				'type' => 'text',
			),
		),
		'location' => array(
			// Fields are registered but not attached to any options page
			// They're used as fallbacks in block render files
		),
	) );
}

/**
 * 4. Seed Content on Activation
 */
function pns_cars_seed_content() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$is_already_seeded = get_option( 'pns_cars_seeded' );
	
	// Always check and update partner logos if empty, contain external URLs, or have less than 5 logos (even if already seeded)
	$current_partners = get_field( 'hero_partner_logos', 'option' );
	$needs_update = false;
	
	if ( empty( $current_partners ) || ! is_array( $current_partners ) || count( $current_partners ) === 0 ) {
		$needs_update = true;
	} elseif ( count( $current_partners ) < 5 ) {
		// If there are less than 5 logos, update to include all 5
		$needs_update = true;
	} else {
		// Check if any partner logo uses external URLs
		foreach ( $current_partners as $partner ) {
			if ( isset( $partner['image'] ) && $partner['image'] ) {
				// Check if it's an external URL (not from our theme directory)
				if ( strpos( $partner['image'], 'cloudfront' ) !== false || 
					 strpos( $partner['image'], 'ctfassets' ) !== false || 
					 strpos( $partner['image'], 'cdn.doordash' ) !== false ||
					 ( strpos( $partner['image'], get_template_directory_uri() ) === false && strpos( $partner['image'], 'http' ) === 0 ) ) {
					$needs_update = true;
					break;
				}
			}
		}
	}
	
	if ( $needs_update ) {
		$theme_img_url = get_template_directory_uri() . '/assets/img/';
		$partner_logos = array(
			array(
				'image' => $theme_img_url . 'uber-logo.svg',
				'alt' => 'Uber',
				'link' => 'https://www.uber.com',
			),
			array(
				'image' => $theme_img_url . 'lyft-logo.svg',
				'alt' => 'Lyft',
				'link' => 'https://www.lyft.com',
			),
			array(
				'image' => $theme_img_url . 'doordash-logo.svg',
				'alt' => 'DoorDash',
				'link' => 'https://www.doordash.com',
			),
			array(
				'image' => $theme_img_url . 'instacart-logo.svg',
				'alt' => 'Instacart',
				'link' => 'https://www.instacart.com',
			),
			array(
				'image' => $theme_img_url . 'shipt-logo.svg',
				'alt' => 'Shipt',
				'link' => 'https://www.shipt.com',
			),
		);
		update_field( 'hero_partner_logos', $partner_logos, 'option' );
	}
	
	if ( $is_already_seeded ) {
        // Force update the map URL if it's the old placeholder one, even if already seeded
        // This is a quick patch to ensure the user sees the map without needing to reset the whole theme
        $current_map = get_field('google_maps_embed_url', 'option');
        $new_map = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17969.587510091234!2d-84.29384894259061!3d33.90250098033048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f509c59cbfffff%3A0xfb53040bca7eb8ed!2s5872%20New%20Peachtree%20Rd%20Ste%20103%2C%20Doraville%2C%20GA%2030340!5e0!3m2!1sen!2sus!4v1764203567826!5m2!1sen!2sus';
        
        if($current_map !== $new_map) {
             update_field( 'google_maps_embed_url', $new_map, 'option' );
        }
		return;
	}

	// Define Seed Data
	$hero = array(
		'hero_headline' => 'Drive today. Earn this week.',
		'hero_subheadline' => 'Get behind the wheel of a reliable vehicle and start earning with Uber, Lyft, and DoorDash immediately. No credit checks, easy approval.',
		'hero_cta_primary' => 'View Available Vehicles',
		'hero_cta_secondary' => 'Start Your Booking',
		'hero_partners_text' => 'Perfect for:',
	);
	
	$theme_img_url = get_template_directory_uri() . '/assets/img/';
	$partner_logos = array(
		array(
			'image' => $theme_img_url . 'uber-logo.svg',
			'alt' => 'Uber',
			'link' => 'https://www.uber.com',
		),
		array(
			'image' => $theme_img_url . 'lyft-logo.svg',
			'alt' => 'Lyft',
			'link' => 'https://www.lyft.com',
		),
		array(
			'image' => $theme_img_url . 'doordash-logo.svg',
			'alt' => 'DoorDash',
			'link' => 'https://www.doordash.com',
		),
		array(
			'image' => $theme_img_url . 'instacart-logo.svg',
			'alt' => 'Instacart',
			'link' => 'https://www.instacart.com',
		),
		array(
			'image' => $theme_img_url . 'shipt-logo.svg',
			'alt' => 'Shipt',
			'link' => 'https://www.shipt.com',
		),
	);

	$steps = array(
		array(
			'title' => 'Pick Your Car',
			'description' => 'Browse our fleet of hybrid and gas-saver vehicles perfect for rideshare.',
			'icon' => '🚗',
		),
		array(
			'title' => 'Submit Request',
			'description' => 'Fill out a simple application. We approve drivers fast.',
			'icon' => '📝',
		),
		array(
			'title' => 'Drive & Earn',
			'description' => 'Pick up your keys and start making money on your favorite platforms.',
			'icon' => '💸',
		),
	);

	$services = array(
		array(
			'title' => 'Weekly Rentals',
			'description' => 'Flexible weekly terms designed for gig economy cash flow. No long-term lock-in.',
		),
		array(
			'title' => 'Unlimited Miles',
			'description' => 'Drive as much as you need within Georgia. No mileage caps for earners.',
		),
		array(
			'title' => 'Maintenance Included',
			'description' => 'We cover oil changes, tires, and routine maintenance so you keep earning.',
		),
	);

	$faqs = array(
		array(
			'question' => 'What documents do I need?',
			'answer'   => 'You need a valid driver\'s license, proof of address, and an active account with a rideshare or delivery platform.',
		),
		array(
			'question' => 'Is insurance included?',
			'answer'   => 'Yes, we provide the necessary commercial insurance required for rideshare driving.',
		),
		array(
			'question' => 'How do payments work?',
			'answer'   => 'Payments are made weekly via card. A refundable deposit is required at signing.',
		),
	);

	$location = array(
		'address_text' => "PNS Global Resources L.L.C\n5872 New Peachtree Rd Ste 103\nDoraville, GA 30340\n\nServing the Atlanta Metro Area",
		'map_link'     => 'https://goo.gl/maps/place/5872+New+Peachtree+Rd+Ste+103,+Doraville,+GA+30340',
		'embed_url'    => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17969.587510091234!2d-84.29384894259061!3d33.90250098033048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f509c59cbfffff%3A0xfb53040bca7eb8ed!2s5872%20New%20Peachtree%20Rd%20Ste%20103%2C%20Doraville%2C%20GA%2030340!5e0!3m2!1sen!2sus!4v1764203567826!5m2!1sen!2sus',
	);

	// Update Fields
	$option_id = 'option';

	// Hero
	update_field( 'hero_headline', $hero['hero_headline'], $option_id );
	update_field( 'hero_subheadline', $hero['hero_subheadline'], $option_id );
	update_field( 'hero_cta_primary', $hero['hero_cta_primary'], $option_id );
	update_field( 'hero_cta_secondary', $hero['hero_cta_secondary'], $option_id );
	update_field( 'hero_partners_text', $hero['hero_partners_text'], $option_id );
	update_field( 'hero_partner_logos', $partner_logos, $option_id );

	// Repeaters need special handling usually, but update_field handles arrays for repeaters well if structure matches.
	update_field( 'steps', $steps, $option_id );
	update_field( 'services_list', $services, $option_id );
	update_field( 'faqs', $faqs, $option_id );

	// Location
	update_field( 'address_text', $location['address_text'], $option_id );
	update_field( 'map_link', $location['map_link'], $option_id );
	update_field( 'google_maps_embed_url', $location['embed_url'], $option_id );

	// Contact
	update_field( 'contact_email', 'rentals@pnscars.com', $option_id );
	update_field( 'contact_phone', '(404) 555-0199', $option_id );

	// Pricing
	update_field( 'pricing_headline', 'Simple, Transparent Pricing', $option_id );
	update_field( 'pricing_intro_text', 'No hidden fees. One weekly price covers the car, insurance, and maintenance.', $option_id );
	$pricing_items = array(
		array( 'item' => '$250 Refundable Deposit' ),
		array( 'item' => 'Weekly automatic payments' ),
		array( 'item' => 'Minimum 2-week rental' ),
	);
	update_field( 'pricing_list_items', $pricing_items, $option_id );

	// Mark as seeded
	update_option( 'pns_cars_seeded', true );
}

/**
 * Create homepage with Gutenberg blocks on theme activation
 * Only creates if the page doesn't exist
 */
function pns_cars_create_homepage_with_blocks() {
	// Check if homepage already exists by slug
	$homepage = get_page_by_path( 'home' );
	
	// Also check if there's already a page set as front page
	$front_page_id = get_option( 'page_on_front' );
	if ( $front_page_id ) {
		$front_page = get_post( $front_page_id );
		if ( $front_page && $front_page->post_type === 'page' ) {
			// Homepage already exists and is set
			return;
		}
	}
	
	if ( $homepage ) {
		// Homepage exists, don't create
		return;
	}

	// Create block content
	$blocks = array();

	// Hero Block - get partner logos
	$partners_data = array();
	$theme_img_url = get_template_directory_uri() . '/assets/img/';
	
	if ( function_exists( 'have_rows' ) && have_rows( 'hero_partner_logos', 'option' ) ) {
		while ( have_rows( 'hero_partner_logos', 'option' ) ) {
			the_row();
			$image_url = get_sub_field( 'image' ) ?: '';
			
			// Replace external URLs with local ones
			if ( $image_url ) {
					if ( strpos( $image_url, 'cloudfront' ) !== false ) {
						$image_url = $theme_img_url . 'uber-logo.svg';
					} elseif ( strpos( $image_url, 'ctfassets' ) !== false ) {
						$image_url = $theme_img_url . 'lyft-logo.svg';
					} elseif ( strpos( $image_url, 'cdn.doordash' ) !== false ) {
						$image_url = $theme_img_url . 'doordash-logo.svg';
					}
					// Note: Instacart and Shipt don't need URL replacement as they're new additions
			}
			
			$partners_data[] = array(
				'image' => $image_url,
				'imageId' => null,
				'alt' => get_sub_field( 'alt' ) ?: '',
				'link' => get_sub_field( 'link' ) ?: '',
			);
		}
	}
	// Default partner logos if empty OR if less than 5 logos (to ensure all 5 are included)
	if ( empty( $partners_data ) || count( $partners_data ) < 5 ) {
		$partners_data = array(
			array(
				'image' => $theme_img_url . 'uber-logo.svg',
				'imageId' => null,
				'alt' => 'Uber',
				'link' => 'https://www.uber.com',
			),
			array(
				'image' => $theme_img_url . 'lyft-logo.svg',
				'imageId' => null,
				'alt' => 'Lyft',
				'link' => 'https://www.lyft.com',
			),
			array(
				'image' => $theme_img_url . 'doordash-logo.svg',
				'imageId' => null,
				'alt' => 'DoorDash',
				'link' => 'https://www.doordash.com',
			),
			array(
				'image' => $theme_img_url . 'instacart-logo.svg',
				'imageId' => null,
				'alt' => 'Instacart',
				'link' => 'https://www.instacart.com',
			),
			array(
				'image' => $theme_img_url . 'shipt-logo.svg',
				'imageId' => null,
				'alt' => 'Shipt',
				'link' => 'https://www.shipt.com',
			),
		);
	}
	$blocks[] = array(
		'blockName' => 'pns-cars/hero',
		'attrs' => array(
			'headline' => get_field( 'hero_headline', 'option' ) ?: 'Drive today. Earn this week.',
			'subheadline' => get_field( 'hero_subheadline', 'option' ) ?: 'Get behind the wheel of a reliable vehicle and start earning with Uber, Lyft, and DoorDash immediately. No credit checks, easy approval.',
			'ctaPrimary' => get_field( 'hero_cta_primary', 'option' ) ?: 'View Available Vehicles',
			'ctaPrimaryLink' => get_field( 'hero_cta_primary_link', 'option' ) ?: '#vehicles',
			'ctaSecondary' => get_field( 'hero_cta_secondary', 'option' ) ?: 'Start Your Booking',
			'ctaSecondaryLink' => get_field( 'hero_cta_secondary_link', 'option' ) ?: '#booking',
			'partnersText' => get_field( 'hero_partners_text', 'option' ) ?: 'Perfect for:',
			'partners' => $partners_data,
			'lifestyleImage' => get_field( 'hero_lifestyle_image', 'option' ) ?: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop',
			'earningsHeader' => get_field( 'hero_earnings_header', 'option' ) ?: 'Weekly Earnings',
			'earningsAmount' => get_field( 'hero_earnings_amount', 'option' ) ?: '1426.29',
			'earningsSubtext' => get_field( 'hero_earnings_subtext', 'option' ) ?: 'Oct 4 - Oct 10 • 33 Trips',
			'earningsOnline' => get_field( 'hero_earnings_online', 'option' ) ?: '20h 16m',
			'earningsTips' => get_field( 'hero_earnings_tips', 'option' ) ?: '+$187.24',
			'notification1Icon' => get_field( 'hero_notification1_icon', 'option' ) ?: '💰',
			'notification1Title' => get_field( 'hero_notification1_title', 'option' ) ?: 'Payout Processed',
			'notification1Sub' => get_field( 'hero_notification1_sub', 'option' ) ?: 'You received $999.41',
			'notification2Icon' => get_field( 'hero_notification2_icon', 'option' ) ?: '🚗',
			'notification2Title' => get_field( 'hero_notification2_title', 'option' ) ?: 'New Tip!',
			'notification2Sub' => get_field( 'hero_notification2_sub', 'option' ) ?: '+$15.00 from Sarah',
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// How It Works Block
	$steps_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'steps', 'option' ) ) {
		while ( have_rows( 'steps', 'option' ) ) {
			the_row();
			$steps_data[] = array(
				'title' => get_sub_field( 'title' ) ?: '',
				'description' => get_sub_field( 'description' ) ?: '',
				'icon' => get_sub_field( 'icon' ) ?: '',
			);
		}
	}
	$blocks[] = array(
		'blockName' => 'pns-cars/how-it-works',
		'attrs' => array(
			'heading' => get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works',
			'steps' => $steps_data,
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// Services Block
	$services_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'services_list', 'option' ) ) {
		while ( have_rows( 'services_list', 'option' ) ) {
			the_row();
			$services_data[] = array(
				'title' => get_sub_field( 'title' ) ?: '',
				'description' => get_sub_field( 'description' ) ?: '',
			);
		}
	}
	$blocks[] = array(
		'blockName' => 'pns-cars/services',
		'attrs' => array(
			'heading' => get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers',
			'services' => $services_data,
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// Vehicles Block
	$blocks[] = array(
		'blockName' => 'pns-cars/vehicles',
		'attrs' => array(
			'heading' => get_field( 'vehicles_heading', 'option' ) ?: 'Available Vehicles',
			'count' => get_field( 'vehicles_count', 'option' ) ?: -1,
			'perRow' => get_field( 'vehicles_per_row', 'option' ) ?: 3,
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// Pricing Block
	$pricing_list_items = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'pricing_list_items', 'option' ) ) {
		while ( have_rows( 'pricing_list_items', 'option' ) ) {
			the_row();
			$item = get_sub_field( 'item' );
			if ( $item ) {
				$pricing_list_items[] = $item;
			}
		}
	}
	if ( empty( $pricing_list_items ) ) {
		$pricing_list_items = array(
			'$250 Refundable Deposit',
			'Weekly automatic payments',
			'Minimum 2-week rental'
		);
	}
	$blocks[] = array(
		'blockName' => 'pns-cars/pricing',
		'attrs' => array(
			'headline' => get_field( 'pricing_headline', 'option' ) ?: 'Simple, Transparent Pricing',
			'introText' => get_field( 'pricing_intro_text', 'option' ) ?: 'No hidden fees. One weekly price covers the car, insurance, and maintenance.',
			'listItems' => $pricing_list_items,
			'buttonText' => get_field( 'pricing_button_text', 'option' ) ?: 'Choose Your Car',
			'buttonLink' => get_field( 'pricing_button_link', 'option' ) ?: '#vehicles',
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// FAQ Block
	$faqs_data = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'faqs', 'option' ) ) {
		while ( have_rows( 'faqs', 'option' ) ) {
			the_row();
			$faqs_data[] = array(
				'question' => get_sub_field( 'question' ) ?: '',
				'answer' => get_sub_field( 'answer' ) ?: '',
			);
		}
	}
	$blocks[] = array(
		'blockName' => 'pns-cars/faq',
		'attrs' => array(
			'heading' => get_field( 'faq_heading', 'option' ) ?: 'Frequently Asked Questions',
			'faqs' => $faqs_data,
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// Location Block
	$blocks[] = array(
		'blockName' => 'pns-cars/location',
		'attrs' => array(
			'heading' => get_field( 'location_heading', 'option' ) ?: 'Find Us',
			'addressText' => get_field( 'address_text', 'option' ) ?: "PNS Global Resources L.L.C<br>\n5872 New Peachtree Rd Ste 103<br>\nDoraville, GA 30340<br>\n<br>\nServing the Atlanta Metro Area",
			'servingText' => get_field( 'location_serving_text', 'option' ) ?: 'Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.',
			'mapLink' => get_field( 'map_link', 'option' ) ?: 'https://goo.gl/maps/place/5872+New+Peachtree+Rd+Ste+103,+Doraville,+GA+30340',
			'buttonText' => get_field( 'location_button_text', 'option' ) ?: 'Get Directions',
			'googleMapsEmbedUrl' => get_field( 'google_maps_embed_url', 'option' ) ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17969.587510091234!2d-84.29384894259061!3d33.90250098033048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f509c59cbfffff%3A0xfb53040bca7eb8ed!2s5872%20New%20Peachtree%20Rd%20Ste%20103%2C%20Doraville%2C%20GA%2030340!5e0!3m2!1sen!2sus!4v1764203567826!5m2!1sen!2sus',
		),
		'innerBlocks' => array(),
		'innerContent' => array(),
	);

	// Convert blocks to block markup
	$block_content = '';
	foreach ( $blocks as $block ) {
		$block_content .= serialize_block( $block );
	}

	// Create homepage with all blocks
	$post_data = array(
		'post_title' => 'Home',
		'post_name' => 'home',
		'post_content' => $block_content,
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_author' => 1,
	);
	
	$homepage_id = wp_insert_post( $post_data );
	
	if ( $homepage_id && ! is_wp_error( $homepage_id ) ) {
		// Set as homepage (uses default page.php template which renders blocks)
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $homepage_id );
	}
}

/**
 * Hook: Create homepage with blocks on theme activation
 * Only fires if the page doesn't exist
 * Seed content runs first (priority 10) to ensure ACF fields are updated
 * Homepage creation runs second (priority 20) to use the updated ACF data
 */
add_action( 'after_switch_theme', 'pns_cars_seed_content', 10 );
add_action( 'after_switch_theme', 'pns_cars_create_homepage_with_blocks', 20 );

/**
 * 5. Migrate ACF Footer Contact Values to Customizer (one-time)
 */
function pns_cars_migrate_footer_contact_to_customizer() {
	// Check if migration already ran
	if ( get_option( 'pns_cars_customizer_migrated' ) ) {
		return;
	}

	// Only migrate if ACF is available
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	// Get ACF values
	$acf_address = get_field( 'address_text', 'option' );
	$acf_phone = get_field( 'contact_phone', 'option' );
	$acf_email = get_field( 'contact_email', 'option' );

	// Set customizer values only if ACF values exist
	if ( ! empty( $acf_address ) ) {
		set_theme_mod( 'pns_cars_address_text', $acf_address );
	}
	if ( ! empty( $acf_phone ) ) {
		set_theme_mod( 'pns_cars_contact_phone', $acf_phone );
	}
	if ( ! empty( $acf_email ) ) {
		set_theme_mod( 'pns_cars_contact_email', $acf_email );
	}

	// Mark migration as complete
	update_option( 'pns_cars_customizer_migrated', true );
}
add_action( 'after_setup_theme', 'pns_cars_migrate_footer_contact_to_customizer' );

/**
 * 6. Customizer Settings for Footer Contact Information
 */
function pns_cars_customize_register( $wp_customize ) {
	// Add PNS Cars section
	$wp_customize->add_section( 'pns_cars_footer_contact', array(
		'title'       => __( 'Footer Contact Info', 'pns-cars' ),
		'description' => __( 'Update contact information displayed in the footer', 'pns-cars' ),
		'priority'    => 130,
	) );

	// Address Text
	$wp_customize->add_setting( 'pns_cars_address_text', array(
		'default'           => "PNS Global Resources L.L.C\n5872 New Peachtree Rd Ste 103\nDoraville, GA 30340\n\nServing the Atlanta Metro Area",
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'pns_cars_address_text', array(
		'label'       => __( 'Address', 'pns-cars' ),
		'description' => __( 'Enter the company address (line breaks will be preserved)', 'pns-cars' ),
		'section'     => 'pns_cars_footer_contact',
		'type'        => 'textarea',
		'priority'    => 10,
	) );

	// Phone Number
	$wp_customize->add_setting( 'pns_cars_contact_phone', array(
		'default'           => '(404) 555-0199',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'pns_cars_contact_phone', array(
		'label'       => __( 'Phone Number', 'pns-cars' ),
		'description' => __( 'Enter the contact phone number', 'pns-cars' ),
		'section'     => 'pns_cars_footer_contact',
		'type'        => 'text',
		'priority'    => 20,
	) );

	// Email Address
	$wp_customize->add_setting( 'pns_cars_contact_email', array(
		'default'           => 'rentals@pnscars.com',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'pns_cars_contact_email', array(
		'label'       => __( 'Email Address', 'pns-cars' ),
		'description' => __( 'Enter the contact email address', 'pns-cars' ),
		'section'     => 'pns_cars_footer_contact',
		'type'        => 'email',
		'priority'    => 30,
	) );
}
add_action( 'customize_register', 'pns_cars_customize_register' );
