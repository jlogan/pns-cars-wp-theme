<?php
/**
 * Vehicles Block Render
 */

// Ensure $attributes is an array (WordPress should pass this, but be safe)
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get values from block attributes, fallback to ACF options
// Check if attribute key exists and has a value (even if empty string)
// Only fallback to ACF if the attribute key doesn't exist in the saved block
$heading = ( isset( $attributes['heading'] ) && $attributes['heading'] !== null ) 
	? $attributes['heading'] 
	: ( get_field( 'vehicles_heading', 'option' ) ?: 'Available Vehicles' );

$count = ( isset( $attributes['count'] ) && $attributes['count'] !== null ) 
	? $attributes['count'] 
	: ( get_field( 'vehicles_count', 'option' ) !== false ? get_field( 'vehicles_count', 'option' ) : -1 );

$per_row = ( isset( $attributes['perRow'] ) && $attributes['perRow'] !== null ) 
	? $attributes['perRow'] 
	: ( get_field( 'vehicles_per_row', 'option' ) ?: 3 );

// Build shortcode with attributes
$shortcode = '[rental_car_inventory';
if ( $count !== null && $count !== false ) {
	$shortcode .= ' count="' . esc_attr( intval( $count ) ) . '"';
}
if ( $per_row !== null && $per_row !== false ) {
	$shortcode .= ' per_row="' . esc_attr( intval( $per_row ) ) . '"';
}
$shortcode .= ']';
?>

<section class="section-padding" id="vehicles">
	<div class="container">
		<div class="d-flex justify-between align-center mb-2">
			<h2 class="section-title fade-in-up"><?php echo esc_html( $heading ); ?></h2>
		</div>
		
		<div class="fade-in-up">
			<?php echo do_shortcode( $shortcode ); ?>
		</div>
	</div>
</section>

