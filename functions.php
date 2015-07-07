<?php
/**
 * Maina Kiai Theme Functions Definitions
 *
*/

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/util.php' );
require( get_template_directory() . '/inc/simplexlsx.php' );
require( get_template_directory() . '/inc/jw_custom_post_type.php' );
require( get_template_directory() . '/inc/rapporteur_shortcodes.php' );

add_theme_support('post-thumbnails');

register_nav_menu('primary', __('Primary Menus'));


function register_theme_jquery_scripts()
{
	// Register the script like this for our theme:
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.js');
	wp_register_script( 'touchswipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ) );
	wp_register_script( 'mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array( 'jquery' ) );
	wp_register_script( 'nivoslider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array( 'jquery' ) );
	wp_register_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ) );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ) );
	wp_register_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ) );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ));
	wp_register_script( 'sorting', get_template_directory_uri() . '/js/sorting.js' );
	wp_register_script( 'scrollbar', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js' );
	wp_register_script( 'cbpNTAccordion', get_template_directory_uri() . '/js/jquery.cbpNTAccordion.min.js' );
	wp_register_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ) );
	
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'touchswipe' );
	wp_enqueue_script( 'mousewheel' );
	wp_enqueue_script( 'nivoslider' );
	wp_enqueue_script( 'easing' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'superfish' );
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'sorting' );
	wp_enqueue_script( 'scrollbar' );
	wp_enqueue_script( 'cbpNTAccordion' );
	wp_enqueue_script( 'scripts' );
}
add_action( 'wp_enqueue_scripts', 'register_theme_jquery_scripts' );

function register_portfolio_scripts()
{
?>
<script type="text/javascript">
	$(function () {
		$('div.element').hide();
		$('.projects').isotope({});
	});

	var i = 0;//initialize
	var int = 0;
	$(window).bind("load", function() {
		var int = setInterval(function() {
			var imgs = $('div.element').length;
			if (i >= imgs) {
				clearInterval(int);
			}
			$('div.element:hidden').eq(0).fadeIn(100);
			i++; //add 1 to the count

		}, 100); //fade in speed in milliseconds
	}); 

	$("a[rel^='prettyPhoto']").prettyPhoto();
	$("a[rel^='prettyPhoto'], a[rel^='lightbox']").prettyPhoto({
		overlay_gallery: false, 
		social_tools: false,  
		deeplinking: false
	});
</script>
<?php
}

/*
---------------------------------------------------------------------------------------
	Custom Post Types
---------------------------------------------------------------------------------------
*/

$maps = new JW_Post_Type("rapporteur", array(
	'supports' => array('title', 'editor'),
	'labels' => array(
			'name' => __('Countries'),
			'singular_name' => __('Rapporteur'),
			'all_items' => __('All Locations'),
	        'add_new_item' => __('Add Location'),
	        'edit_item' => __('Edit Location'),
	        'new_item' => __('New Location'),
	        'view_item' => __('View Location'),
	        'search_items' => __('Search Location'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'query_var' => 'rapporteur'
));
$maps->add_meta_box('Rapporteur', array(
	'Visit date' => 'text',
	'Visit status' => array('type' => 'select', 'options' =>  util::visit_options() ),
	'country' => array('type' => 'select', 'options' => util::countries() ),
	'longitude' => 'text',
	'latitude' => 'text',
	'Upload File' => 'file',
));


$pressnews = new JW_Post_Type("rapporteurpressnews", array(
	'supports' => array('title', 'editor' ,'thumbnail'),
	'labels' => array(
			'name' => __('News'),
			'singular_name' => __('News Item'),
			'all_items' => __('News'),
	        'add_new_item' => __('Add New Item'),
	        'edit_item' => __('Edit Item'),
	        'new_item' => __('New Item'),
	        'view_item' => __('View Item'),
	        'search_items' => __('Search Item'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'taxonomies' => array('post_tag'),
	'query_var' => 'rapporteurpressnews'
));
$pressnews->add_taxonomy(
	'Press Category', 
	array("hierarchical" => true), 
	array(
        'name' => _x('Press Category', 'taxonomy general name'),
        'search_items' => __('Search Press Category'),
        'all_items' => __('All Press Categories')
    )
);
$pressnews->add_meta_box('Rapporteur Press News', array(
	'Release Date' => 'text',
	'country' => array('type' => 'checkbox', 'options' => util::countries_options() ),
	'Upload File' => 'file'
));

$reports = new JW_Post_Type("rapporteurreports", array(
	'supports' => array('title', 'editor' ,'thumbnail'),
	'labels' => array(
			'name' => __('Reports'),
			'singular_name' => __('Report'),
			'all_items' => __('Reports'),
	        'add_new_item' => __('Add New Item'),
	        'edit_item' => __('Edit Item'),
	        'new_item' => __('New Item'),
	        'view_item' => __('View Item'),
	        'search_items' => __('Search Item'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'taxonomies' => array('post_tag'),
	'query_var' => 'rapporteurreports'
));
$reports->add_taxonomy('Type', array("hierarchical" => true));
$reports->add_meta_box('Rapporteur Reports', array(
	'Release Date' => 'text',
	'country' => array('type' => 'checkbox', 'options' => util::countries_options() ),
	'Upload File' => 'file',
));

$discussions = new JW_Post_Type("rapdiscussions", array(
	'supports' => array('title', 'editor' ,'thumbnail'),
	'labels' => array(
			'name' => __('Discussions'),
			'singular_name' => __('Discussion'),
			'all_items' => __('Discussions'),
	        'add_new_item' => __('Add New Item'),
	        'edit_item' => __('Edit Item'),
	        'new_item' => __('New Item'),
	        'view_item' => __('View Item'),
	        'search_items' => __('Search Item'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'taxonomies' => array('post_tag'),
	'query_var' => 'rapcommunications'
));
$discussions->add_taxonomy('Discussions Type', array("hierarchical" => true));
$discussions->add_meta_box('Discussions Info', array(
	'Release Date' => 'text',
));

$spreadsheets = new JW_Post_Type("spreadsheets", array(
	'supports' => array('title'),
	'labels' => array(
			'name' => __('Spreadsheets'),
			'singular_name' => __('Spreadsheet'),
			'all_items' => __('Spreadsheets'),
	        'add_new_item' => __('Add New Item'),
	        'edit_item' => __('Edit Item'),
	        'new_item' => __('New Item'),
	        'view_item' => __('View Item'),
	        'search_items' => __('Search Item'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'taxonomies' => array('post_tag'),
	'query_var' => 'spreadsheets'
));
$spreadsheets->add_taxonomy('Spreadsheets Category', array("hierarchical" => true));
$spreadsheets->add_meta_box('Uploads', array(
	'Spreadsheet' => 'spreadsheets',
));

$reports = new JW_Post_Type("resource-center", array(
	'supports' => array('title', 'editor', 'thumbnail'),
	'labels' => array(
			'name' => __('Resource Center'),
			'singular_name' => __('Resource Center'),
			'all_items' => __('Resource Center'),
	        'add_new_item' => __('Add New Item'),
	        'edit_item' => __('Edit Item'),
	        'new_item' => __('New Item'),
	        'view_item' => __('View Item'),
	        'search_items' => __('Search Item'),
	        'not_found' => __('No items found'),
	        'not_found_in_trash' => __('No items found in Trash')
		),
	'hierarchical' => true,
	'menu_icon' => admin_url().'/images/media-button-image.gif',
	'taxonomies' => array('post_tag'),
	'query_var' => 'resource-center'
));
$reports->add_meta_box('Meta', array(
	'Release Date' => 'text',
	'Parent' => array('type' => 'checkbox', 'options' => util::resource_center() ),
));


/**
* Returns the latitude setting for a post.
* @return	string	Description
*/
function _get_Lat()
{
	global $post;
	return get_post_meta($post->ID, 'rapporteur_rapporteur_latitude', true);
}



/**
 * @param  [type] $num [description]
 * @return [type]      [description]
 */
function yg_get_posts($type = 'popular', $num = 2) 
{    
    $type = ($type == 'popular') ? 'orderby=comment_count' : 'orderby=post_date';
	$popular_posts_list = new WP_Query(
		array(
			'post_type' => array( 'rapporteurreports', 'rapporteurpressnews'),
			'orderby' => 'post_date',
			'order' => 'DESC',
			'posts_per_page' => $num,
		)
	);

   // $popular_posts_list = new WP_Query("{$type}&posts_per_page={$num}");
    while ($popular_posts_list->have_posts()) 
    {
        $popular_posts_list->the_post();?>

   		<li class="media">
   		<?php
   		if ( has_post_thumbnail() ) 
   		{?>
		    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_post_thumbnail(array(42, 42), array('class'=> 'drop pull-left')); ?>
            </a>
   		<?php 
   		} ?> 
   		<div class="media-body">
   			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();?></a>
   			<br/><i class="icon-time hue"></i> <?php the_date(); ?>
   		</div>
   		</li>
    <?php
	}
}

function yg_latest_posts($num = 1) 
{    
    $type = 'orderby=post_date';
    $popular_posts_list = new WP_Query("{$type}&posts_per_page={$num}");?>
    
    <div class="accordion" id="accordion">
    <?php
    while ($popular_posts_list->have_posts()) 
    {
        $popular_posts_list->the_post();?>

   		<?php
   		if ( has_post_thumbnail() ) 
   		{?>
            <?php the_post_thumbnail('full'); ?>
   		<?php 
   		} ?> 
   		<div class="accordion-group">
			<div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><?php the_title(); ?></a>
            </div>
            <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <?php the_excerpt(); ?>
                </div>
            </div> 
		</div>
    <?php
	}?>
	</div>
<?php }


/**
 * Register our sidebars and widgetized areas.
 *
 */

function register_this_theme_widgets() 
{
	register_sidebar( array(
		'name' => 'Theme Footer Widget',
		'id' => 'theme_footer_widget',
		'before_widget' => '',
        'after_widget' => '',
		'before_title' => '<h6>',
		'after_title' => '</h6>',
	) );	

	register_sidebar( array(
		'name' => 'Contact Information Widget',
		'id' => 'theme_contact_info_widget',
		'before_widget' => '',
        'after_widget' => '',
		'before_title' => '<h6>',
		'after_title' => '</h6>',
	) );

	register_sidebar( array(
		'name' => 'Theme Sidebar Widget',
		'id' => 'theme_sidebar_widget',
		'before_widget' => '',
        'after_widget' => '',
		'before_title' => '<h6 class="title-divider span3">',
		'after_title' => '<span></span></h6>',
	) );

	register_sidebar( array(
		'name' => 'Theme Search Widget',
		'id' => 'theme_search_widget',
		'before_widget' => ' <div class="input-append">',
        'after_widget' => '</div>',
		'before_title' => '<h6 class="title-divider span3">',
		'after_title' => '<span></span></h6>',
	) );

	register_sidebar( array(
		'name' => 'Homepage Quote',
		'id' => 'theme_home_page_quotes',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	) );
}

add_action( 'widgets_init', 'register_this_theme_widgets' );


add_filter('request', 'this_theme_feed_request');
function this_theme_feed_request($feeds) 
{
	if (isset($feeds['feed']))
	{
		$feeds['post_type'] = get_post_types();
	}
	return $feeds;
}

/**
 * Attach a class to linked images' parent anchors
 * e.g. a img => a.img img
 */
add_filter('the_content','give_linked_images_class');
function give_linked_images_class($html)
{
	$classes = ' pull-right quote_sections_img '; // separated by spaces, e.g. 'img image-link'
	$rel = 'rel="prettyPhoto"';
	// check if there are already classes assigned to the anchor
	if ( preg_match('#<img.*? class=.+?>#', $html) ) 
	{
		$html = preg_replace('#(<img.+)(class\=[\".+\"|\'.+\'])(.*>)#', '$1 class="' . $classes .'$3', $html);
	} 
	else 
	{
		$html = preg_replace('#(<img.*?)>#', '$1 class="' . $classes .'" '. $rel.' >', $html);
	}
	return $html;
}

add_filter('the_content','style_youtube_vedios');
function style_youtube_vedios($html)
{
	$classes = ' pull-right '; // separated by spaces, e.g. 'img image-link'
	// check if there are already classes assigned to the anchor
	if ( preg_match('#<p><iframe.+></p>#', $html) ) 
	{
		$html = preg_replace('#<p>(<iframe.*?)></p>#', '$1 class="' . $classes.'">', $html);
	} 

	return $html;
}

add_filter( 'excerpt_more', 'this_theme_excerpt_more' );
function this_theme_excerpt_more( $more ) 
{
	return ' <a class="more-link" href="'. get_permalink( get_the_ID() ) . '">... Continue reading &rarr;</a>';
}

add_filter( 'excerpt_length', 'this_theme_excerpt_length' );
function this_theme_excerpt_length( $length = null) 
{
	return (is_front_page()) ? 20 : 150;
}

add_filter('get_the_excerpt', 'this_theme_trim_excerpt');
add_filter('the_excerpt', 'this_theme_trim_excerpt');
function this_theme_trim_excerpt($text) 
{
	$raw_excerpt = $text;
	if ( '' == $text ) 
	{
	    $text = get_the_content(''); 
	    $text = strip_shortcodes( $text );
	 
	    $text = apply_filters('the_content', $text);
	    $text = str_replace(']]>', ']]&gt;', $text);
	     
	    /***Add the allowed HTML tags separated by a comma.***/
	    $allowed_tags = '<div>,<span>,<p>,<a>,<em>,<strong>'; 
	    $text = strip_tags($text, $allowed_tags);
	     
	    /***Change the excerpt word count.***/
	    // $excerpt_word_count = 60;
	    // $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
	     
	    /*** Change the excerpt ending.***/
	    // $excerpt_end = ' <a href="'. get_permalink($post->ID) . '">' . '&raquo; Continue Reading.' . '</a>';
	    // $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
	     
	    // $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	    // if ( count($words) > $excerpt_length ) {
	    //     array_pop($words);
	    //     $text = implode(' ', $words);
	    //     $text = $text . $excerpt_more;
	    // } else {
	    //     $text = implode(' ', $words);
	    // }
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

add_filter( 'pre_get_posts', 'this_theme_add_custom_types' );
function this_theme_add_custom_types( $query ) 
{
    if( is_tag() ) 
    {
        // this gets all post types:
        $post_types = get_post_types();

        // alternately, you can add just specific post types using this line instead of the above:
        // $post_types = array( 'post', 'your_custom_type' );
        $query->set( 'post_type', $post_types );
        return $query;
    }
}

function login_styles() 
{ 
	echo '<style type="text/css"> h1 a { background:#fbfbfb url('. get_template_directory_uri().'/img/logo.png) !important ;  width: 391px !important; height: 86px;  }</style>'; 
}
add_action('login_head', 'login_styles');

function remove_menus () 
{
	global $menu;
	$restricted = array(__('Links'));
	end ($menu);
	while (prev($menu))
	{
		$value = explode(' ', $menu[key($menu)][0]);
		if(in_array($value[0] != NULL ? $value[0]:"" , $restricted)){ unset($menu[key($menu)]); }
	}
}
add_action('admin_menu', 'remove_menus');

function disable_default_dashboard_widgets() 
{
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	//remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

/**
 * Displays navigation to next/previous pages when applicable.
 */
function this_theme_content_nav( $html_id ) 
{
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) 
	{ ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<div class="nav-previous"><?php  get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts') ); ?></div>
			<div class="nav-next"><?php  get_previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php 
	}
}
