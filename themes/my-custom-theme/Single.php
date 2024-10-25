<?php get_header(); ?>
<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" loading="lazy">

<main class="single-post">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <div class="post-meta">
                <span>Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?></span>
            </div>
            <div class="post-thumbnail">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" loading="lazy">
            </div>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
            <div class="post-comments">
                <?php comments_template(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
