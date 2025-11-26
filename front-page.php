<?php
/**
 * The main template file (Landing Page)
 */
get_header(); 
?>

<!-- 1. Hero Section -->
<?php get_template_part( 'template-parts/section', 'hero' ); ?>

<!-- 2. How It Works -->
<?php get_template_part( 'template-parts/section', 'how-it-works' ); ?>

<!-- 3. Services -->
<?php get_template_part( 'template-parts/section', 'services' ); ?>

<!-- 4. Vehicles -->
<?php get_template_part( 'template-parts/section', 'vehicles' ); ?>

<!-- 5. Pricing -->
<?php get_template_part( 'template-parts/section', 'pricing' ); ?>

<!-- 6. FAQ -->
<?php get_template_part( 'template-parts/section', 'faq' ); ?>

<!-- 7. Map/Location -->
<?php get_template_part( 'template-parts/section', 'location' ); ?>

<?php get_footer(); ?>

