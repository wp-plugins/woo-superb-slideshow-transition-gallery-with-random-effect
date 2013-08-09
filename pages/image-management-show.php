<?php
// Form submitted, check the data
if (isset($_POST['frm_woo_display']) && $_POST['frm_woo_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$woo_success = '';
	$woo_success_msg = FALSE;
	
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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('woo_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_woo_TABLE."`
					WHERE `woo_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$woo_success_msg = TRUE;
			$woo_success = __('Selected record was successfully deleted.', WP_woo_UNIQUE_NAME);
		}
	}
	
	if ($woo_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $woo_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php echo WP_woo_TITLE ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=woo-superb-slideshow&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_woo_TABLE."` order by woo_type, woo_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/pages/setting.js"></script>
		<form name="frm_woo_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" /></th>
			<th scope="col">Type</th>
            <th scope="col">URL</th>
			<th scope="col">Target</th>
            <th scope="col">Order</th>
            <th scope="col">Display</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" /></th>
			<th scope="col">Type</th>
            <th scope="col">Path</th>
			<th scope="col">Target</th>
            <th scope="col">Order</th>
            <th scope="col">Display</th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			$displayisthere = FALSE;
			foreach ($myData as $data)
			{
				if($data['woo_status'] == 'YES') 
				{
					$displayisthere = TRUE; 
				}
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['woo_id']; ?>" name="woo_group_item[]"></td>
					<td>
					<strong><?php echo esc_html(stripslashes($data['woo_type'])); ?></strong>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=woo-superb-slideshow&amp;ac=edit&amp;did=<?php echo $data['woo_id']; ?>">Edit</a> | </span>
						<span class="trash"><a onClick="javascript:woo_delete('<?php echo $data['woo_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
					</div>
					</td>
					<td><a href="<?php echo esc_html(stripslashes($data['woo_path'])); ?>" target="_blank"><?php echo esc_html(stripslashes($data['woo_path'])); ?></a></td>
					<td><?php echo esc_html(stripslashes($data['woo_target'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['woo_order'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['woo_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				} 
			?>
			<?php 
			if ($displayisthere == FALSE) 
			{ 
				?><tr><td colspan="6" align="center">No records available.</td></tr><?php 
			} 
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('woo_form_show'); ?>
		<input type="hidden" name="frm_woo_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=woo-superb-slideshow&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=woo-superb-slideshow&amp;ac=set">Widget setting</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_woo_FAV; ?>">Help</a>
	  </h2>
	  </div>
	    <div style="height:5px"></div>
		<h3>Plugin configuration option</h3>
		<ol>
			<li>Add the plugin in the posts or pages using short code.</li>
			<li>Add directly in to the theme using PHP code.</li>
			<li>Drag and drop the widget to your sidebar.</li>
		</ol>
	  <p class="description"><?php echo WP_woo_LINK; ?></p>
	</div>
</div>