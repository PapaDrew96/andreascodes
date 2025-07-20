<?php
/**
 * andreas functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package andreas
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function andreas_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on andreas, use a find and replace
		* to change 'andreas' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'andreas', get_template_directory() . '/languages' );

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
	register_nav_menus( array(
	'primary'           => esc_html__( 'Primary Menu', 'andreas' ),
	'footer-primary'    => esc_html__( 'Footer Menu', 'andreas' ),
	'footer-secondary'  => esc_html__( 'Footer Menu Secondary', 'andreas' ),
	) );


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
			'andreas_custom_background_args',
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
add_action( 'after_setup_theme', 'andreas_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function andreas_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'andreas_content_width', 640 );
}
add_action( 'after_setup_theme', 'andreas_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function andreas_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'andreas' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'andreas' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'andreas_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function andreas_scripts() {
	// Main theme stylesheet
	wp_enqueue_style( 'andreas-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'andreas-style', 'rtl', 'replace' );

	// Custom theme CSS
	wp_enqueue_style( 'andreas-styles', get_template_directory_uri() . '/css/styles.css', array(), _S_VERSION );

	// ✅ Bootstrap CSS
	wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );

	// Swiper CSS
	wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );

	wp_enqueue_style( 'fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css', [], null );

	// ✅ jQuery
	wp_enqueue_script( 'jquery' );

	// ✅ Bootstrap JS
	wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.3', true );

	// Theme navigation
	wp_enqueue_script( 'andreas-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// Swiper JS
	wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );

	// GSAP + ScrollTrigger
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], '3.12.2', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );

	// Main site script
	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', [ 'jquery', 'swiper-js', 'gsap-scrolltrigger' ], _S_VERSION, true );

	// Fancybox
	wp_enqueue_script( 'fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', [], null, true );

	// Shader cursor
	wp_enqueue_script( 'cursor', get_template_directory_uri() . '/js/cursor.js', [], _S_VERSION, true );

	// ✅ Conditionally load Catch the Stack game only on template
	if ( is_page_template( 'page-catch-the-stack.php' ) ) {
		// Enqueue game-specific CSS
		wp_enqueue_style(
			'catch-the-stack-style',
			get_template_directory_uri() . '/css/game.css',
			[],
			_S_VERSION
		);

		// Enqueue game-specific JS
		wp_enqueue_script(
			'catch-the-stack',
			get_template_directory_uri() . '/js/game.js',
			[],
			_S_VERSION,
			true
		);

		// Get stack icons
		$terms = get_terms([
			'taxonomy' => 'tech_stack',
			'hide_empty' => false,
		]);

		$stack_icons = [];

		foreach ( $terms as $term ) {
			$icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
			if ( $icon && isset( $icon['url'] ) ) {
				$stack_icons[] = [
					'name' => $term->name,
					'url'  => $icon['url'],
				];
			}
		}

		wp_localize_script( 'catch-the-stack', 'STACK_ICONS', $stack_icons );
	}

	
   
	wp_enqueue_script(
            'particlesjs',
            'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'particlesjs-config',
            get_template_directory_uri() . '/js/about-background.js',
            array('particlesjs'),
            null,
            true
        );



	
	// Comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'andreas_scripts' );

function register_rest_routes() {
	
}


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


require get_template_directory() . '/inc/pre_get_posts.php';