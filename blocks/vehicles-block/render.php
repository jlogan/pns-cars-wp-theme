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
?>

<section class="section-padding" id="vehicles">
	<div class="container">
		<div class="d-flex justify-between align-center mb-2">
			<h2 class="section-title fade-in-up"><?php echo esc_html( $heading ); ?></h2>
		</div>
		
		<div class="fade-in-up">
			<?php echo do_shortcode('[rental_car_inventory]'); ?>
		</div>
	</div>
</section>

