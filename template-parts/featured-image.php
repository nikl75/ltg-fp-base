<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.
if (has_post_thumbnail($post->ID)) {
	echo '	
						<div class="featured-hero" role="banner" data-interchange="[' . get_the_post_thumbnail_url($post->ID, 'featured-small') . ', small], [' . get_the_post_thumbnail_url($post->ID, 'featured-medium') . ', medium], [' . get_the_post_thumbnail_url($post->ID, 'featured-large') . ', large], [' . get_the_post_thumbnail_url($post->ID, 'featured-xlarge') . ', xlarge]"></div>';
} else {
	$tHeaders = get_uploaded_header_images();
	if (!is_random_header_image() || count($tHeaders) <= 1) {
		echo '
						<div class="featured-hero default" role="banner" data-interchange="[' . get_header_image() . ', small], [' . get_header_image() . ', medium], [' . get_header_image() . ', large], [' . get_header_image() . ', xlarge]"></div>';
	} else {

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
