<?php
/**
 * Template part for displaying single posts.
 *
 * @package Square
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sq-hentry'); ?>>

    <div class="entry-meta">
        <?php square_posted_on(); ?>
    </div><!-- .entry-meta -->

    <div class="entry-content single-entry-content">
        <?php the_content(); ?>
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'square'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php square_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->