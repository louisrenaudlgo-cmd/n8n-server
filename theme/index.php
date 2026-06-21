<?php get_header(); ?>

<main id="primary" class="site-main">

  <?php if (is_front_page() && !is_home()): ?>
    <!-- Static front page: show hero only -->
    <?php get_template_part('template-parts/hero'); ?>
    <div class="accent-bar"></div>

    <section style="padding:4rem 0; background:var(--oca-light);">
      <div class="container">
        <h2 class="section-title"><?php esc_html_e('Dernières actualités', 'oca-theme'); ?></h2>
        <p class="section-subtitle"><?php esc_html_e('Toute l\'actualité de l\'audiovisuel citoyen', 'oca-theme'); ?></p>

        <?php
        $recent = new WP_Query(['posts_per_page' => 6]);
        if ($recent->have_posts()):
        ?>
        <div class="cards-grid">
          <?php while ($recent->have_posts()): $recent->the_post(); ?>
            <?php get_template_part('template-parts/card'); ?>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <?php get_template_part('template-parts/stats-band'); ?>

  <?php else: ?>
    <!-- Blog / archive -->
    <div class="container" style="padding:3rem 1.5rem;">
      <div style="display:grid; grid-template-columns:1fr 300px; gap:2.5rem; align-items:start;">

        <div>
          <?php if (is_home() && !is_front_page()): ?>
            <h1 class="section-title"><?php esc_html_e('Actualités', 'oca-theme'); ?></h1>
          <?php elseif (is_category() || is_tag() || is_archive()): ?>
            <h1 class="section-title"><?php the_archive_title(); ?></h1>
            <?php the_archive_description('<p class="section-subtitle">', '</p>'); ?>
          <?php elseif (is_search()): ?>
            <h1 class="section-title">
              <?php printf(esc_html__('Résultats pour : %s', 'oca-theme'), get_search_query()); ?>
            </h1>
          <?php endif; ?>

          <?php if (have_posts()): ?>
            <div class="cards-grid" style="grid-template-columns:1fr 1fr;">
              <?php while (have_posts()): the_post(); ?>
                <?php get_template_part('template-parts/card'); ?>
              <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(['mid_size' => 2, 'class' => 'pagination']); ?>
          <?php else: ?>
            <p><?php esc_html_e('Aucun article trouvé.', 'oca-theme'); ?></p>
          <?php endif; ?>
        </div>

        <aside id="secondary" class="widget-area">
          <?php dynamic_sidebar('sidebar-1'); ?>
        </aside>

      </div>
    </div>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
