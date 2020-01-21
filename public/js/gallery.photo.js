$(document).ready(function()
{
    var filerInput = $('#filerInputPhoto');
    var filerInputUpload = $('.filerInput-upload-photo');
    var filerInputProgress = $('.filerInput-progress');

    var filerChangeInput = '<div class="jFiler-input-dragDrop">\
        <div class="jFiler-input-inner">\
            <div class="jFiler-input-icon">\
                <i class="icon-jfi-cloud-up-o"></i>\
            </div>\
            <div class="jFiler-input-text">\
                <h3>Drag&Drop files here</h3>\
                <span style="display:inline-block; margin: 15px 0">or</span>\
            </div>\
            <a class="jFiler-input-choose-btn blue">Browse Files</a>\
        </div>\
    </div>';

    var filerItem = '<li class="jFiler-item">\
        <div class="jFiler-item-container">\
            <div class="jFiler-item-inner">\
                <div class="jFiler-item-thumb">\
                    <div class="jFiler-item-status"></div>\
                    <div class="jFiler-item-thumb-overlay">\
                        <div class="jFiler-item-info">\
                            <div style="display:table-cell;vertical-align: middle;">\
                                <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                <span class="jFiler-item-others">{{fi-size2}}</span>\
                            </div>\
                        </div>\
                    </div>\
                    {{fi-image}}\
                </div>\
                <div class="jFiler-item-assets jFiler-row">\
                    <ul class="list-inline pull-left">\
                        <li>{{fi-progressBar}}</li>\
                    </ul>\
                    <ul class="list-inline pull-right">\
                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                    </ul>\
                </div>\
            </div>\
        </div>\
    </li>';

    filerInput.filer({
        limit: 10,
        fileMaxSize: 1,
        extensions: ["jpg", "png", "gif"],
        showThumbs: true,
        addMore: true,
        changeInput: filerChangeInput,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: filerItem,
            canvasImage: false,
            removeConfirmation: false,
        },
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
                $.each(data.files, function (key, file) { html += file.html; });
                galleryItems.prepend(html);
            }
        });
    });

    var galleryItems = $("#gallery-items");

    galleryItems.on('click', '.action-thumbnail', function (e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function () {
            var call = new AjaxCall();
            call.mark(btn, '.action-thumbnail');
        });
    });

    galleryItems.on('click', '.action-remove', function (e) {
        e.preventDefault();
        var btn = $(this);
        new BootBox().confirm(btn, function () {
            var call = new AjaxCall();
            call.remove(btn, '.model-gallery-item');
        });
    });
});
