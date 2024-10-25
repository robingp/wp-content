<?php get_header(); ?>

<main class="project-archive">
    <h1>Our Projects</h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="project-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="project-content">
                <?php the_excerpt(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
