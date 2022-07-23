<?php
    $year = isset($_GET['year']) ? esc_sql($_GET['year']) : date('Y');
    $month = isset($_GET['month']) ? esc_sql($_GET['month']) : date('n');
    $cal = calendar($year, $month);
    $events = query_month_events($year, $month);
    the_post();
    $od_dates = get_post_meta(get_the_ID(), "event_date");
    $opendays = array_map(function ($d) {
        return explode("#", $d)[0];
    }, $od_dates);
    function get_od_time ($date, $which, $opendays, $od_dates) {
        //global $opendays, $od_dates;
        $i = array_search($date, $opendays);
        $t = explode("#",$od_dates[$i])[(array("start"=>1, "end"=>2)[$which])];
        if ($t) return intval(explode(":", $t)[0]);
        return "";
    }
?>

<header class="calendar-header">
    <a href="?month=<?= cycle($month - 1, 1, 12) ?>" class="calendar-nav">←</a>
    <?= monthname($month) ?> <?= $year ?>
    <a href="?month=<?= cycle($month + 1, 1, 12) ?>" class="calendar-nav">→</a>
</header>
<div class="calendar-wrap">
    <div class="calendar">
        <ul class="weekdays">
            <li>Sunday</li>
            <li>Monday</li>
            <li>Tuesday</li>
            <li>Wednesday</li>
            <li>Thursday</li>
            <li>Friday</li>
            <li>Saturday</li>
        </ul>
        <? foreach (array_chunk($cal, 7) as $week): ?>
            <ul class="days">
            <? foreach ($week as $d): $today = date("Y-m-d", mktime(0,0,0,$month,$d,$year)); ?>
                <li class="day <?php if ($d == 0) echo 'other-month'; ?>">
                    <? if ($d): ?>
                        <div class="date"><?= $d ?></div>
                        <? foreach (find_events($events, $today) as $event):?>
                        <div class="event">
                            <div class="event-desc">
                                <a href="<?= $event->guid ?>">
                                    <?= $event->post_title ?>
                                </a>
                            </div>
                            <!-- div class="event-time"></div -->
                        </div>
                        <? endforeach; ?>
                        <? if (in_array($today, $opendays)): ?>
                        <div class="event">
                            <div class="event-desc">
                                <a href="<?= get_permalink(get_id_by_post_name('usage')) ?>">
                                    オープンデイ Open Day
                                </a>
                            </div>
                            <div class="event-time">
                                <input type="button" 
                                       data-date="<?= $today ?>"
                                       data-time-start="<?= get_od_time($today, 'start', $opendays, $od_dates) ?>"
                                       data-time-end="<?= get_od_time($today, 'end', $opendays, $od_dates) ?>" 
                                       class="button-booking block-center button button-primary" 
                                       value="予約" />
                            </div>
                        </div>
                        <? endif; ?>
                    <? endif; ?>
                </li>
            <? endforeach; ?>
            </ul>
        <? endforeach; ?>
        <!-- ? foreach (query_month_events() as $post) {
            print_r($post);
        } ? -->
    </div>
</div>