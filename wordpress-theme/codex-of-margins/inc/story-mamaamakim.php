<?php
/**
 * ממעמקים – נמרוד דוויק
 * Included by page-stories.php when ?story=mamaamakim
 *
 * Reads mamaamakim.txt (UTF-8, one paragraph per line, *** = section break).
 */

$story_file = get_template_directory() . '/inc/mamaamakim.txt';

if ( ! file_exists( $story_file ) ) {
    echo '<p class="error">הסיפור אינו זמין כרגע.</p>';
    return;
}

$lines = file( $story_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
if ( ! $lines ) {
    echo '<p class="error">לא ניתן לטעון את הסיפור.</p>';
    return;
}
?>

<article class="prose story-prose" dir="rtl" lang="he">

    <header class="story-header reveal">
        <span class="story-genre">סיפור קצר</span>
        <h1 class="story-title">מִמַּעֲמַקִּים</h1>
        <p class="story-author">מאת נמרוד דוויק</p>
    </header>

    <div class="story-body">
<?php foreach ( $lines as $line ) :
    $line = trim( $line );
    if ( $line === '' ) continue;

    if ( $line === '***' ) : ?>
        <div class="story-break reveal" aria-hidden="true">✦ ✦ ✦</div>
    <?php else : ?>
        <p class="reveal"><?php echo esc_html( $line ); ?></p>
    <?php endif;
endforeach; ?>
    </div><!-- .story-body -->

    <footer class="story-footer reveal">
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'sipurot' ) ) ); ?>"
           class="btn">← חזרה לסיפורות</a>
    </footer>

</article>
