jQuery(document).ready(function () {

	if (typeof hot === 'undefined') {
		return true;
	}
	/**
	 * Disable post status cells that contain readonly statuses.
	 * ex. scheduled posts
	 */
	hot.updateSettings({
		cells: function (row, col, prop) {
			var cellProperties = {};


			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];
			if (columnSettings) {
				if (!columnSettings.is_locked && (vgse_editor_settings.watch_cells_to_lock || prop === 'post_status')) {
					var cellData = hot.getDataAtCell(row, col);
					if (cellData && typeof cellData === 'string' && cellData.indexOf('vg-cell-blocked') > -1) {
						cellProperties.readOnly = true;
						cellProperties.editor = false;
						cellProperties.renderer = 'wp_locked';
						cellProperties.fillHandle = false;
					}
				}

				if (columnSettings.is_locked && columnSettings.allow_to_save && vgse_editor_settings.lockedColumnsManuallyEnabled.indexOf(prop) > -1) {
					cellProperties = columnSettings.formatted;
					cellProperties.readOnly = false;
					cellProperties.fillHandle = true;
					cellProperties.renderer = 'text';
				}

				if (vgse_editor_settings.post_type === vgse_editor_settings.woocommerce_product_post_type_key && prop === 'post_status') {
					cellProperties.selectOptions = columnSettings.formatted.selectOptions;
					var cellData = hot.getDataAtCell(row, col);
					var rowPostType = hot.getDataAtRowProp(row, 'post_type');
					if (rowPostType === 'product_variation') {
						cellProperties.selectOptions = {
							'publish': cellProperties.selectOptions.publish,
							'delete': cellProperties.selectOptions.delete
						};
					}
				}
			}

			return cellProperties;
		}
	});
});

