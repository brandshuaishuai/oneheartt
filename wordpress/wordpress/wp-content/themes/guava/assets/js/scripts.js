(function($) {
    "use strict";
	    jQuery(document).ready(function() {
			var top_news = jQuery('#featured-slider');
			top_news.show().owlCarousel({
				items : 1,
				singleItem : true,
				responsive: true,
				navigation : true,
				navigationText : ['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
				pagination: false,
			});

			var top_promo = jQuery('.promo-slider');
			top_promo.show().owlCarousel({
				items : 3,
				responsive: true,

			});

			$('.search-wrapper i').click(function() {
    			$('.search-form-wrapper').toggleClass('search-form-active');
    		}); 
	    		
	    		
	    
    });
})(jQuery);


jQuery(document).ready(function($) {
	
//Check to see if the window is top if not then display button
	jQuery(window).scroll(function($){
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scrollToTop').addClass('activetop');
			jQuery('.scrollToTop').fadeIn();
		} else {
			jQuery('.scrollToTop').fadeOut();
		}
	});
	
	//Click event to scroll to top
	jQuery('.scrollToTop').click(function($){
		jQuery('html, body').animate({scrollTop : 0},800);
		return false;
	});


//sticky sidebar
    var at_body = jQuery("body");
    var at_window = jQuery(window);

   if(at_body.hasClass('at-sticky-sidebar')){
            if(at_body.hasClass('right-sidebar')){
                jQuery('#secondary, #primary').theiaStickySidebar();
            }
            else{
                jQuery('#secondary, #primary').theiaStickySidebar();
            }
        }


});