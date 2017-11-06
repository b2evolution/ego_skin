<?php
/**
 * This is the main/default page template for the "bootstrap_blog" skin.
 *
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific dispays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

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
echo "<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>";
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
<div class="container main-page-content">
	<div class="row">
         <!-- ================================= START OF MAIN AREA ================================== -->
         <div class="col-lg-12">

            <?php
            if( ! in_array( $disp, array( 'login', 'lostpassword', 'register', 'activateinfo', 'access_requires_login' ) ) )
            { // Don't display the messages here because they are displayed inside wrapper to have the same width as form
               // ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
               messages( array(
                  'block_start' => '<div class="action_messages">',
                  'block_end'   => '</div>',
               ) );
               // --------------------------------- END OF MESSAGES ---------------------------------
            }
            ?>

            <?php
               // ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
               item_prevnext_links( array(
                  'block_start' => '<nav><ul class="pager">',
                  'prev_start'  => '<li class="previous">',
                  'prev_end'    => '</li>',
                  'next_start'  => '<li class="next">',
                  'next_end'    => '</li>',
                  'block_end'   => '</ul></nav>',
               ) );
               // ------------------------- END OF PREV/NEXT POST LINKS -------------------------
            ?>

            <?php
               // ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
               request_title( array(
                  'title_before'       => '<div class="row"><div class="container"><h2 class="title_mediaidx">',
                  'title_after'        => '</h2></div></div>',
                  'title_none'         => '',
                  'glue'               => ' - ',
                  'title_single_disp'  => false,
                  'title_page_disp'    => false,
                  'format'             => 'htmlbody',
                  'register_text'      => '',
                  'login_text'         => '',
                  'lostpassword_text'  => '',
                  'account_activation' => '',
                  'msgform_text'       => '',
                  'user_text'          => '',
                  'users_text'         => '',
                  'display_edit_links' => false,
                  'arcdir_text'        => T_('Index'),
                  'catdir_text'        => '',
                  'category_text'      => T_('Gallery').': ',
                  'categories_text'    => T_('Galleries').': ',
               ) );
               // ----------------------------- END OF REQUEST TITLE ----------------------------
            ?>


      		<?php
      			// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
      			skin_include( '$disp$', array(
   					'author_link_text'     => 'preferredname',
   					'item_class'           => 'evo_post evo_content_block',
   					'item_type_class'      => 'evo_post__ptyp_',
   					'item_status_class'    => 'evo_post__',
   					// Login
   					'login_page_before'    => '<div class="login_block"><div class="evo_details">',
   					'login_page_after'     => '</div></div>',
   					// Register
   					'register_page_before' => '<div class="login_block"><div class="evo_details">',
   					'register_page_after'  => '</div></div>',
   					'display_abort_link'   => ( $Blog->get_setting( 'allow_access' ) == 'public' ), // Display link to abort login only when it is really possible
   				) );
      			// Note: you can customize any of the sub templates included here by
      			// copying the matching php file into your skin directory.
      			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
      		?>

         </div><!-- .col -->
	</div>
</div>

<footer class="row">

	<!-- =================================== START OF FOOTER =================================== -->
	<div class="col-md-12">

		<?php
			// ------------------------- "Footer" CONTAINER EMBEDDED HERE --------------------------
			widget_container( 'footer', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start' => '<div class="evo_container $wico_class$">',
					'container_end'   => '</div><div class="clearfix"></div>',
					'block_start'     => '<div class="evo_widget $wi_class$">',
					'block_end'       => '</div>',
				) );
			// ----------------------------- END OF "Footer" CONTAINER -----------------------------
		?>

		<p class="center">
			<?php
				// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
						'before' => '',
						'after'  => ' &bull; ',
					) );
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

<?php if ( $Skin->get_setting( 'backtotop_vis' ) == true ) { ?>
	<a href="#" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
<?php } ?>

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>