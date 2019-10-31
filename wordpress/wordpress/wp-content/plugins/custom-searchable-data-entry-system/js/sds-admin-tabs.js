/**
 * tabsin admin panel
 */
jQuery(document).ready(function($) {
    $("#form_tabs").tabs();
        $("input[class^=sds_download_table_csv_]").click(function(){
            //alert("clicked");
            $(".sds_update_link").detach();
            $(".sds_del_link").detach();
            var currentTable = $('#'+$(this).attr('class'));
            currentTable.tableExport({type:'csv',escape:'false',tableName:'yourTableName'});
            $(".sds_refresh_page").html(sds_object.refresh);
        });

});