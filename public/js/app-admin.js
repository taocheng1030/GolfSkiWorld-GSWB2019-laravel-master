$(document).ready(function() {
    // Auto logout
    var Auth = $('#Auth');
    var checkTimer = 60 * 1000;
    setTimeout(function check() {
        var call = new AjaxCall();
        call.send(Auth.data('url'), "get", {}, function(data) {
            if (data.status === false || Auth.data('id') != data.id) {
                window.location.reload();
            }
        });
        setTimeout(check, checkTimer);
    }, checkTimer);



    /**
     * Button actions
     **/

    var buttonActions = $('.buttons');

    buttonActions.on('click', '.action-dialog', function(e) {
        e.preventDefault();
        new BootBox().dialog($(this));
    });

    buttonActions.on('click', '.action-push', function(e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function() {
            var call = new AjaxCall();
            call.mark(btn, '.action-push');
        });
    });

    buttonActions.on('click', '.action-delete', function(e) {
        e.preventDefault();
        new BootBox().delete($(this), function() {
            window.location.reload();
        });
    });

    buttonActions.on('click', '.action-trash', function(e) {
        e.preventDefault();
        new BootBox().delete($(this), function() {
            window.location.reload();
        });
    });

    var phoneInputs = document.getElementsByClassName("phone");
    for (var phoneInput of phoneInputs) {
        window.intlTelInput(phoneInput);
    }

    /**
     * System messages
     **/

    var notifications = $('.notifications-menu');

    $('.menu', notifications).on('click', 'a', function(e) {
        e.preventDefault();
        e.stopPropagation();

        new Notifications().button($(this));
    });

    $('.menu', notifications).on('click', 'strong', function(e) {
        e.preventDefault();
        e.stopPropagation();

        window.location.href = $(this).data('url');
    });

    $('.menu', notifications).on('click', 'button', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var item = $(this).closest('a');
        var menu = item.closest('.notifications-menu');
        var ids = [];
        ids.push(item.data('id'));

        new Notifications().remove(item, menu, ids);
    });

    $('.footer', notifications).on('click', 'a', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var item = $(this);
        var menu = item.closest('.notifications-menu');
        var ids = [];

        $.each($('a[data-id]', menu), function(key, item) {
            ids.push($(item).data('id'));
        });

        new Notifications().clear(item, menu, ids);
    });


    /**
     * Deal/Last minute elements
     **/

    var limiterID = $('#limiterID');

    $('.limiterField').hide();
    $('input[type="checkbox"]', limiterID).each(function(i, e) {
        var limiter = $(this);
        if (limiter.prop("checked") == true) {
            $('#limiterID' + limiter.val()).show();
        }
    });

    limiterID.on('change', 'input[type="checkbox"]', function() {
        $('.limiterField').hide();
        var limiter = $(this);
        if (limiter.prop("checked") == true) {
            $('#limiterID' + limiter.val()).show();
        }
    });

    $('#ddlSelectResort').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
    });

    $('#ddlSelectRestaurant').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
    });

    $('#ddlSelectHotel').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
    });

    $('#ddlSelectDestinfo').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
    });

    $('#dateTimeStarts').datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss"
    });

    $('#dateTimeEnds').datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss"
    });



    /**
     * Tab extends
     **/

    var navTabsExtend = $('.nav-tabs-extend');

    navTabsExtend.on('click', 'a[data-url]', function(e) {
        var link = $(this);
        new AjaxCall().html(link.data('url'), $(link.attr('href')));
    });
});