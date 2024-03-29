<?php
ob_start();

require self::$plugin_path . 'assets/css/sui-editor.min.css';
$editor_css = ob_get_clean();
$editor_css = '<style>' . $editor_css. '</style>';
$email_enabled = isset( $email['enabled'] ) && '0' !== (string) $email['enabled'];
$email_subject = isset( $email['email_subject'] ) ? $email['email_subject'] : '';
$email_body = isset( $email['email_body'] ) ? $email['email_body'] : '';
?>

<div id="email-copy-row" class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Unsubscribe Email Copy', Opt_In::TEXT_DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Customize the copy of the email that will be recived  by the visitors with the unsubscribe link.', Opt_In::TEXT_DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">

		<label class="sui-toggle">
			<input type="checkbox"
				name="email_enabled"
				value="1"
				id="wph-unsub-edit-email"
				<?php checked( $email_enabled ); ?>
				>
			<label for="wph-unsub-edit-email" class="sui-toggle-slider"></label>
		</label>
		<label class="sui-toggle-label" for="wph-unsub-edit-email"><?php esc_html_e( 'Enable custom email copy', Opt_In::TEXT_DOMAIN ); ?></label>

		<div class="sui-border-frame sui-toggle-content<?php echo $email_enabled ? '' : ' sui-hidden'; ?>">

			<!-- Email subject -->
			<div class="sui-form-field">

				<?php
				$email_subject = array(
					'email_subject_label' => array(
						'id' 	=> 'email-subject-label',
						'for' 	=> 'email-subject',
						'type' 	=> 'label',
						'value' => __( 'Email subject', Opt_In::TEXT_DOMAIN ),
					),
					'email_subject'       => array(
						'id' 			=> 'email-subject',
						'name' 			=> 'email_subject',
						'value' 		=> $email_subject,
						'placeholder' 	=> '',
						'type' 			=> 'text',
					),
				);

				foreach ( $email_subject as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Email body -->
			<div class="sui-form-field">

				<label class="sui-label sui-label-editor" for="emailmessage"><?php esc_html_e( 'Email body', Opt_In::TEXT_DOMAIN ); ?></label>

				<?php wp_editor(
					$email_body,
					'emailmessage',
					array(
						'media_buttons'    => false,
						'textarea_name'    => 'email_message',
						'editor_css'       => $editor_css,
						'tinymce'          => array(
							'content_css' => self::$plugin_url . 'assets/css/sui-editor.min.css'
						),
						'editor_height'    => 192,
						'drag_drop_upload' => false,
					)
				); ?>

				<span class="sui-description"><?php printf( esc_html__( 'Use the placeholder %1$s{hustle_unsubscribe_link}%2$s to insert the unsubscription link.', Opt_In::TEXT_DOMAIN ), '<strong>', '</strong>' ); ?></span>

			</div>

		</div>

	</div>

</div>
