<?php

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. 
require_once plugin_dir_path( __FILE__ ). 'views/database-operations-admin-display.php';
-->
<?php 
include 'database-operations-init-admin-display.php';
include 'database-operations-form-admin-display.php';
//include 'database-operations-submission-admin-display.php';
?>
<div class="ms-panel">
	<div class="ms-panel-div">
        <div id="ct_ms_content" name="ct_ms_content"><?php echo $res; ?></div>
        <?php echo '<h4>Display preview below with shortcode [database_operations id='.
        //get_post_meta(get_the_ID, "post_ID", true );
         get_the_ID().']</h4>
		</br>
	<h4>	please donate www.antechncom.wordpress.com 💙</h4></br>
         ';
        //get_post_custom_values('tb1', get_the_ID())
        //get_text_value(get_the_ID(), 'mm', '') ?>
<?php echo get_text_value(get_the_ID(), 'ct_ms_content', '') ?>
    </div>        
</div>
<div id="database-operations-meta-box-nonce" class="hidden">
  <?php wp_nonce_field( 'database_operations_save', 'database_operations_nonce' ); ?>
</div>