var $ = jQuery;

webshims.setOptions('waitReady', false);
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');

$("#meta-box-date-proto").hide();
$("#js-add-event-date-field").on("click", function () {
    var $el = $("#meta-box-date-proto").clone().attr("id", "").show();
    $el.find("input[name*=event_date]").attr("type", "date");
    $el.find("input[name*=time]").attr("type", "time");
    $("#meta-box-date-wrap").appendPolyfill($el);
});
