<?php get_header(); ?>
<h1>Welcome to My Custom Theme</h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h2><?php the_title(); ?></h2>
    <div><?php the_content(); ?></div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
