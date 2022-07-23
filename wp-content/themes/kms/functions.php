<?php
ini_set( 'display_errors', 1 );

const MACHINES = array("3d-printer", "laser-cutter", "sewing-machine");

function enqueue_js () {
    //wp_enqueue_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js', array(), '2.2.3', true);
    wp_enqueue_script('webshim', 'https://cdn.jsdelivr.net/webshim/1.15.10/polyfiller.js', null, '1.15.10', true);
    wp_enqueue_script( 'kms', get_bloginfo( 'template_url') . '/kms.js', array('jquery', 'webshim'), false, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_js');

function add_openday_setting_menu () {
    add_menu_page( 'カレンダー', 'オープンデーの設定', 'edit_posts', 'post.php?post=28&action=edit#event_date' );
}
add_action('admin_menu', 'add_openday_setting_menu');

function meta_event_date_box(){
  add_meta_box('event_date', 'イベントの日付', 'meta_event_date_html', 'post', 'normal', 'high');

  /* for calendar page */
  $post_id = '';
  if(isset($_GET['post']) || isset($_POST['post_ID'])) {
      $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  }
  if ($post_id == get_id_by_post_name('calendar'))
      add_meta_box('event_date', 'オープンデーの日付', 'meta_event_date_html', 'page', 'normal', 'high');
}
//投稿スラッグから投稿IDを取得する関数の定義
function get_id_by_post_name($post_name)
{
  global $wpdb;
  $id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$post_name."'");
  return esc_html($id);
}
function meta_box_date ($date="", $id="", $type="") {
    $d = explode("#", $date);
    if ( ! isset($d[1])) {
        $d[1] = ""; $d[2] = "";
    }
    ?><div class="meta-box-date" id="<?= $id ?>">
        <label for="event_dates[]">event_date</label>
        <input type="<?= $type ?>" name="event_dates[]" value="<?= $d[0] ?>" size="25" />
        <label for="event_time_start">time</label>
        <input type="<? if ($type) { ?>time<? } ?>" name="time_start[]" value="<?= $d[1] ?>" /> ~
        <input type="<? if ($type) { ?>time<? } ?>" name="time_end[]" value="<?= $d[2] ?>" />
    </div><?php
}
function meta_event_date_html($post, $box){
    meta_box_date("", "meta-box-date-proto", "");
    ?><div id="meta-box-date-wrap">
    <p>設定後は、[更新]ボタンを押してください</p>
    <p>時間は空欄でもOK。この場合、平日は17時~21時、休日は10時~16時になります。</p>
    <?php
    foreach(get_post_meta($post->ID, 'event_date', false) as $date) {
        meta_box_date($date, "", "date");
    }
    ?></div><br/><input type="button" class="button button-primary" id="js-add-event-date-field" value="日付を追加 - ADD" /><?php
}
add_action('admin_menu', 'meta_event_date_box');

function meta_event_date_update ($post_id) {
    if (! $_POST["event_dates"]) return $post_id;
    $dates = array_filter($_POST["event_dates"], function ($date) {
        return $date != "";
    });

    delete_post_meta($post_id, "event_date");
    foreach( $dates as $i => $date) {
        add_post_meta($post_id, "event_date", implode("#", [$date, $_POST["time_start"][$i], $_POST["time_end"][$i]]));
    }
}
add_action('save_post', 'meta_event_date_update');


function admin_scripts () {
    wp_enqueue_script('webshim', 'https://cdn.jsdelivr.net/webshim/1.15.10/polyfiller.js', null, '1.15.10', true);
    wp_enqueue_script('admin-script', get_bloginfo('template_url') . '/admin-script.js', 'webshim', null, true);
}
add_action('admin_print_scripts', 'admin_scripts');

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget_title">',
        'after_title' => '</h2>',
    ));

//メインメニュー
register_nav_menu('mainmenu', 'メインメニュー');

//アイキャッチ
add_theme_support( 'post-thumbnails', array( 'post' ) );
set_post_thumbnail_size( 100, 100, true );

/* construct an array of dates padded with zero */
function calendar ($year = false, $month = false) {
    if (!$year) $year = date('Y');
    if (!$month) $month = date('n');
    $last_d = mktime(0,0,0, $month + 1, 0, $year);
    $last_date = date('j', $last_d);
    $last_day = date('w', $last_d);

    $cal = array();
    $day1 = date('w', mktime(0,0,0, $month, 1, $year));
    for ($i = 0; $i < $day1; $i++)
        array_push($cal, 0);

    for ($i = 1; $i <= $last_date; $i++)
        array_push($cal, $i);

    for ($i = 0; $i < 6 - $last_day; $i++)
        array_push($cal, 0);

    return $cal;
}


function query_month_events ($year = false, $month = false) {
    if (!$year) $year = date('Y');
    if (!$month) $month = date('n');
    $posts = get_posts(array(
        'post_type' => 'post',
        'meta_key' => 'event_date',
        'meta_value' => $year . sprintf('-%02d', $month),
        'meta_compare' => 'LIKE'
    ));

    return array_map(function ($post) {
        $ds = get_post_meta($post->ID, 'event_date', false);
        $post->event_dates = array_map(function ($d) {
            return explode("#", $d)[0];
        }, $ds);
        return $post;
    }, $posts);
}


function find_events ($events, $ymd) {
    return array_filter($events, function ($event) use ($ymd) {
        return in_array($ymd, $event->event_dates);
    });
}


function pagenation ($wp_rewrite, $wp_query, $paged) {
    $paginate_base = get_pagenum_link(1);
    if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
        $paginate_format = '';
        $paginate_base = add_query_arg('paged','%#%');
    }
    else{
        $paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
        user_trailingslashit('page/%#%/','paged');;
        $paginate_base .= '%_%';
    }
    echo paginate_links(array(
        'base' => $paginate_base,
        'format' => $paginate_format,
        'total' => $wp_query->max_num_pages,
        'mid_size' => 4,
        'current' => ($paged ? $paged : 1),
        'prev_text' => '«',
        'next_text' => '»',
    ));
}

//excerpt length
function change_excerpt_mblength($length) {
    return 3;
}
add_filter('excerpt_mblength', 'change_excerpt_mblength');
function change_excerpt_length ($length) {
    return 40;
}
add_filter('excerpt_length', 'change_excerpt_mblength');

function monthname ($n) {
    return array("", "January", "February", "March", "April", "May", "June",
                     "July", "August", "September", "October", "November", "December")[$n];
}

function cycle ($x, $start, $end) {
    $r = ($x - $start) % $end;
    if ($r < 0)
        return $end;
    return $r + 1;
}

function check_booking_request ($p) {
    $date = explode("-", $p["date"]);
    if (! is_array($p["time"])) return false;
    foreach ($p["time"] as $hour) {
        if ( ! in_array((int)$hour, range(0,24)))
            return false;
    }
    return checkdate($date[1], $date[2], $date[0])
        && is_string($p["uname"]) && strlen($p["uname"]) > 0
        && in_array($p["machine"], MACHINES)
        && is_string($p["phone"]) && strlen($p["phone"]) > 0;
}
function check_date_str ($datestr) {
    $date = explode("-", $datestr);
    return checkdate($date[1], $date[2], $date[0]);
}


