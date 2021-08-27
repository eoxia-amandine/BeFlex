<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Beflex
 * @since 4.0.0
 */


if ( ! function_exists( 'beflextheme_support' ) ) :
/**
 * Theme support
 */
function beflextheme_support()  {

	// Adding support for featured images.
	add_theme_support( 'post-thumbnails' );

	// Adding support for core block visual styles.
	add_theme_support( 'wp-block-styles' );

	// Adding support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( get_template_directory_uri() . '/assets/css/style.min.css' );
	add_editor_style( 'style.css' );

	// Add support for custom units.
	add_theme_support( 'custom-units' );
}
add_action( 'after_setup_theme', 'beflextheme_support' );

endif;

/**
* Enqueue scripts and styles.
*/
function beflextheme_scripts() {
	// Enqueue theme stylesheets.
	wp_enqueue_style( 'beflex-style', get_template_directory_uri() . '/assets/css/style.min.css', array(), wp_get_theme()->get( 'Version' ) );

	// Enqueue theme scripts.
	wp_enqueue_script( 'beflex-script', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'beflextheme_scripts' );


// Block patterns.
require_once 'inc/block-patterns.php';
