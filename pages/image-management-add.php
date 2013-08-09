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
		$woo_errors[] = __('Please enter the image path.', WP_woo_UNIQUE_NAME);
		$woo_error_found = TRUE;
	}

	$form['woo_link'] = isset($_POST['woo_link']) ? $_POST['woo_link'] : '';
	if ($form['woo_link'] == '')
	{
		$woo_errors[] = __('Please enter the target link.', WP_woo_UNIQUE_NAME);
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
		
		$woo_success = __('New image details was successfully added.', WP_woo_UNIQUE_NAME);
		
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
if ($ltw_tes_error_found == FALSE && strlen($woo_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $woo_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=woo-superb-slideshow">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_woo_TITLE; ?></h2>
	<form name="form_woo" method="post" action="#" onsubmit="return woo_submit()"  >
      <h3>Add new image details</h3>
      <label for="tag-image">Enter image path</label>
      <input name="woo_path" type="text" id="woo_path" value="" size="125" />
      <p>Where is the picture located on the internet</p>
      <label for="tag-link">Enter target link</label>
      <input name="woo_link" type="text" id="woo_link" value="" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="woo_target" id="woo_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image title</label>
      <input name="woo_title" type="text" id="woo_title" value="" size="125" />
      <p>Enter image title. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
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
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="woo_status" id="woo_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="woo_order" type="text" id="woo_order" size="10" value="" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="woo_id" id="woo_id" type="hidden" value="">
      <input type="hidden" name="woo_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="Insert Details" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="woo_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button" onclick="woo_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('woo_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_woo_LINK; ?></p>
</div>