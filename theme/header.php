<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">
  <?php esc_html_e('Aller au contenu', 'oca-theme'); ?>
</a>

<header id="masthead" class="site-header">
  <div class="site-header-inner">

    <div class="site-branding">
      <?php if (has_custom_logo()): ?>
        <div class="site-logo"><?php the_custom_logo(); ?></div>
      <?php endif; ?>
      <div>
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
        <?php $desc = get_bloginfo('description', 'display');
        if ($desc): ?>
          <p class="site-description"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>
      </div>
    </div><!-- .site-branding -->

    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Menu principal', 'oca-theme'); ?>">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        ☰
      </button>
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'container'      => false,
        'fallback_cb'    => false,
      ]); ?>
    </nav>

  </div>
</header><!-- #masthead -->
