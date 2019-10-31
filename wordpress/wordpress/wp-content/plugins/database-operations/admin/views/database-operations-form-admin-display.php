
	
<?php
	$db_op_first_tb = db_op_retrieve_dbs();
	$db_op_second_tb = db_op_retrieve_dbs();
	$db_op_query_op = array( '','UNION');
	 ?>
 <div class="wrap">
	<h3> Select at least one table </h3>
      <form method="post" action="<?php echo get_permalink(); ?>">

     <table class="form-table">
           <tr valign="top">
         <th scope="row"><?php _e( 'Current Database', 'db_op_plugin' ) ?></th>
			<td><h4><?php
            $site_title = get_bloginfo('name');
            echo esc_attr( $site_title ); ?> </h4></td>
			</tr>
			<tr valign="top">
            <th scope="row"><?php _e( 'Select first database table', 'db_op_plugin' ) ?></th>
			<td>
			<select name="tb1" class="tb1" id="tb1">
		<option value="" > None </option>
			<?php
			 foreach ($db_op_first_tb as $mytable)
				{
					foreach ($mytable as $t) 
					{   ?>
						  <option value="<?php echo esc_attr( $t); ?>" > <?php echo esc_attr( $t ); ?> </option>
			<?php  }
				}
			?>
	
<script type="text/javascript">
  document.getElementById('tb1').value = "<?php 
$post_val = get_post_meta(get_the_ID(), 'tb1');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  
  ?>";
</script>
			</select>
			</td>
            </tr><tr>
			<th scope="row"><?php _e( 'Select second database table', 'db_op_plugin' ) ?></th>
			<td>
			<select name="tb2" class="tb2" id="tb2" >
		<option value="">None</option>

			<?php
			 foreach ($db_op_second_tb as $mytable)
				{
					foreach ($mytable as $t) 
					{  ?><option value="<?php echo esc_attr($t); ?>"><?php echo esc_attr($t); ?></option>
			<?php  }
				}
			?>
<script type="text/javascript">
  document.getElementById('tb2').value = "<?php 
$post_val = get_post_meta(get_the_ID(), 'tb2');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  
  ?>";
</script>
			</select>
			
			</td>
			</tr>
			<tr valign="top">
            <th scope="row"><?php _e( 'Select database query option', 'db_op_plugin' ) ?></th>
			<td>
			<select name="qryop" class="qryop" id="qryop">
			<?php
			 foreach ($db_op_query_op as $mytable)
				{
					?>
						  <option value="<?php echo  $mytable; ?>" > <?php echo esc_attr( $mytable ); ?> </option>
				<?php	
				}
			?>
<script type="text/javascript">
  document.getElementById('qryop').value = "<?php 
$post_val = get_post_meta(get_the_ID(), 'qryop');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  ?>";
</script>
			</select
			</td>
			</tr>
			 
            <tr valign="bottom">
			<td  colspan="2" style="align:right;">
			
				
			</td>
		</tr>
      </table>
</div>
<label class="switch">
    <input type="checkbox" name="charts" id="charts">
<script type="text/javascript">
  document.getElementById('charts').checked = "<?php 
$post_val = get_post_meta(get_the_ID(), 'charts');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  
  ?>";
</script>
  <span class="slider round"></span> Charts
  <br/><br/> <h4>To use this chart, use just one table with two columns representing the vertical and horizontal axis.</h4>
</label>
			<div class="pwpc-form-row">
				<label class="pwpc-form-label" for="pwpc_types"><h4><?php _e( "Please choose the type here", PWPC_CHARTS_TEXT_DOMAIN );?></h4></label>
				<select class="pwpc-form-control" id="pwpc_types" name="pwpc_types">
					<option value="piechart"><?php _e( "Pie Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="polarchart"><?php _e( "Polar Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="doughnutchart"><?php _e( "Doughnut Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="linechart"><?php _e( "Line Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="barchart"><?php _e( "Bar Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="radarchart"><?php _e( "Radar Chart", PWPC_CHARTS_TEXT_DOMAIN );?></option>
				</select>
<script type="text/javascript">
  document.getElementById('pwpc_types').value = "<?php 
$post_val = get_post_meta(get_the_ID(), 'pwpc_types');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  
  ?>";
</script>
			</div>
			
			<div class="pwpc-form-row">
				<label class="pwpc-form-label" for="pwpc_legend"><h4><?php _e( "Display Legend?", PWPC_CHARTS_TEXT_DOMAIN );?></h4></label>
				<select class="pwpc-form-control" id="pwpc_legend" name="pwpc_legend">
					<option value="false"><?php _e( "False", PWPC_CHARTS_TEXT_DOMAIN );?></option>
					<option value="true"><?php _e( "True", PWPC_CHARTS_TEXT_DOMAIN );?></option>
				</select>
<script type="text/javascript">
  document.getElementById('pwpc_legend').value = "<?php 
$post_val = get_post_meta(get_the_ID(), 'pwpc_legend');
            
            foreach($post_val as $k => $v){
                
                echo $v;
            
            }
  ?>";
</script>
			</div>
 </form>
	 
 </div>