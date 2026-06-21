<footer id="colophon" class="site-footer">

  <div class="footer-widgets">

    <div class="footer-widget">
      <h4><?php bloginfo('name'); ?></h4>
      <p style="font-size:.88rem; line-height:1.6; color:rgba(255,255,255,.65);">
        <?php bloginfo('description'); ?>
      </p>
    </div>

    <?php if (is_active_sidebar('footer-1')): ?>
    <div class="footer-widget">
      <?php dynamic_sidebar('footer-1'); ?>
    </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('footer-2')): ?>
    <div class="footer-widget">
      <?php dynamic_sidebar('footer-2'); ?>
    </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('footer-3')): ?>
    <div class="footer-widget">
      <?php dynamic_sidebar('footer-3'); ?>
    </div>
    <?php endif; ?>

    <?php if (has_nav_menu('footer-1')): ?>
    <div class="footer-widget">
      <h4><?php esc_html_e('Liens utiles', 'oca-theme'); ?></h4>
      <?php wp_nav_menu([
        'theme_location' => 'footer-1',
        'container'      => false,
        'depth'          => 1,
        'fallback_cb'    => false,
      ]); ?>
    </div>
    <?php endif; ?>

  </div><!-- .footer-widgets -->

  <div class="footer-bottom">
    <span>
      &copy; <?php echo date('Y'); ?>
      <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    </span>
    <span>·</span>
    <?php wp_nav_menu([
      'theme_location' => 'footer-2',
      'container'      => false,
      'depth'          => 1,
      'fallback_cb'    => false,
      'link_before'    => '',
      'link_after'     => '',
    ]); ?>
  </div>

</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
