<?php
/**
 * This file is the template that displays "access denied" for non-members.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


global $app_version, $disp, $Blog;

if( version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );
global $Blog;

// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>
<?php
if( $Skin->is_visible_container( 'menu' ) )
{ // Display 'Menu' widget container
?>
<nav class="navbar">				
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-hamb collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
				<?php // ------------------------- "Menu" SEARCH TOGGLER --------------------------
					if ( $Skin->get_setting( 'nav_search' ) == true ) { ?>
						<div class="navbar-toggle header-search-toggle">
							<i class="fa fa-search search-field-toggle"></i>
						</div>
				<?php } // ---------------------- END OF "Menu" SEARCH TOGGLER ---------------------- ?>
				
				<?php // ------------------------- "Menu" SOCIAL LINKS --------------------------
					if ( $Skin->get_setting( 'nav_social' ) == true ) { 
						skin_widget( array(
						// CODE for the widget:
						'widget'              => 'user_links',
						// Optional display params
						'block_start'         => '<div class="evo_widget $wi_class$ navbar-toggle header-social-toggle">',
						'block_end'           => '</div>',
						'block_display_title' => false,
					) );
					}
				  // ---------------------- END OF "Menu" SOCIAL LINKS ---------------------- 
				  ?>
			
				<?php 
				// ------------------------- "Menu" Collection title --------------------------
				if ( $Skin->get_setting( 'title_logo_w' ) == 'display_title' ) {
					skin_widget( array(
						// CODE for the widget:
						'widget'              => 'coll_title',
						// Optional display params
						'block_start'         => '<div class="navbar-brand">',
						'block_end'           => '</div>',
						'item_class'           => 'navbar-brand',
					) );
				// ------------------------- "Menu" Collection logo --------------------------
				} else if ( $Skin->get_setting( 'title_logo_w' ) == 'display_logo' && !empty($Skin->get_setting( 'title_logo_w' )) ) {
					$logo_w_path = $Skin->get_setting('logo_w_path');
					echo '<div class="navbar-brand navbar-logo">';
					echo '<a href="'.$Blog->get( 'url' ).'"><img src="'.$skins_url.'/ego_skin/'.$logo_w_path.'" /></a>';
					echo '</div>';
				}
				// ---------------------- END OF "Menu" Collection title/logo ---------------------- 
				?>
				
		</div><!-- /.navbar-header -->

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-collapse-1">

				<?php // ------------------------- "Menu" SEARCH TOGGLER --------------------------
					if ( $Skin->get_setting( 'nav_search' ) == true ) { ?>
						<div class="header-search-toggle">
							<i class="fa fa-search search-field-toggle"></i>
						</div>
				<?php } // ---------------------- END OF "Menu" SEARCH TOGGLER ---------------------- ?>

				<?php // ------------------------- "Menu" SOCIAL LINKS --------------------------
					if ( $Skin->get_setting( 'nav_social' ) == true ) { 
						skin_widget( array(
						// CODE for the widget:
						'widget'              => 'user_links',
						// Optional display params
						'block_start'         => '<div class="evo_widget $wi_class$ menu-social-toggle">',
						'block_end'           => '</div>',
						'block_display_title' => false,
					) );
					}
					  // ---------------------- END OF "Menu" SOCIAL LINKS ---------------------- ?>
				
				<?php
					// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
					// Display container and contents:
					// Note: this container is designed to be a single <ul> list
					widget_container( 'menu', array(
							// The following params will be used as defaults for widgets included in this container:
							'container_display_if_empty' => false, // If no widget, don't display container at all
							'container_start'     => '<ul class="navbar-nav evo_container $wico_class$">',
							'container_end'       => '</ul>',
							'block_start'         => '',
							'block_end'           => '',
							'block_display_title' => false,
							'list_start'          => '',
							'list_end'            => '',
							'item_start'          => '<li class="evo_widget $wi_class$">',
							'item_end'            => '</li>',
							'item_selected_start' => '<li class="active evo_widget $wi_class$">',
							'item_selected_end'   => '</li>',
							'item_title_before'   => '',
							'item_title_after'    => '',
						) );
					// ----------------------------- END OF "Menu" CONTAINER -----------------------------
				?>
		</div><!-- .collapse -->
</nav><!-- .row -->

<?php
	skin_widget( array(
		// CODE for the widget:
		'widget'              => 'coll_search_form',
		// Optional display params
		'block_start'         => '<div class="evo_widget $wi_class$ header-main-search-field">',
		'block_end'           => '</div>',
		'block_display_title' => false,
		'search_submit_before' => '<span class="hidden">',
		'search_submit_after'  => '</span>',
	) );
?>
<?php } ?>
<div class="container main-page-content">

<div class="row">
	<div class="<?php echo $Skin->is_visible_sidebar( true ) ? $Skin->get_column_class() : 'col-md-12'; ?>">
		<main><!-- This is were a link like "Jump to main content" would land -->

		<!-- ================================= START OF MAIN AREA ================================== -->

		<?php
			// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
			messages( array(
					'block_start' => '<div class="action_messages">',
					'block_end'   => '</div>',
				) );
			// --------------------------------- END OF MESSAGES ---------------------------------
		?>

		<?php
			// ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
			request_title( array(
					'title_before'      => '<h2 class="page_title">',
					'title_after'       => '</h2>',
					'title_none'        => '',
					'glue'              => ' - ',
				) );
			// ----------------------------- END OF REQUEST TITLE ----------------------------
		?>

		<?php
			// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
			skin_include( '_access_denied.disp.php' );
			// Note: you can customize any of the sub templates included here by
			// copying the matching php file into your skin directory.
			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
		?>

		</main>

	</div><!-- .col -->

	<?php
	if( $Skin->is_visible_sidebar( true ) )
	{ // Display sidebar:
	?>
	<aside class="col-md-3<?php echo ( $Skin->get_setting( 'layout' ) == 'left_sidebar' ? ' pull-left' : '' ); ?>">
		<?php
		if( $Skin->is_visible_container( 'sidebar' ) )
		{	// Display 'Sidebar' widget container:
			// ------------------------- "Sidebar" CONTAINER EMBEDDED HERE --------------------------
			widget_container( 'sidebar', array(
					// The following (optional) params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start' => '<div class="evo_container $wico_class$">',
					'container_end'   => '</div>',
					// This will enclose each widget in a block:
					'block_start' => '<div class="panel panel-default evo_widget $wi_class$">',
					'block_end' => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<div class="panel-heading"><h4 class="panel-title">',
					'block_title_end' => '</h4></div>',
					// This will enclose the body of each widget:
					'block_body_start' => '<div class="panel-body">',
					'block_body_end' => '</div>',
					// If a widget displays a list, this will enclose that list:
					'list_start' => '<ul>',
					'list_end' => '</ul>',
					// This will enclose each item in a list:
					'item_start' => '<li>',
					'item_end' => '</li>',
					// This will enclose sub-lists in a list:
					'group_start' => '<ul>',
					'group_end' => '</ul>',
					// This will enclose (foot)notes:
					'notes_start' => '<div class="notes">',
					'notes_end' => '</div>',
					// Widget 'Search form':
					'search_class'         => 'compact_search_form',
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
				) );
			// ----------------------------- END OF "Sidebar" CONTAINER -----------------------------
		} ?>

		<?php
		if( $Skin->is_visible_container( 'sidebar2' ) )
		{	// Display 'Sidebar 2' widget container:
			// ------------------------- "Sidebar 2" CONTAINER EMBEDDED HERE --------------------------
			widget_container( 'sidebar_2', array(
					// The following (optional) params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start' => '<div class="evo_container $wico_class$">',
					'container_end'   => '</div>',
					// This will enclose each widget in a block:
					'block_start' => '<div class="panel panel-default evo_widget $wi_class$">',
					'block_end' => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<div class="panel-heading"><h4 class="panel-title">',
					'block_title_end' => '</h4></div>',
					// This will enclose the body of each widget:
					'block_body_start' => '<div class="panel-body">',
					'block_body_end' => '</div>',
					// If a widget displays a list, this will enclose that list:
					'list_start' => '<ul>',
					'list_end' => '</ul>',
					// This will enclose each item in a list:
					'item_start' => '<li>',
					'item_end' => '</li>',
					// This will enclose sub-lists in a list:
					'group_start' => '<ul>',
					'group_end' => '</ul>',
					// This will enclose (foot)notes:
					'notes_start' => '<div class="notes">',
					'notes_end' => '</div>',
					// Widget 'Search form':
					'search_class'         => 'compact_search_form',
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
				) );
			// ----------------------------- END OF "Sidebar 2" CONTAINER -----------------------------
		} ?>

	</aside><!-- .col -->
	<?php } ?>

</div><!-- .row -->


<footer class="row">

	<!-- =================================== START OF FOOTER =================================== -->
	<div class="col-md-12 center">

		<?php
		if( $Skin->is_visible_container( 'footer' ) )
		{	// Display 'Footer' widget container:
			// ------------------------- "Footer" CONTAINER EMBEDDED HERE --------------------------
			widget_container( 'footer', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start' => '<div class="evo_container $wico_class$">',
					'container_end'   => '</div>',
					'block_start'     => '<div class="evo_widget $wi_class$">',
					'block_end'       => '</div>',
				) );
			// ----------------------------- END OF "Footer" CONTAINER -----------------------------
		} ?>

		<p>
			<?php
				// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
						'before' => '',
						'after'  => ' &bull; ',
					) );

			// TODO: dh> provide a default class for pTyp, too. Should be a name and not the ityp_ID though..?!
			?>

			<?php
				// Display a link to contact the owner of this blog (if owner accepts messages):
				$Blog->contact_link( array(
						'before' => '',
						'after'  => ' &bull; ',
						'text'   => T_('Contact'),
						'title'  => T_('Send a message to the owner of this blog...'),
					) );
				// Display a link to help page:
				$Blog->help_link( array(
						'before'      => ' ',
						'after'       => ' ',
						'text'        => T_('Help'),
					) );
			?>

			<?php
				// Display additional credits:
				// If you can add your own credits without removing the defaults, you'll be very cool :))
				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
				credits( array(
						'list_start'  => '&bull;',
						'list_end'    => ' ',
						'separator'   => '&bull;',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );
			?>
		</p>

		<?php
			// Please help us promote b2evolution and leave this logo on your blog:
			powered_by( array(
					'block_start' => '<div class="powered_by">',
					'block_end'   => '</div>',
					// Check /rsc/img/ for other possible images -- Don't forget to change or remove width & height too
					'img_url'     => '$rsc$img/powered-by-b2evolution-120t.gif',
					'img_width'   => 120,
					'img_height'  => 32,
				) );
		?>
	</div><!-- .col -->
	
</footer><!-- .row -->


</div><!-- .container -->


<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>