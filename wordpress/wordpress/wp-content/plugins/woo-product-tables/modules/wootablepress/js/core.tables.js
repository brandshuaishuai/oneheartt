(function (vendor, $, window) {

	var wooTableInstances = [];

	var appName = 'WooTablepress';
	if (!(appName in vendor)) {
		vendor = vendor[appName] = {};
	}

	vendor.initializeTable = (function initializeTable(tableWrapper, finalCallback, settingsIn) {
		var table = tableWrapper.find('.wtbpContentTable'),
			__this = this,
			viewId = tableWrapper.data('table-id'),
			settings = this.getSetting(settingsIn, table),
			printCaps = settings.print_captions;
		this.removeTableInstanceById(viewId);

			var objAttr = {
			dom: 'B<"wtbpFilters">lftrip',
			columnDefs: [ {
				"targets": 'no-sort',
				"orderable": false
			} ],
			order: [],
			buttons: [{
				extend: 'print',
				className: 'button',
				exportOptions: {
					stripHtml: false,
					columns: []
				},
                title: printCaps === '1' && settings.caption_enable === '1' ? settings.caption_text : '*',
                repeatingHead: {
                    title: printCaps === '1' && settings.caption_enable === '1' ? settings.caption_text : null,
                    description: printCaps === '1' && settings.description_enable === '1' ? settings.description_text : null,
                },
                repeatingFoot: {
                    signature: printCaps === '1' && settings.signature_enable === '1' ? settings.signature_text : null
                },
				customize: function (win) {
					var printTable = $(win.document.body).find('table').css('font-size', '80%');
					printTable.removeClass('wtbpScrollTop');
					printTable.find('a').removeAttr('href');
					printTable.find('.woocommerce-Price-amount').css('white-space', 'nowrap').closest('td').css('white-space', 'nowrap');
					printTable.find('.wtbpNoBreak').css('white-space', 'nowrap');
					printTable.find('td, th').css('word-break', 'normal');
					$(win.document.body).find('h1').remove();

                    $(win.document.body).find('.table-title').css({textAlign:'center',fontSize:'20px',fontWeight:'bold',padding:'10px',border:'none'});
                    $(win.document.body).find('.table-description').css({textAlign:'center',fontSize:'14px',paddingBottom:'10px',border:'none'});
                    $(win.document.body).find('.table-signature').css({textAlign:'center',fontSize:'14px',paddingBottom:'10px',paddingTop:'5px',border:'none'});
				}
			},],
			fnDrawCallback :function(){
				if ( jQuery(this).closest('.wtbpTableWrapper').find('.dataTables_paginate span .paginate_button').size() <= 1) {
					jQuery(this).closest('.wtbpTableWrapper').find('.dataTables_paginate').hide();
				}else{
					jQuery(this).closest('.wtbpTableWrapper').find('.dataTables_paginate').show();
				}
				__this.controlScrollPosition(tableWrapper, table);
			}
		};
		if(typeof(this.setSettingsPro) == 'function') {
			objAttr = this.setSettingsPro(settings, objAttr, tableWrapper);
		}
		objAttr = this.setColumnsSettings(objAttr, settings);
		objAttr = this.addPagination(objAttr, settings);
		objAttr = this.addLanguage(objAttr, settings);
		objAttr = this.enableFixedHeader(objAttr, settings);
		objAttr = this.initResponsiveMode(objAttr, settings);
		objAttr = this.initFinalCallBack(objAttr, finalCallback);
		this.addColumnSearching(table, settings);

		var tableObj = table.DataTable(objAttr);
		tableObj.table_id = viewId;
		tableObj.isSSP = this.checkSettings(settings, 'pagination_ssp', false) == '1';

		// window.tableWrapper = tableWrapper;
		// window.tableObj = tableObj;

		var indexColMultipleAdd = tableWrapper.find('[data-key=check_multy]').index();
		if (indexColMultipleAdd != -1 && tableObj.column(indexColMultipleAdd).visible()) {
				var dataKey = tableWrapper.find('th').eq(indexColMultipleAdd).attr('data-key');
				if (dataKey === 'check_multy') {
					priceHide = true;
					tableObj.column(indexColMultipleAdd).visible(false);
					tableObj.hide_table_column = tableObj.column( tableWrapper.find('[data-key=check_multy]').attr('data-column') );
					tableObj.hide_check_multy = true;
				}
		}

		$('.wtbpTableWrapper').on( 'change', 'wtbpVarAttribute', function() {
			tableWrapper.trigger( "change" );
		});
		tableWrapper.on( 'change', '.wtbpVarAttribute', function() {
			var select = $(this),
				wrapper = select.closest('.wtbpVarAttributes'),
				variations = JSON.parse(wrapper.attr('data-variations')),
				td = select.closest('td'),
				curAttr = select.attr('data-attribute'),
				curValue = select.val(),
				otherAttrs = wrapper.find('select:not([data-attribute="'+curAttr+'"])'),
				tr = td.closest('tr'),
				multy = tr.find('.wtbpAddMulty'),
				thumbnail = tr.find('td.thumbnail'),
				addButton = td.find('.add_to_cart_button'),
				attributes = [];

			otherAttrs.each(function () {
				var current = $(this);
				attributes.push({name: current.attr('data-attribute'), value: current.val()});
				current.find('option:not([value=""])').css('display', 'none');
			});

			td.find('.wtbpVarPrice').addClass('wtbpHidden');
            if (typeof td.parent().find('.stock-count') !== 'undefined') {
                var parentQuantity = td.parent().find('.stock-count').data('quantity');
                if (parentQuantity) {
                    td.parent().find('.stock-count').text(parentQuantity);
                } else {
                    td.parent().find('.stock-count').parent().addClass('wtbpHidden');
                }
            }
			if(thumbnail.length) {
				thumbnail.find('a:not(.wtbpMainImage)').remove();
				thumbnail.find('a.wtbpMainImage').removeClass('wtbpHidden');
			}

			addButton.attr('data-variation_id', 0).closest('.wtbpAddToCartWrapper').addClass('wtbpDisabledLink');
			multy.prop('disabled', true).attr('data-variation_id', 0);
			var attrLen = attributes.length,
				found = false;
			for(id in variations) {
				var attrs = variations[id],
					match = (!(curAttr in attrs) || attrs[curAttr] == '' || attrs[curAttr] == curValue);
				if(match || curValue == '') {
					for(var i = 0; i < attrLen; i++) {
						var name = attributes[i]['name'],
							value = attributes[i]['value'];
						if(name in attrs) {
							wrapper.find('select[data-attribute="'+name+'"] option'+(attrs[name] == '' ? '' : '[value="'+attrs[name]+'"]')).css('display', 'block');
							if(attrs[name] != '' && attrs[name] != value) {
								match = false;
							}
						}
					}
					if(!found && match) {
						td.find('.wtbpVarPrice[data-variation_id="'+id+'"]').removeClass('wtbpHidden');

						addButton.attr({'data-product_id': id, 'data-variation_id': id}).closest('.wtbpAddToCartWrapper').removeClass('wtbpDisabledLink');
						addButton.data('product_id', id);
						addButton.data('variation_id', id);
						multy.prop('disabled', false).attr({'data-product_id': id, 'data-variation_id': id});

						if(thumbnail.length) {
							var varImg = td.find('.wtbpVarImage[data-variation_id="'+id+'"]');
							if(varImg.length) {
								thumbnail.find('a.wtbpMainImage').addClass('wtbpHidden');
								thumbnail.append(varImg.clone().removeClass('wtbpHidden'))
							}
						}

						// if enabled stock_item_counts and variation has quantity
                        var varQuantity = td.find('.wtbpVarPrice[data-variation_id="'+id+'"]').attr('data-quantity'),
                            parentQuantityBox = td.parent().find('.stock-count');
						if (varQuantity && typeof parentQuantityBox !== 'undefined') {
                            parentQuantityBox.text(varQuantity).parent().removeClass('wtbpHidden');
                        }

						found = true;
					}
				}
			}
			if(multy.length > 0 && multy.prop('disabled')) {
				multy.prop('checked', false);
			}
			otherAttrs.each(function () {
				var current = $(this);
				if(current.find('option:selected').css('display') == 'none') {
					current.val('');
				}
			});
		});

		var methodName = [
			'enableHeader', 'enableFooter', 'addDescription',
			'addCaption', 'addSignature', 'enableTableInfo',
			'viewCartHide', 'setColumnWidth',
			'enablePrintBtn', 'addCustomCss'];

		methodName.forEach(function(item) {
			__this[item](tableWrapper, settings);
		});

		var methodName2 = [
			'enableSearching', 'enableHighlighForColumn', 'enableRowStriping', 'setTableWidth',
			'enablehighlightRowByHover', 'enableBorders', 'setScrollPosition'];

		methodName2.forEach(function(item) {
			__this[item](tableWrapper, settings, table);
		});

		if(typeof(this.setMethodsPro) == 'function') {
			this.setMethodsPro(tableWrapper, tableObj, settings);
		}

		var isFixedHeader = this.checkSettings(settings, 'header_fixed', false),
			scrollBody = table.closest('.dataTables_scrollBody'),
			fakeContainer = tableWrapper.find('.wtbpFakeScrollBody');
		if(scrollBody.length == 0) {
			scrollBody = table;
		}

		if(isFixedHeader) {
			var adminBar = $('#wpadminbar'),
				tableIdInfo = viewId+'_info',
				tableWidth, tableLeft, floatingTop;

			setVariablesForFixedHeader();

			$(document).on('scroll',function(){
				var floatingHeader = $('table.fixedHeader-floating');
				if(floatingHeader.length) {
					floatingHeader.removeClass('wtbpScrollTop');
					if(floatingHeader.attr('aria-describedby') == tableIdInfo) {
						floatingHeader.css({'width': tableWidth, 'max-width': tableWidth, 'left': tableLeft, 'display': 'block'}).scrollLeft(scrollBody.scrollLeft());

						floatingHeader.css('top', floatingTop);

						if(!floatingHeader.hasClass('wtbpMultyCheckAdded')) {
							var wrapper = $('.wtbpTableWrapper[data-table-id="'+floatingHeader.attr('aria-describedby').replace('_info', '')+'"]');
							floatingHeader.on('change', '.wtbpAddMultyAll', function(e){
								e.preventDefault();
								__this.checkMultyAll($(this), wrapper);
							});
							floatingHeader.addClass('wtbpMultyCheckAdded');
						}
					}
				}
			});
		}
		if(isFixedHeader || fakeContainer.length) {
			scrollBody.on('scroll',function(){
				var left = $(this).scrollLeft();
				$('table.fixedHeader-floating').scrollLeft(left);
				fakeContainer.scrollLeft(left);
			});
		}

		$(window).on('resize', tableObj, function(event) {
			event.preventDefault();
			setVariablesForFixedHeader();
			setTimeout(function() {
				try{
					var activeEl = $(document.activeElement);
					//tableObj.columns.adjust().draw();
					setVariablesForFixedHeader();
					if(fakeContainer.length) {
						fakeContainer.find('div').width(table.width());
						fakeContainer.css('display', scrollBody.get(0).scrollWidth > scrollBody.innerWidth() ? 'block' : 'none');
					}
					if(activeEl && activeEl.is('input')) {
						activeEl.focus();
					}
				}catch (err){
					// console.log(err);
				}
			}, 350);

		}).trigger('resize');

		function setVariablesForFixedHeader() {
			if(!isFixedHeader) return;
			tableWidth = scrollBody.width()+'px';
			tableLeft = scrollBody.offset().left+'px';
			floatingTop = (adminBar.length && adminBar.css('position') == 'fixed' ? adminBar.height() : '0')+'px';
		}


		/*table.scroll(function() {
			if ( $(".fixedHeader-floating").is(":visible") ) {
				$(".fixedHeader-floating").scrollLeft( $(this).scrollLeft() );
			}
		});*/

		this.setTableInstance(tableObj);

		return tableObj;
	});

	vendor.getSetting = (function(settingsIn, table) {
		if(!settingsIn){
			var settings = table.attr('data-settings');
			settings = JSON.parse(settings);
		}else{
			settings = settingsIn.settings;
		}
		return settings;
	});

	vendor.setTableInstance = (function(instance) {
		wooTableInstances.push(instance);
	});

	vendor.getAllTableInstances = (function() {
		return wooTableInstances;
	});

	vendor.getTableInstanceById = (function(id) {
		var allTables = this.getAllTableInstances();

		for(var i = 0; i < allTables.length; i++) {
			if(allTables[i].table_id == id) {
				return allTables[i];
			}
		}
		return false;
	});
	vendor.removeTableInstanceById = (function(id) {
		var allTables = this.getAllTableInstances();

		for(var i = 0; i < allTables.length; i++) {
			if(allTables[i].table_id == id) {
				wooTableInstances.splice(i, 1);
			}
		}
		return;
	});


	vendor.checkSettings = (function(settings, settingName, settingDefault) {
		return ( settings[settingName] ) ? settings[settingName] : settingDefault;
	});

	vendor.setColumnsSettings = (function(objAttr, settings) {
		var mobileWidth = settings.mobile_width ? settings.mobile_width : 768,
			needHide = $(window).width() <= mobileWidth,
			disableSort = ['thumbnail', 'add_to_cart'],
			isMulty = typeof this.multyAddButtonEnable != 'undefined' ? this.multyAddButtonEnable : false,
			firstColumn = isMulty ? 1 : 0,
			printEnabled = this.checkSettings(settings, 'print', false),
			sorting = this.checkSettings(settings, 'sorting', false);
			sortingDefault = this.checkSettings(settings, 'sorting_default', ''),
			sortingDesc = this.checkSettings(settings, 'sorting_desc', false),
			disablePrint = ['add_to_cart'],
			showPrint = [];
		if(this.checkSettings(settings, 'pagination_ssp', false) == '1') {
			disableSort.push('description');
			disableSort.push('short_description');
			disableSort.push('attribute');
		}
		try {
			var columns = JSON.parse(settings.order);
		} catch(e)  {
			var columns = [];
		}
		if(isMulty) {
			objAttr['columnDefs'].push({ "sortable": false, "className": "dt-center", "targets": 0 });
		}
		objAttr['ordering'] = sorting ? true : false;

		for(var i = 0; i < columns.length; i++) {
			var slug = columns[i].slug;
			objAttr['columnDefs'].push({ "name": slug, "targets": i + firstColumn});
			//hide column on mobile
			if(needHide && columns[i].hide_on_mobile && columns[i].hide_on_mobile == '1') {
				objAttr['columnDefs'].push({ "visible": false, "targets": i + firstColumn});
			} else if(disablePrint.indexOf(slug) == -1) {
				showPrint.push(i + firstColumn);
			}
			if(sorting) {
				//disable sorting for some columns
				if(disableSort.indexOf(slug) != -1) {
					objAttr['columnDefs'].push({"sortable": false, "targets": i + firstColumn});
				} else if(slug == 'price') {
					objAttr['columnDefs'].push({"sortable": true, "type": 'num', "targets": i + firstColumn});
				}
				if(sortingDefault == slug) {
					objAttr['order'] = [[ i + firstColumn, sortingDesc ? 'desc' : 'asc' ]];
				}
			}
		}
		if(printEnabled) {
			objAttr['buttons'][0]['exportOptions']['columns'] = showPrint;
		}
		return objAttr;
	});

	vendor.addPagination = (function(objAttr, settings) {
		var paginationEnable = this.checkSettings(settings, 'pagination', false);
		if(!paginationEnable){
			objAttr['paging'] = false;
		} else {
			if(this.checkSettings(settings, 'pagination_menu', false)) {
				var list = this.checkSettings(settings, 'pagination_menu_content', '10,50,All').split(','),
					arr = [[],[]];
				list.forEach(function(len) {
					var lenNum = (len == 'All' ? -1 : Number(len));
					if(!isNaN(lenNum) && (lenNum > 0 || lenNum == -1)) {
						arr[1].push(len);
						arr[0].push(lenNum);
					}
				});
				if(arr.length) {
					objAttr['lengthChange'] = true;
					objAttr['lengthMenu'] = arr;
				}
			} else {
				objAttr['lengthChange'] = false;
				objAttr['pageLength'] = Number(this.checkSettings(settings, 'page_length', 10));
				if(isNaN(objAttr['pageLength'])) {
					objAttr['pageLength'] = 10;
				}
			}
		}
		return objAttr;
	});

	vendor.addLanguage = (function(objAttr, settings) {
		var emptyTable = this.checkSettings(settings, 'empty_table', 'There\'re no products in the table')
		,   tableInfoText = this.checkSettings(settings, 'table_info', 'Showing _START_ to _END_ of _TOTAL_ entries')
		,   emptyInfoText = this.checkSettings(settings, 'table_info_empty', 'Showing 0 to 0 of 0 entries')
		,   filteredInfoText = this.checkSettings(settings, 'filtered_info_text', '(filtered from _MAX_ total entries)')
		,   lengthText = this.checkSettings(settings, 'length_text', 'Show: _MENU_')
		,   searchLabel = this.checkSettings(settings, 'search_label', 'Search:')
		,   zeroRecords = this.checkSettings(settings, 'zero_records', 'No matching records are found');

		var languageObj = {};

		if(emptyTable){
			languageObj['emptyTable'] = emptyTable;
		}
		if(tableInfoText){
			languageObj['info'] = tableInfoText;
		}
		if(emptyInfoText){
			languageObj['infoEmpty'] = emptyInfoText;
		}
		if(filteredInfoText){
			languageObj['infoFiltered'] = filteredInfoText;
		}
		if(lengthText){
			languageObj['lengthMenu'] = lengthText;
		}
		if(searchLabel){
			languageObj['search'] = searchLabel;
		}
		if(zeroRecords){
			languageObj['zeroRecords'] = zeroRecords;
		}

		objAttr['language'] = languageObj;

		return objAttr;
	});

	vendor.enableFixedHeader = (function(objAttr, settings) {
		var headerEnable = this.checkSettings(settings, 'header_show', false)
		,   headerFixed = this.checkSettings(settings, 'header_fixed', false);

		if(headerEnable && headerFixed){
			objAttr['fixedHeader'] = true;
		}

		return objAttr;
	});

	vendor.initResponsiveMode = (function(objAttr, settings) {
		var mode = this.checkSettings(settings, 'responsive_mode', 'horizontal'),
            mobileWidth = settings.mobile_width ? settings.mobile_width : 768,
            needHide = $(window).width() <= mobileWidth;
		switch(mode) {
			case 'responsive':
				objAttr['scrollX'] = false;
				objAttr['responsive'] = needHide ? {details: {display: $.fn.dataTable.Responsive.display.childRowImmediate, type: ''}} : false;
				break;
			case 'hiding':
				objAttr['scrollX'] = false;
				objAttr['responsive'] = needHide;
				break;
			case 'horizontal':
				objAttr['scrollX'] = true;
				objAttr['responsive'] = false;
				break;
			case 'disable':
				objAttr['scrollX'] = false;
				objAttr['responsive'] = false;
				break;
		}
		return objAttr;
	});

	vendor.addColumnSearching = (function(table, settings) {
		var columnSearchEnable = this.checkSettings(settings, 'column_searching', false);

		if(columnSearchEnable) {
			var tPosition = 'tfoot',
				disableSearch = ['check_multy', 'thumbnail', 'add_to_cart'];
			if(this.checkSettings(settings, 'pagination_ssp', false) == '1') {
				disableSearch.push('attribute');
				disableSearch.push('featured');
			}
			if(!table.find('.wtbpColumnsSearchWrapper').length) {
				var headerRow = table.find('thead tr:first').find('th');
				if(headerRow.length) {
					var searchRow = '<tr class="wtbpColumnsSearchWrapper">';
					for (var i = 0; i < headerRow.length; i++) {
						var key = headerRow.eq(i).attr('data-key');
						searchRow += '<th data-key="'+key+'">'+(disableSearch.indexOf(key) == -1 ? '<input class="search-column" type="text" />' : '')+'</th>';
					}
					searchRow += '</tr>';
					if(table.find(tPosition).length == 0) {
						table.append($('<' + tPosition + '>'));
					}
					table.find(tPosition).append(searchRow);
				}
			}
			table.on('responsive-resize.dt', function(event, api, columns) {
				$(this).find('tfoot tr.wtbpColumnsSearchWrapper th').each(function(i, th) {
					$(th).css('display', (columns[i] ? 'table-cell' : 'none'));
				});
			});
		}
	});

	vendor.initFinalCallBack = (function(objAttr, finalCallback) {
		objAttr['initComplete'] = function(settings, json) {
			if(typeof finalCallback  == "function") {
				finalCallback();
			}
		};
		return objAttr;
	});

	vendor.enableHeader = (function(tableWrapper, settings) {
		var headerEnable = ( settings.header_show === '1' ) ? settings.header_show : false;
		if(!headerEnable){
			tableWrapper.find("thead").remove();
		}
	});

	vendor.enableFooter = (function(tableWrapper, settings) {
		var footerEnable = this.checkSettings(settings, 'footer_show', false);
		if(!footerEnable){
			tableWrapper.find('tfoot tr:not(.wtbpColumnsSearchWrapper)').css('display', 'none');
		}
	});

	vendor.addDescription = (function(tableWrapper, settings) {
		var description = ( settings.description_enable === '1' && undefined !== settings.description_text && settings.description_text.length > 0 ) ? settings.description_text : false;
		if(description){
			var descriptionHtml = '<div class="wtbpDescription">'+description+'</div>';
			tableWrapper.prepend(descriptionHtml);
		}
	});

	vendor.addCaption = (function(tableWrapper, settings) {
		var caption = ( settings.caption_enable === '1' && undefined !== settings.caption_text && settings.caption_text.length > 0 ) ? settings.caption_text : false
		if(caption){
			var captionHtml = '<div class="wtbpTitle">'+caption+'</div>';
			tableWrapper.prepend(captionHtml);
		}
	});

	vendor.addSignature = (function(tableWrapper, settings) {
		var signature = ( settings.signature_enable === '1' && undefined !== settings.signature_text && settings.signature_text.length > 0 ) ? settings.signature_text : false
		if(signature){
			var signatureHtml = '<div class="wtbpSignature">'+signature+'</div>';
			tableWrapper.append(signatureHtml);
		}
	});

	vendor.enableTableInfo = (function(tableWrapper, settings) {
		var tableInformationEnable = this.checkSettings(settings, 'table_information', false);
		if(!tableInformationEnable){
			tableWrapper.find('.dataTables_info').remove();
		}
	});

	/*vendor.enableSorting = (function(tableWrapper, settings) {
		var sortingEnable = this.checkSettings(settings, 'sorting', false);
		if(!sortingEnable){
			tableWrapper.find('th.sorting').off('click').css('background', 'none');
		}
	});*/

	vendor.viewCartHide = (function(tableWrapper, settings) {
		var viewCartHide = ( settings.view_cart_hide === '1' ) ? settings.view_cart_hide : false;
		if(viewCartHide){
			tableWrapper.find(".wtbpAddToCartButWrapp .added_to_cart").remove();
			var hideViewCart = '<style>.added_to_cart.wc-forward {display:none !important}</style>';
			$('body').append(hideViewCart);
		}
	});

	/*vendor.setSummaryColWidth = (function(tableWrapper, settings) {
		var summaryColWidth = ( settings.width ) ? settings.width['summary'] : '';
		if(summaryColWidth){
			tableWrapper.find('th[data-key="description"]').css({'min-width':summaryColWidth + 'px'});
			tableWrapper.find('td.description').css({'min-width':summaryColWidth + 'px'});
		}
	});*/
	vendor.setColumnWidth = (function(tableWrapper, settings) {
		try {
			var columns = JSON.parse(settings.order);
		} catch(e)  {
			var columns = [];
		}
		var tableWidth = tableWrapper.width();
		for(var i = 0; i < columns.length; i++) {
			if(columns[i].width && columns[i].width_unit && columns[i].width != '') {
				var slug = columns[i].slug;
				tableWrapper.find('th[data-key="'+slug+'"], td.'+slug).css('min-width', (columns[i].width_unit == '%' ? (columns[i].width * tableWidth / 100) : columns[i].width) + 'px');
			}
		}
	});

	vendor.enableSearching = (function(tableWrapper, settings, table) {
		var searchingEnable = this.checkSettings(settings, 'searching', false);
		if(!searchingEnable){
			tableWrapper.find('.dataTables_filter').remove();
		}

		var inputs = table.parents('.dataTables_wrapper:first').find('.wtbpColumnsSearchWrapper .search-column');
		if(inputs.length) {
			var self = this;
			inputs.off('keyup.dtg change.dtg').on('keyup.dtg change.dtg',function () {
				var input = $(this),
					position = input.parents('th:first').index(),
					value = this.value,
					tableObj = self.getTableInstanceById(table.attr('id')),
					column = tableObj.column(position);
				if (column.search() !== value) {
					column.search(value.replace(/;/g, "|"), true, false).draw();
					//column.search(value), true, false).draw();
					if(!tableObj.isSSP) {
						setTimeout(function() {
							column.draw();
						}, 50);
					}
				}
			});
		}
	});

	vendor.addCustomCss = (function(tableWrapper, settings) {
		var styleText = tableWrapper.find('.wtbpCustomCssWrapper');
		if(styleText.length) {
			var wrapperId = tableWrapper.attr('id'),
				styleId = wrapperId+'-css';
			$('#'+styleId).remove();

			var styleTag = $('<style/>', {id: styleId});
			styleTag.html(styleText.text());
			$('head').append(styleTag);
			var sheet = document.getElementById(styleId).sheet,
				rules = sheet.cssRules || sheet.rules,
				selectorId = '#'+wrapperId,
				selectors, newSelectors;
			for(var r = 0; r < rules.length; r++) {
				var rule = rules[r],
					value = rule.cssText ? rule.cssText : rule.style.cssText;
				if(typeof(value) == 'undefined' || value.length == 0 || value.indexOf('#') >= 0 || value.indexOf('@import') >= 0 || value.indexOf('fixedHeader-floating') >= 0) continue;

				selectors = rule.selectorText.split(',');
				newSelectors = '';
				for(var c = 0; c < selectors.length; c++) {
					newSelectors += (newSelectors.length ? ',' : '')+selectorId+' '+selectors[c];
				}
				rule.selectorText = newSelectors;
			}
		}
	});

	vendor.enablePrintBtn = (function(tableWrapper, settings) {
		var printButtonEnable = this.checkSettings(settings, 'print', false);
		if(!printButtonEnable){
			tableWrapper.find('.buttons-print').remove();
		}
	});

	vendor.setTableWidth = (function(tableWrapper, settings, table) {
		var fixedTableWidth = ( settings.width ) ? settings.width['fixed_width'] : '100'
		,   fixedTableMeasure = ( settings.width) ? settings.width['width_unit'] : 'percents';
		if(fixedTableMeasure === 'percents'){
			tableWrapper.css('width', fixedTableWidth + '%');
		}else if(fixedTableMeasure === 'pixels'){
			tableWrapper.css('width', fixedTableWidth + 'px');
		}
		table.css('width','100%');
	});

	vendor.enableHighlighForColumn = (function(tableWrapper, settings, table) {
		var highlightOrderColumn = this.checkSettings(settings, 'highlighting_order_column', false);
		if(highlightOrderColumn){
			table.addClass('order-column');
		}
	});

	vendor.enableRowStriping = (function(tableWrapper, settings, table) {
		var rowStriping = this.checkSettings(settings, 'row_striping', false);
		if(rowStriping){
			table.addClass('stripe');
		}
	});

	vendor.enablehighlightRowByHover = (function(tableWrapper, settings, table) {
		var highlightRowByHover = this.checkSettings(settings, 'highlighting_mousehover', false);
		if(highlightRowByHover){
			table.addClass('hover');
		}
	});

	vendor.enableBorders = (function(tableWrapper, settings, table) {
		var borders = this.checkSettings(settings, 'borders', false);
		if(borders){
			if(borders === 'cell'){
				table.addClass('cell-border dataTable');
			}else if(borders === 'rows'){
				table.addClass('row-border dataTable');
			}else if(borders === 'none'){
				table.addClass('no-border dataTable');
			}
		}
	});

	vendor.setScrollPosition = (function(tableWrapper, settings, table) {
		tableWrapper.find('table').removeClass('wtbpScrollTop');
		if(this.checkSettings(settings, 'responsive_mode', 'horizontal') != 'horizontal') return;

		var position = this.checkSettings(settings, 'horizontal_scroll', 'footer'),
			scrollBody = table.closest('.dataTables_scrollBody');
		if(scrollBody.length == 0) return;
		if(position == 'header') {
			scrollBody.addClass('wtbpScrollTop');
			table.addClass('wtbpScrollTop');
		} else if(position == 'two' && tableWrapper.find('.wtbpFakeScrollBody').length == 0) {
			scrollBody.before('<div class="wtbpFakeScrollBody"><div>&nbsp;</div></div>');
			var fakeContainer = tableWrapper.find('.wtbpFakeScrollBody');
			this.controlScrollPosition(tableWrapper, table);
			fakeContainer.scroll(function() {
				scrollBody.scrollLeft(fakeContainer.scrollLeft());
			});
		}
	});
	vendor.controlScrollPosition = (function(tableWrapper, table) {
		var fakeContainer = tableWrapper.find('.wtbpFakeScrollBody');
		if(fakeContainer.length) {
			setTimeout(function() {
				fakeContainer.find('div').width(table.width());
				var scrollBody = table.closest('.dataTables_scrollBody');
				if(scrollBody.length) {
					if(scrollBody.get(0).scrollWidth <= scrollBody.innerWidth()) {
						fakeContainer.css('display', 'none');
					} else {
						fakeContainer.css('display', 'block');
					}
				}
			}, 10);
		}
	});

}(window.supsystic = window.supsystic || {}, window.jQuery, window));
