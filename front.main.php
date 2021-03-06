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
			<ul class="navbar-nav evo_container evo_container__menu">
			
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
					skin_container( NT_('Menu'), array(
							// The following params will be used as defaults for widgets included in this container:
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
							// Search
							'search_input_before'  => '<div class="input-group">',
							'search_input_after'   => '',
							'search_submit_before' => '<span class="input-group-btn">',
							'search_submit_after'  => '</span></div>',
						) );
					// ----------------------------- END OF "Menu" CONTAINER -----------------------------
				?>
			</ul>
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

<header class="row">

	<div class="<?php
					if ($Skin->get_setting('layout_front') != 'left_sidebar' &&
					    $Skin->get_setting('layout_front') != 'right_sidebar') {
						echo $Skin->get_column_class_front();
					} else {
						echo 'col-lg-12';
					} ?>">
		
		<div class="evo_container evo_container__header center">
		<?php
			
			// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
			messages( array(
					'block_start' => '<div class="action_messages">',
					'block_end'   => '</div>',
				) );
			// --------------------------------- END OF MESSAGES ---------------------------------
				
			// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			skin_container( NT_('Header'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'       => '<div class="evo_widget $wi_class$">',
					'block_end'         => '</div>',
					'block_title_start' => '<h1>',
					'block_title_end'   => '</h1>',
					// Search
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
				) );
			// ----------------------------- END OF "Header" CONTAINER -----------------------------
		?>
		</div>
		
		<?php 
		if ( $Skin->get_setting( 'fr_sec_enable' ) == true )
		{ // Check if enabled Front page special section in the back-office
			// ---------------------- FRONT PAGE EXTRA INTRO SECTION ------------------------
			echo '<div class="front-page-extra-section">';
			
				// Textfield
				echo $Skin->get_setting( 'fr_sec_txt' );
				
				if ($Skin->get_setting( 'frsec_but_enable' ) == true )
				{ // If button is enabled, show with default settings
					echo '<div class="extra-section-btn-wrapper"><a href="' . $Skin->get_setting( 'fr_sec_btn_link' ) . '">
						' . $Skin->get_setting( 'fr_sec_btn_txt' ) . '
					</a></div>';
				}
				
			echo '</div>';
			// ---------------------- FRONT PAGE EXTRA INTRO SECTION ------------------------
		}
		?>
		
	</div><!-- .col -->

</header><!-- .row -->

<div class="row">

	<div class="<?php echo $Skin->get_column_class_front(); ?>">

		<main><!-- This is were a link like "Jump to main content" would land -->

		<!-- ================================= START OF MAIN AREA ================================== -->

		<?php
		if( ! in_array( $disp, array( 'login', 'lostpassword', 'register', 'activateinfo', 'access_requires_login' ) ) && $Skin->get_setting( 'fr_sec_enable' ) == false )
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
					'title_before'      => '<h2>',
					'title_after'       => '</h2>',
					'title_none'        => '',
					'glue'              => ' - ',
					'title_single_disp' => false,
					'title_page_disp'   => false,
					'format'            => 'htmlbody',
					'register_text'     => '',
					'login_text'        => '',
					'lostpassword_text' => '',
					'account_activation' => '',
					'msgform_text'      => '',
					'user_text'         => '',
					'users_text'        => '',
					'display_edit_links'=> false,
					'catdir_text' => T_('Categories'),
					'arcdir_text' => T_('Archives'),
				) );
			// ----------------------------- END OF REQUEST TITLE ----------------------------
		?>

		<?php
		// Go Grab the featured post:
		if( ! in_array( $disp, array( 'single', 'page' ) ) && $Item = & get_featured_Item() )
		{ // We have a featured/intro post to display:
			// ---------------------- ITEM BLOCK INCLUDED HERE ------------------------
			skin_include( '_item_block.inc.php', array(
					'feature_block' => true,
					'content_mode' => 'full', // We want regular "full" content, even in category browsing: i-e no excerpt or thumbnail
					'intro_mode'   => 'normal',	// Intro posts will be displayed in normal mode
					'item_class'   => ($Item->is_intro() ? 'evo_intro_post' : 'evo_featured_post'),
				) );
			// ----------------------------END ITEM BLOCK  ----------------------------
		}
		?>

		<?php
			// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
			skin_include( '$disp$', array(
					'author_link_text' => 'preferredname',
					// Profile tabs to switch between user edit forms
					'profile_tabs' => array(
						'block_start'         => '<nav><ul class="nav nav-tabs profile_tabs">',
						'item_start'          => '<li>',
						'item_end'            => '</li>',
						'item_selected_start' => '<li class="active">',
						'item_selected_end'   => '</li>',
						'block_end'           => '</ul></nav>',
					),
					// Pagination
					'pagination' => array(
						'block_start'           => '<div class="center"><ul class="pagination">',
						'block_end'             => '</ul></div>',
						'page_current_template' => '<span>$page_num$</span>',
						'page_item_before'      => '<li>',
						'page_item_after'       => '</li>',
						'page_item_current_before' => '<li class="active">',
						'page_item_current_after'  => '</li>',
						'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
						'next_text'             => '<i class="fa fa-angle-double-right"></i>',
					),
					// Form params for the forms below: login, register, lostpassword, activateinfo and msgform
					'skin_form_before'      => '<div class="panel panel-default skin-form">'
																				.'<div class="panel-heading">'
																					.'<h3 class="panel-title">$form_title$</h3>'
																				.'</div>'
																				.'<div class="panel-body">',
					'skin_form_after'       => '</div></div>',
					// Login
					'display_form_messages' => true,
					'form_title_login'      => T_('Log in to your account').'$form_links$',
					'form_title_lostpass'   => get_request_title().'$form_links$',
					'lostpass_page_class'   => 'evo_panel__lostpass',
					'login_form_inskin'     => false,
					'login_page_class'      => 'evo_panel__login',
					'login_page_before'     => '<div class="$form_class$">',
					'login_page_after'      => '</div>',
					'display_reg_link'      => true,
					'abort_link_position'   => 'form_title',
					'abort_link_text'       => '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
					// Register
					'register_page_before'      => '<div class="evo_panel__register">',
					'register_page_after'       => '</div>',
					'register_form_title'       => T_('Register'),
					'register_links_attrs'      => '',
					'register_use_placeholders' => true,
					'register_field_width'      => 252,
					'register_disabled_page_before' => '<div class="evo_panel__register register-disabled">',
					'register_disabled_page_after'  => '</div>',
					// Activate form
					'activate_form_title'  => T_('Account activation'),
					'activate_page_before' => '<div class="evo_panel__activation">',
					'activate_page_after'  => '</div>',
					// Search
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
					// Front page
					'featured_intro_before' => '<div class="intro_background_image"></div>',
					'featured_intro_after'  => '',
					// Form "Sending a message"
					'msgform_form_title' => T_('Sending a message'),
				) );
			// Note: you can customize any of the sub templates included here by
			// copying the matching php file into your skin directory.
			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
		?>
		</main>

	</div><!-- .col -->


	<?php
	if( $Skin->is_visible_sidebar_front() )
	{ // Display sidebar:
	?>
	<aside class="col-md-4<?php echo ( $Skin->get_setting( 'layout_front' ) == 'left_sidebar' ? ' pull-left' : '' ); ?>">
		<!-- =================================== START OF SIDEBAR =================================== -->
		<div class="evo_container evo_container__sidebar">
		<?php
			// ------------------------- "Sidebar" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			skin_container( NT_('Sidebar'), array(
					// The following (optional) params will be used as defaults for widgets included in this container:
					// This will enclose each widget in a block:
					'block_start' => '<div class="evo_widget $wi_class$">',
					'block_end' => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<div><h4 class="panel-title">',
					'block_title_end' => '</h4></div>',
					// This will enclose the body of each widget:
					'block_body_start' => '<div>',
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
		?>
		</div>

		<?php if ( $Skin->get_setting( 'sidebar2_single' ) == false ) { ?>
		<div class="evo_container evo_container__sidebar2">
		<?php
			// ------------------------- "Sidebar" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			skin_container( NT_('Sidebar 2'), array(
					// The following (optional) params will be used as defaults for widgets included in this container:
					// This will enclose each widget in a block:
					'block_start' => '<div class="evo_widget $wi_class$">',
					'block_end' => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<div><h4 class="panel-title">',
					'block_title_end' => '</h4></div>',
					// This will enclose the body of each widget:
					'block_body_start' => '<div>',
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
		?>
		</div>
		<?php } // if Sidebar2 Single option not selected ?>
	</aside><!-- .col -->
	<?php } // if visible sidebar ?>

</div><!-- .row -->


<footer class="row">

	<!-- =================================== START OF FOOTER =================================== -->
	<div class="col-md-12">

		<div class="evo_container evo_container__footer">
		<?php
			// Display container and contents:
			skin_container( NT_("Footer"), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'       => '<div class="evo_widget $wi_class$">',
					'block_end'         => '</div>',
					// Search
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
				) );
			// Note: Double quotes have been used around "Footer" only for test purposes.
		?>
		</div>

		<div class="clearfix"></div>
		
		<p class="center small">
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
			
			<?php 
				// Please help us promote b2evolution and leave this note:
				if ($Skin->get_setting('b2evo_credits')) {
					echo '| Powered by <a href="http://www.b2evolution.net">b2evolution CMS</a>.';
				}
			?>
		</p>
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