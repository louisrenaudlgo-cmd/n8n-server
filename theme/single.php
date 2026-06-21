<?php get_header(); ?>

<main id="primary" class="site-main">
  <div class="container" style="padding:3rem 1.5rem;">
    <div style="display:grid; grid-template-columns:1fr 300px; gap:2.5rem; align-items:start;">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
          <?php if (has_post_thumbnail()): ?>
            <div style="border-radius:var(--radius-lg); overflow:hidden; margin-bottom:1.75rem;">
              <?php the_post_thumbnail('oca-hero', ['style' => 'width:100%; height:420px; object-fit:cover;']); ?>
            </div>
          <?php endif; ?>

          <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

          <div class="entry-meta">
            <?php echo esc_html(get_the_date()); ?>
            <?php $cats = get_the_category_list(', ');
            if ($cats): ?> · <?php echo $cats; endif; ?>
            <?php if (get_the_author()): ?> · <?php the_author(); ?> <?php endif; ?>
          </div>
        </header>

        <div class="entry-content" style="margin-top:1.75rem;">
          <?php the_content(); ?>
          <?php wp_link_pages(['before' => '<div class="page-links">', 'after' => '</div>']); ?>
        </div>

        <footer class="entry-footer" style="margin-top:2rem; padding-top:1rem; border-top:1px solid var(--oca-border);">
          <?php the_tags('<div style="font-size:.85rem; color:var(--oca-gray);">' . __('Tags : ', 'oca-theme'), ', ', '</div>'); ?>
        </footer>

        <?php if (comments_open() || get_comments_number()): ?>
          <div style="margin-top:2.5rem;">
            <?php comments_template(); ?>
          </div>
        <?php endif; ?>

      </article>

      <aside id="secondary" class="widget-area">
        <?php dynamic_sidebar('sidebar-1'); ?>
      </aside>

    </div>
  </div>
</main>

<?php get_footer(); ?>
