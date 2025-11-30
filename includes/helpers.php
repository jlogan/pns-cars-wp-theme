<?php
/**
 * Helper Functions for PNS Cars Theme
 * Common utilities and reusable functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get block attribute with ACF fallback
 * 
 * @param array  $attributes Block attributes
 * @param string $key        Attribute key (camelCase)
 * @param string $acf_field  ACF field name (snake_case)
 * @param mixed  $default    Default value if both attribute and ACF are empty
 * @return mixed
 */
function pns_cars_get_block_attr( $attributes, $key, $acf_field = null, $default = '' ) {
	if ( ! is_array( $attributes ) ) {
		$attributes = array();
	}
	
	// Check if attribute exists and is not null
	if ( isset( $attributes[ $key ] ) && $attributes[ $key ] !== null ) {
		return $attributes[ $key ];
	}
	
	// Fallback to ACF if field name provided
	if ( $acf_field && function_exists( 'get_field' ) ) {
		$acf_value = get_field( $acf_field, 'option' );
		if ( $acf_value !== false && $acf_value !== null && $acf_value !== '' ) {
			return $acf_value;
		}
	}
	
	return $default;
}

/**
 * Get ACF repeater field data as array
 * 
 * @param string $field_name ACF field name
 * @param array  $map_fields Array mapping: ['sub_field_key' => 'output_key']
 * @return array
 */
function pns_cars_get_acf_repeater( $field_name, $map_fields = array() ) {
	if ( ! function_exists( 'have_rows' ) || ! have_rows( $field_name, 'option' ) ) {
		return array();
	}
	
	$items = array();
	while ( have_rows( $field_name, 'option' ) ) {
		the_row();
		$item = array();
		
		if ( empty( $map_fields ) ) {
			// Return all sub fields
			$fields = get_row();
			$items[] = $fields ? $fields : array();
		} else {
			// Map fields according to provided mapping
			foreach ( $map_fields as $sub_field => $output_key ) {
				$item[ $output_key ] = get_sub_field( $sub_field ) ?: '';
			}
			if ( ! empty( $item ) ) {
				$items[] = $item;
			}
		}
	}
	
	return $items;
}

/**
 * Get default partner logos array
 * 
 * @return array
 */
function pns_cars_get_default_partner_logos() {
	$theme_img_url = get_template_directory_uri() . '/assets/img/';
	return array(
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

/**
 * Get partner logos from ACF or use defaults
 * 
 * @return array
 */
function pns_cars_get_partner_logos() {
	if ( function_exists( 'have_rows' ) && have_rows( 'hero_partner_logos', 'option' ) ) {
		$partners = array();
		while ( have_rows( 'hero_partner_logos', 'option' ) ) {
			the_row();
			$partners[] = array(
				'image' => get_sub_field( 'image' ) ?: '',
				'imageId' => null,
				'alt' => get_sub_field( 'alt' ) ?: '',
				'link' => get_sub_field( 'link' ) ?: '',
			);
		}
		
		// Only return ACF partners if they have images
		if ( ! empty( $partners ) ) {
			$has_images = false;
			foreach ( $partners as $partner ) {
				if ( ! empty( $partner['image'] ) ) {
					$has_images = true;
					break;
				}
			}
			if ( $has_images ) {
				return $partners;
			}
		}
	}
	
	return pns_cars_get_default_partner_logos();
}

/**
 * Get image URL from attachment ID or URL string
 * 
 * @param int|string|null $image_id  Attachment ID
 * @param string|null     $image_url Image URL
 * @return string
 */
function pns_cars_get_image_url( $image_id = null, $image_url = null ) {
	if ( $image_id && is_numeric( $image_id ) ) {
		$url = wp_get_attachment_image_url( $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	
	if ( $image_url && is_string( $image_url ) ) {
		return $image_url;
	}
	
	return '';
}

/**
 * Get ACF data for block editor localization
 * Consolidates all ACF data fetching into one function
 * 
 * @return array
 */
function pns_cars_get_acf_data_for_editor() {
	$data = array();
	
	// Hero data
	$data['hero'] = array(
		'headline' => get_field( 'hero_headline', 'option' ) ?: 'Drive today. Earn this week.',
		'subheadline' => get_field( 'hero_subheadline', 'option' ) ?: 'Get behind the wheel of a reliable vehicle and start earning with Uber, Lyft, and DoorDash immediately. No credit checks, easy approval.',
		'ctaPrimary' => get_field( 'hero_cta_primary', 'option' ) ?: 'View Available Vehicles',
		'ctaPrimaryLink' => get_field( 'hero_cta_primary_link', 'option' ) ?: '#vehicles',
		'ctaSecondary' => get_field( 'hero_cta_secondary', 'option' ) ?: 'Start Your Booking',
		'ctaSecondaryLink' => get_field( 'hero_cta_secondary_link', 'option' ) ?: '#booking',
		'partnersText' => get_field( 'hero_partners_text', 'option' ) ?: 'Perfect for:',
		'partners' => pns_cars_get_partner_logos(),
		'lifestyleImage' => get_field( 'hero_lifestyle_image', 'option' ) ?: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop',
		'lifestyleImageId' => null,
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
	$data['howItWorks'] = array(
		'heading' => get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works',
		'steps' => pns_cars_get_acf_repeater( 'steps', array(
			'title' => 'title',
			'description' => 'description',
			'icon' => 'icon',
		) ),
	);
	
	// Services data
	$data['services'] = array(
		'heading' => get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers',
		'services' => pns_cars_get_acf_repeater( 'services_list', array(
			'title' => 'title',
			'description' => 'description',
		) ),
	);
	
	// Vehicles data
	$data['vehicles'] = array(
		'heading' => get_field( 'vehicles_heading', 'option' ) ?: 'Available Vehicles',
		'count' => get_field( 'vehicles_count', 'option' ) !== false ? get_field( 'vehicles_count', 'option' ) : -1,
		'perRow' => get_field( 'vehicles_per_row', 'option' ) ?: 3,
	);
	
	// Pricing data
	$pricing_items = array();
	if ( function_exists( 'have_rows' ) && have_rows( 'pricing_list_items', 'option' ) ) {
		while ( have_rows( 'pricing_list_items', 'option' ) ) {
			the_row();
			$item = get_sub_field( 'item' );
			if ( $item ) {
				$pricing_items[] = array( 'item' => $item );
			}
		}
	}
	if ( empty( $pricing_items ) ) {
		$pricing_items = array(
			array( 'item' => '$250 Refundable Deposit' ),
			array( 'item' => 'Weekly automatic payments' ),
			array( 'item' => 'Minimum 2-week rental' ),
		);
	}
	$data['pricing'] = array(
		'headline' => get_field( 'pricing_headline', 'option' ) ?: 'Simple, Transparent Pricing',
		'introText' => get_field( 'pricing_intro_text', 'option' ) ?: 'No hidden fees. One weekly price covers the car, insurance, and maintenance.',
		'listItems' => $pricing_items,
		'buttonText' => get_field( 'pricing_button_text', 'option' ) ?: 'Choose Your Car',
		'buttonLink' => get_field( 'pricing_button_link', 'option' ) ?: '#vehicles',
	);
	
	// FAQ data
	$data['faq'] = array(
		'heading' => get_field( 'faq_heading', 'option' ) ?: 'Frequently Asked Questions',
		'faqs' => pns_cars_get_acf_repeater( 'faqs', array(
			'question' => 'question',
			'answer' => 'answer',
		) ),
	);
	
	// Location data
	$data['location'] = array(
		'heading' => get_field( 'location_heading', 'option' ) ?: 'Find Us',
		'addressText' => get_field( 'address_text', 'option' ) ?: "PNS Global Resources L.L.C<br>\n5872 New Peachtree Rd Ste 103<br>\nDoraville, GA 30340<br>\n<br>\nServing the Atlanta Metro Area",
		'servingText' => get_field( 'location_serving_text', 'option' ) ?: 'Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.',
		'mapLink' => get_field( 'map_link', 'option' ) ?: 'https://goo.gl/maps/place/5872+New+Peachtree+Rd+Ste+103,+Doraville,+GA+30340',
		'buttonText' => get_field( 'location_button_text', 'option' ) ?: 'Get Directions',
		'googleMapsEmbedUrl' => get_field( 'google_maps_embed_url', 'option' ) ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17969.587510091234!2d-84.29384894259061!3d33.90250098033048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f509c59cbfffff%3A0xfb53040bca7eb8ed!2s5872%20New%20Peachtree%20Rd%20Ste%20103%2C%20Doraville%2C%20GA%2030340!5e0!3m2!1sen!2sus!4v1764203567826!5m2!1sen!2sus',
	);
	
	return $data;
}

/**
 * Check if partner logos need update
 * 
 * @return bool
 */
function pns_cars_partner_logos_need_update() {
	$current_partners = get_field( 'hero_partner_logos', 'option' );
	
	if ( empty( $current_partners ) || ! is_array( $current_partners ) || count( $current_partners ) === 0 ) {
		return true;
	}
	
	if ( count( $current_partners ) < 5 ) {
		return true;
	}
	
	// Check if any partner logo uses external URLs
	$theme_dir = get_template_directory_uri();
	foreach ( $current_partners as $partner ) {
		if ( isset( $partner['image'] ) && $partner['image'] ) {
			if ( strpos( $partner['image'], 'cloudfront' ) !== false ||
				 strpos( $partner['image'], 'ctfassets' ) !== false ||
				 strpos( $partner['image'], 'cdn.doordash' ) !== false ||
				 ( strpos( $partner['image'], $theme_dir ) === false && strpos( $partner['image'], 'http' ) === 0 ) ) {
				return true;
			}
		}
	}
	
	return false;
}

