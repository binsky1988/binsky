<?php 
require_once("lc_archivers_function.php"); 

function archivers_optionpage() {
      if(isset($_POST["action"])) { if($_POST["action"]=='build_html_all') {
		 Lc_update_all();
	  } }
      if(isset($_POST["action"])) { if($_POST["action"]=='build_html') {
		 Lc_update();
	  } }
      if(isset($_POST["action"])) { if($_POST["action"]=='build_Lc_options') {
		 update_Lc_options();
	  } }
      if(isset($_POST["action"])) { if($_POST["action"]=='del_html') {
		 delDirAndFile();
	  } }

		/** Definition **/
      echo '<div class="wrap"><div style="background: url('.Lc_GetPluginUrl().'img/liucheng_name32.png) no-repeat;" class="icon32"><br /></div>';
		echo '<h2>Lc. Archivers</h2>';

		/** Introduction **/ 
		echo '<p>'. _e('Lc.Archivers is a text-only version, concise version of the wordpress blog browsing tools. Generate a static full-articles archive and Site Map.','Lc_archivers') .'</p>';

###IsWritable
Lc_IsWritable();
$Lc_opt = new Lc_get_options;
$Lc_archivers_url = $Lc_opt->Lc_archivers_url();
$Lc_archivers_f = $Lc_opt->Lc_archivers_catalog();
$Lc_archivers_k = $Lc_opt->Lc_keywords();
$Lc_archivers_d = $Lc_opt->Lc_descriptions();
$Lc_the_header = $Lc_opt->Lc_the_header();
$Lc_the_footer = $Lc_opt->Lc_the_footer();
$Lc_post_ads_r = $Lc_opt->Lc_post_ads_r();
$Lc_archivers_auto = $Lc_opt->Lc_archivers_auto();
$Lc_author_url = 'http://liucheng.name/';
$Lc_plugin_url = 'http://liucheng.name/947/';
	$Lc_Advanced_Settings = get_option(Lc_Advanced_Settings);
	if($Lc_Advanced_Settings){ $Lc_archivers_link = $Lc_Advanced_Settings;} else { $Lc_archivers_link = 'Lc.Archivers'; }
?>
		<div class="postbox-container" style="width:75%;">
			<div class="metabox-holder">	
				<div class="meta-box-sortables">			
						
		<div class="tool-box">
			<h3 class="title"><?php _e('Profile');?></h3>
			<p><?php _e('Configuring this is optional. By default, it should be blank.');?></p>
			<a name="Lc_archivers_options"></a><form name="Lc_archivers_options" method="post" action="">
			<input type="hidden" name="action" value="build_Lc_options" />
			<table>
				<tr><td><label for="Lc_archivers_f"><?php _e('Directory Name','Lc_archivers');?></label></td><td><input type="text" size="50" name="Lc_archivers_f" value="<?php echo $Lc_archivers_f;?>" <?php if($Lc_archivers_auto=='1'){ echo 'disabled'; } ?> /></td><td><i><?php _e('Default');?><?php echo ':';?><?php _e('archivers');?></i></td></tr>
				<tr><td><label for="Lc_archivers_url"><?php _e('URL','Lc_archivers');?></label></td><td><input type="text" size="50" name="Lc_archivers_url" value="<?php if($Lc_archivers_url) { echo $Lc_archivers_url; }?>" /></td></tr>
				<tr><td><label for="Lc_archivers_k"><?php _e('Term');?></label></td><td><input type="text" size="50" maxlength="200" name="Lc_archivers_k" value="<?php echo $Lc_archivers_k;?>" /></td><td><i><?php _e('Separate tags with commas.');?></i></td></tr>
				<tr><td><label for="Lc_archivers_d"><?php _e('Description');?></label></td><td><textarea rows='3' cols='43' name="Lc_archivers_d"><?php echo $Lc_archivers_d;?></textarea></td></tr>
				<tr><td><label for="Lc_the_header"><?php _e('Custom Header');?></label></td><td><textarea rows='3' cols='43' name="Lc_the_header"><?php echo $Lc_the_header;?></textarea></td><td><i><?php _e('Such as: Ads in Header','Lc_archivers');?></i></td></tr>
				<tr><td><label for="Lc_the_footer"><?php _e('Footer');?></label></td><td><textarea rows='3' cols='43' name="Lc_the_footer"><?php echo $Lc_the_footer;?></textarea></td><td><i><?php _e('Such as: Google Analytics in Footer','Lc_archivers');?></i></td></tr>
				<tr><td><label for="Lc_post_ads_r"><?php _e('Insert into Post');?></label></td><td><textarea rows='3' cols='43' name="Lc_post_ads_r"><?php echo $Lc_post_ads_r;?></textarea></td><td><i><?php _e('Ads in right sidebar of Singel','Lc_archivers');?></i></td></tr>
				<tr><td><label for="Lc_archivers_auto"><?php _e('Enabled');?></label></td><td><input type="checkbox" id="Lc_archivers_auto" name="Lc_archivers_auto" value="1" <?php if($Lc_archivers_auto=='1'){ echo 'checked="checked"'; } ?> /></td><td><i><?php _e('Updated it when publish_post','Lc_archivers');?></i></td></tr>

			<tr><td><label for="Advanced_Settings"><strong><?php _e('Advanced Settings');?></strong></label></td></tr>

				<tr><td><label for="Lc_archivers_link"><?php _e('Display Template','Lc_archivers');?></label></td><td><input type="text" size="50" name="Lc_archivers_link" value="<?php echo $Lc_archivers_link;?>" /></td></tr>
			</table>
			<p><?php _e('To display a link to Lc.Arvchivers, Note that the theme files must contain a call to <code>Lc_Archivers_Link()</code>','Lc_archivers');?></p>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update Profile'); ?>" /></p>
			</form>
		</div>

		<div class="tool-box">
			<h3 class="title"><?php _e('Lc. Archivers','Lc_archivers');?></h3>

				<a name="Lc_archivers_all"></a><form name="Lc_archivers_all" method="post" action="">
				<input type="hidden" name="action" value="build_html_all" />
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update')._e('All'); ?>" /> <i><?php _e('Steps may take a few minutes depending on the size of your database. Please be patient.');?></i></p>
				</form>
				<a name="Lc_archivers_html"></a><form name="Lc_archivers_html" method="post" action="">
				<input type="hidden" name="action" value="build_html" />
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update')._e('Latest'); ?>" /></p>
				</form>
				<?php index_exist(); ?>
				<?php //Lc_others_plugin_exist(); ?>
		</div>
		</div>
		</div>
		</div>



		<style type="text/css">
				
		a.Lc_button {
			padding:4px;
			display:block;
			padding-left:25px;
			background-repeat:no-repeat;
			background-position:5px 50%;
			text-decoration:none;
			border:none;
		}
		
		a.Lc_button:hover {
			border-bottom-width:1px;
		}

		a.Lc_donatePayPal {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/icon-paypal.gif);
		}
		
		a.Lc_donateFavorite {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/favorite_icon.png);
		}
		
		a.Lc_pluginHome {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/liucheng_name16.png);
		}
		
		a.Lc_pluginList {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/icon-email.gif);
		}
		
		a.Lc_pluginBugs {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/rss_icon.png);
		}
		
		a.Lc_resBaidu {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/baidu.png);
		}
		
		a.Lc_resRss {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/rss_icon.png);
		}
		
		a.Lc_resWordpress {
			background-image:url(<?php echo Lc_GetPluginUrl(); ?>img/wordpress_icon2.png);
		}
		
		</style>

		<div class="postbox-container" style="width:2%;">
		</div>
		<div class="postbox-container" style="width:21%;">
			<div class="metabox-holder">	
				<div class="meta-box-sortables">			

	     <div id="Lc_smres" class="postbox">
			<h3 class="hndle"><span ><?php _e('Plugin Information:');?></span></h3>
			  <div class="inside">
			            <a class="Lc_button Lc_pluginHome" href="<?php echo $Lc_author_url;?>" target="_blank"><?php _e('Visit author homepage');?></a>
						<a class="Lc_button Lc_pluginHome" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Visit plugin site');?></a>
						<a class="Lc_button Lc_resRss" href="http://liucheng.name/archivers/" target="_blank"><?php _e('Preview this Page');?></a>
				</div>
			</div>

	     <div id="Lc_smres" class="postbox">
			<h3 class="hndle"><span ><?php _e('Donations: ','Lc_archivers');?></span></h3>
			  <div class="inside">
			            <a class="Lc_button Lc_resWordpress" href="<?php echo $Lc_plugin_url;?>"><?php _e('Not yet. you would be the first!','Lc_archivers');?></a>
				</div>
			</div>

	     <div id="Lc_smres" class="postbox">
			<h3 class="hndle"><span ><?php _e('Languages');?></span></h3>
			  <div class="inside">
			            <a class="Lc_button Lc_resRss" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('English','Lc_archivers');?></a>
						<a class="Lc_button Lc_pluginHome" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Simplified Chinese','Lc_archivers');?></a>
                        <a class="Lc_button Lc_resRss" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Traditional Chinese','Lc_archivers');?></a>
						<a class="Lc_button Lc_resRss" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Japanese','Lc_archivers');?></a>
						<a class="Lc_button Lc_resRss" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Korean','Lc_archivers');?></a>
				</div>
			</div>

	     <div id="Lc_smres" class="postbox">
			<h3 class="hndle"><span ><?php _e('Plugin');?></span></h3>
			  <div class="inside">
			            <a class="Lc_button Lc_pluginHome" href="<?php echo $Lc_plugin_url;?>" target="_blank"><?php _e('Lc. Archivers','Lc_archivers');?></a>
			            <a class="Lc_button Lc_pluginHome" href="http://liucheng.name/883/" target="_blank"><?php _e('Baidu-Sitemap','Lc_archivers');?></a>
						<a class="Lc_button Lc_pluginHome" href="http://liucheng.name/789/" target="_blank"><?php _e('WP KeywordLink','Lc_archivers');?></a>
				</div>
			</div>

			</div>
			</div>
			</div>
<?php 
				} 

/** custom message **/
function Lc_archivers_topbarmessage($msg) {
	 echo '<div class="updated fade" id="message"><p>' . $msg . '</p></div>';
}

/** update the options **/
function update_Lc_options() {
    if(isset($_POST["action"])) {
		if ($_POST['action']=='build_Lc_options'){
			if(isset($_POST["Lc_archivers_f"])) { if($_POST['Lc_archivers_f']) { $Lc_archivers_f = $_POST['Lc_archivers_f']; } else { $Lc_archivers_f = 'archivers'; } } else { $Lc_opt = new Lc_get_options; $Lc_archivers_f = $Lc_opt->Lc_archivers_catalog(); }
			if($_POST['Lc_archivers_k']) { $Lc_archivers_k = $_POST['Lc_archivers_k']; } else { $Lc_archivers_k = 'archivers'.','.get_bloginfo('name'); }
			if($_POST['Lc_archivers_d']) { $Lc_archivers_d = $_POST['Lc_archivers_d']; } else { $Lc_archivers_d = get_bloginfo('name').' '.'archivers'; }
			if($url = trim($_POST['Lc_archivers_url'])) { if(preg_match("/\/$/",$url)) { $Lc_archivers_url = $url; }  else {  $Lc_archivers_url = $url.'/'; } }

			$Lc_updatePeri = '10';

			$Lc_title = 'Archivers';

			$Lc_archivers_auto = $_POST['Lc_archivers_auto'];
			if(empty($Lc_archivers_auto)){ $Lc_archivers_auto = '0'; if(function_exists('wp_clear_scheduled_hook')) { wp_clear_scheduled_hook('do_Lc_auto'); } }

			if($_POST['Lc_the_header']) { $Lc_the_header = Lc_Escape_v(Lc_Escape($_POST['Lc_the_header'])); } else { $Lc_the_header = ''; }
			if($_POST['Lc_the_footer']) { $Lc_the_footer = Lc_Escape_v(Lc_Escape($_POST['Lc_the_footer'])); } else { $Lc_the_footer = '&copy;'.get_bloginfo('name'); }
			if($_POST['Lc_post_ads_r']) { $Lc_post_ads_r = Lc_Escape_v(Lc_Escape($_POST['Lc_post_ads_r'])); } else { $Lc_post_ads_r = ''; }

			$Lc_archivers_options = implode('|',array($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r, $Lc_archivers_url));
			update_option(LC_ARCHIVERS_OPTION,$Lc_archivers_options); 
			Lc_archivers_topbarmessage(__('Options saved.'));
			if($Lc_archivers_auto){ Lc_archivers_is_auto(); }
			//update Lc_Advanced_Settings
			if($_POST[Lc_archivers_link]){ $Lc_archivers_link = $_POST[Lc_archivers_link]; update_option(Lc_Advanced_Settings,$Lc_archivers_link); } 
		}
	}
}

function update_Lc_last() {
    /** Get the current time **/
	$blogtime = current_time('mysql'); 
	list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $blogtime );
	$Lc_lastupdate = "$today_year-$today_month-$today_day $hour:$minute:$second";
    update_option(LC_ARCHIVERS_LAST,$Lc_lastupdate);
}

###get the category list
function archivers_category() {
    global $wpdb, $posts, $wp_version;
	$Lc_opt = new Lc_get_options;
	$Lc_archivers_url =  $Lc_opt->Lc_archivers_url();
	$Lc_blog_url = get_bloginfo('url');
	$Lc_archivers_catalog = 'archivers';
	$category_index_all='';
    
	$sql_category = "SELECT $wpdb->terms.term_id as cat_ID, name, slug, count, description
 		 		 FROM $wpdb->terms
 		 		 JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
 		 		 WHERE taxonomy = 'category'
 		 		 ";
	$category_index = $wpdb->get_results($sql_category);
	if($category_index) {
		foreach($category_index as $category) {
			$category_name = $category->name;
			$category_slug = $category->slug;
			$category_count = $category->count;
			$category_Id = $category->cat_ID;
			$category_description = $category->description;
			if($category_count){
                $category_index_r = '<li><a href="'.$Lc_archivers_url.'cat'.$category_Id.'-1.html" title="'.Lc_EscapeESC($category_description).'">'.$category_name.'</a> ('.$category_count.')</li>';
                $category_index_all .=  $category_index_r."\n";
			}
		}
	} 
   return $category_index_all;
}

###get the page list
function archivers_page() {
	global $wpdb;
	$archivers_page_all = '';
	$sql_ap = "SELECT ID, post_title
              FROM $wpdb->posts
              WHERE post_type = 'page'
              AND post_status = 'publish'
              AND post_password = ''
              ";
    $archivers_page_index = $wpdb->get_results($sql_ap);
	if($archivers_page_index) { 
		foreach ($archivers_page_index as $page) {
            $archivers_page_url = get_permalink($page->ID);
            $archivers_page_title = $page->post_title;
            $archivers_page_r = '<li><a href="'.$archivers_page_url.'" title="'.Lc_EscapeESC($archivers_page_title).'">'.$archivers_page_title.'</a></li>';
			$archivers_page_all .= $archivers_page_r."\n";
		}
	}
	 return $archivers_page_all;
}

###get the recent_post
function recent_post() {
	global $wpdb;
	$Lc_opt = new Lc_get_options;
	$Lc_archivers_url =  $Lc_opt->Lc_archivers_url();
	$recent_post_all = '';
	$sql_rp = "SELECT ID, post_title, comment_count
              FROM $wpdb->posts
              WHERE post_type = 'post'
              AND post_status = 'publish'
              AND post_password = ''
              ORDER BY ID DESC 
              LIMIT 0, 10";
	$get_recent_post = $wpdb->get_results($sql_rp);
	if($get_recent_post) {
		foreach($get_recent_post as $post) {
           //$recent_post_url = get_permalink($post->ID);
		   $recent_post_url = $Lc_opt->Lc_archivers_url().'p'.$post->ID.'.html';
		   $recent_post_title = $post->post_title;
		   $comment_count = $post->comment_count;
		   $recent_post_r = '<li><a href="'.$recent_post_url.'" title="'.Lc_EscapeESC($recent_post_title).'">'.$recent_post_title.'</a> ('.str_replace('%s',$comment_count,__('Comments %s')).')</li>';
           $recent_post_all .= $recent_post_r."\n";
		}
	}
	return $recent_post_all;
}


###get the post list by cat_ID
function get_list_by_cat() {
	$sql_cat = "SELECT term_id, name, slug, count 
 		 		 FROM $wpdb->terms
 		 		 JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
 		 		 WHERE taxonomy = 'category'
 		 		 ";
	$get_list_by_cat = $wpdb->get_results($sql_cat);
}


######################################################



###update archivers Homepage
function archivers_index_build() {
	$Lc_opt = new Lc_get_options;
	$Lc_the_header = Lc_REscape($Lc_opt->Lc_the_header());
	$Lc_the_footer = Lc_REscape($Lc_opt->Lc_the_footer());
	$Lc_post_ads_r = Lc_REscape($Lc_opt->Lc_post_ads_r());
	    $Lc_archivers_catalog = $Lc_opt->Lc_archivers_catalog();
		$Lc_title = $Lc_opt->Lc_title();
		$Lc_blog_name = Lc_EscapeESC(get_bloginfo('name')); 
		$Lc_keywords = $Lc_opt->Lc_keywords();
		$Lc_descriptions = $Lc_opt->Lc_descriptions();;
		//$Lc_author = 'Liucheng.Name';
		//$Lc_copyright = 'Liucheng.Name';
		$Lc_blog_home = $Lc_opt->Lc_blog_home();
		$Lc_archivers_url = $Lc_opt->Lc_archivers_url();
		$Lc_recentpost = __('Your latest posts');
		$Lc_recentpost_contents = recent_post();
		$Lc_category = __('Categories');
		$Lc_category_contents = archivers_category();
		$Lc_page = __('Pages');
		$Lc_page_contents = archivers_page();
		$Lc_footnote = $Lc_opt->Lc_footnote();

		###Tag
		$Lc_tag = __('Tag Cloud');
		$Lc_tag_index_url = $Lc_archivers_url.'tag.html';
		//$updated_time = "$today_year-$today_month-$today_day $hour:$minute:$second";
		
		##build the index
		//archivers_category
			$path_index_html  = Lc_GetPluginPath().'index.html';
			$index_html = file_get_contents("$path_index_html");

			$index_html = str_replace("%Lc_title%",$Lc_title,$index_html);
			$index_html = str_replace("%Lc_tag%",$Lc_tag,$index_html);
			$index_html = str_replace("%Lc_blog_home%",$Lc_blog_home,$index_html);
			$index_html = str_replace("%Lc_blog_name%",$Lc_blog_name,$index_html);
			$index_html = str_replace("%Lc_keywords%",$Lc_keywords,$index_html);
			$index_html = str_replace("%Lc_descriptions%",$Lc_descriptions,$index_html);
			$index_html = str_replace("%Lc_archivers_url%",$Lc_archivers_url,$index_html);
			$index_html = str_replace("%Lc_recentpost%",$Lc_recentpost,$index_html);
			$index_html = str_replace("%Lc_recentpost_contents%",$Lc_recentpost_contents,$index_html);
			$index_html = str_replace("%Lc_category%",$Lc_category,$index_html);
			$index_html = str_replace("%Lc_category_contents%",$Lc_category_contents,$index_html);
			$index_html = str_replace("%Lc_page%",$Lc_page,$index_html);
			$index_html = str_replace("%Lc_page_contents%",$Lc_page_contents,$index_html);
			$index_html = str_replace("%Lc_footnote%",$Lc_footnote,$index_html);
			$index_html = str_replace("%Lc_tag_index_url%",$Lc_tag_index_url,$index_html);
			$index_html = str_replace("%Lc_the_header%",$Lc_the_header,$index_html);
			$index_html = str_replace("%Lc_the_footer%",$Lc_the_footer,$index_html);

			//echo $index_html;
            $file_index = Lc_GetHomePath().$Lc_archivers_catalog;
			$file_index_html = Lc_GetHomePath().$Lc_archivers_catalog.'/index.html';
			Lc_createFolders($file_index);
			if(Lc_IsFileWritable($file_index)){
				file_put_contents("$file_index_html","$index_html"); 						
				/** Messages  **/
				Lc_archivers_topbarmessage(__('Archivers','Lc_archivers').' '.__('Update'));
			}
		
		##build the tag_index
		$Lc_tag = __('Tag Cloud');
		$Lc_tag_index_url = $Lc_archivers_url.'tag.html';
		#$Lc_tag_contents = Lc_wp_tag_cloud('smallest=8&largest=22&number=500&link=Lc_tag_url&echo=0'); 去除标签list的更新
		$Lc_tag_contents = Lc_wp_tag_cloud('smallest=8&largest=22&number=500&echo=0');

		   $path_tag_html = Lc_GetPluginPath().'tag.html';
		   $tag_html = file_get_contents("$path_tag_html");

			$tag_html = str_replace("%Lc_title%",$Lc_title,$tag_html);
			$tag_html = str_replace("%Lc_tag%",$Lc_tag,$tag_html);
			$tag_html = str_replace("%Lc_blog_home%",$Lc_blog_home,$tag_html);
			$tag_html = str_replace("%Lc_blog_name%",$Lc_blog_name,$tag_html);
			$tag_html = str_replace("%Lc_keywords%",$Lc_keywords,$tag_html);
			$tag_html = str_replace("%Lc_descriptions%",$Lc_descriptions,$tag_html);
			$tag_html = str_replace("%Lc_archivers_url%",$Lc_archivers_url,$tag_html);
			$tag_html = str_replace("%Lc_recentpost%",$Lc_recentpost,$tag_html);
			$tag_html = str_replace("%Lc_recentpost_contents%",$Lc_recentpost_contents,$tag_html);
			$tag_html = str_replace("%Lc_tag_index_url%",$Lc_tag_index_url,$tag_html);
			$tag_html = str_replace("%Lc_tag_contents%",$Lc_tag_contents,$tag_html);
			$tag_html = str_replace("%Lc_footnote%",$Lc_footnote,$tag_html);
			$tag_html = str_replace("%Lc_the_header%",$Lc_the_header,$tag_html);
			$tag_html = str_replace("%Lc_the_footer%",$Lc_the_footer,$tag_html);

            $file_index = Lc_GetHomePath().$Lc_archivers_catalog;
			$file_tag_html = Lc_GetHomePath().$Lc_archivers_catalog.'/tag.html';
			Lc_createFolders($file_index);
			if(Lc_IsFileWritable($file_index)){
				file_put_contents("$file_tag_html","$tag_html"); 						
				/** Messages  **/
				Lc_archivers_topbarmessage(__('Tag Cloud').' '.__('Update'));
			}
}

###get the post_list
function update_the_post_list($type,$vaule) {
	global $post;
	$Lc_opt = new Lc_get_options;
	$Lc_the_header = Lc_REscape($Lc_opt->Lc_the_header());
	$Lc_the_footer = Lc_REscape($Lc_opt->Lc_the_footer());
	$Lc_post_ads_r = Lc_REscape($Lc_opt->Lc_post_ads_r());

    ##post list for category
	if($type == 'cat_list') {
		
		 $myposts = get_posts("category=$vaule&numberposts=-1&post_status=publish&post_type=post"); 

		 ###options
		 $Lc_post_term = Lc_EscapeESC(get_cat_name($vaule));
		 $Lc_title  = $Lc_opt->Lc_title();
		 $Lc_blog_name = Lc_EscapeESC(get_bloginfo('name'));
		 $Lc_descriptions = $Lc_opt->Lc_descriptions();
		 $Lc_blog_home = $Lc_opt->Lc_blog_home();
		 $Lc_archivers_url =  $Lc_opt->Lc_archivers_url();
		 //$Lc_post_term_url = $Lc_opt->Lc_archivers_url().Lc_get_cat_slug($vaule).'.html';
		 $Lc_footnote = $Lc_opt->Lc_footnote();
		 $Lc_post_term_permalink = get_category_link($vaule);
		 $Lc_limit_page = '';
		 ###End options

		 //print_r($myposts);
		 	 $ii = 0;
			 $jj=1;
		 foreach ($myposts as $post) {
			 $ii++;
			 $limit = $Lc_opt->Lc_limit();
             $limit_page = $jj;
			 if($ii == $limit) { $jj++; $ii = 0; }
			 $comment_count= Lc_get_post_count($post->ID);
			 $Lc_post_term_contents_{$limit_page} = $Lc_post_term_contents_{$limit_page}.'<li><a href="'.$Lc_opt->Lc_post_url($post->ID).'" title="'.Lc_EscapeESC($post->post_title).'" >'.$post->post_title.'</a> ('.str_replace('%s',$comment_count,__('Comments %s')).')</li>'."\n";
			 $Lc_post_term_url_{$limit_page} = $Lc_opt->Lc_archivers_url().'cat'.$vaule.'-'.$limit_page.'.html';
		 }
		 for($i=1;$i<=$limit_page;$i++){
			 $Lc_limit_page_r = '['.'<a href="'.$Lc_post_term_url_{$i}.'">'.$i.'</a>'.']'.' ';
			 $Lc_limit_page .= $Lc_limit_page_r;  
		 }
		 for($j=1;$j<=$limit_page;$j++){
			 $Lc_post_term_title = $Lc_post_term.'('.__('Pages').$j.')';
			 $Lc_post_term_url = $Lc_post_term_url_{$j};
             $Lc_limit_page =  $Lc_limit_page;
			 $Lc_post_term_contents = $Lc_post_term_contents_{$j};
             //print $Lc_post_term_contents."#";
				 ###Build html
				 $path_post_list_html  = Lc_GetPluginPath().'post_list.html';
				 $post_list_html = file_get_contents("$path_post_list_html");
				 $post_list_b = array('%Lc_title%', '%Lc_blog_name%', '%Lc_post_term_title%', '%Lc_post_term%', '%Lc_descriptions%', '%Lc_blog_home%', '%Lc_archivers_url%', '%Lc_post_term_url%', '%Lc_post_term_contents%', '%Lc_limit_page%', '%Lc_footnote%', '%Lc_post_term_permalink%', '%Lc_the_header%', '%Lc_the_footer%');
				 $post_list_a = array($Lc_title, $Lc_blog_name, $Lc_post_term_title, $Lc_post_term, $Lc_descriptions, $Lc_blog_home, $Lc_archivers_url, $Lc_post_term_url, $Lc_post_term_contents, $Lc_limit_page, $Lc_footnote, $Lc_post_term_permalink, $Lc_the_header, $Lc_the_footer);

					$post_list_html = str_replace($post_list_b,$post_list_a,$post_list_html);
					//echo $post_html;
					##file_put_contents
					$file_index = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog();
					$file_post_list_html = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog().'/cat'.$vaule.'-'.$j.'.html';;
					//echo $file_post_html;
					Lc_createFolders($file_index);
					if(Lc_IsFileWritable($file_index)){
						file_put_contents("$file_post_list_html","$post_list_html"); 						
						## Messages
						//Lc_archivers_topbarmessage(__('Congratulate, Cat','Lc_archivers'));
					}
		 }
	}
    ##post list for tag
	elseif($type == 'tag_list') {

		 $myposts = get_posts("tag=$vaule&numberposts=-1&post_status=publish&post_type=post"); 

		 ###options
		 $tag_id = Lc_get_cat_id($vaule);
		 $Lc_post_term = Lc_EscapeESC(Lc_get_tag_name($tag_id));
		 $Lc_title  = __('Tag Cloud');
		 $Lc_blog_name = Lc_EscapeESC(get_bloginfo('name'));
		 $Lc_descriptions = $Lc_opt->Lc_descriptions();
		 $Lc_blog_home = $Lc_opt->Lc_blog_home();
		 $Lc_archivers_url =  $Lc_opt->Lc_tag_index_url();
		 //$Lc_post_term_url = $Lc_opt->Lc_archivers_url().'tag'.$tag_id.'.html';
		 $Lc_footnote = $Lc_opt->Lc_footnote();
		 $Lc_post_term_permalink = get_tag_link($tag_id);
		 $Lc_limit_page = '';
		 ###End options

		 //print_r($myposts);
		 	 $ii = 0;
			 $jj=1;
		 foreach ($myposts as $post) {
			 $ii++;
			 $limit = $Lc_opt->Lc_limit();
             $limit_page = $jj;
			 if($ii == $limit) { $jj++; $ii = 0; }
			 $comment_count= Lc_get_post_count($post->ID);
			 $Lc_post_term_contents_{$limit_page} = $Lc_post_term_contents_{$limit_page}.'<li><a href="'.$Lc_opt->Lc_post_url($post->ID).'" title="'.Lc_EscapeESC($post->post_title).'" >'.$post->post_title.'</a> ('.str_replace('%s',$comment_count,__('Comments %s')).')</li>'."\n";
			 $Lc_post_term_url_{$limit_page} = $Lc_opt->Lc_archivers_url().'tag'.$tag_id.'-'.$limit_page.'.html';
		 }
		 for($i=1;$i<=$limit_page;$i++){
			 $Lc_limit_page_r = '['.'<a href="'.$Lc_post_term_url_{$i}.'">'.$i.'</a>'.']'.' ';
			 $Lc_limit_page .= $Lc_limit_page_r;  
		 }
		 for($j=1;$j <= $limit_page;$j++){
			 $Lc_post_term_title = $Lc_post_term.'('.__('Pages').$j.')';
			 $Lc_post_term_url = $Lc_post_term_url_{$j};
             $Lc_limit_page =  $Lc_limit_page;
			 $Lc_post_term_contents = $Lc_post_term_contents_{$j};

				 ###Build html
				 $path_post_list_html  = Lc_GetPluginPath().'post_list.html';
				 $post_list_html = file_get_contents("$path_post_list_html");
				 $post_list_b = array('%Lc_title%', '%Lc_blog_name%', '%Lc_post_term_title%', '%Lc_post_term%', '%Lc_descriptions%', '%Lc_blog_home%', '%Lc_archivers_url%', '%Lc_post_term_url%', '%Lc_post_term_contents%', '%Lc_limit_page%', '%Lc_footnote%', '%Lc_post_term_permalink%', '%Lc_the_header%', '%Lc_the_footer%');
				 $post_list_a = array($Lc_title, $Lc_blog_name, $Lc_post_term_title, $Lc_post_term, $Lc_descriptions, $Lc_blog_home, $Lc_archivers_url, $Lc_post_term_url, $Lc_post_term_contents, $Lc_limit_page, $Lc_footnote, $Lc_post_term_permalink, $Lc_the_header, $Lc_the_footer);

					$post_list_html = str_replace($post_list_b,$post_list_a,$post_list_html);
					//echo $post_html;
					##file_put_contents
					$file_index = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog();
					$file_post_list_html = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog().'/'.'tag'.$tag_id.'-'.$j.'.html';
					//echo $file_post_html;
					Lc_createFolders($file_index);
					if(Lc_IsFileWritable($file_index)){
						file_put_contents("$file_post_list_html","$post_list_html"); 						
						## Messages
						//Lc_archivers_topbarmessage(__('###########Congratulate, Tags','Lc_archivers'));
					}
		 }
	}
	##post list for all
	else {
	## Messages
	Lc_archivers_topbarmessage(__('Category not updated.'));
	}
}


###update the post
function update_the_post($post_ID){
	global $wpdb;

	$Lc_opt = new Lc_get_options;
	$Lc_the_header = Lc_REscape($Lc_opt->Lc_the_header());
	$Lc_the_footer = Lc_REscape($Lc_opt->Lc_the_footer());
	$Lc_post_ads_r = Lc_REscape($Lc_opt->Lc_post_ads_r());
	$Lc_archivers_url =  $Lc_opt->Lc_archivers_url();

	$sql_post = "SELECT ID, post_author, post_date, post_content, post_title, post_excerpt
		FROM $wpdb->posts
		WHERE ID = '$post_ID' 
				";
	$get_update_post = $wpdb->get_results($sql_post);
	//if(function_exists(wp_keywordlink_replace_content)) { echo "HI"; }
	if($get_update_post){
		foreach($get_update_post as $post) {
			$post_ID = $post->ID;
			$post_date = $post->post_date;
			$post_author = $Lc_opt->Lc_post_author($post->post_author);
			$post_content_r = $post->post_content;
			$post_content = Lc_EscapeHTML(strip_tags(($post->post_content),'<p> <a> <img> <h2> <h3> <b> <strong> <ol> <ul> <li>'));
			if(function_exists('wp_keywordlink_replace_content')) { $post_content = wp_keywordlink_replace_content($post_content); }
			##others plugin
			//Lc_others_plugin(content,$post_content);
			##end others plugin
			$Lc_post_title = Lc_EscapeESC($post->post_title);
			$post_excerpt = $post->post_excerpt;
			$Lc_post_p = str_replace(array('%1$s','%2$s','%3$s'), array($post_author, $post_date, ""), __('From <strong>%1$s</strong> on %2$s %3$s'));
		}
		##post url
		if($post_ID) {
			$Lc_post_url = $Lc_opt->Lc_post_url($post_ID);
			$Lc_post_permalink = get_permalink($post_ID);
		}
			
		##post descriptions
		if($post_excerpt){
			$Lc_post_descriptions = Lc_utf8Substr(Lc_EscapeESC($post_excerpt),0,180);
		} else {
            $Lc_post_descriptions = Lc_utf8Substr(trim(Lc_EscapeESC(strip_tags($post_content_r))),0,180);
		}
	}
     
	###post comments
	$sql_comments = "SELECT comment_ID, comment_author, comment_date, comment_content
	                 FROM $wpdb->comments
					 WHERE comment_post_ID = '$post_ID'
					 AND comment_approved = '1'
					 ORDER BY comment_ID
					 ";
	$get_comments = $wpdb->get_results($sql_comments);
	$Lc_comments = '';
	if($get_comments){
		foreach($get_comments as $comments) {
			$comments_p = str_replace(array('%1$s','%2$s','%3$s'), array("$comments->comment_author", "$comments->comment_date", ""), __('From <strong>%1$s</strong> on %2$s %3$s'));
			$Lc_comments = $Lc_comments.'<p class="author">'.$comments_p.'</p>'."\n".$comments->comment_content."\n";
		} 
					//echo $Lc_comments;
	} 
    
    ###post category 
	$category = get_the_category($post_ID); 
	$last_category = array_pop($category);
    $Lc_post_cat= $last_category->cat_name;
	$Lc_post_cat_url = $Lc_opt->Lc_term_url($last_category->cat_ID);

    ###post tags
	$Lc_post_tag ='';
	$Lc_post_tag_k ='';
	if($get_the_tags = get_the_tags($id = $post_ID)) {
		foreach($get_the_tags as $tag) {
			#$Lc_post_tag = $Lc_post_tag.'<a href="'.$Lc_archivers_url.'tag'.$tag->term_id.'-1.html" title="'.Lc_EscapeESC($tag->name).'">'.$tag->name.'</a>'.", "; 去除标签list
			$Lc_post_tag = $Lc_post_tag.'<a href="'.get_tag_link($tag->term_id).'" title="'.Lc_EscapeESC($tag->name).'">'.$tag->name.'</a>'.", ";
		}
		$Lc_post_tag = rtrim($Lc_post_tag,', '); 
		$Lc_post_tag_k = strip_tags($Lc_post_tag);
	}

	     ###~
		 $path_index_html  = Lc_GetPluginPath().'post.html';
		 $post_html = file_get_contents("$path_index_html");
		 $post_b = array('%Lc_title%', '%Lc_blog_home%', '%Lc_blog_name%', '%Lc_post_title%', '%Lc_post_tag_k%', '%Lc_post_descriptions%', '%Lc_archivers_url%', '%Lc_post_url%', '%Lc_post_p%', '%Lc_post_content%', '%Lc_footnote%', '%Lc_post_permalink%', '%Lc_comments%', '%Lc_post_tag%', '%Lc_the_header%', '%Lc_the_footer%', '%Lc_post_ads_r%','%Lc_post_cat%','%Lc_post_cat_url%');
		 $post_a = array($Lc_opt->Lc_title(), $Lc_opt->Lc_blog_home(), $Lc_opt->Lc_blog_name(), $Lc_post_title, $Lc_post_tag_k, $Lc_post_descriptions, $Lc_opt->Lc_archivers_url(), $Lc_post_url, $Lc_post_p, $post_content, $Lc_opt->Lc_footnote(), $Lc_post_permalink, $Lc_comments, $Lc_post_tag, $Lc_the_header, $Lc_the_footer, $Lc_post_ads_r,$Lc_post_cat,$Lc_post_cat_url);

			$post_html = str_replace($post_b,$post_a,$post_html);
            //echo $post_html;
			##file_put_contents
            $file_index = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog();
			$file_post_html = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog().'/p'.$post_ID.'.html';
			//echo $file_post_html;
			Lc_createFolders($file_index);
			if(Lc_IsFileWritable($file_index)){
				file_put_contents("$file_post_html","$post_html"); 						
				## Messages
				//Lc_archivers_topbarmessage(__('Congratulate, Post','Lc_archivers'));
			}			
}


###update if ~
function Lc_update_all() {
	global $wpdb;
	//$lastupdate = '1';
	$sql = "SELECT DISTINCT ID
		FROM $wpdb->posts
		LEFT JOIN $wpdb->comments ON ( $wpdb->posts.ID = $wpdb->comments.comment_post_ID ) 
		WHERE post_password = ''
		AND post_type = 'post'
		AND post_status = 'publish'
		ORDER BY post_date DESC 
		";
	$update_ID = $wpdb->get_results($sql);
	if($update_ID) {
			foreach($update_ID as $post) {
				//echo $post->ID;
				###update the post
                update_the_post($post->ID);
			}
		## Messages
		Lc_archivers_topbarmessage(__('Post updated.'));

			###update index
            archivers_index_build();

			###update post list
			//cat
	       $sql_category_id = "SELECT $wpdb->terms.term_id as cat_ID
 		 		              FROM $wpdb->terms
 		 		              JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
 		 		              WHERE taxonomy = 'category'
 		 		              ";
 		 	$category_ids = $wpdb->get_results($sql_category_id);
            //$category_ids = get_all_category_ids();
		if($category_ids){
			foreach($category_ids as $cat_id) {
				//echo Lc_get_term_count($cat_id);
				if(Lc_get_term_count($cat_id->cat_ID)){
			       update_the_post_list('cat_list',$cat_id->cat_ID);
				}
			}
		}
		## Messages
		Lc_archivers_topbarmessage(__('Category updated.'));

			//tags 去除标签list的更新
          /*  $sql_tag ="SELECT slug
 		 		 FROM $wpdb->terms
 		 		 JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
 		 		 WHERE taxonomy = 'post_tag'
 		 		 ";
      	    $mytag_ids = $wpdb->get_results($sql_tag);
      	    if($mytag_ids){
      		    foreach($mytag_ids as $tag){
				   $tag_id = Lc_get_cat_id($tag->slug);
				   if(Lc_get_term_count($tag_id)){
				       update_the_post_list('tag_list',$tag->slug);
				   }
      		    }
      	    }
		 ## Messages
		 Lc_archivers_topbarmessage(__('Tag updated.'));*/

		} else {
				Lc_archivers_topbarmessage(__('Published'));        
		}
	update_Lc_last();
	if(function_exists('wp_clear_scheduled_hook')) { wp_clear_scheduled_hook('do_Lc_auto'); }
    Lc_archivers_is_auto(); 
	Lc_archivers_topbarmessage(__('All done.').__('Have fun!')); 
}

function Lc_update() {
	global $wpdb, $post;
	$get_Lc_last = get_option(LC_ARCHIVERS_LAST);
	//$get_Lc_last = '2009-09-14 08:40:00';
	if($get_Lc_last) {
		$lastupdate = $get_Lc_last;
		$sql = "SELECT DISTINCT ID
			FROM $wpdb->posts
			LEFT JOIN $wpdb->comments ON ( $wpdb->posts.ID = $wpdb->comments.comment_post_ID ) 
			WHERE post_password = ''
			AND post_type = 'post'
			AND post_status = 'publish'
			AND ( post_date > '$lastupdate'
			OR post_modified > '$lastupdate'
			OR comment_date > '$lastupdate' )
			ORDER BY post_date DESC 
			";
		$update_ID = $wpdb->get_results($sql);
		if($update_ID) {
			foreach($update_ID as $post) {
				$post_ID = $post->ID;
				###update the post
				update_the_post($post->ID);
				###update post list
				//cat
				if(get_the_category($post->ID)){
					 foreach(get_the_category($post->ID) as $category) { 
						//echo Lc_get_term_count($cat_id);
						update_the_post_list('cat_list',$category->cat_ID);
					}
				}
				//tags
				if(get_the_tags($post_ID)){
					foreach(get_the_tags($post_ID) as $tag) {
						//echo "Hi";
						//print_r ($tag);
						update_the_post_list('tag_list',$tag->slug);
					 }
				}
			}
			## Messages
			Lc_archivers_topbarmessage(__('Post updated.'));

			## Messages
			Lc_archivers_topbarmessage(__('Category updated.'));

			 ## Messages
			 Lc_archivers_topbarmessage(__('Tag updated.'));

			###update index
			archivers_index_build();
		} else {
				###update index
			    //archivers_index_build();
				Lc_archivers_topbarmessage(str_replace('%s','',__('%s page updated.')));        
			}
	}
	update_Lc_last();
	if(function_exists('wp_clear_scheduled_hook')) { wp_clear_scheduled_hook('do_Lc_auto'); }
	if(function_exists('wp_clear_scheduled_hook')) { wp_clear_scheduled_hook('do_Lc_auto_2');}
    Lc_archivers_is_auto(); 
	Lc_archivers_topbarmessage(__('All done.').__('Have fun!')); 
}

Lc_archivers_is_auto();
?>