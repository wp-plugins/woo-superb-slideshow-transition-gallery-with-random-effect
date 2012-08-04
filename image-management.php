<!--
/**
 *     Woo superb slideshow transition gallery with random effect
 *     Copyright (C) 2012  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
-->

<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['woo_link']) <>"")
    {
			if($_POST['woo_id'] == "" )
			{
					$sql = "insert into ".WP_woo_TABLE.""
					. " set `woo_path` = '" . mysql_real_escape_string(trim($_POST['woo_path']))
					. "', `woo_link` = '" . mysql_real_escape_string(trim($_POST['woo_link']))
					. "', `woo_target` = '" . mysql_real_escape_string(trim($_POST['woo_target']))
					. "', `woo_title` = '" . mysql_real_escape_string(trim($_POST['woo_title']))
					. "', `woo_order` = '" . mysql_real_escape_string(trim($_POST['woo_order']))
					. "', `woo_status` = '" . mysql_real_escape_string(trim($_POST['woo_status']))
					. "', `woo_type` = '" . mysql_real_escape_string(trim($_POST['woo_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_woo_TABLE.""
					. " set `woo_path` = '" . mysql_real_escape_string(trim($_POST['woo_path']))
					. "', `woo_link` = '" . mysql_real_escape_string(trim($_POST['woo_link']))
					. "', `woo_target` = '" . mysql_real_escape_string(trim($_POST['woo_target']))
					. "', `woo_title` = '" . mysql_real_escape_string(trim($_POST['woo_title']))
					. "', `woo_order` = '" . mysql_real_escape_string(trim($_POST['woo_order']))
					. "', `woo_status` = '" . mysql_real_escape_string(trim($_POST['woo_status']))
					. "', `woo_type` = '" . mysql_real_escape_string(trim($_POST['woo_type']))
					. "' where `woo_id` = '" . $_POST['woo_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_woo_TABLE." where woo_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_woo_TABLE." where woo_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $woo_id_x = htmlspecialchars(stripslashes($data->woo_id)); 
		if ( !empty($data) ) $woo_path_x = htmlspecialchars(stripslashes($data->woo_path)); 
        if ( !empty($data) ) $woo_link_x = htmlspecialchars(stripslashes($data->woo_link));
		if ( !empty($data) ) $woo_target_x = htmlspecialchars(stripslashes($data->woo_target));
        if ( !empty($data) ) $woo_title_x = htmlspecialchars(stripslashes($data->woo_title));
		if ( !empty($data) ) $woo_order_x = htmlspecialchars(stripslashes($data->woo_order));
		if ( !empty($data) ) $woo_status_x = htmlspecialchars(stripslashes($data->woo_status));
		if ( !empty($data) ) $woo_type_x = htmlspecialchars(stripslashes($data->woo_type));
        $submittext = "Update Message";
    }
    ?>
  <h2>Woo superb slideshow transition gallery with random effect</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/setting.js"></script>
  <form name="form_woo" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return woo_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="woo_path" type="text" id="woo_path" value="<?php echo @$woo_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="woo_link" type="text" id="woo_link" value="<?php echo @$woo_link_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="woo_target" type="text" id="woo_target" value="<?php echo @$woo_target_x; ?>" size="50" /> ( _blank, _parent, _self )</td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter image title:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="woo_title" type="text" id="woo_title" value="<?php echo @$woo_title_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="woo_type" type="text" id="woo_type" value="<?php echo @$woo_type_x; ?>" size="50" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="woo_status" id="woo_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$woo_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$woo_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="woo_order" type="text" id="woo_rder" size="10" value="<?php echo @$woo_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="_woo_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php'" value="Go to - Image Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/woo-superb-slideshow-transition-gallery-with-random-effect.php'" value="Go to - Gallery Setting" type="button" />
			  <input name="Help" lang="publish" class="button-primary" onclick="_woo_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="woo_id" id="woo_id" type="hidden" value="<?php echo @$woo_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_woo_TABLE." order by woo_type,woo_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_woo_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Type
              </td>
            <th width="52%" align="left" scope="col">Title
              </td>
			 <th width="10%" align="left" scope="col">Target
              </td>
            <th width="8%" align="left" scope="col">Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->woo_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->woo_type)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->woo_title)); ?></td>
			<td align="left" valign="middle"><?php echo(stripslashes($data->woo_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->woo_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->woo_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php&DID=<?php echo($data->woo_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_cas_delete('<?php echo($data->woo_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php'" value="Go to - Image Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/woo-superb-slideshow-transition-gallery-with-random-effect.php'" value="Go to - Gallery Setting" type="button" />
		<input name="Help1" lang="publish" class="button-primary" onclick="_woo_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
Check official website for live demo and more information  <a target="_blank" href='http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/'>click here</a>
</div>
