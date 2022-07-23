<?php
/*
Template Name:メンバー一覧
*/
?>

<?php get_header(); ?>

    <div id="content" class="with-sidebar">
        <main>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

            <article class="post">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(array(200,200)); ?>
                </a>
                <div class="post-summary">
                    <h2 class="post-title"><?php the_title(); ?></h2>
                    <div class="post-content">
                        <?php the_content(); ?>

<!--投稿者一覧を表示-->
<?php $users =get_users( array('orderby'=>ID,'order'=>DSC) );
echo '<div class="writers">';
foreach($users as $user):
    $uid = $user->ID;
    $userData = get_userdata($uid);
    echo '<div class="writer-profile">';
        echo '<figure class="eyecatch">';
            echo get_avatar( $uid ,300 );
        echo '</figure>';
        echo '<div class="profiletxt">';
            echo '<p class="name">'.$user->display_name.'</p>';
            echo '<div class="description">'.$userData->user_description.'</div>';
            echo '<div class="button"><a href="'.get_bloginfo(url).'/?author='.$uid.'">'.$user->display_name.'の記事一覧</a></div>';
        echo '</div>';
    echo '</div>';
endforeach;
echo '</div>'; ?>

					</div>
                </div>
            </article>

            <?php
            endwhile;
            endif;
            ?>

        </main>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>