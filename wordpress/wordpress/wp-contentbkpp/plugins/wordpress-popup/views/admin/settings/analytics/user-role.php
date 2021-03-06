<?php
global $wp_roles;
$roles = Opt_In_Utils::get_user_roles();
?>

<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'User Role', Opt_In::TEXT_DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Choose the user roles you want to make the analytics widget available to.', Opt_In::TEXT_DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">
		<select class="sui-select" name="role" multiple>
			<?php foreach ( $roles as $slug => $label ) { ?>
				<?php $admin = 'administrator' === $slug; ?>
			<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( in_array($slug, $value, true) || $admin ); ?> <?php disabled( $admin ); ?> ><?php echo esc_html( $label ); ?></option>
			<?php } ?>
		</select>
	</div>

</div>
