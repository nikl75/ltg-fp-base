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
