(function($) {
    "use strict";
	    jQuery(document).ready(function() {
    		//Sticky header
		    var headerHeight = $('.section-menu').height();
		    $(window).scroll(function() {
		        if ($(window).scrollTop() > headerHeight) {
		            $('.section-menu').addClass('fixed-top');
		        } else {
		            $('.section-menu').removeClass('fixed-top');
		        }
		    });
    	});
})(jQuery);


