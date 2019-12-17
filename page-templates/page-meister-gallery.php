<?php
/*
Template Name: Meister Galerie
*/
$tQuery;
get_header(); ?>

<?php get_template_part('template-parts/featured-image'); ?>
<div class="main-container">
	<div class="main-grid grid-margin-x grid-x grid-margin-y holzh-meister-page-title">

		<?php if (!get_field('holzh_titel_verbergen', get_the_ID())) : ?>
			<header class="cell small-12">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
	</div>
		<?php endif; ?>
		<?php
			$re = custom_werke_liste(array());
			echo $re;


		?>
</div>
<?php get_footer();
