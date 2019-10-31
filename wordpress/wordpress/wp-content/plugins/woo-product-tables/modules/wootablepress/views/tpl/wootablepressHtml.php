<div id="wtbp-table-wrapper-<?php echo $this->viewId;?>" data-table-id="wtbp-table-<?php echo $this->viewId;?>" class="wtbpTableWrapper" style="visibility: hidden">
    <table id="wtbp-table-<?php echo $this->viewId;?>" data-table-id="<?php echo $this->tableId;?>" class="wtbpContentTable" data-settings="<?php echo htmlspecialchars(json_encode($this->settings['settings']), ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo $this->html; ?>
    </table>
	<div class="wtbpFilterWrapper">
		<?php echo $this->filter; ?>
	</div>
	<div class="wtbpCustomCssWrapper" style="display: none;">
		<?php print $this->custom_css; ?>
	</div>
	<?php print $this->loader; ?>
</div>
