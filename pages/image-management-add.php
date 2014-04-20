<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$woo_errors = array();
$woo_success = '';
$woo_error_found = FALSE;

// Preset the form fields
$form = array(
	'woo_path' => '',
	'woo_link' => '',
	'woo_target' => '',
	'woo_title' => '',
	'woo_order' => '',
	'woo_status' => '',
	'woo_type' => ''
);

// Form submitted, check the data
if (isset($_POST['woo_form_submit']) && $_POST['woo_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('woo_form_add');
	
	$form['woo_path'] = isset($_POST['woo_path']) ? $_POST['woo_path'] : '';
	if ($form['woo_path'] == '')
	{
		$woo_errors[] = __('Please enter the image path.', 'woo-transition');
		$woo_error_found = TRUE;
	}

	$form['woo_link'] = isset($_POST['woo_link']) ? $_POST['woo_link'] : '';
	if ($form['woo_link'] == '')
	{
		$woo_errors[] = __('Please enter the target link.', 'woo-transition');
		$woo_error_found = TRUE;
	}
	
	$form['woo_target'] = isset($_POST['woo_target']) ? $_POST['woo_target'] : '';
	$form['woo_title'] = isset($_POST['woo_title']) ? $_POST['woo_title'] : '';
	$form['woo_order'] = isset($_POST['woo_order']) ? $_POST['woo_order'] : '';
	$form['woo_status'] = isset($_POST['woo_status']) ? $_POST['woo_status'] : '';
	$form['woo_type'] = isset($_POST['woo_type']) ? $_POST['woo_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($woo_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_woo_TABLE."`
			(`woo_path`, `woo_link`, `woo_target`, `woo_title`, `woo_order`, `woo_status`, `woo_type`)
			VALUES(%s, %s, %s, %s, %d, %s, %s)",
			array($form['woo_path'], $form['woo_link'], $form['woo_target'], $form['woo_title'], $form['woo_order'], $form['woo_status'], $form['woo_type'])
		);
		$wpdb->query($sql);
		
		$woo_success = __('New image details was successfully added.', 'woo-transition');
		
		// Reset the form fields
		$form = array(
			'woo_path' => '',
			'woo_link' => '',
			'woo_target' => '',
			'woo_title' => '',
			'woo_order' => '',
			'woo_status' => '',
			'woo_type' => ''
		);
	}
}

if ($woo_error_found == TRUE && isset($woo_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $woo_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($woo_error_found == FALSE && strlen($woo_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $woo_success; ?> <a href="<?php echo WP_woo_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'woo-transition'); ?></a></strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo WP_woo_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Woo superb slideshow', 'woo-transition'); ?></h2>
	<form name="form_woo" method="post" action="#" onsubmit="return woo_submit()"  >
      <h3><?php _e('Add new image details', 'woo-transition'); ?></h3>
      <label for="tag-image"><?php _e('Enter image path', 'woo-transition'); ?></label>
      <input name="woo_path" type="text" id="woo_path" value="" size="125" />
      <p><?php _e('Where is the picture located on the internet', 'woo-transition'); ?> 
	  (ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg)</p>
      <label for="tag-link"><?php _e('Enter target link', 'woo-transition'); ?></label>
      <input name="woo_link" type="text" id="woo_link" value="#" size="125" />
      <p><?php _e('When someone clicks on the picture, where do you want to send them', 'woo-transition'); ?></p>
      <label for="tag-target"><?php _e('Enter target option', 'woo-transition'); ?></label>
      <select name="woo_target" id="woo_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p><?php _e('Do you want to open link in new window?', 'woo-transition'); ?></p>
      <label for="tag-title"><?php _e('Enter image title', 'woo-transition'); ?></label>
      <input name="woo_title" type="text" id="woo_title" value="" size="125" />
      <p><?php _e('Enter image title. This is only for reference.', 'woo-transition'); ?></p>
      <label for="tag-select-gallery-group"><?php _e('Select gallery type', 'woo-transition'); ?></label>
      <select name="woo_type" id="woo_type">
		<option value=''>Select</option>
		<?php
		$sSql = "SELECT distinct(woo_type) as woo_type FROM `".WP_woo_TABLE."` order by woo_type";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 1;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["woo_type"] = strtoupper($DistinctData['woo_type']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+10; $j++)
		{
			$arrDistinctData[$j]["woo_type"] = "GROUP" . $j;
		}
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo strtoupper($arrDistinct["woo_type"]); ?>'><?php echo strtoupper($arrDistinct["woo_type"]); ?></option><?php
		}
		?>
		</select>
      <p><?php _e('This is to group the images. Select your slideshow group.', 'woo-transition'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'woo-transition'); ?></label>
      <select name="woo_status" id="woo_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p><?php _e('Do you want the picture to show in your galler?', 'woo-transition'); ?></p>
      <label for="tag-display-order"><?php _e('Display order', 'woo-transition'); ?></label>
      <input name="woo_order" type="text" id="woo_order" size="10" value="1" maxlength="3" />
      <p><?php _e('What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.', 'woo-transition'); ?></p>
      <input name="woo_id" id="woo_id" type="hidden" value="">
      <input type="hidden" name="woo_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Insert Details', 'woo-transition'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="woo_redirect()" value="<?php _e('Cancel', 'woo-transition'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="woo_help()" value="<?php _e('Help', 'woo-transition'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('woo_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'woo-transition'); ?>
	<a target="_blank" href="<?php echo WP_woo_FAV; ?>"><?php _e('click here', 'woo-transition'); ?></a>
</p>
</div>