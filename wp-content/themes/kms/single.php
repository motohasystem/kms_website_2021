<?php get_header(); ?>

<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

	<div id="content" class="with-sidebar">
		<main>
			<article class="post border-box">
				<?php the_post_thumbnail(array(800, 510), array('class' => 'eyecatch-large')); ?>
				<h2 class="post-title"><?php the_title(); ?></h2>
				<div class="post-date"><?php the_date("Y / m / d"); ?></div>
				<div class="post-content mincho">
					<?php the_content(); ?>
				</div>
				<div class="post-footer">
					著者:   <?php the_author_posts_link(); ?><br />
					投稿日: <?php echo get_the_date("Y / m / d", get_the_ID()); ?><br />
					開催日: <ul class="date-list">
					<?php foreach(get_post_meta(get_the_ID(), 'event_date', false) as $date):  ?>
						<li><?= str_replace("-", "/", $date) ?></li>
					<?php endforeach; ?></ul><br />
					<?php the_tags(); ?>

				</div>
			</article>
			<?php comments_template(); ?>
		</main>
	</div>

<?php
endwhile;
endif;
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
