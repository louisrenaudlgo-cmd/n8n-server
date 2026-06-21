<?php get_header(); ?>

<div class="page-hero" style="padding:2.5rem 0;">
  <div class="container">
    <p class="page-hero-tag">
      <?php
      $cats = get_the_category();
      echo $cats ? esc_html($cats[0]->name) : 'Article';
      ?>
    </p>
    <?php the_title('<h1 style="font-size:clamp(1.5rem,3vw,2rem); font-weight:800; margin-bottom:.5rem;">','</h1>'); ?>
    <p style="font-size:.85rem; color:rgba(255,255,255,.6);">
      <?php echo get_the_date(); ?> · <?php the_author(); ?>
    </p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">
  <div class="container" style="padding:3rem 1.5rem;">
    <div style="display:grid; grid-template-columns:1fr 280px; gap:3rem; align-items:start; max-width:1100px; margin:0 auto;">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (has_post_thumbnail()): ?>
          <div style="border-radius:var(--r-lg); overflow:hidden; margin-bottom:2rem;">
            <?php the_post_thumbnail('oca-hero', ['style'=>'width:100%; height:400px; object-fit:cover;']); ?>
          </div>
        <?php endif; ?>

        <div class="entry-content">
          <?php the_content(); ?>
        </div>

        <footer style="margin-top:2rem; padding-top:1rem; border-top:1px solid var(--gray-200);">
          <?php the_tags('<div style="font-size:.8rem; color:var(--gray-400);">','  ','</div>'); ?>
        </footer>

        <?php if (comments_open() || get_comments_number()): ?>
          <div style="margin-top:2.5rem;"><?php comments_template(); ?></div>
        <?php endif; ?>
      </article>

      <aside>
        <?php dynamic_sidebar('sidebar-1'); ?>
      </aside>

    </div>
  </div>
</main>

<?php get_footer(); ?>
