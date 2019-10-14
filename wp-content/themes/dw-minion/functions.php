<?php
if ( !isset( $content_width ) )
	$content_width = 620;

if ( !function_exists( 'dw_minion_setup' ) ) {
	function dw_minion_setup() {
		load_theme_textdomain( 'dw-minion', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'quote', 'link' ) );
		add_theme_support( 'post-thumbnails' );
		add_editor_style();
	}
}
add_action( 'after_setup_theme', 'dw_minion_setup' );

function dw_minion_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'dw-minion' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'dw-minion' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
        'name' => __( 'Top Sidebar', 'dw-minion' ),
        'id' => 'top-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'dw_minion_widgets_init' );

function dw_minion_scripts() {
	wp_enqueue_style('dw-minion-main', get_template_directory_uri() . '/assets/css/main.css' ); // green
	wp_enqueue_style( 'dw-minion-style', get_stylesheet_uri() );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.6.2.min.js' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'dw-minion-main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), false, true );
	wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/assets/js/bootstrap-transition.js', array('jquery'), false, true );
	wp_enqueue_script( 'bootstrap-carousel', get_template_directory_uri() . '/assets/js/bootstrap-carousel.js', array('jquery'), false, true );
	wp_enqueue_script( 'bootstrap-collapse', get_template_directory_uri() . '/assets/js/bootstrap-collapse.js', array('jquery'), false, true );
	wp_enqueue_script( 'bootstrap-tab', get_template_directory_uri() . '/assets/js/bootstrap-tab.js', array('jquery'), false, true );
}
add_action( 'wp_enqueue_scripts', 'dw_minion_scripts' );

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/customizer.php';

//随机文章挂件
class RandomPostWidget extends WP_Widget
{
	function RandomPostWidget()
	{
		parent::WP_Widget('bd_random_post_widget', '随机文章', array('description' =>  '我的随机文章小工具') );
	}

	function widget($args, $instance)
	{
		extract( $args );

		$title = apply_filters('widget_title',empty($instance['title']) ? '随机文章' :
				$instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
		{
			$number = 10;
		}

		$r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true,
				'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' =>'rand'));
		if ($r->have_posts())
		{
			echo "\n";
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			?>
    		<ul class="line">
				<?php  while ($r->have_posts()) : $r->the_post(); ?>
					<li>
						<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> - <?php getPostViews(get_the_ID()); ?> views</a>
					</li>   
    			<?php endwhile; ?>   
    		</ul><?php   
                echo $after_widget;   
                wp_reset_postdata();   
            }   
        }   
        
        function update($new_instance, $old_instance)   
        {   
            $instance = $old_instance;   
            $instance['title'] = strip_tags($new_instance['title']);   
            $instance['number'] = (int) $new_instance['number'];   
            return $instance;   
        }   
        
        function form($instance)   
        {   
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';   
            $number = isset($instance['number']) ? absint($instance['number']) : 10;?>   
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>   
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>   
        
            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to    
    show:'); ?></label>   
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>   
    <?php   
        }   
        
    }   
add_action('widgets_init', create_function('', 'return register_widget("RandomPostWidget");'));



// features image on social share
add_action('wp_head', 'minion_features_image_as_og_image');
function minion_features_image_as_og_image() {
    global $post;
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium'); 
    ?><meta property="og:image" content="<?php echo $thumb[0] ?>" /><?php
}

// load style for dw qa plugin
if( !function_exists('dwqa_minion_scripts') ){
    function dwqa_minion_scripts(){
        wp_enqueue_style( 'dw-minion-qa', get_stylesheet_directory_uri() . '/dwqa-templates/style.css' );
    }
    add_action( 'wp_enqueue_scripts', 'dwqa_minion_scripts' );
}

/**
 * 百度主动推送
 *
 */
function baidu_push_initiative($post_ID){
    global $post;
    if(function_exists('curl_init') ){//判断下是否开启了curl扩展
        $wpabcd_tuisong_site = 'www.binsky.net';
        $wpabcd_tuisong_token = 'UGmGf8nllBKcqzli';
        if (empty($post_ID) || empty($wpabcd_tuisong_site) || empty($wpabcd_tuisong_token)) {
            return;
        }
        $api = 'https://data.zz.baidu.com/urls?site='.$wpabcd_tuisong_site.'&token='.$wpabcd_tuisong_token;//百度官方的api
        if( $post->post_status = "publish" ) {//仅限已发布的文章
            $url = get_permalink($post_ID);
            $ch = curl_init();
            $options =  array(
                CURLOPT_URL => $api,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $url,
                CURLOPT_HTTPHEADER => array('Content-Type: text/plain')
            );
            curl_setopt_array($ch, $options);
        }
    }
}
add_action('publish_post', 'baidu_push_initiative', 0);

// Top sidebar
add_action( 'dw_minion_top_sidebar', 'dw_minion_top_sidebar' );
function dw_minion_top_sidebar() {
    ?><div class="top-sidebar"><?php dynamic_sidebar( 'top-sidebar' ); ?></div><?php
}

// TGM plugin activation
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
function alx_plugins() {
    $plugins = array(
        array(
            'name'              => 'DW Question & Answer',
            'slug'              => 'dw-question-answer',
            'source'            => false,
            'required'          => false,
            'force_activation' 	=> false,
            'force_deactivation'=> false,
            ),
        array(
            'name'              => 'Contact Form 7',
            'slug'              => 'contact-form-7',
            'required'          => false,
            'force_activation' 	=> false,
            'force_deactivation'=> false,
            )
	);
    
    tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'alx_plugins' );

/**
 * 查看文章点击数
 *
 */
function getPostViews($post_id){
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        $count = '0';
    }
    echo number_format_i18n($count);
}

function setPostViews($post_id) {
    global $post;
    $post_id = $post -> ID;
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count==''){
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        update_post_meta($post_id, $count_key, $count);
    }
}
add_action('get_header', 'setPostViews');

/**
 * 百度自动推送
 *
 */
//add_action( 'wp_footer', 'bdPushData', 999);
//检查百度是否已收录最新改进版本
if(!function_exists('baidu_check_record')){
    function baidu_check_record($url){
        global $wpdb;
        $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
        $baidu_record  = get_post_meta($post_id,'baidu_record',true);
        if( $baidu_record != 1){
            $url='https://www.baidu.com/s?wd='.$url;
            $curl=curl_init();
            curl_setopt($curl,CURLOPT_URL,$url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            $rs=curl_exec($curl);
            curl_close($curl);
            //如果抓取到的百度结果中不存在【提交网址】这个关键词，则认为该页面已被百度收录
            if (!preg_match_all('/提交网址/u',$rs,$matches) && preg_match_all('/百度为您找到相关结果/u',$rs, $matches)) {
                update_post_meta($post_id, 'baidu_record', 1) || add_post_meta($post_id, 'baidu_record', 1, true);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }
}

function baidu_record() {
    if(baidu_check_record(get_permalink()) == 1) {
        echo '<a target="_blank" title="点击查看" rel="external nofollow" href="https://www.baidu.com/s?wd='.get_the_title().'">百度已收录</a>';
    } else {
        echo '<a style="color:red;" rel="external nofollow" title="点击提交，谢谢您！" target="_blank" href="https://zhanzhang.baidu.com/sitesubmit/index?sitename='.get_permalink().'">百度未收录</a>';
        baidu_push_initiative(get_the_ID());
    }
}

/**
 * 首页截取长度设置为200
 *
 */
function custom_excerpt_length( $length ) {
    return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * 首页显示缩略图，或者bing随机图片
 *
 */
function thumb_img($soContent){
    $soImages = '~<img [^\>]*\ />~';
    preg_match_all( $soImages, $soContent, $thePics );
    $allPics = count($thePics[0]);
    $pic;
    $date;
    if( $allPics > 0 ){
        // 文章中有图片，显示图片
	echo "<span id='thumb'>";
	echo $thePics[0][0];
	echo '</span>';
    } else {
        // 使用bing随机图片
        $bingimg= bingImgFetch();
        $pic = "https://www.bing.com";
        $pic .=  $bingimg['url'];
        $pic_date = $bingimg['date'];
        echo "<span id = 'thumb'>";
        echo "<img src = $pic>";
        echo "</span>";
    }
}


/**
 * 获取bing随机图片
 *
 */
function bingImgFetch(){
    $random1 = rand(0, 16);
    $random2 = rand(1, 8);
    $ch = curl_init();
    $url_send = sprintf("https://www.bing.com/HPImageArchive.aspx?format=js&idx=%s&n=%s", $random1, $random2);
    curl_setopt($ch, CURLOPT_URL, $url_send);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36'
        ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $re = curl_exec($ch);
    curl_close($ch);
    $re = json_decode($re,1);
    $re2 = json_decode(file_get_contents('https://cn.bing.com/cnhp/coverstory/'),1);
    return array(
        'url' => str_replace('1920x1080','1366x768',$re['images'][$random2-1]['url']),
        'date' => date('j',strtotime($re['images'][$random2-1]['enddate'])),
        'title' => $re2['title'],
        'd' => $re2['para1']
    );
}

/**
 * 替换Google API
 *
 */
function hc_cdn_callback($buffer) 
{
    return str_replace('lug.ustc.edu.cn', 'lug.ustc.edu.cn', $buffer);
    
}

function hc_buffer_start()
{
    ob_start("hc_cdn_callback");
}

function hc_buffer_end()
{
    ob_end_flush();
}
add_action('init', 'hc_buffer_start');
add_action('shutdown', 'hc_buffer_end');


/**
 * 全站ssl支持
 *
 */
add_filter('get_header', 'fanly_ssl');
function fanly_ssl(){
    if( is_ssl() ){
        function fanly_ssl_main ($content){
            $siteurl = get_option('siteurl');
            $upload_dir = wp_upload_dir();
            $content = str_replace( 'http:'.strstr($siteurl, '//'), 'https:'.
strstr($siteurl, '//'), $content);
            $content = str_replace( 'http:'.strstr($upload_dir['baseurl'], 
'//'), 'https:'.strstr($upload_dir['baseurl'], '//'), $content);
            return $content;
        }
        ob_start("fanly_ssl_main");
    }
}
