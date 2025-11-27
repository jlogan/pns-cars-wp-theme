<?php
/**
 * Location Block Render
 */

// Get values from block attributes, fallback to ACF options
$heading = !empty($attributes['heading']) ? $attributes['heading'] : (get_field('location_heading', 'option') ?: 'Find Us');
$address_text = !empty($attributes['addressText']) ? $attributes['addressText'] : (get_field('address_text', 'option') ?: '');
$map_link = !empty($attributes['mapLink']) ? $attributes['mapLink'] : (get_field('map_link', 'option') ?: '');
$embed_url = !empty($attributes['googleMapsEmbedUrl']) ? $attributes['googleMapsEmbedUrl'] : (get_field('google_maps_embed_url', 'option') ?: '');
?>

<section class="section-padding" id="location">
	<div class="container">
		<div class="location-grid">
			<div class="location-info fade-in-up">
				<h2><?php echo esc_html( $heading ); ?></h2>
				<p class="location-address">
					<?php echo nl2br( esc_html( $address_text ) ); ?>
				</p>
				<div class="mb-2 text-muted">
					Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.
				</div>
				
				<?php if ( $map_link ): ?>
					<a href="<?php echo esc_url( $map_link ); ?>" target="_blank" class="btn btn-secondary">Get Directions</a>
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

