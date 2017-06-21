<?php
/*
*@author arnee
*google-sitemap-generator
*/
#region PHP5 compat functions
if (!function_exists('file_get_contents')) {
	/**
	 * Replace file_get_contents()
	 *
	 * @category    PHP
	 * @package     PHP_Compat
	 * @link        http://php.net/function.file_get_contents
	 * @author      Aidan Lister <aidan - php - net>
	 * @version     $Revision: 1.21 $
	 * @internal    resource_context is not supported
	 * @since       PHP 5
	 */
	function file_get_contents($filename, $incpath = false, $resource_context = null) {
		if (false === $fh = fopen($filename, 'rb', $incpath)) {
			user_error('file_get_contents() failed to open stream: No such file or directory', E_USER_WARNING);
			return false;
		}
		
		clearstatcache();
		if ($fsize = @filesize($filename)) {
			$data = fread($fh, $fsize);
		} else {
			$data = '';
			while (!feof($fh)) {
				$data .= fread($fh, 8192);
			}
		}
		
		fclose($fh);
		return $data;
	}
}


if(!function_exists('file_put_contents')) {
	
	if (!defined('FILE_USE_INCLUDE_PATH')) {
		define('FILE_USE_INCLUDE_PATH', 1);
	}
	
	if (!defined('LOCK_EX')) {
		define('LOCK_EX', 2);
	}
	
	if (!defined('FILE_APPEND')) {
		define('FILE_APPEND', 8);
	}
	
	
	/**
	 * Replace file_put_contents()
	 *
	 * @category    PHP
	 * @package     PHP_Compat
	 * @link        http://php.net/function.file_put_contents
	 * @author      Aidan Lister <aidan - php - net>
	 * @version     $Revision: 1.25 $
	 * @internal    resource_context is not supported
	 * @since       PHP 5
	 * @require     PHP 4.0.0 (user_error)
	 */
	function file_put_contents($filename, $content, $flags = null, $resource_context = null) {
		// If $content is an array, convert it to a string
		if (is_array($content)) {
			$content = implode('', $content);
		}
		
		// If we don't have a string, throw an error
		if (!is_scalar($content)) {
			user_error('file_put_contents() The 2nd parameter should be either a string or an array',E_USER_WARNING);
			return false;
		}
		
		// Get the length of data to write
		$length = strlen($content);
		
		// Check what mode we are using
		$mode = ($flags & FILE_APPEND)?'a':'wb';
		
		// Check if we're using the include path
		$use_inc_path = ($flags & FILE_USE_INCLUDE_PATH)?true:false;
		
		// Open the file for writing
		if (($fh = @fopen($filename, $mode, $use_inc_path)) === false) {
			user_error('file_put_contents() failed to open stream: Permission denied',E_USER_WARNING);
			return false;
		}
		
		// Attempt to get an exclusive lock
		$use_lock = ($flags & LOCK_EX) ? true : false ;
		if ($use_lock === true) {
			if (!flock($fh, LOCK_EX)) {
				return false;
			}
		}
		
		// Write to the file
		$bytes = 0;
		if (($bytes = @fwrite($fh, $content)) === false) {
			$errormsg = sprintf('file_put_contents() Failed to write %d bytes to %s',$length,$filename);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
		
		// Close the handle
		@fclose($fh);
		
		// Check all the data was written
		if ($bytes != $length) {
			$errormsg = sprintf('file_put_contents() Only %d of %d bytes written, possibly out of free disk space.',$bytes,$length);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
		
		// Return length
		return $bytes;
	}
	
}
#endregion

/*
*@author arnee
*google-sitemap-generator
*/
if(!function_exists('Lc_GetHomePath()')) {
  function Lc_GetHomePath() {
	
	$res="";
	//Check if we are in the admin area -> get_home_path() is avaiable
	if(function_exists("get_home_path")) {
		$res = get_home_path();
	} else {
		//get_home_path() is not available, but we can't include the admin
		//libraries because many plugins check for the "check_admin_referer"
		//function to detect if you are on an admin page. So we have to copy
		//the get_home_path function in our own...
		$home = get_option( 'home' );
		if ( $home != '' && $home != get_option( 'siteurl' ) ) {
			$home_path = parse_url( $home );
			$home_path = $home_path['path'];
			$root = str_replace( $_SERVER["PHP_SELF"], '', $_SERVER["SCRIPT_FILENAME"] );
			$home_path = trailingslashit( $root.$home_path );
		} else {
			$home_path = ABSPATH;
		}

		$res = $home_path;
	}
	return $res;
  }
}

/**
 * Checks if a file is writable and tries to make it if not.
 *
 * @since 3.05b
 * @access private
 * @author  VJTD3 <http://www.VJTD3.com>
 * @return bool true if writable
 */
function Lc_IsFileWritable($filename) {
	//can we write?
	if(!is_writable($filename)) {
		//no we can't.
		if(!@chmod($filename, 0666)) {
			$pathtofilename = dirname($filename);
			//Lets check if parent directory is writable.
			if(!is_writable($pathtofilename)) {
				//it's not writeable too.
				if(!@chmod($pathtoffilename, 0666)) {
					//darn couldn't fix up parrent directory this hosting is foobar.
					//Lets error because of the permissions problems.
					return false;
				}
			}
		}
	}
	//we can write, return 1/true/happy dance.
	return true;
}

/**
 * Returns the path to the directory where the plugin file is located
 * @since 3.0b5
 * @access private
 * @author Arne Brachhold
 * @return string The path to the plugin directory
 */
function Lc_GetPluginPath() {
	$path = dirname(__FILE__);
	return trailingslashit(str_replace("\\","/",$path));
}


/**
 * Returns the URL to the directory where the plugin file is located
 * @since 3.0b5
 * @access private
 * @author Arne Brachhold
 * @return string The URL to the plugin directory
 */
function Lc_GetPluginUrl() {
	
	//Try to use WP API if possible, introduced in WP 2.6
	if (function_exists('plugins_url')) return trailingslashit(plugins_url(basename(dirname(__FILE__))));
	
	//Try to find manually... can't work if wp-content was renamed or is redirected
	$path = dirname(__FILE__);
	$path = str_replace("\\","/",$path);
	$path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
	return $path;
}


//directory   
function Lc_createFolders($path) {    
    if (!file_exists($path))  
    {   
        Lc_createFolders(dirname($path));  
        mkdir($path,0777);   
    }   
}  

function Lc_IsWritable() {
	$Lc_opt = new Lc_get_options;
	$filename_home = Lc_GetHomePath();
	$Lc_archivers_index = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog();
	$filename_index = $Lc_archivers_index.'/'.'index.html';
	if(!file_exists($filename_index) && !is_writable($filename_home)) { Lc_archivers_topbarmessage(str_replace('%s',$filename_home,__('Warning: chmod root directory %s to 777','Lc_archivers')));}
	if(file_exists($Lc_archivers_index) && !is_writable($Lc_archivers_index)) { Lc_archivers_topbarmessage(str_replace('%s',$Lc_archivers_index,__('Warning: chmod root directory %s to 777','Lc_archivers')));}
}

function delDirAndFile()
{
	$Lc_opt = new Lc_get_options;
	$Lc_archivers_catalog = $Lc_opt->Lc_archivers_catalog();
	$dirName = Lc_GetHomePath().$Lc_archivers_catalog;
  if ( $handle = opendir( "$dirName" ) ) {
   while ( false !== ( $item = readdir( $handle ) ) ) {
     if ( $item != "." && $item != ".." ) {
       if ( is_dir( "$dirName/$item" ) ) {
         delDirAndFile( "$dirName/$item" );
       } else {
         if( unlink( "$dirName/$item" ) ) _e('Delete')._e('File'); echo "£º $dirName/$item<br />\n";
       }
     }
   }
   closedir( $handle );
   if( rmdir( $dirName ) ) _e('DelTree Succeed:'); echo " $dirName<br />\n";
  }
}


function Lc_get_archivers_link(){
	 $Lc_archivers_catalog = 'archivers';
	 $Lc_get_archivers_link = get_bloginfo('url').'/'.$Lc_archivers_catalog.'/';
	 return $Lc_get_archivers_link;
}


/* Display tag cloud.
*
* Modify by Lc., 2009-8-27 
*/
function Lc_wp_tag_cloud( $args = '' ) {
	$Lc_opt = new Lc_get_options;
	$Lc_archivers_url =  $Lc_opt->Lc_archivers_url();

    $defaults = array(
        'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
        'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
        'exclude' => '', 'include' => '', 'link' => 'view', 'taxonomy' => 'post_tag', 'echo' => true
    );
    $args = wp_parse_args( $args, $defaults );

    $tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags

    if ( empty( $tags ) )
        return;

    foreach ( $tags as $key => $tag ) {
        if ( 'Lc_tag_url' == $args['link'] )
            $link = $Lc_archivers_url.'tag'.$tag->term_id.'-1.html';
        else
            $link = get_term_link( intval($tag->term_id), $args['taxonomy'] );
        if ( is_wp_error( $link ) )
            return false;

        $tags[ $key ]->link = $link;
        $tags[ $key ]->id = $tag->term_id;
    }

    $return = wp_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args

    $return = apply_filters( 'wp_tag_cloud', $return, $args );

    if ( 'array' == $args['format'] || empty($args['echo']) )
        return $return;

    echo $return;
}


/*
*@Lc.
*2009-08-27
*/
function Lc_EscapeESC($string) {
	return str_replace ( array ( '&', '"', "'", '<', '>'), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;'), $string);
}

/*
*@Lc.
*2009-09-02
*/
function Lc_EscapeHTML($string) {
	$string = str_replace ( "\n", '<br />', $string);
	return preg_replace ( array ( '/<img(.*?)>/i' ), array ( '&lt;img$1&gt;' ), $string);
}

function Lc_Escape($string) {
	return str_replace ( array ( '<', '>'), array ( '&lt;' , '&gt;'), $string);
}
function Lc_REscape($string) {
	return str_replace ( array ( '&lt;', '&gt;'), array ( '<' , '>'), $string);
}
function Lc_Escape_v($string) {
	return str_replace ( '|', '&#;', $string);
}
function Lc_REscape_v($string) {
	return str_replace ( '&#;', '|', $string);
}

##get post count
if ( !function_exists( 'Lc_get_post_count' ) ) {
 function Lc_get_post_count($post_id) {
	 global $wpdb;
      $sql ="SELECT comment_count
	         From $wpdb->posts
			 where ID = '$post_id'";
	  $mycount = $wpdb->get_results($sql);
	  if($mycount){
		  foreach($mycount as $count){
			  $Lc_get_post_count = $count->comment_count;
		  }
	  }
      return $Lc_get_post_count;
  }
}

if ( !function_exists( 'Lc_get_tag_name' ) ) {
 function Lc_get_tag_name($tag_id) {
	 global $wpdb;
      $sql ="SELECT name
	         From $wpdb->terms
			 where term_id = '$tag_id'";
	  $mytags = $wpdb->get_results($sql);
	  if($mytags){
		  foreach($mytags as $tag){
			  $Lc_get_tag_name = $tag->name;
		  }
	  }
      return $Lc_get_tag_name;
  }
}

if ( !function_exists( 'Lc_get_cat_slug' ) ) {
 function Lc_get_cat_slug($cat_id) {
	 global $wpdb;
      $sql ="SELECT slug
	         From $wpdb->terms
			 where term_id = '$cat_id'";
	  $mycats = $wpdb->get_results($sql);
	  if($mycats){
		  foreach($mycats as $cat){
			  $Lc_get_cat_slug = $cat->slug;
		  }
	  }
      return $Lc_get_cat_slug;
  }
}

if ( !function_exists( 'Lc_get_cat_id' ) ) {
 function Lc_get_cat_id($cat_slug) {
	 global $wpdb;
      $sql ="SELECT term_id
	         From $wpdb->terms
			 where slug = '$cat_slug'";
	  $mycats = $wpdb->get_results($sql);
	  if($mycats){
		  foreach($mycats as $cat){
			  $Lc_get_cat_id = $cat->term_id;
		  }
	  }
      return $Lc_get_cat_id;
  }
}

if ( !function_exists( 'Lc_get_term_count' ) ) {
 function Lc_get_term_count($id) {
	 global $wpdb;
		  $sql ="SELECT count
				 From $wpdb->term_taxonomy
				 where term_id = '$id'";
		  $mycounts = $wpdb->get_results($sql);
		  if($mycounts){
			  foreach($mycounts as $mycount){
				  $Lc_get_term_count = $mycount->count;
			  }
		  }
		  return $Lc_get_term_count;
  }
}

//meessage
function Lc_rebuild_message() {
				if(function_exists("wp_next_scheduled")) {
					$next = wp_next_scheduled('do_Lc_auto');
					if($next) {
						$diff = (time()-$next)*-1;
						if($diff <= 0) {
							//$diffMsg = __('Your sitemap is being refreshed at the moment. Depending on your Post Count this might take some time!','Lc_archivers');
							$diffMsg = '';
						} else {
							//$diffMsg = str_replace("%s",$diff,__('Your sitemap will be refreshed in %s seconds!','Lc_archivers'));
							$diffMsg = '';
						}

					}else{
							$diffMsg = __('Donot activate the Auto build , you need build the HTML file by yourself.','Lc_archivers');
					}
					echo "<strong><p>$diffMsg</p></strong>";	
				}
}


function index_exist() {
    $Lc_opt = new Lc_get_options;
	$Lc_archivers_index = Lc_GetHomePath().$Lc_opt->Lc_archivers_catalog();
    $Lc_archivers_index_url = $Lc_opt->Lc_archivers_url();
	$filename = $Lc_archivers_index.'/'.'index.html';
    if(file_exists($filename)){
	?>
				<a name="Lc_archivers_del"></a><form name="Lc_archivers_del" method="post" action="">
				<input type="hidden" name="action" value="del_html" />
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Delete')._e('All');; ?>" /></p>
				</form>
	<?php
		$filemtime=date("Y-m-d H:i:s",filemtime("$filename")); 
		$nextmtime = date("Y-m-d H:i:s",filemtime("$filename") + $Lc_opt->Lc_updatePeri()*60*60); 
		echo '<p>'; echo '<a href="'.$Lc_archivers_index_url.'" target="_blank">'.$Lc_archivers_index_url.'</a></p>';
		echo '<p>'; _e('Last Updated:'); print $filemtime.';  '; if( $Lc_opt->Lc_archivers_auto() == '1') { _e('Next Updated:','Lc_archivers'); print $nextmtime.'</p>'; }
		echo '<p>'; _e('You can add a link in Homepage footer or Anywhere you want.','Lc_archivers'); print '</p>';
	} 
	Lc_rebuild_message();
}


/*function Lc_others_plugin_exist() {
	print "<p><b>Current Plugins:</b></p>";
	##WP keyWord Link
	if(function_exists('wp_keywordlink_replace_content')) { print "WP keyWord Link;"; }
	//elseif() { }
	else { _e('No plugins match your request.'); }
}

function Lc_others_plugin($type,$value){
	if($type == 'content') {
		##WP keyWord Link
		if(function_exists('wp_keywordlink_replace_content')) { return wp_keywordlink_replace_content($value); }
	}

}*/

/*
*
*Un-quotes quoted string\
*/
if (!function_exists('stripslashes_deep')) {
	function stripslashes_deep($value)
	{
		$value = is_array($value) ?
					array_map('stripslashes_deep', $value) :
					stripslashes($value);

		return $value;
	}
}


//utf-8, substr
function Lc_utf8Substr($str, $from, $len)
{
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str);
}

###get the options
class Lc_get_options {
        var $_opt= array();

	function Lc_archivers_catalog() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			$this->_opt["Lc_archivers_catalog"] = $Lc_archivers_f;
		} else {
            $this->_opt["Lc_archivers_catalog"] = 'archivers';
		}
		   return $this->_opt["Lc_archivers_catalog"];
	}
	function Lc_title() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			$this->_opt["Lc_title"] = $Lc_title;
		}else{
			$this->_opt["Lc_title"] = __('Archivers','Lc_archivers');
		}
		return $this->_opt["Lc_title"];
	}
	function Lc_descriptions() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			$this->_opt["Lc_descriptions"] = $Lc_archivers_d;
		}else{
			$this->_opt["Lc_descriptions"] = '';
		}
		return Lc_EscapeESC($this->_opt["Lc_descriptions"]);
	}
	function Lc_keywords() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r) = explode("|",$get_Lc_options);
			$this->_opt["Lc_keywords"] = $Lc_archivers_k;
		}else{
			$this->_opt["Lc_keywords"] = '';
		}
		return Lc_EscapeESC($this->_opt["Lc_keywords"]);
	}
	function Lc_archivers_url() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
		}
		if($Lc_archivers_url){
            return $this->_opt["Lc_archivers_url"] = $Lc_archivers_url;
		} else {
		    return $this->_opt["Lc_archivers_url"] = get_bloginfo('url').'/'.$this->Lc_archivers_catalog().'/';
		}
	}
	function Lc_tag_index_url() {
		return $this->_opt["Lc_tag_index_url"] = $this->_opt["Lc_archivers_url"].'tag.html';
	}
	function Lc_footnote() {
		return $this->_opt["Lc_footnote"] = __('The Full Version:','Lc_archivers');
	}
	function Lc_blog_name() {
		return $this->_opt["Lc_blog_name"] = get_bloginfo('name');
	}
	function Lc_blog_home() {
		return $this->_opt["Lc_blog_home"] = get_bloginfo('url').'/';
	}
	function Lc_post_url($post_ID) {
		return $this->_opt["Lc_post_url"] = $this->Lc_archivers_url().'p'.$post_ID.'.html';
	}
	function Lc_term_url($cat_ID) {
		return $this->_opt["Lc_term_url"] = $this->Lc_archivers_url().'cat'.$cat_ID.'-1.html';
	}
	function Lc_post_author($user_ID) {
		$user_info = get_userdata($user_ID);
		return $this->_opt["Lc_post_author"] = $user_info->display_name;
	}
	function Lc_limit() {
		return $this->_opt["Lc_limit"] = '100';
	}
	function Lc_archivers_auto() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
			$this->_opt["Lc_archivers_auto"] = $Lc_archivers_auto;
		}else{
			$this->_opt["Lc_archivers_auto"] = '0';
		}
		return $this->_opt["Lc_archivers_auto"];
	}
	function Lc_updatePeri() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
			$this->_opt["Lc_updatePeri"] = $Lc_updatePeri;
		}else{
			$this->_opt["Lc_updatePeri"] = '10';
		}
		return $this->_opt["Lc_updatePeri"];
	}
	function Lc_the_header() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
			$this->_opt["Lc_the_header"] = Lc_REscape_v(stripslashes_deep($Lc_the_header));
		}else{
			$this->_opt["Lc_the_header"] = '';
		}
		return $this->_opt["Lc_the_header"];
	}
	function Lc_the_footer() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
			$this->_opt["Lc_the_footer"] = Lc_REscape_v(stripslashes_deep($Lc_the_footer));
		}else{
			$this->_opt["Lc_the_footer"] = '&copy;'.get_bloginfo('name');
		}
		return $this->_opt["Lc_the_footer"];
	}
	function Lc_post_ads_r() {
		$get_Lc_options = get_option(LC_ARCHIVERS_OPTION);
	    if(!empty($get_Lc_options)){
		    list($Lc_archivers_f,$Lc_archivers_k,$Lc_archivers_d,$Lc_updatePeri,$Lc_title,$Lc_archivers_auto,$Lc_the_header,$Lc_the_footer,$Lc_post_ads_r,$Lc_archivers_url) = explode("|",$get_Lc_options);
			$this->_opt["Lc_post_ads_r"] = Lc_REscape_v(stripslashes_deep($Lc_post_ads_r));
		}else{
			$this->_opt["Lc_post_ads_r"] = '';
		}
		return $this->_opt["Lc_post_ads_r"];
	}
}

##add at blog
function Lc_Archivers_Link(){
	$Lc_Advanced_Settings = get_option(Lc_Advanced_Settings);
	if($Lc_Advanced_Settings){ $Lc_archivers_link = $Lc_Advanced_Settings;} else { $Lc_archivers_link = 'Lc.Archivers'; }
	$Lc_opt = new Lc_get_options;
	$Lc_archivers_url = $Lc_opt->Lc_archivers_url();
	$Lc_archivers_catalog = $Lc_opt->Lc_archivers_catalog();
    $file_index = Lc_GetHomePath().$Lc_archivers_catalog;
	$post_html = $file_index.'/p'.get_the_ID().'.html';
	//echo $file_index."\n".$post_html;
     //get_the_ID();
	 if(file_exists($post_html)){ echo "<a href='".$Lc_archivers_url.'p'.get_the_ID().".html' title='".str_replace('%s', 'Lc.Archivers', __('View posts By %s','Lc_archivers'))."' target='_blank'>".$Lc_archivers_link."</a>"; }
}
?>