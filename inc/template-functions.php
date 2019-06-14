<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package beflex
 * @since 1.0.0
 * @version 2.0.0-phoenix
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function beflex_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'beflex_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function beflex_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'beflex_pingback_header' );

if ( ! function_exists( 'beflex_pagination' ) ) {
	/**
	 * More beautiful pagination
	 *
	 * @return void
	 */
	function beflex_pagination() {
		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

		$pagination = array(
			'base' => add_query_arg('page','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => false,
			'end_size'     => 1,
			'mid_size'     => 2,
			'type' => 'list',
			'next_text' => '»',
			'prev_text' => '«',
		);

		if ( $wp_rewrite->using_permalinks() ) :
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		endif;

		if ( ! empty( $wp_query->query_vars['s'] ) ) :
			$pagination['add_args'] = array( 's' => str_replace( ' ' , '+', get_query_var( 's' ) ) );
		endif;

		echo str_replace( 'page/1/','', paginate_links( $pagination ) ); // WPCS: XSS ok.
	}
}

/**
 * Display page title according to ACF parameter
 *
 * @param  [type] $title [description]
 * @param  [type] $id    [description]
 * @return [type]        [description]
 */
function beflex_display_page_title( $title, $id ) {
	$beflex_display_title = true;

	if ( ! is_admin() && is_acf() && is_beflex_pro() ) :
		$display_title_field = get_field_object( 'beflex_display_page_title', $id );
		if ( ! empty( $display_title_field ) ) :
			$beflex_display_title = ( get_field( 'beflex_display_page_title', $id ) ) ? true : false;
		endif;
	endif;

	if ( $beflex_display_title ) :
		return $title;
	else :
		return '';
	endif;
}
add_filter( 'the_title', 'beflex_display_page_title', 10, 2 );

/**
 * Remove filter the_title before nav menu starts
 *
 * @param  [type] $nav_menu [description]
 * @param  [type] $args     [description]
 * @return [type]           [description]
 */
function beflex_remove_title_filter_nav_menu( $nav_menu, $args ) {
	remove_filter( 'the_title', 'beflex_display_page_title', 10, 2 );
	return $nav_menu;
}
add_filter( 'pre_wp_nav_menu', 'beflex_remove_title_filter_nav_menu', 10, 2 );

/**
 * Remove filter the_title after nav menu ends
 *
 * @param [type] $items [description]
 * @param [type] $args  [description]
 */
function beflex_add_title_filter_non_menu( $items, $args ) {
	add_filter( 'the_title', 'beflex_display_page_title', 10, 2 );
	return $items;
}
add_filter( 'wp_nav_menu_items', 'beflex_add_title_filter_non_menu', 10, 2 );
