<?php
/**
 * Pricing Block Render
 */

// Ensure $attributes is an array (WordPress should pass this, but be safe)
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get values from block attributes, fallback to ACF options
// Check if attribute key exists and has a value (even if empty string)
// Only fallback to ACF if the attribute key doesn't exist in the saved block
$headline = ( isset( $attributes['headline'] ) && $attributes['headline'] !== null ) 
	? $attributes['headline'] 
	: ( get_field( 'pricing_headline', 'option' ) ?: '' );
	
$intro_text = ( isset( $attributes['introText'] ) && $attributes['introText'] !== null ) 
	? $attributes['introText'] 
	: ( get_field( 'pricing_intro_text', 'option' ) ?: 'No hidden fees. One weekly price covers the car, insurance, and maintenance.' );

$list_items = array();

// Get list items from block attributes
if ( isset( $attributes['listItems'] ) && is_array( $attributes['listItems'] ) ) {
	// Handle both string arrays and object arrays
	foreach ( $attributes['listItems'] as $item ) {
		if ( is_string( $item ) ) {
			$list_items[] = $item;
		} elseif ( is_array( $item ) && isset( $item['item'] ) ) {
			$list_items[] = $item['item'];
		}
	}
}

// If list items are empty, try to get from ACF
if ( empty( $list_items ) && function_exists( 'have_rows' ) && have_rows( 'pricing_list_items', 'option' ) ) {
	while ( have_rows( 'pricing_list_items', 'option' ) ) {
		the_row();
		$item = get_sub_field( 'item' );
		if ( $item ) {
			$list_items[] = $item;
		}
	}
}

// Fallback to default items if still empty
if ( empty( $list_items ) ) {
	$list_items = array(
		'$250 Refundable Deposit',
		'Weekly automatic payments',
		'Minimum 2-week rental'
	);
}
	
$button_text = ( isset( $attributes['buttonText'] ) && $attributes['buttonText'] !== null ) 
	? $attributes['buttonText'] 
	: ( get_field( 'pricing_button_text', 'option' ) ?: 'Choose Your Car' );
	
$button_link = ( isset( $attributes['buttonLink'] ) && $attributes['buttonLink'] !== null ) 
	? $attributes['buttonLink'] 
	: ( get_field( 'pricing_button_link', 'option' ) ?: '#vehicles' );
?>

<section class="section-padding pricing-section" id="pricing">
	<div class="container">
		<div class="pricing-overview fade-in-up">
			<h2><?php echo esc_html( $headline ); ?></h2>
			<div class="pricing-body">
				<?php if ( $intro_text ): ?>
					<p><?php echo esc_html( $intro_text ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $list_items ) ): ?>
					<ul>
						<?php foreach ( $list_items as $item ): ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php if ( $button_text && $button_link ): ?>
			<div style="margin-top: 3rem;">
				<a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-primary btn-lg"><?php echo esc_html( $button_text ); ?></a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

