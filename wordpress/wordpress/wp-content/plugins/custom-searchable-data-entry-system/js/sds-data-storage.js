/**
 * organizing admin page elements
 */
jQuery(document).ready(function($){

   $(".field_ext").hide();
    $(".file_upload_guide").hide();

    $(".ghazale_sds_field_type").change(function(){
        var select = $(this).find("option:selected").text();
        switch (select){
            case"Drop Down":
                $(".field_ext").slideDown();
                $(".file_upload_guide").slideUp();
                break;
            case "Multiple Choice":
                $(".field_ext").slideDown();
                $(".file_upload_guide").slideUp();
                break;
            case "File Upload":
                $(".file_upload_guide").slideDown().html("File Upload is intended for image uploads only. <i>Supported formats are: png, jpg, jpeg, gif, bmp</i><br> If you wish to show 'Links', use URL field type instead.");
                break;
            default:
                $(".file_upload_guide").slideUp();
                $(".field_ext").slideUp();
                break;

        }
        $(".field_ext").closest("div").find("input[type=text]").val("");

    });
    if($(".ghazale_sds_field_type").find("option:selected").text() == "Drop Down" || $(".ghazale_sds_field_type").find("option:selected").text() == "Multiple Choice" ){
        $(".field_ext").show();
    }

    if($(".ghazale_sds_field_type").find("option:selected").text() == "File Upload"){
        $(".file_upload_guide").show();
    }

});