<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

<article class="post">
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(array(200,200)); ?>
    </a>
    <div class="post-summary">
        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </div>
</article>

<?php
endwhile;
endif;
?>
