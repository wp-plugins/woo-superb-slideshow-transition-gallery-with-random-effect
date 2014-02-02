<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Woo superb slideshow', 'woo-transition'); ?></h2>
	<h3><?php _e('Widget Setting', 'woo-transition'); ?></h3>
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
			<p><strong><?php _e('Details successfully updated.', 'woo-transition'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_woo_PLUGIN_URL; ?>/pages/setting.js"></script>
    <form name="woo_form" method="post" action="">
      
		<label for="tag-title"><?php _e('Enter widget title', 'woo-transition'); ?></label>
		<input name="woo_title" id="woo_title" type="text" value="<?php echo $woo_title; ?>" maxlength="250" size="50" />
		<p><?php _e('Enter Widget title, Only for widget.', 'woo-transition'); ?></p>
		
		<label for="tag-width"><?php _e('Pause', 'woo-transition'); ?></label>
		<input name="woo_pause" id="woo_pause" type="text" value="<?php echo $woo_pause; ?>" maxlength="5" />
		<p><?php _e('Pause between transition change in millisec.', 'woo-transition'); ?> (Example: 2000)</p>
		
		<label for="tag-height"><?php _e('Transduration', 'woo-transition'); ?></label>
		<input name="woo_transduration" id="woo_transduration" type="text" value="<?php echo $woo_transduration; ?>" maxlength="4" />
		<p><?php _e('Please enter duration of transition, affects only IE users.', 'woo-transition'); ?> (Example: 1000)</p>
		
		<label for="tag-title"><?php _e('Random', 'woo-transition'); ?></label>
		<select name="woo_random" id="woo_random">
			<option value='YES' <?php if($woo_random == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($woo_random == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p><?php _e('Please select random display option.', 'woo-transition'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Select gallery type', 'woo-transition'); ?></label>
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
		  <p><?php _e('This is to group the images. Select your slideshow group.', 'woo-transition'); ?></p>
		 
		<input type="hidden" name="woo_form_submit" value="yes"/>
		<input name="woo_submit" id="woo_submit" class="button" value="<?php _e('Submit', 'woo-transition'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="woo_redirect()" value="<?php _e('Cancel', 'woo-transition'); ?>" type="button" />
		<input name="Help" lang="publish" class="button" onclick="woo_help()" value="<?php _e('Help', 'woo-transition'); ?>" type="button" />
		<?php wp_nonce_field('woo_form_setting'); ?>
    </form>
  </div>
  <br />
<p class="description">
	<?php _e('Check official website for more information', 'woo-transition'); ?>
	<a target="_blank" href="<?php echo WP_woo_FAV; ?>"><?php _e('click here', 'woo-transition'); ?></a>
</p>
</div>