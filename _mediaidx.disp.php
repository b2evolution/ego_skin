<?php
/**
 * This is the template that displays the media index for a blog
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display the archive directory, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=arcdir
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $thumbnail_sizes;

if( empty( $params ) )
{ // Initialize array with params
	$params = array();
}

// Merge the params from current skin
$params = array_merge( array(
		'mediaidx_thumb_size' => $Skin->get_setting( 'mediaidx_thumb_size' ),
	), $params );

$photocell_styles = '';
if( isset( $thumbnail_sizes[ $params['mediaidx_thumb_size'] ] ) )
{
	$photocell_styles = ' style="width:'.$thumbnail_sizes[ $params['mediaidx_thumb_size'] ][1].'px;'
		.'height:'.$thumbnail_sizes[ $params['mediaidx_thumb_size'] ][2].'px"';
}

// Customizable settings
$mediaidx_grid = $Skin->get_setting( 'mediaidx_grid' );
$grid = "";
if ( $mediaidx_grid == 'one_column' ) {
   $grid = "one";
} else if ( $mediaidx_grid == 'three_column' ) {
   $grid = 'three';
}


// --------------------------------- START OF MEDIA INDEX --------------------------------
skin_widget( array(
		// CODE for the widget:
		'widget' => 'coll_media_index',
		// Optional display params
		'block_start' => '<div class="evo_widget $wi_class$">',
		'block_end' => '</div>',
		'block_display_title' => false,
		'thumb_size' => $params['mediaidx_thumb_size'],
		'thumb_layout' => 'list',
		'list_start' => '<div class="mediaidx-item--wrapper">',
		'list_end' => '</div>',
	    'item_start' => '<div class="mediaidx-item">',
		'item_end' => '</div>',
		'order_by' => $Blog->get_setting('orderby'),
		'order_dir' => $Blog->get_setting('orderdir'),
		'limit' => 100,
	) );
// ---------------------------------- END OF MEDIA INDEX ---------------------------------

?>