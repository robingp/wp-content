<?php
/*
Template Name: Full Width
*/

get_header(); ?>

<main class="full-width-page">
    <?php
    while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
