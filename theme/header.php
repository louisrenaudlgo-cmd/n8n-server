<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">Aller au contenu</a>

<?php
// Alert ticker (option modifiable depuis l'admin)
$ticker = get_option('oca_alert_ticker', '');
if ($ticker):
?>
<div class="alert-ticker">
  <div class="container">
    <div class="alert-ticker-inner">
      <span class="ticker-badge">⚠ ALERTE</span>
      <span><?php echo esc_html($ticker); ?></span>
    </div>
  </div>
</div>
<?php endif; ?>

<header id="masthead">
  <div class="container">
    <div class="header-inner">

      <?php get_template_part('template-parts/logo'); ?>

      <nav id="site-navigation" class="primary-nav" aria-label="Navigation principale">
        <?php wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => '',
          'fallback_cb'    => false,
          'walker'         => new OCA_Nav_Walker(),
        ]); ?>
      </nav>

      <div class="header-cta">
        <a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>" class="btn btn-primary btn-sm">
          Nous soutenir
        </a>
        <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="Ouvrir le menu">
          <svg width="20" height="14" viewBox="0 0 20 14" fill="none">
            <rect y="0"  width="20" height="2" rx="1" fill="white"/>
            <rect y="6"  width="20" height="2" rx="1" fill="white"/>
            <rect y="12" width="20" height="2" rx="1" fill="white"/>
          </svg>
        </button>
      </div>

    </div>
  </div>
</header>
