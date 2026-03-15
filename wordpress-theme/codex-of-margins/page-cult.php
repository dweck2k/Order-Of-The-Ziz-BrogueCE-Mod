<?php
/**
 * Template Name: כת הזיז
 * The Cult of the Ziz lore page
 */
get_header(); ?>

<div class="section-wrap">
  <div class="section-head reveal">
    <?php codex_eyebrow('לור הקאלט'); ?>
    <h2 class="s-title">כת הזיז</h2>
    <?php codex_ornament(); ?>
    <p class="s-sub">מסורה זו מחכה במרחב מוגן</p>
  </div>

  <div class="prose reveal reveal-delay-1">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>

  <!-- MONSTER ROSTER — managed via Admin > יצורים -->
  <?php
  $monsters = get_posts(['post_type'=>'monster','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
  if ( $monsters ) : ?>
  <hr class="hr-blood">
  <div class="section-head reveal">
    <?php codex_eyebrow('יצורי המאורה'); ?>
    <h3 class="s-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem);">יצורי הקודקס</h3>
    <?php codex_ornament(); ?>
  </div>
  <div class="monsters-grid">
    <?php foreach ( $monsters as $i => $mon ) :
      $pre   = get_post_meta( $mon->ID, '_monster_pre', true );
      $delay = $i % 3 === 0 ? '' : ( $i % 3 === 1 ? ' reveal-delay-1' : ' reveal-delay-2' );
    ?>
    <div class="card reveal<?php echo $delay; ?>" style="cursor:default;padding:1.6rem 1.4rem;">
      <div class="card-pre"><?php echo esc_html( $pre ); ?></div>
      <div class="card-title" style="font-size:1.1rem;"><?php echo esc_html( $mon->post_title ); ?></div>
      <p class="card-body" style="font-size:0.88rem;"><?php echo esc_html( wp_strip_all_tags( $mon->post_excerpt ?: $mon->post_content ) ); ?></p>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

</div>

<?php get_footer();
