<div class="wtbpAdminFooterShell">
	<div class="wtbpAdminFooterCell">
		<?php echo WTBP_WP_PLUGIN_NAME?>
		<?php _e('Version', WTBP_LANG_CODE)?>:
		<a target="_blank" href="http://wordpress.org/plugins/woo-product-tables/changelog/"><?php echo WTBP_VERSION?></a>
	</div>
	<div class="wtbpAdminFooterCell">|</div>
	<?php  if(!frameWtbp::_()->getModule(implode('', array('l','ic','e','ns','e')))) {?>
	<div class="wtbpAdminFooterCell">
		<?php _e('Go', WTBP_LANG_CODE)?>&nbsp;<a target="_blank" href="<?php echo $this->getModule()->getMainLink();?>"><?php _e('PRO', WTBP_LANG_CODE)?></a>
	</div>
	<div class="wtbpAdminFooterCell">|</div>
	<?php } ?>
	<div class="wtbpAdminFooterCell">
		<a target="_blank" href="https://wordpress.org/support/plugin/woo-product-tables"><?php _e('Support', WTBP_LANG_CODE)?></a>
	</div>
	<div class="wtbpAdminFooterCell">|</div>
	<div class="wtbpAdminFooterCell">
		Add your <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/woo-product-tables?filter=5#postform">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on wordpress.org.
	</div>
</div>