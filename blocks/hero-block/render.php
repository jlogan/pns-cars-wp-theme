<?php
/**
 * Hero Block Render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get values from block attributes, fallback to ACF options
$headline = !empty($attributes['headline']) ? $attributes['headline'] : (get_field('hero_headline', 'option') ?: '');
$subhead = !empty($attributes['subheadline']) ? $attributes['subheadline'] : (get_field('hero_subheadline', 'option') ?: '');
$cta1 = !empty($attributes['ctaPrimary']) ? $attributes['ctaPrimary'] : (get_field('hero_cta_primary', 'option') ?: '');
$cta2 = !empty($attributes['ctaSecondary']) ? $attributes['ctaSecondary'] : (get_field('hero_cta_secondary', 'option') ?: '');
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
						<a href="#vehicles" class="btn btn-primary"><?php echo esc_html($cta1); ?></a>
					<?php endif; ?>
					<?php if($cta2): ?>
						<a href="#booking" class="btn btn-secondary"><?php echo esc_html($cta2); ?></a>
					<?php endif; ?>
				</div>

				<div class="hero-partners">
					<span>Perfect for:</span>
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
						<img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop" alt="Happy Driver" class="lifestyle-img">
						<div class="lifestyle-overlay"></div>
					</div>

					<!-- Main Phone UI: Earnings App -->
					<div class="earnings-app-card">
						<div class="app-header">
							<span>Weekly Earnings</span>
							<span class="status-dot"></span>
						</div>
						<div class="app-balance">
							<span class="currency">$</span><span class="counter" data-target="1426.29">0.00</span>
						</div>
						<div class="app-subtext">Oct 4 - Oct 10 • 33 Trips</div>
						
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
								<span class="value">20h 16m</span>
							</div>
							<div class="stat-item">
								<span class="label">Tips</span>
								<span class="value text-green">+$187.24</span>
							</div>
						</div>
					</div>

					<!-- Floating Notification 1 -->
					<div class="float-notif notif-1">
						<div class="notif-icon">💰</div>
						<div class="notif-text">
							<div class="notif-title">Payout Processed</div>
							<div class="notif-sub">You received $999.41</div>
						</div>
					</div>

					<!-- Floating Notification 2 -->
					<div class="float-notif notif-2">
						<div class="notif-icon">🚗</div>
						<div class="notif-text">
							<div class="notif-title">New Tip!</div>
							<div class="notif-sub">+$15.00 from Sarah</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</section>
