<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

error_reporting(E_ALL ^ E_DEPRECATED);

/**
 * Register the theme assets.
 *
 * @return void
 */

define('JQUERY_FILE', 'https://code.jquery.com/jquery-3.6.0.min.js');
define('JQUERY_HASH', 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=');

define('CFG__REMOTE_DATA', WP_ENV == 'development' ? 'http://localhost/~giantpaper/~namesdata' : 'https://data.namefiles.co');

add_action('wp_enqueue_scripts', function () {
	global $post, $wp, $wp_query;

	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', JQUERY_FILE, null, false);
	}

	wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/7cc7cea40d.js', null, true);
	wp_enqueue_style('typekit', 'https://use.typekit.net/hnp5fhi.css?v=3.2', false, null);
	bundle('app')->enqueue();

	define('NAME_TITLE', $wp_query->is_singular( 'name' ) ? str_replace('-2', '', $post->post_name) : get_query_var('s') );
	// define('SHOW_GRAPH', false);
	define('SHOW_GRAPH', ( $wp_query->is_singular('name') || $wp_query->is_search() ) && json_decode(file_get_contents(CFG__REMOTE_DATA . '/json.php?mode=stats&country=us&which=by_name&slug=' . NAME_TITLE)) != null );

	$localize = [
		'urls' => [
			'home' => get_home_url(),
			'graph' => CFG__REMOTE_DATA,
			'edit' => '/wp/wp-admin/post.php?post=%s&action=edit',
		],
	];

	$term_list = [];
	$loop_terms = ['gender', 'nametype', 'origin'];

	foreach ($loop_terms as $term) {
		foreach ( get_terms($term) as $gender) {
			$term_list[$term][$gender->term_id] = [
				'slug' => $gender->slug,
				'title' => $gender->name,
			];
		}
	}

	$localize['terms'] = $term_list;

	if (SHOW_GRAPH) {
		function have_name_data() {
			$json = json_decode(file_get_contents(CFG__REMOTE_DATA.CFG__REMOTE_JSON_FILE . '&country=' .CFG__COUNTRY. '&slug=' . NAME_TITLE), true);

			return !empty(array_pop($json));
		}
		define('CFG__COUNTRY', 'us');
		define('CFG__REMOTE_JSON_FILE', '/json.php?mode=stats&which=by_name');
		$localize['post']['info']['slug'] = NAME_TITLE;
		$localize['endpoints']['stats'] = CFG__REMOTE_JSON_FILE;
		$localize['nameData'] = have_name_data();
	}

	wp_localize_script('app/1', 'TNF', $localize);


	add_filter('script_loader_tag', function ($src, $handle) {
		$new_attr = null;
		switch ($handle) {
		case 'jquery':
			if (!is_admin()) {
				$new_attr = 'integrity="' .JQUERY_HASH. '" crossorigin="anonymous"';
			}
			break;
		case 'fontawesome':
			$new_attr = 'crossorigin="anonymous"';
			break;
		default:
			$new_attr = null;
		}

		$src = str_replace('></script>', ' ' .$new_attr. '></script>', $src);

		return $src;
	}, 10, 2);

	add_filter('body_class', function($classes){

		$classes[] = 'site';

		if ( is_front_page() )
			$classes[] = 'front-page';

		if ( SHOW_GRAPH )
			$classes[] = 'show-graph';

		return $classes;
	});

}, 100);

add_action( 'wp_default_scripts', function( $scripts ) {
	if ( !is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];

		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array(
				'jquery-migrate'
			) );
		}
	}
} );
/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
	bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
	/**
	 * Enable features from the Soil plugin if activated.
	 * @link https://roots.io/plugins/soil/
	 */
	add_theme_support('soil', [
		'clean-up',
		'nav-walker',
		'nice-search',
		'relative-urls',
	]);

	/**
	 * Disable full-site editing support.
	 *
	 * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
	 */
	remove_theme_support('block-templates');

	/**
	 * Register the navigation menus.
	 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
	 */
	register_nav_menus([
		'primary_navigation' => __('Primary Navigation', 'sage'),
	]);

	/**
	 * Disable the default block patterns.
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
	 */
	remove_theme_support('core-block-patterns');

	/**
	 * Enable plugins to manage the document title.
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
	 */
	add_theme_support('title-tag');

	/**
	 * Enable post thumbnail support.
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	/**
	 * Enable responsive embed support.
	 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
	 */
	add_theme_support('responsive-embeds');

	/**
	 * Enable HTML5 markup support.
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
	 */
	add_theme_support('html5', [
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
		'script',
		'style',
	]);

	/**
	 * Enable selective refresh for widgets in customizer.
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
	 */
	add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
	$config = [
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	];

	register_sidebar([
		'name' => __('Primary', 'sage'),
		'id' => 'sidebar-primary',
	] + $config);

	register_sidebar([
		'name' => __('Footer', 'sage'),
		'id' => 'sidebar-footer',
	] + $config);
});


add_action('template_redirect', function (){
	if(is_search() && !empty($_GET['s'])){
		wp_redirect(home_url("/search/"). urlencode(get_query_var('s')));
		exit();
	}
});
/* --------------
 * ACF Options
 * --------------
 */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page([
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'tnf_settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-admin-tools',
	]);

	acf_add_options_page([
		'page_title' 	=> 'Graph FAQs',
		'menu_title'	=> 'Graph FAQs',
		'menu_slug' 	=> 'tnf_graph_faqs',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'parent_slug'	=> 'tnf_settings',
	]);

}

include 'tnf_functions.php';
