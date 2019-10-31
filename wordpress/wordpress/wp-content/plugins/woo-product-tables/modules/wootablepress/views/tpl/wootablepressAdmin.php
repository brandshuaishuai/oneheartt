<section>
    <div class="supsystic-item supsystic-panel">
        <div id="containerWrapper">
            <ul id="wtbpTableTblNavBtnsShell" class="supsystic-bar-controls">
                <li title="<?php _e('Delete selected', WTBP_LANG_CODE)?>">
                    <button class="button" id="wtbpTableRemoveGroupBtn" disabled data-toolbar-button>
                        <i class="fa fa-fw fa-trash-o"></i>
						<?php _e('Delete selected', WTBP_LANG_CODE)?>
                    </button>
                </li>
                <li title="<?php _e('Search', WTBP_LANG_CODE)?>">
                    <input id="wtbpTableTblSearchTxt" type="text" name="tbl_search" placeholder="<?php _e('Search', WTBP_LANG_CODE)?>">
                </li>
            </ul>
            <div id="wtbpTableTblNavShell" class="supsystic-tbl-pagination-shell"></div>
            <div style="clear: both;"></div>
            <hr />
            <table id="wtbpTableTbl"></table>
            <div id="wtbpTableTblNav"></div>
            <div id="wtbpTableTblEmptyMsg" style="display: none;">
                <h3><?php printf(__('You have no Tables for now. <a href="%s" style="font-style: italic;">Create</a> your Table!', WTBP_LANG_CODE), $this->addNewLink)?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div id="prewiew" style="margin-top: 30px"></div>
    </div>
</section>
