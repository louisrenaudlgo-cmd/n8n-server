<?php get_header(); ?>

<main id="primary">
  <div class="container container--narrow" style="padding:3rem 1.5rem;">
    <?php while (have_posts()): the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php the_title('<h1 class="entry-title" style="margin-bottom:1.5rem;">','</h1>'); ?>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php get_footer(); ?>
