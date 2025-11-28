<?php
/**
 * Location Block Render
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
	: ( get_field( 'location_heading', 'option' ) ?: 'Find Us' );
	
$address_text = ( isset( $attributes['addressText'] ) && $attributes['addressText'] !== null ) 
	? $attributes['addressText'] 
	: ( get_field( 'address_text', 'option' ) ?: '' );

// Fix newlines that may have been stored incorrectly (rn -> \n -> <br>)
if ( $address_text ) {
	// Replace literal "rn" with actual newlines
	$address_text = str_replace( 'rn', "\n", $address_text );
	// Replace \r\n and \n with <br> for HTML rendering
	$address_text = str_replace( array( "\r\n", "\n" ), '<br>', $address_text );
}
	
$map_link = ( isset( $attributes['mapLink'] ) && $attributes['mapLink'] !== null ) 
	? $attributes['mapLink'] 
	: ( get_field( 'map_link', 'option' ) ?: '' );
	
$embed_url = ( isset( $attributes['googleMapsEmbedUrl'] ) && $attributes['googleMapsEmbedUrl'] !== null ) 
	? $attributes['googleMapsEmbedUrl'] 
	: ( get_field( 'google_maps_embed_url', 'option' ) ?: '' );
	
$serving_text = ( isset( $attributes['servingText'] ) && $attributes['servingText'] !== null ) 
	? $attributes['servingText'] 
	: ( get_field( 'location_serving_text', 'option' ) ?: 'Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.' );

// Fix newlines for serving text as well
if ( $serving_text ) {
	// Replace literal "rn" with actual newlines
	$serving_text = str_replace( 'rn', "\n", $serving_text );
	// Replace \r\n and \n with <br> for HTML rendering
	$serving_text = str_replace( array( "\r\n", "\n" ), '<br>', $serving_text );
}
	
$button_text = ( isset( $attributes['buttonText'] ) && $attributes['buttonText'] !== null ) 
	? $attributes['buttonText'] 
	: ( get_field( 'location_button_text', 'option' ) ?: 'Get Directions' );
?>

<section class="section-padding" id="location">
	<div class="container">
		<div class="location-grid">
			<div class="location-info fade-in-up">
				<h2><?php echo esc_html( $heading ); ?></h2>
				<?php if ( $address_text ): ?>
				<p class="location-address">
					<?php echo wp_kses_post( $address_text ); ?>
				</p>
				<?php endif; ?>
				<?php if ( $serving_text ): ?>
				<div class="mb-2 text-muted">
					<?php echo wp_kses_post( $serving_text ); ?>
				</div>
				<?php endif; ?>
				
				<?php if ( $map_link && $button_text ): ?>
					<a href="<?php echo esc_url( $map_link ); ?>" target="_blank" class="btn btn-secondary"><?php echo esc_html( $button_text ); ?></a>
				<?php endif; ?>
			</div>
			
			<div class="location-map fade-in-up" style="transition-delay: 200ms;">
				<?php if ( $embed_url ): ?>
					<iframe 
						src="<?php echo esc_url( $embed_url ); ?>" 
						allowfullscreen="" 
						loading="lazy" 
						referrerpolicy="no-referrer-when-downgrade">
					</iframe>
				<?php else: ?>
					<div style="display:flex;align-items:center;justify-content:center;height:100%;background:#1e293b;color:#64748b;">Map Unavailable</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

