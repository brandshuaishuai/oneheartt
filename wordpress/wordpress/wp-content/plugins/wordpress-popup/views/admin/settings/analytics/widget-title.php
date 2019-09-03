<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Widget Title', 'wordpress-popup' ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Choose a title for your analytics widget to be displayed on the dashboard.', 'wordpress-popup' ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">
		<input type="text" name="title" value="<?php echo esc_attr( $value ); ?>"
			placeholder="<?php esc_html_e( 'Widget Title', 'wordpress-popup' ); ?>"
			class="sui-form-control" >
	</div>

</div>
