<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.

$current_id = $post->ID;
if (is_home()){ 
	$current_id = get_option('page_for_posts');
}
if (!get_field('sike_beitragsbild_verbergen', $current_id)) {
	echo '<div class="grid-container post-thumbnail-container">';
	if (has_post_thumbnail($current_id) ) {
		echo '	
						<div href="' . get_the_post_thumbnail_url($current_id, 'full') . '" data-fancybox="gal-' . get_the_ID() . '" data-fbID="' . get_the_ID() . '" class="featured-hero sike-button" role="banner" data-interchange="[' . get_the_post_thumbnail_url($current_id, 'featured-small') . ', small], [' . get_the_post_thumbnail_url($current_id, 'featured-medium') . ', medium], [' . get_the_post_thumbnail_url($current_id, 'featured-large') . ', large], [' . get_the_post_thumbnail_url($current_id, 'featured-xlarge') . ', xlarge]"></div>';
	} else {
			$tHeaders = get_uploaded_header_images();

			if (!is_random_header_image() && get_header_image()) {
				echo '
						<div class="featured-hero default" role="banner" data-interchange="[' . get_header_image() . ', small], [' . get_header_image() . ', medium], [' . get_header_image() . ', large], [' . get_header_image() . ', xlarge]"></div>';
			} elseif (is_random_header_image() && count($tHeaders) >= 1) {

				echo '	
						<div class="swiper-container swiper-featured-galerie featured-hero default"  role="banner">
				    		<div class="swiper-wrapper">';
				foreach ($tHeaders as $tHeader) {
					echo '		<div class="swiper-slide header-slide" style="background:url(' . $tHeader['url'] . ')"></div>';
				}
				echo '    	</div>';
				echo '		<div class="swiper-pagination"></div>';
				echo '  </div>';
			}
	}
	echo '</div>';
}
