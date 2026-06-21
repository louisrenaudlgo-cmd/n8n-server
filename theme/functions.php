<?php
/**
 * OCA Theme – functions.php
 */

defined('ABSPATH') || exit;

// ── Setup ──────────────────────────────────────────────────────────────────────
function oca_setup(): void {
    load_theme_textdomain('oca-theme', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    set_post_thumbnail_size(800, 480, true);
    add_image_size('oca-card', 640, 380, true);
    add_image_size('oca-hero', 1920, 700, true);

    register_nav_menus([
        'primary'  => __('Menu principal',  'oca-theme'),
        'footer-1' => __('Footer – Liens',  'oca-theme'),
        'footer-2' => __('Footer – Légal',  'oca-theme'),
    ]);
}
add_action('after_setup_theme', 'oca_setup');

// ── Content width ──────────────────────────────────────────────────────────────
function oca_content_width(): void {
    $GLOBALS['content_width'] = 860;
}
add_action('after_setup_theme', 'oca_content_width', 0);

// ── Enqueue assets ─────────────────────────────────────────────────────────────
function oca_enqueue_assets(): void {
    $v = wp_get_theme()->get('Version');

    // Google Fonts
    wp_enqueue_style(
        'oca-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style('oca-style', get_stylesheet_uri(), ['oca-fonts'], $v);

    // Main script
    wp_enqueue_script(
        'oca-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $v,
        true
    );

    // Comment reply
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'oca_enqueue_assets');

// ── Widgets / sidebars ─────────────────────────────────────────────────────────
function oca_widgets_init(): void {
    $defaults = [
        'before_widget' => '<section class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar(array_merge($defaults, [
        'name'        => __('Sidebar', 'oca-theme'),
        'id'          => 'sidebar-1',
        'description' => __('Sidebar principale', 'oca-theme'),
    ]));

    register_sidebar(array_merge($defaults, [
        'name'        => __('Footer – Colonne 1', 'oca-theme'),
        'id'          => 'footer-1',
    ]));

    register_sidebar(array_merge($defaults, [
        'name'        => __('Footer – Colonne 2', 'oca-theme'),
        'id'          => 'footer-2',
    ]));

    register_sidebar(array_merge($defaults, [
        'name'        => __('Footer – Colonne 3', 'oca-theme'),
        'id'          => 'footer-3',
    ]));
}
add_action('widgets_init', 'oca_widgets_init');

// ── Excerpt length ─────────────────────────────────────────────────────────────
add_filter('excerpt_length', fn() => 25);
add_filter('excerpt_more',   fn() => ' …');

// ── Body classes ───────────────────────────────────────────────────────────────
function oca_body_classes(array $classes): array {
    if (is_singular()) {
        $classes[] = 'singular';
    }
    if (!is_active_sidebar('sidebar-1') || is_page()) {
        $classes[] = 'no-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'oca_body_classes');

// ── Custom block colors (editor palette) ───────────────────────────────────────
function oca_editor_colors(): void {
    add_theme_support('editor-color-palette', [
        ['name' => 'Bleu marine',  'slug' => 'navy',  'color' => '#0d2c6b'],
        ['name' => 'Cyan OCA',     'slug' => 'cyan',  'color' => '#00c8e8'],
        ['name' => 'Rouge OCA',    'slug' => 'red',   'color' => '#d42b2b'],
        ['name' => 'Blanc',        'slug' => 'white', 'color' => '#ffffff'],
        ['name' => 'Fond clair',   'slug' => 'light', 'color' => '#f4f7fb'],
    ]);
}
add_action('after_setup_theme', 'oca_editor_colors');

// ── Disable emoji scripts ──────────────────────────────────────────────────────
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// ── Remove query string from static assets ─────────────────────────────────────
add_filter('script_loader_src', 'oca_remove_query_ver', 15, 1);
add_filter('style_loader_src',  'oca_remove_query_ver', 15, 1);
function oca_remove_query_ver(string $src): string {
    return $src ? esc_url(remove_query_arg('ver', $src)) : $src;
}
