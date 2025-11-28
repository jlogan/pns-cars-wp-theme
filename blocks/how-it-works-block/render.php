<?php
/**
 * How It Works Block Render
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
	: ( get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works' );
	
$steps = ( isset( $attributes['steps'] ) && is_array( $attributes['steps'] ) ) 
	? $attributes['steps'] 
	: [];

// If steps are empty, get from ACF
if (empty($steps) && function_exists('have_rows')) {
	$steps = array();
	if (have_rows('steps', 'option')) {
		while (have_rows('steps', 'option')) {
			the_row();
			$steps[] = array(
				'title' => get_sub_field('title') ?: '',
				'description' => get_sub_field('description') ?: '',
				'icon' => get_sub_field('icon') ?: '',
			);
		}
	}
}
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

