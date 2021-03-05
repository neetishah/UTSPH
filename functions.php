<?php
/**
 * uthsp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package uthsp
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'uthsp_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function uthsp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on uthsp, use a find and replace
		 * to change 'uthsp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'uthsp', get_template_directory() . '/languages' );

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
				'menu-1' => esc_html__( 'Primary', 'uthsp' ),
			)
		);

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
				'uthsp_custom_background_args',
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
add_action( 'after_setup_theme', 'uthsp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function uthsp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uthsp_content_width', 640 );
}
add_action( 'after_setup_theme', 'uthsp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function uthsp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'uthsp' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'uthsp' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'uthsp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function uthsp_scripts() {
	wp_enqueue_style( 'uthsp-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'uthsp-style', 'rtl', 'replace' );

	wp_enqueue_script( 'uthsp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'uthsp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

    
/**
 * Register a custom news post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function create_advanced_posttype() {

	// Define the labels used inside the WordPress admin for this custom post type (CPT)
	$labels = array(
		'name'                => _x( 'News', 'Post Type General Name', 'newsdomain' ),
		'singular_name'       => _x( 'News', 'Post Type Singular Name', 'newsdomain' ),
		'add_new'             => __( 'Add News', 'newsdomain' ),
		'add_new_item'        => __( 'Add New Post', 'newsdomain' ),
		'edit_item'           => __( 'Edit News', 'newsdomain' ),
		'new_item'            => __( 'New Post' ),
		'all_items'           => __( 'All News', 'newsdomain' ),
		'view_item'           => __( 'View News', 'newsdomain' ),
		'search_items'        => __( 'Search News', 'newsdomain' ),
		'menu_name'           => __( 'News', 'newsdomain' ),
		'parent_item_colon'   => __( 'Parent News', 'newsdomain' ),
		'update_item'         => __( 'Update News', 'newsdomain' ),
		'not_found'           => __( 'Not Found', 'newsdomain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'newsdomain' )
	);
		
	// Define more options for the CPT
		
	$args = array(
		'label'               => $labels,
		'description'         => __( 'News information and details', 'newsdomain' ),
		'labels'              => $labels,
		// Define the allowed features in the post editor
		'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'trackbacks', 'post-formats', 'page-attributes', 'custom-fields' ),
		// If hierarchical is true then the CPT behaves like a post. If false, it can have parent and child items like a page. 
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		// menu_position defines where in the WP admin menu the CPT appears. 5 puts it right below posts. The higher the number to lower the CPT will be.
		'menu_position'       => 19,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
		
	// Register this CPT
	register_post_type( 'news', $args );
}
	
// hook into the init action and call create_advanced_posttype when it fires
add_action( 'init', 'create_advanced_posttype', 0 );


/**
 * Add categories Internal and External
 */
function create_news_taxonomy() {
	 
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'newsdomain' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'newsdomain' ),
			'search_items'      => __( 'Search Categories', 'newsdomain' ),
			'all_items'         => __( 'All Categories', 'newsdomain' ),
			'parent_item'       => __( 'Parent Category', 'newsdomain' ),
			'parent_item_colon' => __( 'Parent Category:', 'newsdomain' ),
			'edit_item'         => __( 'Edit Category', 'newsdomain' ),
			'update_item'       => __( 'Update Category', 'newsdomain' ),
			'add_new_item'      => __( 'Add New Category', 'newsdomain' ),
			'new_item_name'     => __( 'New Category Name', 'newsdomain' ),
			'menu_name'         => __( 'Category', 'newsdomain' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'news-type' ),
		);
	
		register_taxonomy( 'news-type', array( 'news' ), $args );
	
		// Add Internal and External categories
		if (!term_exists( 'Internal', 'news-type')){
			wp_insert_term('Internal', 'news-type', array(
				// 'description' => 'From internal source',
				'slug' => 'internal'
			));
		}
		if (!term_exists( 'External', 'news-type')){
			wp_insert_term('External', 'news-type', array(
				// 'description' => 'From external source',
				'slug' => 'external'
			));
		}		
	}
	
	// hook into the init action and call create_news_taxonomy when it fires
	add_action( 'init', 'create_news_taxonomy', 0 );

