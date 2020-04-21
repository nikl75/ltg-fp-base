<?php
/*
Template Name: Full Width
*/
get_header(); ?>

<?php
	/* debug file name */
	if (is_user_logged_in()) {
		echo ('<div class="ltg-debug filename">' . basename(__FILE__) . '</div>');
	}
?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<div class="main-container">
	<div class="main-grid grid-margin-x">
		<main class="main-content-full-width">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</main>
	</div>
</div>
<?php get_footer();
