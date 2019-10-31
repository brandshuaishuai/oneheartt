jQuery(document).ready(function () {
	var $filtersForm = jQuery('#be-filters');
	var $filtersPopup = $filtersForm.parents('.remodal');

	if (!$filtersForm.length) {
		return true;
	}

	$filtersPopup.submit(function (e) {
		e.preventDefault();

		var filters = $filtersForm.serialize();
		var $selects = $filtersForm.find('select.select2');
		$selects.each(function () {
			var $select = jQuery(this);
			if (!$select.val()) {
				filters += '&' + $select.attr('name') + '=';
			}
		});

		beAddRowsFilter(filters);

		vgseReloadSpreadsheet();

		$filtersPopup.find('.remodal-cancel').trigger('click');
		return false;
	});



// Automatically set filters from last session
	if (vgse_editor_settings.last_session_filters) {
		beAddRowsFilter(vgse_editor_settings.last_session_filters);
		vgseCustomTooltip(jQuery('.vgse-current-filters a').last(), vgse_editor_settings.texts.last_session_filters_notice, 'right');
	}
});


/**
 * Cell locator
 */
jQuery(document).ready(function () {

	jQuery('body').on('vgSheetEditor:beforeRowsInsert', function (event, response) {

		// Locate cell
		if (typeof window.cellLocatorAlreadyInit === 'undefined') {
			window.cellLocatorAlreadyInit = true;
			var searchField = document.getElementById('cell-locator-input');
			if (searchField) {
				Handsontable.dom.addEvent(searchField, 'keyup', function (event) {
					if (event.keyCode == 13) {
						var queryResult = hot.getPlugin('search').query(this.value);
						if (queryResult.length) {
							hot.scrollViewportTo(queryResult[0].row, queryResult[0].col, true);
						} else if (this.value) {
							alert('Cells not found. Try with another search criteria.');
						}
						hot.render();
						if (!jQuery('#responseConsole .rows-located').length) {
							jQuery('#responseConsole').append('. <span class="rows-located" />');
						}
						jQuery('#responseConsole .rows-located').text(queryResult.length + ' cells located');
					}
				});
			}
		}

		// Locate column		
		if (typeof window.columnLocatorAlreadyInit === 'undefined') {
			window.columnLocatorAlreadyInit = true;
			var columnSearchField = document.getElementById('column-locator-input');
			if (columnSearchField) {
				Handsontable.dom.addEvent(columnSearchField, 'keyup', function (event) {
					if (event.keyCode == 13) {

						var headers = hot.getSettings().colHeaders;
						var firstIndex = null;
						var keyword = this.value.toLowerCase();
						var matches = 0;
						headers.forEach(function (header, index) {
							if (header && header.toLowerCase().indexOf(keyword) > -1) {
								if (matches === 0) {
									firstIndex = index;
								}
								matches++;
							}
						});

						if (firstIndex !== null) {
							hot.selectColumns(firstIndex);
						} else if (this.value) {
							alert('Column not found. Try with another search criteria.');
						}
						if (!jQuery('#responseConsole .columns-located').length) {
							jQuery('#responseConsole').append('. <span class="columns-located" />');
						}
						jQuery('#responseConsole .columns-located').text(matches + ' columns located');
					}
				});
			}
		}
	});
});

