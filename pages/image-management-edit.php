<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_woo_TABLE."
	WHERE `woo_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'woo-transition'); ?></strong></p></div><?php
}
else
{
	$woo_errors = array();
	$woo_success = '';
	$woo_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_woo_TABLE."`
		WHERE `woo_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'woo_path' => $data['woo_path'],
		'woo_link' => $data['woo_link'],
		'woo_target' => $data['woo_target'],
		'woo_title' => $data['woo_title'],
		'woo_order' => $data['woo_order'],
		'woo_status' => $data['woo_status'],
		'woo_type' => $data['woo_type']
	);
}
// Form submitted, check the data
if (isset($_POST['woo_form_submit']) && $_POST['woo_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('woo_form_edit');
	
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
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_woo_TABLE."`
				SET `woo_path` = %s,
				`woo_link` = %s,
				`woo_target` = %s,
				`woo_title` = %s,
				`woo_order` = %d,
				`woo_status` = %s,
				`woo_type` = %s
				WHERE woo_id = %d
				LIMIT 1",
				array($form['woo_path'], $form['woo_link'], $form['woo_target'], $form['woo_title'], $form['woo_order'], $form['woo_status'], $form['woo_type'], $did)
			);
		$wpdb->query($sSql);	
		$woo_success = __('Image details was successfully updated.', 'woo-transition');
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
      <h3><?php _e('Update image details', 'woo-transition'); ?></h3>
      <label for="tag-image"><?php _e('Enter image path', 'woo-transition'); ?></label>
      <input name="woo_path" type="text" id="woo_path" value="<?php echo $form['woo_path']; ?>" size="125" />
      <p><?php _e('Where is the picture located on the internet', 'woo-transition'); ?></p>
      <label for="tag-link"><?php _e('Enter target link', 'woo-transition'); ?></label>
      <input name="woo_link" type="text" id="woo_link" value="<?php echo $form['woo_link']; ?>" size="125" />
      <p><?php _e('When someone clicks on the picture, where do you want to send them', 'woo-transition'); ?></p>
      <label for="tag-target"><?php _e('Enter target option', 'woo-transition'); ?></label>
      <select name="woo_target" id="woo_target">
        <option value='_blank' <?php if($form['woo_target']=='_blank') { echo 'selected' ; } ?>>_blank</option>
        <option value='_parent' <?php if($form['woo_target']=='_parent') { echo 'selected' ; } ?>>_parent</option>
        <option value='_self' <?php if($form['woo_target']=='_self') { echo 'selected' ; } ?>>_self</option>
        <option value='_new' <?php if($form['woo_target']=='_new') { echo 'selected' ; } ?>>_new</option>
      </select>
      <p><?php _e('Do you want to open link in new window?', 'woo-transition'); ?></p>
      <label for="tag-title"><?php _e('Enter image title', 'woo-transition'); ?></label>
      <input name="woo_title" type="text" id="woo_title" value="<?php echo $form['woo_title']; ?>" size="125" />
      <p><?php _e('Enter image title. This is only for reference.', 'woo-transition'); ?></p>
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
			if(strtoupper($form['woo_type']) == strtoupper($arrDistinct["woo_type"])) 
			{ 
				$thisselected = "selected='selected'" ; 
			}
			?><option value='<?php echo strtoupper($arrDistinct["woo_type"]); ?>' <?php echo $thisselected; ?>><?php echo strtoupper($arrDistinct["woo_type"]); ?></option><?php
			$thisselected = "";
		}
		?>
		</select>
      <p><?php _e('This is to group the images. Select your slideshow group.', 'woo-transition'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'woo-transition'); ?></label>
      <select name="woo_status" id="woo_status">
        <option value='YES' <?php if($form['woo_status']=='YES') { echo 'selected' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['woo_status']=='NO') { echo 'selected' ; } ?>>No</option>
      </select>
      <p><?php _e('Do you want the picture to show in your galler?', 'woo-transition'); ?></p>
      <label for="tag-display-order"><?php _e('Display order', 'woo-transition'); ?></label>
      <input name="woo_order" type="text" id="woo_order" size="10" value="<?php echo $form['woo_order']; ?>" maxlength="3" />
      <p><?php _e('What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.', 'woo-transition'); ?></p>
      <input name="woo_id" id="woo_id" type="hidden" value="">
      <input type="hidden" name="woo_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Update Details', 'woo-transition'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="woo_redirect()" value="<?php _e('Cancel', 'woo-transition'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="woo_help()" value="<?php _e('Help', 'woo-transition'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('woo_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'woo-transition'); ?>
	<a target="_blank" href="<?php echo WP_woo_FAV; ?>"><?php _e('click here', 'woo-transition'); ?></a>
</p>
</div>