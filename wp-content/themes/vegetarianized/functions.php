<?php
    header("Access-Control-Allow-Origin: http://www.facebook.com");
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
/**
 * Vegetarinized functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

/*tmp*/
//add_filter( 'xmlrpc_allow_anonymous_comments', '__return_true' );

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Vegetarianized supports.
 *
 * @since Vegetarianized 1.0
 */
function vegetarianized_setup() {
	/*
	 * Makes Vegetarianized available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'vegetarianized', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
    
    // This theme allows for custom logos by using the 'custom-header' theme feature
    $defaults = array(
        'default-image'          => get_template_directory_uri() . '/images/vegetarianized_logo_tomato.png',
        'random-default'         => false,
        'width'                  => 616,
        'height'                 => 135,
        'flex-height'            => false,
        'flex-width'             => false,
        'default-text-color'     => '',
        'header-text'            => false,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    );
    add_theme_support('custom-header', $defaults);

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 241, 164, true );
    
    // This theme uses several custom image sizes
    add_image_size( 'feature-full', 660, 9999 );
    add_image_size( 'page-feature-full', 1024, 9999 );
    add_image_size( 'page-one-column', 1024, 9999 );
    add_image_size( 'page-two-column', 501, 9999 );
    add_image_size( 'page-three-column_column-one-two', 321, 9999 );
    add_image_size( 'page-three-column_column-three', 341, 9999 );
    add_image_size( 'video-thumbnail', 241, 9999 );
    add_image_size( 'press-article-thumbnail', 501, 9999 );
}
add_action( 'after_setup_theme', 'vegetarianized_setup' );

/**
 * Remove unnecessary menus from the admin tool. 
 *
 * @since Vegetarianized 1.0
 */
function remove_menus () {
global $menu;
		$restricted = array( __('Posts'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
}
add_action('admin_menu', 'remove_menus');

/**
 * Adding custom post types. This enables some custom options for posting recipes, news, links and videos.
 * Eventually this should be in a plugin I think.
 *
 * @since Vegetarianized 1.0
 */
function create_post_types() {
    // The recipe type
    register_post_type( 'recipe',
		array(
			'labels' => array(
				'name'                  => __( 'Recipes' ),
				'singular_name'         => __( 'Recipe' ),
                'add_new_item'          => __( 'Add New Recipe' ),
                'edit_item'             => __( 'Edit Recipe' ),
                'new_item'              => __( 'New Recipe' ),
                'view_item'             => __( 'View Recipe' ),
                'search_items'          => __( 'Search Recipes' ),
                'not_found'             => __( 'No recipes found' ),
                'not_found_in_trash'    => __( 'No recipes found in Trash' ),
            ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array(
                'title',
                'thumbnail',
                'comments'
            ),
            'taxonomies'    => array( 'category' ),
            'menu_position' => 5,
		)
	);
    // The alert type
    register_post_type( 'alert',
		array(
			'labels' => array(
				'name'                  => __( 'Alerts' ),
				'singular_name'         => __( 'Alert' ),
                'add_new_item'          => __( 'Add New Alert' ),
                'edit_item'             => __( 'Edit Alert' ),
                'new_item'              => __( 'New Alert' ),
                'view_item'             => __( 'View Alert' ),
                'search_items'          => __( 'Search Alerts' ),
                'not_found'             => __( 'No alerts found' ),
                'not_found_in_trash'    => __( 'No alerts found in Trash' ),
            ),
            'public'        => true,
            'has_archive'   => false,
            'supports'      => array(
                'title',
                'editor'
            ),
            'menu_position' => 5,
		)
	);
}
add_action( 'init', 'create_post_types' );

/**
 * Remove the slug from published post permalinks. Only affect our CPT though.
 */
function vipx_remove_cpt_slug( $post_link, $post, $leavename ) {
 
    if ( ! in_array( $post->post_type, array( 'recipe' ) ) || 'publish' != $post->post_status )
        return $post_link;
    
    $post_date = explode("-", $post->post_date);
 
    $post_link = str_replace( '/' . $post->post_type . '/', '/'.$post_date[0].'/'.$post_date[1].'/', $post_link );
    
    //$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    
    return $post_link;
}
add_filter( 'post_type_link', 'vipx_remove_cpt_slug', 10, 3 );

/**
 * Some hackery to have WordPress match postname to any of our public post types
 * All of our public post types can have /post-name/ as the slug, so they better be unique across all posts
 * Typically core only accounts for posts and pages where the slug is /post-name/
 */
function vipx_parse_request_tricksy( $query ) {
    
    
    
    // Only noop the main query
    if ( ! $query->is_main_query() ) {
        //echo '<pre>';
        //echo 'Here!';
        //echo '</pre>';
        return;
    }
    // Only noop our very specific rewrite rule match
    if ( 4 != count( $query->query )
        || ! isset( $query->query['page'] ) ) {
        //echo '<pre>';
        //echo count( $query->query );
        //echo '<br />';
        //echo isset( $query->query['page'] );
        //echo '</pre>';
        return;
    }
    //echo '<pre>';
    //var_dump( $query );
    //echo '</pre>';
    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) )
        $query->set( 'post_type', array( 'post', 'recipe', 'page' ) );
}
add_action( 'pre_get_posts', 'vipx_parse_request_tricksy' );

/**
 * Setting the recipe post type to be available to general post queries.
 *
 * @since Vegetarianized 1.0
 */
function my_get_posts( $query ) {

	if ( ( is_home() && $query->is_main_query() ) || is_feed() )
		$query->set( 'post_type', array( 'post', 'recipe' ) );

	return $query;
}
add_filter( 'pre_get_posts', 'my_get_posts' );

/**
 * Adding the meta-box script to enable easy custom meta-boxes in the admin tool. 
 * See http://www.deluxeblogtips.com/meta-box/ for details.
 *
 * @since Vegetarianized 1.0
 */
// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TEMPLATEPATH . '/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

/**
 * Adding all of the custom meta-boxes
 *
 * @since Vegetarianized 1.0
 */
function pages_register_meta_boxes() {
    // We dont want the editor to appear on the page type by default
    remove_post_type_support('page', 'editor');
    
    // These meta-boxes are template specific so we need to grab the current template
    if ( array_key_exists ( 'post' , $_GET ) ||  array_key_exists ( 'post_ID' , $_POST ) ) {
        $post_id = array_key_exists ( 'post' , $_GET ) ? $_GET['post'] : $_POST['post_ID'];
        $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
    } else {
        $template_file = '';
    }
    
    
    // Check if plugin is activated or included in theme
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;
    $prefix = 'page_';
    $meta_boxes = array();
    
    // check for a template type
    if ($template_file == 'page-templates/two-column.php' || $template_file == 'default' || $template_file == 'page-templates/three-column.php') {
        // Stuff thats common to all page column formats
        $meta_boxes[] = array(
            'title'     => __( 'Credits, Links and Extras' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'  => __( 'Subtitle' ),
                    'id'    => $prefix.'subtitle',
                    'type'  => 'text',
                ),
                array(
                    'name'  => __( 'Author' ),
                    'id'    => $prefix.'author',
                    'desc'  => __( 'The author credit of the original article.' ),
                    'type'  => 'text',
                ),
                array(
                    'name'  => __( 'Photos...' ),
                    'id'    => $prefix.'photographer',
                    'desc'  => __( 'The photographer credit of the original article.' ),
                    'type'  => 'text',
                ),
                array(
                    'name'  => __( 'Originally published in...' ),
                    'id'    => $prefix.'published_in',
                    'desc'  => __( 'The publication (and date if applicable) that the original article was published in.' ),
                    'type'  => 'text',
                ),
                array(
                    'name'  => __( 'Original article URL' ),
                    'id'    => $prefix.'original_article_url',
                    'desc'  => __( 'The posted URL of the original article.' ),
                    'type'  => 'text',
                ),
                array(
                    'name'      => __( 'Short article summary' ),
                    'id'        => $prefix.'short_summary',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'A short summary of the article. Appears on the main "Press" page.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => true,
                        'media_buttons' => false,
                    ),
                ),
                array(
                    'name'  => __( 'Thumbnail' ),
                    'id'    => $prefix.'article_thumb',
                    'desc'  => __( 'The thumbnail image for the article. Will appear on the main press page.' ),
                    'type'  => 'image',
                ),

            )
        );
    }
    if ($template_file == 'page-templates/press-main.php') {
        // This is not a customizable page
        remove_post_type_support('page', 'thumbnail');
    }
    elseif ($template_file == 'page-templates/two-column.php') {
        // The two column meta box
        $meta_boxes[] = array(
            'title'     => __( 'Columns' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'      => __( 'Column 1' ),
                    'id'        => $prefix.'column_1',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'When inserting images use "Two column layout size" from the "Size" dropdown on the "Insert Media" dialog.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
                array(
                    'name'      => __( 'Column 2' ),
                    'id'        => $prefix.'column_2',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'When inserting images use "Two column layout size" from the "Size" dropdown on the "Insert Media" dialog.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
            )
        );
    }
    elseif ($template_file == 'page-templates/three-column.php') {
        // The three column meta box
        $meta_boxes[] = array(
            'title'     => __( 'Columns' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'      => __( 'Column 1' ),
                    'id'        => $prefix.'column_1',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'When inserting images use "Three column layout size: columns one and two" from the "Size" dropdown on the "Insert Media" dialog.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
                array(
                    'name'      => __( 'Column 2' ),
                    'id'        => $prefix.'column_2',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'When inserting images use "Three column layout size: columns one and two" from the "Size" dropdown on the "Insert Media" dialog.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
                array(
                    'name'      => __( 'Column 3' ),
                    'id'        => $prefix.'column_3',
                    'type'      => 'wysiwyg',
                    'desc'      => __( 'When inserting images use "Three column layout size: column three" from the "Size" dropdown on the "Insert Media" dialog.' ),
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
            )
        );
    }
    elseif ($template_file == 'page-templates/press-link.php') {
        // The press link page template
        $meta_boxes[] = array(
            'title'     => __( 'Link' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'  => __( 'URL' ),
                    'id'    => $prefix.'link_url',
                    'type'  => 'text',
                ),
            )
        );

    }
    elseif ($template_file == 'page-templates/press-video.php') {
        // The press video page template
        $meta_boxes[] = array(
            'title'     => __( 'Video links.' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'  => __( 'URL' ),
                    'id'    => $prefix.'original_article_url',
                    'type'  => 'text',
                ),
                array(
                    'name'  => __( 'Video embed code' ),
                    'id'    => $prefix.'video_embed_code',
                    'type'  => 'text',
                ),
                array(
                    'name'      => __( 'Comments' ),
                    'id'        => $prefix.'video_comments',
                    'type'      => 'wysiwyg',
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => true,
                        'media_buttons' => false,
                    ),
                ),
            )
        );

    }
    elseif ($template_file == 'default') {
        // Default one column meta box
        $meta_boxes[] = array(
            'title'     => __( 'Columns' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'fields'    => array(
                array(
                    'name'      => __( 'Column 1' ),
                    'id'        => $prefix.'column_1',
                    'type'      => 'wysiwyg',
                    'options'   => array(
                        'textarea_rows' => 20,
                        'teeny'         => false,
                        'media_buttons' => true,
                    ),
                ),
            )
        );
    }
    
    // Add all the metaboxes defined above
    foreach ( $meta_boxes as $meta_box )
    {
        new RW_Meta_Box( $meta_box );
    }
}
function recipe_register_meta_boxes() {
    // Check if plugin is activated or included in theme
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;
    $prefix = 'recipe_';
    $meta_boxes = array();
    
    // The recipe description meta box
    $meta_boxes[] = array(
        'title'     => __( 'Recipe Description' ),
        'pages'     => array( 'recipe' ),
        'context'   => 'normal',
        'fields'    => array(
            array(
                'name'      => __( 'Description' ),
                'id'        => $prefix.'description',
                'type'      => 'wysiwyg',
                'desc'      => __( 'Recipe description.' ),
                // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                'options'   => array(
                    'textarea_rows' => 10,
                    'teeny'         => true,
                    'media_buttons' => false,
                    'wpautop'       => false,
                ),
            ),
            array(
                'name'  => __( 'Recipe views' ),
                'id'    => $prefix.'views_count',
                'type'  => 'hidden',
                'std'   => 0,
            ),
        )
    );
    // The recipe information meta box
    $meta_boxes[] = array(
        'title'     => __( 'Recipe Information' ),
        'pages'     => array( 'recipe' ),
        'context'   => 'normal',
        'fields'    => array(
            array(
                'name' => __( 'Servings' ),
                'id'   => $prefix.'servings',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Serving size' ),
                'id'   => $prefix.'serving_size',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Time' ),
                'id'   => $prefix.'time',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Price' ),
                'id'   => $prefix.'price',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Calories' ),
                'id'   => $prefix.'calories',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Protein' ),
                'id'   => $prefix.'protein',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Fat' ),
                'id'   => $prefix.'fat',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Saturated fat' ),
                'id'   => $prefix.'saturated_fat',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Carbohydrates' ),
                'id'   => $prefix.'carbohydrates',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Fiber' ),
                'id'   => $prefix.'fiber',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Sodium' ),
                'id'   => $prefix.'sodium',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Cholesterol' ),
                'id'   => $prefix.'cholesterol',
                'type' => 'text',
            ),
        )
    );
    // The recipe ingredients, preparation and images.
    $meta_boxes[] = array(
        'title'     => __( 'Recipe Ingredients, Preparation and Images' ),
        'pages'     => array( 'recipe' ),
        'context'   => 'normal',
        'fields'    => array(
            array(
                'name'  => __( 'Ingredients' ),
                'id'    => $prefix.'ingredients',
                'type'  => 'wysiwyg',
                'desc'  => esc_html__( 'The recipe ingredients. Use <ul><li>Item</li></ul>.' ),
                // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                'options' => array(
                    'textarea_rows' => 10,
                    'teeny'         => true,
                    'media_buttons' => false,
                ),
            ),
            array(
                'name'  => __( 'Preparation' ),
                'id'    => $prefix.'preperation',
                'desc'  => esc_html__( 'The steps in the recipe preparation. Use <ol><li>Item</li></ol>.' ),
                'type'  => 'wysiwyg',
                'options' => array(
                    'textarea_rows' => 10,
                    'teeny'         => true,
                    'media_buttons' => false,
                ),
            ),
            array(
                'name'              => __( 'Recipe Images' ),
                'id'                => $prefix . 'images',
                'type'              => 'plupload_image',
                'max_file_uploads'  => 10,
                'desc'              => __( 'All of the images for the recipe except the final image.' ),
            ),
        )
    );
    // Add all the metaboxes defined above
    foreach ( $meta_boxes as $meta_box )
    {
        new RW_Meta_Box( $meta_box );
    }
}
add_action( 'admin_init', 'recipe_register_meta_boxes' );
add_action( 'admin_init', 'pages_register_meta_boxes' );


$brand_array = array(
    0 => "tomato",
    1 => "carrot",
    2 => "eggplant",
    3 => "lemon",
);
$brand_name = $brand_array[rand ( 0 , 3 )];

/**
 * Register all of the scripts and styles used by the theme.
 *
 * @since Vegetarianized 1.0
 */

function vegetarianized_scripts_styles() {
    global $brand_name;
    /**
     * Register scripts
     */
    // Classy enables pythonish type classes in javascript
    wp_register_script("classy", get_template_directory_uri() . "/js/classy.js");
    // These are all of the javascript classes that vegetarianized.com uses
    wp_register_script("vegetarianized-globals", get_template_directory_uri() . "/js/globals.js");
    wp_register_script("vegetarianized-scroller", get_template_directory_uri() . "/js/scroller.js", array("vegetarianized-globals","jquery","classy"), "1.0");
    wp_register_script("vegetarianized-navbar", get_template_directory_uri() . "/js/navbar.js", array("vegetarianized-globals","jquery","classy"), "1.0");
    wp_register_script("vegetarianized-feature", get_template_directory_uri() . "/js/feature.js", array("vegetarianized-globals","jquery","classy"), "1.0");
    wp_register_script("vegetarianized-results_list", get_template_directory_uri() . "/js/results_list.js", array("vegetarianized-globals","jquery","classy"), "1.0");
    wp_register_script("vegetarianized-fontsizer", get_template_directory_uri() . "/js/fontsizer.js", array("vegetarianized-globals","jquery","classy"), "1.0");
    // These scripts are for specific pages or page types
    wp_register_script("vegetarianized-init_index", get_template_directory_uri() . "/js/init_index.js", array("vegetarianized-globals","jquery","classy", "vegetarianized-scroller", "vegetarianized-navbar", "vegetarianized-feature", "vegetarianized-fontsizer"), "1.0");
    //so there is a variable to call the ajax script for updating the recipe count on the homepage
    wp_localize_script( "vegetarianized-init_index", "TheAjax", array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );
    
    wp_register_script("vegetarianized-init_recipe", get_template_directory_uri() . "/js/init_recipe.js", array("vegetarianized-globals","jquery","classy", "vegetarianized-scroller", "vegetarianized-navbar", "vegetarianized-feature", "vegetarianized-fontsizer"), "1.0");
    wp_register_script("vegetarianized-init_list", get_template_directory_uri() . "/js/init_list.js", array("vegetarianized-globals","jquery","classy", "vegetarianized-navbar", "vegetarianized-results_list", "vegetarianized-fontsizer"), "1.0");
    wp_register_script("vegetarianized-init_other", get_template_directory_uri() . "/js/init_other.js", array("vegetarianized-globals","jquery","classy", "vegetarianized-navbar", "vegetarianized-fontsizer"), "1.0");
    
    //Register twitter web intents API
    wp_register_script("twitter", "//platform.twitter.com/widgets.js");
    
    /**
     * Load scripts
     */
    //if ( get_post_type() == "recipe"){
    //    echo "its a recipe";
    //}
    //echo "test ".is_single()." ".get_post_type() == "recipe".".";
    
    if ( is_front_page() ) {
        wp_enqueue_script("vegetarianized-init_index");
    }
    elseif ( is_single() && (get_post_type() == "recipe") ) {
        wp_enqueue_script("vegetarianized-init_recipe");
    }
    elseif ( is_category() || is_search() ) {
        wp_enqueue_script("vegetarianized-init_list");
    }
    else {
        wp_enqueue_script("vegetarianized-init_other");
    }
    
    /**
     * Register fonts
     */
    wp_register_style( "vegetarianized-font-futura_light", get_template_directory_uri() . "/fonts/FuturaTLight/stylesheet.css" );
    wp_register_style( "vegetarianized-font-futura_book", get_template_directory_uri() . "/fonts/FuturaTBook/stylesheet.css" );
    
    /**
     * Load the main stylesheets
     */
    wp_enqueue_style( "vegetarianized-style", get_stylesheet_uri(), array("vegetarianized-font-futura_light", "vegetarianized-font-futura_book"), "1.0", "screen" );
    wp_enqueue_style( "vegetarianized-brand-style", get_template_directory_uri() . "/style-brand-".$brand_name.".css", array("vegetarianized-style"), "1.0", "screen" );
    wp_enqueue_style( "vegetarianized-print-style", get_template_directory_uri() . "/style-print.css", array("vegetarianized-font-futura_light", "vegetarianized-font-futura_book"), "1.0", "print" );
    wp_enqueue_style( "vegetarianized-handheld-style", get_template_directory_uri() . "/style-handheld.css", array("vegetarianized-font-futura_light", "vegetarianized-font-futura_book"), "1.0", "screen" );
    
     
}
add_action( 'wp_enqueue_scripts', 'vegetarianized_scripts_styles' );

/**
 * Add a series of functions to count the number of views for each recipe.
 * set_recipe_views is called each time a recipe is viewed.
 * set_recipe_views_callback is called via ajax when the homepage
 * recipe is clicked on. 
 *
 * @since Vegetarianized 1.0
 */
function set_recipe_views($postID) {
    $count_key = 'recipe_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

add_action('wp_ajax_nopriv_set_recipe_views', 'set_recipe_views_callback');
add_action('wp_ajax_set_recipe_views', 'set_recipe_views_callback');

// The ajax callback
function set_recipe_views_callback() {
	global $wpdb; // this is how you get access to the database

	$post_id = intval( $_POST['post_id'] );
    
    set_recipe_views($post_id);

	die(); // this is required to return a proper result
}

/**
 * The search form.
 *
 * @since Vegetarianized 1.0
 */
function vegetarianized_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="'. home_url( '/' ) .'" >'
                .'<input class="text_box" type="text" value="'. get_search_query() .'" name="s" id="s" />'
                .'<input class="submit_button" type="image" src="'. get_template_directory_uri() .'/images/search.png" alt="'. esc_attr__('Search') .'" />'
            .'</form>';

    return $form;
}
add_filter( 'get_search_form', 'vegetarianized_search_form' );

/**
 * Template for comments and pingbacks.
 *
 * This is cribbed verbatim from the Twenty Twelve theme.
 *
 * @since Vegetarianized 1.0
 */
function vegetarianized_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'vegetarianized' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'vegetarianized' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'vegetarianized' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'vegetarianized' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'vegetarianized' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'vegetarianized' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'vegetarianized' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
