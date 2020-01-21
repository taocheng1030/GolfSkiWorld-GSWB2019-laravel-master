$(document).ready(function()
{
    var sideBarForm = $('form');
    var sideBarTable = $('table');

    sideBarForm.on('click', '.action-sidebar-add', function (e) {
        e.preventDefault();
        var btn = $(this);
        var form = btn.closest('form');
        var call = new AjaxCall();
        call.send(form.attr('action'), "post", form.serialize(), function (data) {
            if (data.status === true) {
                var html = '<tr>' +
                    '<td>' + data.name +'</td>' +
                    '<td>' + data.link + '</td>' +
                '</tr>';
                btn.closest('.model-item').find('table').append(html);
                form.find('input').val('');
            }
        });
    }).on('submit', function (e) {
        e.preventDefault();
    });

    sideBarTable.on('click', '.action-sidebar-delete', function (e) {
        e.preventDefault();
        var btn = $(this);
        var table = btn.closest('table');
        if (confirm('Are you sure you want to delete this record?')) {
            var call = new AjaxCall();
            call.send(table.data('url'), "post", { id:btn.data('id'), model:table.data('model') }, function (data) {
                if (data.status === true) {
                    btn.closest('tr').remove();
                }
            });
        }
    });
});
