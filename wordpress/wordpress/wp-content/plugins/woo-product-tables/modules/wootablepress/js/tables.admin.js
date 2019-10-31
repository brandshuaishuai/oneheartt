(function ($, app) {

	function AdminPage() {
		this.$obj = this;
		//this.tableSearchWrap = $('#wtbpSearchContentTbl');
		this.tableSearch = '';
		this.tablePropertiesWrap = $('#wtbpSetPropertiesContent');
		this.tableContent = '';
		this.tablePreview = '';
		this.tableContentReloading = false;

		return this.$obj;

	}

	AdminPage.prototype.init = (function () {
		var _thisObj = this.$obj;
		_thisObj.eventsAdminPage();
		_thisObj.eventsTables();
		_thisObj.eventsProperties();
		_thisObj.previewShowEvent();
		_thisObj.loadProductsSearchTbl();
		_thisObj.loadProductsContentTbl();
	});

	AdminPage.prototype.initTable = (function (tablename) {
		var _thisObj = this.$obj;
		switch (tablename) {
			case 'tableSearch':
				_thisObj.tableSearch = $('#wtbpSearchTable').css('width', '100%').DataTable(
					{
						serverSide: true,
						processing: true,
						ajax: {
							"url": url + '?mod=wootablepress&action=getSearchProducts&pl=wtbp&reqType=ajax',
							"type": "POST",
							data: function (d) {
								d.productids = $('input[name="settings[productids]"]').val();
								d.filter_in_table = $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_in_table"]').val();
								d.filter_author = $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_author"]').val();
								d.filter_category = $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_category"]').val();
								d.filter_tag = $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_tag"]').val();
								d.filter_attribute = $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_attribute"]').val();
								d.filter_attribute_exactly = $('#wtbpSearchTable_wrapper .dt-buttons input[name="filter_attribute_exactly"]').is(':checked') ? 1 : 0;
								d.show_variations = $('#wtbpSearchTable_wrapper .dt-buttons input[name="show_variations"]').is(':checked') ? 1 : 0;
								d.filter_private = $('#wtbpSearchTable_wrapper .dt-buttons input[name="filter_private"]').is(':checked') ? 1 : 0;
							},
							beforeSend: function() {
								$('#wtbpSearchTable').DataTable().column(4).visible($('#wtbpSearchTable_wrapper .dt-buttons input[name="show_variations"]').is(':checked'));
							}
						},
						dom: 'Bfrtip',
						buttons: [
							{
								text: 'Select all',
								className: 'button',
								action: function (e, dt, node, config) {
									$('.wtbpSearchTableWrapp table input[type="checkbox"]').prop('checked', true).closest('tr').addClass('selected');
									$('#wtbpSearchTableSelectAll').val(1);
									$('#wtbpSearchTableSelectExclude').val('');
								}
							},
							{
								text: 'Select none',
								className: 'button',
								action: function (e, dt, node, config) {
									$('.wtbpSearchTableWrapp table input[type="checkbox"]').prop('checked', false).closest('tr').removeClass('selected');
									$('#wtbpSearchTableSelectAll').val(0);
									$('#wtbpSearchTableSelectExclude').val('');
								}
							}
						],
						columnDefs: [{
							"targets": 'no-sort',
							"orderable": false
						},
						{
                			"targets": [0],
                			"className": 'checkbox-column'
                		}],
						order: [],
						responsive: true,
						language: {
							"emptyTable": "There\'re no products in the WooCommerce store",
						},
						fnDrawCallback : function(){
							if ( jQuery('#wtbpSearchTable_wrapper .dataTables_paginate  span .paginate_button').size() > 1) {
								jQuery('#wtbpSearchTable_wrapper .dataTables_paginate ')[0].style.display = "block";
							} else {
								jQuery('#wtbpSearchTable_wrapper .dataTables_paginate ')[0].style.display = "none";
							}
							jQuery('#wtbpSearchTable_wrapper label.wtbpPropuctInTable ').closest('tr').css('background-color', '#E5F7FF');
							wtbpSetSelectAllExclude(false, true, true, 'Search');
						}
					}
				);
				_thisObj.tableSearch.buttons().container().append($('#wtbpSearchTableFilters select, #wtbpSearchTableFilters div'));
				jQuery('#wtbpSearchTable_wrapper .dt-buttons select, #wtbpSearchTable_wrapper .dt-buttons input').on('change', function (e) {
					_thisObj.tableSearch.ajax.reload();
				});
				break;
			case 'tableContent':
				_thisObj.tableContent = $('.wtbpContentAdmTable').DataTable(
					{
						lengthChange: true,
						lengthMenu: [ [10, 20, 40, -1], [10, 20, 40, "All"] ],
   						paging: 10,
						dom: 'B<"pull-right"l>frtip',
						processing: true,
						buttons: [
							{
								text: 'Select all',
								className: 'button',
								action: function (e, dt, node, config) {
									_thisObj.tableContentSelectAll(true);
								}
							},
							{
								text: 'Select none',
								className: 'button',
								action: function (e, dt, node, config) {
									_thisObj.tableContentSelectAll(false);
								}
							},
							{
								text: '<i class="fa fa-minus"></i> Remove Selected Products',
								className: 'button',
								action: function (e, dt, node, config) {
									$(document.body).trigger('removeSelected');
								}
							}
						],
						columnDefs: [{
							"targets": 'no-sort',
							"orderable": false,
						}],
						order: [],
						language: {
							"emptyTable": "There\'re no products in the WooCommerce store",
						},
						fnDrawCallback : function(){
							if ( jQuery('#wtbpContentTable_wrapper .dataTables_paginate  span .paginate_button').size() > 1) {
								// jQuery('#wtbpContentTable_wrapper .dataTables_paginate ')[0].style.display = "block";
								jQuery('#wtbpContentTable_wrapper .dataTables_paginate ').show();
							} else {
								// jQuery('#wtbpContentTable_wrapper .dataTables_paginate ')[0].style.display = "none";
								jQuery('#wtbpContentTable_wrapper .dataTables_paginate ').hide();
							}
						}
					}
				);

				//Custom Drag and Drop sorting functional START
				var customSortIsChecked = true;
				if ( $('[name="settings[sorting_custom]"]' ).is(':checked') ) {
					customSortIsChecked = false;
				}
				var startData, startIndex, endIndex, dataTablePage, dataTableLength;
				var dataTable = $("#wtbpContentTable").dataTable();
				//We need update DataTable - data when drag and drop element
				$('.wtbpContentAdmTable').find("tbody").sortable({
					disabled: customSortIsChecked,
					start: function(event, ui) {
						//Get position of drag
						dataTableLength =  dataTable.api().data().page.info().length;
						dataTablePage = Number(dataTable.api().page() * dataTableLength);
						startIndex = ui.item.index();
						startIndex = Number(startIndex + dataTablePage);
						//Get data of drag row
						startData = dataTable.api().row(startIndex).data();
				    },
					stop: function(event, ui) {
						//Remove drag row and add it to end of dataTable
						dataTable.api().row(startIndex).remove();
						dataTable.api().row.add(startData);
						//Get position of drop
						dataTableLength =  dataTable.api().data().page.info().length;
						dataTablePage = Number(dataTable.api().page() * dataTableLength);
						endIndex = ui.item.index();
						endIndex = Number(endIndex + dataTablePage);
						//Get movement row Data and Length of all Rows
				        rowCount = dataTable.api().data().length-1;
				        insertedRow = dataTable.api().row(rowCount).data();
						//Move End row to need position
						for (var i=rowCount;i>endIndex;i--) {
					        tempRow = dataTable.api().row(i-1).data();
					        dataTable.api().row(i).data(tempRow);
					        dataTable.api().row(i-1).data(insertedRow);
					    }
						//Redraw dataTable
						dataTable.api().draw( false );
						//Remove all sortable icon from dataTable
						wtbSortableIconRemove();
						//Add sortable icon for sortable row
						wtbSortableIconAdd();
						//Put dataTable row product-id to productIds
				        wtbUpdateProductIds(false);
				    },
					containment: "parent",
					cursor: "move",
				});
				//Custom Drag and Drop sorting functional END

				break;
		}
		return;

	});

	/*AdminPage.prototype.chooseIconPopup = (function () {

		return false;
	});*/

	AdminPage.prototype.eventsAdminPage = (function () {
		var _thisObj = this.$obj;
		// Initialize Main Tabs
		var $mainTabsContent = $('#wtbpTablePressEditForm > .row-tab'),
			$mainTabs = $('.wtbpSub.tabs-wrapper.wtbpMainTabs .button'),
			$currentTab = $mainTabs.filter('.current').attr('href');

		$mainTabsContent.filter($currentTab).addClass('active');

		$mainTabs.on('click', function (e) {
			e.preventDefault();
			var $this = $(this),
				$curTab = $this.attr('href');

			$mainTabsContent.removeClass('active');
			$mainTabs.filter('.current').removeClass('current');
			$this.addClass('current');
			$mainTabsContent.filter($curTab).addClass('active');
		});


		// Initialize Settings Tabs
		var $settingsTabsContent = $('.row-settings-tab'),
			$settingsTabs = $('.tabs-settings .wtbpSub.tabs-wrapper .button'),
			$currentSettingsTab = $settingsTabs.filter('.current').attr('href');

		$settingsTabsContent.filter($currentSettingsTab).addClass('active');

		$settingsTabs.on('click', function (e) {
			e.preventDefault();
			var $this = $(this),
				$curTab = $this.attr('href');

			$settingsTabsContent.removeClass('active');
			$settingsTabs.filter('.current').removeClass('current');
			$this.addClass('current');
			$settingsTabsContent.filter($curTab).addClass('active');

			if($curTab == '#row-tab-settings-css') {
				var cssText = jQuery('#wtbpCssEditor').get(0);
				if(typeof(cssText.CodeMirrorEditor) === 'undefined') {
					if(typeof(CodeMirror) !== 'undefined') {
						var cssEditor = CodeMirror.fromTextArea(cssText, {
							mode: 'css',
							lineWrapping: true,
							lineNumbers: true,
							matchBrackets: true,
							autoCloseBrackets: true
						});
						cssText.CodeMirrorEditor = cssEditor;
					}
				} else {
					cssText.CodeMirrorEditor.refresh();
				}
			}
		});


		// Initialize Content Tabs
		var $contentTabsContent = $('.row-content-tab .row'),
			$contentTabs = $('.wtbpContentTabs .button'),
			$currentContentTab = $contentTabs.filter('.current').attr('href');

		$contentTabsContent.filter($currentContentTab).addClass('active');

		$contentTabs.on('click', function (e) {
			e.preventDefault();

			var $this = $(this),
				$curTab = $this.attr('href');

			$contentTabsContent.removeClass('active');
			$contentTabs.filter('.current').removeClass('current');
			$this.addClass('current');
			$contentTabsContent.filter($curTab).addClass('active');
		});

		$("#chooseColumns option").each(function(){
			var options = $(this);
			if(options.css('display') === 'block'){
				$("#chooseColumns").val(options.val());
				return false;
			}
		});

		$("#wtbpAddButton").prop('disabled', false);
		var i = 0;
		$("#chooseColumns option").each(function(){
			var options = $(this);
			if(options.css('display') === 'block'){
				$("#chooseColumns").val(options.val());
				i++;
				return false;
			}
		});
		if(i === 0){
			$("#chooseColumns").val('');
			$("#chooseColumns").css('disabled','disabled');
			//$("#wtbpAddButton").prop('disabled', true);
		}

	});

	AdminPage.prototype.eventsTables = (function () {
		var _thisObj = this.$obj;

		$('body').on('changeOrderPosition', function (e) {
			// help disabled multiple request for server
			if (_thisObj.tableContentReloading) {
				clearTimeout(_thisObj.tableContentReloading);
			}

			_thisObj.tableContentReloading = setTimeout(function () {
				_thisObj.loadProductsContentTbl();
				_thisObj.tableContentReloading = false;
			}, 2000);
		});

		$('body').on('addSelected', function (e) {
			e.preventDefault();
			if($('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_in_table"]').val() == 'yes') return true;
			$('#wtbpAddProducts').prop('disabled', true);

			var productIdExist = $('#wtbpTablePressEditForm input[name="settings[productids]"]').val();
			productIdExist = productIdExist.split(",");
			var productIdSelected = [],
				productIdExcluded = [],
				filters = {
					search: {value: $('#wtbpSearchTable_filter input').val()},
					filter_author: $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_author"]').val(),
					filter_category: $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_category"]').val(),
					filter_tag: $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_tag"]').val(),
					filter_attribute: $('#wtbpSearchTable_wrapper .dt-buttons select[name="filter_attribute"]').val(),
					show_variations: $('#wtbpSearchTable_wrapper .dt-buttons input[name="show_variations"]').is(':checked') ? 1 : 0,
					filter_private: $('#wtbpSearchTable_wrapper .dt-buttons input[name="filter_private"]').is(':checked') ? 1 : 0
				},
				orders = $('#wtbpTablePressEditForm input[name="settings[order]"]').val();

			if($('#wtbpSearchTableSelectAll').val() == '1') {
				productIdSelected = 'all',
				productIdExcluded = $('#wtbpSearchTableSelectExclude').val().split(',');
			} else {
				productIdSelected = $('#wtbpSearchTableSelectExclude').val().split(',');
				/*var data = _thisObj.tableSearch.rows('.selected').data().toArray();
				data.forEach(function (row, i) {
					row.forEach(function (column, j) {
						//get only id value
						if (j === 0) {
							var html = $.parseHTML(column)
								, id = $(html).attr('data-id');
							productIdSelected.push(id);
						}
					});
				});*/
			}

			$('#wtbpSearchTable')
				.find('.selected')
				.removeClass('selected')
				.find('input[type="checkbox"]')
				.prop("checked", false);

			$('#wtbpSearchTable')
				.find('th input[type="checkbox"]')
				.prop("checked", false);
			$('#wtbpSearchTableSelectAll').val(0);
			$('#wtbpSearchTableSelectExclude').val('');

			var tableId = $("#wtbpTablePressEditForm").attr('data-table-id') || 0;

			jQuery.sendFormWtbp({
				data: {
					mod: 'wootablepress',
					action: 'getProductContent',
					productIdSelected: productIdSelected,
					productIdExcluded: productIdExcluded,
					productIdExist: productIdExist,
					filters: filters,
					order: orders,
					tableid: tableId
				},
				onSuccess: function(res) {
					if (res.errors.length === 0 && res.html.length > 0) {
						var el = $('#wtbpContentTable');
						if ($.fn.dataTable.isDataTable('#wtbpContentTable')) {
							_thisObj.tableContent.destroy();
						}
						el.html(res.html);
						_thisObj.initTable('tableContent');
						_thisObj.tableContent.columns.adjust().draw();
						$('input[name="settings[productids]"]').val(res.data['ids']);
						_thisObj.tableSearch.ajax.reload();
						$('#wtbpSortTableContent').show();
						wtbSortableIconAdd();
					}
					$('#wtbpAddProducts').prop('disabled', false);
					$.sNotify({
						'icon': 'fa fa-check',
						'content': '<span>Product(s) added to the table</span>',
						'delay' : 1500
					});
				}
			});

		});

		$('body').on('removeSelected', function (e) {
			e.preventDefault();
			_thisObj.tableContent.rows('.selected').remove().draw();
			_thisObj.saveContentIdsToInput();
			$.sNotify({
				'icon': 'fa fa-check',
				'content': '<span>Product(s) removed from the table</span>',
				'delay': 1500,
			});
			$('#wtbpContentTable')
				.find('th input[type="checkbox"]')
				.prop("checked", false);

			$('#wtbpSearchTableSelectAll').val(0);
			$('#wtbpSearchTableSelectExclude').val('');
			_thisObj.tableSearch.ajax.reload();
		});

		$('body').on('click', '.wtbpContentTab', function (e) {
			if ($.fn.dataTable.isDataTable('#wtbpContentTable')) {
				_thisObj.tableContent.draw()
			}
		});

		$('body').on('click', '#buttonDelete', function (e) {
			e.preventDefault();
			if(confirm('Are you sure want to delete table?')) {
				var id = $('#wtbpTablePressEditForm').attr('data-table-id');

				if (id) {
					jQuery.sendFormWtbp({
						data: {
							mod: 'wootablepress',
							action: 'deleteByID',
							id: id,
						},
						onSuccess: function(res) {
							var redirectUrl = $('#wtbpTablePressEditForm').attr('data-href');
							if (!res.error) {
								toeRedirect(redirectUrl);
							}
						}
					});
				}
			}
		});

		$('body').on('click', '#buttonSave', function (e) {
			e.preventDefault();
			$('#wtbpTablePressEditForm').trigger('submit');
		});

		$('body').on('click', '#buttonClone', function (e) {
			e.preventDefault();
			var cloneDialog = jQuery('.wtbpCloneTableWrapp');
			if(cloneDialog.length) {
				var $error = cloneDialog.find('.wtbpCloneError'),
					$input = cloneDialog.find('input').val(jQuery('#wtbpTableTitleLabel').text()),
					tableid = $('#wtbpTablePressEditForm').attr('data-table-id');
					$dialog = cloneDialog.removeClass('wtbpHidden').dialog({
						width: 480,
						modal: true,
						autoOpen: false,
						buttons: {
							Save: function (event) {
								$error.fadeOut();
								$dialog.dialog('close');
								jQuery.sendFormWtbp({
									btn: jQuery('#buttonClone'),
									data: {
										mod: 'wootablepress',
										action: 'cloneTable',
										id: tableid,
										title: $input.val()
									},
									onSuccess: function(res) {
										if(!res.error) {
											if (res.data.edit_link) {
												toeRedirect(res.data.edit_link, true);
											}
										} else {
											$error.find('p').text(res.errors.title);
											$error.fadeIn();
										}
									}
								});
							},
							Cancel: function () {
								$dialog.dialog('close');
							}
						}
					});

				$input.on('focus', function () {
					$error.fadeOut();
				});

				$dialog.dialog('open');
			}
		});

		$('#wtbpTablePressEditForm').submit(function (e) {
			e.preventDefault();
			var cssText = jQuery('#wtbpCssEditor');
			if(typeof(cssText.get(0).CodeMirrorEditor) !== 'undefined') {
				cssText.val(cssText.get(0).CodeMirrorEditor.getValue());
			}

			jQuery(this).sendFormWtbp({
				btn: jQuery('#buttonSave')
				, onSuccess: function (res) {
					var currentUrl = window.location.href;
					if (!res.error && res.data.edit_link && currentUrl !== res.data.edit_link) {
						toeRedirect(res.data.edit_link);
					}
					jQuery('.icsComparisonSaveBtn i').attr('class', 'fa fa-check');
				}
			});
			return false;

		});

		$('input[name="settings[caption_enable]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('#wtbpCaptionText').removeClass('wtbpHidden');
			} else {
				$('#wtbpCaptionText').addClass('wtbpHidden');
			}
		});
		$('input[name="settings[description_enable]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('#wtbpDescriptionText').removeClass('wtbpHidden');
			} else {
				$('#wtbpDescriptionText').addClass('wtbpHidden');
			}
		});
		$('input[name="settings[header_show]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('#wtbpFixedHeader').removeClass('wtbpHidden');
			} else {
				$('#wtbpFixedHeader').addClass('wtbpHidden');
			}
		});
		$('input[name="settings[signature_enable]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('#wtbpSignatureText').removeClass('wtbpHidden');
			} else {
				$('#wtbpSignatureText').addClass('wtbpHidden');
			}
		});
		$('input[name="settings[auto_width]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('#wtbpFixedTableWidthText').addClass('wtbpVisibilityHidden');
			} else {
				$('#wtbpFixedTableWidthText').removeClass('wtbpVisibilityHidden');
			}
		});
		$('select[name="settings[thumbnail_size]"]').on('change', function () {
			if ($(this).val() == 'set_size') {
				$('.wtbpSetImageSize').removeClass('wtbpHidden');
			} else {
				$('.wtbpSetImageSize').addClass('wtbpHidden');

			}
		});
		$('input[name="settings[sorting]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('.wtbpSortingSub').removeClass('wtbpHidden');
			} else {
				$('.wtbpSortingSub').addClass('wtbpHidden');
			}
		});
		$('input[name="settings[pagination]"]').on('change', function () {
			if ($(this).is(':checked')) {
				$('.wtbpPaginationSub').removeClass('wtbpHidden');
			} else {
				$('.wtbpPaginationSub').addClass('wtbpHidden');
			}
			$('input[name="settings[pagination_menu]"]').trigger('change');
		});
		$('input[name="settings[pagination_menu]"]').on('change', function () {
			$('input[name="settings[page_length]"], input[name="settings[pagination_menu_content]"]').closest('tr').addClass('wtbpHidden');
			if ($(this).is(':checked')) {
				$('input[name="settings[pagination_menu_content]"]').closest('tr').removeClass('wtbpHidden');
			} else {
				$('input[name="settings[page_length]"]').closest('tr').removeClass('wtbpHidden');
			}
		});
		$('select[name="settings[responsive_mode]"]').on('change', function () {
			if ($(this).val() == 'horizontal') {
				$('.wtbpHorizontalPosition').removeClass('wtbpHidden');
			} else {
				$('.wtbpHorizontalPosition').addClass('wtbpHidden');
			}
		});

		// Work with shortcode copy text
		$('#wtbpCopyTextCodeExamples').on('change', function (e) {
			var optName = $(this).val();
			switch (optName) {
				case 'shortcode' :
					$('.wtbpCopyTextCodeShowBlock').hide();
					$('.wtbpCopyTextCodeShowBlock.shortcode').show();
					break;
				case 'phpcode' :
					$('.wtbpCopyTextCodeShowBlock').hide();
					$('.wtbpCopyTextCodeShowBlock.phpcode').show();
					break;
			}
		});

		//Work with title
		$('#wtbpTableTitleShell').on('click', function () {
			$('#wtbpTableTitleLabel').hide();
			$('#wtbpTableTitleTxt').show();
		});

		//Work with title
		$('#wtbpTableTitleTxt').on('focusout', function () {
			var tableTitle = $(this).val();
			$('#wtbpTableTitleLabel').text(tableTitle);
			$('#wtbpTableTitleTxt').hide();
			$('#wtbpTableTitleLabel').show();
			$('#buttonSave').trigger('click');
		});
	});

	AdminPage.prototype.tableContentSelectAll = (function (check) {
		var _thisObj = this.$obj,
			page = _thisObj.tableContent.page();
		_thisObj.tableContent.column(0).nodes().to$().each(function(index) {
			$(this).find('input').prop('checked', check);
			if(check) $(this).closest('tr').addClass('selected');
			else $(this).closest('tr').removeClass('selected');
		});
		_thisObj.tableContent.page(page).draw('page');
	});

	AdminPage.prototype.eventsProperties = (function () {
		var _thisObj = this.$obj;

		jQuery('#wtbpSetProperties').on('click', function (e) {
			e.preventDefault();
			var button = $(this)
				, butWrapper = button.parent();

			if (!button.hasClass('active')) {
				butWrapper.find('button').removeClass('active');
				button.addClass('active');
				$(_thisObj.tableSearchWrap).css('display', 'none');
				$(_thisObj.tablePropertiesWrap).css('display', 'block');
			}
		});

		//make properties sortable
		$(".wtbpPropertiesWrapp").sortable({
			containment: "parent",
			cursor: "move",
			stop: _thisObj.saveProperties,
			handle: ".wtbpOptionDragHandler"
		});
		//make properties sortable end

		$('body').on('click', '.wtbpOptionEditHandler', function (e) {
			e.preventDefault();
			var el = $(this),
				wrapper = el.closest('.wtbpOptions'),
				slug = wrapper.attr('data-slug'),
				propType = $('#chooseColumns option[value="'+slug+'"]').attr('data-type'),
				options = [];
			try{
				var columns = JSON.parse($('#wtbpTablePressEditForm input[name="settings[order]"]').val());
				for(var i = 0; i < columns.length; i++) {
					if(columns[i]['slug'] == slug) {
						options = columns[i];
						break;
					}
				}
			}catch(e){
				options = [{'slug': slug}];
			}
			var columnNameHtml = wrapper.find('.content'),
				dialogHtml = $('.wtbpPropertiesChangeNameWrapp').removeClass('wtbpHidden');

			dialogHtml.find('span.originalName').text('original_name' in options ? options['original_name'] : columnNameHtml.text());
			dialogHtml.find('.wtbpOptionContainer').each(function() {
				var container = $(this),
					forProperties = container.attr('data-properties'),
					forType = container.attr('data-types');
				container.removeClass('wtbpHidden');
				if((typeof forProperties !== 'undefined' && forProperties != slug) || (typeof forType !== 'undefined' && forType != propType)) {
					container.addClass('wtbpHidden');
				}
			});
			dialogHtml.find('input, select').each(function() {
				var element = $(this);

				if(!element.closest('.wtbpOptionContainer').hasClass('wtbpHidden')) {
					var elName = element.attr('name'),
						elType = element.attr('type'),
						value = elName in options ? options[elName] : '';
					if(elType == 'radio') {
						element.prop('checked', element.attr('value') == (value == '' ? '0' : value));
					} else if(elType == 'checkbox') {
						element.prop('checked', value == 1);
						if (element.hasClass("wtbpDefaultChecked")) {
							if (value.length === 0) {
								element.prop('checked', true);
							}
						}
					} else {
						if(element.is('select') && value == '') {
							element.find('option').prop('selected', false);
							element.find('option:first').prop('selected', true);
						} else {
							element.val(value);
						}
					}
					if(element.hasClass("wtbpHideByParent")) {
						var parentName = element.attr("data-parent"),
							parent = jQuery("body").find("[name="+parentName+"]"),
							hideBlock = element.closest('.wtbpHideByParentBlock');
						if(hideBlock.length == 0) {
							hideBlock = element;
						}
						if(parent.is('select')) {
							if(element.attr("data-parent-value") == parent.val()) {
								hideBlock.show();
							} else {
								hideBlock.hide();
							}

						} else {
							if(parent.prop("checked")) {
								hideBlock.show();
							} else {
								hideBlock.hide();
							}
						}
					}
					var fileWrapper = element.closest('.wtbpSelectFile');
					if(fileWrapper.length) {
						var img = fileWrapper.find('img');
						if(img.length) {
							img.attr('src', value.length ? value : img.attr('data-src'));
						}
					}
				}
			});
			var $dialog = dialogHtml.dialog({
				width: 350,
				modal: true,
				autoOpen: false,
				close: function () {
					$dialog.dialog('close');
				},
				buttons: {
					Change: function (event) {
						$dialog.find('input, select').each(function() {
							var element = $(this),
								elName = element.attr('name');
							if(element.closest('.wtbpOptionContainer').hasClass('wtbpHidden')) {
								delete options[elName];
							} else {
								var elType = element.attr('type');
								if(elType == 'radio') {
									options[elName] = $dialog.find('input[name="'+elName+'"]:checked').attr('value');
								} else if(elType == 'checkbox') {
									options[elName] = element.prop('checked') ? 1 : 0;
								} else {
									options[elName] = element.val();
								}
							}
						});
						options['original_name'] = $dialog.find('span.originalName').text();
						columnNameHtml.text(options['show_display_name'] == '1' ?  options['display_name'] : options['original_name']);

						_thisObj.saveProperties('update', options);
						$dialog.dialog('close');
					},
					Cancel: function () {
						$dialog.dialog('close');
					}
				}
			});

			$dialog.dialog('open');

		});
		$('body').on('click', '.wtbpOptionContainer input[type=checkbox]', function(e) {
			var element = jQuery(this),
				elName = element.attr("name"),
				elHiddenChildren = jQuery('body').find('[data-parent='+elName+']'),
				elIsChecked = element.prop('checked');

			if (elHiddenChildren.length > 0) {
				if (elIsChecked) {
					elHiddenChildren.show();
				} else {
					elHiddenChildren.hide();
				}
			}
		});
		$('body').on('change', '.wtbpOptionContainer select', function(e) {
			var element = jQuery(this),
				container = element.closest('.wtbpOptionContainer'),
				elName = element.attr('name'),
				elValue = element.val();
			container.find('[data-parent='+elName+']').closest('.wtbpHideByParentBlock').hide();
			container.find('[data-parent='+elName+'][data-parent-value='+elValue+']').closest('.wtbpHideByParentBlock').show();
		});
		$('body').on('click', '.wtbpSelectFileButton', function(e){
			e.preventDefault();
			var $button = $(this),
				$input = $button.parent().find('input'),
				$img = $button.parent().find('img');
			_custom_media = true;
			wp.media.editor.send.attachment = function(props, attachment){
				wp.media.editor._attachSent = true;
				if(_custom_media) {
					var selectedUrl = attachment.url;
					if(props && props.size && attachment.sizes && attachment.sizes[ props.size ] && attachment.sizes[ props.size ].url) {
						selectedUrl =  attachment.sizes[ props.size ].url;
					}
					$input.val(selectedUrl).trigger('change');
					if($img.length) $img.attr('src', selectedUrl);
				} else {
					return _orig_send_attachment.apply( this, [props, attachment] );
				}
			};
			wp.media.editor.insert = function(html) {
				if(_custom_media) {
					if(wp.media.editor._attachSent) {
						wp.media.editor._attachSent = false;
						return;
					}
					if(html && html != "") {
						var selectedUrl = $(html).attr('src');
						if(selectedUrl) {
							$input.val(selectedUrl).trigger('change');
							if($img.length) $img.attr('src', selectedUrl);
						}
					}
				}
			};
			wp.media.editor.open($button);
			$('.attachment-filters').val($button.data('type')).trigger('change');
			return false;
		});

		$('body').on('click', '.wtbpOptionRemoveHandler', function (e) {
			e.preventDefault();
			var wrapper = $(this).closest('.wtbpOptions'),
				slug = wrapper.attr('data-slug');
			wrapper.remove();
			$('#chooseColumns option[value="'+slug+'"]').css('display','block');
			_thisObj.saveProperties('delete', {'slug': slug});
		});

		$('#chooseColumns').on('change', function (e) {
			e.preventDefault();
			var selectedProperty = $('#chooseColumns option:selected');
			$('#wtbpProColumn, #wtbpAddButton').css('display','none');
			$(selectedProperty.length == 0 || selectedProperty.attr('data-enabled') == '1' ? '#wtbpAddButton' : '#wtbpProColumn').css('display', 'inline-block');
		}).trigger('change');

		$('#wtbpAddButton').on('click', function (e) {
			e.preventDefault();
			var selected = $('#chooseColumns').find(":selected")
				, slug = selected.attr('value')
				, name = selected.attr('data-name')
				, template = $('.wtbpOptionsEmpty').clone()
				, propertiesWrapp = $('.wtbpPropertiesWrapp');

			if(!$('.wtbpPropertiesWrapp .wtbpOptions[data-slug="'+slug+'"]').length && slug ) {
				//make add button not active
				jQuery('#wtbpSearchTable_wrapper .dt-buttons button').attr('disabled', 'disabled');
				template.removeClass('wtbpOptionsEmpty wtbpHidden');
				template.attr('data-name', name);
				template.attr('data-slug', slug);
				template.find('.content').html(name);
				propertiesWrapp.append(template);
				$('#chooseColumns option[value="'+slug+'"]').css('display','none');
				_thisObj.saveProperties('add', {slug: slug, original_name: name});
			}

		});
	});

	AdminPage.prototype.saveProperties = (function (mode, options) {
		var orders = $('#wtbpTablePressEditForm input[name="settings[order]"]');
			slug = options ? options.slug : false;
		try {
			var properties = JSON.parse(orders.val());
		} catch(e) {
			var properties = [];
		}
		if(typeof mode === 'object') {
			var currentOrder = {},
				i = 0;
			$('.wtbpPropertiesWrapp .wtbpOptions').not('.wtbpEmptyOptions').each(function (index) {
				i++;
				currentOrder[$(this).attr('data-slug')] = i;
			});
			properties.sort(function(a, b){
				return currentOrder[a.slug] - currentOrder[b.slug];
			});
		} else if(mode == 'add') {
			properties.push(options);
		} else {
			for(var i = 0; i < properties.length; i++) {
				if('slug' in properties[i] && properties[i]['slug'] == slug) {
					if(mode == 'update') {
						properties[i] = options;
					} else if(mode == 'delete') {
						properties.splice(i, 1);
					}
					break;
				}
			}
		}
		var uniq = [],
			forDelete = [];
		for(var i = 0; i < properties.length; i++) {
			if('slug' in properties[i]) {
				var slug = properties[i]['slug'];
				if(toeInArrayWtbp(slug, uniq)) {
					forDelete.push(i);
				} else {
					uniq.push(slug);
				}
			} else {
				forDelete.push(i);
			}
		}
		if(forDelete.length) {
			for (var i = forDelete.length - 1; i >= 0; i--) {
				properties.splice(forDelete[i], 1);
			}
		}
		if(mode == 'add' || mode == 'delete') {
			var chooseColumns = $('#chooseColumns');
			$("#wtbpAddButton").prop('disabled', false);
			var i = 0;
			chooseColumns.find('option').each(function(){
				var option = $(this);
				if(option.css('display') === 'block'){
					chooseColumns.val(option.val());
					i++;
					return false;
				}
			});
			if(i === 0){
				chooseColumns.val('').css('disabled','disabled');
				//$("#wtbpAddButton").prop('disabled', true);
			}
		}
		$('#chooseColumns').trigger('change');

		var propertiesJson = JSON.stringify(properties);
		$('input[name="settings[order]"]').val(propertiesJson);

		$(document.body).trigger('changeOrderPosition');
	});

	AdminPage.prototype.loadProductsSearchTbl = (function () {
		var _thisObj = this.$obj;
		_thisObj.initTable('tableSearch');

		jQuery('#wtbpAddProducts').on('click', function (e) {
			e.preventDefault();
			var w = $(window).width() * 0.95,
				h = $(window).height() * 0.95;

			var $dialog = $('.wtbpSearchTableWrapp').removeClass('wtbpHidden').dialog({
				width: w,
				height: h,
				modal: true,
				autoOpen: false,
				title: "Manage Table Contents",
				close: function () {
					$dialog.dialog('close');
				},
				buttons: {
					'Add selected products to the table': function (event) {
						$(document.body).trigger('addSelected');
						$dialog.dialog('close');
					},
					Cancel: function () {
						$dialog.dialog('close');
					}
				}
			});

			$dialog.dialog('open');
		});
	});

	AdminPage.prototype.loadProductsContentTbl = (function (byCategories) {
		var _thisObj = this.$obj,
			byCategories = typeof(byCategories) == 'undefined' ? false : true,
			wtbpForm = $('#wtbpTablePressEditForm'),
			productsInput = wtbpForm.find('input[name="settings[productids]"]'),
			autoEnabled = wtbpForm.find('input[name="settings[auto_categories_enable]"]'),
			autoCategories = byCategories && autoEnabled.length && autoEnabled.is(':checked') ? wtbpForm.find('input[name="settings[auto_categories_list]"]').val().split(',') : [];

		//if exist post id show them in second tables
		if(productsInput.val().length || autoCategories.length) {
			var productIdExist = productsInput.val().split(',');
			var orders = wtbpForm.find('input[name="settings[order]"]').val(),
				tableId = wtbpForm.attr('data-table-id') || 0,
				loading = wtbpForm.find('#wtbpContentTable_processing');
			loading.css('display', 'block');

			jQuery.sendFormWtbp({
				data: {
					mod: 'wootablepress',
					action: 'getProductContent',
					productIdExist: productIdExist,
					autoCategories: autoCategories,
					order: orders,
					tableid: tableId
				},
				onSuccess: function(res) {
					if(!res.error) {
						if (res.errors.length === 0 && res.html.length > 0) {
							var el = $('#wtbpContentTable');
							if (!$.fn.dataTable.isDataTable('#wtbpContentTable')) {
								el.html(res.html);
								_thisObj.initTable('tableContent');
							} else {
								_thisObj.tableContent.destroy();
								el.html(res.html);
								_thisObj.initTable('tableContent');
							}
							$('#wtbpSortTableContent').show();
							productsInput.val(res.data['ids']);
							if(byCategories) {
								_thisObj.tableSearch.ajax.reload();
							}
						}
						wtbSortableIconAdd();
					}
					//_thisObj.processing(false);
					loading.css('display', 'none');
				}
			});
		} else {
			$('#wtbpSortTableContent').hide();
		}
		//make add button active again
		jQuery('#wtbpSearchTable_wrapper .dt-buttons button').removeAttr('disabled');
	});

	AdminPage.prototype.previewShowEvent = (function () {
		var _thisObj = this.$obj;

		$('body').on('click', '.wtbpPreviewShow', function (e) {
			e.preventDefault();
			$('.wtbpAdminPreviewNotice').addClass('wtbpHidden');
			$('#loadingProgress').removeClass('wtbpHidden');
			$('#buttonSave').trigger('click');

			setTimeout(function () {
				if ($('input[name="settings[productids]"]').val().length) {
					var productIdExist = $('input[name="settings[productids]"]').val();
					productIdExist = productIdExist.split(",");
					var orders = $('#wtbpTablePressEditForm input[name="settings[order]"]').val();
					var tableId = $("#wtbpTablePressEditForm").attr('data-table-id') || 0;
					jQuery.sendFormWtbp({
						data: {
							mod: 'wootablepress',
							action: 'getProductContent',
							productIdExist: productIdExist,
							order: orders,
							tableid: tableId,
							frontend: true,
							prewiew: true
						},
						onSuccess: function(res) {
							if (!res.error && res.html.length > 0) {
								var el = $('#wtbpPreviewTable'),
									wrapper = $('#wtbp-table-wrapper-1');
									tableWrapper = $('#row-tab-preview .wtbpTableWrapper'),
									settings = res.data['settings'],
									filter = res.data['filter'],
									customCss = res.data['css'];

								if (_thisObj.tablePreview !== null && typeof _thisObj.tablePreview === 'object') {
									_thisObj.tablePreview.destroy();
									wrapper.find('*').not('#wtbpPreviewTable, #wtbpPreviewFilter, .wtbpCustomCssWrapper').remove();
								}
								el.html(res.html);
								wrapper.find('#wtbpPreviewFilter').empty().append(filter);
								wrapper.find('.wtbpCustomCssWrapper').html(customCss);

								$.fn.dataTableExt.afnFiltering.length = 0;
								_thisObj.tablePreview = app.WooTablepress.initializeTable(tableWrapper, function () {}, settings);
								wrapper.find('.wtbpLoader').addClass('wtbpHidden');
								$('.wtbpAdminPreviewNotice').addClass('wtbpHidden');
								$('#loadingFinished').removeClass('wtbpHidden');
								_thisObj.tablePreview.columns.adjust().draw();
								_thisObj.tablePreview.fixedHeader.adjust();
								$('#wtbpPreviewTable').show();
							}
						}
					});
				} else {
					$('.wtbpAdminPreviewNotice').addClass('wtbpHidden');
					$('#loadingEmpty').removeClass('wtbpHidden');
					$('#wtbpPreviewTable').hide();
				}
			}, 1000);
		});
	});

	AdminPage.prototype.saveContentIdsToInput = (function () {
		var _thisObj = this.$obj;
		if (_thisObj.tableContent) {
			var contentData = _thisObj.tableContent.rows().data().toArray();
			var postids = [];
			contentData.forEach(function (row, i) {
				row = Object.values(row);
				row.forEach(function (column, j) {
					//get only id value
					if (j === 0) {
						var html = $.parseHTML(column)
							, id = $(html).attr('data-id');

						postids.push(id);
					}
				});
			});
			$('input[name="settings[productids]"]').val(postids);
		}
	});

	$(document).ready(function () {
		//var adminPage = new AdminPage();
		//adminPage.init();
		app.WtbpAdminPage = new AdminPage();
		app.WtbpAdminPage.init();
	});

	//Custom Drag and Drop sorting functional START

	//Replace ROW position by input index
	$("body").on("click",".wtbpSortableIcon", function(){
		var dataTable = $("#wtbpContentTable").dataTable();
		var rowCount = dataTable.api().data().length;
		var newIndex = prompt("Set a new position index for this product (from 1 to "+rowCount+")", "");
		var oldIndex = $(this).parent().index();
		var dataTableLength =  dataTable.api().data().page.info().length;
		dataTablePage = Number(dataTable.api().page() * dataTableLength);
		oldIndex = Number(oldIndex + dataTablePage);
		newIndex = Number(newIndex);
		if ( (newIndex > rowCount) || (newIndex <= 0) ) {
			return false;
		}
		wtbMoveSortable (oldIndex, newIndex);
	});
	function wtbMoveSortable (oldIndex, newIndex) {
		var dataTable = $("#wtbpContentTable").dataTable();
		var startData = dataTable.api().row(oldIndex).data();
		//Remove drag row and add it to end of dataTable
		dataTable.api().row(oldIndex).remove();
		dataTable.api().row.add(startData);
		//Get movement row Data and Length of all Rows
		rowCount = dataTable.api().data().length-1;
		insertedRow = dataTable.api().row(rowCount).data();
		//Move End row to need position
		for (var i=rowCount;i>newIndex-1;i--) {
			tempRow = dataTable.api().row(i-1).data();
			dataTable.api().row(i).data(tempRow);
			dataTable.api().row(i-1).data(insertedRow);
		}
		//Redraw dataTable
		dataTable.api().draw( false );
		//Remove all sortable icon from dataTable
		wtbSortableIconRemove();
		//Add sortable icon for sortable row
		wtbSortableIconAdd();
		//Put dataTable row product-id to productIds
		wtbUpdateProductIds(false);
	}
	//Add sortable icons to dataTable
	function wtbSortableIconAdd () {
		var dataTable = $("#wtbpContentTable").dataTable();
		if ( $('[name="settings[sorting_custom]"]').is(':checked') ) {
			$("#wtbpContentTable").find("thead tr").prepend("<th class='wtbpSortableIconThead' style='width:10px;'></th>");
			$("#wtbpContentTable").find("tfoot tr").prepend("<th class='wtbpSortableIconTfoot' style='width:10px;'></th>");
			$(dataTable.fnGetNodes()).each(function(){
					$(this).prepend("<td class='wtbpSortableIcon'><i class='fa fa-arrows-v' aria-hidden='true'></i></td>");
			});
		}
	}
	//Remove sortable icons from dataTable
	function wtbSortableIconRemove () {
		var dataTable = $("#wtbpContentTable").dataTable();
		$("#wtbpContentTable").find(".wtbpSortableIconThead").remove();
		$("#wtbpContentTable").find(".wtbpSortableIconTfoot").remove();
		$(dataTable.fnGetNodes()).each(function(){
			$(this).find(".wtbpSortableIcon").remove();
		});
	}
	//Update ProductIds by DataTable rows product-id
	$('body').on('mouseup', '#wtbpContentTable thead tr th', function (e) {
		wtbUpdateProductIds(true);
	});
	function wtbUpdateProductIds (sortable = false) {
		var productIds = [];
		var dataTable = $("#wtbpContentTable").dataTable();
		$(dataTable.fnGetNodes()).each(function(){
			dataId = $(this).find("[data-id]").attr('data-id');
			productIds.push(dataId);
		})
		if (sortable == true) {
			productIds.reverse();
		}
		productIds.join();
		$('input[name="settings[productids]"]').val(productIds);
		//console.log( $('input[name="settings[productids]"]').val() );
	}
	//Toggle checkbox, select input and toggle sortable icon by sorting_custom checked status
	$('[name="settings[sorting_custom]"]').on('change', function() {
		var dataTable = $("#wtbpContentTable").dataTable();
		if ($(this).is(':checked')) {
			$('[name="settings[sorting_default]"]').prop("disabled",true);
			$('[name="settings[sorting_desc]"]').prop("disabled",true);
			$('[name="settings[sorting_desc]"]').attr("checked",false);
			$('body').find('.wtbpContentAdmTable tbody.ui-sortable').sortable("enable");
			wtbSortableIconAdd();
		} else {
			$('[name="settings[sorting_default]"]').prop("disabled",false);
			$('[name="settings[sorting_desc]"]').prop("disabled",false);
			$('body').find('.wtbpContentAdmTable tbody.ui-sortable').sortable("disable");
			wtbSortableIconRemove();
		}
	});
	$('[name="settings[sorting]"]').on('change', function() {
		if ($(this).is(':checked')) {
			$('[name="settings[sorting_custom]"]').attr("checked",false);
			$('[name="settings[sorting_default]"]').prop("disabled",false);
			$('[name="settings[sorting_desc]"]').prop("disabled",false);
		} else {
			$('[name="settings[sorting_custom]"]').attr("checked",true);
		}
	});

	//Custom Drag and Drop sorting functional END

}(window.jQuery, window.supsystic));