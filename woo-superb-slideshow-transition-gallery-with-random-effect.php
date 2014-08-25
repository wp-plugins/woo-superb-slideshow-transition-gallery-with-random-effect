<?php
/*
Plugin Name: Woo superb slideshow transition gallery with random effect
Plugin URI: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
Description: Don't just display images, showcase them in style using this gallery effect plugin. Randomly chosen Transitional effects in IE browsers.  
Author: Gopi Ramasamy
Version: 7.4
Author URI: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
Donate link: http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_woo_TABLE", $wpdb->prefix . "woo_transition");
define('WP_woo_FAV', 'http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/');

if ( ! defined( 'WP_woo_BASENAME' ) )
	define( 'WP_woo_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_woo_PLUGIN_NAME' ) )
	define( 'WP_woo_PLUGIN_NAME', trim( dirname( WP_woo_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_woo_PLUGIN_URL' ) )
	define( 'WP_woo_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_woo_PLUGIN_NAME );
	
if ( ! defined( 'WP_woo_ADMIN_URL' ) )
	define( 'WP_woo_ADMIN_URL', get_option('siteurl') . '/wp-admin/options-general.php?page=woo-superb-slideshow' );

function woo_show( $type = "widget" , $random = "YES" ) 
{
	$arr = array();
	$arr["type"] = $type;
	$arr["random"] = $random;
	echo woo_shortcode($arr);
}

function woo_shortcode( $atts ) 
{
	global $wpdb;
	global $Woo_ScriptInserted;
	$woo_xml = "";
	$woo_package = "";
	
	// [woo-superb-slideshow type="widget" random="YES"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$woo_type = $atts['type'];
	$woo_random = $atts['random'];
	
	$sSql = "select woo_path,woo_link,woo_target,woo_title from ".WP_woo_TABLE." where 1=1";

	if($woo_random <> "")
	{ 
		$sSql = $sSql . " and woo_type='".$woo_type."'"; 
	}
	
	if($woo_random == "YES")
	{ 
		$sSql = $sSql . " ORDER BY RAND()"; 
	}
	else
	{ 
		$sSql = $sSql . " ORDER BY woo_order"; 
	}
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$woo_package = $woo_package .'["'.$data->woo_path.'", "'.$data->woo_link.'", "'.$data->woo_target.'", "'.$data->woo_title.'"],';
		}
		
		$woo_package = substr($woo_package,0,(strlen($woo_package)-1));
		$newwrapperid = $woo_type;
		$woo_pluginurl = get_option('siteurl') . "/wp-content/plugins/woo-superb-slideshow-transition-gallery-with-random-effect/";
		
		if (!isset($Woo_ScriptInserted) || $Woo_ScriptInserted !== true)
		{
			$Woo_ScriptInserted = true;
			$woo_xml = $woo_xml .'<link rel="stylesheet" href="'.$woo_pluginurl.'style.css" type="text/css" />';
		}
		
		$woo_xml = $woo_xml .'<script type="text/javascript">';
		$woo_xml = $woo_xml .'var flashyshow=new woo_target({ wrapperid: "'.$newwrapperid.'", wrapperclass: "woo_class_'.$newwrapperid.'", imagearray: ['.$woo_package.'],pause: '. get_option('woo_pause').',transduration: '. get_option('woo_transduration').' })';
		$woo_xml = $woo_xml .'</script>';
	}
	else
	{
		$woo_xml = "Record not found: " . $woo_type;
	}
	
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
		$sSql = $sSql . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('".WP_woo_PLUGIN_URL."/images/250x167_1.jpg','#','_blank','','1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('".WP_woo_PLUGIN_URL."/images/250x167_2.jpg','#','_blank','','2', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('".WP_woo_PLUGIN_URL."/images/250x167_3.jpg','#','_blank','','3', 'YES', 'PAGE', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_woo_TABLE . "` (`woo_path`, `woo_link`, `woo_target` , `woo_title` , `woo_order` , `woo_status` , `woo_type` , `woo_date`)"; 
		$sSql = $sSql . "VALUES ('".WP_woo_PLUGIN_URL."/images/250x167_4.jpg','#','_blank','','4', 'YES', 'PAGE', '0000-00-00 00:00:00');";
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
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-management-edit.php');
			break;
		case 'add':
			include('pages/image-management-add.php');
			break;
		case 'set':
			include('pages/image-setting.php');
			break;
		default:
			include('pages/image-management-show.php');
			break;
	}
}

function woo_control()
{
	echo '<p><b>';
	_e('Woo Superb Slideshow', 'woo-transition');
	echo '.</b> ';
	_e('Check official website for more information', 'woo-transition');
	?> <a target="_blank" href="<?php echo WP_woo_FAV; ?>"><?php _e('click here', 'woo-transition'); ?></a></p><?php
}

function woo_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('Woo-superb-slideshow-transition', 
				__('Woo superb slideshow', 'woo-transition'), 'woo_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('Woo-superb-slideshow-transition', array( 
				__('Woo superb slideshow', 'woo-transition'), 'widgets'), 'woo_control');
	} 
}

function woo_deactivation() 
{
	// No action required.
}

function woo_add_to_menu() 
{
	add_options_page( __('Woo superb slideshow', 'woo-transition'), 
				__('Woo superb slideshow', 'woo-transition'), 'manage_options', 'woo-superb-slideshow', 'woo_admin_option' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'woo_add_to_menu');
}

function woo_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'woo-superb-slideshow', WP_woo_PLUGIN_URL.'/woo-superb-slideshow-transition-gallery-with-random-effect.js');
	}	
}

function woo_textdomain() 
{
	  load_plugin_textdomain( 'woo-transition', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'woo_textdomain');
add_shortcode( 'woo-superb-slideshow', 'woo_shortcode' );
add_action('init', 'woo_add_javascript_files');
add_action("plugins_loaded", "woo_widget_init");
register_activation_hook(__FILE__, 'woo_install');
register_deactivation_hook(__FILE__, 'woo_deactivation');
add_action('init', 'woo_widget_init');
?>