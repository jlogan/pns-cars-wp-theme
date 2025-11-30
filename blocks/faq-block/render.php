<?php
/**
 * FAQ Block Render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure $attributes is an array
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get heading with ACF fallback
$heading = pns_cars_get_block_attr( $attributes, 'heading', 'faq_heading', 'Frequently Asked Questions' );

// Get FAQs from attributes or ACF
$faqs = ( isset( $attributes['faqs'] ) && is_array( $attributes['faqs'] ) && ! empty( $attributes['faqs'] ) )
	? $attributes['faqs']
	: pns_cars_get_acf_repeater( 'faqs', array(
		'question' => 'question',
		'answer' => 'answer',
	) );
?>

<?php if ( ! empty( $faqs ) ): ?>
<section class="section-padding" id="faq">
	<div class="container faq-container">
		<h2 class="section-title text-center mb-2 fade-in-up"><?php echo esc_html( $heading ); ?></h2>
		
		<?php foreach ( $faqs as $faq ): ?>
			<div class="faq-item fade-in-up">
				<div class="faq-question">
					<?php echo esc_html( $faq['question'] ?? '' ); ?>
					<span class="faq-toggle">+</span>
				</div>
				<div class="faq-answer">
					<p><?php echo esc_html( $faq['answer'] ?? '' ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

