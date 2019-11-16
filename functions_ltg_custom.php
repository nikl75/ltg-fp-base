<?php

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
        'default-image'          => get_template_directory_uri() . '/dist/assets/images/corporate/corporate-default-header.png',
        'random-default'         => false,
        'width'                  => 0,
        'height'                 => 0,
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

    // CUSTOM BACKGROUND IMAGE
    $defaults = array(
	    'default-image'          => get_template_directory_uri() . '/dist/assets/images/corporate/corporate-default-bg.png',
	    'default-preset'         => 'default', // 'default', 'fill', 'fit', 'repeat', 'custom'
	    'default-position-x'     => 'left',    // 'left', 'center', 'right'
	    'default-position-y'     => 'top',     // 'top', 'center', 'bottom'
	    'default-size'           => 'auto',    // 'auto', 'contain', 'cover'
	    'default-repeat'         => 'repeat',  // 'repeat-x', 'repeat-y', 'repeat', 'no-repeat'
	    'default-attachment'     => 'scroll',  // 'scroll', 'fixed'
	    'default-color'          => '',
	    'wp-head-callback'       => '_custom_background_cb',
	    'admin-head-callback'    => '',
	    'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-background', $defaults );

}
add_action('after_setup_theme', 'ltg_theme_setup', 100);

function ltg_add_theme_scripts()
{
    wp_enqueue_script('swiper', get_template_directory_uri() . '/library/swiper.min.js', array('jquery'), 1.1, true);
    wp_enqueue_script('ltg-call-swiper', get_template_directory_uri() . '/library/ltg_swiper-call.js', array('swiper'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'ltg_add_theme_scripts');
