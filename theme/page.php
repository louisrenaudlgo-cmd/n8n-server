<?php get_header(); ?>

<main id="primary" class="site-main">
  <div class="container" style="padding:3rem 1.5rem; max-width:900px;">

    <?php while (have_posts()): the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
          <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header>

        <div class="entry-content" style="margin-top:1.5rem;">
          <?php the_content(); ?>
        </div>

      </article>
    <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
