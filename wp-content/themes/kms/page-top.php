<?php get_header(); ?>

    <div id="content">
        <div class="eyecatch">
            <ul class="main-slide bxslider">
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/1.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/2.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/3.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/4.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/5.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/6.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/7.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/8.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/9.jpg" alt="kms-slideshow-image" /></li>
                <li><img src="<?php bloginfo('stylesheet_directory') ?>/images/slides/10.jpg" alt="kms-slideshow-image" /></li>
            </ul>
        </div>
        <div style="margin: 0 0 40px; border: 1px solid #c3c3c3; border-radius: 3px; padding: 1em 4em">
            <h2>オープンデイ</h2>
            <p style="margin: 1em 0; line-height:1.4em">毎月４回開催しているオープンディ。講習を受けた人ならKMSの工房や機材が利用可能です。レーザーカッターなどの機材でなくて、相談事や工作室としての利用もできる月会員制度ももう直ぐ始まります。詳細はもう少しお待ちください！<br/>機材の予約は<a href="/calendar">カレンダー</a>よりお願いします。</p>
        <?php 
            $od_dates = get_post_meta(get_page_by_path("calendar")->ID, "event_date");
            $opendays = array_map(function ($d) {
                return explode("#", $d)[0];
            }, $od_dates);
            function get_od_time ($date, $which) {
                global $opendays, $od_dates;
                $i = array_search($date, $opendays);
                $t = explode("#",$od_dates[$i])[(array("start"=>1, "end"=>2)[$which])];
                if ($t) return intval(explode(":", $t)[0]);
                return "";
            }
            foreach($opendays as $od) {
                $today = new DateTime();
                $datetime = new DateTime($od);
                if ($datetime->getTimeStamp() >= $today->getTimeStamp()) {
                    $week = array("日", "月", "火", "水", "木", "金", "土");
                    $w = (int)$datetime->format('w');
                    $start = get_od_time($od, 'start');
                    $end = get_od_time($od, 'end');
                    echo $datetime->format('m');
                    echo '/';
                    echo $datetime->format('d');
                    echo ' (';
                    echo $week[$w];
                    echo ') ';
                    echo $start != "" ? $start : ($week[$w] == "土" ? "10" : "17");
                    echo ':00 - ';
                    echo $end != "" ? $end : ($week[$w] == "土" ? "16" : "21");
                    echo ':00';
                    echo '<br />';
                }
            }
        ?>
        <p style="margin: 1em 0">
            その他質問がある方は、infoアットkamiyama.msまでお問い合わせください。
        </p>
        </div>
        <div class="news-wrap">
            <?php
            query_posts(array(
                 'post_type' => 'news', /* 投稿タイプを指定 */
                 'paged' => $paged,
            ));
            ?>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                <div class="news">
                    <h3 class="news-title">
                        <span class="news-date"><?php the_time("Y年m月j日") ?></span>
                        <?php the_title(); ?>
                    </h3>
                    <?php the_content(); ?>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div class="blog-teasers">
            <h3 class="text-center">RECENT BLOG POSTS</h3>
            <div class="flex">
                <?php
                    $myposts = get_posts(array( 'posts_per_page' => 4 ));
                    foreach ( $myposts as $post ) :
                        setup_postdata( $post );
                        get_template_part("preview");
                    endforeach;
                ?>
            </div>
        </div>
    </div>

<!--?php get_sidebar(); ?-->
<?php get_footer(); ?>
