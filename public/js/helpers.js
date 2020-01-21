function AjaxCall()
{
    var csrf_token = $('#CSRF').data('token');

    this.isUpload = false;

    this.send = function (url, method, data, success, error, type) {
        type = type || 'json';
        var successRes = function (data) {
            success(data);
        };

        var errorAlert = function (JSON) {
            var messages = $('<div/>');
            $.each(JSON, function (e, item) {
                $.each(item, function (e, message) {
                    message = isNaN(e) ? e + ' : ' + message : message;
                    messages.append('<div class="text-danger">' + message + '</div>');
                })
            });
            return messages.html();
        };

        var errorRes = function (e) {
            if (error)
                return error(e);

            console.log(e);
            $('.filerInput-progress').empty();

            if (e.responseJSON) {
                return bootbox.alert(errorAlert(e.responseJSON));
            } else {
                return bootbox.alert("Error found \nError Code: " + e.status + " \nError Message: " + e.statusText);
            }
        };

        data._token = csrf_token;

        var obj = {
            url: url,
            type: method,
            data: data,
            success: successRes,
            error: errorRes,
            dataType: type,
            timeout: 900000
        };

        if (this.isUpload === true) {
            obj.cache = false;
            obj.processData = false; // Don't process the files
            obj.contentType = false; // Set content type to false as jQuery will tell the server its a query string request
        }

        $.ajax(obj);
    };

    this.mark = function (btn, all, method) {
        var oldIcon = this.icon(btn, "fa fa-spinner fa-pulse");
        this.send(btn.data('url'), method ? method : "post", { id:btn.data('id') }, function (data) {
            if (data.status === true) {
                $(all).removeClass('btn-success').addClass('btn-default');
                btn.removeClass('btn-default').addClass('btn-success');
                btn.find('i').attr({ "class" : oldIcon });
            }
        });
    };

    this.remove = function (btn, closest, method) {
        var oldIcon = this.icon(btn, "fa fa-spinner fa-pulse");
        this.send(btn.data('url'), method ? method : "post", { id:btn.data('id') }, function (data) {
            if (data.status === true) {
                btn.closest(closest).remove();
            } else {
                btn.find('i').attr({ "class" : oldIcon });
            }
        });
    };

    this.clear = function (btn, closest, method) {
        this.send(btn.data('url'), method ? method : "post", { id:btn.data('id') }, function (data) {
            if (data.status === true) {
                btn.closest(closest).remove();
            }
        });
    };

    this.icon = function (btn, iconClass) {
        btn = btn.find('i');
        var old = btn.attr('class');
        btn.attr({ "class":iconClass });
        return old;
    };

    this.html = function (link, element, data, method) {
        element.html('');
        this.send(link, method || "get", data || {}, function (data) {
            if (data.status === true) {
                element.html(data.message);
            }
        });
    };
}

function BootBox()
{
    var call = new AjaxCall();

    this.delete = function (btn, success, method) {
        __confirm(btn.data('confirm'), function () {
            call.send(btn.data('url'), method || "post", { id:btn.data('id'), _method:btn.data('method') }, function (data) {
                if (data.status === true) {
                    return success(data);
                }
            });
        });
    };

    this.dialog = function (btn, method) {
        call.send(btn.data('url'), method || "get", {}, function (data) {
            if (data.status === true) {
                __dialog(data.title, data.message, data.className)
            }
        });
    };

    this.confirm = function (btn, success, size) {
        __confirm(btn.data('confirm'), success, size);
    };

    var __confirm = function (message, success, size) {
        bootbox.confirm({
            size: size,
            animate: false,
            backdrop: false,
            onEscape: true,
            closeButton: false,
            message: message,
            callback: function(result) {
                if (result === true) {
                    return success();
                }
            }
        });
    };

    var __dialog = function(title, message, className) {
        bootbox.dialog({
            animate: false,
            backdrop: false,
            onEscape: true,
            closeButton: false,
            title: title,
            message: message,
            className: className
        });
    }
}


function Notifications()
{
    var call = new AjaxCall();

    this.add = function (element, data) {
        __render(element, data, function () {
            element.find('.menu').prepend(data.message);
        });
    };

    this.clear = function (item, element, ids) {
        call.send(item.data('url'), "post", { ids:ids }, function (data) {
            if (data.status === true) {
                __render(element, data, function () {
                    element.find('.menu').text(null);
                });
            }
        });
    };

    this.remove = function (item, element, ids) {
        call.send(item.data('url'), "post", { ids:ids }, function (data) {
            if (data.status === true) {
                item.closest('li').remove();
                __render(element, data);
            }
        });
    };

    this.button = function (element) {
        element.find('.action').toggle();
        element.find('.time').toggle();
    };

    var __render = function (element, data, callback) {
        element.find('.label').text(data.total);
        element.find('.header').text(data.header);

        if (data.total !== null) element.find('.footer').show();
        if (data.total === null) element.find('.footer').hide();

        if (callback) callback();
    };
}

function showAlert(type, text)
{
    return '<div class="alert alert-' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + text + '</div>'
}

function makeErrorField(element, message)
{
    var filed = $('#' + element);
    var fieldRow = filed.closest('.form-group');

    if (fieldRow.find('.help-block').length == 0) {
        fieldRow.addClass('has-error');
        filed.after('<span class="help-block">' + message +'</span>');
    }

    filed.one('click', function () {
        fieldRow.removeClass('has-error');
        fieldRow.find('.help-block').remove();
    });
}
