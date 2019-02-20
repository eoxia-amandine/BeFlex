<?php
/**
 * The sidebar containing the main widget area
 *
 * @author    Eoxia <contact@eoxia.com>
 * @copyright (c) 2006-2019 Eoxia <contact@eoxia.com>
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 * @package   beflex
 * @since     3.0.0
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$sidebar_name = get_field( 'page_sidebar_name' );
if ( ! is_active_sidebar( $sidebar_name ) ) :
	return;
endif;
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar_name ); ?>
</aside><!-- #secondary -->