<?php
/**
 * theme functions and definitions
 *
 * @package Qortia
 */

function Qortia_scripts() {
	wp_enqueue_style( 'Qortia-fancy-css', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', array(), '1.0' );
	wp_enqueue_style( 'Qortia-main-css', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0' );
	wp_enqueue_style( 'Qortia-fix-css', get_template_directory_uri() . '/assets/css/fix.css', array(), '1.0' );
	wp_enqueue_style( 'Qortia-style-css', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.2' );
	wp_enqueue_script( 'Qortia-jquery-scripts', get_template_directory_uri() . '/assets/js/jquery.js', array(), '1.0', true );
	wp_enqueue_script( 'Qortia-fancy-scripts', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', array(), '1.0', true );
	wp_enqueue_script( 'Qortia-inputmask-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js', array(), '1.0', true );
	wp_enqueue_script( 'Qortia-libs-scripts', get_template_directory_uri() . '/assets/js/libs.min.js', array(), '1.0', true );
	wp_enqueue_script( 'Qortia-main-scripts', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.1', true );
	wp_enqueue_script( 'Qortia-fix-scripts', get_template_directory_uri() . '/assets/js/fix.js', array(), '1.0', true );
	wp_enqueue_script( 'Qortia-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.2', true );
	wp_localize_script( 'ajax-script', 'AJAX', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'Qortia_scripts' );

get_template_part( 'functions/helpers' );
get_template_part( 'functions/settings' );
get_template_part( 'functions/carbon-settings' );
get_template_part( 'functions/translations' );
get_template_part( 'functions/components' );
get_template_part( 'functions/google-distance' );
get_template_part( 'functions/ajax-functions' );
get_template_part( 'functions/add-status-bubble' );

function enqueue_admin_scripts() {
	wp_enqueue_style( 'custom-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0' );
	wp_enqueue_script( 'custom-admin-scripts', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), '1.0', true );
}

//add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');



