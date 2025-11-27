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
 * 2. Enqueue Assets
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
 * 3. ACF Options Page & Fields
 */
if ( function_exists( 'acf_add_options_page' ) ) {

	// Add Options Page
	acf_add_options_page( array(
		'page_title' 	=> 'PNS Cars Settings',
		'menu_title'	=> 'PNS Cars',
		'menu_slug' 	=> 'pns-cars-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'      => 'dashicons-car',
	) );

	// Register Fields Programmatically
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
			
			// Tab: How It Works
			array(
				'key' => 'field_tab_how',
				'label' => 'How It Works',
				'type' => 'tab',
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
				'key' => 'field_vehicles_list',
				'label' => 'Vehicles List',
				'name' => 'vehicles_list',
				'type' => 'repeater',
				'sub_fields' => array(
					array(
						'key' => 'field_vehicle_name',
						'label' => 'Year Make Model',
						'name' => 'name',
						'type' => 'text',
					),
					array(
						'key' => 'field_vehicle_rate',
						'label' => 'Weekly Rate',
						'name' => 'rate',
						'type' => 'text',
					),
					array(
						'key' => 'field_vehicle_tag',
						'label' => 'Tag',
						'name' => 'tag',
						'type' => 'text',
					),
					array(
						'key' => 'field_vehicle_image',
						'label' => 'Image URL', // Using text for simplicity in seeding, ideally Image Object
						'name' => 'image_url',
						'type' => 'text',
						'instructions' => 'Enter external image URL for demo purposes.',
					),
				),
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
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'pns-cars-settings',
				),
			),
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

	// Check if already seeded
	if ( get_option( 'pns_cars_seeded' ) ) {
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

	$vehicles = array(
		array(
			'name' => '2020 Toyota Prius',
			'rate' => '$280 / week',
			'tag'  => 'Best for Uber',
			'image_url' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&q=80&w=800',
		),
		array(
			'name' => '2021 Hyundai Elantra',
			'rate' => '$260 / week',
			'tag'  => 'Great Gas Mileage',
			'image_url' => 'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&q=80&w=800',
		),
		array(
			'name' => '2019 Toyota Camry',
			'rate' => '$290 / week',
			'tag'  => 'Comfort Ride',
			'image_url' => 'https://images.unsplash.com/photo-1621007947382-bb3c3968e3bb?auto=format&fit=crop&q=80&w=800',
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

	// Repeaters need special handling usually, but update_field handles arrays for repeaters well if structure matches.
	update_field( 'steps', $steps, $option_id );
	update_field( 'services_list', $services, $option_id );
	update_field( 'vehicles_list', $vehicles, $option_id );
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
	update_field( 'pricing_content', '<p>No hidden fees. One weekly price covers the car, insurance, and maintenance.</p><ul><li>$250 Refundable Deposit</li><li>Weekly automatic payments</li><li>Minimum 2-week rental</li></ul>', $option_id );

	// Mark as seeded
	update_option( 'pns_cars_seeded', true );
}
add_action( 'after_switch_theme', 'pns_cars_seed_content' );
