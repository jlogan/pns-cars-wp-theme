<?php
/**
 * How It Works Block Render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure $attributes is an array
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get heading with ACF fallback
$heading = pns_cars_get_block_attr( $attributes, 'heading', 'how_it_works_heading', 'How It Works' );

// Get steps from attributes or ACF
$steps = ( isset( $attributes['steps'] ) && is_array( $attributes['steps'] ) && ! empty( $attributes['steps'] ) )
	? $attributes['steps']
	: pns_cars_get_acf_repeater( 'steps', array(
		'title' => 'title',
		'description' => 'description',
		'icon' => 'icon',
	) );
?>

<?php if ( ! empty( $steps ) ): ?>
<section class="section-padding" id="how-it-works">
	<div class="container">
		<h2 class="section-title text-center fade-in-up"><?php echo esc_html( $heading ); ?></h2>
		<div class="steps-grid">
			<?php 
			$i = 1;
			foreach ( $steps as $step ): 
				$icon = $step['icon'] ?? '';
				$title = $step['title'] ?? '';
				$desc = $step['description'] ?? '';
			?>
				<div class="step-card fade-in-up" style="transition-delay: <?php echo $i * 100; ?>ms">
					<div class="step-number"><?php echo $i; ?></div>
					<div class="step-icon"><?php echo esc_html( $icon ); ?></div>
					<h3><?php echo esc_html( $title ); ?></h3>
					<p class="text-muted"><?php echo esc_html( $desc ); ?></p>
				</div>
			<?php 
			$i++;
			endforeach; 
			?>
		</div>
	</div>
</section>
<?php endif; ?>

