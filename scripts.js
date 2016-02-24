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

	/* Header Social Section
	*********************************************************/
	jQuery('.ufld_icon_links').click(function() {
		// When < 992px, social in header becomes drop-down
		$( '.ufld_icon_links a' ).toggleClass(' drop-down-social');
	});
	
});