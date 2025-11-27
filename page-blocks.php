<?php
/**
 * Template Name: Blocks Template
 * 
 * Template that supports Gutenberg blocks
 */
get_header(); 
?>

<main id="main" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php
				the_content();
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();

