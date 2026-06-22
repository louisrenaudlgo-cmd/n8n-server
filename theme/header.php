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

<!-- ── TOPBAR ─────────────────────────────────────────────────────────────── -->
<div class="topbar" role="banner">
  <div class="wrap topbar-inner">

    <div class="topbar-alert">
      <span class="topbar-dot" aria-hidden="true"></span>
      <span class="topbar-badge">Alerte</span>
      <?php
      $ticker = get_option('oca_alert_ticker', 'Surveillance des conventions audiovisuelles — ARCOM');
      echo '<span>' . esc_html($ticker) . '</span>';
      ?>
    </div>

    <div class="topbar-links">
      <a href="<?php echo esc_url(home_url('/contact')); ?>#presse">Espace presse</a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
    </div>

  </div>
</div>

<!-- ── NAV PRINCIPALE ─────────────────────────────────────────────────────── -->
<header id="masthead" class="site-nav">
  <div class="wrap">
    <div class="site-nav-inner">

      <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="OCA — Accueil">
        <span class="logo-abbr">OCA</span>
        <span class="logo-sep" aria-hidden="true"></span>
        <span class="logo-sub">Observatoire Citoyen<br>de l'Audiovisuel</span>
      </a>

      <nav id="site-navigation" class="primary-nav" aria-label="Navigation principale">
        <?php wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => '',
          'fallback_cb'    => false,
          'walker'         => new OCA_Nav_Walker(),
        ]); ?>
      </nav>

      <div class="nav-right">
        <a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>" class="btn-soutenir">
          Nous soutenir
        </a>
        <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="Ouvrir le menu">
          <svg width="18" height="12" viewBox="0 0 18 12" fill="none" aria-hidden="true">
            <rect y="0"  width="18" height="1.5" rx="1" fill="currentColor"/>
            <rect y="5"  width="18" height="1.5" rx="1" fill="currentColor"/>
            <rect y="10" width="18" height="1.5" rx="1" fill="currentColor"/>
          </svg>
        </button>
      </div>

    </div>
  </div>
</header>
