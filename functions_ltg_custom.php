<?php

add_image_size('sike_werk_gal', 600,450,true);

function ltg_theme_setup()
{
    // add Gutenberg align-wide and align-full support
    add_theme_support('align-wide');

    // CUSTOM LOGO
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'), //hides listed classes when logo appears
    );
    add_theme_support('custom-logo', $defaults);

    // CUSTOM HEADER BILD
    $defaults = array(
        'default-image'          => get_template_directory_uri() . '/dist/assets/images/corporate/featured-image-default.png',
        'random-default'         => false,
        'width'                  => 2000,
        'height'                 => 500,
        'flex-height'            => false,
        'flex-width'             => false,
        'default-text-color'     => '',
        'header-text'            => false,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
        'video'                  => false,
        'video-active-callback'  => 'is_front_page',
    );
    add_theme_support('custom-header', $defaults);

    register_default_headers( array(
        'default-image' => array(
            'url'           => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.png',
            'thumbnail_url' => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.png',
            'description'   => __( 'Default Header Image', 'ltg' )
        ),
    ) );
    
}
add_action('after_setup_theme', 'ltg_theme_setup', 100);


function ltg_add_theme_scripts()
{
    wp_enqueue_script('swiper', get_template_directory_uri() . '/library/swiper/swiper.min.js', array('jquery'), 1.1, true);
    wp_enqueue_script('ltg-call-swiper', get_template_directory_uri() . '/library/swiper/ltg_swiper-call.js', array('swiper'), 1.1, true);
    wp_enqueue_script('fb', get_template_directory_uri() . '/library/fancybox/jquery.fancybox.js', array('jquery'), 3.5, true);
    wp_enqueue_style('fb-css', get_template_directory_uri(). '/library/fancybox/jquery.fancybox.css');
    wp_enqueue_script('ltg-fb-events', get_template_directory_uri() . '/library/fancybox/ltg_fancybox-events.js', array('fb'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'ltg_add_theme_scripts');



function custom_werke_liste( $atts) {
	$re = '';
	$a = shortcode_atts( array(
		'kategorie' => '',
        'jahre'  => '',
        'ordnung' => '',
	), $atts);
	
    if($a['jahre'] != ''){
        $tJahreString = $a['jahre'];
        $tJahre = explode(', ', $tJahreString);
    }
 
    $tCat = $a['kategorie'];
    $tOrder = $a['ordnung'];

    $re .= '<div class="main-grid grid-margin-x grid-x grid-margin-y">';

    if ($tJahre) {
        foreach ($tJahre as $tJahr) {
            $re .= '<div class="cell small-12 liste-werk liste-jahr">' . $tJahr . '</div>';
            $tS = werkeSammeln($tJahr, $tCat, $tOrder);
            $re .= werkeShowList($tS);
        }
    } else {
        $tS = werkeSammeln('', $tCat, $tOrder);
        $re .= werkeShowList($tS);
    }

    $re .= '</div>';

	return $re;
}
add_shortcode('werke-liste', 'custom_werke_liste');

function werkeSammeln($tJahr, $tCat, $tOrder)
{
	if ($tJahr != '') {
		$tTt = array(
			array(
				'taxonomy' => 'jahr',
				'field' => 'slug',
				'terms' => array($tJahr),
				'operator' => 'IN',
			)
		);
	} else {
		$tTt = '';
	}
	$tQuery = new WP_Query(array(
        'post_type' => 'werke',
        'category_name' => $tCat,
        'orderby'   => 'meta_value',
        'meta_key'  => $tOrder,
        'order' => 'ASC',
		'tax_query' => $tTt
	));
	return $tQuery;
}

function werkeShowList($tWerkList)
{
	if ($tWerkList->have_posts()) {
        $tRe = '';
		while ($tWerkList->have_posts()) {
			$tWerkList->the_post();

			// getting field-group galerie and count difference to 4
			$image = get_the_post_thumbnail();
			$size = 'sike_werk_gal';

			// getting field-group
			$name = get_field('sike_von');

			// getting terms
			$tJ = printTermList(get_the_terms(get_the_ID(), 'jahr'));
			$tM = printTermList(get_the_terms(get_the_ID(), 'material'));
			$tO = printTermList(get_the_terms(get_the_ID(), 'objekt'));

			// build post
			if ($image) {
					$tRe .= '<a href="' . get_the_permalink() . '" class="liste-werk-thumbnail small-12 medium-6 large-3 cell">';
					$tRe .= $image;
					$tRe .= '<div class="sike-caption-trigger"><div class="sike-caption liste werk">' . get_the_title() . '</div></div>';
					$tRe .= '</a>';
			}

		}
	}

	// Reset things, for good measure
	$member_group_query = null;
    wp_reset_postdata();
    return $tRe;
}

function printTermList($tJahr)
{
	$re = array();
	if(! empty($tJahr)){
		foreach ($tJahr as $tT) {
			array_push($re, $tT->name );
		}
	}
	$re = implode('<br/>', $re);
	return $re;
}
