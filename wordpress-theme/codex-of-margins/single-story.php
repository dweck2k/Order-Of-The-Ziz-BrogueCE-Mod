<?php
/**
 * single-story.php
 * Template for individual 'story' custom post type entries.
 */
get_header(); ?>

<main id="main-content" class="section-wrap" dir="rtl" lang="he">
<?php while ( have_posts() ) : the_post(); ?>

    <article id="story-<?php the_ID(); ?>" <?php post_class('prose story-prose'); ?>>

        <header class="story-header reveal">
            <?php
            $genre = get_post_meta( get_the_ID(), '_story_genre', true );
            if ( $genre ) :
            ?>
            <span class="story-genre"><?php echo esc_html( $genre ); ?></span>
            <?php endif; ?>

            <h1 class="story-title"><?php the_title(); ?></h1>

            <?php
            $author_name = get_post_meta( get_the_ID(), '_story_author', true );
            if ( $author_name ) :
            ?>
            <p class="story-author">מאת <?php echo esc_html( $author_name ); ?></p>
            <?php endif; ?>
        </header>

        <div class="story-body">
            <?php the_content(); ?>
        </div>

        <footer class="story-footer reveal">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'story' ) ?: home_url( '/sipurot/' ) ); ?>"
               class="btn btn-ghost">← חזרה לסיפורות</a>
        </footer>

    </article>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
