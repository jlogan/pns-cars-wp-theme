<?php
/**
 * Services Block Render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure $attributes is an array
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get heading with ACF fallback
$heading = pns_cars_get_block_attr( $attributes, 'heading', 'services_heading', 'Benefits for Drivers' );

// Get services from attributes or ACF
$services = ( isset( $attributes['services'] ) && is_array( $attributes['services'] ) && ! empty( $attributes['services'] ) )
	? $attributes['services']
	: pns_cars_get_acf_repeater( 'services_list', array(
		'title' => 'title',
		'description' => 'description',
	) );
?>

<?php if ( ! empty( $services ) ): ?>
<section class="section-padding" id="services">
	<div class="container">
		<h2 class="section-title fade-in-up"><?php echo esc_html( $heading ); ?></h2>
		<div class="services-grid">
			<?php foreach ( $services as $service ): ?>
				<div class="service-card fade-in-up">
					<h3><?php echo esc_html( $service['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $service['description'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

