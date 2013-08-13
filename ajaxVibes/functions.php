<?php
function register_jquery() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'register_jquery');

function register_ajaxLoop_script() {
    wp_register_script(
       'ajaxLoop',
        get_stylesheet_directory_uri() . '/js/ajaxLoop.js',
        array('jquery'),
        NULL
    );
    wp_enqueue_script('ajaxLoop');
}
add_action('wp_enqueue_scripts', 'register_ajaxLoop_script');
?>