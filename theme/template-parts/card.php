<article class="card">

  <?php if (has_post_thumbnail()): ?>
  <div class="card-thumbnail">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('oca-card'); ?>
    </a>
    <?php $cats = get_the_category();
    if ($cats): ?>
      <span class="card-category"><?php echo esc_html($cats[0]->name); ?></span>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <div class="card-body">
    <p class="card-meta"><?php echo esc_html(get_the_date()); ?></p>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p><?php the_excerpt(); ?></p>
  </div>

  <div class="card-footer">
    <a href="<?php the_permalink(); ?>" class="read-more">
      <?php esc_html_e('Lire la suite →', 'oca-theme'); ?>
    </a>
    <?php if (get_the_author()): ?>
      <span style="font-size:.78rem; color:var(--oca-gray);"><?php the_author(); ?></span>
    <?php endif; ?>
  </div>

</article>
