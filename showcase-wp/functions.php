<?php
/**
 * Showcase functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Showcase
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'showcase_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function showcase_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Showcase, use a find and replace
		 * to change 'showcase' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'showcase', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-header' => esc_html__( 'Header Menu', 'showcase' ),
				'menu-footer' => esc_html__( 'Footer Menu', 'showcase' ),
			)
		);
		function wpse23007_redirect(){
		  if( is_admin() && !defined('DOING_AJAX') && ( current_user_can('subscriber') || current_user_can('contributor') ) ){
		    wp_redirect(home_url());
		    exit;
		  }
		}
		add_action('init','wpse23007_redirect');
		add_filter( 'show_admin_bar', '__return_false' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'showcase_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'showcase_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function showcase_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'showcase_content_width', 640 );
}
add_action( 'after_setup_theme', 'showcase_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function showcase_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'showcase' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'showcase' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'showcase_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function showcase_scripts() {
	wp_enqueue_style( 'showcase', get_template_directory_uri() . "/dist/main.css", array(), _S_VERSION );
	wp_enqueue_style( 'showcase-style', get_stylesheet_uri(), array(), _S_VERSION );
  	wp_style_add_data( 'showcase-style', 'rtl', 'replace' );

	wp_enqueue_script( 'webrtc-adapter', 'https://webrtc.github.io/adapter/adapter-latest.js', array(), _S_VERSION, false );
	wp_enqueue_script( 'showcase-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/dist/bootstrap-scripts.js', array(), _S_VERSION, false );
	wp_enqueue_script( 'footawesome', 'https://kit.fontawesome.com/f5515e915e.js', array(), false, true );

	if(is_page("add-headshot") || is_page('edit-profile')){
		wp_enqueue_script( 'headshot', get_template_directory_uri() . '/js/headshot.js', array(), _S_VERSION, false );		
		
		/* Add Headshot */ 
		wp_localize_script(
			'headshot',
			'SCI_HEADSHOT',
			array(
				'request_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'headshot_request' ),
			)
		);
	}

	if(is_page("email-verification")){
		wp_enqueue_script( 'sci-um-rev', get_template_directory_uri() . '/js/sci-um-rev.js', array('bootstrap'), _S_VERSION, true );

		/* Resend verification email */
		wp_localize_script(
			'sci-um-rev',
			'UM_RAF',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'um_raf_nonce' ),
			)
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Generic Localized Script */ 
	// currently used in manage account navigation menu which is present in all pages
	wp_localize_script(
		'bootstrap',
		'SCI_AJAX',
		array(
			'request_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'sci_nonce' ),
		)
	);	
}
add_action( 'wp_enqueue_scripts', 'showcase_scripts' );

function __sci_s($field_group, $field){
   $raw_field_groups = acf_get_raw_field_groups();
   foreach ($raw_field_groups as $key => $value) {
      if ($value["title"] == $field_group) {
         foreach (acf_get_fields($value['key']) as $key => $value) {
            if ($value['name'] == $field) {
              return $value;
            }
         }
      }
   }
}
function custom_page_scripts(){
	if (is_page('edit-profile')) {
		wp_enqueue_style( 'editable', get_template_directory_uri() . "/sass/components/bootstrap-editable.css", array(), _S_VERSION );
		wp_enqueue_script( 'isotope', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'packery', 'https://unpkg.com/packery@2/dist/packery.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'draggabilly', 'https://unpkg.com/draggabilly@2/dist/draggabilly.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'imagesloaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'editable_request', get_template_directory_uri() . '/js/edit-page.js', array(), _S_VERSION, false );
		$obj_id = wp_get_current_user()->data->ID;
		wp_localize_script(
			'editable_request',
			'Edit',
			array(
				'request_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'edit_request' ),
				'locations' => json_encode(__sci_s("USER: Profile details", 'sci_user_location')['choices']),
				'gender' => json_encode(__sci_s("USER: Profile details", 'sci_user_gender')['choices']),
				'categories' => json_encode(get_field('profession', 'user_' . $obj_id)),
			)
		);

	}
	if (is_author()) {
		wp_enqueue_script( 'editable_request', get_template_directory_uri() . '/js/edit-page.js', array(), _S_VERSION, false );
		wp_enqueue_script( 'isotope', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'imagesloaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', array(), false, true );
		wp_localize_script(
			'editable_request',
			'Edit',
			array(
				'request_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'edit_request' ),

			)
		);
	}
	if (is_page( 'spotlight' )){
		wp_enqueue_script( 'like', get_template_directory_uri() . '/js/like.js', array(), _S_VERSION, false );
		wp_localize_script(
			'like',
			'LIKE',
			array(
				'request_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'edit_like' ),
			)
		);
	}
	if (is_page( 'sitewide-search' )){
		wp_enqueue_script( 'sitewide-search', get_template_directory_uri() . '/js/sitewide-search.js', array('jquery'), _S_VERSION, false );
		wp_localize_script(
			'sitewide-search',
			'SEARCH_TALENT',
			array(
				'request_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'sitewide_search' )
			)
		);
	}
}
add_action('wp_head','custom_page_scripts');

function add_stylesheet_attributes( $html, $handle ) {
    if ( 'wp-block-library' === $handle ) {
        $html = str_replace( "media='all'", "media='none' onload=\"if(media!='all')media='all'\" ", $html );
    }
    return $html;
}
add_filter( 'style_loader_tag', 'add_stylesheet_attributes', 10, 2 );

/**
 * Add Headshot 
 */
require get_template_directory() . '/inc/ajax-headshot.php';

/**
 * User Videos 
 */
require get_template_directory() . '/inc/ajax-videos.php';

/**
 * User Audios
 */
require get_template_directory() . '/inc/ajax-audios.php';

/**
 * User Physical Attributes
 */
require get_template_directory() . '/inc/ajax-physcial-attributes.php';

/**
 * User Toggle Profile Visibility
 */
require get_template_directory() . '/inc/ajax-user-hide-show-profile.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Edit profile page
 */
require get_template_directory() . '/inc/edit-page.php';

/**
 * Edit profile likes
 */
require get_template_directory() . '/inc/ajax-like.php';

/**
 * Sitewide search page
 */
require get_template_directory() . '/inc/sitewide-search.php';

/**
 * Implement the Custom Nav Walker feature.
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add Discover Talent PHP functions.
 */
require get_template_directory() . '/inc/functions-discover-talent.php';

/**
 * Add Discover Talent PHP functions.
 */
require get_template_directory() . '/inc/functions-business-moderator.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// My code here

// Custom user role: Spotlight Manager
add_action('after_setup_theme',function(){
	if ( ! get_option('wpc_roles_created')){
		$spotlight_manager_caps = get_role ('administrator')->capabilities;
		$unwanted_caps = [
			'activate_plugins'=> 1,
			'delete_plugins'=> 1,
			'install_plugins'=> 1,
			'update_plugins'=> 1,
		];
		$spotlight_manager_caps = array_diff_key ($spotlight_manager_caps,$unwanted_caps);
		add_role('spotlight_manager','Spotlight Manager',$spotlight_manager_caps);
		update_option( 'wpc_roles_created',true);
	}
});

add_action( 'init' , function(){
		$spotlight_manager_caps = get_role( 'spotlight_manager' );
		$spotlight_manager_caps-> add_cap ('toggle_spotlight_btn');
		$admin = get_role ('administrator');
		$admin-> add_cap ('toggle_spotlight_btn');
} );

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Showcase Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

// Register Custom Post Type
function testimonials() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Testimonials', 'text_domain' ),
		'name_admin_bar'        => __( 'Testimonial', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-testimonial',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'testimonials', 0 );

add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'testimonial',
            'title'             => __('Testimonial'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/testimonial/testimonial.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'testimonial', 'quote' ),
        ));

        acf_register_block_type(array(
            'name'              => 'brands',
            'title'             => __('Brands'),
            'description'       => __('Get found by brands block.'),
            'render_template'   => 'template-parts/blocks/brands/brands.php',
            'category'          => 'formatting',
            'icon'              => 'dashicons-testimonial',
            'keywords'          => array( 'brands' ),
        ));

        acf_register_block_type(array(
            'name'              => 'profile',
            'title'             => __('Profile'),
            'description'       => __('Profile block on the home page.'),
            'render_template'   => 'template-parts/blocks/create_profile/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'profile' ),
        ));

        acf_register_block_type(array(
            'name'              => 'banner',
            'title'             => __('Banner'),
            'description'       => __('Banner block on the home page.'),
            'render_template'   => 'template-parts/blocks/banner/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'banner' ),
        ));

        acf_register_block_type(array(
            'name'              => 'zone',
            'title'             => __('Enter the zone'),
            'description'       => __('Enter the zone block on the home page.'),
            'render_template'   => 'template-parts/blocks/zone/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'zone' ),
        ));

        acf_register_block_type(array(
            'name'              => 'discover',
            'title'             => __('Discover Talent'),
            'description'       => __('Discover Talent block on the home page.'),
            'render_template'   => 'template-parts/blocks/discover/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'discover' ),
        ));

        acf_register_block_type(array(
            'name'              => 'cta',
            'title'             => __('Call to action'),
            'description'       => __('Call to action block on the home page.'),
            'render_template'   => 'template-parts/blocks/cta/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'cta' ),
        ));

        acf_register_block_type(array(
            'name'              => 'join',
            'title'             => __('Join for free'),
            'description'       => __('Join for free block on the home page.'),
            'render_template'   => 'template-parts/blocks/join/block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'join' ),
        ));
    }
}

// Register Custom Post Type
function jobs() {

	$labels = array(
		'name'                  => _x( 'Jobs', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Jobs', 'text_domain' ),
		'name_admin_bar'        => __( 'Jobs', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Job', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'jobs' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-clipboard',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'job', $args );

}
add_action( 'init', 'jobs', 0 );

// Register Custom Taxonomy
function profession() {

	$labels = array(
		'name'                       => _x( 'Job Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Job Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Job Categories', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'jobs', array( 'job' ), $args );

}
add_action( 'init', 'profession', 0 );

/**
 * Rewrite author base to custom
 *
 * @return void
 */
function sci_author_base_rewrite() {
    global $wp_rewrite;
    $author_base_db = get_option( 'sci_author_base' );
    if ( !empty( $author_base_db ) ) {
        $wp_rewrite->author_base = $author_base_db;
    }
}

add_action( 'init', 'sci_author_base_rewrite' );

/**
 * Render textinput for Author base
 * Callback for the add_settings_function()
 *
 * @return void
 */
function sci_author_base_render_field() {
    global $wp_rewrite;
    printf(
        '<input name="sci_author_base" id="sci_author_base" type="text" value="%s" class="regular-text code">',
        esc_attr( $wp_rewrite->author_base )
    );
}

/**
 * Add a setting field for Author Base to the "Optional" Section
 * of the Permalinks Page
 *
 * @return void
 */
function sci_author_base_add_settings_field() {
    add_settings_field(
        'sci_author_base',
        esc_html__( 'Author base' ),
        'sci_author_base_render_field',
        'permalink',
        'optional',
        array( 'label_for' => 'sci_uthor_base' )
    );
}

add_action( 'admin_init', 'sci_author_base_add_settings_field' );

/**
 * Sanitize and save the given Author Base value to the database
 *
 * @return void
 */
function sci_author_base_update() {
    $author_base_db = get_option( 'sci_author_base' );

    if ( isset( $_POST['sci_author_base'] ) &&
        isset( $_POST['permalink_structure'] ) &&
        check_admin_referer( 'update-permalink' )
    ) {
        $author_base = sanitize_title( $_POST['sci_author_base'] );

        if ( empty( $author_base ) ) {
            add_settings_error(
                'sci_author_base',
                'sci_author_base',
                esc_html__( 'Invalid Author Base.' ),
                'error'
            );
        } elseif ( $author_base_db != $author_base ) {
            update_option( 'sci_author_base', $author_base );
        }

    }
}

add_action( 'admin_init', 'sci_author_base_update' );


add_filter( 'authenticate', 'user_lock', 10, 3 );
function user_lock( $user, $username, $password ){
    // Make sure a username and password are present for us to work with
    if($username == '' || $password == '') return;

    $user = get_user_by('login', $username);

	$account_is_deactivated = isset($user->ID) ? get_field('is_deactivated', "user_" . $user->ID) : false ;

    if (!!$account_is_deactivated) {
    	$user = new WP_Error( 'denied', __("Your account has been deactivaed because: \n". get_field('message_to_show', "user_" . $user->ID) ) );
    }else{
    	return $user;
    }
   	
     // Comment this line if you wish to fall back on WordPress authentication
     // Useful for times when the external service is offline
     remove_action('authenticate', 'wp_authenticate_username_password', 20);

     return $user;
}

function hook_header(){
	if (is_page('signup')) {	
		echo '<style type="text/css">';
		echo '#main-header{ text-align: center; }';
		echo '#main-header #logo { text-align: center; float: none; margin: 0 auto; display:block; }';
		echo '.um input[type=submit].um-button {background: #07bb9b;color: #fff;text-transform: capitalize;border: 1px solid #07bb9b; width: 100% !important;}';
		echo '.um input[type=submit].um-button:hover {background: #035445;color: #fff; }';
		echo '</style>';
	}

	if (is_page('login') || is_page('reset-password')) {	
		echo '<style type="text/css">';
		echo '.um input[type=submit].um-button {background: #07bb9b;color: #fff;text-transform: capitalize;border: 1px solid #07bb9b; width: 100% !important;}';
		echo '.um input[type=submit].um-button:hover {background: #035445;color: #fff; }';
		echo '</style>';
	}
	// if(is_page('add-headshot')){
	// 	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng==" crossorigin="anonymous" />';
	// }
}
add_action('wp_head','hook_header');

/* Session start */
function sci_startSession() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'sci_startSession', 1);

/* Storing register submitted data in session */ 
function my_registration_complete( $user_id, $args ) {
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_args'] = $args;

	if(isset($_SESSION['user_social_links']['instagram'])){
		update_user_meta( $user_id, 'sci_user_social_links_instagram', $_SESSION['user_social_links']['instagram']);
		unset($_SESSION['user_social_links']['instagram']);
	}
	if(isset($_SESSION['user_social_links']['facebook'])){
		update_user_meta( $user_id, 'sci_user_social_links_facebook', $_SESSION['user_social_links']['facebook']);
		unset($_SESSION['user_social_links']['facebook']);
	}
	if(isset($_SESSION['user_social_links']['twitter'])){
		update_user_meta( $user_id, 'sci_user_social_links_twitter', $_SESSION['user_social_links']['twitter']);
		unset($_SESSION['user_social_links']['twitter']);
	}
	if(isset($_SESSION['user_social_links']['youtube'])){
		update_user_meta( $user_id, 'sci_user_social_links_youtube', $_SESSION['user_social_links']['youtube']);
		unset($_SESSION['user_social_links']['youtube']);
	}

	if(isset($_SESSION['user_profession'])){
		update_user_meta( $user_id, 'profession', $_SESSION['user_profession']);
		unset($_SESSION['user_profession']);
	}
}
add_action( 'um_registration_complete', 'my_registration_complete', 10, 2 );

function my_custom_mime_types( $mimes ) {
	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	//$mimes['svgz'] = 'image/svg+xml';
	//$mimes['doc'] = 'application/msword';	 
	// Optional. Remove a mime type.
	//unset( $mimes['exe'] );	 
	return $mimes;

}
add_filter( 'upload_mimes', 'my_custom_mime_types' );

add_action( 'template_redirect', 'redirect_to_login_page' );
function redirect_to_login_page($original_template) {

	if ( is_page('edit-profile') && ! is_user_logged_in() ) {

		wp_redirect( get_site_url() . '/login', 301 ); 
  		exit;
    }else{
		return $original_template;
	}
}

//check minimum profile completion
// params: user ID
// return: boolean
function check_user_minimum_profile_completion($user_id){
	$userMinimumProfileComplete = false;
			
	$user_profile_details_complete = false;
	$user_headshot_complete = false;

	$fn_exist = get_user_meta( $user_id, 'first_name', true);
	$ln_exist = get_user_meta( $user_id, 'last_name', true);
	$dob_exist = get_field('sci_user_dob','user_'.$user_id);
	$gender_exist = get_field('sci_user_gender','user_'.$user_id);
	$mobile_exist = get_field('sci_user_mobile','user_'.$user_id);
	$location_exist = get_field('sci_user_location','user_'.$user_id);

	//all profile details
	if($fn_exist && $ln_exist && $dob_exist && $gender_exist && $mobile_exist && $location_exist){
		$user_profile_details_complete = true;
	}
	
	//atleast one headshot
	if(have_rows('sci_user_headshots', 'user_' . $user_id)){
		$user_headshot_complete = true;
	}

	if($user_profile_details_complete && $user_headshot_complete){
		$userMinimumProfileComplete = true;
	}

	return $userMinimumProfileComplete;
}

add_action( 'template_redirect', 'redirect_incomplete_profile' );
function redirect_incomplete_profile($original_template) {

	if ( is_page('edit-profile') && is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$complete = check_user_minimum_profile_completion($user_id);

		if($complete){
			return $original_template;
		}
		wp_redirect(get_page_link(get_page_by_path('welcome'))); 
		exit;
    }
		
	return $original_template;
}

//redirect loggedin users
add_action( 'template_redirect', 'redirect_loggedin_user' );
function redirect_loggedin_user($original_template) {

	if ( is_page('login') && is_user_logged_in() ) {
		wp_redirect(get_page_link(get_page_by_path('edit-profile'))); 
		exit;
    }

	if ( is_page('signup') && is_user_logged_in() ) {
		wp_redirect(get_page_link(get_page_by_path('edit-profile'))); 
		exit;
    }

	return $original_template;
}
