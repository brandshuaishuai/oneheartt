<div class="<?php echo esc_attr( implode( ' ', $sui['summary']['classes'] ) ); ?>">
	<div class="sui-summary-image-space" aria-hidden="true" style="<?php echo esc_attr( $sui['summary']['style'] ); ?>"></div>
	<div class="sui-summary-segment">
		<div class="sui-summary-details">
			<span class="sui-summary-large"><?php echo esc_attr( $active_modules_count ); ?></span>
			<?php if ( 1 === $active_modules_count ) { ?>
				<span class="sui-summary-sub"><?php printf( esc_html__( 'Active %s', Opt_In::TEXT_DOMAIN ), esc_html( $singular ) ); ?></span>
			<?php } else { ?>
				<span class="sui-summary-sub"><?php printf( esc_html__( 'Active %s', Opt_In::TEXT_DOMAIN ), esc_html( $plural ) ); ?></span>
			<?php } ?>
		</div>
	</div>
	<div class="sui-summary-segment">
		<ul class="sui-list">
			<li>
				<span class="sui-list-label"><?php esc_html_e( 'Last Conversion', Opt_In::TEXT_DOMAIN ); ?></span>
				<span class="sui-list-detail"><?php echo esc_html( $latest_entry_time ); ?></span>
			</li>
			<li>
				<span class="sui-list-label"><?php esc_html_e( 'Conversions in the last 30 days', Opt_In::TEXT_DOMAIN ); ?></span>
				<span class="sui-list-detail"><?php echo esc_html( $latest_entries_count ); ?></span>
			</li>
		</ul>
	</div>
</div>
