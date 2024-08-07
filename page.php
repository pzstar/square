<?php
/**
 * The template for displaying all pages.
 *
 * @package Square
 */
get_header();
?>

<header class="sq-main-header">
    <div class="sq-container">
        <?php the_title('<h1 class="sq-main-title">', '</h1>'); ?>
    </div>
</header><!-- .entry-header -->

<div class="sq-container sq-clearfix">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php while (have_posts()):
                the_post(); ?>

                <?php get_template_part('template-parts/content', 'page'); ?>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()):
                    comments_template();
                endif;
                ?>

            <?php endwhile; // End of the loop. ?>

        </main><!-- #main -->
    </div><!-- #primary -->

    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
