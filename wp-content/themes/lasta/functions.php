<?php
/* enqueue scripts and style from parent theme */        
function twentyseventeen_styles() {

	//Stylesheets
	wp_enqueue_style( 'parent', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_style( 'mobile', get_stylesheet_directory_uri() . '/mobile.css' );
	wp_enqueue_style( 'FontFamily', get_stylesheet_directory_uri() . '/fonts/fonts.css' );
    wp_enqueue_style( 'flexslider-style', get_stylesheet_directory_uri() . '/flex-slider/flexslider.css' );
    // Bootstrap css
	wp_enqueue_style( 'bootstrap-grid', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap-grid.css' );
	wp_enqueue_style( 'bootstrap-reboot', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap-reboot.css' );
    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap.css' );
    wp_enqueue_style( 'bootstrap-select', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap-select.min.css' );
    // Animate css
    wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/css/animate.css' );
    // Animate on scroll css
	wp_enqueue_style( 'aos', get_stylesheet_directory_uri() . '/css/aos.css' );
	wp_enqueue_style( 'jquery-ui-css', get_stylesheet_directory_uri() . '/css/jquery-ui.css' );

	// Scripts	
	wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js' );
	wp_enqueue_script( 'jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui.js' );
	wp_enqueue_script( 'jquery-ui-datepic-lang', get_stylesheet_directory_uri() . '/js/datepicker-sr.js' );
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js' );
	wp_enqueue_script( 'bootstrap-select-js', get_stylesheet_directory_uri() . '/js/bootstrap-select.min.js' );
	wp_enqueue_script( 'aos-js', get_stylesheet_directory_uri() . '/js/aos.js' );
	wp_enqueue_script( 'flexslider-script', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/app.js');
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_styles');

function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
    }
    add_filter('upload_mimes', 'add_file_types_to_uploads');


function add_responsive_class($content){

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));

    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {
        $existing_class = $img->getAttribute('class');
        $img->setAttribute('class', "img-fluid $existing_class");
    }

    $html = $document->saveHTML();
    return $html;
}
add_filter('the_content', 'add_responsive_class');


// Register Custom Navigation Walker
require_once('wp_bootstrap4-mega-navwalker.php');
	
register_nav_menus( array(
	'mega_menu'   => __( 'Mega Menu', 'lasta' ),
	) );  

//register MegaMenu widget if the Mega Menu is set as the menu location
function wp_items_megamenu_init() {
    $location = 'mega_menu';
	$css_class = 'mega-menu-parent';
	$locations = get_nav_menu_locations();
	if ( isset( $locations[ $location ] ) ) {
	$menu = get_term( $locations[ $location ], 'nav_menu' );
	if ( $items = wp_get_nav_menu_items( $menu->name ) ) {
		foreach ( $items as $item ) {
		if ( in_array( $css_class, $item->classes ) ) {
			register_sidebar( array(
			'id'   => 'mega-menu-item-' . $item->ID,
			'description' => 'Mega Menu items',
			'name' => $item->title . ' - Mega Menu',
			'before_widget' => '<li id="%1$s" class="mega-menu-item">',
			'after_widget' => '</li>', 

			));
		}
		}
	}
}
}

add_action( 'widgets_init', 'wp_items_megamenu_init' );

add_filter( 'excerpt_length', function($length) {
    return 10;
} );


function new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');



/*=============================================
                LOAD MORE POSTS
=============================================*/

function misha_my_load_more_scripts() {
 
	global $wp_query; 
 
	// In most cases it is already included on the page and this line can be removed
	//wp_enqueue_script('jquery');
 
	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/js/myloadmore.js', array('jquery') );
 
	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script( 'my_loadmore' );
}
 
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


function misha_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
 
			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
			// get_template_part( 'template-parts/post/content', get_post_format() );
			// for the test purposes comment the line above and uncomment the below one
			the_title();
 
 
		endwhile;
 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
 
 
 
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}






/*=============================================
                BREADCRUMBS
=============================================*/

function the_breadcrumb()
{
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter = '/'; // delimiter between crumbs
    $home = 'Početna'; // text for the 'Home' link
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    global $post;
    $homeLink = get_bloginfo('url');
    if (is_home() || is_front_page()) {
        if ($showOnHome == 1) {
            echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
        }
    } else {
        echo '<div class="breadcr"><div class="container px-lg-0"><div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
            }
            echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1) {
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) {
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                }
                echo $cats;
                if ($showCurrent == 1) {
                    echo $before . get_the_title() . $after;
                }
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) {
                echo $before . get_the_title() . $after;
            }
        } elseif (is_page() && $post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) {
                    echo ' ' . $delimiter . ' ';
                }
            }
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ' (';
            }
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ')';
            }
        }
        echo '</div></div></div>';
    }
} // end the_breadcrumb()