<?php
/**
 * Template Name: עמוד הבית
 * Front page — hero + lore + cards
 */
get_header(); ?>

<!-- HERO -->
<section class="hero">
  <canvas id="particle-canvas"></canvas>
  <div class="hero-vignette"></div>
  <div class="hero-content">
    <?php
    $pid     = get_queried_object_id();
    $pre     = get_post_meta($pid,'_hero_pre',    true) ?: 'The Codex of the Margins';
    $title   = get_post_meta($pid,'_hero_title',  true) ?: 'הקודקס של השוליים';
    $tagline = get_post_meta($pid,'_hero_tagline',true) ?: 'הסיפור האמיתי של הדברים נכתב תמיד בצד.';
    $body    = get_post_meta($pid,'_hero_body',   true) ?: 'יקום סיפורי יהודי־ישראלי שבו טקסטים עתיקים, כוחות נסתרות ומאבק מתמשך נפגשים הרחק מן ההיסטוריה הרשמית.';
    ?>
    <p class="hero-pre"><?php echo esc_html($pre); ?></p>
    <div class="hero-title-wrap"><h1 class="hero-title flicker pulse"><?php echo esc_html($title); ?></h1></div>
    <div class="hero-rule"></div>
    <p class="hero-tagline"><?php echo esc_html($tagline); ?></p>
    <p class="hero-body"><?php echo esc_html($body); ?></p>
  </div>
</section>

<!-- על היקום -->
<section class="lore-section">
  <span class="s-eyebrow">על היקום</span>
  <div class="ornament"><div class="ornament-gem"></div></div>
  <div class="prose reveal">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>
</section>

<!-- CARDS ROW -->
<div class="cards-row">

  <a href="<?php echo home_url('/komiks'); ?>" class="card">
    <div class="card-pre">קומיקס</div>
    <div class="card-title">הקומיקס</div>
    <p class="card-body">גילוי המגילות בדרום לבנון חשף מסמך שלא היה אמור להימצא — ומאבק עתיק בכוחות שאיש לא הודה בקיומם.</p>
    <span class="btn">קרא את הלור ↓</span>
  </a>

  <a href="<?php echo home_url('/sipurot'); ?>" class="card">
    <div class="card-pre">סיפורות</div>
    <div class="card-title">הסיפורים</div>
    <p class="card-body">לא כל הסיפורים מתרחשים במרכז האירועים. חלקם עוסקים באנשים שנתקלו בשוליים — ולרגע הבינו שהמציאות רחבה יותר.</p>
    <span class="btn">📖 לקריאת הסיפורים</span>
  </a>

  <a href="<?php echo home_url('/order-of-the-ziz'); ?>" class="card">
    <div class="card-pre">משחקים</div>
    <div class="card-title" style="font-family:var(--f-latin);font-size:1.35rem;letter-spacing:0.04em;">Order of the Ziz</div>
    <p class="card-body">ירד אל המעמקים, הילחם ביצורי המאורה, ומצא את ספר השיקוץ — לפני שהאפלה תבלע הכל.</p>
    <span class="btn btn-blood">🎮 שחק ב-Order of the Ziz</span>
  </a>

</div>

<?php get_footer(); ?>
