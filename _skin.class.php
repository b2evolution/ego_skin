<?php
/**
 * This file implements a class derived of the generic Skin class in order to provide custom code for
 * the skin in this folder.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @package skins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Specific code for this skin.
 *
 * ATTENTION: if you make a new skin you have to change the class name below accordingly
 */
class ego_Skin extends Skin
{	
	var $version = '1.0.0';
	/**
	 * Do we want to use style.min.css instead of style.css ?
	 */
	var $use_min_css = 'check';  // true|false|'check' Set this to true for better optimization
	// Note: we leave this on "check" in the bootstrap_blog_skin so it's easier for beginners to just delete the .min.css file
	// But for best performance, you should set it to true.

	/**
	 * Get default name for the skin.
	 * Note: the admin can customize it.
	 */
	function get_default_name()
	{
		return 'Ego Skin';
	}


	/**
	 * Get default type for the skin.
	 */
	function get_default_type()
	{
		return 'rwd';
	}


	/**
	 * What evoSkins API does has this skin been designed with?
	 *
	 * This determines where we get the fallback templates from (skins_fallback_v*)
	 * (allows to use new markup in new b2evolution versions)
	 */
	function get_api_version()
	{
		return 6;
	}

	
	/**
	 * Get supported collection kinds.
	 *
	 * This should be overloaded in skins.
	 *
	 * For each kind the answer could be:
	 * - 'yes' : this skin does support that collection kind (the result will be was is expected)
	 * - 'partial' : this skin is not a primary choice for this collection kind (but still produces an output that makes sense)
	 * - 'maybe' : this skin has not been tested with this collection kind
	 * - 'no' : this skin does not support that collection kind (the result would not be what is expected)
	 * There may be more possible answers in the future...
	 */
	public function get_supported_coll_kinds()
	{
		$supported_kinds = array(
				'main' => 'yes',
				'std' => 'yes',		// Blog
				'photo' => 'yes',
				'forum' => 'no',
				'manual' => 'partial',
				'group' => 'maybe',  // Tracker
				// Any kind that is not listed should be considered as "maybe" supported
			);
		return $supported_kinds;
	}


	/**
	 * Get the container codes of the skin main containers
	 *
	 * This should NOT be protected. It should be used INSTEAD of file parsing.
	 * File parsing should only be used if this function is not defined
	 *
	 * @return array
	 */
	function get_declared_containers()
	{
		// Note: second param below is the ORDER
		return array(
				'header'                    => array( NT_('Header'), 10 ),
				'menu'                      => array( NT_('Menu'), 15 ),
				'front_page_main_area'      => array( NT_('Front Page Main Area'), 40 ),
				'item_single_header'        => array( NT_('Item Single Header'), 50 ),
				'item_single'               => array( NT_('Item Single'), 51 ),
				'item_page'                 => array( NT_('Item Page'), 55 ),
				'contact_page_main_area'    => array( NT_('Contact Page Main Area'), 60 ),
				'sidebar'                   => array( NT_('Sidebar'), 80 ),
				'sidebar_2'                 => array( NT_('Sidebar_2'), 81 ),
				'footer'                    => array( NT_('Footer'), 100 ),
				'user_profile_left'         => array( NT_('User Profile - Left'), 110 ),
				'user_profile_right'        => array( NT_('User Profile - Right'), 120 ),
				'404_page'                  => array( NT_('404 Page'), 130 ),
			);
	}


	/**
	 * Get definitions for editable params
	 *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 */
	function get_param_definitions( $params )
	{
		
		// Load to use function get_available_thumb_sizes()
		load_funcs( 'files/model/_image.funcs.php' );
		
		$r = array_merge( array(
				'section_layout_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('General Layout Settings')
				),
					'layout' => array(
						'label' => T_('Default Pages Layout'),
						'note' => T_('Select general skin layout.'),
						'defaultvalue' => 'right_sidebar',
						'options' => array(
							'single_column'              => T_('Single Column Large'),
							'single_column_normal'       => T_('Single Column'),
							'single_column_narrow'       => T_('Single Column Narrow'),
							'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
							'left_sidebar'               => T_('Left Sidebar'),
							'right_sidebar'              => T_('Right Sidebar'),
						),
						'type' => 'select',
					),
					'max_image_height' => array(
						'label' => T_('Max image height'),
						'note' => 'px. ' . T_('Set maximum height for post images.'),
						'defaultvalue' => '',
						'type' => 'integer',
						'allow_empty' => true,
						'size' => '7',
					),
					'links_color' => array(
						'label'        => T_('Links Color Schemes'),
						'note'         => T_('Default links color schemes is') . ' #096. ' . T_('This color is used for links, buttons, hover and active classes.'),
						'defaultvalue' => '#096',
						'type'         => 'color',
					),
					'site_bg_color' => array(
						'label'         => T_('Color scheme supporting color'),
						'note'          => T_('Default supporting color is') . ' #fff. ' . T_('This color appears as the second color scheme combination and is used as a supporting color for links and page sections.'),
						'defaultvalue'  => '#fff',
						'type'          => 'color',
					),
					'site_borders' => array(
						'label'         => T_('Color scheme second supporting color'),
						'note'          => T_('Default color is') . ' #eee. ' . T_('This color is used as a third color used for the custom site color scheme. It is mostly used for borders on elements.'),
						'defaultvalue'  => '#eee',
						'type'          => 'color',
					),
					'title_logo_w' => array(
						'label' => T_('Display logo/title'),
						'note' => T_('Decide whether you want to display blog title, logo or neither of both.'),
						'defaultvalue' => 'display_logo',
						'options' => array(
							'display_logo'   => T_('Display logo'),
							'display_title'  => T_('Display title'),
							'none'      	 => T_('None'),
						),
						'type' => 'select',
					),
					'logo_w_path' => array(
						'label'          => T_('Logo path'),
						'note'           => T_('Works only if "Display logo" selected above. Please use logo from within the skin folder.'),
						'defaultvalue'   => 'logo.png',
						'type'           => 'text',
						'size'           => '25',
					),
					'backtotop_vis' => array(
						'label' => T_('"Back to Top" button'),
						'note' => T_('Check to enable the "Back to Top" button.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_layout_end' => array(
					'layout' => 'end_fieldset',
				),


				// Navigation links
				'nav_links_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Navigation Menu Settings')
				),
					'menu_bg_color' => array(
						'label'         => T_('Navigation background color'),
						'note'          => T_('Default color is.') . ' #fff.',
						'defaultvalue'  => '#fff',
						'type'          => 'color',
					),
					'menu_a_color' => array(
						'label'         => T_('Navigation links color'),
						'note'          => T_('Default color is.') . ' #333.',
						'defaultvalue'  => '#333',
						'type'          => 'color',
					),
					'nav_search' => array(
						'label' => T_('Navigation Search Field'),
						'note' => T_('Check to enable a skin-specific search field in navigation menu.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'nav_social' => array(
						'label' => T_('Navigation Social Links'),
						'note' => T_('Check to enable a special social links widget in the navigation.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'nav_hamb_menu' => array(
						'label'          => T_('Hamburger menu at'),
						'note'           => T_('px. Set the width in pixels below which menu will have hamburger layout.'),
						'defaultvalue'   => '820',
						'type'           => 'integer',
						'size'           => '7',
					),
				'nav_links_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'front_disp_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Front Page Settings')
				),
					// Front Disp layout
					'layout_front' => array(
						'label' => T_('Front Page Layout'),
						'note' => T_('Select front page layout.'),
						'defaultvalue' => 'single_column_narrow',
						'options' => array(
							'single_column'              => T_('Single Column Large'),
							'single_column_normal'       => T_('Single Column'),
							'single_column_narrow'       => T_('Single Column Narrow'),
							'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
							'left_sidebar'               => T_('Left Sidebar'),
							'right_sidebar'              => T_('Right Sidebar'),
						),
						'type' => 'select',
					),
					'fr_sec_enable' => array(
						'label' => T_('Enable front page intro section'),
						'note' => T_('Check this to show a special intro section on disp=front of this skin.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'fr_sec_txt' => array(
						'label' => T_('Intro text'),
						'note' => T_('This is the introduction text that will appear in the disp=front. Type text or code in this field.'),
						'defaultvalue' => "
Welcome to Ego skin.&nbsp;Built specially for <a href='http://b2evolution.net/'>b2evolution</a>.&nbsp;Set the button destination in the back-office:",
						'type' => 'textarea',
					),
					'frsec_but_enable' => array(
						'label' => T_('Enable section button'),
						'note' => T_('Check this to enable the linking button in this section.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'fr_sec_btn_link' => array(
						'label' => T_('Link URL'),
						'note' => T_('Type the link destination (URL) you want this button to lead on. It can be any page, even external.'),
						'defaultvalue' => "http://b2evolution.net/",
						'type' => 'text',
						'size' => 50,
					),
					'fr_sec_btn_txt' => array(
						'label' => T_('Link title'),
						'note' => T_('Type the title of the link.'),
						'defaultvalue' => 'Link title',
						'type' => 'text',
						'size' => 20,
					),
				'front_disp_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'posts_disp_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Posts Page Settings')
				),
					// Posts Disp layout
					'layout_posts' => array(
						'label' => T_('Posts Page Layout'),
						'note' => T_('Select posts page layout.'),
						'defaultvalue' => 'right_sidebar',
						'options' => array(
							'single_column'              => T_('Single Column Large'),
							'single_column_normal'       => T_('Single Column'),
							'single_column_narrow'       => T_('Single Column Narrow'),
							'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
							'left_sidebar'               => T_('Left Sidebar'),
							'right_sidebar'              => T_('Right Sidebar'),
						),
						'type' => 'select',
					),
				   'posts_format' => array(
						'label'    => T_('Posts Format'),
						'note'     => '(' . T_('Select posts format on posts page.') . ')',
						'type'     => 'radio',
						'options'  => array(
							array( 'default', T_('Default') ),
							array( 'simple', T_('Simple') ),
							array( 'masonry', T_('Masonry') ),
						),
						'defaultvalue' => 'default',
				   ),
				   'posts_masonry' => array(
						'label'    => T_('Number of columns'),
						'note'     => '(' . T_('Select the number of columns if Masonry post format is selected above') . ')',
						'type'     => 'radio',
						'options'  => array(
							array( 'one', T_('1 Column') ),
							array( 'two', T_('2 Columns') ),
							array( 'three', T_('3 Columns') ),
						),
						'defaultvalue' => 'one',
				   ),
					// Top pagination
					'top_pagination' => array(
						'label' => T_('Enable top pagination'),
						'note' => T_('Check this to enable top page pagination.'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					// Bottom pagination
					'bottom_pagination' => array(
						'label' => T_('Enable bottom pagination'),
						'note' => T_('Check this to enable bottom page pagination.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'pag_alignment' => array(
						'label'        => T_('Pagination Alignment'),
						'note'         => T_('Select pagination alignment on posts page.'),
						'type'         => 'select',
						'options'      => array(
							'left'   => T_('Left'),
							'center' => T_('Center'),
							'right'  => T_('Right'),
						),
					'defaultvalue' => 'left',
               ),
				'posts_disp_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'single_disp_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Single Page Settings')
				),
					// Single Disp layout
					'layout_single' => array(
						'label' => T_('Single Page Layout'),
						'note' => T_('Select single page layout.'),
						'defaultvalue' => 'right_sidebar',
						'options' => array(
							'single_column'              => T_('Single Column Large'),
							'single_column_normal'       => T_('Single Column'),
							'single_column_narrow'       => T_('Single Column Narrow'),
							'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
							'left_sidebar'               => T_('Left Sidebar'),
							'right_sidebar'              => T_('Right Sidebar'),
						),
						'type' => 'select',
					),
					// Sidebar 2 Container Only
					'sidebar2_single' => array(
						'label' => T_('Sidebar2 on Single Page'),
						'note' => T_('Check this to enable Sidebar2 container only on single pages. On other pages regular Sidebar container will be shown.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'cover_image_start' => array(
						'layout' => 'begin_fieldset',
						'label'  => T_('Cover Image Settings')
					),
						// Intro Post layout
						'spec_cover_image' => array(
							'label' => T_('Special Cover Image Position'),
							'note' => T_('Check this to enable a special cover image placement.'),
							'defaultvalue' => 1,
							'type' => 'checkbox',
						),
						'cover_text' => array(
							'label'         => T_('Cover section text color'),
							'note'          => T_('Default color is') . ' #fefefe.',
							'defaultvalue'  => '#fefefe',
							'type'          => 'color',
						),
						'cover_links' => array(
							'label'         => T_('Cover section links color'),
							'note'          => T_('Default color is') . ' #fefefe.',
							'defaultvalue'  => '#fefefe',
							'type'          => 'color',
						),
						'cover_borders' => array(
							'label'         => T_('Cover section borders color'),
							'note'          => T_('Default color is') . ' #fefefe.',
							'defaultvalue'  => '#fefefe',
							'type'          => 'color',
						),
					'cover_image_end' => array(
						'layout' => 'end_fieldset',
					),
				'single_disp_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				// Mediaidx disp customizations
				'mediaidx_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Media Page Settings')
				),
				   'mediaidx_thumb_size' => array(
						'label'        => T_('Thumbnail size'),
						'note'         => T_('Thumbnail size for Media index page.'),
						'defaultvalue' => 'crop-480x320',
						'options'      => get_available_thumb_sizes(),
						'type'         => 'select',
					),
				   'mediaidx_masonry' => array(
						'label'    => T_('Masonry Columns'),
						'note'     => '(' . T_('Select the number of columns for displaying media items') . ')',
						'type'     => 'radio',
						'options'  => array(
							array( 'one', T_('1 Column') ),
							array( 'two', T_('2 Columns') ),
							array( 'three', T_('3 Columns') ),
						),
						'defaultvalue' => 'three',
				   ),
				'mediaidx_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				// Catdir disp customizations
				'catdir_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Category Page Settings')
				),
					'catdir_layout' => array(
						'label'    => T_('Category Page Layout'),
						'note'     => '(' . T_('Select the number of columns for displaying media items') . ')',
						'type'     => 'radio',
						'options'  => array(
							array( 'catdir_list', T_('List') ),
							array( 'catdir_masonry', T_('Masonry') ),
						),
						'defaultvalue' => 'catdir_list',
					),
				   'catdir_masonry_cols' => array(
						'label'    => T_('Masonry Columns'),
						'note'     => '(' . T_('Select the number of columns for displaying media items') . ')',
						'type'     => 'radio',
						'options'  => array(
							array( 'one', T_('1 Column') ),
							array( 'two', T_('2 Columns') ),
							array( 'three', T_('3 Columns') ),
						),
						'defaultvalue' => 'two',
				   ),
				   'catdir_thumb_size' => array(
						'label'        => T_('Thumbnail size'),
						'note'         => T_('Use this only if Masonry layout is enabled.'),
						'defaultvalue' => 'crop-480x320',
						'options'      => get_available_thumb_sizes(),
						'type'         => 'select',
					),
				'catdir_end' => array(
					'layout' => 'end_fieldset',
				),


				// Footer layout customzation
				'footer_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Footer Settings')
				),
					'b2evo_credits' => array(
						'label' => T_('b2evolution credits'),
						'note' => T_('Please help us promote b2evolution and leave b2evolution credits on your website.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'spec_sw_footer' => array(
						'label'         => T_('Special sitewide footer'),
						'note'          => T_('Check to enable the special sitewide footer (cookies declaration) layout.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'sp_sw_f_bg_col' => array(
						'label'         => T_('SW Footer background color'),
						'note'          => T_('Set the background color of the special sitewide footer section.'),
						'defaultvalue'  => '#333',
						'type'          => 'color',
					),
					'sp_sw_f_col' => array(
						'label'         => T_('SW Footer color'),
						'note'          => T_('Set the color of the special sitewide footer section.'),
						'defaultvalue'  => '#fff',
						'type'          => 'color',
					),
				'footer_end' => array(
					'layout' => 'end_fieldset',
				),
				

				'section_colorbox_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Colorbox Image Zoom')
				),
					'colorbox' => array(
						'label' => T_('Colorbox Image Zoom'),
						'note' => T_('Check to enable javascript zooming on images (using the colorbox script)'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_post' => array(
						'label' => T_('Voting on Post Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_post_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_comment' => array(
						'label' => T_('Voting on Comment Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_comment_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_user' => array(
						'label' => T_('Voting on User Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_user_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_colorbox_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_username_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Username Settings')
				),
					'gender_colored' => array(
						'label' => T_('Display gender'),
						'note' => T_('Use colored usernames to differentiate men & women.'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					'bubbletip' => array(
						'label' => T_('Username bubble tips'),
						'note' => T_('Check to enable bubble tips on usernames'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					'autocomplete_usernames' => array(
						'label' => T_('Autocomplete usernames'),
						'note' => T_('Check to enable auto-completion of usernames entered after a "@" sign in the comment forms'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_username_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_access_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('When access is denied or requires login...')
				),
					'access_login_containers' => array(
						'label' => T_('Display on login screen'),
						'note' => '',
						'type' => 'checklist',
						'options' => array(
							array( 'menu',     sprintf( T_('"%s" container'), NT_('Menu') ),      1 ),
							array( 'sidebar',  sprintf( T_('"%s" container'), NT_('Sidebar') ),   1 ),
							array( 'sidebar2', sprintf( T_('"%s" container'), NT_('Sidebar 2') ), 1 ),
							array( 'footer',   sprintf( T_('"%s" container'), NT_('Footer') ),    1 ) ),
						),
				'section_access_end' => array(
					'layout' => 'end_fieldset',
				),

			), parent::get_param_definitions( $params ) );

		return $r;
	}


	/**
	 * Get ready for displaying the skin.
	 *
	 * This may register some CSS or JS...
	 */
	function display_init()
	{
		global $Messages, $debug, $disp;

		// Request some common features that the parent function (Skin::display_init()) knows how to provide:
		parent::display_init( array(
				'jquery',                  // Load jQuery
				'font_awesome',            // Load Font Awesome (and use its icons as a priority over the Bootstrap glyphicons)
				'bootstrap',               // Load Bootstrap (without 'bootstrap_theme_css')
				'bootstrap_evo_css',       // Load the b2evo_base styles for Bootstrap (instead of the old b2evo_base styles)
				'bootstrap_messages',      // Initialize $Messages Class to use Bootstrap styles
				'style_css',               // Load the style.css file of the current skin
				'colorbox',                // Load Colorbox (a lightweight Lightbox alternative + customizations for b2evo)
				'bootstrap_init_tooltips', // Inline JS to init Bootstrap tooltips (E.g. on comment form for allowed file extensions)
				'disp_auto',               // Automatically include additional CSS and/or JS required by certain disps (replace with 'disp_off' to disable this)
			) );
			
		// Skin specific initializations:
		require_js( 'js/scripts.js', 'relative' );
		
		// Include Masonry Grind for Posts and Mediaidx disps
		if ( in_array ( $disp, array( 'posts', 'mediaidx', 'catdir' ) ) ) {
			require_js( 'js/masonry.pkgd.min.js', 'relative' );
			require_js( 'js/imagesloaded.pkgd.min.js', 'relative' );
			add_js_headline("
				jQuery( document ).ready( function($) {
					$( '.grid' ).imagesLoaded().done( function( instance ) {
						$( '.grid' ).masonry(
						{
							// options
							itemSelector: '.grid-item',
						});
					});
				});
			");
		}
		

		// Limit images by max height:
		$max_image_height = intval( $this->get_setting( 'max_image_height' ) );
		if( $max_image_height > 0 )
		{
			add_css_headline( '.evo_image_block img { max-height: '.$max_image_height.'px; width: auto }' );
		}
		
		// Add custom CSS:
		$custom_css = '';
			
	
			/**
			* ============================================================================
			* General Customization
			* ============================================================================
			*/
			if ( $links_color = $this->get_setting( 'links_color' ) ) {
				$custom_css .= '.container.main-page-content a,
				#submit_preview_buttons_wrapper .preview, #submit_preview_buttons_wrapper .submit:hover,
				.filter-submit,
				.disp_login .control-buttons input.btn-success, .disp_login .control-buttons a.btn-primary:hover,
				.disp_lostpassword .control-buttons input.btn-primary:hover,
				.disp_register .control-buttons input.btn-primary:hover,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn,
				.disp_msgform main .comment-form input.submit:hover,
				.navbar-brand h3 a,
				.disp_access_denied .control-buttons input.btn-success,
				.disp_access_requires_login .control-buttons input.btn-success, .disp_access_requires_login .control-buttons a.btn-primary:hover,
				.disp_threads.detail_msgform main .comment-form .btn-info, .disp_threads.detail_msgform main .comment-form .btn-primary:hover,
				.widget_core_org_members a.user_link:hover,
				.widget_core_coll_subscription .btn:hover
				{ color: '. $links_color ." }\n";
				
				$custom_css .= '
				.widget_core_coll_category_list ul li a:hover,
				.evo_post__categories a:hover,
				.evo_post__full .evo_post__full_text .evo_post_more_link a,
				#submit_preview_buttons_wrapper .preview:hover,
				.results .fieldset_title .action_icon:hover,
				.filter-submit:hover, .form_add_contacts .SaveButton,
				.disp_login .control-buttons input.btn-success:hover, .disp_login .control-buttons a.btn-primary,
				.disp_lostpassword .control-buttons input.btn-primary,
				.disp_register .control-buttons input.btn-primary,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn:hover,
				.disp_threads.detail_msgform main .comment-form input.submit,
				.disp_access_requires_login .control-buttons input.btn-success:hover, .disp_access_requires_login .control-buttons a.btn-primary,
				.disp_threads.detail_msgform main .comment-form .btn-info:hover, .disp_threads.detail_msgform main .comment-form .btn-primary
				{ border: 1px solid '. $links_color ." }\n";
				
				$custom_css .= '
				div.compact_search_form .search_submit,
				.extra-section-btn-wrapper a:hover,
				.navbar-nav.evo_container__menu .ufld_icon_links:hover:before,
				.evo_post__full .evo_post__full_text .evo_post_more_link a:hover,
				.pagination>.active>a, .pagination>.active>a:hover,	.pagination>li>a:hover,	.pagination>.active>span, .pagination>.active>span:hover,
				.back-to-top,
				#submit_preview_buttons_wrapper .submit,
				.evo_comment__meta_info .badge-meta,
				.results .fieldset_title .action_icon:hover,
				.filter-submit:hover,
				.form_add_contacts .SaveButton, .disp_contacts .filter-submit:hover,
				.disp_login .control-buttons a.btn-primary,
				.disp_lostpassword .control-buttons input.btn-primary,
				.disp_access_requires_login .control-buttons a.btn-primary,
				.disp_register .control-buttons input.btn-primary,
				.search_result_score,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn:hover,
				.disp_threads.detail_msgform main .comment-form input.submit,
				.header-social-toggle .ufld_icon_links:hover:before,
				.disp_threads.detail_msgform main .comment-form .btn-primary,
				.widget_core_coll_subscription .btn,
				.disp_msgform main .comment-form input.submit
				{ background-color: '. $links_color ." }\n";
				
				$custom_css .= '
				div.compact_search_form .search_submit,
				.extra-section-btn-wrapper a,
				p.tag_cloud a:hover,
				.pagination>.active>span, .pagination>.active>span:hover,
				.pagination>.active>a,
				.pagination>li>a:hover,
				#submit_preview_buttons_wrapper .submit,
				.form_add_contacts .SaveButton,
				div.controls input:focus, div.form-control input:focus, textarea.form-control:focus, #login_form input:focus:invalid:focus, #login_form select:focus:invalid:focus, #login_form textarea:focus:invalid:focus,
				.widget_core_coll_subscription .btn
				{ border-color: '. $links_color ." }\n";
				
				$custom_css .= '.evo_featured_post { border-left: 5px solid '. $links_color ." }\n";
				
				// Fix for Gender colors settings
				if ( $this->get_setting( 'gender_colored' ) == true ) {
					$custom_css .= '.container.main-page-content a.user.man { color: #00F'." }\n";
					$custom_css .= '.container.main-page-content a.user.woman { color: #e100af'." }\n";
				}
			}
			
			if ( $site_bg_color = $this->get_setting( 'site_bg_color' ) ) {
				$custom_css .= '
				.disp_contacts .filter-submit,
				.disp_login .control-buttons input.btn-success, .disp_login .control-buttons a.btn-primary:hover,
				.disp_lostpassword .control-buttons input.btn-primary:hover,
				.disp_access_requires_login .control-buttons input.btn-success, .disp_access_requires_login .control-buttons a.btn-primary:hover,
				.disp_register .control-buttons input.btn-primary:hover,
				.disp_msgform main .comment-form input.submit:hover,
				.navbar-header .ufld_icon_links a, .navbar-nav .ufld_icon_links a,
				.disp_threads.detail_msgform main .comment-form .btn-primary:hover, .disp_threads.detail_msgform main .comment-form .btn-info,
				.widget_core_coll_subscription .btn:hover
				{ background-color: '. $site_bg_color ." }\n";
				
				$custom_css .= '
				.extra-section-btn-wrapper a:hover,
				.evo_post__full .evo_post__full_text .evo_post_more_link a:hover,
				.pagination>li>a:hover, .pagination>.active>a, .pagination>.active>a:hover,
				.back-to-top, .back-to-top:hover, .back-to-top:active, .back-to-top:focus, .back-to-top:visited,
				.results .fieldset_title .action_icon:hover, .filter-submit:hover,
				.form_add_contacts .SaveButton,
				.disp_login .control-buttons a.btn-primary,
				.disp_lostpassword .control-buttons input.btn-primary,
				.disp_register .control-buttons input.btn-primary,
				.disp_access_requires_login .control-buttons a.btn-primary,
				.search_result_score,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn:hover,
				.disp_msgform main .comment-form input.submit,
				#submit_preview_buttons_wrapper .submit
				{ color: '. $site_bg_color ." }\n";
			}
			
			if ( $site_borders = $this->get_setting( 'site_borders' ) ) {
				$custom_css .= '
				nav.navbar,
				.evo_widget h3, .evo_widget h4.panel-title,
				.widget_core_coll_post_list ul li,
				.widget_core_coll_comment_list ul li,
				.widget_core_coll_featured_posts ul li,
				.widget_core_coll_page_list ul li,
				.widget_core_coll_related_post_list ul li,
				.widget_core_coll_item_list ul li, .widget_core_coll_item_list ul li ul li,
				.widget_core_coll_xml_feeds ul li, .widget_core_coll_xml_feeds div.notes,
				.widget_core_content_hierarchy ul li,
				.compact_search_form input.search_field,
				.widget_plugin_evo_Arch ul li, .arcdir_list_wrapper ul li,
				.disp_user .profile_content .profile_column_right fieldset.fieldset legend.panel-title
				{ border-bottom: 1px solid '. $site_borders ." }\n";
				
				$custom_css .= 'nav.navbar div.ufld_icon_links a,
				.navbar-nav.evo_container__menu .ufld_icon_links:before,
				.header-search-toggle,
				.navbar-toggle-hamb,
				.header-social-toggle .ufld_icon_links:before
				{ border-left: 1px solid '. $site_borders ." }\n";
				
				$custom_css .= '
				.widget_core_coll_category_list ul li a,
				.evo_post__categories a,
				#bCalendarToday,
				p.tag_cloud a,
				.pagination>li>a,
				#submit_preview_buttons_wrapper .preview,
				.evo_comment,
				.special_pager_layout li a,
				.results .fieldset_title .action_icon,
				.filter-submit,
				.disp_login .control-buttons input.btn-success
				{ border: 1px solid '. $site_borders ." }\n";
				
				$custom_css .= '
				.widget_plugin_evo_Calr .bCalendarTable th,
				.widget_plugin_evo_Calr .bCalendarTable td,
				.navbar-nav.evo_container__menu .ufld_icon_links a.drop-down-social, .header-social-toggle a
				{ border-right: 1px solid '. $site_borders .'; border-bottom: 1px solid '. $site_borders ." }\n";
				
				$custom_css .= '.widget_plugin_evo_Calr .bCalendarTable { border-left: 1px solid '. $site_borders .'; border-top: 1px solid '. $site_borders ." }\n";
				
				$custom_css .= '#bCalendarToday,
				.special_pager_layout li a:hover,
				.results .fieldset_title .action_icon,
				.filter-submit,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn,
				.disp_single .evo_comment__meta_info a:hover
				{ background-color: '. $site_borders ." }\n";
				
				$custom_css .= 'blockquote,
				.disp_user .profile_content .profile_column_left .profile_buttons a button.btn,
				.disp_usercomments .results table.table th, .disp_useritems .results table.table th,
				.disp_single .evo_comment__meta_info a,
				.disp_access_requires_login .control-buttons input.btn-success,
				.disp_threads.detail_msgform main .comment-form .btn-info
				{ border-color: '. $site_borders ." }\n";
				
				$custom_css .= '.evo_comment_avatar img { border: 3px solid '. $site_borders ." }\n";
				$custom_css .= '.comment-form--title { border-top: 3px solid '. $site_borders ." }\n";
				$custom_css .= '.disp_search .widget_core_coll_search_form .extended_search_form .search_field { border-bottom: 2px solid '. $site_borders ." }\n";
				$custom_css .= '.disp_msgform main .comment-form input.submit { border-color: '. $links_color ." }\n";
			}
		
		
			/**
			* ============================================================================
			* Menu Customization
			* ============================================================================
			*/
			if ( $menu_bg_color = $this->get_setting( 'menu_bg_color' ) ) {
				$custom_css .= '.collapse.navbar-collapse,
				.header-main-search-field .search_field,
				.ufld_icon_links a.drop-down-social,
				.navbar,
				.navbar-nav.evo_container__menu .ufld_icon_links a
				{ background-color: '. $menu_bg_color ." }\n";
			}
			
			if ( $menu_a_color = $this->get_setting( 'menu_a_color' ) ) {
				$custom_css .= '.evo_container__menu li a, .navbar-nav.evo_container__menu .ufld_icon_links a, .navbar-header .ufld_icon_links a { color: '. $menu_a_color ." }\n";
				$custom_css .= '.navbar-header span.icon-bar { background-color: '. $menu_a_color ." }\n";
			}
			
			if ( $nav_social = $this->get_setting( 'nav_social' ) == true ) {
				$custom_css .= '.menu-social-toggle { position: absolute '." }\n";
				if ( $nav_search = $this->get_setting( 'nav_search' ) == true ) {
					$custom_css .= '.menu-social-toggle { right: 54px '." }\n";
				} else {
					$custom_css .= '.menu-social-toggle { right: 0 '." }\n";
				}
			}
			
			if ( $nav_hamb_menu = $this->get_setting( 'nav_hamb_menu' ) ) {
				$custom_css .= '@media (max-width: '. $nav_hamb_menu ."px) {
				   .navbar-header {float: none;}.navbar-left,.navbar-right {float: none !important;}.navbar-toggle {display: block;}.navbar-collapse {border-top: 1px solid transparent;box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);}.navbar-fixed-top {top: 0;border-width: 0 0 1px;}.navbar-collapse.collapse {display: none!important}.navbar-nav {float: none!important;margin-top: 7.5px;overflow: hidden;}.navbar-nav>li {float: none;margin-left: 15px;}.navbar-nav>li>a {padding-top: 10px;padding-bottom: 10px;}.collapse.in{display:block !important;}.evo_container__menu .header-search-toggle{display: none}.header-search-toggle{position: relative !important}.menu-social-toggle{display: none}.navbar-collapse{border-top: 1px solid ". $site_borders ."}.navbar-nav.evo_container__menu li:last-child{margin-bottom: 17px;}
				}\n";
			}
			
			
			/**
			* ============================================================================
			* Single page `
			* ============================================================================
			*/
			if ( $cover_text = $this->get_setting( 'cover_text' ) ) {
				$custom_css .= '.spec_cover_image__header { color: '. $cover_text ." }\n";
				$custom_css .= '.spec_cover_image__header .evo_post__categories a:hover { border: 1px solid '. $cover_text ." }\n";
			}
			if ( $cover_links = $this->get_setting( 'cover_links' ) ) {
				$custom_css .= '.spec_cover_image__header a { color: '. $cover_links ." }\n";
			}
			if ( $cover_borders = $this->get_setting( 'cover_borders' ) ) {
				$custom_css .= '
				.spec_cover_image__header .evo_post__categories a
				{ border: 1px solid '. $cover_borders ." }\n";
			}
			
			
			/**
			* ============================================================================
			* Special sitewide footer layout
			* ============================================================================
			*/
			if ( $this->get_setting( 'spec_sw_footer' ) == true ) {
				// if special sitewide footer layout is enabled
				$custom_css .= 'footer.sitewide_footer { font-size: 14px; letter-spacing: 0.3px; font-family: "Droid Serif", serif; padding: 10px 0; border: none; box-shadow: none; '." }\n";

				if ( $sp_sw_f_bg_col = $this->get_setting( 'sp_sw_f_bg_col' ) ) {
					$custom_css .= 'footer.sitewide_footer { background-color: '. $sp_sw_f_bg_col ." }\n";
				}
				if ( $sp_sw_f_col = $this->get_setting( 'sp_sw_f_col' ) ) {
					$custom_css .= 'footer.sitewide_footer, footer.sitewide_footer a, footer.sitewide_footer a:hover { color: '. $sp_sw_f_col ." }\n";
				}
			}

	
			/**
			* ============================================================================
			* Sidebar widgets margin-top
			* ============================================================================
			*/
			if ( $this->get_setting( 'sidebar2_single' ) == false ) {
				// if Sidebar2 is NOT reserved for disp=single only, then:
				$custom_css .= '.evo_container__sidebar .evo_widget:nth-child(1) div > h4 { margin-top: 0 !important;'." }\n";
			} else {
				$custom_css .= '.evo_container__sidebar .evo_widget:nth-child(1) div > h4, .evo_container__sidebar_2 .evo_widget:nth-child(1) div > h4 { margin-top: 0 !important;'." }\n";
			}
			
			
			/**
			* ============================================================================
			* Positioned at the end of the file because of the hover style - preventing 
			* wrong style on non-hover color customization
			* ============================================================================
			*/
			if ( $links_color = $this->get_setting( 'links_color' ) ) {
				$custom_css .= '#submit_preview_buttons_wrapper .submit:hover { color: '. $links_color ." !important }\n";
			}
	
		
		if( ! empty( $custom_css ) )
		{ // Function for custom_css:
		$custom_css = '<style type="text/css">
<!--
'.$custom_css.'
-->
		</style>';
		add_headline( $custom_css );
		}			
	}


	/**
	 * Those templates are used for example by the messaging screens.
	 */
	function get_template( $name )
	{
		switch( $name )
		{
			case 'Results':
				// Results list (Used to view the lists of the users, messages, contacts and etc.):
				return array(
					'page_url' => '', // All generated links will refer to the current page
					'before' => '<div class="results">',
					'content_start' => '<div id="$prefix$ajax_content">',
					'header_start' => '',
						'header_text' => '<div class="center"><ul class="pagination">'
								.'$prev$$first$$list_prev$$list$$list_next$$last$$next$'
							.'</ul></div>',
						'header_text_single' => '',
					'header_end' => '',
					'head_title' => '<h2>$title$</h2><div class="fieldset_title"><div class="form-group">$global_icons$</div></div>'."\n",
					'global_icons_class' => 'btn btn-sm',
					'filters_start'        => '<div class="filters">',
					'filters_end'          => '</div>',
					'filter_button_class'  => 'btn-sm btn-info filter-submit',
					'filter_button_before' => '<div class="form-group floatright filter-button-wrapper">',
					'filter_button_after'  => '</div>',
					'messages_start' => '<div class="messages form-inline">',
					'messages_end' => '</div>',
					'messages_separator' => '<br />',
					'list_start' => '<div class="table_scroll">'."\n"
					               .'<table class="table table-condensed" cellspacing="0">'."\n",
						'head_start' => "<thead>\n",
							'line_start_head' => '<tr>',  // TODO: fusionner avec colhead_start_first; mettre a jour admin_UI_general; utiliser colspan="$headspan$"
							'colhead_start' => '<th $class_attrib$>',
							'colhead_start_first' => '<th class="firstcol $class$">',
							'colhead_start_last' => '<th class="lastcol $class$">',
							'colhead_end' => "</th>\n",
							'sort_asc_off' => get_icon( 'sort_asc_off' ),
							'sort_asc_on' => get_icon( 'sort_asc_on' ),
							'sort_desc_off' => get_icon( 'sort_desc_off' ),
							'sort_desc_on' => get_icon( 'sort_desc_on' ),
							'basic_sort_off' => '',
							'basic_sort_asc' => get_icon( 'ascending' ),
							'basic_sort_desc' => get_icon( 'descending' ),
						'head_end' => "</thead>\n\n",
						'tfoot_start' => "<tfoot>\n",
						'tfoot_end' => "</tfoot>\n\n",
						'body_start' => "<tbody>\n",
							'line_start' => '<tr class="even">'."\n",
							'line_start_odd' => '<tr class="odd">'."\n",
							'line_start_last' => '<tr class="even lastline">'."\n",
							'line_start_odd_last' => '<tr class="odd lastline">'."\n",
								'col_start' => '<td $class_attrib$>',
								'col_start_first' => '<td class="firstcol $class$">',
								'col_start_last' => '<td class="lastcol $class$">',
								'col_end' => "</td>\n",
							'line_end' => "</tr>\n\n",
							'grp_line_start' => '<tr class="group">'."\n",
							'grp_line_start_odd' => '<tr class="odd">'."\n",
							'grp_line_start_last' => '<tr class="lastline">'."\n",
							'grp_line_start_odd_last' => '<tr class="odd lastline">'."\n",
										'grp_col_start' => '<td $class_attrib$ $colspan_attrib$>',
										'grp_col_start_first' => '<td class="firstcol $class$" $colspan_attrib$>',
										'grp_col_start_last' => '<td class="lastcol $class$" $colspan_attrib$>',
								'grp_col_end' => "</td>\n",
							'grp_line_end' => "</tr>\n\n",
						'body_end' => "</tbody>\n\n",
						'total_line_start' => '<tr class="total">'."\n",
							'total_col_start' => '<td $class_attrib$>',
							'total_col_start_first' => '<td class="firstcol $class$">',
							'total_col_start_last' => '<td class="lastcol $class$">',
							'total_col_end' => "</td>\n",
						'total_line_end' => "</tr>\n\n",
					'list_end' => "</table></div>\n\n",
					'footer_start' => '',
					'footer_text' => '<div class="center"><ul class="pagination">'
							.'$prev$$first$$list_prev$$list$$list_next$$last$$next$'
						.'</ul></div><div class="center">$page_size$</div>'
					                  /* T_('Page $scroll_list$ out of $total_pages$   $prev$ | $next$<br />'. */
					                  /* '<strong>$total_pages$ Pages</strong> : $prev$ $list$ $next$' */
					                  /* .' <br />$first$  $list_prev$  $list$  $list_next$  $last$ :: $prev$ | $next$') */,
					'footer_text_single' => '<div class="center">$page_size$</div>',
					'footer_text_no_limit' => '', // Text if theres no LIMIT and therefor only one page anyway
						'page_current_template' => '<span>$page_num$</span>',
						'page_item_before' => '<li>',
						'page_item_after' => '</li>',
						'page_item_current_before' => '<li class="active">',
						'page_item_current_after'  => '</li>',
						'prev_text' => T_('Previous'),
						'next_text' => T_('Next'),
						'no_prev_text' => '',
						'no_next_text' => '',
						'list_prev_text' => T_('...'),
						'list_next_text' => T_('...'),
						'list_span' => 11,
						'scroll_list_range' => 5,
					'footer_end' => "\n\n",
					'no_results_start' => '<div class="panel-footer">'."\n",
					'no_results_end'   => '$no_results$</div>'."\n\n",
					'content_end' => '</div>',
					'after' => '</div>',
					'sort_type' => 'basic'
				);
				break;

			case 'blockspan_form':
				// Form settings for filter area:
				return array(
					'layout'         => 'blockspan',
					'formclass'      => 'form-inline',
					'formstart'      => '',
					'formend'        => '',
					'title_fmt'      => '$title$'."\n",
					'no_title_fmt'   => '',
					'fieldset_begin' => '<fieldset $fieldset_attribs$>'."\n"
																.'<legend $title_attribs$>$fieldset_title$</legend>'."\n",
					'fieldset_end'   => '</fieldset>'."\n",
					'fieldstart'     => '<div class="form-group form-group-sm" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => 'control-label',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label></label>',
					'inputstart'     => '',
					'inputend'       => "\n",
					'infostart'      => '<div class="form-control-static">',
					'infoend'        => "</div>\n",
					'buttonsstart'   => '<div class="form-group form-group-sm">',
					'buttonsend'     => "</div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'fieldstart_checkbox'    => '<div class="form-group form-group-sm checkbox" $ID$>'."\n",
					'fieldend_checkbox'      => "</div>\n\n",
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '',
					'inputend_checkbox'      => "\n",
					'checkbox_newline_start' => '',
					'checkbox_newline_end'   => "\n",
					// - radio
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '',
					'radio_newline_end'      => "\n",
					'radio_oneline_start'    => '',
					'radio_oneline_end'      => "\n",
				);

			case 'compact_form':
			case 'Form':
				// Default Form settings (Used for any form on front-office):
				return array(
					'layout'         => 'fieldset',
					'formclass'      => 'form-horizontal',
					'formstart'      => '<div class="comment-form">',
					'formend'        => '</div>',
					'title_fmt'      => '<span style="float:right">$global_icons$</span><h2>$title$</h2>'."\n",
					'no_title_fmt'   => '<span style="float:right">$global_icons$</span>'."\n",
					'fieldset_begin' => '<div class="fieldset_wrapper $class$" id="submit_preview_buttons_wrapper"><fieldset $fieldset_attribs$><div>'."\n"
															.'<legend class="panel-heading" $title_attribs$>$fieldset_title$</legend><div class="panel-body $class$">'."\n",
					'fieldset_end'   => '</div></div></fieldset></div>'."\n",
					'fieldstart'     => '<div class="form-group" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => 'control-label',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label class="control-label"></label>',
					'inputstart'     => '<div class="controls">',
					'inputend'       => "</div>\n",
					'infostart'      => '<div class="controls"><div class="form-control-static">',
					'infoend'        => "</div></div>\n",
					'buttonsstart'   => '<div class="control-buttons">',
					'buttonsend'     => "</div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '<div class="controls col-sm-9"><div class="checkbox"><label>',
					'inputend_checkbox'      => "</label></div></div>\n",
					'checkbox_newline_start' => '<div class="checkbox">',
					'checkbox_newline_end'   => "</div>\n",
					// - radio
					'fieldstart_radio'       => '<div class="form-group radio-group" $ID$>'."\n",
					'fieldend_radio'         => "</div>\n\n",
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '<div class="radio"><label>',
					'radio_newline_end'      => "</label></div>\n",
					'radio_oneline_start'    => '<label class="radio-inline">',
					'radio_oneline_end'      => "</label>\n",
				);

			case 'fixed_form':
				// Form with fixed label width (Used for form on disp=user):
				return array(
					'layout'         => 'fieldset',
					'formclass'      => 'form-horizontal',
					'formstart'      => '',
					'formend'        => '',
					'title_fmt'      => '<span style="float:right">$global_icons$</span><h2>$title$</h2>'."\n",
					'no_title_fmt'   => '<span style="float:right">$global_icons$</span>'."\n",
					'fieldset_begin' => '<div class="fieldset_wrapper $class$" id="fieldset_wrapper_$id$"><fieldset $fieldset_attribs$><div class="">'."\n"
															.'<legend class="panel-title" $title_attribs$>$fieldset_title$</legend><div class="$class$">'."\n",
					'fieldset_end'   => '</div></div></fieldset></div>'."\n",
					'fieldstart'     => '<div class="form-group fixedform-group" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => '',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label class="control-label fixedform-label"></label>',
					'inputstart'     => '<div class="">',
					'inputend'       => "</div>\n",
					'infostart'      => '<div class=""><div class="">',
					'infoend'        => "</div></div>\n",
					'buttonsstart'   => '<div class="form-group"><div class="control-buttons fixedform-controls">',
					'buttonsend'     => "</div></div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '<div class="controls fixedform-controls"><div class="checkbox"><label>',
					'inputend_checkbox'      => "</label></div></div>\n",
					'checkbox_newline_start' => '<div class="checkbox">',
					'checkbox_newline_end'   => "</div>\n",
					// - radio
					'fieldstart_radio'       => '<div class="form-group radio-group" $ID$>'."\n",
					'fieldend_radio'         => "</div>\n\n",
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '<div class="radio"><label>',
					'radio_newline_end'      => "</label></div>\n",
					'radio_oneline_start'    => '<label class="radio-inline">',
					'radio_oneline_end'      => "</label>\n",
				);

			case 'user_navigation':
				// The Prev/Next links of users (Used on disp=user to navigate between users):
				return array(
					'block_start'  => '<ul class="pager">',
					'prev_start'   => '<li class="previous">',
					'prev_end'     => '</li>',
					'prev_no_user' => '',
					'back_start'   => '<li>',
					'back_end'     => '</li>',
					'next_start'   => '<li class="next">',
					'next_end'     => '</li>',
					'next_no_user' => '',
					'block_end'    => '</ul>',
				);

			case 'button_classes':
				// Button classes (Used to initialize classes for action buttons like buttons to spam vote, or edit an intro post):
				return array(
					'button'       => 'btn btn-default btn-xs',
					'button_red'   => 'btn-danger',
					'button_green' => 'btn-success',
					'text'         => 'btn btn-default btn-xs',
					'group'        => 'btn-group',
				);

			case 'tooltip_plugin':
				// Plugin name for tooltips: 'bubbletip' or 'popover'
				// We should use 'popover' tooltip plugin for bootstrap skins
				// This tooltips appear on mouse over user logins or on plugin help icons
				return 'popover';
				break;

			case 'plugin_template':
				// Template for plugins:
				return array(
						// This template is used to build a plugin toolbar with action buttons above edit item/comment area:
						'toolbar_before'       => '<div class="btn-toolbar $toolbar_class$" role="toolbar">',
						'toolbar_after'        => '</div>',
						'toolbar_title_before' => '<div class="btn-toolbar-title">',
						'toolbar_title_after'  => '</div>',
						'toolbar_group_before' => '<div class="btn-group btn-group-xs" role="group">',
						'toolbar_group_after'  => '</div>',
						'toolbar_button_class' => 'btn btn-default',
					);

			case 'modal_window_js_func':
				// JavaScript function to initialize Modal windows, @see echo_user_ajaxwindow_js()
				return 'echo_modalwindow_js_bootstrap';
				break;

			default:
				// Delegate to parent class:
				return parent::get_template( $name );
		}
	}


	/**
	 * Check if we can display a widget container
	 *
	 * @param string Widget container key: 'menu', 'sidebar', 'sidebar2', 'footer'
	 * @param string Skin setting name
	 * @return boolean TRUE to display
	 */
	function is_visible_container( $container_key, $setting_name = 'access_login_containers' )
	{
		$access = $this->get_setting( $setting_name );

		return ( ! empty( $access ) && ! empty( $access[ $container_key ] ) );
	}


	/**
	 * Check if we can display a sidebar for the current layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar( $check_containers = false )
	{
		$layout = $this->get_setting( 'layout' );

		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}
	
	
	/**
	 * Check if we can display a sidebar for the Front page layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar_front( $check_containers = false )
	{
		$layout = $this->get_setting( 'layout_front' );

		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}
	
	
	/**
	 * Check if we can display a sidebar for the Posts page layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar_posts( $check_containers = false )
	{
		$layout = $this->get_setting( 'layout_posts' );

		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}
	
	
	/**
	 * Check if we can display a sidebar for the Single page layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar_single( $check_containers = false )
	{
		$layout = $this->get_setting( 'layout_single' );

		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}


	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout"
	 *
	 * @return string
	 */
	function get_column_class()
	{
		switch( $this->get_setting( 'layout' ) )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';
				
			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-md-8 pull-right left-padding';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-md-8 right-padding';
		}
	}
	
	
	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout Front"
	 *
	 * @return string
	 */
	function get_column_class_front()
	{
		switch( $this->get_setting( 'layout_front' ) )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';
				
			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-md-8 pull-right left-padding';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-md-8 right-padding';
		}
	}
	

	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout Posts"
	 *
	 * @return string
	 */
	function get_column_class_posts()
	{
		switch( $this->get_setting( 'layout_posts' ) )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';
				
			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-md-8 pull-right left-padding';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-md-8 right-padding';
		}
	}
	
	
	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout Single"
	 *
	 * @return string
	 */
	function get_column_class_single()
	{
		switch( $this->get_setting( 'layout_single' ) )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';
				
			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-md-8 pull-right left-padding';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-md-8 right-padding';
		}
	}
}

?>