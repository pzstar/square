<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @package Square
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sq-hentry'); ?>>

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
        <?php
        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__('Edit %s', 'square'), the_title('<span class="screen-reader-text">"', '"</span>', false)
            ), '<span class="edit-link">', '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->