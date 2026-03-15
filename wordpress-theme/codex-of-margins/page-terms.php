<?php
/**
 * Template Name: תקנון שימוש
 * Terms of use page — content managed via WP editor
 */
get_header(); ?>

<div class="section-wrap">
  <div class="section-head reveal">
    <?php codex_eyebrow('משפטי'); ?>
    <h2 class="s-title">תקנון שימוש</h2>
    <?php codex_ornament(); ?>
  </div>

  <div class="prose reveal reveal-delay-1">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>
</div>

<?php get_footer();
