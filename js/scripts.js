jQuery(document).ready(function() {
	
	/* Header Search Field
	*********************************************************/
	jQuery('.search-field-toggle').click(function() {
		jQuery(this).toggleClass('search-field-visible');
		if (jQuery(this).hasClass('search-field-visible')) {
			jQuery('.header-main-search-field').fadeIn(400);
			// Add focus on the opened field
			jQuery( ".header-main-search-field .search_field" ).focus();
			// Add placeholder for the opened field
			jQuery( ".header-main-search-field .search_field" ).attr("placeholder", "Type in and hit enter");
		}
		if (!jQuery(this).hasClass('search-field-visible')) {
			jQuery('.header-main-search-field').fadeOut(400);
		}
	});
	
	/* Disp search search field placeholder
	*********************************************************/
	jQuery( ".disp_search .extended_search_form .search_field, .disp_front .compact_search_form .search_field" ).attr("placeholder", "Type in and hit enter");

	/* Header Social Section
	*********************************************************/
	jQuery('.ufld_icon_links').click(function() {
		// Social in header becomes drop-down
		$( '.ufld_icon_links a' ).toggleClass(' drop-down-social');
	});
	
	/* Back to Top Button
	*********************************************************/
	// browser window (in pixels) after which the "back to top" button is show
		var offset = 300,
	// duration of the top scrolling animatiion (in ms)
		scroll_top_duration = 700,
	// grab the "back to top" link
		$back_to_top = $( '.back-to-top' );

	$(window).scroll( function() {
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('visible') : $back_to_top.removeClass('visible');
	});

	// Smooth scroll to top
	$back_to_top.on( 'click', function(event) {
		event.preventDefault();
		$( 'body, html' ).animate({
			scrollTop: 0,
			}, scroll_top_duration 
		);
	});
	
});