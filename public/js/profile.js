$(document).ready(function()
{
    var boxProfile = $('.box-profile');
    var profileForm = $('.form-profile');

    profileForm.on('click', 'input', function () {
        $(this).closest('form').find('.alert').alert('close');
    });

    profileForm.on('click', '.action-update', function (e) {
        e.preventDefault();

        var form = $(this).closest('form');

        form.find('.form-group').removeClass('has-error');
        form.find('.help-block').remove();

        var call = new AjaxCall();
        call.send(form.attr('action'), "post", form.serialize(), function (data) {
            if (data.status === true) {
                form.prepend(showAlert('success', data.message));
                if (data.clear) {
                    form.find('.form-control').val('');
                }
            }
        }, function (errors) {
            $.each(errors.responseJSON, function (key, val) {
                makeErrorField(key, val[0]);
            });
        });
    });

    boxProfile.on('click', '.list-group-item', function (e) {
        e.preventDefault();

        var link = $(this);
        if (link.attr('href') == undefined)
            return false;

        var call = new AjaxCall();
        call.send(link.attr('href'), "get", {}, function (data) {
            if (data.status === true) {
                var message = $('<ul/>', {"class":'nav nav-stacked'});

                $.each(data.items, function (key, item) {
                    var li = $('<li/>');
                    var a = $('<a/>');
                    message.append(li.html(a.text(item.name)));
                });

                var dialog = bootbox.dialog({
                    animate: false,
                    backdrop: false,
                    onEscape: true,
                    title: data.title,
                    message: message,
                    className: 'modal-summary'
                });
            }
        });
    })
});
