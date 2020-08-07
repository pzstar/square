<?php
/**
 * Template Name: Blank Template(For Page Builders)
 *
 * @package Square
 */
get_header();
?>

<div class="sq-container sq-clearfix">
    <div class="content-area">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('template-parts/content', 'page'); ?>

        <?php endwhile; // End of the loop. ?>

    </div><!-- #primary -->

</div>

<?php
get_footer();
