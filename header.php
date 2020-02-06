<?php

/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php if (get_theme_mod('wpt_mobile_menu_layout') === 'offcanvas') : ?>
		<?php get_template_part('template-parts/mobile-off-canvas'); ?>
	<?php endif; ?>

	<header class="site-header" role="banner">

		<div class="holzh-bg-wrapper bg-wrapper-logo">
			<div class="container">
				<div class="holzh-top-bar main-grid align-bottom main-content-full-width grid-x grid-margin-x">
					<div class="holzh-logo cell shrink">
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<span class="holzh-logo-zeile-eins">Holzhandwerk</span><br />
							<span class="holzh-logo-zeile-zwei">Allgäu<br />
								Oberschwaben</span>
						</a>
					</div>


					<nav class="site-navigation-desktop cell shrink holzh-top-bar-menu">
						<?php foundationpress_top_bar_r(); ?>
						<button aria-label="<?php _e('Main Menu', 'foundationpress'); ?>" class="show-for-small-only menu-icon" type="button" data-toggle="holzh-mobile-menu"></button>
					</nav>

					<?php if (!get_theme_mod('wpt_mobile_menu_layout') || get_theme_mod('wpt_mobile_menu_layout') === 'topbar') : ?>
						<nav id="holzh-mobile-menu" class="site-navigation-mobile cell small-12 holzh-top-bar-mobile is-hidden" data-toggler=".is-hidden">
							<?php get_template_part('template-parts/mobile-top-bar'); ?>
						</nav>
					<?php endif; ?>


				</div>
			</div>
		</div>



	</header>
