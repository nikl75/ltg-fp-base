<?php
$tQuery;
get_header(); ?>

<?php
/* debug file name */
if (is_user_logged_in()) {
	echo ('<div class="ltg-debug filename">' . basename(__FILE__) . '</div>');
}
?>

<?php get_template_part('template-parts/featured-image'); ?>
<div class="main-container">
	<div class="main-grid grid-margin-x grid-x grid-margin-y sike-meister-page-title">

		<?php if (!get_field('sike_titel_verbergen', get_the_ID())) : ?>
			<header class="cell small-12">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
		<?php endif; ?>
		</div>
		<?php
			$re = custom_werke_liste(array());
			echo $re;


		?>
</div>
<?php get_footer();
