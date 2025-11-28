<?php
/**
 * Services Block Render
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
	: ( get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers' );
	
$services = ( isset( $attributes['services'] ) && is_array( $attributes['services'] ) ) 
	? $attributes['services'] 
	: [];

// If services are empty, get from ACF
if (empty($services) && function_exists('have_rows')) {
	$services = array();
	if (have_rows('services_list', 'option')) {
		while (have_rows('services_list', 'option')) {
			the_row();
			$services[] = array(
				'title' => get_sub_field('title') ?: '',
				'description' => get_sub_field('description') ?: '',
			);
		}
	}
}
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

