<?php
$image_1x = self::$plugin_url . 'assets/images/hustle-welcome.png';
$image_2x = self::$plugin_url . 'assets/images/hustle-welcome@2x.png';
?>

<div class="sui-box sui-message sui-message-lg">

	<?php echo Opt_In_Utils::render_image_markup( esc_url( $image_1x ), esc_url( $image_2x ), 'sui-image' ); // WPCS: XSS ok. ?>

	<div class="sui-message-content">

		<?php if ( isset( $message ) && '' !== $message ) { ?>

			<p><?php echo esc_html( $message ); ?></p>

		<?php } else { ?>

			<p><?php esc_html_e( "You don't have any module yet. Click on create button to start.", Opt_In::TEXT_DOMAIN ); ?></p>

		<?php } ?>

		<?php if ( $capability['hustle_create'] ) { ?>

			<p>
				<button
					class="sui-button sui-button-blue hustle-create-module"
				>
					<i class="sui-icon-plus" aria-hidden="true"></i> <?php esc_html_e( 'Create', Opt_In::TEXT_DOMAIN ); ?>
				</button>

				<button
					class="sui-button hustle-import-new-module"
				>
					<i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Import', Opt_In::TEXT_DOMAIN ); ?>
				</button>
			</p>

		<?php } ?>

	</div>

</div>
