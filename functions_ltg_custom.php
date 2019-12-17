<?php

add_image_size('holzh_werk_gal', 600,450,true);

function ltg_theme_setup()
{
    // add Gutenberg align-wide and align-full support
    add_theme_support('align-wide');

    // // CUSTOM LOGO
    // $defaults = array(
    //     'height'      => 100,
    //     'width'       => 400,
    //     'flex-height' => true,
    //     'flex-width'  => true,
    //     'header-text' => array('site-title', 'site-description'), //hides listed classes when logo appears
    // );
    // add_theme_support('custom-logo', $defaults);

    // CUSTOM HEADER BILD
    $defaults = array(
        'default-image'          => get_template_directory_uri() . '/dist/assets/images/corporate/featured-image-default.jpg',
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
            'url'           => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.jpg',
            'thumbnail_url' => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.jpg',
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
        // echo '$member_group_terms';
        foreach ($tJahre as $tJahr) {
            $re .= '<div class="cell small-12 liste-werk liste-jahr">' . $tJahr . '</div>';
            $tS = werkeSammeln($tJahr, $tCat, $tOrder);
            $re .= werkeShowList($tS);
        }
    } else {
        // echo '$member_group_terms empty';
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
			$images = get_field('holzh_galerie');
			$size = 'holzh_werk_gal';
			$tIC = (count($images) < 4) ? count($images) : 4;

			// getting field-group
			$name = get_field('holzh_von');

			// getting terms
			$tJ = printTermList(get_the_terms(get_the_ID(), 'jahr'));
			$tM = printTermList(get_the_terms(get_the_ID(), 'material'));
			$tO = printTermList(get_the_terms(get_the_ID(), 'objekt'));

			// build post
			if ($images) {
				for ($tImCount = 0; $tImCount <= $tIC - 1; $tImCount++) {
					// $tRe .= '<a href="' . $images[$tImCount]['url'] . '" data-fancybox="gal-' . get_the_ID() . '" class="liste-werk-werk-bild small-12 medium-6 large-3 cell">';
					$tRe .= '<a href="' . $images[$tImCount]['url'] . '" data-fancybox="gal-gesamt" class="liste-werk-werk-bild small-12 medium-6 large-3 cell">';
					$tRe .= wp_get_attachment_image($images[$tImCount]['ID'], $size);
					$tRe .= '<div class="holzh-caption-trigger"><div class="holzh-caption liste werk">' . get_the_title() . '</div></div>';
					$tRe .= '</a>';
				}
				for ($tNonImCount = 0; $tNonImCount <= 3 - $tIC; $tNonImCount++) {
					$tRe .= '<div class="holzh-spacer cell medium-6 large-3 hide-for-small-only"></div>';
				}
			}

			$tRe .= 
				'
				<div class="holzh-info is-hidden" id="holzh-infobox-' . get_the_ID() . '">
				<div class="holzh-term-objekt">' . $tO . '</div>
				<div class="holzh-title"><h2>' . get_the_title() . '</h2></div>
				<div class="holzh-untertitel">' . get_field('holzh_untertitel') . '</div>
				<div class="holzh-terms-material">' . $tM . '</div>
				<div class="holzh-name">' . $name['holzh_gef_vorname'] . ' ' . $name['holzh_gef_nachname'] . '</div>
				<div class="holzh-kontakt">' . get_field('holzh_kontakt') . '</div>
				<div class="holzh-e-mail"><a href="mailto:' . get_field('holzh_e-mail') . '">' . get_field('holzh_e-mail') . '</a></div>
				<div class="holzh-gefertigt-bei">' . get_field('holzh_gefertigt_bei') . '</div>
				<div class="holzh-ausbildungsbetrieb">' . get_field('holzh_ausbildungsbetrieb') . '</div>
				<div class="holzh-term-jahr">' . $tJ . '</div>
			</div>';
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
