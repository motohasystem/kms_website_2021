<?php get_header(); ?>

    <div id="content" class="with-sidebar">
        <div class="blog-menu">
            <div class="border-right">
                <a href="http://kamiyama.ms/category/%e6%8a%95%e7%a8%bf%e3%82%bf%e3%82%a4%e3%83%97/%e3%81%8a%e7%9f%a5%e3%82%89%e3%81%9b/">お知らせ</a>
            </div>
            <div class="border-right">
                <a href="http://kamiyama.ms/category/%e6%8a%95%e7%a8%bf%e3%82%bf%e3%82%a4%e3%83%97/%e3%82%a4%e3%83%99%e3%83%b3%e3%83%88%e3%83%ac%e3%83%9d%e3%83%bc%e3%83%88/">イベントレポート</a>
            </div>
            <div>
                <a href="http://kamiyama.ms/blog/">全て</a>
            </div>
        </div>
        <div class="blog-teasers">
            <div class="flex flex-wrap flex-start">
                <?php
                    while (have_posts()):
                        the_post();
                        get_template_part( 'preview' );
                    endwhile;
                ?>
            </div>
        </div>
        <div class="pager">
            <?php pagenation($wp_rewrite, $wp_query, $paged); ?>
        </div>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
