<?php
/**
 * FAQ Block Render
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
	: ( get_field( 'faq_heading', 'option' ) ?: 'Frequently Asked Questions' );
	
$faqs = ( isset( $attributes['faqs'] ) && is_array( $attributes['faqs'] ) ) 
	? $attributes['faqs'] 
	: [];

// If FAQs are empty, get from ACF
if (empty($faqs) && function_exists('have_rows')) {
	$faqs = array();
	if (have_rows('faqs', 'option')) {
		while (have_rows('faqs', 'option')) {
			the_row();
			$faqs[] = array(
				'question' => get_sub_field('question') ?: '',
				'answer' => get_sub_field('answer') ?: '',
			);
		}
	}
}
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

