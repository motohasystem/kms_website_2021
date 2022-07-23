webshims.setOptions('waitReady', true);
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');

jQuery(function ($) {
    $(".button-booking").on("click", function (e) {
        var date = $(this).data("date");
        location.href = location.href.replace("?", "&").replace("calendar/", "booking?date=" + date 
            + "&time_start=" + $(this).data("time-start")
            + "&time_end="   + $(this).data("time-end"));
    });

    function resize_images() {
        $(".post-content").each(function (i, el) {
            var $img = $(el).find("img");
            var origW = $img.css("width", "auto").width();
            var wrapW = $(el).width();
            $img.width(wrapW);
            $img.css("height", "auto");
        });
    }
    resize_images();
    $(window).on("resize", resize_images);

    var slider = $('.bxslider').bxSlider({
        mode: "fade",
        speed: 5000,
        auto: true
    });
});
