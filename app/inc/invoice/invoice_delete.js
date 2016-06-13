function invoice_delete(myObj, invoicesTable) {
    var myId = myObj.attr('invoice-id'),
        title = myObj.closest('tr').find('.invoice_number').text();
        
    myObj.prop('disabled', true).tooltip("hide");

    bootbox.confirm({ 
        closeButton: true,
        message: 'Czy usunąć fakturę nr: ' + title + '?', 
        buttons: {
            'cancel':  { label: 'Anuluj', className: 'btn-default pull-left' },
            'confirm': { label: 'Usuń', className: 'btn-danger pull-right' }
            },
        callback: function(result){ 
            myObj.prop('disabled', false);
            if (result) {
                var form_data = {id: myId};
                $.ajax({
                    url: 'invoice_delete.php',
                    method: 'POST',
                    data:  form_data,
                    error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                        var response = data[0];
                        var $button = $('button[invoice-id="' + response.id + '"]'),
                            $tr     = $button.closest('tr')
                        invoicesTable.row($tr).remove().draw( false );
                        myDialog('Faktura usunięta', 'css/cartoons/Delete.jpg');
                    });
            } // end of if
        }
    });
}