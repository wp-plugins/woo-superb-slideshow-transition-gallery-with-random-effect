<?php

/*
Plugin Name: Woo superb slideshow transition gallery with random effect
Plugin URI: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
Description: Don't just display images, showcase them in style using this gallery effect plugin. Randomly chosen Transitional effects in IE browsers.  
Author: Gopi.R
Version: 2.0
Author URI: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
Donate link: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
*/

/*
##############################################################################################################################
###### Project   : Woo superb slideshow transition gallery with random effect  											######
###### File Name : woo-superb-slideshow-transition-gallery-with-random-effect.php                   					######
###### Purpose   : This page is plugin main page.  																		######
###### Created   : Aug 21th 2010                  																		######
###### Modified  : Jan 01st 2011                  																		######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        										######
###### Link      : http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/  ######
##############################################################################################################################
*/

global $wpdb, $wp_version;
define("WP_woo_TABLE", $wpdb->prefix . "woo_transition");

function woo_show() 
{
	
	global $wpdb;
	$woo_random = get_option('woo_random');
	$woo_type = get_option('woo_type');
	$sSql = "select woo_path,woo_link,woo_target,woo_title from ".WP_woo_TABLE." where 1=1";
	$sSql = $sSql . " and woo_type='".$woo_type."'";
	if($woo_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY woo_order"; }
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$woo_package = $woo_package .'["'.$data->woo_path.'", "'.$data->woo_link.'", "'.$data->woo_target.'", "'.$data->woo_title.'"],';
		}
	}	
	$woo_package = substr($woo_package,0,(strlen($woo_package)-1));
	?>
	<link rel='stylesheet' href='<?php echo get_option('siteurl') ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/style.css' type='text/css' />
    <script type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/woo-superb-slideshow-transition-gallery-with-random-effect.js"></script>
    <script type="text/javascript">
	var flashyshow=new woo_target({ 
		wrapperid: "woo_id_<?php echo $woo_type; ?>", 
		wrapperclass: "woo_class_<?php echo $woo_type; ?>", 
		imagearray: [
			<?php echo $woo_package; ?>
		],
		pause: <?php echo get_option('woo_pause'); ?>, 
		transduration: <?php echo get_option('woo_transduration'); ?> 
	})
	</script>
    <?php
}


add_filter('the_content','woo_show_filter');

function woo_show_filter($content){
	return 	preg_replace_callback('/\[woo-superb-slideshow=(.*?)\]/sim','woo_show_filter_Callback',$content);
}

function woo_show_filter_Callback($matches) 
{
	global $wpdb;
	$var = $matches[1];
	list($woo_type, $woo_random) = split('[=.-]', $var);
	if($woo_type==""){$woo_type = "widget";}
	if($woo_random==""){$woo_random = "YES";}
	$sSql = "select woo_path,woo_link,woo_target,woo_title from ".WP_woo_TABLE." where 1=1";
	$sSql = $sSql . " and woo_type='".$woo_type."'";
	if($woo_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY woo_order"; }
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$woo_package = $woo_package .'["'.$data->woo_path.'", "'.$data->woo_link.'", "'.$data->woo_target.'", "'.$data->woo_title.'"],';
		}
	}
	$woo_package = substr($woo_package,0,(strlen($woo_package)-1));
	$newwrapperid = $woo_type;
	$woo_pluginurl = get_option('siteurl') . "/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/";
	$woo_xml = $woo_xml .'<link rel="stylesheet" href="'.$woo_pluginurl.'style.css" type="text/css" />';
    $woo_xml = $woo_xml .'<script type="text/javascript" src="'.$woo_pluginurl.'woo-superb-slideshow-transition-gallery-with-random-effect.js"></script>';
    $woo_xml = $woo_xml .'<script type="text/javascript">';
	$woo_xml = $woo_xml .'var flashyshow=new woo_target({ wrapperid: "'.$newwrapperid.'", wrapperclass: "woo_class_'.$newwrapperid.'", imagearray: ['.$woo_package.'],pause: '. get_option('woo_pause').',transduration: '. get_option('woo_transduration').' })';
	$woo_xml = $woo_xml .'</script>';
	return $woo_xml;
}

function woo_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_woo_TABLE . "'") != WP_woo_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_woo_TABLE . "` (";
		$sSql = $sSql . "`woo_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`woo_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`woo_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`woo_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`woo_title` VARCHAR( 200 ) NOT NULL ,";
		$sSql = $sSql . "`woo_order` INT NOT NULL ,";
		$sSql = $sSql . "`woo_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`woo_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`woo_date` INT NOT NULL ,";
		$sSql = $sSql . "PRIMARY KEY ( `woo_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x200/250x200_1.jpg','http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/','_blank','','1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x200/250x200_2.jpg','http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/','_blank','','2', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x200/250x200_3.jpg','http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/','_blank','','3', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x200/250x200_4.jpg','http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/','_blank','','4', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	add_option('woo_title', "Woo Slideshow");
	add_option('woo_pause', "2000");
	add_option('woo_transduration', "1000");
	add_option('woo_random', "YES");
	add_option('woo_type', "widget");
}

function woo_widget($args) 
{
	extract($args);
	if(get_option('woo_title') <> "")
	{
		echo $before_widget . $before_title;
		echo get_option('woo_title');
		echo $after_title;
	}
	woo_show();
	if(get_option('woo_title') <> "")
	{
		echo $after_widget;
	}
}

function woo_admin_option() 
{
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo wp_specialchars( "Woo superb slideshow transition gallery with random effect" ) ;
	echo "</h2>";
	$woo_title = get_option('woo_title');
	$woo_pause = get_option('woo_pause');
	$woo_transduration = get_option('woo_transduration');
	$woo_random = get_option('woo_random');
	$woo_type = get_option('woo_type');
	if ($_POST['woo_submit']) 
	{
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
	}
	?><form name="form_woo" method="post" action="">
	<?php
	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $woo_title . '" name="woo_title" id="woo_title" /> Widget title.</p>';
	echo '<p>Pause:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $woo_pause . '" name="woo_pause" id="woo_pause" /> Only Number / Pause between content change (millisec).</p>';
	echo '<p>Transduration:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $woo_transduration . '" name="woo_transduration" id="woo_transduration" /> Only Number / Duration of transition (affects only IE users).</p>';
	echo '<p>Random :<br><input  style="width: 100px;" type="text" value="';
	echo $woo_random . '" name="woo_random" id="woo_random" /> (YES/NO)</p>';
	echo '<p>Type:<br><input  style="width: 150px;" type="text" value="';
	echo $woo_type . '" name="woo_type" id="woo_type" /> This field is to group the images.</p>';
	echo '<input name="woo_submit" id="woo_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</form>
	<table width="100%">
		<tr>
		  <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php'" value="Go to - Image Management" type="button" />
			<input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/woo-superb-slideshow-transition-gallery-with-random-effect.php'" value="Go to - Gallery Setting" type="button" />
		  </td>
		</tr>
	  </table>
	<?php
	include_once("help.php");
	echo "</div>";
}

function woo_control()
{
	echo '<p>Woo superb slideshow transition gallery with random effect.<br><br> To change the setting goto "Woo superb slideshow transition gallery with random effect" link under SETTING menu.';
	echo ' <a href="options-general.php?page=woo-superb-slideshow-transition-gallery-with-random-effect/woo-superb-slideshow-transition-gallery-with-random-effect.php">';
	echo 'click here</a></p>';
	?>
	<a target="_blank" href='http://gopi.coolpage.biz/demo/about/'>Click here</a> for more help.<br> 
	<?php
}

function woo_widget_init() 
{
  	register_sidebar_widget(__('Woo superb slideshow transition gallery with random effect'), 'woo_widget');   
	
	if(function_exists('register_sidebar_widget')) 	
	{
		register_sidebar_widget('Woo superb slideshow transition gallery with random effect', 'woo_widget');
	}
	
	if(function_exists('register_widget_control')) 	
	{
		register_widget_control(array('Woo superb slideshow transition gallery with random effect', 'widgets'), 'woo_control');
	} 
}

function woo_deactivation() 
{
}

function woo_add_to_menu() 
{
	//add_options_page('Woo superb slideshow transition gallery with random effect', 'Woo superb slideshow transition gallery with random effect', 7, __FILE__, 'woo_admin_option' );
	//add_options_page('Woo superb slideshow transition gallery with random effect', '', 0, "woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php",'' );

	add_options_page('Woo superb slideshow transition gallery with random effect', 'Woo superb slideshow transition gallery with random effect', 'manage_options', __FILE__, 'woo_admin_option' );
	add_options_page('Woo superb slideshow transition gallery with random effect', '', 'manage_options', "woo-superb-slideshow-transition-gallery-with-random-effect/image-management.php",'' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'woo_add_to_menu');
}

add_action('admin_menu', 'woo_add_to_menu');
add_action("plugins_loaded", "woo_widget_init");
register_activation_hook(__FILE__, 'woo_install');
register_deactivation_hook(__FILE__, 'woo_deactivation');
add_action('init', 'woo_widget_init');
?>