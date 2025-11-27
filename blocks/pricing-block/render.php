<?php
/**
 * Pricing Block Render
 */

// Get values from block attributes, fallback to ACF options
$headline = !empty($attributes['headline']) ? $attributes['headline'] : (get_field('pricing_headline', 'option') ?: '');
$content = !empty($attributes['content']) ? $attributes['content'] : (get_field('pricing_content', 'option') ?: '');
?>

<section class="section-padding pricing-section" id="pricing">
	<div class="container">
		<div class="pricing-overview fade-in-up">
			<h2><?php echo esc_html( $headline ); ?></h2>
			<div class="pricing-body">
				<?php echo wp_kses_post( $content ); ?>
			</div>
			<div style="margin-top: 3rem;">
				<a href="#vehicles" class="btn btn-primary btn-lg">Choose Your Car</a>
			</div>
		</div>
	</div>
</section>

