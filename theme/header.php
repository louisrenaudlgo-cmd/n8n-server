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
<div class="topbar">
  <div class="wrap topbar-inner">
    <?php $ticker = get_option('oca_alert_ticker', ''); ?>
    <div class="topbar-alert">
      <span class="topbar-dot"></span>
      <?php if ($ticker): ?>
        <span><?php echo esc_html($ticker); ?></span>
      <?php else: ?>
        <span>Observatoire Citoyen de l'Audiovisuel — surveillance des conventions ARCOM</span>
      <?php endif; ?>
    </div>
    <div class="topbar-links">
      <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
      <a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>">Nous soutenir</a>
    </div>
  </div>
</div>

<!-- ── NAV PRINCIPALE ─────────────────────────────────────────────────────── -->
<header id="masthead" class="site-nav">
  <div class="wrap">
    <div class="site-nav-inner">

      <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="OCA — Accueil">
        <?php get_template_part('template-parts/logo'); ?>
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
          <svg width="20" height="14" viewBox="0 0 20 14" fill="none">
            <rect y="0"  width="20" height="2" rx="1" fill="currentColor"/>
            <rect y="6"  width="20" height="2" rx="1" fill="currentColor"/>
            <rect y="12" width="20" height="2" rx="1" fill="currentColor"/>
          </svg>
        </button>
      </div>

    </div>
  </div><!-- .wrap -->
</header>
