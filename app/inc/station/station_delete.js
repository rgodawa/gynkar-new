function station_delete(myObj, myTable) {
var myId = myObj.attr('data-id'),
    station = myObj.closest('tr').find('.station-name').text();

    bootbox.confirm({ 
        closeButton: true,
        message: 'Czy usunąć stację: ' + station + '?', 
        buttons: {
            'cancel':  { label: 'Anuluj', className: 'btn-default pull-left' },
            'confirm': { label: 'Usuń', className: 'btn-danger pull-right' }
            },
        callback: function(result){ 
            if (result) {
                var form_data = {id: myId};
                $.ajax({
                    url: 'station_delete.php',
                    method: 'POST',
                    data:  form_data,
                    error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                        var response = data[0];
                        console.log(response.id);
                        var $button = $('button[data-id="' + response.id + '"]'),
                            $tr     = $button.closest('tr')
                        myTable.row($tr).remove().draw( false );
                        myDialog('Kategoria usunięta', 'css/cartoons/Delete.jpg');
                    });
            } // end of if
        }
    });
}