/**
 * Apply columns changes to the spreadsheet
 * @param array loadedColumns
 * @param array loadedColumnsNames
 * @param array loadedColumnsWidths
 * @param str context softUpdate or empty. If the changes will be saved to the database
 * @returns Boolean | null
 */
function vgseColumnsVisibilityUpdateHOT(loadedColumns, loadedColumnsNames, loadedColumnsWidths, context) {
	var $form = jQuery('.modal-columns-visibility form');
	var $enabled = $form.find('.columns-enabled li .js-column-key');
	if (!$enabled.length && window.vgseColumnsVisibilityEnabled) {
		$enabled = window.vgseColumnsVisibilityEnabled;
	}
	var $save = jQuery('.save_post_type_settings');
	var modalInstance = $form.parents('.remodal').remodal();

	// If we enabled a column that needs a page reload,
	// automatically enable saving, show a confirmation to the user, and reload.
	var $columnsRequireReload = $form.find('.columns-enabled li .fa-refresh').parent();
	var autoReload = false;
	if ($columnsRequireReload.length) {
		var columnNamesToConfirm = [];
		$columnsRequireReload.find('.column-title').each(function () {
			columnNamesToConfirm.push(jQuery.trim(jQuery(this).text()));
		});
		var reloadConfirmationText = vgse_editor_settings.texts.confirm_column_reload_page.replace('{columns}', columnNamesToConfirm.join(', '));
		if (confirm(reloadConfirmationText)) {
			$save.prop('checked', true);
			autoReload = true;
		}
	}

	// Exit if no column is enabled.        
	if (!$enabled.length) {
		loading_ajax({estado: false});
		if (modalInstance.getState() === 'opened') {
			modalInstance.close();
		}
		console.log('exit, columns not enabled');
		return false;
	}


	if (typeof hot !== 'undefined') {
		// Cache to be able to call this function when the modal is closed.    
		window.vgseColumnsVisibilityEnabled = $enabled;

		// Apply changes live to the spreadsheet
		if (!loadedColumns) {
			loadedColumns = hot.getSettings().columns;
		}
		if (!loadedColumnsNames) {
			loadedColumnsNames = vgse_editor_settings.colHeaders;
		}
		if (!loadedColumnsWidths) {
			loadedColumnsWidths = vgse_editor_settings.colWidths;
		}
		var indexedLoadedColumns = [];
		var newColumns = [];
		var newColumnsNames = [];
		var newColumnsWidths = [];

		// Add key index to loadedColumns so we can access specific items later.
		loadedColumns.forEach(function (item, index) {
			item.vgOriginalIndex = index;
			indexedLoadedColumns[item.data] = item;
		}, this);

		// Generate list of enabled columns, including fixed columns.  
		var disallowedColumns = $form.find('.not-allowed-columns').val();
		disallowedColumns = disallowedColumns.replace('ID,', '').split(',');
		var enabledColumns = [];
		$enabled.each(function () {
			var columnKey = jQuery(this).val();
			enabledColumns.push(columnKey);
		});

//		enabledColumns = enabledColumns.concat(disallowedColumns);
		enabledColumns = disallowedColumns.concat(enabledColumns);

		// Iterate over enabledColumns and generate the list of final columns, columnsNames, and columns Widths.  
		enabledColumns.forEach(function (columnKey, index) {
			if (indexedLoadedColumns[columnKey]) {
				newColumns.push(indexedLoadedColumns[columnKey]);
				newColumnsNames.push(loadedColumnsNames[columnKey]);
				newColumnsWidths.push(loadedColumnsWidths[columnKey]);
			}
		}, this);


		console.log(indexedLoadedColumns);
		console.log(newColumns);
		console.log(enabledColumns);
		console.log(loadedColumns);
		console.log(newColumnsNames);
		console.log(loadedColumnsNames);


		hot.updateSettings({
			columns: newColumns,
			colHeaders: newColumnsNames,
			colWidths: newColumnsWidths
		});

		if (!$save.is(':checked') || context === 'softUpdate') {
			loading_ajax({estado: false});
			if (modalInstance.getState() === 'opened') {
				modalInstance.close();
			}
			console.log('exit, saving not checked');
			return false;
		}

	}
	var formData = $form.children('input').serializeArray();
//	var enabledData = $form.find('.columns-enabled li:visible input').serializeArray();
	var enabledData = $form.find('.columns-enabled li input').serializeArray();

	finalFormData = formData.concat(enabledData);

	console.log(finalFormData);
	jQuery.post($form.attr('action'), finalFormData, function (response) {
		console.log(response);

		var callback = $form.data('callback');
		if (callback) {
			vgseExecuteFunctionByName(callback, window, {
				response: response,
				form: $form
			});
		}
		if (autoReload) {
			window.location.reload();
		}
	});
	loading_ajax({estado: false});
	if (modalInstance) {
		if (modalInstance.getState() === 'opened') {
			modalInstance.close();
		}
	}

	return false;
}

function vgseColumnsVisibilityEqualizeHeight() {
	jQuery('#vgse-columns-enabled,#vgse-columns-disabled').css('height', '');
	var enabledHeight = jQuery('#vgse-columns-enabled').height();
	var disabledHeight = jQuery('#vgse-columns-disabled').height();
	var maxHeight = enabledHeight > disabledHeight ? enabledHeight : disabledHeight;

	if (maxHeight > 0) {
		jQuery('#vgse-columns-enabled,#vgse-columns-disabled').height(maxHeight);
	}
}
function vgseColumnsVisibilityInit() {

// It should init once, otherwise it will make repeat ajax requests
	if (window.vgseColumnsVisibilityAlreadyInit) {
		return true;
	}
	window.vgseColumnsVisibilityAlreadyInit = true;

	// Initialize sortable lists
	var $columns = document.getElementById('vgse-columns-enabled');
	var $columnsDisabled = document.getElementById('vgse-columns-disabled');
	var $modal = jQuery('.modal-columns-visibility');

	if (!$columns || !$columnsDisabled) {
		return true;
	}

	// Equalize height between columns
//	setTimeout( function(){		
	vgseColumnsVisibilityEqualizeHeight();
//	}, 1000);

	function itemsMoved() {
		// Switch the input names based on the status

		var $allEnabledInputs = $modal.find('.columns-enabled li input');
		$allEnabledInputs.each(function () {
			jQuery(this).attr('name', jQuery(this).attr('name').replace('disallowed_column', 'column'));
		});

		var $disabled = $modal.find('.columns-disabled li input');
		$disabled.each(function () {
			jQuery(this).attr('name', jQuery(this).attr('name').replace(/^column/, 'disallowed_column'));
		});

		var $enabled = $modal.find('.columns-enabled li .js-column-key');
		var allEnabled = $enabled.map(function () {
			return jQuery(this).val();
		}).get().join(',');

		$modal.find('.all-allowed-columns').val(allEnabled);


		window.vgseColumnsVisibilityUsed = true;
	}
	window.enabledSortable = Sortable.create($columns, {
		group: 'vgseColumns',
		animation: 100,
		onSort: function (evt) {

			console.log('moved');
			itemsMoved();
		}
	});
	window.disabledSortable = Sortable.create($columnsDisabled, {
		group: {
			name: 'vgseColumns',
			// put: ['foo', 'bar']
		},
		animation: 100
	});

	// Enable / disable all columns
	jQuery('body').on('click', '.modal-columns-visibility .vgse-change-all-states', function (e) {
		e.preventDefault();
		var toStatus = jQuery(this).data('to');

		if (toStatus === 'disabled') {
			$columnsDisabled.innerHTML += $columns.innerHTML;
			$columns.innerHTML = '';
		} else {
			$columns.innerHTML += $columnsDisabled.innerHTML;
			$columnsDisabled.innerHTML = '';
		}

		itemsMoved();
	});

	// Save changes
	jQuery('body').on('submit', '.modal-columns-visibility  form', function (e) {
		e.preventDefault();
		itemsMoved();
		var response = vgseColumnsVisibilityUpdateHOT(null, null, null, 'hardUpdate');
		console.log(response);
		if (typeof response === 'boolean') {
			return response;
		}

		return false;
	});
	jQuery('body').on('click', '.modal-columns-visibility  .vgse-restore-removed-columns', function (e) {
		e.preventDefault();
		jQuery.post(ajaxurl, {
			action: 'vgse_restore_columns',
			nonce: jQuery('.modal-columns-visibility form').data('nonce'),
			post_type: jQuery('.modal-columns-visibility form input[name="post_type"]').val()
		}, function (response) {
			if (response.success) {
				alert(response.data.message);
			} else {
				notification({mensaje: response.data.message, tipo: 'error', tiempo: 30000});
			}
		});
	});
	jQuery('body').on('click', '.modal-columns-visibility   .deactivate-column', function (e) {
		e.preventDefault();

		if (window.hot) {
			var modifiedData = beGetModifiedItems();

			if (modifiedData.length) {
				alert(vgse_editor_settings.texts.save_changes_before_remove_column);
				return true;
			}
		}
		$column = jQuery(this).parent();
		$column.appendTo('.modal-columns-visibility .columns-disabled');
		itemsMoved();
	});
	jQuery('body').on('click', '.modal-columns-visibility   .enable-column', function (e) {
		e.preventDefault();
		$column = jQuery(this).parent();
		$column.appendTo('.modal-columns-visibility .columns-enabled');
		itemsMoved();
	});
	jQuery('body').on('click', '.modal-columns-visibility   .remove-column', function (e) {
		e.preventDefault();
		if (window.hot) {
			var modifiedData = beGetModifiedItems();

			if (modifiedData.length) {
				alert(vgse_editor_settings.texts.save_changes_before_remove_column);
				return true;
			}
		}
		var $button = jQuery(this);
		var columnKey = $button.parent().find('.js-column-key').val();

		window.lastColumnKeyRemoved = columnKey;
		$button.parent().remove();

		jQuery.post(ajaxurl, {
			action: 'vgse_remove_column',
			nonce: jQuery('.modal-columns-visibility form').data('nonce'),
			post_type: jQuery('.modal-columns-visibility form input[name="post_type"]').val(),
			column_key: columnKey
		}, function (response) {
			if (response.success) {
				itemsMoved();
			} else {
				notification({mensaje: response.data.message, tipo: 'error', tiempo: 30000});
			}
		});
		return false;
	});
	itemsMoved();
}

// We need to initialize the form when the popup opens, the sortable plugin 
// requires the elements to be visible
// When we're not in the spreadsheet page, we initialize on page load
jQuery(document).on('opened', '.modal-columns-visibility', function () {
	vgseColumnsVisibilityInit();
	vgseColumnsVisibilityEqualizeHeight();
});
jQuery(window).load(function () {
	jQuery('body').on('click', '.wpse-toggle-head', function () {
		if (jQuery(this).next('.wpse-toggle-content').find('.modal-columns-visibility').length) {
			vgseColumnsVisibilityEqualizeHeight();
			vgseColumnsVisibilityInit();
		}
	});
});

// Allow to hide columns from contextual menu
jQuery(document).ready(function () {

	if (typeof hot === 'undefined' || !jQuery('.modal-columns-visibility').length) {
		return true;
	}
	/**
	 * Disable post status cells that contain readonly statuses.
	 * ex. scheduled posts
	 */
	var contextMenu = hot.getSettings().contextMenu;
	if (typeof contextMenu.items === 'undefined') {
		contextMenu.items = {};
	}
	contextMenu.items.wpse_hide_column = {
		name: vgse_editor_settings.texts.hide_column,
		hidden: function () {
			if (!hot.getSelected()) {
				return true;
			}
			var columnKey = hot.colToProp(hot.getSelected()[0][1]);
			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[columnKey];
			return columnSettings && !columnSettings.allow_to_hide;
		},
		callback: function (key, selection, clickEvent) {
			console.log(key);

			var modifiedData = beGetModifiedItems();

			if (modifiedData.length) {
				alert(vgse_editor_settings.texts.save_changes_before_remove_column);
			} else {

				vgseColumnsVisibilityInit();
				var columnKey = hot.colToProp(selection[0].start.col);
				var $modal = jQuery('.modal-columns-visibility');
				var $columnItem = $modal.find('.columns-enabled .js-column-key[value="' + columnKey + '"]').parent('li');

				$columnItem.appendTo($modal.find('.columns-disabled'));
				$modal.find('.save_post_type_settings').prop('checked', true);
				$modal.find('form').submit();
				notification({mensaje: vgse_editor_settings.texts.column_removed, tipo: 'success', tiempo: 40000});
			}
		}
	};
	contextMenu.items.wpse_open_columns_visibility = {
		name: vgse_editor_settings.texts.open_columns_visibility,
		callback: function (key, selection, clickEvent) {
			var $modal = jQuery('.modal-columns-visibility');
			$modal.remodal().open();
		}
	};
	hot.updateSettings({
		contextMenu: contextMenu
	});
});

