<?php
/**
 * Vehicles Block Render
 */

// Get values from block attributes, fallback to ACF options
$heading = !empty($attributes['heading']) ? $attributes['heading'] : (get_field('vehicles_heading', 'option') ?: 'Available Vehicles');
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

