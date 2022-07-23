<div class="preview">
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(array(320,320)); ?>
    </a>
	<div class="preview-date"><?php the_date("Y / m / d") ?></div>
    <div class="preview-summary">
        <h2 class="preview-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="mincho preview-text">
            <?php the_excerpt(); ?>
        </div>
    </div>
</div>
