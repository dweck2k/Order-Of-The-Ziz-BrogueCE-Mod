<?php
/**
 * Template Name: קומיקס
 * Comic reader — book-flip page viewer with fullscreen + PDF download
 */
get_header();

$comics_uri  = get_template_directory_uri() . '/comics/';
$comics_dir  = get_template_directory() . '/comics/';
$total_pages = 6;
$pdf_online  = $comics_uri . 'TamarOnline.pdf';
?>

<div class="section-wrap" style="padding-bottom:0;">
  <div class="section-head reveal">
    <?php codex_eyebrow('יקום הקודקס'); ?>
    <h2 class="s-title">הקומיקס</h2>
    <?php codex_ornament(); ?>
  </div>

  <div class="prose reveal reveal-delay-1" style="margin-bottom:3rem;">
    <?php $co = get_queried_object(); echo $co ? apply_filters( 'the_content', $co->post_content ) : ''; ?>
  </div>
</div>

<!-- COMIC BOOK READER -->
<div id="comic-reader" class="cv-reader reveal reveal-delay-2">

  <div class="cv-stage">
    <?php for ( $i = 1; $i <= $total_pages; $i++ ) :
      $img_file = $comics_dir . 'TamarOnline_Page_' . $i . '.jpg';
      $img_uri  = $comics_uri . 'TamarOnline_Page_' . $i . '.jpg';
      if ( ! file_exists( $img_file ) ) continue;
    ?>
    <div class="cv-page" data-page="<?php echo $i; ?>">
      <img
        src="<?php echo esc_url( $img_uri ); ?>"
        alt="<?php echo esc_attr( 'קומיקס צדיק כתמר יפרח — עמוד ' . $i ); ?>"
        loading="<?php echo $i === 1 ? 'eager' : 'lazy'; ?>"
      >
    </div>
    <?php endfor; ?>
  </div>

  <div class="cv-nav">
    <button class="cv-btn" id="cvPrev" disabled>&#x2039; הקודם</button>
    <span class="cv-counter">עמוד <span id="cvCurrent">1</span> / <?php echo $total_pages; ?></span>
    <button class="cv-btn" id="cvNext">הבא &#x203A;</button>
  </div>

  <div class="cv-toolbar">
    <button class="cv-btn-fs" id="cvFullscreen">⛶ מסך מלא</button>
    <a href="<?php echo esc_url( $pdf_online ); ?>" class="btn btn-blood" download>
      ⬇&nbsp; הורד PDF
    </a>
  </div>

</div>

<div style="max-width:800px;margin:0 auto;padding:2rem 4rem 6rem;text-align:center;">
  <p style="font-size:0.85rem;color:var(--text-faint);letter-spacing:0.08em;">
    ציור: יובל בוזגלו &nbsp;·&nbsp; תסריט: נמרוד דוויק
  </p>
</div>

<?php get_footer(); ?>
