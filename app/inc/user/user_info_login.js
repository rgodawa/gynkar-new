function user_info_login(myObj) {
var title = myObj.closest('tr').find('.username').text();
    myObj.prop('disabled', true).tooltip('hide');
    $.ajax({
        url: 'user_login_audit.php?id=' + myObj.attr('data-id'),
        dataType : 'json',
        method: 'GET',
        error: function(x,e) { error_to_console(x,e) }
    }).success(function(data) {
        myObj.prop('disabled', false);
        var myHtml = create_table_audit(data[0]);
        bootbox
        .alert({ 
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-log-in"></i><span>'
                    + ' Historia logowania użytkownika: '
                    + title + '</span></h3>',
            message: myHtml
        })
        .modal('show').find("div.modal-dialog").addClass("infoTable-width")
        .find('.bootbox-close-button').removeAttr('data-dismiss');
    });
}

