<?php
	$messages_enabled = '0' !== (string) $messages['enabled'];
?>
<div id="customize-row" class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Customize Unsubscribe Form', Opt_In::TEXT_DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Choose the copy of the unsubscribe form along with the success and error messages to be displayed.', Opt_In::TEXT_DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">

		<label class="sui-toggle">
			<input type="checkbox"
				name="messages_enabled"
				value="1"
				id="wph-unsub-edit-message"
				<?php checked( $messages_enabled ); ?>
				>
			<label for="wph-unsub-edit-message" class="sui-toggle-slider"></label>
		</label>
		<label class="sui-toggle-label" for="wph-unsub-edit-message"><?php esc_html_e( 'Enable form customization', Opt_In::TEXT_DOMAIN ); ?></label>

		<div class="sui-border-frame sui-toggle-content<?php echo $messages_enabled ? '' : ' sui-hidden'; ?>">

			<!-- Submit button text -->
			<div class="sui-form-field">

				<?php
				$sbt = array(
					'button_text_label' => array(
						'id'    => 'submit-button-text-label',
						'for'   => 'submit-button-text',
						'type'  => 'label',
						'value' => __( 'Submit button text', Opt_In::TEXT_DOMAIN ),
					),
					'button_text'       => array(
						'id'          => 'submit-button-text',
						'name'        => 'submit_button_text',
						'value'       => $messages['submit_button_text'],
						'placeholder' => '',
						'type'        => 'text',
					),
				);

				foreach ( $sbt as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Search lists button text -->
			<div class="sui-form-field">

				<?php
				$slbt = array(
					'get_lists_button_text_label' => array(
						'id'    => 'lists-button-text-label',
						'for'   => 'lists-button-text',
						'type'  => 'label',
						'value' => __( 'Search lists button text', Opt_In::TEXT_DOMAIN ),
					),
					'get_lists_button_text'       => array(
						'id'          => 'lists-button-text',
						'name'        => 'get_lists_button_text',
						'value'       => $messages['get_lists_button_text'],
						'placeholder' => '',
						'type'        => 'text',
					),
				);

				foreach ( $slbt as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Invalid email error message -->
			<div class="sui-form-field">

				<?php
				$ieem = array(
					'invalid_email_message_label' => array(
						'id'    => 'invalid-email-message-label',
						'for'   => 'invalid-email',
						'type'  => 'label',
						'value' => __( 'Invalid email error message', Opt_In::TEXT_DOMAIN ),
					),
					'invalid_email_message'       => array(
						'id'    => 'invalid-email-message',
						'name'  => 'invalid_email',
						'type'  => 'text',
						'value' => $messages['invalid_email'],
					),
				);

				foreach ( $ieem as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Email not found message -->
			<div class="sui-form-field">

				<?php
				$enfm = array(
					'email_not_found_message_label' => array(
						'id'    => 'iemail-not-found-message-label',
						'for'   => 'email-not-found-message',
						'type'  => 'label',
						'value' => __( 'Email not found message', Opt_In::TEXT_DOMAIN ),
					),
					'email_not_found_message'       => array(
						'id'    => 'email-not-found-message',
						'name'  => 'email_not_found',
						'type'  => 'text',
						'value' => $messages['email_not_found'],
					),
				);

				foreach ( $enfm as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Data not valid message -->
			<div class="sui-form-field">

				<?php
				$dnvm = array(
					'invalid_data_message_label' => array(
						'id'    => 'invalid-data-message-label',
						'for'   => 'invalid-data-message',
						'type'  => 'label',
						'value' => __( 'Data not valid message', Opt_In::TEXT_DOMAIN ),
					),
					'invalid_data_message'       => array(
						'id'    => 'invalid-data-message',
						'name'  => 'invalid_data',
						'type'  => 'text',
						'value' => $messages['invalid_data'],
					),
				);

				foreach ( $dnvm as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Email couldn't be submitted message -->
			<div class="sui-form-field">

				<?php
				$ecbsm = array(
					'email_not_submitted_message_label' => array(
						'id'    => 'email-not-submitted-message-label',
						'for'   => 'email-not-submitted-message',
						'type'  => 'label',
						'value' => __( 'Email couldn\'t be submitted message', Opt_In::TEXT_DOMAIN ),
					),
					'email_not_submitted_message'       => array(
						'id'    => 'email-not-submitted-message',
						'name'  => 'email_not_processed',
						'type'  => 'text',
						'value' => $messages['email_not_processed'],
					),
				);

				foreach ( $ecbsm as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Check your email for confirmation message -->
			<div class="sui-form-field">

				<?php
				$cyefcm = array(
					'email_submitted_message_label'     => array(
						'id'    => 'email-submitted-message-label',
						'for'   => 'email-submitted-message',
						'type'  => 'label',
						'value' => __( 'Check your email for confirmation message', Opt_In::TEXT_DOMAIN ),
					),
					'email_submitted_message'           => array(
						'id'    => 'email-submitted-message',
						'name'  => 'email_submitted',
						'type'  => 'text',
						'value' => $messages['email_submitted'],
					),
				);

				foreach ( $cyefcm as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

			<!-- Successful unsubscription message -->
			<div class="sui-form-field">

				<?php
				$sum = array(
					'successful_unsubscription_message_label' => array(
						'id'    => 'successful-unsubscription-message-label',
						'for'   => 'successful-unsubscription-message',
						'type'  => 'label',
						'value' => __( 'Successful unsubscription message', Opt_In::TEXT_DOMAIN ),
					),
					'successful_unsubscription_message' => array(
						'id'    => 'successful-unsubscription-message',
						'name'  => 'successful_unsubscription',
						'type'  => 'text',
						'value' => $messages['successful_unsubscription'],
					),
				);

				foreach ( $sum as $key => $option ) {
					$this->render( 'general/option', $option );
				} ?>

			</div>

		</div>

	</div>

</div>
