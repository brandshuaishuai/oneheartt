<div class="wrap">
    <div class="supsystic-plugin">
        <?php /*?><header class="supsystic-plugin">
            <h1><?php echo WTBP_WP_PLUGIN_NAME?></h1>
        </header><?php */?>
		<?php echo $this->breadcrumbs?>
        <section class="supsystic-content">
            <nav class="supsystic-navigation supsystic-sticky <?php dispatcherWtbp::doAction('adminMainNavClassAdd')?>">
                <ul>
					<?php foreach($this->tabs as $tabKey => $tab) { ?>
						<?php if(isset($tab['hidden']) && $tab['hidden']) continue;?>
						<li class="supsystic-tab-<?php echo $tabKey;?> <?php echo (($this->activeTab == $tabKey || in_array($tabKey, $this->activeParentTabs)) ? 'active' : '')?>">
							<a href="<?php echo $tab['url']?>" title="<?php echo $tab['label']?>">
								<?php if(isset($tab['fa_icon'])) { ?>
									<i class="fa <?php echo $tab['fa_icon']?>"></i>
								<?php } elseif(isset($tab['wp_icon'])) { ?>
									<i class="dashicons-before <?php echo $tab['wp_icon']?>"></i>
								<?php } elseif(isset($tab['icon'])) { ?>
									<i class="<?php echo $tab['icon']?>"></i>
								<?php }?>
								<span class="sup-tab-label"><?php echo $tab['label']?></span>
							</a>
						</li>
					<?php }?>
                </ul>
            </nav>
            <div class="supsystic-container supsystic-<?php echo $this->activeTab?>">
				<?php echo $this->content?>
                <div class="clear"></div>
            </div>
        </section>
    </div>
</div>
<!--Option available in PRO version Wnd-->
<div id="wtbpOpt" style="display: none;" title="qwe">

</div>

<div id="wtbpAddDialog" style="display: none; vertical-align: top; padding: 10px 20px" title="<?php _e('Create new table', WTBP_LANG_CODE)?>">
	<div style="padding-bottom:10px">
		<label><?php _e('Enter product table name', WTBP_LANG_CODE)?></label>
		<input id="addDialog_title" class="supsystic-text" type="text" style="width:300px;"/>
		<label><?php _e(' and select Products to add:', WTBP_LANG_CODE)?></label>
		<div id="wtbpCreateTableFilters">
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
			<div class="wtbpCreateTableFilter">
                <input type="checkbox" name="show_variations" value="1"> <?php _e('show variations', WTBP_LANG_CODE);?>
            </div>
			<div class="wtbpCreateTableFilter">
				<input type="checkbox" name="filter_private" value="1"> <?php _e('show private', WTBP_LANG_CODE);?>
			</div>
		</div>
	</div>
	<div class="wtbpAdminTableWrapp">
		<input type="hidden" id="wtbpCreateTableSelectAll" value="0">
		<input type="hidden" id="wtbpCreateTableSelectExclude" value="">
		<table id="wtbpCreateTable" class="wtbpSearchTable">
			<?php echo $this->search_table; ?>
		</table>
	</div>

	<div id="formError" style="color: red; display: none; float: left;">
		<p></p>
	</div>
	<!-- /#formError -->
</div>
<!-- /#addDialog -->
