jQuery(document).ready(function() {
	
	// Adding Mobile Menu Toggle
	var nav = jQuery('.builder-module-navigation');
	
	jQuery.each( nav, function(){
		if ( !jQuery(this).hasClass('secondary-navigation') ) {
			var menu = jQuery(this).find('.menu');
			menu.addClass("it-mobile-menu-hidden");
		}
	});

	
	// jQuery(".builder-module-navigation .menu").addClass("it-mobile-menu-hidden");
	jQuery(".builder-module-navigation .sub-menu-expand").addClass(".sub-menu-expand-hidden");
	jQuery(".builder-module-navigation").addClass("mobile");

	jQuery(".it-mobile-menu-hidden").before('<div class="it-mobile-menu">&#8801; Menu</div>');

	jQuery(".it-mobile-menu").click(function(){
		jQuery(this).next().slideToggle();
		jQuery(this).toggleClass("border");
	});
	
	
	// Expandable/collapsable Sub Menu
    jQuery('.mobile.builder-module-navigation .menu-item-has-children').append('<div class="sub-menu-expand"><span class="dashicons dashicons-plus"></span></div>');
		
	
    jQuery( ".sub-menu-expand" ).click(function() {
	    var subMenu = jQuery(this).siblings('.sub-menu');
	    var subMenuIcon = jQuery('.dashicons',this);
		if(subMenu.css('display') == 'none') {
			subMenu.slideDown();
			subMenuIcon.removeClass('dashicons-plus');
			subMenuIcon.addClass('dashicons-no');
		} else {
	  		subMenuIcon.removeClass('dashicons-no');
	  		subMenuIcon.addClass('dashicons-plus');
	  		subMenu.slideUp(); 
		}
	});
	
	
	// Window Resize Function
	jQuery(window).resize(function(){
		if(window.innerWidth > 500) {
			jQuery(".menu").removeAttr("style");
			jQuery(".sub-menu-expand").removeAttr("style");
			jQuery(".builder-module-navigation.mobile").removeAttr("style");
		}
	});
});
