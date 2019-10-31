<?php
function ghazale_sds_register_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init','ghazale_sds_register_session');
/**
 * message session
 */
function ghazale_sds_message(){
    if(isset($_SESSION["sds-message"])){
        $output = "<div id = \"message\" class = \"updated\" >";
        $output .= $_SESSION["sds-message"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["sds-message"]=null;
        return $output;
    }
    if(isset($_SESSION["sds-message-error"])){
        $output = "<div style='background-color: #e14d43; color: #fff;border-left: 5px solid #ff0000; padding-left: 10px'>";
        $output .= $_SESSION["sds-message"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["sds-message-error"]=null;
        return $output;
    }

}

function ghazale_sds_update(){
    if(isset($_SESSION["sds-update"])){
        $output = "<div id = \"message\" class = \"updated\" >";
        $output .= $_SESSION["sds-update"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["sds-update"]=null;
        return $output;
    }

}