<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
	<div class="container header-inner">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">
				PNS <span>CARS</span>
			</a>
		</div>

		<nav id="site-navigation" class="main-nav">
			<ul>
				<li><a href="#how-it-works">How It Works</a></li>
				<li><a href="#services">Benefits</a></li>
				<li><a href="#vehicles">Vehicles</a></li>
				<li><a href="#pricing">Pricing</a></li>
				<li><a href="#faq">FAQ</a></li>
			</ul>
		</nav>

        <div class="header-actions">
            <a href="#vehicles" class="btn btn-primary btn-sm">Rent Now</a>
        </div>
        
        <button class="mobile-toggle" aria-label="Toggle Menu">
            ☰
        </button>
	</div>
</header>

<main id="primary" class="site-main">

