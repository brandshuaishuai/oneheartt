<div class="supsystic-bar" style="display: inline-block;">
    <div id="wtbpComparisonTitleLabel" style="display: inline;">
        <?php echo htmlWtbp::text('title', array(
            'value' => (isset($this->slider['title']) ? $this->slider['title'] : ''),
            'attrs' => 'style="float: left; width:200px;"',
            'required' => true,
        ))?>
    </div>
    <button class="button button-primary wtbpComparisonSaveBtn" style="margin-left: 10px;">
        <i class="fa fa-check"></i>
        <?php _e('Save', WTBP_LANG_CODE)?>
    </button>
</div>

