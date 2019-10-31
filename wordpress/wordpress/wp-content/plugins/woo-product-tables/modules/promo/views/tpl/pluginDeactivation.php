<style type="text/css">
	.wtbpDeactivateDescShell {
		display: none;
		margin-left: 25px;
		margin-top: 5px;
	}
	.wtbpDeactivateReasonShell {
		display: block;
		margin-bottom: 10px;
	}
	#wtbpDeactivateWnd input[type="text"],
	#wtbpDeactivateWnd textarea {
		width: 100%;
	}
	#wtbpDeactivateWnd h4 {
		line-height: 1.53em;
	}
	#wtbpDeactivateWnd + .ui-dialog-buttonpane .ui-dialog-buttonset {
		float: none;
	}
	.wtbpDeactivateSkipDataBtn {
		float: right;
		margin-top: 15px;
		text-decoration: none;
		color: #777 !important;
	}
</style>
<div id="wtbpDeactivateWnd" style="display: none;" title="<?php _e('Your Feedback', WTBP_LANG_CODE)?>">
	<h4><?php printf(__('If you have a moment, please share why you are deactivating %s', WTBP_LANG_CODE), WTBP_WP_PLUGIN_NAME)?></h4>
	<form id="wtbpDeactivateForm">
		<label class="wtbpDeactivateReasonShell">
			<?php echo htmlWtbp::radiobutton('deactivate_reason', array(
				'value' => 'not_working',
			))?>
			<?php _e('Couldn\'t get the plugin to work', WTBP_LANG_CODE)?>
			<div class="wtbpDeactivateDescShell">
				<?php printf(__('If you have a question, <a href="%s" target="_blank">contact us</a> and will do our best to help you'), 'https://woobewoo.com/contact-us/')?>
			</div>
		</label>
		<label class="wtbpDeactivateReasonShell">
			<?php echo htmlWtbp::radiobutton('deactivate_reason', array(
				'value' => 'found_better',
			))?>
			<?php _e('I found a better plugin', WTBP_LANG_CODE)?>
			<div class="wtbpDeactivateDescShell">
				<?php echo htmlWtbp::text('better_plugin', array(
					'placeholder' => __('If it\'s possible, specify plugin name', WTBP_LANG_CODE),
				))?>
			</div>
		</label>
		<label class="wtbpDeactivateReasonShell">
			<?php echo htmlWtbp::radiobutton('deactivate_reason', array(
				'value' => 'not_need',
			))?>
			<?php _e('I no longer need the plugin', WTBP_LANG_CODE)?>
		</label>
		<label class="wtbpDeactivateReasonShell">
			<?php echo htmlWtbp::radiobutton('deactivate_reason', array(
				'value' => 'temporary',
			))?>
			<?php _e('It\'s a temporary deactivation', WTBP_LANG_CODE)?>
		</label>
		<label class="wtbpDeactivateReasonShell">
			<?php echo htmlWtbp::radiobutton('deactivate_reason', array(
				'value' => 'other',
			))?>
			<?php _e('Other', WTBP_LANG_CODE)?>
			<div class="wtbpDeactivateDescShell">
				<?php echo htmlWtbp::text('other', array(
					'placeholder' => __('What is the reason?', WTBP_LANG_CODE),
				))?>
			</div>
		</label>
		<?php echo htmlWtbp::hidden('mod', array('value' => 'promo'))?>
		<?php echo htmlWtbp::hidden('action', array('value' => 'saveDeactivateData'))?>
	</form>
	<a href="" class="wtbpDeactivateSkipDataBtn"><?php _e('Skip & Deactivate', WTBP_LANG_CODE)?></a>
</div>