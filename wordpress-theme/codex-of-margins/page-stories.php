<?php
/**
 * Template Name: סיפורות
 * Stories index — list + inline reading of ממעמקים
 */
get_header();

// Legacy ?story=mamaamakim URL → redirect to proper CPT permalink
if ( isset( $_GET['story'] ) && sanitize_key( $_GET['story'] ) === 'mamaamakim' ) {
    wp_redirect( home_url( '/sipurot/mamaamakim/' ), 301 );
    exit;
}
?>

<div class="section-wrap">

<?php if ( false ) : // inline reader removed — CPT post now at /sipurot/mamaamakim/ ?>
  <!-- ===== READING VIEW: ממעמקים ===== -->
  <div class="section-head reveal">
    <?php codex_eyebrow('נמרוד דוויק'); ?>
    <h2 class="s-title">ממעמקים</h2>
    <?php codex_ornament(); ?>
  </div>

  <div class="story-reading prose reveal reveal-delay-1">
    <p class="story-meta">סיפור קצר · נמרוד דוויק · יקום הקודקס של השוליים</p>
    <?php include get_template_directory() . '/inc/story-mamaamakim.php'; ?>
  </div>

  <div class="reveal" style="margin-top:4rem;text-align:center;">
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn">← חזרה לסיפורות</a>
  </div>

<?php else : ?>
  <!-- ===== STORIES INDEX ===== -->
  <div class="section-head reveal">
    <?php codex_eyebrow('יצירה'); ?>
    <h2 class="s-title">סיפורות של הקודקס</h2>
    <?php codex_ornament(); ?>
  </div>

  <div class="prose reveal" style="margin-bottom:3rem;">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>

  <div class="stories-stack">

    <?php
    $mamaamakim_post = get_page_by_path( 'mamaamakim', OBJECT, 'story' );
    $mamaamakim_url  = $mamaamakim_post ? get_permalink( $mamaamakim_post->ID ) : home_url( '/sipurot/mamaamakim/' );
    ?>
    <a href="<?php echo esc_url( $mamaamakim_url ); ?>" class="story-card reveal">
      <div class="story-num">א׳</div>
      <div class="story-inner">
        <div class="story-title">ממעמקים</div>
        <p class="story-blurb">סיפור צבאי-ספרותי על חיילים, לבנון, ניווט GPS בחושך ומבצע חיפוש שמגלה יותר ממה שביקשו למצוא. מאת נמרוד דוויק.</p>
        <span class="btn">קרא ←</span>
      </div>
    </a>

    <div class="story-card reveal reveal-delay-1" style="cursor:default;opacity:0.5;">
      <div class="story-num">ב׳</div>
      <div class="story-inner">
        <div class="story-title">הארכיאולוג</div>
        <p class="story-blurb">באמצע המדבר מוצא סייר גופה. מה שמתחיל כחקירה רגילה הופך במהרה לשאלה על מה מונח מתחת לאדמה — ולמה הוא רוצה לצאת.</p>
        <span class="btn btn-ghost">בקרוב</span>
      </div>
    </div>

    <div class="story-card reveal reveal-delay-2" style="cursor:default;opacity:0.5;">
      <div class="story-num">ג׳</div>
      <div class="story-inner">
        <div class="story-title">צדיק כתמר יפרח</div>
        <p class="story-blurb">חוקרת צעירה נדרשת לבדוק זירת רצח המובילה אותה למרוץ נגד הזמן מול כוחות השיקוץ. מאת נמרוד דוויק.</p>
        <span class="btn btn-ghost">בקרוב</span>
      </div>
    </div>

    <div class="story-card reveal reveal-delay-3" style="cursor:default;opacity:0.5;">
      <div class="story-num">ד׳</div>
      <div class="story-inner">
        <div class="story-title">בוא יום</div>
        <p class="story-blurb">סיפור קצר נוסף בפיתוח — תוכן עתידי ביקום הקודקס של השוליים.</p>
        <span class="btn btn-ghost">בקרוב</span>
      </div>
    </div>

  </div>

  <!-- WP Custom Post Type stories (if any exist) -->
  <?php
  // Exclude slugs already shown as hardcoded cards above
  $hardcoded_slugs = ['mamaamakim'];
  $exclude_ids = array_filter( array_map( function( $s ) {
      $p = get_page_by_path( $s, OBJECT, 'story' );
      return $p ? $p->ID : 0;
  }, $hardcoded_slugs ) );

  $stories = new WP_Query([
      'post_type'      => 'story',
      'posts_per_page' => 10,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'post__not_in'   => array_values( $exclude_ids ),
  ]);
  if ( $stories->have_posts() ) :
    $n = 4;
    while ( $stories->have_posts() ) : $stories->the_post(); ?>
    <a href="<?php the_permalink(); ?>" class="story-card reveal">
      <div class="story-num"><?php echo $n++; ?></div>
      <div class="story-inner">
        <div class="story-title"><?php the_title(); ?></div>
        <p class="story-blurb"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
        <span class="btn">קרא ←</span>
      </div>
    </a>
    <?php endwhile; wp_reset_postdata();
  endif; ?>

<?php endif; ?>

</div><!-- .section-wrap -->

<?php get_footer();
