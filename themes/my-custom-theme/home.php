<?php get_header(); ?>
<div class="homepage-content">
    <h1>Welcome to My Custom Theme Homepage</h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <div><?php the_excerpt(); ?></div>
    <?php endwhile; endif; ?>
</div>



<?php get_header(); ?>


