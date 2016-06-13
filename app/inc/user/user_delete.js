function userDelete(myObj, usersTable) {  
    var myId = myObj.attr('data-id'),
        username = myObj.closest('tr').find('.username').text();
        bootbox.confirm({ 
            closeButton: false,
            title: '<h3><i class="glyphicon glyphicon glyphicon-remove"></i></h3>',
            message: '<h3 class="text-center">Czy usunąć użytkownika:</br>' + username + '?</h3>', 
            buttons: {
                'cancel':  { label: 'Nie', className: 'btn-default pull-left' },
                'confirm': { label: 'Tak', className: 'btn-danger pull-right' }
                },
            callback: function(result){ 
                if (result) {
                    var form_data = {id: myId};
                    $.ajax({
                        url: 'user_delete.php',
                        method: 'POST',
                        data:  form_data,
                        error: function(x,e) { error_to_console(x,e) }
                    }).success(function(data) {
                            var response = data[0];
                            var $button = $('button[data-id="' + response.id + '"]'),
                                $tr     = $button.closest('tr')
                            usersTable.row($tr).remove().draw( false );
                            myDialog('Użytkownik usunięty', 'css/cartoons/Delete.jpg');
                        });
                } // end of if
            }
        });
}

