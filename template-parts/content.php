<?php

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<?php
/* debug file name */
if (is_user_logged_in()) {
	echo ('<div class="ltg-debug filename">' . basename(__FILE__) . '</div>');
}
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<?php if (is_singular("werke")) {
		sike_image_galerie();
	}
	?>

	<header>
		<?php
		if (is_single() && !get_field('sike_titel_verbergen', get_the_ID())) {
			the_title('<h1 class="entry-title">', '</h1>');
		} elseif(!is_singular()){
			sike_get_archive_featured_image(get_the_ID());
			the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
		} 
		?>
	</header>

	<div class="entry-content">
		<?php	if (is_single()) {
			the_content();
		} else {
			the_excerpt();
		}
		?>
		<?php edit_post_link(__('(Edit)', 'foundationpress'), '<span class="edit-link">', '</span>'); ?> 
		
	</div>
	<footer>
		<?php
		wp_link_pages(
			array(
				'before' => '<nav id="page-nav"><p>' . __('Pages:', 'foundationpress'),
				'after'  => '</p></nav>',
			)
		);
		?>
		<?php $tag = get_the_tags();
		if ($tag) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</article>