<?php get_header(); ?>

<main id="primary" class="site-main">

  <?php get_template_part('template-parts/hero'); ?>

  <div class="accent-bar"></div>

  <section style="padding:4rem 0; background:var(--oca-light);">
    <div class="container">
      <h2 class="section-title"><?php esc_html_e('Dernières actualités', 'oca-theme'); ?></h2>
      <p class="section-subtitle"><?php esc_html_e("Toute l'actualité de l'audiovisuel citoyen", 'oca-theme'); ?></p>

      <?php
      $recent = new WP_Query(['posts_per_page' => 6, 'post_status' => 'publish']);
      if ($recent->have_posts()):
      ?>
      <div class="cards-grid">
        <?php while ($recent->have_posts()): $recent->the_post(); ?>
          <?php get_template_part('template-parts/card'); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else: ?>
        <p style="color:var(--oca-gray);"><?php esc_html_e('Les articles apparaîtront ici une fois publiés.', 'oca-theme'); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/stats-band'); ?>

</main>

<?php get_footer(); ?>
