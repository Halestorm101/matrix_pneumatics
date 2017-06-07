jQuery(document).ready(function(){
	jQuery('.bxslider').bxSlider({
		mode: 'fade',
		captions: true,
		adaptiveHeight: true,
		onSliderLoad: function(){
			jQuery(".slides-wrapper").css("visibility", "visible");
      }
	});
});