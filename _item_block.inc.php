<?php
/**
 * This is the template that displays the item block: title, author, content (sub-template), tags, comments (sub-template)
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version;

// Default params:
$params = array_merge( array(
		'feature_block'              => false,			// fp>yura: what is this for??
		// Classes for the <article> tag:
		'item_class'                 => 'evo_post evo_content_block',
		'item_type_class'            => 'evo_post__ptyp_',
		'item_status_class'          => 'evo_post__',
		// Controlling the title:
		'disp_title'                 => true,
		'item_title_masonry_before'  => '<div class="evo_post_masonry">',
		'item_title_line_before'     => '<div class="evo_post_title">',	// Note: we use an extra class because it facilitates styling
		'item_title_line_before_spec'=> '<div class="evo_post_title special_posts_simple_layout__title">',
			'item_title_before'          => '<h2>',	
			'item_title_after'           => '</h2>',
			'item_title_single_before'   => '<h1>',	// This replaces the above in case of disp=single or disp=page
			'item_title_single_after'    => '</h1>',
		'item_title_line_after'      => '</div>',
		// Controlling the content:
		'content_mode'               => 'auto',		// excerpt|full|normal|auto -- auto will auto select depending on $disp-detail
		'image_class'                => 'img-responsive',
		'image_size'                 => 'fit-1280x720',
		'author_link_text'           => 'preferredname',
	), $params );

// Posts Format Masonry - Columns number
$columns_count = '';
if ( $disp == 'posts' && ($Skin->get_setting( 'posts_masonry' ) == 'two') ) {
   $columns_count = 'two-cols';
} else if ( $disp == 'posts' && ($Skin->get_setting( 'posts_masonry' ) == 'three') ) {
   $columns_count = 'three-cols';
}

echo '<div class="evo_content_block';
	// If not Intro post and not Simple Posts selected and Masonry posts selected, add special Masonry class "grid-item"
	if ( ! $Item->is_intro() && $disp == 'posts' && $Skin->get_setting( 'posts_format' ) == 'masonry' ) { echo ' grid-item '.$columns_count; }
echo '">'; // Beginning of post display
?>

<article id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>">

	<?php if ( $Skin->get_setting( 'spec_cover_image' ) == true && ! empty($Item->get_cover_image_url()) && in_array( $disp, array( 'single', 'page' ) ) )
	{ // We leave this blank if special cover image option is checked and if there is no cover image upladed
	} else { ?> 
	
	<header>
	
	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

		if( ! $Item->is_intro() && $disp != 'page' ) {
			if ( $Skin->get_setting( 'posts_format' ) != 'masonry' || empty($Item->get_cover_image_url()) ) { ?>
			<div class="evo_post__categories"><i class="fa fa-folder-open categories-icon <?php if ( $disp == 'posts' && $Skin->get_setting( 'posts_format' ) == 'simple' ) { echo 'hidden'; } ?>"></i>
		<?php // Categories
			$Item->categories( array(
				'before'          => '',
				'after'           => '</div>',
				'separator'       => '',
				'include_main'    => true,
				'include_other'   => true,
				'include_external'=> true,
				'link_categories' => true,
				'before_external' => '',   // string fo display before EXTERNAL categories
				'after_external'  => '',  
			) );
			}
		}
		?>

		<?php
		// ------- Title -------
		if( $params['disp_title'] )
		{
			// Check if Special Posts Layout is enabled
			if ( $Skin->get_setting( 'posts_format' ) == 'simple' ) {
				echo $params['item_title_line_before_spec'];
			} else if ( $Skin->get_setting( 'posts_format' ) == 'masonry' ) {
				echo $params['item_title_masonry_before'];
			} else {
				echo $params['item_title_line_before'];
			}

			if( $disp == 'single' || $disp == 'page' )
			{
				$title_before = $params['item_title_single_before'];
				$title_after = $params['item_title_single_after'];
			}
			else
			{
				$title_before = $params['item_title_before'];
				$title_after = $params['item_title_after'];
			}

			// POST TITLE:
			$Item->title( array(
					'before'    => $title_before,
					'after'     => $title_after,
					'link_type' => '#'
				) );

			// EDIT LINK:
			if( $Item->is_intro() )
			{ // Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
				$Item->edit_link( array(
							'before' => '<div class="'.button_class( 'group' ).'">',
							'after'  => '</div>',
							'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
							'class'  => button_class( 'text' ),
						) );
			}

			echo $params['item_title_line_after'];
		}
		?>

		<?php
		if( ! $Item->is_intro() )
		{ // Don't display the following for intro posts
		?>
		<div class="evo_post__info<?php if ( $Skin->get_setting( 'posts_format' ) == 'simple' ) { echo ' special_posts_simple_layout__info'; } ?>">
			<?php
				if( $Item->status != 'published' )
				{
					$Item->format_status( array(
							'template' => '<div class="evo_status evo_status__$status$ badge pull-right">$status_title$</div>',
						) );
				}
			?>

			<?php
				// We want to display the post time:
				$Item->issue_time( array(
					'before'      => '<div class="evo_post__post_date"><i class="fa fa-clock-o"></i> ',
					'after'       => '</div>',
					'time_format' => 'F j, Y',
				) );
			?>
				
			<?php
				// Show author info only if not two-cols or three-cols Masonry layout
				if ( $columns_count == '' ) {
					// Author
					$Item->author( array(
						'before'    => '<div class="evo_post__author"><i class="fa fa-user"></i> ',
						'after'     => '</div>',
						'link_text' => $params['author_link_text'],
					) );
				}
			?>

			<?php
				if ( $disp == 'posts' ) {

				echo '<span class="evo_post__comments">';
				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
								'type' => 'comments',
								'link_before' => '<i class="fa fa-comment-o"></i> ',
								'link_after' => '',
								'link_text_zero' => '0 '.T_('Comments'),
								'link_text_one' => '1 '.T_('Comment'),
								'link_text_more' => '%d '.T_('Comments'),
								'link_title' => '#',
								// fp> WARNING: creates problem on home page: 'link_class' => 'btn btn-default btn-sm',
								// But why do we even have a comment link on the home page ? (only when logged in)
							) );

				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
								'type' => 'trackbacks',
								'link_before' => '<i class="fa fa-comment"></i> ',
								'link_after' => '',
								'link_text_zero' => '0 '.T_('Feedbacks'),
								'link_text_one' => '1 '.T_('Feedback'),
								'link_text_more' => '%d '.T_('Feedbacks'),
								'link_title' => '#',
							) );
				echo '</span>';

				}
			?>

			<?php
				// Link for editing
				$Item->edit_link( array(
					'before'    => '<div>',
					'after'     => '</div>',
				) );
			?>
		</div>
		<?php } ?>
		
	</header>
	
	<?php } ?>

	<?php
	if( $disp == 'single' )
	{
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
		// WARNING: EXPERIMENTAL -- NOT RECOMMENDED FOR PRODUCTION -- MAY CHANGE DRAMATICALLY BEFORE RELEASE.
		// Display container contents:
		widget_container( 'item_single', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			'container_start' => '<div class="evo_container $wico_class$">',
			'container_end'   => '</div>',
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_coll_item_tags_before'    => '<div class="evo_post__full">',
			'widget_coll_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_coll_item_content_params' => $params,
		) );
		// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
	}
	else
	{
		if ( $Skin->get_setting( 'posts_format' ) == 'default' ) {
			// this will create a <section>
				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array_merge( array(
					'more_link_text'           => 'Continue reading',
					), $params ) );
				// Note: You can customize the default item content by copying the generic
				// /skins/_item_content.inc.php file into the current skin folder.
			// -------------------------- END OF POST CONTENT -------------------------
		} else if ( $Skin->get_setting( 'posts_format' ) == 'masonry' ) { // If Masonry Post Format
				// this will create a Simple Blog <section>
				echo '<div class="special_posts_simple_layout__evo_post">';
				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array_merge( array(					
					'image_limit'              => 1,
					'gallery_image_limit'      => 0,
					'before_more_link'         => '<p class="evo_post_more_link hidden">',
					), $params ) );
				// Note: You can customize the default item content by copying the generic
				// /skins/_item_content.inc.php file into the current skin folder.
				// -------------------------- END OF POST CONTENT -------------------------
				echo '</div>';
		} else { // If other Post Format is selected
				// this will create a Simple Blog <section>
				echo '<div class="special_posts_simple_layout__evo_post">';
				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array_merge( array(					
					'image_limit'              => 0,
					'gallery_image_limit'      => 0,
					
					'before_more_link'         => '<p class="evo_post_more_link hidden">',
					), $params ) );
				// Note: You can customize the default item content by copying the generic
				// /skins/_item_content.inc.php file into the current skin folder.
				// -------------------------- END OF POST CONTENT -------------------------
				echo '</div>';
		}
	// this will end a </section>
	}
	?>

	<footer>

		<?php
			if( ! $Item->is_intro() && $Skin->get_setting( 'posts_format' ) == 'default' && $disp == 'posts' ) 
			// Do NOT apply tags, comments and feedback on intro posts and when Simple Blog Layout is selected
			{ // List all tags attached to this post:
				$Item->tags( array(
						'before'    => '<nav class="evo_post__tags">'.T_('Tags: '),
						'after'     => '</nav>',
						'separator' => ', ',
					) );
		?>


		<?php } ?>
	</footer>
	
	<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array_merge( array(
				'before_section_title' => '<div class="clearfix"></div><h3 class="evo_comment__list_title">',
				'after_section_title'  => '</h3>',
				'comment_title_before'  => '<div><h4 class="evo_comment_title panel-title">',
				'comment_info_before'   => '<footer class="evo_comment_footer clear"><small>',
				'comment_avatar_before' => '<div class="comments-wrapper"><span class="evo_comment_avatar">',
				'comment_end'           => '</article></div>',
			), $params ) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
	?>

    <?php
    if( evo_version_compare( $app_version, '6.7' ) >= 0 )
    {    // We are running at least b2evo 6.7, so we can include this file:
        // ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
        skin_include( '_item_workflow.inc.php' );
        // ---------------------- END OF WORKFLOW PROPERTIES ---------------------
    }
    ?>

    <?php
    if( evo_version_compare( $app_version, '6.7' ) >= 0 )
    {    // We are running at least b2evo 6.7, so we can include this file:
        // ------------------ META COMMENTS INCLUDED HERE ------------------
        skin_include( '_item_meta_comments.inc.php', array(
                'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
                'comment_end'           => '</article>',
            ) );
        // ---------------------- END OF META COMMENTS ---------------------
    }
    ?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</article>

<?php echo '</div>'; // End of post display ?>
