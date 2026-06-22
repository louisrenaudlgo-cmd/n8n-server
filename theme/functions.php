<?php
defined('ABSPATH') || exit;

require_once get_template_directory() . '/inc/nav-walker.php';

// ── Setup ──────────────────────────────────────────────────────────────────────
function oca_setup(): void {
    load_theme_textdomain('oca-theme', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_post_type_support('page', 'excerpt'); // active le champ Extrait sur les pages

    set_post_thumbnail_size(800, 500, true);
    add_image_size('oca-card',   640, 380, true);
    add_image_size('oca-hero',  1920, 700, true);
    add_image_size('oca-thumb',  400, 300, true);

    register_nav_menus([
        'primary'  => 'Menu principal',
        'footer-1' => 'Footer — Liens rapides',
        'footer-2' => 'Footer — Légal',
    ]);
}
add_action('after_setup_theme', 'oca_setup');

function oca_content_width(): void { $GLOBALS['content_width'] = 860; }
add_action('after_setup_theme', 'oca_content_width', 0);

// ── Assets ─────────────────────────────────────────────────────────────────────
function oca_enqueue(): void {
    $v = '2.0.0';

    wp_enqueue_style('oca-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        [], null
    );
    wp_enqueue_style('oca-style', get_stylesheet_uri(), ['oca-fonts'], $v);
    wp_enqueue_script('oca-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [], $v, true
    );

    // Pass KPI data to JS for live countdown/display
    $kpis = [
        'signalements' => get_option('oca_kpi_signalements', '65'),
        'emissions'    => get_option('oca_kpi_emissions',    '23'),
        'transmissions'=> get_option('oca_kpi_transmissions','12'),
        'updated'      => get_option('oca_kpi_updated',      ''),
    ];
    wp_localize_script('oca-main', 'OCA', ['kpis' => $kpis, 'ajaxUrl' => admin_url('admin-ajax.php')]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'oca_enqueue');

// ── Widgets ────────────────────────────────────────────────────────────────────
function oca_widgets(): void {
    $d = ['before_widget'=>'<section class="widget %2$s">','after_widget'=>'</section>',
          'before_title'=>'<h3 class="widget-title">','after_title'=>'</h3>'];

    register_sidebar(array_merge($d, ['name'=>'Sidebar','id'=>'sidebar-1']));
    foreach ([1,2,3] as $i) {
        register_sidebar(array_merge($d, ['name'=>"Footer col $i",'id'=>"footer-$i"]));
    }
}
add_action('widgets_init', 'oca_widgets');

// ── Custom Post Type : Infraction ──────────────────────────────────────────────
function oca_register_cpt(): void {
    register_post_type('infraction', [
        'labels' => [
            'name'          => 'Infractions',
            'singular_name' => 'Infraction',
            'add_new_item'  => 'Ajouter une infraction',
            'edit_item'     => 'Modifier l\'infraction',
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-warning',
        'menu_position' => 5,
        'supports'      => ['title','editor','thumbnail','excerpt','custom-fields'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'infractions'],
        'show_in_rest'  => true,
    ]);

    register_taxonomy('type_infraction', 'infraction', [
        'labels' => ['name'=>'Types', 'singular_name'=>'Type'],
        'public' => true,
        'rewrite'=> ['slug'=>'type-infraction'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('chaine', 'infraction', [
        'labels' => ['name'=>'Chaînes', 'singular_name'=>'Chaîne'],
        'public' => true,
        'rewrite'=> ['slug'=>'chaine'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'oca_register_cpt');

// ── Options page (KPIs + ticker) ───────────────────────────────────────────────
function oca_admin_menu(): void {
    add_options_page('Réglages OCA', 'OCA', 'manage_options', 'oca-settings', 'oca_settings_page');
}
add_action('admin_menu', 'oca_admin_menu');

function oca_settings_page(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('oca_settings')) {
        $fields = ['oca_kpi_signalements','oca_kpi_emissions','oca_kpi_transmissions',
                   'oca_kpi_updated','oca_alert_ticker','oca_semaine_label'];
        foreach ($fields as $f) {
            update_option($f, sanitize_text_field($_POST[$f] ?? ''));
        }
        echo '<div class="notice notice-success"><p>Enregistré ✓</p></div>';
    }
    ?>
    <div class="wrap">
    <h1>Réglages OCA — KPIs & Ticker</h1>
    <form method="post">
    <?php wp_nonce_field('oca_settings'); ?>
    <table class="form-table">
      <tr><th>Signalements documentés</th>
          <td><input name="oca_kpi_signalements" value="<?php echo esc_attr(get_option('oca_kpi_signalements','65')); ?>" class="regular-text"></td></tr>
      <tr><th>Émissions concernées</th>
          <td><input name="oca_kpi_emissions" value="<?php echo esc_attr(get_option('oca_kpi_emissions','23')); ?>" class="regular-text"></td></tr>
      <tr><th>Transmissions ARCOM</th>
          <td><input name="oca_kpi_transmissions" value="<?php echo esc_attr(get_option('oca_kpi_transmissions','12')); ?>" class="regular-text"></td></tr>
      <tr><th>Date de mise à jour</th>
          <td><input name="oca_kpi_updated" value="<?php echo esc_attr(get_option('oca_kpi_updated','')); ?>" class="regular-text" placeholder="ex: 21 juin 2026"></td></tr>
      <tr><th>Label semaine (accroche hero)</th>
          <td><input name="oca_semaine_label" value="<?php echo esc_attr(get_option('oca_semaine_label','Semaine 25 — juin 2026')); ?>" class="regular-text"></td></tr>
      <tr><th>Bandeau d'alerte (laisser vide pour masquer)</th>
          <td><input name="oca_alert_ticker" value="<?php echo esc_attr(get_option('oca_alert_ticker','')); ?>" class="large-text" placeholder="ex: CNews : 65 infractions documentées cette semaine — dossier transmis à l'ARCOM"></td></tr>
    </table>
    <?php submit_button('Enregistrer'); ?>
    </form>
    </div>
    <?php
}

// ── Editor palette ──────────────────────────────────────────────────────────────
add_action('after_setup_theme', function(): void {
    add_theme_support('editor-color-palette', [
        ['name'=>'Marine OCA',   'slug'=>'marine',  'color'=>'#0D1F3C'],
        ['name'=>'Bleu France',  'slug'=>'france',  'color'=>'#1855A3'],
        ['name'=>'Cyan Signal',  'slug'=>'cyan',    'color'=>'#00C5E7'],
        ['name'=>'Rouge Alerte', 'slug'=>'alert',   'color'=>'#E63946'],
        ['name'=>'Blanc',        'slug'=>'white',   'color'=>'#FFFFFF'],
    ]);
});

// ── Misc ───────────────────────────────────────────────────────────────────────
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('excerpt_length', fn() => 20);
add_filter('excerpt_more',   fn() => '…');

add_filter('body_class', function(array $c): array {
    if (!is_active_sidebar('sidebar-1') || is_page()) $c[] = 'no-sidebar';
    return $c;
});
