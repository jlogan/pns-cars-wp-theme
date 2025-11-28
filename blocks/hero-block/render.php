<?php
/**
 * Hero Block Render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure $attributes is an array (WordPress should pass this, but be safe)
if ( ! is_array( $attributes ) ) {
	$attributes = array();
}

// Get values from block attributes, fallback to ACF options
// Check if attribute key exists and has a value (even if empty string)
// Only fallback to ACF if the attribute key doesn't exist in the saved block
$headline = ( isset( $attributes['headline'] ) && $attributes['headline'] !== null ) 
	? $attributes['headline'] 
	: ( get_field( 'hero_headline', 'option' ) ?: 'Drive today. Earn this week.' );
	
$subhead = ( isset( $attributes['subheadline'] ) && $attributes['subheadline'] !== null ) 
	? $attributes['subheadline'] 
	: ( get_field( 'hero_subheadline', 'option' ) ?: 'Get behind the wheel of a reliable vehicle and start earning with Uber, Lyft, and DoorDash immediately. No credit checks, easy approval.' );
	
$cta1 = ( isset( $attributes['ctaPrimary'] ) && $attributes['ctaPrimary'] !== null ) 
	? $attributes['ctaPrimary'] 
	: ( get_field( 'hero_cta_primary', 'option' ) ?: 'View Available Vehicles' );
	
$cta1_link = ( isset( $attributes['ctaPrimaryLink'] ) && $attributes['ctaPrimaryLink'] !== null ) 
	? $attributes['ctaPrimaryLink'] 
	: ( get_field( 'hero_cta_primary_link', 'option' ) ?: '#vehicles' );
	
$cta2 = ( isset( $attributes['ctaSecondary'] ) && $attributes['ctaSecondary'] !== null ) 
	? $attributes['ctaSecondary'] 
	: ( get_field( 'hero_cta_secondary', 'option' ) ?: 'Start Your Booking' );
	
$cta2_link = ( isset( $attributes['ctaSecondaryLink'] ) && $attributes['ctaSecondaryLink'] !== null ) 
	? $attributes['ctaSecondaryLink'] 
	: ( get_field( 'hero_cta_secondary_link', 'option' ) ?: '#booking' );
	
$partners_text = ( isset( $attributes['partnersText'] ) && $attributes['partnersText'] !== null ) 
	? $attributes['partnersText'] 
	: ( get_field( 'hero_partners_text', 'option' ) ?: 'Perfect for:' );
	
// Get lifestyle image - check for image ID first, then URL
$lifestyle_image = '';
if ( isset( $attributes['lifestyleImageId'] ) && $attributes['lifestyleImageId'] ) {
	$image_url = wp_get_attachment_image_url( $attributes['lifestyleImageId'], 'full' );
	if ( $image_url ) {
		$lifestyle_image = $image_url;
	}
}
if ( ! $lifestyle_image ) {
	$lifestyle_image = ( isset( $attributes['lifestyleImage'] ) && $attributes['lifestyleImage'] !== null ) 
		? $attributes['lifestyleImage'] 
		: ( get_field( 'hero_lifestyle_image', 'option' ) ?: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop' );
}
	
$earnings_header = ( isset( $attributes['earningsHeader'] ) && $attributes['earningsHeader'] !== null ) 
	? $attributes['earningsHeader'] 
	: ( get_field( 'hero_earnings_header', 'option' ) ?: 'Weekly Earnings' );
	
$earnings_amount = ( isset( $attributes['earningsAmount'] ) && $attributes['earningsAmount'] !== null ) 
	? $attributes['earningsAmount'] 
	: ( get_field( 'hero_earnings_amount', 'option' ) ?: '1426.29' );
	
$earnings_subtext = ( isset( $attributes['earningsSubtext'] ) && $attributes['earningsSubtext'] !== null ) 
	? $attributes['earningsSubtext'] 
	: ( get_field( 'hero_earnings_subtext', 'option' ) ?: 'Oct 4 - Oct 10 • 33 Trips' );
	
$earnings_online = ( isset( $attributes['earningsOnline'] ) && $attributes['earningsOnline'] !== null ) 
	? $attributes['earningsOnline'] 
	: ( get_field( 'hero_earnings_online', 'option' ) ?: '20h 16m' );
	
$earnings_tips = ( isset( $attributes['earningsTips'] ) && $attributes['earningsTips'] !== null ) 
	? $attributes['earningsTips'] 
	: ( get_field( 'hero_earnings_tips', 'option' ) ?: '+$187.24' );
	
$notif1_icon = ( isset( $attributes['notification1Icon'] ) && $attributes['notification1Icon'] !== null ) 
	? $attributes['notification1Icon'] 
	: ( get_field( 'hero_notification1_icon', 'option' ) ?: '💰' );
	
$notif1_title = ( isset( $attributes['notification1Title'] ) && $attributes['notification1Title'] !== null ) 
	? $attributes['notification1Title'] 
	: ( get_field( 'hero_notification1_title', 'option' ) ?: 'Payout Processed' );
	
$notif1_sub = ( isset( $attributes['notification1Sub'] ) && $attributes['notification1Sub'] !== null ) 
	? $attributes['notification1Sub'] 
	: ( get_field( 'hero_notification1_sub', 'option' ) ?: 'You received $999.41' );
	
$notif2_icon = ( isset( $attributes['notification2Icon'] ) && $attributes['notification2Icon'] !== null ) 
	? $attributes['notification2Icon'] 
	: ( get_field( 'hero_notification2_icon', 'option' ) ?: '🚗' );
	
$notif2_title = ( isset( $attributes['notification2Title'] ) && $attributes['notification2Title'] !== null ) 
	? $attributes['notification2Title'] 
	: ( get_field( 'hero_notification2_title', 'option' ) ?: 'New Tip!' );
	
$notif2_sub = ( isset( $attributes['notification2Sub'] ) && $attributes['notification2Sub'] !== null ) 
	? $attributes['notification2Sub'] 
	: ( get_field( 'hero_notification2_sub', 'option' ) ?: '+$15.00 from Sarah' );
?>

<section class="hero-section" id="hero">
	<div class="hero-bg-accent"></div>
	<div class="container">
		<div class="hero-grid">
			
			<!-- Left: Text Content -->
			<div class="hero-content fade-in-up">
				<h1 class="hero-title"><?php echo esc_html($headline); ?></h1>
				<p class="hero-subtitle"><?php echo esc_html($subhead); ?></p>
				
				<div class="hero-buttons">
					<?php if($cta1): ?>
						<a href="<?php echo esc_url($cta1_link); ?>" class="btn btn-primary"><?php echo esc_html($cta1); ?></a>
					<?php endif; ?>
					<?php if($cta2): ?>
						<a href="<?php echo esc_url($cta2_link); ?>" class="btn btn-secondary"><?php echo esc_html($cta2); ?></a>
					<?php endif; ?>
				</div>

				<div class="hero-partners">
					<span><?php echo esc_html($partners_text); ?></span>
					<div class="partner-logos">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/uber-logo.svg" alt="Uber" class="partner-logo">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/lyft-logo.svg" alt="Lyft" class="partner-logo">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/doordash-logo.svg" alt="DoorDash" class="partner-logo">
					</div>
				</div>
			</div>

			<!-- Right: Visual Content (Earnings Focus) -->
			<div class="hero-visual fade-in-up" style="transition-delay: 200ms;">
				<div class="freedom-stack">
					
					<!-- Background Lifestyle Image -->
					<div class="lifestyle-bg-card">
						<img src="<?php echo esc_url($lifestyle_image); ?>" alt="Happy Driver" class="lifestyle-img">
						<div class="lifestyle-overlay"></div>
					</div>

					<!-- Main Phone UI: Earnings App -->
					<div class="earnings-app-card">
						<div class="app-header">
							<span><?php echo esc_html($earnings_header); ?></span>
							<span class="status-dot"></span>
						</div>
						<div class="app-balance">
							<span class="currency">$</span><span class="counter" data-target="<?php echo esc_attr($earnings_amount); ?>">0.00</span>
						</div>
						<div class="app-subtext"><?php echo esc_html($earnings_subtext); ?></div>
						
						<div class="app-graph">
							<div class="bar" style="height: 40%;"></div>
							<div class="bar" style="height: 65%;"></div>
							<div class="bar" style="height: 35%;"></div>
							<div class="bar" style="height: 50%;"></div>
							<div class="bar" style="height: 85%;"></div>
							<div class="bar active" style="height: 100%;"></div>
							<div class="bar" style="height: 20%;"></div>
						</div>

						<div class="app-stats-row">
							<div class="stat-item">
								<span class="label">Online</span>
								<span class="value"><?php echo esc_html($earnings_online); ?></span>
							</div>
							<div class="stat-item">
								<span class="label">Tips</span>
								<span class="value text-green"><?php echo esc_html($earnings_tips); ?></span>
							</div>
						</div>
					</div>

					<!-- Floating Notification 1 -->
					<div class="float-notif notif-1">
						<div class="notif-icon"><?php echo esc_html($notif1_icon); ?></div>
						<div class="notif-text">
							<div class="notif-title"><?php echo esc_html($notif1_title); ?></div>
							<div class="notif-sub"><?php echo esc_html($notif1_sub); ?></div>
						</div>
					</div>

					<!-- Floating Notification 2 -->
					<div class="float-notif notif-2">
						<div class="notif-icon"><?php echo esc_html($notif2_icon); ?></div>
						<div class="notif-text">
							<div class="notif-title"><?php echo esc_html($notif2_title); ?></div>
							<div class="notif-sub"><?php echo esc_html($notif2_sub); ?></div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</section>
