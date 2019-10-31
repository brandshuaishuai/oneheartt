jQuery( window ).load( function() {
	var dts = {}, datas = {}, titles_array = [], values_array = [], param = [], data = {}, key = 0, uniqueid = "";
	jQuery( "#wpbody-content .wrap" ).css( "visibility", "visible" );
	jQuery( "#screen_preloader" ).fadeOut( "slow", function() {
		jQuery( this ).remove();
	});
	jQuery("#pwpc-shortcode").focus( function() {
		jQuery( this ).select(); 
	});
	jQuery( "body" ).on( "click", "#generate_wpc_shortcode", function() {
		dts = {};
		param[ 'style' ] = jQuery( "#pwpc_types" ).val();
		if ( jQuery( "#pwpc_max" ).val().length > 0 ) {
			param[ 'max' ] = jQuery( "#pwpc_max" ).val();
		}
		else {
			param[ 'max' ] = "";
		}
		if ( jQuery( "#pwpc_legend" ).val() == 'true' ) {
			param[ 'legend' ] = "true";
		}
		else {
			param[ 'legend' ] = "false";
		}
		if ( param[ 'max' ] != "" ) {
			jQuery( "#pwpc-shortcode" ).val( '[wpcharts type="' + param[ 'style' ] + '" max="' + param[ 'max' ] + '" legend="' + param[ 'legend' ] + '" titles="' + jQuery( "#pwpc_titles" ).val() + '" values="' + jQuery( "#pwpc_values" ).val() + '"]' );			
		}
		else {
			jQuery( "#pwpc-shortcode" ).val( '[wpcharts type="' + param[ 'style' ] + '" legend="' + param[ 'legend' ] + '" titles="' + jQuery( "#pwpc_titles" ).val() + '" values="' + jQuery( "#pwpc_values" ).val() + '"]' );
		}
		datas[ 'style' ] = param;
		titles_array = jQuery( "#pwpc_titles" ).val().split( "," );
		values_array = jQuery( "#pwpc_values" ).val().split( "," );
			jQuery.each( titles_array, function( key, value ) {
				dts[ key ] = {
					answer: value,
					count: parseFloat( values_array[ key ] )
				}
		})
		datas[ 'datas' ]= {
			0: dts
		}
		uniqueid = Math.floor(Math.random() * 26) + Date.now();
		jQuery( "#pwpc-chart-area" ).html( '<div id="pwp-charts-' + uniqueid + '" class="admin-chart"><canvas style="width: 500px; height: 100%;"></canvas></div>' );
		jQuery( "#pwp-charts-" + uniqueid ).pmsresults({ "style": datas.style, "datas": datas.datas });
	});
});