<?php
/**
 * Generic fallback template — redirects to front page if no more specific template matches.
 */
get_header(); ?>

<div class="section-wrap">
  <div class="section-head reveal">
    <?php codex_eyebrow('תוכן'); ?>
    <h1 class="s-title"><?php the_title(); ?></h1>
    <?php codex_ornament(); ?>
  </div>
  <div class="prose reveal reveal-delay-1">
    <?php
    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        the_content();
      endwhile;
    endif;
    ?>
  </div>
</div>

<?php get_footer();
