<?php
$isPro = true;
if ( ! $isPro ) {
	$wtbpDisabled = 'wtbpDisabled';
} else {
	$wtbpDisabled = '';
}

?>


	<div id="wtbpTablePressEditTabs">
		<section>
			<div class="supsystic-item supsystic-panel" style="padding-left:20px; padding-right:20px;">
				<div id="containerWrapper">
					<form id="wtbpTablePressEditForm" data-table-id="<?php echo $this->table['id']; ?>" data-href="<?php echo $this->link;?>">

						<div class="row">
							<div class="wtbpCopyTextCodeSelectionShell col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<div class="row">
									<div class="col-md-4 col-sm-5 col-xs-12 wtbpNamePadding">
										<span id="wtbpTableTitleWrapLabel"><?php echo __('Table name:', WTBP_LANG_CODE); ?></span>
										<span id="wtbpTableTitleShell" title="<?php echo esc_html(__('Click to edit', WTBP_LANG_CODE))?>">
                                        <?php $title = isset($this->table['title']) ? $this->table['title'] : '';?>
											<span id="wtbpTableTitleLabel"><?php echo $title; ?></span>
											<?php echo htmlWtbp::text('title', array(
												'value' => $title,
												'attrs' => 'style="display:none;" id="wtbpTableTitleTxt"',
												'required' => true,
											)); ?>
											<i class="fa fa-fw fa-pencil"></i>
									</span>
									</div>
									<div class="col-md-3 col-sm-5 col-xs-10 wtbpShortcodeAdm">
										<select name="shortcode_example" id="wtbpCopyTextCodeExamples">
											<option value="shortcode"><?php echo __('Table Shortcode', WTBP_LANG_CODE); ?></option>
											<option value="phpcode"><?php echo __('Table PHP code', WTBP_LANG_CODE); ?></option>
										</select>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-2 wtbpTooltipInfo">
										<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Table PHP code: lets display the table through themes/plugins files (for example in the site footer). You can use shortcode in this way. <a href="https://woobewoo.com/documentation/how-to-add-a-product-table-to-a-page" target="_blank">Read more.</a>', WTBP_LANG_CODE))?>"></i>
									</div>
									<?php $id = isset($this->table['id']) ? $this->table['id'] : ''; ?>
									<?php if($id) {?>
										<div class="col-md-4 col-sm-6 col-xs-12 wtbpCopyTextCodeShowBlock wtbpShortcode shortcode" style="">
											<?php
											echo htmlWtbp::text('', array(
												'value' => "[".WTBP_SHORTCODE." id=$id]",
												'attrs' => 'readonly style="width: 100%" onclick="this.setSelectionRange(0, this.value.length);" class=""',
												'required' => true,
											));
											?>
										</div>
										<div class="col-md-4 col-sm-6 col-xs-12 wtbpCopyTextCodeShowBlock wtbpShortcode phpcode" style="display: none;">
											<?php
											echo htmlWtbp::text('', array(
												'value' => "<?php echo do_shortcode('[".WTBP_SHORTCODE." id=$id]') ?>",
												'attrs' => 'readonly style="width: 100%" onclick="this.setSelectionRange(0, this.value.length);" class=""',
												'required' => true,
											));
											?>
										</div>
									<?php } else { ?>
										<div class="col-md-8 col-sm-6 col-xs-10" style="line-height: 30px;">
											<?php echo __('Will be created after first save', WTBP_LANG_CODE); ?>
										</div>
									<?php } ?>
									<div class="clear"></div>
								</div>
							</div>
							<div class="wtbpMainBtnsShell col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<ul class="wtbpSub control-buttons">
									<li>
										<button id="buttonSave" class="button">
											<i class="fa fa-floppy-o" aria-hidden="true"></i><span><?php echo __('Save', WTBP_LANG_CODE); ?></span>
										</button>
									</li>
									<li>
										<button id="buttonClone" class="button">
											<i class="fa fa-files-o" aria-hidden="true"></i><span><?php echo __('Clone', WTBP_LANG_CODE); ?></span>
										</button>
									</li>
									<li>
										<button id="buttonDelete" class="button">
											<i class="fa fa-trash-o" aria-hidden="true"></i><span><?php echo __('Delete', WTBP_LANG_CODE); ?></span>
										</button>
									</li>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12">
								<ul class="wtbpSub tabs-wrapper wtbpMainTabs">
									<li>
										<a href="#row-tab-content" class="current button wtbpContentTab"><i class="fa fa-fw fa-th"></i><?php echo __('Content', WTBP_LANG_CODE); ?></a>
									</li>
									<li>
										<a href="#row-tab-settings" class="button"><i class="fa fa-fw fa-wrench"></i><?php echo __('Settings', WTBP_LANG_CODE); ?></a>
									</li>
									<li>
										<a href="#row-tab-preview" class="button wtbpPreviewShow"><i class="fa fa-fw fa-eye"></i><?php echo __('Preview', WTBP_LANG_CODE); ?></a>
									</li>
								</ul>
								<span id="wtbpTableTitleEditMsg"></span>
							</div>
						</div>

						<div class="row row-tab active" id="row-tab-content">
							<!-- Save post id's -->
							<?php echo htmlWtbp::hidden('settings[productids]', array(
								'value' => (isset($this->settings['settings']['productids']) ? $this->settings['settings']['productids'] : ''),
							));?>

							<div class="col-xs-12">

								<h3 class="wtbpHeaders"><?php _e('Table Columns', WTBP_LANG_CODE)?></h3>

								<label style="margin-bottom: 25px; font-weight: 500;"><?php _e('Select properties to add to the table', WTBP_LANG_CODE)?>
									<select id="chooseColumns">
										<?php
										$order = array();
										$isDefault = true;
										$savedColumns = array();

										if(isset($this->settings['settings']['order']) && !empty($this->settings['settings']['order'])) {
											$optionsArr = json_decode($this->settings['settings']['order'], TRUE);
											foreach($optionsArr as $i => $column){
												$order[$column['slug']] = !empty($column['show_display_name']) ? $column['display_name'] : $column['original_name'];
												$savedColumns[$column['slug']] = $i;
											}
											$isDefault = false;
										}
										$enabledColumns = array();
										$sortableColumns = array('' => __('none', WTBP_LANG_CODE));
										$disableSort = array('thumbnail', 'add_to_cart');
										foreach($this->table_columns as $column) {
											$slug = $column['slug'];
											if($isDefault && $column['is_default']) {
												$order[$slug] = $column['name'];
											}
											$enabled = $column['is_enabled'];
											$enabledColumns[$slug] = $enabled;
											$visible = isset($order[$slug]) && $enabled ? 'style="display:none;"' : '';
											$style = empty($column['class']) ? '' : ' class="'.$column['class'].'"';
											$propType = empty($column['type']) ? '' : ' data-type="'.$column['type'].'"';

											if($slug !== 'id'){
												echo '<option '.$visible.$style.$propType.' value="'.$slug.'" data-name="'.$column['name'].'" data-enabled="'.$enabled.'">'.($column['sub'] ? '&nbsp;&nbsp;&nbsp;' : '').$column['name'].'</option>';
												if(!in_array($slug, $disableSort)) {
													$sortableColumns[$slug] = $column['name'];
												}
											}
										}

										?>
									</select>
									<button id="wtbpAddButton" class="button active" style="height: 28px; line-height: 26px;"><span><?php _e('Add', WTBP_LANG_CODE)?></span></button>
									<span class="wtbpPro wtbpProInline" id="wtbpProColumn"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=button-add-properties&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
								</label>
								<div class="wtbpPropertiesWrapp">
									<?php
									$curOrder = array();
									foreach($order as $slug => $name) {
										if(!isset($enabledColumns[$slug]) || !$enabledColumns[$slug]) continue;
										$curOrder[] = $isDefault ? array('slug' => $slug, 'original_name' => $name) : $optionsArr[$savedColumns[$slug]];
										echo '<div class="wtbpOptions" data-slug="'.$slug.'"><div class="content">'.$name.'</div>';
										?>
											<div class="wtbpOptionHandlers">
												<div class="wtbpOptionDragHandler"><i class="fa fa-arrows-h"></i></div>
												<div class="wtbpOptionEditHandler"><i class="fa fa-fw fa-pencil"></i></div>
												<div class="wtbpOptionRemoveHandler"><i class="fa fa-fw fa-trash-o"></i></div>
											</div>
										</div>
										<?php
									}
									?>
									<!-- Save show elements name like columns order in content table -->
									<?php echo htmlWtbp::hidden('settings[order]', array(
										'value' => htmlentities(json_encode($curOrder)),
									));?>
								</div>
								<div class="wtpbAutoCategories">
									<?php if($this->is_pro) {
										dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminAddAuto', array('settings' => $this->settings, 'categories_html' => $this->categories_html));
									} else { ?>
										<?php echo htmlWtbp::checkbox('settings[auto_categories_enable]', array(
											'checked' => '', 'disabled' => 1))?>
										<?php _e('Add products automatically', WTBP_LANG_CODE)?>
										<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><img src="'.$this->getModule()->getModPath(). 'img/add_products_automatically.png'.'" height="264"></div>')?>"></i>
										<span class="wtbpPro wtbpProInline"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=add-product-automatically&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
									<?php } ?>
								</div>
								<div class="wtbpSearchTableWrapp wtbpAdminTableWrapp wtbpHidden">
									<div id="wtbpSearchTableFilters">
										<select name="filter_in_table">
											<option value=""><?php _e('In table', WTBP_LANG_CODE);?></option>
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
										<select name="filter_author">
											<option value=""><?php _e('Select author', WTBP_LANG_CODE);?></option>
											<?php echo $this->authors_html; ?>
										</select>
										<select name="filter_category">
											<option value=""><?php _e('Select category', WTBP_LANG_CODE);?></option>
											<?php echo $this->categories_html; ?>
										</select>
										<select name="filter_tag">
											<option value=""><?php _e('Select tag', WTBP_LANG_CODE);?></option>
											<?php echo $this->tags_html; ?>
										</select>
										<select name="filter_attribute">
											<option value=""><?php _e('Select attribute', WTBP_LANG_CODE);?></option>
											<?php echo $this->attributes_html; ?>
										</select>
										<div class="wtbpCreateTableFilter">
							                <input type="checkbox" name="filter_attribute_exactly" value="1"> <?php _e('only current attribute', WTBP_LANG_CODE);?>
							            </div>
										<div class="wtbpSearchTableFilter">
                							<input type="checkbox" name="show_variations" value="1"> <?php _e('show variations', WTBP_LANG_CODE);?>
            							</div>
										<div class="wtbpSearchTableFilter">
											<input type="checkbox" name="filter_private" value="1">	<?php _e('show private', WTBP_LANG_CODE);?>
										</div>
									</div>
									<input type="hidden" id="wtbpSearchTableSelectAll" value="0">
									<input type="hidden" id="wtbpSearchTableSelectExclude" value="">
									<table id="wtbpSearchTable" class="wtbpSearchTable">
										<?php echo $this->search_table; ?>
									</table>
								</div>

								<div class="wtbpPropertiesChangeNameWrapp wtbpHidden" title="<?php _e('Column settings', WTBP_LANG_CODE)?>">
									<div class="wtbpOptionContainer">
										<div class="wtbpOptionTitle"><label><?php _e('Title', WTBP_LANG_CODE);?></label></div>
										<div>
											<input type="radio" name="show_display_name" class="wtbpNotOutline" value="0">
											<span class="originalName"></span> <span style="color:#ccc">(<?php _e('default', WTBP_LANG_CODE);?>)</span>
										</div>
										<div>
											<input type="radio" name="show_display_name" class="wtbpNotOutline" value="1">
											<input type="text" name="display_name"/>
										</div>
									</div>
									<div class="wtbpOptionContainer" data-properties="description">
										<label><?php _e('Column width', WTBP_LANG_CODE);?></label>
										<i class="fa fa-question supsystic-tooltip" style="margin-left: 12px;" title="<?php echo esc_html(__('This setting sets the maximum width for the column, but the rest of the table content also affects its width - check how it looks on Preview.', WTBP_LANG_CODE))?>"></i>
											<?php
												echo htmlWtbp::text('width', array('attrs' => 'style="width: 60px; height: 25px;"'));
												echo htmlWtbp::selectbox('width_unit', array(
													'options' => array('px' => 'px', '%' => '%'),
													'attrs' => 'style="width: 60px; vertical-align: unset; height: 25px;"')
												);
											?>
									</div>
									<div class="wtbpOptionContainer">
										<input type="checkbox" name="hide_on_mobile" class="wtbpNotOutline" value="1"> <label><?php _e('Hide on small screen', WTBP_LANG_CODE);?></label>
									</div>
									<div class="wtbpOptionContainer" data-properties="thumbnail">
										<label><?php _e('Responsive mod thumnbnail size', WTBP_LANG_CODE);?></label>
										<?php echo htmlWtbp::text('mobile_thumbnail_size_width', array(
											'placeholder' => '150',
											'attrs' => 'style="width: 60px; height: 25px;"'
										));?>
										x
										<?php echo htmlWtbp::text('mobile_thumbnail_size_height', array(
											'placeholder' => '150',
											'attrs' => 'style="width: 60px; height: 25px;"'
										));?>
									</div>
									<div class="wtbpOptionContainer" data-properties="product_title">
										<input type="checkbox" name="product_title_link" class="wtbpNotOutline wtbpDefaultChecked" value="1"> <label><?php _e('Show product link', WTBP_LANG_CODE);?></label>
									</div>
                                    <div class="wtbpOptionContainer" data-properties="product_title">
                                        <input type="checkbox" name="product_title_link_blank" class="wtbpNotOutline" value="1"> <label><?php _e('Open link on a new window', WTBP_LANG_CODE);?></label>
                                    </div>
									<div class="wtbpOptionContainer" data-properties="description">
										<input type="checkbox" name="cut_description_text" class="wtbpNotOutline wtbpDefaultChecked" value="1"> <label><?php _e('Cut description text', WTBP_LANG_CODE);?></label>
										<?php echo htmlWtbp::text('cut_description_text_size', array(
											'placeholder' => '100',
											'attrs' => 'data-parent="cut_description_text" class="wtbpHideByParent" style="width: 60px; height: 25px;"'
										));?>
									</div>
									<div class="wtbpOptionContainer" data-properties="short_description">
										<input type="checkbox" name="cut_short_description_text" class="wtbpNotOutline" value="1"> <label><?php _e('Cut short description text', WTBP_LANG_CODE);?></label>
										<?php echo htmlWtbp::text('cut_short_description_text_size', array(
											'placeholder' => '100',
											'attrs' => 'data-parent="cut_short_description_text" class="wtbpHideByParent" style="width: 60px; height: 25px;"'
										));?>
									</div>
									<?php if($this->is_pro) {?>
										<div class="wtbpOptionContainer" data-types="link">
											<label><?php _e('Show as', WTBP_LANG_CODE);?></label>
											<?php echo htmlWtbp::selectbox('acf_link_show_as', array(
												'options' => array('link' => __('link', WTBP_LANG_CODE), 'button' => __('button', WTBP_LANG_CODE), 'icon' => __('icon', WTBP_LANG_CODE), 'image' => __('image', WTBP_LANG_CODE)),
												'attrs' => 'style="width: 100px; vertical-align: unset; height: 25px;"')
											);?>
											<div class="wtbpHideByParentBlock">
												<?php echo htmlWtbp::selectFileBtn('acf_image_path', array(
													'type' => 'image',
													'value_attrs' => 'data-parent="acf_link_show_as" data-parent-value="image" class="wtbpHideByParent"',
												))?>
											</div>
										</div>
										<div class="wtbpOptionContainer" data-properties="featured">
											<label><?php _e('Show as', WTBP_LANG_CODE);?></label>
											<?php echo htmlWtbp::selectbox('featured_show_as', array(
												'options' => array('text' => __('text', WTBP_LANG_CODE), 'icon' => __('icon', WTBP_LANG_CODE), 'image' => __('image', WTBP_LANG_CODE)),
												'attrs' => 'style="width: 100px; vertical-align: unset; height: 25px;"')
											);?>
											<div class="wtbpHideByParentBlock">
												<?php echo htmlWtbp::selectFileBtn('featured_image_path', array(
													'type' => 'image',
													'value_attrs' => 'data-parent="featured_show_as" data-parent-value="image" class="wtbpHideByParent"',
												))?>
											</div>
										</div>
									<?php }?>
                                    <div class="wtbpOptionContainer" data-properties="stock">
                                        <input type="checkbox" name="stock_item_counts" id="stock_item_counts" class="wtbpNotOutline" value="1"> <label for="stock_item_counts"><?php _e('Show quantity items in stock', WTBP_LANG_CODE);?></label>
                                    </div>
								</div>

								<div class="wtbpCloneTableWrapp wtbpHidden" title="<?php _e('Clone table', WTBP_LANG_CODE)?>">
									<div class="wtbpOptionContainer">
										<input class="wtbpNotOutline" type="text" name="gggg" style="width:100%;" value="" />
										<div class="wtbpCloneError" style="color: red; display: none; float: left;">
											<p></p>
										</div>
									</div>
								</div>

								<div class="wtbpOptions wtbpOptionsEmpty wtbpHidden">
									<div class="content"></div>
									<div class="wtbpOptionHandlers">
										<div class="wtbpOptionDragHandler"><i class="fa fa-arrows-h"></i></div>
										<div class="wtbpOptionEditHandler"><i class="fa fa-fw fa-pencil"></i></div>
										<div class="wtbpOptionRemoveHandler"><i class="fa fa-fw fa-trash-o"></i></div>
									</div>
								</div>

								<h3 class="wtbpHeaders"><?php _e('Table Content', WTBP_LANG_CODE)?>
									<button id="wtbpAddProducts" class="button active" style="background:#4ae8ea;"><span><?php _e('Add Products', WTBP_LANG_CODE)?></span></button>
								</h3>
								<div id="wtbpSortTableContent" class="wtbpAdminTableWrapp">
									<table id="wtbpContentTable" class="wtbpContentAdmTable" style="width:100%;"></table>
								</div>
							</div>
						</div>
						<div class="row row-tab" id="row-tab-settings">
							<div class="col-xs-12">
								<nav class="tabs-settings">
									<ul class="wtbpSub tabs-wrapper">
										<li>
											<a href="#row-tab-settings-main" class="current button"><i class="fa fa-fw fa-tachometer"></i><?php echo __('Main', WTBP_LANG_CODE); ?></a>
										</li>
										<li>
											<a href="#row-tab-settings-features" class="button"><i class="fa fa-fw fa-cogs"></i><?php echo __('Features', WTBP_LANG_CODE); ?></a>
										</li>
										<li>
											<a href="#row-tab-settings-design" class="button"><i class="fa fa-fw fa-picture-o"></i><?php echo __('Appearance', WTBP_LANG_CODE); ?></a>
										</li>
										<li>
											<a href="#row-tab-settings-text" class="button"><i class="fa fa-fw fa-language"></i><?php echo __('Language and Text', WTBP_LANG_CODE); ?></a>
										</li>
										<li>
											<a href="#row-tab-settings-css" class="button"><i class="fa fa-fw fa-code"></i><?php echo __('CSS', WTBP_LANG_CODE); ?></a>
										</li>
									</ul>
								</nav>
								<section class="row-settings-tabs col-xs-12">
									<section class="row row-settings-tab active" id="row-tab-settings-main">
										<table class="form-settings-table">
											<tbody class="col-md-6">
											<tr class="col-md-12">
												<th class="col-md-12"><?php echo __('Table Elements', WTBP_LANG_CODE)?></th>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Caption', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Check here if you want to show the name of the table above the table.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/caption.png'.'" height="134"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[caption_enable]', array(
														'checked' => (isset($this->settings['settings']['caption_enable']) ? (int) $this->settings['settings']['caption_enable'] : '')
													))?>
												</td>
											</tr>
											<?php
											if(isset($this->settings['settings']['caption_enable'])
												&& (int) $this->settings['settings']['caption_enable'] == 1){
												$wtbpCaptionText = '';
											}else{
												$wtbpCaptionText = 'wtbpHidden';
											}
											?>
											<tr class="col-md-12 <?php echo $wtbpCaptionText?>" id="wtbpCaptionText">
												<td class="col-md-4">
													<?php _e('Caption Text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-7">
													<?php echo htmlWtbp::textarea('settings[caption_text]', array(
														'value' => (isset($this->settings['settings']['caption_text']) ? $this->settings['settings']['caption_text'] : ''),
														'attrs' => 'style="width:100%"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Description', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" data-tooltip-content="" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('You can add short description to the table between title and table.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/description.png'.'" height="122"></div>')?>">
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[description_enable]', array(
														'checked' => (isset($this->settings['settings']['description_enable']) ? (int) $this->settings['settings']['description_enable'] : '')
													))?>
												</td>
											</tr>
											<?php
											if(isset($this->settings['settings']['description_enable'])
												&& (int) $this->settings['settings']['description_enable'] == 1){
												$wtbpDescriptionText = '';
											}else{
												$wtbpDescriptionText = 'wtbpHidden';
											}
											?>
											<tr class="col-md-12 <?php echo $wtbpDescriptionText?>" id="wtbpDescriptionText">
												<td class="col-md-4">
													<?php _e('Description Text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-7">
													<?php echo htmlWtbp::textarea('settings[description_text]', array(
														'value' => (isset($this->settings['settings']['description_text']) ? $this->settings['settings']['description_text'] : ''),
														'attrs' => 'style="width:100%"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Header', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Check here if you want to show the table head.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/header.png'.'" height="100"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[header_show]', array(
														'checked' => (isset($this->settings['settings']['header_show']) ? (int) $this->settings['settings']['header_show'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12<?php echo isset($this->settings['settings']['header_show']) && (int)$this->settings['settings']['header_show'] == 1 ? '' : ' wtbpHidden' ?>" id="wtbpFixedHeader">
												<td class="col-md-4">
													<?php _e('Fixed Header', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allows to fix the table\'s header during table scrolling. Important! Header option must be enabled for using this feature.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[header_fixed]', array(
														'checked' => (isset($this->settings['settings']['header_fixed']) ? (int) $this->settings['settings']['header_fixed'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Footer', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Check here if you want to show the table footer.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/footer.png'.'" height="86"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[footer_show]', array(
														'checked' => (isset($this->settings['settings']['footer_show']) ? (int) $this->settings['settings']['footer_show'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Signature', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('You can add signature under table footer.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/signature.png'.'" height="83"></div>')?>">
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[signature_enable]', array(
														'checked' => (isset($this->settings['settings']['signature_enable']) ? (int) $this->settings['settings']['signature_enable'] : '')
													))?>
												</td>
											</tr>
											<?php
											if(isset($this->settings['settings']['signature_enable'])
												&& (int) $this->settings['settings']['signature_enable'] == 1){
												$wtbpSignatureText = '';
											}else{
												$wtbpSignatureText = 'wtbpHidden';
											}
											?>
											<tr class="col-md-12 <?php echo $wtbpSignatureText?>" id="wtbpSignatureText">
												<td class="col-md-4">
													<?php _e('Signature Text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-7">
													<?php echo htmlWtbp::textarea('settings[signature_text]', array(
														'value' => (isset($this->settings['settings']['signature_text']) ? $this->settings['settings']['signature_text'] : ''),
														'attrs' => 'style="width:100%"'
													))?>
												</td>
											</tr>
											</tbody>

											<tbody class="col-md-6">
											<tr class="col-md-12">
												<th class="col-md-12"><?php echo __('Date Formats', WTBP_LANG_CODE)?></th>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Date', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set output format for date. For example: y-m-d - 1991-12-25, d.m.y - 25.12.1991', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php
														echo htmlWtbp::selectbox('settings[date_formats]', array(
															'options' => array('Y-m-d' => '1991-12-25', 'd.m.Y' => '25.12.1991'),
															'value' => (isset($this->settings['settings']['date_formats']) ? $this->settings['settings']['date_formats'] : 'y-m-d')
														));
													?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Time / Duration', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set output format for time and duration. For example:  1) time - H:m - 18:00 , h:m a - 9:00 pm 2) duration h:m - 36:40, h:m:s - 36:40:12', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php
														echo htmlWtbp::selectbox('settings[time_formats]', array(
															'options' => array('H:i' => '18:00', 'h:i a' => '9:00 pm', 'h:i' => '36:40', 'h:i:s' => '36:40:12'),
															'value' => (isset($this->settings['settings']['time_formats']) ? $this->settings['settings']['time_formats'] : 'H:m')
														));
													?>
												</td>
											</tr>
											</tbody>
										</table>
									</section>
									<section class="row row-settings-tab" id="row-tab-settings-features">
										<table class="form-settings-table">
											<tbody class="col-md-6">
											<tr class="col-md-12">
												<th class="col-md-12"><?php echo __('General', WTBP_LANG_CODE)?></th>
											</tr>
<!--											<tr class="col-md-12">-->
<!--												<td class="col-md-4">-->
<!--													--><?php //_e('Responsive mode', WTBP_LANG_CODE)?>
<!--													<i class="fa fa-question supsystic-tooltip" title="--><?php //echo esc_html(__('Enable responsive mode to fit all container width', WTBP_LANG_CODE))?><!--"></i>-->
<!--												</td>-->
<!--												<td class="col-md-5">-->
<!--													--><?php //echo htmlWtbp::checkbox('settings[responsive_mode]', array(
//														'checked' => (isset($this->settings['settings']['responsive_mode']) ? (int) $this->settings['settings']['responsive_mode'] : 1)
//													))?>
<!--												</td>-->
<!--											</tr>-->
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Table information', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Show pagination information after table.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/table_info.png'.'" height="87"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[table_information]', array(
														'checked' => (isset($this->settings['settings']['table_information']) ? (int) $this->settings['settings']['table_information'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Sorting', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Allow dynamic sorting with arrows. To use this option you must enable Header option <a href="https://woobewoo.com/documentation/sorting-product-table" target="_blank">Read more.</a>',  WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/sorting.png'.'" height="46"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[sorting]', array(
														'checked' => (isset($this->settings['settings']['sorting']) ? (int) $this->settings['settings']['sorting'] : '')
													))?>
												</td>
											</tr>
											<?php
											if(isset($this->settings['settings']['sorting'])
												&& (int) $this->settings['settings']['sorting'] == 1){
												$wtbpSub = '';
											}else{
												$wtbpSub = 'wtbpHidden';
											}
											if(isset($this->settings['settings']['sorting_custom'])
												&& (int) $this->settings['settings']['sorting_custom'] == 1){
												$wtbpSortingCustom = 'disabled';
											}else{
												$wtbpSortingCustom = '';
											}
											?>
											<tr class="col-md-12 sub-settings-row wtbpSortingSub <?php echo $wtbpSub; ?>">
												<td class="col-md-6">
													<?php _e('User custom sorting', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Enable the checkbox if you want to add a sort by drag-n-drop from the admin table preview to the frontend.',  WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[sorting_custom]', array(
														'checked' => (isset($this->settings['settings']['sorting_custom']) ? (int) $this->settings['settings']['sorting_custom'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12 sub-settings-row wtbpSortingSub <?php echo $wtbpSub; ?>">
												<td class="col-md-6">
													<?php _e('Auto sorting default column', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Select the column to sort by default. Works only with relevant columns enabled.',  WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[sorting_default]', array(
														'options' => $sortableColumns,
														'attrs' => $wtbpSortingCustom,
														'value' => (isset($this->settings['settings']['sorting_default']) ? $this->settings['settings']['sorting_default'] : ''),
													))?>
												</td>
											</tr>
											<tr class="col-md-12 sub-settings-row wtbpSortingSub <?php echo $wtbpSub; ?>">
												<td class="col-md-6">
													<?php _e('Auto sorting descending', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Enable the checkbox if you want to sort by descending.',  WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[sorting_desc]', array(
														'checked' => ( isset($this->settings['settings']['sorting_desc']) && empty($this->settings['settings']['sorting_custom']) )  ? (int) $this->settings['settings']['sorting_desc'] : '',
														'attrs' => $wtbpSortingCustom,
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Pagination', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Show table pagination.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/pagination.png'.'" height="74"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[pagination]', array(
														'checked' => (isset($this->settings['settings']['pagination']) ? (int) $this->settings['settings']['pagination'] : '')
													))?>
												</td>
											</tr>
											<?php
											if(isset($this->settings['settings']['pagination'])
												&& (int) $this->settings['settings']['pagination'] == 1){
												$wtbpSub = '';
											}else{
												$wtbpSub = 'wtbpHidden';
											}
											$wtbpPageMenu = (isset($this->settings['settings']['pagination_menu']) && (int) $this->settings['settings']['pagination_menu'] == 1);
											?>
											<tr class="col-md-12 sub-settings-row wtbpPaginationSub <?php echo $wtbpSub; ?>">
												<td class="col-md-6">
													<?php _e('Pagination menu', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Show drop down list to select the number of products on the page.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[pagination_menu]', array(
														'checked' => (isset($this->settings['settings']['pagination_menu']) ? $this->settings['settings']['pagination_menu'] : '')
													))?>
												</td>
											</tr>

											<tr class="col-md-12 sub-settings-row wtbpPaginationSub <?php echo (empty($wtbpSub) && $wtbpPageMenu ? 'wtbpHidden' : $wtbpSub); ?>">
												<td class="col-md-6">
													<?php _e('Products per Page', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Here you can set the number of products to display on one Pagination page.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::text('settings[page_length]', array(
														'value' => (isset($this->settings['settings']['page_length']) ? $this->settings['settings']['page_length'] : '10'),
														'attrs' => 'style="width: 60px"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12 sub-settings-row wtbpPaginationSub <?php echo (empty($wtbpSub) && !$wtbpPageMenu ? 'wtbpHidden' : $wtbpSub); ?>">
												<td class="col-md-6">
													<?php _e('Pagination List Content', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Here you can set the number of rows to display on one Pagination page. Establish several numbers separated by comma to let users choose it personally. First number will be displayed by default. Since that the number of Pagination Pages will be recounted also..', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::text('settings[pagination_menu_content]', array(
														'value' => (isset($this->settings['settings']['pagination_menu_content']) ? $this->settings['settings']['pagination_menu_content'] : '10,20,50,100,All')
													))?>
												</td>
											</tr>
											<?php if($this->is_pro) {
												dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminSSP', array('settings' => $this->settings));
												} else { ?>
												<tr class="col-md-12 sub-settings-row wtbpPaginationSub <?php echo $wtbpSub; ?>">
													<td class="col-md-6">
														<?php _e('Server-side Processing', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This option is recommended for a large tables that cannot be processed in conventional way. The table will be sequentially loaded by ajax on a per page basis, all filtering, ordering and search clauses is server-side implemented too.', WTBP_LANG_CODE))?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=pagination-ssp&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
											<?php } ?>

											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Searching', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Show table searching field.<a href="https://woobewoo.com/documentation/searching-feature-of-product-table" target="_blank">Read more.</a>', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/searching.png'.'" height="91"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[searching]', array(
														'checked' => (isset($this->settings['settings']['searching']) ? (int) $this->settings['settings']['searching'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Search by Columns', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo __('Add search by table columns. Use a semicolon as separator for select any of the values.', WTBP_LANG_CODE)?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[column_searching]', array(
														'checked' => (isset($this->settings['settings']['column_searching']) ? (int) $this->settings['settings']['column_searching'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Print', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Show table print button.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/print.png'.'" height="84"></div>')?>">
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[print]', array(
														'checked' => (isset($this->settings['settings']['print']) ? (int) $this->settings['settings']['print'] : '')
													))?>
												</td>
											</tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-6">
                                                    <?php _e('Print captions', WTBP_LANG_CODE)?>
                                                    <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Print table caption, description and signature.', WTBP_LANG_CODE).'</div></div>')?>">
                                                </td>
                                                <td class="col-md-5">
                                                    <?php echo htmlWtbp::checkbox('settings[print_captions]', array(
                                                        'checked' => (isset($this->settings['settings']['print_captions']) ? (int) $this->settings['settings']['print_captions'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Hide out of stock items', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[hide_out_of_stock]', array(
														'checked' => (isset($this->settings['settings']['hide_out_of_stock']) ? (int) $this->settings['settings']['hide_out_of_stock'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Show private products', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[show_private]', array(
														'checked' => (isset($this->settings['settings']['show_private']) ? (int) $this->settings['settings']['show_private'] : '')
													))?>
												</td>
											</tr>
											<?php if($this->is_pro) {
												dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminFeatures', array('settings' => $this->settings));
												} else { ?>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Show variation thumbnails', WTBP_LANG_CODE)?>
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=multiple-add-products-to-cart&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Multiple add to cart', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Multiple add to cart products. <a href="https://woobewoo.com/documentation/add-to-cart-button-and-variations/" target="_blank">Read more.</a>', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/add_selected_to_cart.png'.'" height="86"></div>')?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=multiple-add-products-to-cart&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Hide view cart link', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Hide view cart link.', WTBP_LANG_CODE))?>"></i>
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=hide-view-cart-link&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
											<?php } ?>

											<?php if($this->is_pro) {
												dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminFilters', array('settings' => $this->settings));
												} else { ?>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Attribute filter', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Attribute filter. Works only with enabled attribute columns. <a href="https://woobewoo.com/documentation/product-attribute-and-category-filters" target="_blank">Read more.</a>', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/filter_attr.png'.'" height="49"></div>')?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=attribute-filter&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Custom taxonomy filter', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Custom taxonomy filter. Works only with enabled custom taxonomy columns. <a href="https://woobewoo.com/documentation/product-attribute-and-category-filters" target="_blank">Read more.</a>', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/filter_attr.png'.'" height="49"></div>')?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=attribute-filter&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Category filter', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Category filter. Works only with enabled category columns.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/filter_cat.png'.'" height="56"></div>')?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=category-filter&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
											<?php } ?>
											</tbody>
											<tbody class="col-md-6 wtbpHidden">
											<tr class="col-md-12">
												<th class="col-md-12"><?php echo __('Export', WTBP_LANG_CODE)?></th>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Frontend Export', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allow export from frontend.', WTBP_LANG_CODE))?>"></i>
													<span class="wtbpPro">
                                                        <a target="_blank" class="supsystic-pro-feature" href="https://supsystic.com/plugins/data-tables-generator-plugin/?utm_source=plugin&utm_medium=export-from-frontend&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a>
                                                    </span>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[frontend_export]', array(
														'checked' => (isset($this->settings['settings']['frontend_export']) ? (int) $this->settings['settings']['frontend_export'] : '')
													))?>
												</td>
											</tr>
											</tbody>
										</table>
									</section>
									<section class="row row-settings-tab" id="row-tab-settings-design">
										<table class="form-settings-table" style="width: 100%">
											<tbody class="col-md-6">
<!--											<tr class="col-md-12">-->
<!--												<td class="col-md-4">-->
<!--													--><?php //_e('Auto Table Width', WTBP_LANG_CODE)?>
<!--													<i class="fa fa-question supsystic-tooltip" title="--><?php //echo esc_html(__('If checked - width of table columns will be calculated automatically for table width 100%', WTBP_LANG_CODE))?><!--"></i>-->
<!--												</td>-->
<!--												<td class="col-md-5">-->
<!--													--><?php //echo htmlWtbp::checkbox('settings[auto_width]', array(
//														'checked' => (isset($this->settings['settings']['auto_width']) ? (int) $this->settings['settings']['auto_width'] : '')
//													))?>
<!--												</td>-->
<!--											</tr>-->
<!--											--><?php
//											if(isset($this->settings['settings']['auto_width'])
//												&& (int) $this->settings['settings']['auto_width'] == 1){
//												$wtbpFixedTableWidthText = 'wtbpVisibilityHidden';
//											}else{
//												$wtbpFixedTableWidthText = '';
//											}
											?>
											<tr class="col-md-12" id="wtbpFixedTableWidthText">
												<td class="col-md-6">
													<?php _e('Fixed table width', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set fixed table width in px or %.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::text('settings[width][fixed_width]', array(
														'value' => (isset($this->settings['settings']['width']['fixed_width']) ? $this->settings['settings']['width']['fixed_width'] : '100'),
														'attrs' => 'style="width: 60px"'
													))?>
													<?php echo htmlWtbp::selectbox('settings[width][width_unit]', array(
														'options' => array('pixels' => 'px', 'percents' => '%'),
														'value' => (isset($this->settings['settings']['width']['width_unit']) ? $this->settings['settings']['width']['width_unit'] : 'percents'),
														'attrs' => 'style="width: 60px"'
													))?>
												</td>
											</tr>
											<!--<tr class="col-md-12">
												<td class="col-md-4">
													<?php //_e('Summary column width', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php //echo esc_html(__('Set width to summary column or leave it empty to default.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php /*echo htmlWtbp::text('settings[width][summary]', array(
														'value' => (isset($this->settings['settings']['width']['summary']) ? $this->settings['settings']['width']['summary'] : ''),
														'attrs' => 'style="width: 60px"'
													))*/?>
													<?php echo esc_html(__('px', WTBP_LANG_CODE))?>
												</td>
											</tr>-->
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Thumbnail size', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Select the image size to display in the frontend', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/thumbnail_size.png'.'" height="86"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php
													$sizesArr = getImageSizes();
													$sizes = array();
													foreach ($sizesArr as $key=>$size){
														$sizes[$key] = (isset($size['name']) ? $size['name'] : $key).(isset($size['width']) ? ' '.$size['width'] . ' x ' . $size['height'] : '');
													}
													?>
													<?php echo htmlWtbp::selectbox('settings[thumbnail_size]', array(
														'options' => $sizes,
														'value' => (isset($this->settings['settings']['thumbnail_size']) ? $this->settings['settings']['thumbnail_size'] : 'thumbnail'),
													))
													?>
												</td>
											</tr>
											<tr class="col-md-12 wtbpSetImageSize <?php echo (isset($this->settings['settings']['thumbnail_size']) && $this->settings['settings']['thumbnail_size'] == 'set_size' ? '' : ' wtbpHidden'); ?>">
												<td class="col-md-6">
													<?php _e('Custom image size', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set width and height values in pixels (in that order).', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::text('settings[thumbnail_width]', array(
														'value' => (isset($this->settings['settings']['thumbnail_width']) ? $this->settings['settings']['thumbnail_width'] : ''),
														'attrs' => 'style="width: 60px"'
													));
													echo ' x ';
													echo htmlWtbp::text('settings[thumbnail_height]', array(
														'value' => (isset($this->settings['settings']['thumbnail_height']) ? $this->settings['settings']['thumbnail_height'] : ''),
														'attrs' => 'style="width: 60px"'
													));?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Mobile screen width', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Select screen width to hide columns.  You can set which columns should be hidden on the Content tab in the column options.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/hide_on_small_screen.png'.'" height="86"></div>')?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[mobile_width]', array(
														'options' => array('320' => '320 px', '480' => '480 px', '600' => '600 px', '768' => '768 px', '1024' => '1024 px'),
														'value' => (isset($this->settings['settings']['mobile_width']) ? $this->settings['settings']['mobile_width'] : '768'),
													))
													?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Responsive Mode', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php
														echo esc_html(__('Standard Responsive mode - in this mode if table content doesn\'t fit all columns become under each other with one cell per row.', WTBP_LANG_CODE).'<br><br>'.
															__('Automatic column hiding - in this mode table columns will collapse from right to left if content does not fit to parent container width.', WTBP_LANG_CODE).'<br><br>'.
															__('Horizontal scroll - in this mode scroll bar will be added if table overflows parent container width.', WTBP_LANG_CODE).'<br><br>'.
															__('Disable Responsivity - default table fluid layout.<a href="https://woobewoo.com/feature/fully-responsive" target="_blank">Read more.</a>', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[responsive_mode]', array(
														'options' => array('responsive' => 'Responsive mode', 'hiding' => 'Automatic column hiding', 'horizontal' => 'Horizontal scroll', 'disable' => 'Disable Responsivity'),
														'value' => (isset($this->settings['settings']['responsive_mode']) ? $this->settings['settings']['responsive_mode'] : 'horizontal'),
													))
													?>
												</td>
											</tr>
											<tr class="col-md-12 wtbpHorizontalPosition sub-settings-row <?php echo !isset($this->settings['settings']['responsive_mode']) || $this->settings['settings']['responsive_mode'] == 'horizontal' ? '' : 'wtbpHidden';?> ">
												<td class="col-md-6">
													<?php _e('Horizontal scrollbar position', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Here you can set horizontal scrollbar position.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[horizontal_scroll]', array(
														'options' => array('footer' => 'Footer', 'header' => 'Header', 'two' => 'Header and Footer'),
														'value' => (isset($this->settings['settings']['horizontal_scroll']) ? $this->settings['settings']['horizontal_scroll'] : 'footer'),
													))
													?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Borders', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Cell - adds border around all four sides of each cell, Row - adds border only over and under each row. (i.e. only for the rows).', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[borders]', array(
														'options' => array('cell' => 'cell', 'rows' => 'rows', 'none' => 'none'),
														'value' => (isset($this->settings['settings']['borders']) ? $this->settings['settings']['borders'] : 'cell'),
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Row Striping', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Add automatic highlight for table odd rows', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[row_striping]', array(
														'checked' => (isset($this->settings['settings']['row_striping']) ? (int) $this->settings['settings']['row_striping'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Highlighting by Mousehover', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Row highlighting by mouse hover.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[highlighting_mousehover]', array(
														'checked' => (isset($this->settings['settings']['highlighting_mousehover']) ? (int) $this->settings['settings']['highlighting_mousehover'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Highlight Sorted Column', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('If checked - the current sorted column will be highlighted', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[highlighting_order_column]', array(
														'checked' => (isset($this->settings['settings']['highlighting_order_column']) ? (int) $this->settings['settings']['highlighting_order_column'] : '')
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-6">
													<?php _e('Hide Table Loader', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Enable / disable table loader icon before table will be completely loaded.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::checkbox('settings[hide_table_loader]', array(
														'checked' => (isset($this->settings['settings']['hide_table_loader']) ? (int) $this->settings['settings']['hide_table_loader'] : '')
													))?>
												</td>
											</tr>
											<?php if($this->is_pro) {
												dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminLoader', array('settings' => $this->settings));
												} else { ?>
												<tr class="col-md-12 sub-settings-row">
													<td class="col-md-6">
														<?php _e('Table Loader Icon', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html('<div class="wtbpTooltipsWrapper"><div class="wtbpTooltipsText">'.__('Choose icon for loader.', WTBP_LANG_CODE).'</div><img src="'.$this->getModule()->getModPath(). 'img/icon_loader.png'.'" height="248"></div>')?>"></i>
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=choose-icon-for-loader&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12 sub-settings-row">
													<td class="col-md-6">
														<?php _e('Table Loader Color', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Choose color for loader', WTBP_LANG_CODE))?>"></i>
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=choose-color-for-loader&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
											<?php } ?>
											</tbody>
											<tbody class="col-md-6">
												<tr class="col-md-12">
													<th class="col-md-12"><?php echo __('Table Styling', WTBP_LANG_CODE)?></th>
												</tr>
												<?php if($this->is_pro) {
													dispatcherWtbp::doAction('addEditAdminSettings', 'partEditAdminCustomStyles', array('settings' => $this->settings));
												} else { ?>
												<tr class="col-md-12">
													<td class="col-md-6">
														<?php _e('Use custom styles', WTBP_LANG_CODE)?>
														<i class="fa fa-question supsystic-tooltip" title="<?php echo __('Choose your custom table styles below. Any settings you leave blank will default to your theme styles.', WTBP_LANG_CODE)?>">
													</td>
													<td class="col-md-5">
														<span class="wtbpPro"><a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=multiple-add-products-to-cart&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a></span>
													</td>
												</tr>
												<tr class="col-md-12">
													<td class="col-md-12" colspan="2">
														<?php echo '<img src="'.$this->getModule()->getModPath().'img/table_styling.png" style="max-width:100%">' ?>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</section>
									<section class="row row-settings-tab" id="row-tab-settings-text">
										<table class="form-settings-table wtbpSettingsLanguage" >
											<tbody class="col-md-6">
											<tr class="col-md-12">
												<th class="col-md-12"><?php echo __('Overwrite Table Text', WTBP_LANG_CODE)?></th>
											</tr>
											<tr class="col-md-12">
													<td class="col-md-4">
														<?php _e('Multiple add selected to cart button text', WTBP_LANG_CODE)?>
													</td>
													<td class="col-md-8">
														<?php echo htmlWtbp::text('settings[selected_to_cart]', array(
															'value' => (isset($this->settings['settings']['selected_to_cart']) ? $this->settings['settings']['selected_to_cart'] : 'Add selected to cart'),
															'attrs' => 'placeholder="Add selected to cart"'
														))?>
													</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Empty table', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[empty_table]', array(
														'value' => (isset($this->settings['settings']['empty_table']) ? $this->settings['settings']['empty_table'] : ''),
														'attrs' => 'placeholder="There\'re no products in the table"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Table info text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[table_info]', array(
														'value' => (isset($this->settings['settings']['table_info']) ? $this->settings['settings']['table_info'] : ''),
														'attrs' => 'placeholder="Showing _START_ to _END_ of _TOTAL_ entries"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Empty info text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[table_info_empty]', array(
														'value' => (isset($this->settings['settings']['table_info_empty']) ? $this->settings['settings']['table_info_empty'] : ''),
														'attrs' => 'placeholder="Showing 0 to 0 of 0 entries"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Filtered info text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[filtered_info_text]', array(
														'value' => (isset($this->settings['settings']['filtered_info_text']) ? $this->settings['settings']['filtered_info_text'] : ''),
														'attrs' => 'placeholder="(filtered from _MAX_ total entries)"'
													))?>
												</td>
											</tr>

											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Length text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[length_text]', array(
														'value' => (isset($this->settings['settings']['length_text']) ? $this->settings['settings']['length_text'] : ''),
														'attrs' => 'placeholder="Show _MENU_ entries"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Search label', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[search_label]', array(
														'value' => (isset($this->settings['settings']['search_label']) ? $this->settings['settings']['search_label'] : ''),
														'attrs' => 'placeholder="Search:"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Zero records', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[zero_records]', array(
														'value' => (isset($this->settings['settings']['zero_records']) ? $this->settings['settings']['zero_records'] : ''),
														'attrs' => 'placeholder="No matching records are found"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Filter text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[filter_text]', array(
														'value' => (isset($this->settings['settings']['filter_text']) ? $this->settings['settings']['filter_text'] : ''),
														'attrs' => 'placeholder="Filter"'
													))?>
												</td>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Reset text', WTBP_LANG_CODE)?>
												</td>
												<td class="col-md-8">
													<?php echo htmlWtbp::text('settings[reset_text]', array(
														'value' => (isset($this->settings['settings']['reset_text']) ? $this->settings['settings']['reset_text'] : ''),
														'attrs' => 'placeholder="Reset"'
													))?>
												</td>
											</tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-4">
                                                    <?php _e('Stock quantity items text', WTBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-8">
                                                    <?php echo htmlWtbp::text('settings[stock_quantity_text]', array(
                                                        'value' => (isset($this->settings['settings']['stock_quantity_text']) ? $this->settings['settings']['stock_quantity_text'] : ''),
                                                        'attrs' => 'placeholder="items"'
                                                    ))?>
                                                </td>
                                            </tr>
											<!--<tr class="col-md-12">
												<td class="col-md-4">
													<?php //_e('Export label', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php //echo esc_html(__('This label can not be translated using Table Language option. You can change this label typing the custom text or hide this label typing _NONE_ as label text.', WTBP_LANG_CODE))?>"></i>
												</td>
												<td class="col-md-8">
													<?php /*echo htmlWtbp::text('settings[export_label]', array(
														'value' => (isset($this->settings['settings']['export_label']) ? $this->settings['settings']['export_label'] : ''),
														'attrs' => 'placeholder="Save as"'
													))*/?>
												</td>
											</tr>-->
											</tbody>
											<tbody class="col-md-6" style="display:none;">
											<tr class="col-md-12" >
												<th class="col-md-12"><?php echo __('Language', WTBP_LANG_CODE)?></th>
											</tr>
											<tr class="col-md-12">
												<td class="col-md-4">
													<?php _e('Table Language', WTBP_LANG_CODE)?>
													<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allows to choose language for the table\'s labels (pagination, search ets.)', WTBP_LANG_CODE))?>"></i>
													<span class="wtbpPro">
                                                            <a target="_blank" class="supsystic-pro-feature" href="https://woobewoo.com/plugins/table-woocommerce-plugin/?utm_source=plugin&utm_medium=choose-language&utm_campaign=woo-product-table"><?php _e('PRO option', WTBP_LANG_CODE)?></a>
													</span>
												</td>
												<td class="col-md-5">
													<?php echo htmlWtbp::selectbox('settings[language]', array(
														'options' => $this->languages,
														'value' => (isset($this->settings['settings']['language']) ? $this->settings['settings']['language'] : 'English'),
														'attrs' => 'class="chosen" style="width: 100%"'
													))?>
												</td>
											</tr>
											</tbody>
										</table>
									</section>
									<section class="row row-settings-tab" id="row-tab-settings-css">
										<table class="form-settings-table wtbpSettingsCss">
											<tbody class="col-md-12">
											<tr class="col-md-12">
												<td class="col-md-12">
													<label><?php echo __('Here you can add custom CSS for the current Table.', WTBP_LANG_CODE)?></label>
													<div style="padding-top:10px">
													<?php
														echo htmlWtbp::textarea('settings[custom_css]',
															array('value' => (isset($this->settings['settings']['custom_css']) ? base64_decode($this->settings['settings']['custom_css']) : '')
															, 'attrs' => 'id="wtbpCssEditor"'))
													?>
													</div>
												</td>
											</tr>
											</tbody>
										</table>
									</section>
								</section>
							</div>


						</div>



						<div class="row row-tab" id="row-tab-preview">
							<div class="col-xs-12" >
								<div id="loadingProgress" class="wtbpHidden wtbpAdminPreviewNotice">
									<p class="description">
										<i class="fa fa-fw fa-spin fa-circle-o-notch"></i>
										<?php _e('Loading your table, please wait...', WTBP_LANG_CODE)?>
									</p>
								</div>
								<div id="loadingEmpty" class="wtbpHidden wtbpAdminPreviewNotice">
									<p class="description">
										<i class="fa fa-fw fa-exclamation-circle"></i>
										<?php _e('Table is empty', WTBP_LANG_CODE)?>
									</p>
								</div>
								<div id="loadingFinished" class="wtbpHidden wtbpAdminPreviewNotice">
									<p class="description">
										<i class="fa fa-fw fa-exclamation-circle"></i>
										<?php _e('Note that the table may look a little different depending on your theme style.', WTBP_LANG_CODE)?>
									</p>
								</div>
								<div id="wtbp-table-wrapper-1" class="wtbpTableWrapper" data-table-id="wtbpPreviewTable">
									<table id="wtbpPreviewTable" class="wtbpContentTable" data-table-id="<?php echo $this->table['id'];?>"></table>
									<div id="wtbpPreviewFilter"></div>
									<div class="wtbpCustomCssWrapper" style="display: none;"></div>
								</div>
							</div>
						</div>

						<?php echo htmlWtbp::hidden( 'mod', array( 'value' => 'wootablepress' ) ) ?>
						<?php echo htmlWtbp::hidden( 'action', array( 'value' => 'save' ) ) ?>
						<?php echo htmlWtbp::hidden( 'id', array( 'value' => $this->table['id'] ) ) ?>
					</form>
					<div style="clear: both;"></div>
				</div>
			</div>
		</section>
		<!--	<div class="s-notify" style="position: fixed; right: 1.7em; top: 3.3em; padding: 1em; background-color: white; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 6px 0px;">-->
		<!--		<i class="fa fa-check"></i>-->
		<!--		<div class="notify-content" style="display: inline-block;">-->
		<!--			<span>Saved</span>-->
		<!--		</div>-->
		<!--	</div>-->
	</div>

<?php
function getImageSizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
			);
		}
	}
	$sizes['full'] = array('name' => __('full size', WTBP_LANG_CODE));
	$sizes['set_size'] = array('name' => __('set size', WTBP_LANG_CODE));

	return $sizes;
}

?>
