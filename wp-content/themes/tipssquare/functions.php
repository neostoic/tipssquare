<?php
/**
 * tipssquare functions and definitions
 *
 * @package tipssquare
 * @since tipssquare 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since tipssquare 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'tipssquare_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since tipssquare 1.0
 */
function tipssquare_setup() 
{

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on tipssquare, use a find and replace
	 * to change 'tipssquare' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tipssquare', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tipssquare' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // tipssquare_setup
add_action( 'after_setup_theme', 'tipssquare_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function tipssquare_register_custom_background() 
{
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'tipssquare_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'tipssquare_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since tipssquare 1.0
 */
function tipssquare_widgets_init() 
{
	register_sidebar( array(
		'name' => __( 'Sidebar', 'tipssquare' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'tipssquare_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function tipssquare_scripts() 
{
	// enqueue base style sheets
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'ts-style', get_template_directory_uri() . '/assets/css/style.css' );

	// add google fonts
	wp_enqueue_style( 'gf-bowlby-one-sc', "http://fonts.googleapis.com/css?family=Bowlby+One+SC" );
	wp_enqueue_style( 'gf-open-sans', "http://fonts.googleapis.com/css?family=Open+Sans" );

	if(!is_front_page())
	{
		wp_enqueue_style( 'ts-layout', get_template_directory_uri() . '/assets/css/layouts/content-sidebar.css' );
	}
	
	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/assets/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
	{
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) 
	{
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'tipssquare_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );
