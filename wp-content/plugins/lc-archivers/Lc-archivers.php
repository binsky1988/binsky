<?php
/*
Plugin Name: Lc.Archivers
Plugin URI: http://liucheng.name/947/
Description: Lc.Archivers is a text-only version, concise version of the wordpress blog browsing tools. Generate a static full-articles archive and Site Map. |仿Discuz! Archiver, 生成一个全静态的文章存档与站点地图. Lc.Archivers 是一个纯文字版、简洁版的博客内容浏览工具.
Version: 1.4.2
Author: 柳城
Author URI: http://liucheng.name/
*/

require_once("lc_archivers_options.php"); 

/** define the field name of database **/
define('LC_ARCHIVERS_OPTION','lc_archivers_options');
define('LC_ARCHIVERS_LAST','lc_archivers_last');
define('Lc_Advanced_Settings','lc_advanced_settings');

/**
*Loading language file...
*@Lc.
*/
function load_lc_language() {
		
		//Loading language file...
		$currentLocale = get_locale();
		if(!empty($currentLocale)) {
			$moFile = dirname(__FILE__) . "/lang/Lc_archivers-" . $currentLocale . ".mo";
			if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('Lc_archivers', $moFile);
		}
}

/** load the language file **/
add_filter('init','load_lc_language');

### Function: Lc.Archivers Option Menu
add_action('admin_menu', 'archivers_menu');
function archivers_menu() {
   if (current_user_can('manage_options')) 				
 		add_options_page('Lc.Archivers','Lc.Archivers', 8, __FILE__, 'archivers_optionpage');
}


###Auto
function Lc_archivers_is_auto() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			$Lc_updatePeri = $Lc_updatePeri*60*60;
			if($Lc_archivers_auto == '1'){ 
				wp_schedule_single_event(time()+$Lc_updatePeri, 'do_Lc_auto'); 
				add_action('do_Lc_auto','Lc_update',1,0); 
				}
		}
}
function Lc_archivers_by_post($post_ID) {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			if($Lc_archivers_auto == '1'){
				   wp_clear_scheduled_hook('do_Lc_auto_2');
					wp_schedule_single_event(time()+120, 'do_Lc_auto_2'); 
			}
		}
		return $post_ID;
}

##Auto
add_action('init','Lc_archivers_is_auto',1010,0);
add_action('publish_post', 'Lc_archivers_by_post');
//WP Cron hook
add_action('do_Lc_auto_2','Lc_update',2,0); 
?>