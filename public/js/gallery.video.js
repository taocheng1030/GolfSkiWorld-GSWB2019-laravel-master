$(function()
{
    var filerInput = $('#filerInputVideo');
    var filerInputUpload = $('.filerInput-upload-video');
    var filerInputProgress = $('.filerInput-progress');

    var filerChangeInput = '<div class="jFiler-input-dragDrop">\
        <div class="jFiler-input-inner">\
            <div class="jFiler-input-icon">\
                <i class="icon-jfi-cloud-up-o"></i>\
            </div>\
            <div class="jFiler-input-text">\
                <h3>Drag&Drop files here</h3>\
                <span style="display:inline-block; margin: 10px 0">or</span>\
            </div>\
            <a class="jFiler-input-choose-btn blue">Browse Files</a>\
            <div class="jFiler-input-text">\
                <span style="display:inline-block; margin:10px 0 0">(<small>Video duration must not exceed 90 seconds</small>)</span>\
            </div>\
        </div>\
    </div>';

    filerInput.filer({
        limit: 1,
        fileMaxSize: 200,
        extensions: ["flv", "mp4", "m3u8", "ts", "3gp", "mov", "avi", "wmv"],
        showThumbs: true,
        // addMore: true,
        changeInput: filerChangeInput,
        theme: "dragdropbox",
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
            dragContainer: null,
        },
        afterShow: function () {
            filerInputUpload.parent().show();
        },
        onEmpty: function () {
            if ($('.jFiler-item').length <= 1)
                filerInputUpload.parent().hide();
        }
    });

    filerInputUpload.on('click', function(e) {

        e.stopPropagation();
        e.preventDefault();

        filerInputProgress.html('<div class="modal-backdrop in"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');

        var filerKit = filerInput.prop("jFiler");
        var filerInputEl = $(filerKit.inputEl);

        var data = new FormData();
        data.append('_token', filerInputEl.data('token'));
        data.append('id', filerInputEl.data('id'));
        data.append('model', filerInputEl.data('model'));
        $.each(filerKit.files_list, function (k,item) {
            data.append('files[]', item.file)
        });

        var call = new AjaxCall();
        call.isUpload = true;
        call.send(filerInputEl.data('url'), "post", data, function (data) {
            filerKit.reset();
            if (data.status === true) {
                filerInputUpload.parent().hide();
                filerInputProgress.empty();
                var html = '';
                $.each(data.files, function (key, file) { html += file.message; });
                // moviesItems.prepend(html);
                return bootbox.alert({
                    animate: false,
                    backdrop: false,
                    closeButton: false,
                    message: html
                });
            }
        });
    });

    var call = new AjaxCall();
    var moviesItems = $("#movies-items");

    moviesItems.on('click', '.action-awarded', function (e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function () {
            call.mark(btn, '.action-awarded');
        });
    });

    moviesItems.on('click', '.action-promo', function (e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function () {
            call.mark(btn, '.action-promo');
        });
    });

    moviesItems.on('click', '.action-remove', function (e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function () {
            call.remove(btn, '.model-movies-item');
        });
    });

    moviesItems.on('click', '.action-tags', function (e) {
        e.preventDefault();
        var btn = $(this);
        call.send(btn.data('url'), "get", { id:btn.data('id') }, function (data) {
            if (data.status === true)
            {
                var makeChecklist = function () {
                    var messages = $('<div/>', {"class":'tags-checklist'});
                    $.each(data.tags, function (e, tag) {
                        var formGroup = $('<div/>', {"class":'form-group'});
                        formGroup.append('<div class="checkbox"><label></label></div>');
                        var checkbox = $('<input/>', {"name":'tags[]', "class":'tag-item', "type":'checkbox', "checked":tag.checked, "data-id":tag.id});
                        formGroup.find('label').append(checkbox).append(tag.name);
                        messages.append(formGroup);
                    });
                    return messages;
                };

                bootbox.confirm({
                    size: "small",
                    animate: false,
                    backdrop: false,
                    closeButton: false,
                    title: data.title,
                    message: makeChecklist,
                    callback: function(result) {
                        if (result) {
                            var checklist = [];
                            $('.tags-checklist').find('.tag-item').each(function (e, i) {
                                if (i.checked)
                                    checklist.push(i.dataset.id)
                            });
                            call.send(btn.data('url'), "post", { id:btn.data('id'), tags: checklist });
                        }
                    }
                });
            }
        });
    });
});
