<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_woo_TITLE; ?></h2>
	<h3>Widget setting</h3>
    <?php
	$woo_title = get_option('woo_title');
	$woo_pause = get_option('woo_pause');
	$woo_transduration = get_option('woo_transduration');
	$woo_random = get_option('woo_random');
	$woo_type = get_option('woo_type');
	
	if (isset($_POST['woo_form_submit']) && $_POST['woo_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('woo_form_setting');
			
		$woo_title = stripslashes($_POST['woo_title']);
		$woo_pause = stripslashes($_POST['woo_pause']);
		$woo_transduration = stripslashes($_POST['woo_transduration']);
		$woo_random = stripslashes($_POST['woo_random']);
		$woo_type = stripslashes($_POST['woo_type']);
		
		update_option('woo_title', $woo_title );
		update_option('woo_pause', $woo_pause );
		update_option('woo_transduration', $woo_transduration );
		update_option('woo_random', $woo_random );
		update_option('woo_type', $woo_type );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/pages/setting.js"></script>
    <form name="woo_form" method="post" action="">
      
		<label for="tag-title">Enter widget title</label>
		<input name="woo_title" id="woo_title" type="text" value="<?php echo $woo_title; ?>" maxlength="250" size="50" />
		<p>Enter Widget title, Only for widget.</p>
		
		<label for="tag-width">Pause</label>
		<input name="woo_pause" id="woo_pause" type="text" value="<?php echo $woo_pause; ?>" maxlength="5" />
		<p>Pause between transition change in millisec. (Example: 2000)</p>
		
		<label for="tag-height">Transduration</label>
		<input name="woo_transduration" id="woo_transduration" type="text" value="<?php echo $woo_transduration; ?>" maxlength="4" />
		<p>Please enter duration of transition, affects only IE users. (Example: 1000)</p>
		
		<label for="tag-title">Random</label>
		<select name="woo_random" id="woo_random">
			<option value='YES' <?php if($woo_random == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($woo_random == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p>Please select random display option.</p>
		
		<label for="tag-select-gallery-group">Select gallery type</label>
		  <select name="woo_type" id="woo_type">
			<option value=''>Select</option>
			<?php
			$sSql = "SELECT distinct(woo_type) as woo_type FROM `".WP_woo_TABLE."` order by woo_type";
			$myDistinctData = array();
			$arrDistinctDatas = array();
			$thisselected = "";
			$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
			$i = 1;
			foreach ($myDistinctData as $DistinctData)
			{				
				if(strtoupper($woo_type) == strtoupper($DistinctData["woo_type"])) 
				{ 
					$thisselected = "selected='selected'" ; 
				}
				?><option value='<?php echo strtoupper($DistinctData["woo_type"]); ?>' <?php echo $thisselected; ?>><?php echo strtoupper($DistinctData["woo_type"]); ?></option><?php
				$thisselected = "";
			}
			?>
		  </select>
		  <p>This is to group the images. Select your slideshow group. </p>
		 
		<input type="hidden" name="woo_form_submit" value="yes"/>
		<input name="woo_submit" id="woo_submit" class="button" value="Submit" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="woo_redirect()" value="Cancel" type="button" />
		<input name="Help" lang="publish" class="button" onclick="woo_help()" value="Help" type="button" />
		<?php wp_nonce_field('woo_form_setting'); ?>
    </form>
  </div>
  <br /><p class="description"><?php echo WP_woo_LINK; ?></p>
</div>
