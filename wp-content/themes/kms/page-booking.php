<?php
$errors = array();
$success = array();

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $date_str = esc_html($_GET["date"]);
        $time_start = esc_html($_GET["time_start"]);
        $time_end = esc_html($_GET["time_end"]);
        break;
    case "POST":
        $date_str = esc_html($_POST["date"]);
        $time_start = esc_html($_POST["time_start"]);
        $time_end = esc_html($_POST["time_end"]);
        if (esc_html($_POST["lecture"]) != "on") {
            array_push($errors, "オープンデーで機材を利用するには、機材の初回講習を受講していただく必要があります");
            array_push($errors, "You need to attend a lecture first before you can use the machine.");
            break;
        }
        if (! check_booking_request($_POST)) {
            array_push($errors, "入力値が不正です。お名前、お電話番号、希望時間の入力をご確認下さい。");
            array_push($errors, "Invalid booking request. Please correct your name, phone number, and/or desired time.");
            break;
        }
        if ( ! fabook_make_booking($date_str, $_POST["time"], $_POST["uname"], $_POST["phone"], $_POST["email"], $_POST["machine"])) {
            array_push($errors, "申し訳ございません。他の方が予約されたため予約を受け付けできませんでした。他の時間をお選びください。");
            array_push($errors, "We are sorry. Somebody else has taken that time period. Please try again.");
            break;
        }
        array_push($success, "ご予約が完了しました。" . esc_html(str_replace("-", "/", $_POST["date"])) . "の" . esc_html(implode("時,", $_POST["time"])) . "時にお待ちしております。");
        array_push($success, "Done booking. We'll see you on " . esc_html(str_replace("-", "/", $_POST["date"])) . " at " . esc_html(implode(",", $_POST["time"])) . "o'clock!");
        $times_str = implode('時,', $_POST['time']) . "時";
        $body = <<< END
DATE:    {$_POST['date']}
TIME:    {$times_str}
MACHINE: {$_POST['machine']}
NAME:    {$_POST['uname']}
PHONE:   {$_POST['phone']}
EMAIL:   {$_POST['email']}
END;
        wp_mail('info@kamiyama.ms', 'オープンデイ予約入りました！', $body);
        break;
}

if (! check_date_str($date_str)) {
    header("Location: /calendar");
    exit;
}

$bookings_today = fabook_get_booking($date_str);
usort($bookings_today, function ($a, $b) { return $a->hour - $b->hour; });
$bookings_simplified = array_map(function ($data) {
    return array('hour' => $data->hour, 'machine' => $data->machine);
}, $bookings_today);

$machines = array(
    array('id' => '3d-printer', 'label' => '3Dプリンター - 3D Printer'),
    array('id' => 'laser-cutter', 'label' => 'レーザーカッター - Laser Cutter'),
    array('id' => 'sewing-machine', 'label' => 'デジタルミシン - Digital Sewing Machine'),
    array('id' => 'cutting-plotter', 'label' => 'カッティングプロッター - Cutting Plotter')
);

function weekend_p ($dayn) {
  return $dayn == 0 || $dayn == 6;
}

//day
$dt = new DateTime($date_str);
$dayn = $dt->format("w");
if ( ! $time_start) $time_start = weekend_p($dayn) ? 10 : 17;
if ( ! $time_end) $time_end = weekend_p($dayn) ? 16 : 21;
$timerange = range($time_start, $time_end);
$daynames = array('日','月','火','水','木','金','土');
?>
<?php get_header(); ?>

<div id="content" class="with-sidebar">
    <header><h1 class="post-title">予約: <?= $date_str ?> (<?= $daynames[$dayn] ?>)</h1></header>
    <?php if (! empty($errors)) : ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p class="error-message"><?= esc_html($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (! empty($success)) : ?>
        <div class="success">
            <?php foreach ($success as $s): ?>
                <p class="error-message"><?= esc_html($s) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php foreach ($machines as $machine): ?>
        <form class="ws-validate" action="<?= esc_attr(get_permalink($post->ID)) ?>" method="post">
            <input type="hidden" name="date" value="<?= esc_attr($date_str) ?>" />
            <input type="hidden" name="time_start" value="<?= esc_attr($time_start) ?>" />
            <input type="hidden" name="time_end" value="<?= esc_attr($time_end) ?>" />
            <input type="hidden" name="machine" value="<?= $machine['id'] ?>" />
            <div class="booking-group">
                <h2><?= $machine['label'] ?></h2>
                <div class="flex flex-start flex-wrap">
                    <?php foreach($timerange as $hour): ?>
                    <div class="booking-time border-box">
                        <?php if (in_array(array('hour' => (string)$hour, 'machine' => $machine['id']), $bookings_simplified)): ?>
                            ❌
                        <?php else: ?>
                            <input type="checkbox" name="time[]" value="<?= $hour ?>" id="time-<?= $hour ?>-machine-<?= $machine['id'] ?>">
                        <?php endif; ?>
                        <label for="time-<?= $hour ?>-machine-<?= $machine['id'] ?>"><?= $hour ?>時</label>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="booking-footer">
                    <div class="booker">
                        <p>
                            <label for="booker-name">Name お名前</label>
                            <input type="text" class="form-control" name="uname" id="booker-name" required />
                        </p>
                        <p>
                            <label for="booker-phone">Phone 電話番号</label>
                            <input type="tel" class="form-control" name="phone" id="booker-phone" pattern="[\+\s0-9]{3,15}" required />
                        </p>
                        <p>
                            <label for="booker-phone">Email メール</label>
                            <input type="email" class="form-control" name="email" id="booker-email" />
                        </p>
                        <p>
                            <label>初回講習を受講しました</label>
                            <input type="checkbox" value="on" name="lecture" id="booker-lecture" style="display:inline" />
                        </p>
                        <input type="submit" value="BOOK! 予約する" />
                    </div>
                </div>
            </div>
        </form>
    <?php endforeach; ?>

    <div class="bookings">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>時間 Time</th>
                    <th>機械 Machine</th>
                    <th>名前 Name</th>
                    <!--th>電話 Tel</th-->
                    <!--th>メール Email</th-->
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings_today as $b): ?>
                    <tr>
                        <td><?= esc_html($b->hour) ?>時</td>
                        <td><?= esc_html($b->machine) ?></td>
                        <td><?= esc_html($b->name) ?></td>
                        <!--td><?= esc_html($b->phone) ?></td-->
                        <!--td><?= esc_html($b->email) ?></td-->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
