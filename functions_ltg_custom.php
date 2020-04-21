<?php

add_image_size('sike_werk_gal', 600, 450, true);
add_image_size('sike_werk_img_stack', 9999, 400, false);
add_image_size('sike_werk_liste_thumb', 9999, 400, false);

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

    register_default_headers(array(
        'default-image' => array(
            'url'           => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.png',
            'thumbnail_url' => get_stylesheet_directory_uri() . '/dist/assets/images/corporate/featured-image-default.png',
            'description'   => __('Default Header Image', 'ltg')
        ),
    ));
}
add_action('after_setup_theme', 'ltg_theme_setup', 100);


function ltg_add_theme_scripts()
{
    wp_enqueue_script('swiper', get_template_directory_uri() . '/library/swiper/swiper.min.js', array('jquery'), 1.1, true);
    wp_enqueue_script('ltg-call-swiper', get_template_directory_uri() . '/library/swiper/ltg_swiper-call.js', array('swiper'), 1.1, true);
    wp_enqueue_script('fb', get_template_directory_uri() . '/library/fancybox/jquery.fancybox.js', array('jquery'), 3.5, true);
    wp_enqueue_style('fb-css', get_template_directory_uri() . '/library/fancybox/jquery.fancybox.css');
    wp_enqueue_script('ltg-fb-events', get_template_directory_uri() . '/library/fancybox/ltg_fancybox-events.js', array('fb'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'ltg_add_theme_scripts');



function custom_werke_liste($atts)
{
    $re = '';
    $a = shortcode_atts(array(
        'kategorie' => '',
        'jahre'  => '',
        'ordnung' => '',
        'post-type' => 'post',
    ), $atts);

    if ($a['jahre'] != '') {
        $tJahreString = $a['jahre'];
        $tJahre = explode(', ', $tJahreString);
    }

    $tCat = $a['kategorie'];
    $tOrder = $a['ordnung'];
    $tPosttype = $a['post-type'];

    console_log($tPosttype);

    $re .= '<div class="main-grid grid-margin-x grid-x grid-margin-y werk-liste">';

    if ($tJahre) {
        foreach ($tJahre as $tJahr) {
            $re .= '<div class="cell small-12 liste-werk liste-jahr">' . $tJahr . '</div>';
            $tS = werkeSammeln($tJahr, $tCat, $tOrder, $tPosttype);
            $re .= werkeShowList($tS);
        }
    } else {
        $tS = werkeSammeln('', $tCat, $tOrder, $tPosttype);
        $re .= werkeShowList($tS);
    }

    $re .= '</div>';

    return $re;
}
add_shortcode('werke-liste', 'custom_werke_liste');

function werkeSammeln($tJahr, $tCat, $tOrder, $tPosttype)
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
        'post_type' => $tPosttype,
        'category_name' => $tCat,
        'orderby'   => 'meta_value',
        'meta_key'  => $tOrder,
        'order' => 'ASC',
        'tax_query' => $tTt
    ));
    console_log($tQuery);
    return $tQuery;
}

function werkeShowList($tWerkList)
{
    if ($tWerkList->have_posts()) {
        $tRe = '';
        while ($tWerkList->have_posts()) {
            $tWerkList->the_post();

            // getting field-group galerie and count difference to 4
            $image = get_the_post_thumbnail(get_the_ID(), 'sike_werk_liste_thumb');
            if($image == ''){
                $image = '<div class="sike-platzhalter"></div>';
            }
            $size = 'sike_werk_gal';

            // getting field-group
            $name = get_field('sike_von');

            // getting terms
            $tJ = printTermList(get_the_terms(get_the_ID(), 'jahr'));
            $tM = printTermList(get_the_terms(get_the_ID(), 'material'));
            $tO = printTermList(get_the_terms(get_the_ID(), 'objekt'));

            // build post
            if ($image) {
                $tRe .= '<a href="' . get_the_permalink() . '" class="liste-werk-thumbnail cell">';
                $tRe .= $image;
                $tRe .= '   <div class="sike-caption-trigger">
                                <h4 class="sike-caption liste werk">' . get_the_title() . '</h4>
                                <div class="sike-textauszug liste werk">'. apply_filters('the_excerpt', get_post_field('post_excerpt', get_the_ID())) .'</div>
                            </div>';
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
    if (!empty($tJahr)) {
        foreach ($tJahr as $tT) {
            array_push($re, $tT->name);
        }
    }
    $re = implode('<br/>', $re);
    return $re;
}
function sike_image_galerie(){
    // echo "<h1>galerie</h1>";
    $images = get_field('sike_galerie');
    $tRe = '<div class="grid-x grid-margin-x grid-margin-y sike-werk-image-galerie">';
    $tSize = 'sike_werk_img_stack'; 
    if($images){
        for ($tImCount = 0; $tImCount <= count($images) - 1; $tImCount++) {
            $tRe .= '<a href="' . $images[$tImCount]['url'] . '" data-fancybox="gal-' . get_the_ID() . '" data-fbID="' . get_the_ID() . '" class="sike-werk-stack cell small-expand medium-shrink">';
            // $tRe .= '<a href="' . $images[$tImCount]['url'] . '" data-fancybox="gal-gesamt" data-fbID="' . get_the_ID() . '" class="liste-werk-werk-bild small-12 medium-6 large-3 cell">';
            $tRe .= wp_get_attachment_image($images[$tImCount]['ID'], $tSize);
            // $tRe .= '<div class="holzh-caption-trigger"><div class="holzh-caption liste werk">' . get_the_title() . '</div></div>';
            $tRe .= '</a>';

        }
    }
    $tRe .= "</div>";
    echo $tRe;
}

function sike_get_archive_featured_image($tID){
    if (has_post_thumbnail($tID) ) {
		echo '<a href="' . esc_url(get_permalink()) . '" class="">'. get_the_post_thumbnail($tID, 'full').'</a>';
	}
}


function console_log($output, $with_script_tags = true)
{
    // $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    //     ');';
    // if ($with_script_tags) {
    //     $js_code = '<script>' . $js_code . '</script>';
    // }
    // echo $js_code;
}
