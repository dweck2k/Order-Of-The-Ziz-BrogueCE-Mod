<?php
/**
 * Template Name: משחקים
 * Game page — Order of the Ziz roguelike + cult lore + monster roster
 */
get_header(); ?>

<!-- GAME BANNER -->
<section class="game-banner">
  <div class="game-banner-bg"></div>
  <div class="game-wrap reveal" style="position:relative;z-index:1;">
    <div class="game-pre">משחקים</div>
    <h1 class="game-title-heb">מסדר הזיז</h1>
    <p class="game-title-he">ממעמקי המאורה</p>
    <a href="#game-desc" class="btn btn-blood" style="margin-left:1rem;">קרא את הלור ↓</a>
    <a href="<?php echo esc_url( content_url('uploads/order-of-the-ziz-windows.zip') ); ?>" class="btn" download>⬇ הורד לWindows</a>
  </div>
</section>

<div class="section-wrap" id="game-desc">

  <div class="prose reveal reveal-delay-1">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>

  <!-- כת הזיז LORE -->
  <hr class="hr-blood">
  <div class="section-head reveal">
    <?php codex_eyebrow('היסטוריה סודית'); ?>
    <h3 class="s-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem);">כת הזיז</h3>
    <?php codex_ornament(); ?>
  </div>
  <div class="prose reveal reveal-delay-1">
    <?php echo codex_cult_lore(); ?>
  </div>


</div>

<?php get_footer(); ?>
