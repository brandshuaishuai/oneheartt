
function vgseEscapeHTML(str) {
	var map = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		"\"": "&quot;",
		"'": "&#39;" // ' -> &apos; for XML only
	};
	return str.replace(/[&<>"']/g, function (m) {
		return map[m];
	});
}
function vgseToggleFullScreen(status) {
	var isActive = jQuery('.wpse-full-screen-notice-content.notice-on').is(':visible');
	if (isActive) {
		jQuery('.wpse-full-screen-notice-content.notice-on').hide();
		jQuery('.wpse-full-screen-notice-content.notice-off').show();
		jQuery('html').removeClass('wpse-full-screen');
	} else {
		jQuery('.wpse-full-screen-notice-content.notice-on').show();
		jQuery('.wpse-full-screen-notice-content.notice-off').hide();
		jQuery('html').addClass('wpse-full-screen');
	}
}
function vgseFormatDate() {
	var d = new Date(),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

	if (month.length < 2)
		month = '0' + month;
	if (day.length < 2)
		day = '0' + day;

	return [year, month, day].join('-');
}
function vgseGuidGenerator() {
	var S4 = function () {
		return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
	};
	return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
}

function vgseCustomTooltip($element, text, position, multipleTimes) {
	if (!position) {
		position = 'bottom';
	}
	$element.tipso({
		position: position,
		tooltipHover: true,
		content: text,
	}).tipso('show');

	if (multipleTimes) {
		$element.hover(function () {
			$element.tipso('hide');
		});
		setTimeout(function () {
			$element.tipso('hide');
		}, 8000);
	}
	setTimeout(function () {
		$element.tipso('hide');
		if (!multipleTimes) {
			$element.tipso('destroy');
		}
	}, 8000);
}
/**
 * Turn query string into object
 * @param str query
 * @returns obj
 */
function beParseParams(query) {
	var query_string = {};
	var vars = query.split("&");
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		pair[0] = decodeURIComponent(pair[0]);
		// We don't decode the pair[1] because we'll send the value to the server encoded
		// The decoding and encoding causes issues with the + and spaces

		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
			query_string[pair[0]] = pair[1];
			// If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
			var arr = [query_string[pair[0]], pair[1]];
			query_string[pair[0]] = arr;
			// If third or later entry with this name
		} else {
			query_string[pair[0]].push(pair[1]);
		}
	}
	return query_string;
}

/**
 * Get rows filters
 * @returns str Filters as query string
 */
function beGetRowsFilters() {
	return (jQuery('body').data('be-filters')) ? jQuery.param(jQuery('body').data('be-filters')) : '';
}
/**
 * Add rows filter
 * @param str|obj filter as query string or object
 * @returns Object|Boolean Current filters object or false on error
 */
function beAddRowsFilter(filter) {
	if (!filter) {
		return false;
	}
	var currentFilters = jQuery('body').data('be-filters');
	if (!currentFilters) {
		currentFilters = {};
	}

	var newFilterObj = (typeof filter === 'string') ? beParseParams(filter) : filter;
	var allFilters = jQuery.extend(currentFilters, newFilterObj);

	var $currentFiltersHolders = jQuery('.vgse-current-filters');
	$currentFiltersHolders.find('.button').remove();

	$currentFiltersHolders.each(function () {
		var $currentFilters = jQuery(this);
		jQuery.each(allFilters, function (filterKey, filterValue) {
			if (filterValue && filterKey.indexOf('meta_query') < 0) {

				var publicValue = (typeof filterValue === 'string') ? filterValue : filterValue.join(', ');
				publicValue = jQuery('<span>' + publicValue + '</span>').text();

				if (publicValue.length > 20) {
					publicValue = publicValue.substring(0, 20) + '...';
				}
				var publicKey = filterKey.replace('[]', '');
				$currentFilters.append('<a href="#" class="button" data-filter-key="' + filterKey + '"><i class="fa fa-remove"></i> ' + publicKey + ': ' + publicValue + '</a>');
			}
		});

		if (allFilters.meta_query) {
			jQuery.each(allFilters.meta_query, function (index, filter) {
				var publicKey = filter.key;
				if (publicKey) {
					var filterKey = 'meta_query';
					var publicValue = filter.value;
					var operator = filter.compare;
					publicValue = jQuery('<span>' + publicValue + '</span>').text();

					if (publicValue.length > 20) {
						publicValue = publicValue.substring(0, 20) + '...';
					}
					$currentFilters.append('<a href="#" class="button advanced-filter" data-filter-key="' + filterKey + '"><i class="fa fa-remove"></i> ' + publicKey + ' ' + operator + ' ' + publicValue + '</a>');
				}
			});
		}

		jQuery('.advanced-filters-list > li').each(function () {
			var $filter = jQuery(this);
			var $field = $filter.find('.wpse-advanced-filters-field-selector');
			var publicKey = $field.val();
			if (publicKey) {
				var filterKey = $field.attr('name');
				var filterValue = $filter.find('.wpse-advanced-filters-value-selector').val();
				var operator = $filter.find('.wpse-advanced-filters-operator-selector option:selected').text();
				var publicValue = (typeof filterValue === 'string') ? filterValue : filterValue.join(', ');
				publicValue = jQuery('<span>' + publicValue + '</span>').text();

				if (publicValue.length > 20) {
					publicValue = publicValue.substring(0, 20) + '...';
				}
				$currentFilters.append('<a href="#" class="button advanced-filter" data-filter-key="' + filterKey + '"><i class="fa fa-remove"></i> ' + publicKey + ' ' + operator + ' ' + publicValue + '</a>');
			}
		});
		if (!$currentFilters.find('.button').length) {
			$currentFilters.hide();
		} else {
			$currentFilters.show();
		}
	});

	jQuery('body').data('be-filters', allFilters);

	return allFilters;
}

/* Ajax calls loop 
 * Execute ajax calls one after another
 * */
function beAjaxLoop(args) {

	//setup an array of AJAX options, each object is an index that will specify information for a single AJAX request

	var defaults = {
		totalCalls: null,
		current: 1,
		url: '',
		method: 'GET',
		dataType: 'json',
		data: {},
		prepareData: function (data, settings) {
			return data;
		},
		onSuccess: function (response, settings) {

		},
		onError: function (jqXHR, textStatus, settings) {

		},
		status: 'running',
	};

	var settings = jQuery.extend(defaults, args);


	//declare your function to run AJAX requests
	function do_ajax() {

		//check to make sure there are more requests to make
		if (settings.current < settings.totalCalls + 1) {

			if (settings.status !== 'running') {
//				console.log('not running');
				return true;
			}

			if (jQuery.isArray(settings.data)) {
				settings.data.push({
					name: 'page',
					value: settings.current
				});
				settings.data.push({
					name: 'totalCalls',
					value: settings.totalCalls
				});
			} else {
				settings.data.page = settings.current;
				settings.data.totalCalls = settings.totalCalls;
			}

//			console.log(settings);

			var data = {
				url: settings.url,
				dataType: settings.dataType,
				data: settings.prepareData(settings.data, settings),
				method: settings.method,
			};
//			console.log(data);
			jQuery.ajax(data).done(function (serverResponse) {

//				console.log(serverResponse);
				var goNext = settings.onSuccess(serverResponse, settings);

				//increment the `settings.current` counter and recursively call this function again
				if (goNext) {
					settings.current++;

					setTimeout(function () {
						do_ajax();
					}, parseInt(vgse_editor_settings.wait_between_batches) * 1000);
				}
			}).fail(function (jqXHR, textStatus) {

//				console.log(jqXHR);
//				console.log(textStatus);
				var goNext = settings.onError(jqXHR, textStatus, settings);
				//increment the `settings.current` counter and recursively call this function again
				if (goNext) {
					settings.current++;
					setTimeout(function () {
						do_ajax();
					}, parseInt(vgse_editor_settings.wait_between_batches) * 1000);
				}
			});
		}
	}

	//run the AJAX function for the first time once `document.ready` fires
	do_ajax();

	return {
		pause: function () {
			settings.status = 'paused';
		},
		resume: function () {
			settings.status = 'running';
//			console.log('resuming');
			do_ajax();
		}
	};
}


//  show or hide loading screen
function loading_ajax(options) {

	if (typeof options === 'boolean') {
		options = {
			'estado': options
		};
	}

	var defaults = {
		'estado': true
	}
	jQuery.extend(defaults, options);

	if (defaults.estado == true) {
		if (!jQuery('body').find('.sombra_popup').length) {
			jQuery('body').append('<div class="sombra_popup be-ajax"><div class="sk-three-bounce"><div class="sk-child sk-bounce1"></div><div class="sk-child sk-bounce2"></div><div class="sk-child sk-bounce3"></div></div></div>');
		}
		jQuery('.sombra_popup').fadeIn(1000);
	} else {
		jQuery('.sombra_popup').fadeOut(800, function () {
//			jQuery('.sombra_popup').remove();
		});
	}
}


// Show notification to user
function notification(options) {
	var defaults = {
		'tipo': 'success',
		'mensaje': '',
		'time': 8600,
		'position': 'top'
	}
	jQuery.extend(defaults, options);

	setTimeout(function () {
		if (defaults.tipo == 'success') {
			var color = 'green';
		} else if (defaults.tipo == 'error') {
			var color = 'red';
		} else if (defaults.tipo == 'warning') {
			var color = 'orange';
		} else {
			var color = 'blue';
		}

		if (defaults.position === 'bottom') {
			jQuery('#ohsnap').css({
				top: 'auto',
				bottom: '5px'
			});
		} else {
			jQuery('#ohsnap').css({
				top: '',
				bottom: ''
			});
		}

		jQuery('#ohsnap').css('z-index', '1100000');
		setTimeout(function () {
			jQuery('#ohsnap').css('z-index', '-1');
		}, defaults.time);
		ohSnap(defaults.mensaje, {duration: defaults.time, color: color});

	}, 500);
}


// Define chunk method to split arrays in groups
if (typeof Array.prototype.chunk === 'undefined') {
	Object.defineProperty(Array.prototype, 'chunk', {
		value: function (chunkSize) {
			var array = this;
			return [].concat.apply([],
					array.map(function (elem, i) {
						return i % chunkSize ? [] : [array.slice(i, i + chunkSize)];
					})
					);
		}
	});
}

/**
 * Show notification to user after a failed ajax request.
 * Ex. the server is not available
 */
jQuery(document).ajaxError(function (event, xhr, ajaxOptions, thrownError) {
//	console.log(event);
//	console.log(xhr);
//	console.log(ajaxOptions);
//	console.log(thrownError);

	loading_ajax({estado: false});
	if (typeof window.vgseDontNotifyServerError === 'boolean' && window.vgseDontNotifyServerError) {
		window.vgseDontNotifyServerError = false;
	} else if (xhr.statusText !== 'abort') {
		if (xhr.status == 400) {
			notification({mensaje: vgse_editor_settings.texts.http_error_400, tipo: 'error', tiempo: 60000});
		} else if (xhr.status == 403) {
			notification({mensaje: vgse_editor_settings.texts.http_error_403, tipo: 'error', tiempo: 60000});
		} else if (xhr.status == 500 || xhr.status == 502 || xhr.status == 505) {
			notification({mensaje: vgse_editor_settings.texts.http_error_500_502_505, tipo: 'error', tiempo: 60000});
		} else if (xhr.status == 503) {
			notification({mensaje: vgse_editor_settings.texts.http_error_503, tipo: 'error', tiempo: 60000});
		} else if (xhr.status == 509) {
			notification({mensaje: vgse_editor_settings.texts.http_error_509, tipo: 'error', tiempo: 60000});
		} else if (xhr.status == 504) {
			notification({mensaje: vgse_editor_settings.texts.http_error_504, tipo: 'error', tiempo: 60000});
		} else {
			notification({mensaje: vgse_editor_settings.texts.http_error_default, tipo: 'error', tiempo: 60000});
		}
	}
});

/**
 * Show notification to user after a successful ajax request with empty response
 */
jQuery(document).ajaxComplete(function (event, xhr, ajaxOptions, thrownError) {

	// We delay this notification to allow the ajax handlers of the individual 
	// requests to disable the notification with window.vgseDontNotifyServerError
	setTimeout(function () {
		if (xhr.statusText !== 'abort' && window.vgse_editor_settings) {
			if (xhr.responseText === '0' || xhr.responseText === 0 || thrownError) {
//		console.log('empty response');
				loading_ajax({estado: false});
				if (typeof window.vgseDontNotifyServerError === 'boolean' && window.vgseDontNotifyServerError) {
					window.vgseDontNotifyServerError = false;
				} else {
					notification({mensaje: vgse_editor_settings.texts.http_error_500_502_505, tipo: 'error', tiempo: 60000});
				}
			}
		}
	}, 500);
});

/**
 * Load posts into the spreadsheet
 * @param obj data ajax request data parameters
 * @param fun callback
 * @param bool customInsert If we want to load rows but use custom success controller.
 */
function beLoadPosts(data, callback, customInsert, removeExisting) {
	loading_ajax({estado: true});

	var timeoutId = setTimeout(function () {
		jQuery('.wpse-stuck-loading').css('display', 'block');
	}, 5000);

	if (!customInsert) {
		customInsert = true;
	}
	if (!removeExisting) {
		removeExisting = false;
	}
	data.action = 'vgse_load_data';
	data.wpse_source_suffix = vgse_editor_settings.wpse_source_suffix || '';

	if (!data.paged) {
		data.paged = 1;
	}

	window.beCurrentPage = data.paged;

	// Apply filters to request
	data.filters = beGetRowsFilters();
	window.beLastLoadRowsAjax = jQuery.ajax({
		url: ajaxurl,
//		url: ajaxurl+'?XDEBUG_PROFILE=1',
		dataType: 'json',
		type: 'POST',
		data: data,
	}).success(function (response) {
		jQuery('.wpse-stuck-loading').hide();
		clearTimeout(timeoutId);

		jQuery('body').trigger('vgSheetEditor:beforeRowsInsert', [response, data, callback, customInsert, removeExisting]);
		if (typeof callback === 'function') {
			callback(response);

			if (customInsert) {
				return true;
			}
		}
		if (response.success) {

			// Add rows to spreadsheet			
			vgseAddFoundRowsCount(response.data.total);

			vgAddRowsToSheet(response.data.rows, null, removeExisting);

			var successMessage = response.data.message || vgse_editor_settings.texts.posts_loaded;
			notification({mensaje: successMessage, tipo: 'info'});
			loading_ajax({estado: false});

		} else {
			// Disable loading screen and notify of error
			loading_ajax({estado: false});

			notification({mensaje: response.data.message, tipo: 'info'});
			vgseAddFoundRowsCount(0);
		}
	});
}

function beSetSaveButtonStatus(status) {
	var $button = jQuery('#vg-header-toolbar .wpse-save');
	if (status) {
		$button.attr('data-remodal-target', 'bulk-save');
		$button.removeClass('disabled');
	} else {
		$button.removeAttr('data-remodal-target');
		$button.addClass('disabled');
	}
}

/**
 * Remove duplicated items from array
 * @param array data
 * @returns array
 */
function beDeduplicateItems(data) {
	if (!data || !data.length) {
		return data;
	}
	var out = {};
	var type = (data[0] instanceof Array) ? 'array' : 'object';
	jQuery.each(data, function (key, item) {
		var id = (type === 'array') ? item[0] : item.ID;

		if (typeof id === 'string') {
			id = parseInt(id);
		}
		if (!out[ id ]) {
			out[ id ] = item;
		}
	});
	return out;
}

/**
 * Get modified object properties
 * @param obj orig
 * @param obj update
 * @returns obj
 */
function beGetModifiedObjectProperties(orig, update) {
	var diff = {};

	Object.keys(update).forEach(function (key) {
		if (!orig || typeof orig[key] === 'undefined' || update[key] != orig[key]) {
			diff[key] = update[key];
		}
	})

	console.log(diff);
	return diff;
}

/**
 * Check if arrays are identical recursively
 * @param array arr1
 * @param array arr2
 * @returns Boolean
 */
function beArraysIdenticalCheck(arr1, arr2) {
	console.log(arr1);
	console.log(arr2);
	if (arr1.length !== arr2.length) {
		return false;
	}
	for (var i = arr1.length; i--; ) {
		if (arr1[i] !== arr2[i]) {
			return false;
		}
	}

	return true;
}
/**
 * Compare arrays and return modified items only.
 * 
 * @param array newData
 * @param array originalData
 * @returns array
 */
function beGetModifiedItems(newData, originalData) {
	if (!newData) {
		var newData = hot.getSourceData();
	}
	if (!originalData) {
		var originalData = window.beOriginalData;
	}

	var newData = beDeduplicateItems(newData);
	var originalData = beDeduplicateItems(originalData);
	var out = [];

	console.log(newData);
	console.log(originalData);

	jQuery.each(newData, function (id, item) {
		console.log(id);
		console.log(item);
		console.log(newData[ id ]);
		console.log(originalData[ id ]);

		var modifiedProperties = beGetModifiedObjectProperties(originalData[id], newData[id]);
		console.log(modifiedProperties);

		var saveData;
		if (typeof originalData[id] === 'undefined' || !jQuery.isEmptyObject(modifiedProperties)) {
			if (!originalData[id] || (originalData[id].provider && vgse_editor_settings.saveFullRowPostTypes && vgse_editor_settings.saveFullRowPostTypes.indexOf(originalData[id].provider) > -1)) {
				saveData = newData[id];
			} else {
				modifiedProperties.ID = id;
				saveData = modifiedProperties;
			}

			out.push(saveData);
		}
	});

	console.log(out);
	return out;
}

/**
 * Get tinymce editor content
 * @returns string
 */
function beGetTinymceContent() {
	if (jQuery('.wp-editor-area').css('display') !== 'none') {
		var content = jQuery('.wp-editor-area').val() || '';
	} else {
		if (document.getElementById('editpost_ifr')) {
			var frame = document.getElementById('editpost_ifr').contentWindow.document || document.getElementById('editpost_ifr').contentDocument;
			var content = frame.body.innerHTML;
		} else {
			var content = '';
		}
	}

	return content;
}

/**
 * Execute function by string name
 */
function vgseExecuteFunctionByName(functionName, context /*, args */) {
	var functionName = jQuery.trim(functionName);
	var args = [].slice.call(arguments).splice(2);
	var namespaces = functionName.split(".");
	var func = namespaces.pop();
	for (var i = 0; i < namespaces.length; i++) {
		context = context[namespaces[i]];
	}
	return context[func].apply(context, args);
}

/**
 * Convert an object to array of values
 * @param obj object
 * @returns Array
 */
function vgObjectToArray(object) {
	var values = [];
	for (var property in object) {
		values.push(object[property]);
	}
	return values;
}


/**
 * Returns a function, that, as long as it continues to be invoked, will not be triggered. The function will be called after it stops being called for N milliseconds. If immediate is passed, trigger the function on the leading edge, instead of the trailing.
 * @param func func
 * @param int wait
 * @param bool immediate
 * @returns func
 */
function _debounce(func, wait, immediate) {
	var timeout, args, context, timestamp, result;

	var later = function () {
		var last = _now() - timestamp;

		if (last < wait && last >= 0) {
			timeout = setTimeout(later, wait - last);
		} else {
			timeout = null;
			if (!immediate) {
				result = func.apply(context, args);
				if (!timeout)
					context = args = null;
			}
		}
	};

	return function () {
		context = this;
		args = arguments;
		timestamp = _now();
		var callNow = immediate && !timeout;
		if (!timeout)
			timeout = setTimeout(later, wait);
		if (callNow) {
			result = func.apply(context, args);
			context = args = null;
		}

		return result;
	};
}
;

/**
 * A (possibly faster) way to get the current timestamp as an integer.
 * @returns int
 */
function _now() {
	var out = Date.now() || new Date().getTime();
	return out;
}

/**
 * Returns a function, that, when invoked, will only be triggered at most once during a given window of time. Normally, the throttled function will run as much as it can, without ever going more than once per wait duration; but if you’d like to disable the execution on the leading edge, pass {leading: false}. To disable execution on the trailing edge, ditto.
 * @param func
 * @param int wait
 * @param obj options
 * @returns func
 */
function _throttle(func, wait, options) {

	if (!wait) {
		wait = 300;
	}
	var context, args, result;
	var timeout = null;
	var previous = 0;
	if (!options)
		options = {};
	var later = function () {
		previous = options.leading === false ? 0 : _now();
		timeout = null;
		result = func.apply(context, args);
		if (!timeout)
			context = args = null;
	};
	return function () {
		var now = _now();
		if (!previous && options.leading === false)
			previous = now;
		var remaining = wait - (now - previous);
		context = this;
		args = arguments;
		if (remaining <= 0 || remaining > wait) {
			if (timeout) {
				clearTimeout(timeout);
				timeout = null;
			}
			previous = now;
			result = func.apply(context, args);
			if (!timeout)
				context = args = null;
		} else if (!timeout && options.trailing !== false) {
			timeout = setTimeout(later, remaining);
		}
		return result;
	};
}
;

/**
 * Remove multiple rows from the sheet by ID
 * @param array rowIds list of IDs to remove
 * @returns null
 */
function vgseRemoveRowFromSheetByID(rowIds) {

	if (rowIds.length) {
		var hotData = hot.getSourceData();
		console.log('Before removal: ', hotData.length);
		rowIds.forEach(function (rowId) {
			hotData = vgseRemovePostFromSheet(rowId, hotData);
		});
		hot.loadData(hotData);
		console.log('After removal: ', hotData.length);
	}
}
/**
 * Remove post ID from array of data
 */
function vgseRemovePostFromSheet(postId, data) {

	console.log(data);
	var newData = [];

	postId = parseInt(postId);
	data.forEach(function (item, id) {
		var item2 = jQuery.extend(true, {}, item);
		console.log(item.ID);

		if (typeof item2.ID === 'string') {
			item2.ID = parseInt(item2.ID);
		}
		console.log(item2.ID);
		console.log(postId);
		if (postId !== item2.ID) {
			newData.push(item);
		}
	});
	return newData;
}

/**
 * Add rows to spreadsheet
 * @param array data Array of objects
 * @param str method append | prepend
 * @returns null
 */
function vgAddRowsToSheet(data, method, removeExisting) {
	if (!method) {
		method = 'append';
	}

	if (!data) {
		data = [];
	}

	if (method === 'prepend') {
		data = data.reverse();
	}

	var hotData = hot.getSourceData();
	console.log('Before removal: ', hotData);


	// Remove existing items from spreadsheet
	if (removeExisting) {
		data.forEach(function (item, id) {
			var item2 = jQuery.extend(true, {}, item);
			item2.ID = parseInt(item2.ID);

			console.log('To remove: ', item2.ID);
			hotData = vgseRemovePostFromSheet(item2.ID, hotData);
		});
	}
	console.log('After removal: ', hotData);

	var sheetIds = hotData.map(function (a) {
		return a.ID;
	});
	for (i = 0; i < data.length; i++) {
		// Don't add new items already existing on spreadsheet,
		// fixes rare mysql bug that paginated requests sometimes bring repeated rows
		if (sheetIds.indexOf(data[i].ID) < 0) {
			if (method === 'append') {
				hotData.push(jQuery.extend(true, {}, data[i]));
			} else {
				hotData.unshift(jQuery.extend(true, {}, data[i]));
			}
		}

	}
	hot.loadData(hotData);
	console.log(hotData);

	jQuery('body').trigger('vgSheetEditor:afterRowsInsert', [data, method, removeExisting]);

	// Save original data, used to compare posts 
	// before saving and save only modified posts.
	if (!window.beOriginalData) {
		window.beOriginalData = [];
	}

	window.beOriginalData = jQuery.merge(window.beOriginalData, data);
}
/**
 * save image in local cache
 */
function wpsePrepareGalleryFilesForCellFormat(gallery, cellCoords) {
	var columnKey = hot.colToProp(cellCoords.col);
	var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[columnKey];
	var multiple = columnSettings && typeof columnSettings.wp_media_multiple !== 'undefined' && columnSettings.wp_media_multiple;

	var currentValue = hot.getDataAtCell(cellCoords.row, cellCoords.col);
	var fileUrls = (multiple && currentValue) ? currentValue.split(',') : [];

	jQuery.each(gallery, function (index, file) {
		fileUrls.push(file.url + '?wpId=' + file.id);
	});

	hot.setDataAtCell(cellCoords.row, cellCoords.col, fileUrls.join(','));
}

/**
 *Init select2 on <select>s
 */
function vgseInitSelect2($selects) {

	if (!$selects) {
		var $selects = jQuery("select.select2");
	}
	$selects.each(function () {
		var config = {
			placeholder: jQuery(this).data('placeholder'),
			minimumInputLength: jQuery(this).data('min-input-length') || 0,
			allowClear: true
		};
		if (jQuery(this).data('remote')) {
			config.ajax = {
				url: ajaxurl,
				delay: 1000,
				data: function (params) {
					var query = {
						search: params.term,
						page: params.page,
						action: jQuery(this).data('action'),
						global_search: jQuery(this).data('global-search') || '',
						output_format: jQuery(this).data('output-format'),
						post_type: jQuery(this).data('post-type') || jQuery('#post-data').data('post-type'),
						nonce: jQuery('#vgse-wrapper').data('nonce'),
					}

					// Query paramters will be ?search=[term]&page=[page]
					return query;
				},
				processResults: function (response) {
					console.log(response);
					if (!response.success) {
						return {
							results: []
						};
					}
					return {
						results: response.data.data
					};
				},
				cache: true
			};
		}
		jQuery(this).select2(config);
	});
}

/**
 * Reload spreadsheet.
 * Removes current rows and loads the rows from the server again.
 */
function vgseReloadSpreadsheet(safeReload) {

	if (safeReload) {
		var fullData = hot.getSourceData();
		fullData = beGetModifiedItems(fullData, window.beOriginalData);
		if (fullData.length) {
			alert(vgse_editor_settings.texts.save_changes_reload_optional);
			return true;
		}
	}

	var nonce = jQuery('.remodal-bg').data('nonce');
	var $container = jQuery("#post-data");

	// Reset internal cache, used to find the modified cells for saving        
	window.beOriginalData = [];
	// Reset spreadsheet
	hot.loadData([]);

	beLoadPosts({
		post_type: $container.data('post-type'),
		nonce: nonce
	});
}

function vgseAddFoundRowsCount(total) {

	window.beFoundRows = total;
	jQuery('.be-total-rows').text(jQuery('.be-total-rows').text().replace(/\d+/, total));
}

function vgseInputToFormattedColumnField(selectedField, $fields, valueFieldSelector) {
	if (typeof vgse_editor_settings.unfiltered_spreadsheet_columns_settings[selectedField] !== 'undefined') {
		var columnSettings = vgse_editor_settings.unfiltered_spreadsheet_columns_settings[selectedField];
		var $value = $fields.find(valueFieldSelector);
		var valueName = $value.attr('name');
		var valueClasses = $value.attr('class');

		// if the field is not a text input, it means it's already formatted, exit
		if ((!$value.is('input') && !$value.is('textarea')) || ($value.attr('type') && $value.attr('type') !== 'text')) {
			return true;
		}
		if (typeof columnSettings.formatted.editor !== 'undefined' && columnSettings.formatted.editor === 'select') {
			$value.replaceWith('<select class="' + valueClasses + '" name="' + valueName + '"><option value="">(' + vgse_editor_settings.texts.empty + ')</option></select>');
			var $newValue = $fields.find('select' + valueFieldSelector);

			$newValue.each(function () {
				var $singleValue = jQuery(this);
				jQuery.each(columnSettings.formatted.selectOptions, function (key, label) {
					if (jQuery.isNumeric(key)) {
						key = label;
					}
					$singleValue.append('<option value="' + key + '">' + label + '</option>');
				});
			});
		} else if (typeof columnSettings.formatted.type !== 'undefined' && columnSettings.formatted.type === 'checkbox') {
			$value.replaceWith('<input type="checkbox" class="' + valueClasses + '" name="' + valueName + '">');
			var $newValue = $fields.find('input' + valueFieldSelector + ':checkbox');
			$newValue.change(function () {
				if (jQuery(this).is(':checked')) {
					jQuery(this).val(columnSettings.formatted.checkedTemplate);
				} else {
					jQuery(this).val(columnSettings.formatted.uncheckedTemplate);
				}
			});
			$newValue.trigger('change');
		}
	}
}