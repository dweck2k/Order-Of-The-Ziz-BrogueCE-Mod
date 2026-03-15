<?php
/**
 * הקודקס של השוליים — Theme Functions
 */

define( 'CODEX_VER', '1.0.0' );
define( 'CODEX_DIR', get_template_directory() );
define( 'CODEX_URI', get_template_directory_uri() );

/* ===== THEME SETUP ===== */
function codex_setup() {
    load_theme_textdomain( 'codex-margins', CODEX_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', ['search-form','comment-form','comment-list','gallery','caption'] );

    register_nav_menus([
        'primary' => __( 'תפריט ראשי', 'codex-margins' ),
    ]);
}
add_action( 'after_setup_theme', 'codex_setup' );

/* ===== ENQUEUE ===== */
function codex_assets() {
    // Google Fonts
    wp_enqueue_style( 'codex-fonts',
        'https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@300;400;500;700;900&family=Rubik:ital,wght@0,300;0,400;0,500;1,300&family=Cinzel:wght@400;600;900&display=swap',
        [], null
    );
    // Theme stylesheet
    wp_enqueue_style( 'codex-style', get_stylesheet_uri(), ['codex-fonts'], CODEX_VER );
    // Main JS
    wp_enqueue_script( 'codex-main', CODEX_URI . '/js/codex.js', [], CODEX_VER, true );
}
add_action( 'wp_enqueue_scripts', 'codex_assets' );

/* ===== CUSTOM POST TYPES: STORY + MONSTER ===== */
function codex_register_post_types() {
    register_post_type( 'monster', [
        'labels' => [
            'name'          => 'יצורים',
            'singular_name' => 'יצור',
            'add_new_item'  => 'הוסף יצור חדש',
            'edit_item'     => 'ערוך יצור',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => true,
        'supports'      => ['title','editor','excerpt','page-attributes'],
        'menu_icon'     => 'dashicons-shield',
    ]);
    register_post_meta( 'monster', '_monster_pre', [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
    ]);

    register_post_type( 'story', [
        'labels' => [
            'name'               => 'סיפורות',
            'singular_name'      => 'סיפור',
            'add_new_item'       => 'הוסף סיפור חדש',
            'edit_item'          => 'ערוך סיפור',
            'view_item'          => 'צפה בסיפור',
            'search_items'       => 'חפש סיפורות',
            'not_found'          => 'לא נמצאו סיפורות',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'supports'      => ['title','editor','excerpt','thumbnail','custom-fields'],
        'has_archive'   => false,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'sipurot'],
        'menu_icon'     => 'dashicons-book-alt',
    ]);
}
add_action( 'init', 'codex_register_post_types' );

// Expose story meta to REST API so wp-json can read/write them
add_action( 'init', function() {
    foreach ( ['_story_genre', '_story_author'] as $key ) {
        register_post_meta( 'story', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => '__return_true',
        ]);
    }
});

/* ===== HELPERS ===== */
function codex_ornament() { ?>
    <div class="ornament"><div class="ornament-gem"></div></div>
<?php }

function codex_eyebrow( $text ) {
    echo '<span class="s-eyebrow">' . esc_html( $text ) . '</span>';
}

/* ===== BODY CLASSES ===== */
function codex_body_classes( $classes ) {
    $classes[] = 'codex-theme';
    return $classes;
}
add_filter( 'body_class', 'codex_body_classes' );

/* ===== PAGE TITLE ===== */
function codex_wp_title( $title ) {
    return $title . ' | הקודקס של השוליים';
}
add_filter( 'pre_get_document_title', 'codex_wp_title' );

/* ===== FALLBACK NAV (when no menu assigned) ===== */
function codex_fallback_nav() { ?>
<ul class="nav-menu">
  <li><a href="<?php echo home_url('/'); ?>">בית</a></li>
  <li><a href="<?php echo home_url('/about'); ?>">על היצירה</a></li>
  <li><a href="<?php echo home_url('/kat-haziz'); ?>">כת הזיז</a></li>
  <li><a href="<?php echo home_url('/komiks'); ?>">קומיקס</a></li>
  <li><a href="<?php echo home_url('/sipurot'); ?>">סיפורות</a></li>
  <li><a href="<?php echo home_url('/order-of-the-ziz'); ?>">משחקים</a></li>
</ul>
<?php }

/* ===== HERO TEXT META BOX — editable from Pages → בית ===== */
add_action( 'add_meta_boxes_page', function( $post ) {
    if ( (int) get_option('page_on_front') === $post->ID ) {
        add_meta_box( 'codex_hero', '🏠 Hero Text', 'codex_hero_meta_box', 'page', 'normal', 'high' );
    }
} );

function codex_hero_meta_box( $post ) {
    wp_nonce_field( 'codex_hero_save', 'codex_hero_nonce' );
    $pre     = get_post_meta( $post->ID, '_hero_pre',     true ) ?: 'The Codex of the Margins';
    $title   = get_post_meta( $post->ID, '_hero_title',   true ) ?: 'הקודקס של השוליים';
    $tagline = get_post_meta( $post->ID, '_hero_tagline', true ) ?: 'הסיפור האמיתי של הדברים נכתב תמיד בצד.';
    $body    = get_post_meta( $post->ID, '_hero_body',    true ) ?: '';
    echo '<table style="width:100%;border-collapse:collapse;">';
    foreach ( [
        ['pre-text (Latin)',   'hero_pre',     $pre,     'input'],
        ['כותרת ראשית',        'hero_title',   $title,   'input'],
        ['Tagline',            'hero_tagline', $tagline, 'input'],
        ['גוף הטקסט',         'hero_body',    $body,    'textarea'],
    ] as [$label, $name, $val, $type] ) {
        echo '<tr><td style="padding:6px 8px;width:130px;font-weight:600;vertical-align:top;">' . esc_html($label) . '</td><td style="padding:6px 0;">';
        if ( $type === 'textarea' ) {
            echo '<textarea name="' . $name . '" rows="2" style="width:100%;font-family:sans-serif;">' . esc_textarea($val) . '</textarea>';
        } else {
            echo '<input type="text" name="' . $name . '" value="' . esc_attr($val) . '" style="width:100%;">';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

add_action( 'save_post_page', function( $post_id ) {
    if ( ! isset($_POST['codex_hero_nonce']) || ! wp_verify_nonce($_POST['codex_hero_nonce'], 'codex_hero_save') ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    foreach ( ['_hero_pre'=>'hero_pre','_hero_title'=>'hero_title','_hero_tagline'=>'hero_tagline','_hero_body'=>'hero_body'] as $meta => $field ) {
        if ( isset($_POST[$field]) ) {
            update_post_meta( $post_id, $meta, sanitize_text_field($_POST[$field]) );
        }
    }
} );

/* ===== כת הזיז LORE — pulled from the כת הזיז WP page content ===== */
function codex_cult_lore() {
    $cult_page = get_page_by_path( 'kat-haziz' );
    if ( $cult_page && ! empty( $cult_page->post_content ) ) {
        return apply_filters( 'the_content', $cult_page->post_content );
    }
    return ''; // content is managed via Pages → כת הזיז in the WP editor
}
