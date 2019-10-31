
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
jQuery(document).ready(function (e) {

	jQuery('body').on('click', '.wpse-toggle-head', function () {
		jQuery(this).next('.wpse-toggle-content').slideToggle();
	});

	if (!jQuery('.be-spreadsheet-wrapper').length) {
		return true;
	}
	(function (Handsontable) {
		var chosenEditor = Handsontable.editors.getEditor('chosen');

		chosenEditor.prototype.prepareOriginalBk = chosenEditor.prototype.prepare;
		chosenEditor.prototype.prepare = function (row, col, prop, td, originalValue, cellProperties) {

			chosenEditor.prototype.prepareOriginalBk.apply(this, arguments);

			this.originalValue = this.originalValue.split(vgse_editor_settings.taxonomy_terms_separator + " ").join(vgse_editor_settings.taxonomy_terms_separator);
		};


		chosenEditor.prototype.getValue = function () {
			if (!this.$textarea.val()) {
				return "";
			}
			if (typeof this.$textarea.val() === "object") {
				return this.$textarea.val().join(vgse_editor_settings.taxonomy_terms_separator + " ");
			}
			return this.$textarea.val();
		};
	})(Handsontable);
	(function (Handsontable) {
		function wpMediaGallery(hotInstance, td, row, column, prop, value, cellProperties) {
			// Optionally include `BaseRenderer` which is responsible for adding/removing CSS classes to/from the table cells.
			Handsontable.renderers.BaseRenderer.apply(this, arguments);

			var postType = jQuery('#post-data').data('post-type');
			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];
			var multiple = typeof columnSettings.wp_media_multiple !== 'undefined' && columnSettings.wp_media_multiple;
			var postId = parseInt(hot.getDataAtRowProp(row, 'ID'));
			var urls = Handsontable.helper.stringify(value);
			var fileIds = [];
			var fileNames = [];

			urls.split(',').forEach(function (url) {
				fileIds.push(jQuery.trim(url.replace(/.+wpId=(\d+)$/, '$1')));

				var imageParts = url.split('/');
				fileNames.push(jQuery.trim(imageParts[imageParts.length - 1].replace(/(.+)\?wpId=(\d+)$/, '$1')));
			});


			var html = '';

			if (urls && urls.indexOf(',') < 0) {
				html += '<div class="vi-inline-preview-wrapper"><img class="vi-preview-img" src="' + urls + '" width="25"></div>';
			}

			if (!columnSettings.formatted.readOnly) {
				html += '<button class="set_custom_images ';
				if (multiple) {
					html += 'multiple';
				}
				html += ' button" data-type="' + columnSettings.data_type + '" data-file="' + fileIds.join(',') + '" data-key="' + prop + '" data-id="' + postId + '"><i class="fa fa-upload"></i></button>';

				if (multiple && urls) {
					html += ' <a href="#image" data-remodal-target="image" class="view_custom_images multiple button" data-type="' + columnSettings.data_type + '" data-key="' + prop + '" data-id="' + postId + '"><i class="fa fa-image"></i></a>';
				}
			}

			if (value) {
				var charactersLimit = 40;
				var fileNamesString = fileNames.join(', ');
				html += jQuery('<span>' + fileNamesString.substring(0, charactersLimit) + '</span>').text();

				if (fileNamesString.length > charactersLimit) {
					html += '...';
				}
			} else {
				html += '(' + vgse_editor_settings.texts.empty + ')';
			}

			if (columnSettings.formatted.readOnly) {
				html = '<i class="fa fa-lock vg-cell-blocked"></i> ' + html;
				html = html.replace(/set_custom_images|view_custom_images/g, '');
			}

			td.innerHTML = html;
			return td;
		}

		// Register an alias
		Handsontable.renderers.registerRenderer('wp_media_gallery', wpMediaGallery);

	})(Handsontable);

	(function (Handsontable) {
		function wpTinyMCE(hotInstance, td, row, column, prop, value, cellProperties) {
			// Optionally include `BaseRenderer` which is responsible for adding/removing CSS classes to/from the table cells.
			Handsontable.renderers.BaseRenderer.apply(this, arguments);

			var postType = jQuery('#post-data').data('post-type');
			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];

			if (typeof columnSettings.formatted.wpse_template_key === 'undefined') {
				columnSettings.formatted.wpse_template_key = 'tinymce_cell_template';
			}

			var html = vgse_editor_settings[ columnSettings.formatted.wpse_template_key ];
			var postId = parseInt(hot.getDataAtRowProp(row, 'ID'));

			var html = html.replace(/\{key\}/g, prop);
			var html = html.replace(/\{type\}/g, columnSettings.data_type);
			var html = html.replace(/\{id\}/g, postId);
			var html = html.replace(/\{post_title\}/g, hot.getDataAtCell(row, '1'));

			if (value) {
				var charactersLimit = 30;
				html += jQuery('<span>' + value + '</span>').text().substring(0, charactersLimit);

				if (value.length > charactersLimit) {
					html += '...';
				}
			} else {
				html += '(' + vgse_editor_settings.texts.empty + ')';
			}

			if (columnSettings.formatted.readOnly) {
				html = '<i class="fa fa-lock vg-cell-blocked"></i> ' + html;
				html = html.replace(/btn-popup-content/g, '');
			}

			td.innerHTML = html;
			return td;
		}

		// Register an alias
		Handsontable.renderers.registerRenderer('wp_tinymce', wpTinyMCE);

	})(Handsontable);

	(function (Handsontable) {
		function wpHandsontable(hotInstance, td, row, column, prop, value, cellProperties) {
			// Optionally include `BaseRenderer` which is responsible for adding/removing CSS classes to/from the table cells.
			Handsontable.renderers.BaseRenderer.apply(this, arguments);

			var postType = jQuery('#post-data').data('post-type');
			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];
			var html = vgse_editor_settings.handsontable_cell_template;
			var postId = parseInt(hot.getDataAtRowProp(row, 'ID'));

			var html = html.replace(/\{key\}/g, prop);
			var html = html.replace(/\{type\}/g, columnSettings.data_type);
			var html = html.replace(/\{id\}/g, postId);
			var html = html.replace(/\{post_title\}/g, hot.getDataAtCell(row, '1'));


			var fullData = hot.getSourceData();
			var modalSettings = jQuery.extend(true, columnSettings, fullData[row]);
			modalSettings.post_id = postId;

			var html = html.replace(/\{modal_settings\}/g, vgseEscapeHTML(JSON.stringify(modalSettings)));
			var html = html.replace(/\{value\}/g, vgseEscapeHTML(JSON.stringify(value)));

			var html = html.replace(/\{button_label\}/g, modalSettings.edit_button_label);

			if (value && value !== '[]') {
				html += ' ...';
			} else {
				html += ' (' + vgse_editor_settings.texts.empty + ')';
			}

			if (columnSettings.formatted.readOnly) {
				html = '<i class="fa fa-lock vg-cell-blocked"></i> ' + html;
				html = html.replace(/(btn-popup-content|button-custom-modal-editor|button-handsontable)/g, '');
			}

			td.innerHTML = html;
			return td;
		}

		// Register an alias
		Handsontable.renderers.registerRenderer('wp_handsontable', wpHandsontable);

	})(Handsontable);
	(function (Handsontable) {
		function wpExternalButtonCell(hotInstance, td, row, column, prop, value, cellProperties) {
			// Optionally include `BaseRenderer` which is responsible for adding/removing CSS classes to/from the table cells.
			Handsontable.renderers.BaseRenderer.apply(this, arguments);

			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];

			var html = '<a target="_blank" href="' + value + '" class="button"><i class="fa fa-external-link"></i> ' + columnSettings.title + '</a>';
			td.innerHTML = html;
			return td;
		}

		// Register an alias
		Handsontable.renderers.registerRenderer('wp_external_button', wpExternalButtonCell);

	})(Handsontable);

	(function (Handsontable) {
		function wpLockedCell(hotInstance, td, row, column, prop, value, cellProperties) {
			// Optionally include `BaseRenderer` which is responsible for adding/removing CSS classes to/from the table cells.
			Handsontable.renderers.BaseRenderer.apply(this, arguments);

			var postType = jQuery('#post-data').data('post-type');
			var columnSettings = vgse_editor_settings.final_spreadsheet_columns_settings[prop];

			if (!columnSettings.lock_template_key) {
				columnSettings.lock_template_key = 'lock_cell_template';
			}

			// Limit value length and convert to plain text
			if (typeof value === 'string') {
				var charactersLimit = vgse_editor_settings.is_premium ? 120 : 55;
				value = jQuery('<span>' + value + '</span>').text().substring(0, charactersLimit);

				if (value.length > charactersLimit) {
					value += '...';
				}
			}

			if (typeof value === 'string' && value.indexOf('vg-cell-blocked') > -1) {
				var html = value;
			} else {
				var html = vgse_editor_settings[ columnSettings.lock_template_key ];

				var html = html.replace(/\{key\}/g, prop);
				var html = html.replace(/\{value\}/g, value);
				var html = html.replace(/\{post_type\}/g, postType);
				var html = html.replace(/set_custom_images|view_custom_images|button-handsontable|button-custom-modal-editor|data-remodal-target="image"/g, '');
			}

			td.innerHTML = html;
			return td;
		}

		// Register an alias
		Handsontable.renderers.registerRenderer('wp_locked', wpLockedCell);

	})(Handsontable);

	if (jQuery('.wpse-full-screen-notice').length) {
		// Enable it by default
		vgseToggleFullScreen();
		var $fullScreenToggle = jQuery('.wpse-full-screen-notice-content .wpse-full-screen-toggle');
		$fullScreenToggle.click(function (e) {
			e.preventDefault();
			vgseToggleFullScreen();
		});
	}

	jQuery('body').on('click', '.dismiss-review-tip', function (e) {
		if (!jQuery(this).attr('href')) {
			e.preventDefault();
		}

		jQuery(this).parent('.review-tip').remove();
		var nonce = jQuery('.remodal-bg').data('nonce');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {action: "vgse_dismiss_review_tip", nonce: nonce},
			dataType: 'json',
		});
	});


	jQuery('.wpse-stuck-loading').appendTo('body');
	jQuery('body').on('click', '.wpse-stuck-loading button', function (e) {
		e.preventDefault();
		loading_ajax(false);

		if (window.beLastLoadRowsAjax) {
			window.beLastLoadRowsAjax.abort();
		}
		jQuery('.wpse-stuck-loading').hide();
	});

	if (!vgse_editor_settings.user_has_saved_sheet) {
		vgseCustomTooltip(jQuery('.vg-toolbar .settings-container'), vgse_editor_settings.texts.settings_moved_submenu, 'top');
	}


// Image previews
	jQuery('.vi-preview-wrapper').appendTo('body');
	jQuery('body').on('mouseleave', '.vi-preview-img', function (e) {
		console.log(jQuery(this));
		jQuery('.vi-preview-wrapper').hide();
	});
	jQuery('body').on('mouseenter', '.vi-preview-img', function (e) {
		console.log(jQuery(this));
		var $img = jQuery(this).first();
		var img = jQuery(this)[0].outerHTML;

		if ($img.attr('src').indexOf('wpse_no_zoom') > -1) {
			return true;
		}

		var imgTag = '<img src="' + $img.attr('src') + '" />';
		console.log(img);
		console.log('imgTag: ', imgTag);
		var $wrapper = jQuery('.vi-preview-wrapper');
		var largeImageAtTheLeft = (jQuery(window).width() - $wrapper.width()) < ($img.offset().left + $img.width() - jQuery(document).scrollLeft());

		if (largeImageAtTheLeft) {
			$wrapper.css({
				right: 'auto',
				left: '0px'
			});
		} else {
			$wrapper.css({
				right: '0px',
				left: 'auto'
			});
		}

		$wrapper.empty();
		$wrapper.show();

		$wrapper.append(imgTag);
	});



	// go to the top
	jQuery('#go-top').click(function (e) {
		e.preventDefault();
		var body = jQuery("html, body");
		body.stop().animate({scrollTop: 0}, '300', 'swing', function () {
		});
	});


	// Add #ohsnap element, which contains the user notifications
	jQuery('body').append('<div id="ohsnap" style="z-index: -1"></div>');

	// Init labelauty, which converts checkboxes into switch buttons
	var $wrapper = jQuery('#vgse-wrapper');

	if ($wrapper.length) {
		$wrapper.find(".vg-toolbar input:checkbox").labelauty();
	}

	// Init tooltips
	jQuery('body').find('.tipso').tipso({
		size: 'small',
		tooltipHover: true,
		background: '#444444'

	});

	/* internal variables */
	var
			$container = jQuery("#post-data"),
			$console = jQuery("#responseConsole"),
			$parent = jQuery('#vgse-wrapper'),
			autosaveNotification,
			maxed = false,
			hot;

	// is cells formatting enabled
	if (jQuery('#formato').is(':checked')) {
		format = false;
	} else {
		format = true;
	}

// Initialize select2 on selects

	setTimeout(function () {
		vgseInitSelect2();
	}, 2000);

// Handsontable settings
	var handsontableArgs = {
		colWidths: vgObjectToArray(vgse_editor_settings.colWidths),
		colHeaders: vgObjectToArray(vgse_editor_settings.colHeaders),
		columns: columns_format(format),
		rowHeaders: true, //Cabeceras
		startRows: vgse_editor_settings.startRows, //Cantidad de filas
		startCols: vgse_editor_settings.startCols, //Cantidad de columnas
		currentRowClassName: 'currentRow',
		currentColClassName: 'currentCol',
		fillHandle: false,
		columnSorting: true,
		contextMenu: {
			items: {
				'undo': {},
				'redo': {},
				'separator1': {
					name: '---------'
				},
				'copy': {},
				'cut': {},
				'how_to_paste': {
					name: 'Paste using keyboard: Ctrl+V'
				},
				'separator2': {
					name: '---------'
				},
				'make_read_only': {},
				'freeze_column': {},
				'unfreeze_column': {},
				'realign_cells': {
					name: 'Realign cells',
					callback: function (key, selection, clickEvent) {
						hot.render();
					}
				},
			}
		},
		autoWrapRow: true,
		autoRowSize: false,
		autoColumnSize: false,
		viewportRowRenderingOffset: 20,
		viewportColumnRenderingOffset: 4,
		wordWrap: true,
		minSpareCols: 0,
		minSpareRows: 0,
		width: null,
		height: null,
		manualColumnFreeze: true,
		copyRowsLimit: 99999999, // maximum number of rows that can be copied
		copyColsLimit: 99999999, // maximum number of columns that can be copied
		afterChange: _throttle(function (changes) {
			console.log('Change detected, enabled saving: ', new Date(), '. changes: ', changes);
			var hasChanged = false;
			if (changes && changes.length) {
				changes.forEach(function (change) {
					if (change[2] !== change[3]) {
						hasChanged = true;
						return true;
					}
				});
			}
			if (hasChanged) {
				beSetSaveButtonStatus(true);
			}
		}, 4000, {
			leading: true,
			trailing: true
		}),
		beforeCopy: function (data, coords) {
			// data -> [[1, 2, 3], [4, 5, 6]]
			// coords -> [{startRow: 0, startCol: 0, endRow: 1, endCol: 2}]

			data.forEach(function (row, rowIndex) {
				row.forEach(function (cell, cellIndex) {
					if (typeof cell === 'string' && cell.indexOf('vg-cell-blocked') > -1) {
						data[rowIndex][cellIndex] = jQuery.trim(jQuery('<span>' + cell + '</span>').text());
					}
				});
			});
			return data;
		}
	};

	if (vgse_editor_settings.debug) {
		handsontableArgs.debug = vgse_editor_settings.debug;
	}

	var customHandsontableArgs = (vgse_editor_settings.custom_handsontable_args) ? JSON.parse(vgse_editor_settings.custom_handsontable_args) : {};
	var finalHandsontableArgs = jQuery.extend(handsontableArgs, customHandsontableArgs);

	hot = new Handsontable($container[0], finalHandsontableArgs);


	beSetSaveButtonStatus(false);
	window.hot = hot;
	window.beFoundRows = 0;

	/**
	 * Load initial posts
	 */
	$parent.find('button[name=load]').click(function () {
		var nonce = jQuery('.remodal-bg').data('nonce');

		beLoadPosts({
			post_type: $container.data('post-type'),
			nonce: nonce
		});

	});

	// Load rows after 400ms to give time to other plugins to hook into the loading process
	if (!vgse_editor_settings.disable_automatic_loading_rows) {
		setTimeout(function () {
			$parent.find('button[name=load]').click();
		}, 400);
	}

	/*
	 * If there are no posts, show tooltip asking to create posts
	 */
	jQuery('body').on('vgSheetEditor:beforeRowsInsert', function (event, response) {
		console.log('beforeRowsInsert');
		console.log(response);

		if (!response.success) {

			vgseCustomTooltip(jQuery('#addrow'), vgse_editor_settings.texts.add_posts_here);
		}
	});

	/**
	 * Save changes
	 */
	// Close modal when clicking the cancel button
	jQuery('.bulk-save.remodal').find('.remodal-cancel').click(function (e) {
		var modalInstance = jQuery('[data-remodal-id="bulk-save"]').remodal();
		modalInstance.close();
		jQuery('html,body').scrollLeft(0)
	});
	/**
	 * Change from "saving" state to "confirm before saving" state after closing the modal
	 */
	jQuery('.bulk-save.remodal .bulk-saving-screen').find('.remodal-cancel').click(function (e) {
		jQuery('html,body').scrollLeft(0)

		var $button = jQuery(this);
		var $modal = $button.parents('.remodal');

		$modal.find('.be-saving-warning').show();
		$modal.find('.bulk-saving-screen').hide();
		$modal.find('#be-nanobar-container').empty();
		$button.addClass('hidden');
		$modal.find('.response').empty();
	});
	/**
	 * Change from "confirm before saving" state to "saving" on save modal
	 */
	jQuery(document).on('opening', '[data-remodal-id="bulk-save"]', function () {
		if (vgse_editor_settings.user_has_saved_sheet) {
			jQuery('body').find('.be-start-saving').click();
		}
	});
	jQuery('body').on('click', '.wpse-save.disabled', function (e) {
		e.preventDefault();
		notification({mensaje: vgse_editor_settings.texts.no_changes_to_save, tipo: 'info'});
	});
	jQuery('.bulk-save.remodal').find('.remodal-confirm').click(function (e) {
		var $button = jQuery(this);
		var $modal = $button.parents('.remodal');

		$modal.find('.be-saving-warning').show();
		$modal.find('.bulk-saving-screen').hide();
		$modal.find('#be-nanobar-container').empty();
		$modal.find('.response').empty();
	});
	/**
	 * Save changes - Start saving
	 */
	jQuery('body').find('.be-start-saving').click(function (e) {
		e.preventDefault();

		// Mark flag to not show the safety notifications because the 
		// user already knows how to save changes
		vgse_editor_settings.user_has_saved_sheet = 1;

		// Hide warning and start saving screen

		var $warning = jQuery(this).parents('.be-saving-warning');
		var $progress = $warning.next();

		$progress.find('.be-loading-anim').show();
		$warning.fadeOut();
		$progress.fadeIn();

		console.log($warning);
		console.log($progress);


		var nonce = jQuery('.remodal-bg').data('nonce');


		// Init progress bar
		var options = {
			classname: 'be-progress-bar',
			id: 'be-progress-bar',
			target: document.getElementById('be-nanobar-container')
		};

		var nanobar = new Nanobar(options);
		// We start progress bar with 1% so it doesn't look completely empty
		nanobar.go(1);

		// Get posts that need saving
		var fullData = hot.getSourceData();

		fullData = beGetModifiedItems(fullData, window.beOriginalData);

		console.log(fullData);
		console.log(!fullData);

		jQuery('.saving-now-message').show();
		setTimeout(function () {
			if (!jQuery('.saving-complete-message').length) {
				jQuery('.tip-saving-speed-message').show();
			}
		}, 5500);

		// No posts to save found
		if (!fullData.length) {

			jQuery($progress).find('.response').append('<p>' + vgse_editor_settings.texts.no_changes_to_save + '</p>');
			loading_ajax({estado: false});

			beSetSaveButtonStatus(false);
			$progress.find('.remodal-cancel').removeClass('hidden');
			$progress.find('.be-loading-anim').hide();

			setFormSubmitting();
			return true;
		}

		// Start saving posts, start ajax loop
		beAjaxLoop({
			totalCalls: Math.ceil(fullData.length / parseInt(vgse_editor_settings.save_posts_per_page)),
			url: ajaxurl,
			dataType: 'json',
			method: 'POST',
			data: {
				'data': [],
				'post_type': $container.data('post-type'),
				'action': 'vgse_save_data',
				'nonce': nonce,
				'filters': beGetRowsFilters()
			},
			prepareData: function (data, settings) {
				var dataParts = fullData.chunk(parseInt(vgse_editor_settings.save_posts_per_page));

				data.data = dataParts[ settings.current - 1 ];

				return data;
			},
			onSuccess: function (res, settings) {


				// if the response is empty or has any other format,
				// we create our custom false response
				if (!res || (res.success !== true && !res.data)) {
					res = {
						data: {
							message: vgse_editor_settings.texts.http_error_try_now
						},
						success: false
					};
				}

				// If error
				if (!res.success) {

					// show error message
					jQuery($progress).find('.response').append('<p>' + res.data.message + '</p>');

					// Ask the user if he wants to retry the same post
					var goNext = confirm(res.data.message);

					// stop saving if the user chose to not try again
					if (!goNext) {
						jQuery($progress).find('.response').append(vgse_editor_settings.texts.saving_stop_error);
						$progress.find('.remodal-cancel').removeClass('hidden');
						jQuery('.bulk-saving-screen .response').scrollTop(jQuery('.bulk-saving-screen .response')[0].scrollHeight);
						return false;
					}
					// reset pointer to try the same batch again
					settings.current--;
					jQuery('.bulk-saving-screen .response').scrollTop(jQuery('.bulk-saving-screen .response')[0].scrollHeight);
					return true;
				}

				nanobar.go(settings.current / settings.totalCalls * 100);

				// Remove rows of posts deleted
				if (res.data.deleted.length) {
					vgseRemoveRowFromSheetByID(res.data.deleted);
				}

				// Display message saying the number of posts saved so far
				var updated = (parseInt(vgse_editor_settings.save_posts_per_page) * settings.current > fullData.length) ? fullData.length : parseInt(vgse_editor_settings.save_posts_per_page) * settings.current;
				var text = vgse_editor_settings.texts.paged_batch_saved.replace('{updated}', updated);
				var text = text.replace('{total}', fullData.length);
				jQuery($progress).find('.response').append('<p>' + text + '</p>');

				// is complete, show notification to user, hide loading screen, and display "close" button
				if (settings.current === settings.totalCalls) {

					jQuery('.tip-saving-speed-message, .saving-now-message').hide();
					var successMessage = vgse_editor_settings.texts.everything_saved;

					if (vgse_editor_settings.texts.ask_review) {
						successMessage += '<br>' + vgse_editor_settings.texts.ask_review;
					}
					jQuery($progress).find('.response').empty().append('<p class="saving-complete-message">' + successMessage + '</p>');

					loading_ajax({estado: false});


					notification({mensaje: vgse_editor_settings.texts.everything_saved});

					$progress.find('.remodal-cancel').removeClass('hidden');
					$progress.find('.be-loading-anim').hide();

					jQuery('body').trigger('vgSheetEditor/afterSavingChanges');

					setFormSubmitting();

					beSetSaveButtonStatus(false);

					// Reset original data cache, so the modified cells that we save are not considered modified anymore.
					window.beOriginalData = jQuery.extend(true, [], hot.getSourceData());

					// Remove all the posts with status=delete that were deleted.
					hot.getSourceData().forEach(function (item, id) {
						if (typeof item.post_status !== 'undefined' && item.post_status === 'delete') {
							hot.alter('remove_row', id);
						}
					});

				} else {

				}

				// Move scroll to the button to show always the last message in the saving status section
				setTimeout(function () {
					jQuery('.bulk-saving-screen .response').scrollTop(jQuery('.bulk-saving-screen .response')[0].scrollHeight);
				}, 600);

				return true;
			},
			onError: function (jqXHR, textStatus, settings) {
				console.log('error cb');

				// Ask the user if he wants to retry the same post
				var goNext = confirm(vgse_editor_settings.texts.http_error_try_now);
				$progress.find('.be-loading-anim').hide();

				// stop saving if the user chose to not try again
				if (!goNext) {
					jQuery($progress).find('.response').append(vgse_editor_settings.texts.saving_stop_error);
					$progress.find('.remodal-cancel').removeClass('hidden');
					jQuery('.bulk-saving-screen .response').scrollTop(jQuery('.bulk-saving-screen .response')[0].scrollHeight);
					return false;
				}
				window.vgseDontNotifyServerError = true;
				// reset pointer to try the same batch again
				settings.current--;
				nanobar.go(settings.current / settings.totalCalls * 100);
				jQuery('.bulk-saving-screen .response').scrollTop(jQuery('.bulk-saving-screen .response')[0].scrollHeight);
				return true;

			}});
	});

	/**
	 * Save image cells, single image
	 */
	if (typeof wp !== 'undefined' && wp.media) {
		jQuery('body').delegate('.set_custom_images:not(.multiple)', 'click', function (e) {
			e.preventDefault();
			loading_ajax({estado: true});
			var button = jQuery(this);
			var $cell = button.parent('td');
			var cellCoords = hot.getCoords($cell[0]);
			console.log(hot.getDataAtCell(cellCoords.row, cellCoords.col));
			var scrollLeft = jQuery('html,body').scrollLeft();
			var id = button.data('id');
			var key = button.data('key');
			var type = button.data('type');
			var file = button.data('file');
			var gallery = [];

			var scrollTop = jQuery(document).scrollTop();
			var currentInfiniteScrollStatus = jQuery('#infinito').prop('checked');
			jQuery('#infinito').prop('checked', false);

			media_uploader = wp.media({
				frame: "post",
				state: "insert",
				multiple: false
			});

// Allow to save images by URL
			media_uploader.state('embed').on('select', function () {
				var state = media_uploader.state(),
						type = state.get('type'),
						embed = state.props.toJSON();

				embed.url = embed.url || '';

				console.log(embed);
				console.log(type);
				console.log(state);

				if (type === 'image' && embed.url) {
					// Guardar img					
					wpsePrepareGalleryFilesForCellFormat([{
							url: embed.url,
							id: embed.url
						}], cellCoords);
				}



			});
			media_uploader.on('open', function () {
				var selection = media_uploader.state().get('selection');
				var selected = file; // the id of the image
				if (selected) {
					selection.add(wp.media.attachment(selected));
				}
			});
			media_uploader.on('close', function () {
				jQuery('html,body').scrollLeft(scrollLeft);
				jQuery(window).scrollTop(scrollTop);
				jQuery('#infinito').prop('checked', currentInfiniteScrollStatus);
			});
			media_uploader.on("insert", function () {
				jQuery('html,body').scrollLeft(scrollLeft);

				var length = media_uploader.state().get("selection").length;
				var images = media_uploader.state().get("selection").models

				console.log(images);
				if (!images.length) {
					return true;
				}
				for (var iii = 0; iii < length; iii++) {
					gallery.push({
						url: images[iii].attributes.url,
						id: images[iii].id
					});
				}

				button.data('file', images[0].id);

				wpsePrepareGalleryFilesForCellFormat(gallery, cellCoords);
			});
			media_uploader.open();
			loading_ajax({estado: false});
			return false;
		});
	}

	/**
	 * Save image cells, multiple images
	 */
	if (typeof wp !== 'undefined' && wp.media) {
		jQuery('body').delegate('.set_custom_images.multiple', 'click', function (e) {
			e.preventDefault();

			loading_ajax({estado: true});
			var button = jQuery(this);
			var $cell = button.parent('td');
			var cellCoords = hot.getCoords($cell[0]);
			console.log(hot.getDataAtCell(cellCoords.row, cellCoords.col));
			var scrollLeft = jQuery('html,body').scrollLeft();
			var id = button.data('id');
			var key = button.data('key');
			var type = button.data('type');
			var gallery = [];

			var scrollTop = jQuery(document).scrollTop();
			var currentInfiniteScrollStatus = jQuery('#infinito').prop('checked');
			jQuery('#infinito').prop('checked', false);

			media_uploader = wp.media({
				frame: "post",
				state: "insert",
				multiple: true
			});

// Allow to save images by url
			media_uploader.state('embed').on('select', function () {
				var state = media_uploader.state(),
						type = state.get('type'),
						embed = state.props.toJSON();

				embed.url = embed.url || '';

				console.log(embed);
				console.log(type);
				console.log(state);

				if (type === 'image' && embed.url) {
					// Guardar img					

					wpsePrepareGalleryFilesForCellFormat([{
							url: embed.url,
							id: embed.url
						}], cellCoords);
				}



			});

			media_uploader.on('close', function () {
				jQuery('html,body').scrollLeft(scrollLeft);
				jQuery(window).scrollTop(scrollTop);
				jQuery('#infinito').prop('checked', currentInfiniteScrollStatus);
			});
			media_uploader.on("insert", function () {
				jQuery('html,body').scrollLeft(scrollLeft);

				var length = media_uploader.state().get("selection").length;
				var images = media_uploader.state().get("selection").models
				console.log(images);
				for (var iii = 0; iii < length; iii++) {
					gallery.push({
						url: images[iii].attributes.url,
						id: images[iii].id
					});
				}

				wpsePrepareGalleryFilesForCellFormat(gallery, cellCoords);
			});
			media_uploader.open();
			loading_ajax({estado: false});
			return false;
		});
	}

	/**
	 * Preview image on image cells, single image
	 */
	jQuery('body').delegate('.view_custom_images', 'click', function () {
		var button = jQuery(this);
		var $cell = button.parent('td');
		var cellCoords = hot.getCoords($cell[0]);
		var images = hot.getDataAtCell(cellCoords.row, cellCoords.col);

		var html = '';
		images.split(',').forEach(function (image) {
			html += '<div><img src="' + jQuery.trim(image) + '" width="425px" /></div>';
		});
		jQuery('div[data-remodal-id=image] .modal-content').html(html);
		jQuery('[data-remodal-id=image]').remodal();
	});

	/**
	 * Move to next post on tinymce cells modal
	 */
	jQuery('button.siguiente').click(function () {
		var element = jQuery(this);
		var pos = element.data('pos');
		var $remodalWrapper = element.parents('.remodal-wrapper');
		var key = $remodalWrapper.find('.remodal-confirm.guardar-popup-tinymce').data('key');
		jQuery('.btn-popup-content.button-tinymce-' + key).eq(pos).trigger('click');
	});

	/**
	 * Move to previous post on tinymce cells modal
	 */
	jQuery('button.anterior').click(function () {
		var element = jQuery(this);
		var pos = element.data('pos');
		var $remodalWrapper = element.parents('.remodal-wrapper');
		var key = $remodalWrapper.find('.remodal-confirm.guardar-popup-tinymce').data('key');
		jQuery('.btn-popup-content.button-tinymce-' + key).eq(pos).trigger('click');
	});


	/**
	 * Open tinymce cell modal
	 */
	jQuery('body').delegate('.btn-popup-content', 'click', function () {
		var element = jQuery(this);
		var post_id = element.data('id');
		var key = element.data('key');
		var type = element.data('type');
		var pos = element.parents('tr').index();
		var length = element.parents('tbody').find('tr').length;

		var $button = jQuery(this);
		var $cell = $button.parent('td');
		var cellCoords = hot.getCoords($cell[0]);
		var postContent = hot.getDataAtCell(cellCoords.row, cellCoords.col);
		var postTitle = hot.getDataAtCell(cellCoords.row, 1);

		// Make the tinymce editor taller by default, wp_editor args didn't work.
		if (!window.tinymceAutoResized) {
			window.tinymceAutoResized = true;
			jQuery('#editpost_ifr').height(200);
		}

		// Display or hide the unnecesary navigation buttons.
		// If first post, hide "previous" button.
		// If last post, hide "next" button
		if (pos === 0) {
			jQuery('button.anterior').hide();
			jQuery('button.anterior').next('.tipso').hide();
		} else {
			jQuery('button.anterior').show();
			jQuery('button.anterior').next('.tipso').show();
		}
		if (pos === (length - 1)) {
			jQuery('button.siguiente').hide();
			jQuery('button.siguiente').next('.tipso').hide();
		} else {
			jQuery('button.siguiente').show();
			jQuery('button.siguiente').next('.tipso').show();
		}

		jQuery('button.anterior').data('pos', pos - 1);
		jQuery('button.siguiente').data('pos', pos + 1);


		if (postTitle) {
			jQuery('.modal-tinymce-editor .post-title-modal span').text(postTitle).show();
		} else {
			jQuery('.modal-tinymce-editor .post-title-modal').hide();
		}

		// Add content to tinymce editor
		setTimeout(function () {
			if (jQuery('.wp-editor-area').css('display') !== 'none') {
				jQuery('.wp-editor-area').empty();
				jQuery('.wp-editor-area').val(postContent);
			} else {
				if (document.getElementById('editpost_ifr')) {
					var frame = document.getElementById('editpost_ifr').contentWindow.document || document.getElementById('editpost_ifr').contentDocument;
					frame.body.innerHTML = postContent;
				}
			}

			window.originalTinyMCEData = beGetTinymceContent();


			jQuery('.remodal2 .remodal-confirm').data('post_id', post_id);
			jQuery('.remodal2 .remodal-confirm').data('key', key);
			jQuery('.remodal2 .remodal-confirm').data('type', type);
			jQuery('.remodal2 .remodal-confirm').data('cellCoords', cellCoords);
			//console.log(jQuery('.remodal2 .remodal-confirm').data('post_id'));

			jQuery('[data-remodal-id="editor"]').remodal().open();
		}, 500);
	});

	/**
	 * Save changes on tinymce editor
	 */
	jQuery('.guardar-popup-tinymce').click(function (e) {
		var element = jQuery('.remodal2 .remodal-confirm');
		var cellCoords = element.data('cellCoords');

		// Get tinymce editor content
		var content = beGetTinymceContent();
		hot.setDataAtCell(cellCoords.row, cellCoords.col, content);
	});

	/**
	 * Load more posts in the spreadsheet
	 */
	$parent.find('button[name=mas]').click(function () {
		if (jQuery('#formato').is(':checked')) {
			format = true;
		} else {
			format = false;
		}
		var nonce = jQuery('.remodal-bg').data('nonce');

		beLoadPosts({
			post_type: $container.data('post-type'),
			paged: window.beCurrentPage + 1,
			nonce: nonce
		}, function (response) {

			if (response.success) {
				vgseAddFoundRowsCount(response.data.total);
				vgAddRowsToSheet(response.data.rows);

				loading_ajax({estado: false});
				var successMessage = response.data.message || vgse_editor_settings.texts.posts_loaded;
				notification({mensaje: successMessage});
				//Para detener el scroll mientras se ejecuta otro y volver a activarlo
				window.scrroll = true;

				if (!response.data || !response.data.rows.length) {
					window.scrroll = false;
				}
			} else {

				loading_ajax({estado: false});
				notification({mensaje: response.data.message, tipo: 'info', time: 30000});
				window.scrroll = false;
			}
		});
	});


	/**
	 * Init infinite scroll
	 */
	var contenedor = jQuery('#post-data');
	var cont_offset = contenedor.offset();
	window.scrroll = true;
	window.isAddColumnNotified = false;
	var countRows = hot.countRows();
	var sheetWidth = contenedor.width();
	var sheetWideEnough = sheetWidth > jQuery(window).width();
	var documentBiggerThanScreen = (jQuery(document).width() + 200) > jQuery(window).width();
	jQuery(window).on('scroll', _throttle(function () {
		var isScrollDown = scrollDown('infiniteLoad');
		console.log('scrolled2');
		// Infinite scroll check
		if (jQuery('#infinito').is(':checked') && jQuery(document).height() > jQuery(window).height() && typeof window.beOriginalData !== 'undefined') {
			if ((jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) && window.scrroll === true && isScrollDown) {
				jQuery('button[name="mas"]').trigger('click');
				window.scrroll = false;
			}
		}
		// Scrolled to the right, show missing column hint
		var almostFinishedHorizontalScroll = (jQuery(window).scrollLeft() + jQuery(window).width()) >= (jQuery(document).width() - 400);
		if (sheetWideEnough && vgse_editor_settings.texts.hint_missing_column_on_scroll && documentBiggerThanScreen && almostFinishedHorizontalScroll && !window.isAddColumnNotified && !isScrollDown) {
			window.isAddColumnNotified = true;

			notification({
				mensaje: vgse_editor_settings.texts.hint_missing_column_on_scroll,
				tipo: 'info',
				time: '40000',
				position: 'bottom'
			});
		}
	}, 500, {
		leading: true,
		trailing: true
	}));

	/**
	 * Change cell formatting setting
	 * @param boolean active
	 * @returns boolean
	 */
	function columns_format(active) {
		if (active === true) {
			var defaultColumns = vgse_editor_settings.columnsFormat
		} else {
			var defaultColumns = vgse_editor_settings.columnsUnformat
		}

		var out = vgObjectToArray(defaultColumns);

		out.forEach(function (columnSettings, index) {
			if (typeof columnSettings.source === 'string' && columnSettings.source === 'loadTaxonomyTerms') {
				out[index].source = loadTaxonomyTerms;
			}
		});
		return out;
	}

	function loadTaxonomyTerms(query, process) {
		var nonce = jQuery('.remodal-bg').data('nonce');
		var post_type = jQuery('#post_type_new_row').val();
		var columnKey = hot.colToProp(hot.getSelected()[0][1]);
		var taxonomyKey = vgse_editor_settings.columnsFormat[columnKey].taxonomy_key || columnKey;

		if (typeof window.wpseTaxonomyTerms === 'undefined') {
			window.wpseTaxonomyTerms = {};
		}
		if (typeof window.wpseTaxonomyTerms[taxonomyKey] === 'undefined') {
			window.wpseTaxonomyTerms[taxonomyKey] = [];
			jQuery.ajax({
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "vgse_get_taxonomy_terms",
					taxonomy_key: taxonomyKey,
					nonce: nonce,
					post_type: post_type,
					wpse_source: 'taxonomy_column'
				},
				success: function (response) {
					console.log("response", response);
					window.wpseTaxonomyTerms[taxonomyKey] = response.data;
					//process(JSON.parse(response.data)); // JSON.parse takes string as a argument
					process(response.data);

				}
			});
		} else {
			process(window.wpseTaxonomyTerms[taxonomyKey]);
		}

	}

	jQuery('body').on('click', '.wpse-enable-locked-cell', function (e) {
		e.preventDefault();

		var columnKey = hot.colToProp(hot.getSelected()[0][1]);
		vgse_editor_settings.lockedColumnsManuallyEnabled.push(columnKey);
		var column = hot.propToCol(columnKey);
		// We reset the cell data to force handsontable to re-render the column
		var currentData = hot.getDataAtCell(1, column);
		hot.setDataAtCell(1, column, currentData);
	});

	/**
	 * Update cells formatting = change to plain text and viceversa
	 */
	jQuery('#formato').change(function () {
		if (jQuery(this).is(':checked')) {
			format = false;
		} else {
			format = true;
		}
		//console.log(format);

		var defaultColumns = columns_format(format);

		if (typeof vgseColumnsVisibilityUpdateHOT === 'function' && window.vgseColumnsVisibilityUsed) {
			vgseColumnsVisibilityUpdateHOT(defaultColumns, vgse_editor_settings.colHeaders, vgse_editor_settings.colWidth, 'softUpdate');

		} else {
			hot.updateSettings({
				columns: defaultColumns
			});
		}
	});

	/**
	 * Update posts count on spreadsheet
	 */
	setInterval(function () {
		var total = hot.countRows();
		jQuery('input[name="visibles"]').val(total);
	}, 1000);

	/**
	 * Add new rows to spreadsheet
	 */
	jQuery("#addrow").click(function () {
		var nonce = jQuery('.remodal-bg').data('nonce');
		var post_type = jQuery('#post_type_new_row').val();
		var rows = (jQuery(this).next('.number_rows').length && jQuery(this).next('.number_rows').val()) ? parseInt(jQuery(this).next('.number_rows').val()) : 1;
		var extra_data = typeof window.wpseAddRowExtraData !== 'undefined' ? window.wpseAddRowExtraData : null;
		loading_ajax({estado: true});

		// Create posts as drafts
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {action: "vgse_insert_individual_post", nonce: nonce, post_type: post_type, rows: rows, extra_data: extra_data},
			dataType: 'json',
			success: function (res) {

				console.log(res);
				if (res.success) {
					// Add rows to spreadsheet							
					vgseAddFoundRowsCount(window.beFoundRows + parseInt(rows));
					vgAddRowsToSheet(res.data.message, 'prepend');

					loading_ajax({estado: false});
					notification({mensaje: vgse_editor_settings.texts.new_rows_added});

					// Scroll up to the new rows
					jQuery(window).scrollTop(jQuery('.be-spreadsheet-wrapper').offset().top - jQuery('#vg-header-toolbar').height() - 20);
				} else {
					loading_ajax({estado: false});
					notification({mensaje: res.data.message, tipo: 'error', tiempo: 60000});
				}

				jQuery('body').trigger('vgSheetEditor:afterNewRowsInsert', [res, post_type, rows]);
			}
		});
	});

	jQuery('#addrow2').click(function () {
		jQuery('#addrow').trigger('click');
	});



	/**
	 * Fix toolbar on scroll
	 */
	function sticky_relocate(direction) {
		var scrollTop = jQuery(window).scrollTop();
		var isVerticalScroll = scrollDown('menu');
		var scrollLeft = jQuery(window).scrollLeft();

		if (isVerticalScroll && direction === 'top') {
			if (scrollTop > div_top) {
				$mainToolbar.css('top', '');
				$mainToolbar.addClass('sticky');
				jQuery('#wpadminbar').hide();
				$toolbarPlaceholder.height(toolbarHeight);

			} else {
				jQuery('#wpadminbar').show();
				$mainToolbar.removeClass('sticky');
				$toolbarPlaceholder.height(0);
			}
		}

		if (!isVerticalScroll && direction !== 'top') {
			if (scrollTop === 0) {
				jQuery('#wpadminbar').show();
				$mainToolbar.removeClass('sticky');
				$toolbarPlaceholder.height(0);
			}
			if ($mainToolbar.hasClass('sticky')) {
				$mainToolbar.css({
					'left': '',
					'width': '',
				});
				$mainToolbar.removeClass('sticky-left');
			} else if (scrollLeft > (toolbarLeft + 20)) {
				$toolbarPlaceholder.height(toolbarHeight);
				$mainToolbar.addClass('sticky-left');
				$mainToolbar.css({
					'left': scrollLeft - jQuery('#vgse-wrapper').offset().left,
					'width': jQuery(window).width(),
				});
			} else {
				$toolbarPlaceholder.height(0);
				$mainToolbar.css({
					'left': '',
					'width': '',
				});
				$mainToolbar.removeClass('sticky-left');
			}
		}
	}

	if (jQuery('#vg-header-toolbar').length && window.location.href.indexOf('wpse_no_sticky_toolbar') < 0) {
//		jQuery(window).scroll(sticky_relocate);
		var toolbarHeight = jQuery('#vg-header-toolbar').outerHeight();
		var toolbarLeft = jQuery('#vg-header-toolbar').offset().left;
		var div_top = jQuery('#vg-header-toolbar-placeholder').offset().top;
		var $mainToolbar = jQuery('#vg-header-toolbar');
		var $toolbarPlaceholder = jQuery('#vg-header-toolbar-placeholder');

		jQuery(window).scroll(_throttle(function () {
			sticky_relocate('top');
		}, 150));
		jQuery(window).scroll(_throttle(function () {
			sticky_relocate('left');
		}, 5));
		sticky_relocate('top');
		sticky_relocate('left');
	}

	jQuery('body').trigger('vgSheetEditor:afterInit');

});


/**
 * Verify we´re scrolling vertically, not horizontally
 */
var lastScrollTop = {};
function scrollDown(flag) {
	if (!lastScrollTop[ flag ]) {
		lastScrollTop[ flag ] = 0;
	}

	var st = jQuery(window).scrollTop();
	if (st > lastScrollTop[ flag ]) {
		down = true;
	} else {
		down = false;
	}
	lastScrollTop[ flag ] = st;
	return down;
}


/**
 * Display warning before closing the page to ask the user to save changes
 */
var formSubmitting = false;
var setFormSubmitting = function () {
	formSubmitting = true;
};

jQuery(window).on("beforeunload", function () {
	if (jQuery('.be-spreadsheet-wrapper').length) {
		var modifiedData = beGetModifiedItems(hot.getSourceData(), window.beOriginalData);
	} else {
		var modifiedData = [];
	}

	if (!jQuery('.be-spreadsheet-wrapper').length || !modifiedData.length || formSubmitting) {
		return undefined;
	}
	return vgse_editor_settings.texts.save_changes_on_leave;
});


jQuery(document).ready(function () {
	var $quickSetupContent = jQuery('.quick-setup-page-content');

	if (!$quickSetupContent.length) {
		return true;
	}

	function nextStep() {
		jQuery('.setup-step.active').removeClass('active').next().addClass('active');
		jQuery(' #vgse-wrapper .progressbar li.active').removeClass('active').next().addClass('active');
	}
	function prevStep() {
		jQuery('.setup-step.active').removeClass('active').prev().addClass('active');
		jQuery(' #vgse-wrapper .progressbar li.active').removeClass('active').prev().addClass('active');
	}

	$quickSetupContent.find('.step-back').click(function (e) {
		e.preventDefault();
		prevStep();
	});
	$quickSetupContent.find('.save-all-trigger').click(function (e) {
		e.preventDefault();
		var $allTrigger = jQuery(this);
		var $step = $allTrigger.parents('.setup-step');
		var $forms = $step.find('form');
		loading_ajax({estado: true});

		if (!$forms.length) {
			nextStep();
			loading_ajax({estado: false});
			return true;
		}

		$step.find('.save-trigger').each(function () {
			jQuery(this).trigger('click');
		});

		var savedCount = 0;
		var savedNeeded = $step.find('.save-trigger').length;

		var intervalId = setInterval(function () {
			var $saved = $step.find('.save-trigger').filter(function () {
				return jQuery(this).data("saved") === 'yes';
			});
			// finished saving all forms.
			if ($saved.length === savedNeeded) {
				clearInterval(intervalId);
				nextStep();
				loading_ajax({estado: false});
			}
		}, 800);
	});

	$quickSetupContent.find('.save-trigger').click(function (e) {
		e.preventDefault();
		var $button = jQuery(this);

		var $form = $button.parents('form');
		var callback = $form.data('callback');
		jQuery.post($form.attr('action'), $form.serializeArray(), function (response) {
			$button.data('saved', 'yes');

			if (callback) {
				vgseExecuteFunctionByName(callback, window, {
					response: response,
					form: $form
				});
			}
		});

	});
});


jQuery(document).ready(function () {

	// Submit formulas modal form 
	jQuery('body').on('click', '.form-submit-outside', function (e) {
		e.preventDefault();

		jQuery(this).parents('.remodal').find('form .form-submit-inside').trigger('click');
	});




	// Disable infinite scroll when opening modals
	jQuery(document).on('opened', '.remodal', function (e) {
		console.log('Modal is opened');
		// Save the existing scroll position, and disable infinite scroll to
		// avoid loosing the scroll position and loading more posts while it´s opened.
		var scrollTop = jQuery(document).scrollTop();
		var currentInfiniteScrollStatus = jQuery('#infinito').prop('checked');
		jQuery('#infinito').prop('checked', false);
		jQuery('body').data('temp-status', currentInfiniteScrollStatus).data('temp-scrolltop', scrollTop);


		var scrollLeft = jQuery('html,body').scrollLeft();
		jQuery('body').data('temp-scrollleft', scrollLeft);
	});
	jQuery(document).on('closed', '.remodal', function () {
		console.log('Modal is closed');
		var scrollTop = jQuery('body').data('temp-scrolltop');
		var scrollLeft = jQuery('body').data('temp-scrollleft');
		var scrollInfinito = jQuery('body').data('temp-status');

		if (scrollTop) {
			jQuery(window).scrollTop(scrollTop);
		}
		if (scrollLeft) {
			jQuery('html,body').scrollLeft(scrollLeft);
		}
		if (scrollInfinito) {
			jQuery('#infinito').prop('checked', scrollInfinito);
		}
	});
});


// handsontable cells

// Initialize spreadsheet
function initHandsontableForPopup(data, modalSettings) {

	if (!data) {
		data = [];
	}

	if (modalSettings.type === 'handsontable') {

		var columnWidths = modalSettings.handsontable_column_widths[modalSettings.post_type];
		var columnHeaders = modalSettings.handsontable_column_names[modalSettings.post_type];
		var columns = modalSettings.handsontable_columns[modalSettings.post_type];
		var container3 = document.getElementById('handsontable-in-modal');


		if (window.hotAttr) {
			window.hotAttr.destroy();
		}

		var responseData;
		if (data.custom_handsontable_args) {
			responseData = data.data;
		} else {
			responseData = data;
		}

		if (!responseData.length && window.wpseCurrentPopupSourceCoords.cellValue) {
			responseData = window.wpseCurrentPopupSourceCoords.cellValue;
		}

		var cellHandsontableArgs = {
			data: responseData,
			minSpareRows: 1,
			wordWrap: true,
			colWidths: columnWidths,
			allowInsertRow: true,
			columnSorting: true,
			colHeaders: columnHeaders,
			columns: columns
		};

		var finalCellHandsontableArgs = jQuery.extend(cellHandsontableArgs, data.custom_handsontable_args);
		window.hotAttr = new Handsontable(container3, finalCellHandsontableArgs);
	} else if (modalSettings.type === 'metabox') {
		var $iframe = jQuery('.vgca-iframe-wrapper iframe');
		$iframe.parents('.vgca-iframe-wrapper ').show();
		$iframe.attr('src', $iframe.data('src') + modalSettings.post_id + '&wpse_column=' + modalSettings.key);
		initEditorIframe(modalSettings);
	}
	loading_ajax({estado: false});
}

function initEditorIframe(modalSettings) {
	// Bail if iframes were already initiated
//	if (typeof window.vgcaIsFrontendSession !== 'undefined' && window.vgcaIsFrontendSession) {
//		return true;
//	}
	window.$iframeWrappers = jQuery('.vgca-iframe-wrapper ');
	window.vgcaIsFrontendSession = [];
	$iframeWrappers.each(function () {
		var $iframeWrapper = jQuery(this);
		var $iframe = $iframeWrapper.find('iframe');
		var hash = window.location.hash;

		$iframe.data('lastPage', $iframe.contents().get(0).location.href);
		window.vgcaIsFrontendSession.push(setInterval(function () {
			var currentPage = $iframe.contents().get(0).location.href;

			// If the user navigated to another admin page, update the iframe height
			if (currentPage !== $iframe.data('lastPage')) {
				$iframeWrappers.css('height', '');
				$iframe.css('height', '');
				$iframe.data('lastPage', currentPage);
			}

			// Prevent js errors when the admin page hasn't loaded yet
			var $iframeContents = null;
			try {
				var $iframeContents = $iframe.contents();
			} catch (e) {

			}
			if ($iframeContents) {
				var iframeHeight = $iframeContents.height();
				$iframe.height(iframeHeight);
				$iframeWrapper.height(iframeHeight);

				// Hide all elements except the metabox section that we'll use
				var $field = $iframeContents.find(modalSettings.metabox_show_selector);
				// Make sure the element is visible
				$field.removeClass('acf-hidden').removeClass('hidden').attr('hidden', '').attr('style', 'display: block !important; visibility: 1 !important; opacity: 1 !important;');
				$field.siblings().filter(function () {
					return !(jQuery(this).hasClass('mce-container') || jQuery(this).hasClass('ui-autocomplete') || (jQuery(this).attr('id') && jQuery(this).attr('id').indexOf('__wp-uploader-id') > -1));
				}).attr('style', 'display: none !important');
				$field.parents().each(function () {
					jQuery(this).siblings().filter(function () {
						return !(jQuery(this).hasClass('mce-container') || jQuery(this).hasClass('ui-autocomplete') || (jQuery(this).attr('id') && jQuery(this).attr('id').indexOf('__wp-uploader-id') > -1));
					}).attr('style', 'display: none !important');
				});
			}
		}, 1000));
	});
}

jQuery(document).ready(function () {

	// Open modal
	jQuery('body').on('click', '.button-custom-modal-editor', function (e) {
		e.preventDefault();
		var $button = jQuery(this);
		var buttonData = $button.data();

		var $cell = $button.parent('td');
		if ($cell.length) {
			var cellCoords = hot.getCoords($cell[0]);
			window.wpseCurrentPopupSourceCoords = cellCoords;
			if (buttonData.modalSettings.use_new_handsontable_renderer) {
				window.wpseCurrentPopupSourceCoords.cellValue = JSON.parse(hot.getDataAtCell(window.wpseCurrentPopupSourceCoords.row, window.wpseCurrentPopupSourceCoords.col));
			}
		}

		if (!window.hotModalCache) {
			window.hotModalCache = {};
		}
		if (!window.hotModalCache[buttonData.modalSettings.post_id]) {
			window.hotModalCache[buttonData.modalSettings.post_id] = {};
		}



		var existing;
		if (window.hotModalCache && window.hotModalCache[buttonData.modalSettings.post_id][buttonData.modalSettings.edit_modal_save_action]) {
			existing = window.hotModalCache[buttonData.modalSettings.post_id][buttonData.modalSettings.edit_modal_save_action];
		} else {
			existing = buttonData.existing;
		}

		var currentRowData = {
			'button': $button,
			'modalSettings': buttonData.modalSettings,
			'existing': existing,
		};

		window.vgseWCAttsCurrent = currentRowData;
		var modalInstance = jQuery('.custom-modal-editor').remodal().open();
		jQuery('.custom-modal-editor').addClass('modal-editor-' + buttonData.modalSettings.key);
	});

	// Cancel edit
	jQuery('body').on('click', '.custom-modal-editor .remodal-cancel', function (e) {
		var $button = jQuery(this);
		var $modal = $button.parents('.custom-modal-editor');
		var data = window.vgseWCAttsCurrent;

		if (data.modalSettings.edit_modal_cancel_action) {
			loading_ajax({estado: true});

			var functionNames = data.modalSettings.edit_modal_cancel_action.replace('js_function_name:', '').split(',');
			functionNames.forEach(function (functionName) {
				vgseExecuteFunctionByName(functionName, $modal.find('iframe')[0].contentWindow);
			});
			loading_ajax(false);
		}
	});

	// Save changes
	jQuery('body').on('click', '.custom-modal-editor .save-changes-handsontable', function (e) {
		var $button = jQuery(this);
		var $modal = $button.parents('.custom-modal-editor');
		var nonce = jQuery('.remodal-bg').data('nonce');
		var data = window.vgseWCAttsCurrent;

		loading_ajax({estado: true});

		if (data.modalSettings.type === 'handsontable') {
			var attrData = hotAttr.getSourceData();
		} else if (data.modalSettings.type === 'metabox') {

			if (data.modalSettings.metabox_value_selector.indexOf('js_function_name:') > -1) {
				var functionName = data.modalSettings.metabox_value_selector.replace('js_function_name:', '');
				var attrData = vgseExecuteFunctionByName(functionName, $modal.find('iframe')[0].contentWindow);
			} else {
				var $metaboxFields = $modal.find('iframe').contents().find(data.modalSettings.metabox_value_selector);
				var attrData = $metaboxFields.length === 1 ? $metaboxFields.val() : beParseParams($metaboxFields.serialize());
			}
		}

		if (!window.hotModalCache) {
			window.hotModalCache = {};
		}
		if (!window.hotModalCache[data.modalSettings.post_id]) {
			window.hotModalCache[data.modalSettings.post_id] = {};
		}

		// cache product data
		if (!data.modalSettings.edit_modal_get_action) {
			data.button.data('existing', attrData);

			window.hotModalCache[data.modalSettings.post_id][data.modalSettings.edit_modal_save_action] = attrData;
		}

		if (data.modalSettings.type === 'handsontable') {

			if (data.modalSettings.use_new_handsontable_renderer) {
				hot.setDataAtCell(window.wpseCurrentPopupSourceCoords.row, window.wpseCurrentPopupSourceCoords.col, JSON.stringify(attrData));
			}
		}

		var saveHandlers = data.modalSettings.edit_modal_save_action.split(',');
		saveHandlers.forEach(function (saveHandler) {
			if (saveHandler.indexOf('js_function_name:') > -1) {
				var functionName = saveHandler.replace('js_function_name:', '');
				vgseExecuteFunctionByName(functionName, $modal.find('iframe')[0].contentWindow);
			} else {
				jQuery.post(ajaxurl, {
					action: saveHandler,
					nonce: nonce,
					postId: data.modalSettings.post_id,
					postType: data.modalSettings.post_type,
					modalSettings: data.modalSettings,
					data: attrData
				}, function (response) {
					console.log(response);
				});
			}
		});
		jQuery('.custom-modal-editor').remodal().close();
		loading_ajax({estado: false});
	});

	jQuery(document).on('closed', '.custom-modal-editor', function () {
		var data = window.vgseWCAttsCurrent;
		var $modal = jQuery('.custom-modal-editor');


		if (data.modalSettings.type === 'metabox' && typeof window.vgcaIsFrontendSession !== 'undefined' && window.vgcaIsFrontendSession.length) {
			$modal.find('iframe').attr('src', '');
			$modal.find('.vgca-iframe-wrapper ').hide();
			window.vgcaIsFrontendSession.forEach(function (intervalId, index) {
				clearInterval(intervalId);
			});
		}


		jQuery('.custom-modal-editor').removeClass('modal-editor-' + data.modalSettings.key);
		loading_ajax({estado: false});

	});
// Load modal and spreadsheet
	jQuery(document).on('opened', '.custom-modal-editor', function () {
		console.log('Modal is opened');
		var data = window.vgseWCAttsCurrent;

		loading_ajax({estado: true});

		if (!data) {
			return true;
		}
		var $modal = jQuery('.custom-modal-editor');

		// Display post title in modal
		if (!$modal.find('.modal-post-title').length) {
			$modal.find('.modal-general-title').after('<span class="modal-post-title"></span>');
		}
		$modal.find('.modal-post-title').html(data.modalSettings.post_title);
		if (data.modalSettings.edit_modal_title) {
			$modal.find('.modal-general-title').html(data.modalSettings.edit_modal_title + ': ');
		}
		if (data.modalSettings.edit_modal_description) {
			$modal.find('.modal-description').html(data.modalSettings.edit_modal_description);
		}

		if (!window.hotModalCache) {
			window.hotModalCache = {};
		}
		if (!window.hotModalCache[data.modalSettings.post_id]) {
			window.hotModalCache[data.modalSettings.post_id] = {};
		}

		// Get data for the spreadsheet if necessary
		if (data.modalSettings.edit_modal_get_action) {
			var nonce = jQuery('.remodal-bg').data('nonce');
			jQuery.get(ajaxurl, {
				action: data.modalSettings.edit_modal_get_action,
				nonce: nonce,
				postId: data.modalSettings.post_id
			}).done(function (response) {
				initHandsontableForPopup(response.data, data.modalSettings);
			});
		} else {

			if (window.hotModalCache && window.hotModalCache[data.modalSettings.post_id][data.modalSettings.edit_modal_save_action]) {
				var objectData = window.hotModalCache[data.modalSettings.post_id][data.modalSettings.edit_modal_save_action];
			} else {
				var objectData = data.existing;
			}
			initHandsontableForPopup(objectData, data.modalSettings);
		}

	});

	jQuery('body').on('click', 'button.remodal-confirm, a.remodal-cancel, .media-button-insert', function (e) {
		if (jQuery(this).attr('type') !== 'submit' && !jQuery(this).hasClass('submit')) {
			e.preventDefault();
		}
	});

});

jQuery(document).ready(function () {
	jQuery('.vgse-current-filters').on('click', '.button', function (e) {
		e.preventDefault();
		var $button = jQuery(this);


		var fullData = hot.getSourceData();
		fullData = beGetModifiedItems(fullData, window.beOriginalData);
		if (fullData.length) {
			alert(vgse_editor_settings.texts.save_changes_before_remove_filter);
			return true;
		}

		var toRemove = $button.data('filter-key');

		// Clear field in the search form
		jQuery('#be-filters').find('input,select,textarea').filter(function () {
			return jQuery(this).attr('name') === toRemove;
		}).val('').trigger('change');

		beAddRowsFilter(toRemove + '=');
		$button.remove();

		vgseReloadSpreadsheet();

	});
});

/* Post type setup wizard */
jQuery(document).ready(function () {
	var $wrapper = jQuery('.post-type-setup-wizard');

	if (!$wrapper.length) {
		return false;
	}

	// Create post type
	$wrapper.find('form.inline-add').submit(function (e) {

		var $form = jQuery(this);
		var callback = $form.data('callback');
		jQuery.ajax({
			method: $form.attr('method'),
			url: $form.attr('action'),
			data: $form.serialize() + '&current_post_type=' + jQuery('.post-types-form input:radio:checked').val()
		})
				.done(function (response) {
					$form.find('input:text').val('');
					$form.find('input:text').first().focus();
					vgseExecuteFunctionByName(callback, window, {
						response: response,
						form: $form,
					});
				});


		return false;
	});

	// Add delete button to custom post types
	var customPostTypes = $wrapper.find('.post-types-form').data('custom-post-types').split(',');
	jQuery.each(customPostTypes, function (index, postType) {
		var $fieldWrapper = $wrapper.find('.post-types-form .post-type-' + postType);
		$fieldWrapper.append('<button class="button vgse-delete-post-type" data-post-type="' + postType + '"><i class="fa fa-remove"></i></button>');
	});

	// Delete post type
	$wrapper.on('click', '.vgse-delete-post-type', function (e) {
		e.preventDefault();
		var $button = jQuery(this);
		var postType = $button.data('post-type');

		var allowed = confirm($wrapper.find('.post-types-form').data('confirm-delete'));

		if (!allowed) {
			return true;
		}
		jQuery.post(ajaxurl, {
			post_type: postType,
			action: 'vgse_delete_post_type',
			nonce: jQuery('.post-type-setup-wizard').data('nonce'),
		}, function (response) {
			if (response.success) {
				notification({mensaje: response.data.message, tipo: 'success', tiempo: 3000});
				$wrapper.find('.post-types-form .post-type-' + postType).remove();
			}
		});
	});
});
function vgsePostTypeSaved(data) {
	if (data.response.success) {
		jQuery('.post-types-form .post-type-field').first().before('<div class="post-type-field"><input type="radio" name="post_types[]" value="' + data.response.data.slug + '" id="' + data.response.data.slug + '"> <label for="' + data.response.data.slug + '">' + data.response.data.label + '</label></div>');
		jQuery('.post-types-form input:radio').first().prop('checked', true);
		jQuery('.post-types-form .save-trigger').trigger('click');
	}
}
function vgsePostTypeSetupPostTypesSaved(data) {
	var $step = data.form.parents('li');

	$step.hide();

	var $next = $step.next();
	$next.show();

	if ($next.hasClass('setup_columns')) {
		jQuery.get(ajaxurl, {
			action: 'vgse_post_type_setup_columns_visibility',
			nonce: jQuery('.post-type-setup-wizard').data('nonce'),
			post_type: jQuery('.post-types-form input:radio:checked').val(),
		}, function (response) {
			$next.append(response.data.html);

			$next.find('[name="save_post_type_settings"]').prop('checked', true);

			if (typeof vgseColumnsVisibilityInit !== 'undefined') {
				vgseColumnsVisibilityInit();
			}
		});
	}
}

function vgsePostTypeSetupColumnSaved(data) {
	jQuery('#vgse-columns-enabled').append('<li><span class="handle">::</span> ' + data.response.data.label + ' <input type="hidden" name="columns[]" class="js-column-key" value="' + data.response.data.key + '"><input type="hidden" name="columns_names[]" class="js-column-title" value="' + data.response.data.label + '"></li>');
}
function vgsePostTypeSetupColumnsVisibilitySaved(data) {
	window.location.href = data.response.data.post_type_editor_url;
}
jQuery(document).ready(function () {

	var $postTypesAvailable = jQuery('.quick-setup-page-content .post-type-field input');

	if (!$postTypesAvailable.length) {
		return false;
	}

	var $postTypesEnabled = jQuery('.quick-setup-page-content .post-types-enabled');
	$postTypesAvailable.change(function (e) {
		console.log('test: ', jQuery(this));
		$postTypesEnabled.empty();

		$postTypesAvailable.each(function () {
			var postTypeKey = jQuery(this).val();

			if (jQuery(this).is(':checked')) {

				var label = jQuery(this).siblings('label').text();
				var html = '<a class="button post-type-' + postTypeKey + '" href="admin.php?page=vgse-bulk-edit-' + postTypeKey + '">Edit ' + label + '</a> - ';
				console.log('html: ', html);
				$postTypesEnabled.append(html);
			}
		});

	});
});
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

