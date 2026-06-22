<section class="hero">
  <div class="hero-content">
    <h1>
      <?php esc_html_e('Observer, analyser et promouvoir', 'oca-theme'); ?><br>
      <span><?php esc_html_e('un audiovisuel citoyen', 'oca-theme'); ?></span>
    </h1>
    <p>
      <?php esc_html_e(
        'L\'Observatoire Citoyen de l\'Audiovisuel analyse les médias, défend le pluralisme et accompagne les citoyens dans leur compréhension des paysages médiatiques.',
        'oca-theme'
      ); ?>
    </p>
    <div>
      <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-primary">
        <?php esc_html_e('Nos publications', 'oca-theme'); ?>
      </a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline">
        <?php esc_html_e('Nous contacter', 'oca-theme'); ?>
      </a>
    </div>
  </div>
</section>
