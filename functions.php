<?php
function wp_styles_scripts() {
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/lib/bootstrap/css/bootstrap.min.css', array(), null, 'all');
	wp_enqueue_style('fontawesome', get_template_directory_uri().'/lib/fontawesome/css/all.min.css', array(), null, 'all');
	wp_enqueue_style('main', get_template_directory_uri().'/css/main.css', array(), null, 'all');
    wp_enqueue_script('instagram', get_template_directory_uri().'/lib/instagram/instagram.min.js', array('jquery'), null, null);
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/lib/bootstrap/js/bootstrap.min.js', array('jquery'), null, null);
    wp_enqueue_script('fontawesome',get_template_directory_uri().'/lib/fontawesome/js/all.min.js', array('jquery'), null, null);
    wp_enqueue_script('custom', get_template_directory_uri().'/js/custom.js', array('jquery'), null, null);
}
add_action('wp_enqueue_scripts', 'wp_styles_scripts');
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_resource_hints', 2);
add_filter('use_default_gallery_style', '__return_false');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );

function extend_body_class($classes)
{
    $include = array
    (
        'is-archive'           => is_archive(),
        'is-post_type_archive' => is_post_type_archive(),
        'is-attachment'        => is_attachment(),
        'is-author'            => is_author(),
        'is-category'          => is_category(),
        'is-tag'               => is_tag(),
        'is-tax'               => is_tax(),
        'is-date'              => is_date(),
        'is-day'               => is_day(),
        'is-feed'              => is_feed(),
        'is-comment-feed'      => is_comment_feed(),
        'is-front-page'        => is_front_page(),
        'is-home'              => is_home(),
        'is-privacy-policy'    => is_privacy_policy(),
        'is-month'             => is_month(),
        'is-page'              => is_page(),
        'is-paged'             => is_paged(),
        'is-preview'           => is_preview(),
        'is-robots'            => is_robots(),
        'is-search'            => is_search(),
        'is-single'            => is_single(),
        'is-singular'          => is_singular(),
        'is-time'              => is_time(),
        'is-trackback'         => is_trackback(),
        'is-year'              => is_year(),
        'is-404'               => is_404(),
        'is-embed'             => is_embed(),
        //'contact'              => is_page('contact'),
    );
    foreach ( $include as $class => $do_include )
    {
        if ( $do_include ) $classes[ $class ] = $class;
    }
    return $classes;
}
add_filter('body_class', 'extend_body_class');

function register_improv_sidebars() {
    register_sidebar( array(
        'name'          => __('Logo', 'improv'),
        'id'            => 'logo',
        'before_widget' => null,
        'after_widget'  => null,
        'before_title'  => null,
        'after_title'   => null,
    ));
    register_sidebar( array(
        'name'          => __('Social Links', 'improv'),
        'id'            => 'social',
        'before_widget' => null,
        'after_widget'  => null,
        'before_title'  => null,
        'after_title'   => null,
    ));
    register_sidebar( array(
        'name'          => __('Home Fixed Photo', 'improv'),
        'id'            => 'fixed-photo',
        'before_widget' => '<section class="fixed-photo">',
        'after_widget'  => '</section>',
        'before_title'  => null,
        'after_title'   => null,
    ));
    register_sidebar( array(
        'name'          => __('Home Block Left', 'improv'),
        'id'            => 'block-l',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar( array(
        'name'          => __('Home Block Mid', 'improv'),
        'id'            => 'block-m',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar( array(
        'name'          => __('Home Block Right', 'improv'),
        'id'            => 'block-r',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar( array(
        'name'          => __('Board Members', 'improv'),
        'id'            => 'board-members',
        'before_widget' => '<article class="boardmember">',
        'after_widget'  => '</article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __('committees', 'improv'),
        'id'            => 'committees-page',
        'before_widget' => '<article class="committee">',
        'after_widget'  => '</article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __('Documents', 'improv'),
        'id'            => 'documents',
        'before_widget' => '<article class="document">',
        'after_widget'  => '</article>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar( array(
        'name'          => __('Contact Maps', 'improv'),
        'id'            => 'contact-maps',
        'before_widget' => '<figure class="map">',
        'after_widget'  => '</figure>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'register_improv_sidebars');

function register_navwalker(){
    require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme','register_navwalker');
register_nav_menus( array(
    'primary' => __( 'Primary', 'improv' ),
) );

/* add slugs to admin columns */
function set_slug_column($columns) {
    $columns['slug'] = 'Slug';
    return $columns;
}
function slug_in_column($column, $post_id) {
    if ('slug' === $column ) {
        echo get_post_field('post_name', get_post());
    }
}
/* Posts */
add_filter('manage_post_posts_columns', 'set_slug_column');
add_action( 'manage_post_posts_custom_column', 'slug_in_column', 5, 2);
/* Pages */
add_filter('manage_pages_columns', 'set_slug_column');
add_action( 'manage_pages_custom_column', 'slug_in_column', 10, 2);
/* Games */
add_filter('manage_games_posts_columns', 'set_slug_column');
add_action( 'manage_games_posts_custom_column', 'slug_in_column', 5, 2);

// Add Custom Post Type 'Games' & Services

function add_cpt_games() {
    register_post_type('games',
        array(
            'labels' => array(
                'name'                => __( 'Games', 'Post Type General Name', 'improv' ),
                'singular_name'       => __( 'Game', 'Post Type Singular Name', 'improv' ),
                'menu_name'           => __( 'Games', 'improv' ),
                'parent_item_colon'   => __( 'Referral Game', 'improv' ),
                'all_items'           => __( 'All Games', 'improv' ),
                'view_item'           => __( 'View Game', 'improv' ),
                'add_new_item'        => __( 'Add New Game', 'improv' ),
                'add_new'             => __( 'Add New', 'improv' ),
                'edit_item'           => __( 'Edit Game', 'improv' ),
                'update_item'         => __( 'Update Game', 'improv' ),
                'search_items'        => __( 'Search Game', 'improv' ),
                'not_found'           => __( 'Not Found', 'improv' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'improv' ),
            ),
            'description' => 'Game database',
            'public' => true,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title','excerpt','editor','revisions'),
            'taxonomies' => array('soort'),
            'has_archive' => 'games',
            'rewrite' => array('slug' => 'game','with_front' => false),
            'delete_with_user' => false,
        )
    );
    $labels = array(
        'name'              => _x( 'Type', 'taxonomy general name', 'improv' ),
        'singular_name'     => _x( 'Type', 'taxonomy singular name', 'improv' ),
        'search_items'      => __( 'Zoeken in Type', 'improv' ),
        'all_items'         => __( 'Alle Type', 'improv' ),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => __( 'Type bewerken', 'improv' ),
        'update_item'       => __( 'Type bijwerken', 'improv' ),
        'add_new_item'      => __( 'Type toevoegen', 'improv' ),
        'new_item_name'     => __( 'Nieuwe Typenaam', 'improv' ),
        'menu_name'         => __( 'Type', 'improv' ),
    );
    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'gametype'),
        'has_archive'       => true,
        'update_count_callback' => '_update_post_term_count',
        );
    register_taxonomy('soort', array('games'), $args);
}
add_action( 'init', 'add_cpt_games' );
function add_cpt_services() {
    register_post_type( 'services',
        array(
            'labels' => array(
                'name'                => __( 'Services', 'Post Type General Name', 'improv' ),
                'singular_name'       => __( 'Service', 'Post Type Singular Name', 'improv' ),
                'menu_name'           => __( 'Services', 'improv' ),
                'parent_item_colon'   => __( 'Referral Service', 'improv' ),
                'all_items'           => __( 'All Services', 'improv' ),
                'view_item'           => __( 'View Service', 'improv' ),
                'add_new_item'        => __( 'Add New Service', 'improv' ),
                'add_new'             => __( 'Add New', 'improv' ),
                'edit_item'           => __( 'Edit Service', 'improv' ),
                'update_item'         => __( 'Update Service', 'improv' ),
                'search_items'        => __( 'Search Service', 'improv' ),
                'not_found'           => __( 'Not Found', 'improv' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'improv' ),
            ),
            'description' => 'Services',
            'public' => true,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' => array('title','excerpt','editor','revisions','custom-fields'),
            'taxonomies' => array('tag'),
            'has_archive' => 'services',
            'rewrite' => array('slug' => 'service'),
            'delete_with_user' => false,
        )
    );
}
add_action( 'init', 'add_cpt_services' );

add_filter( 'tec_views_v2_subscribe_link_gcal_visibility', '__return_false', 10 );
add_filter( 'tec_views_v2_subscribe_link_ical_visibility', '__return_false', 10 );

include_once('func_caps.php');
include_once('func_comments.php');
include_once('func_emojis.php');
include_once('func_yoast.php');
