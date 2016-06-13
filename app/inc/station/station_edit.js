function station_edit(myObj) {
    var myId = myObj.attr('data-id');
    var $button = $('button[data-id="' + myId + '"]'),
        $tr     = $button.closest('tr'),
        $cells  = $tr.find('td');
    var box = bootbox.prompt({
            title: "Tytuł kategorii",
            value: $cells.eq(1).text(),
            buttons: prompt_buttons(),
            callback: function(result) {
            if (!!result) {
                $.ajax({
                    url: 'station_update.php',
                    dataType : 'json',
                    method: 'POST',
                    data: {id: myId, station_name: result},
                    error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                    var response = data[0];
                    switch (true) {
                        case (response.id == 0):
                            myDialog('Błąd zapisu do bazy', 'css/cartoons/Error.png');
                            break;
                        case (response.id == -1):
                            myDialog('Kategoria  o podanym tytule jest już zarejestrowana', 'css/cartoons/Sam.png', 'btn-warning');
                            break;
                        case (response.id > 0):
                            $cells.eq(1).text(response.station_name);
                            myDialog('Tytuł kategorii zaktualizowany', 'css/cartoons/Julian.png', 'btn-success', false);
                            break;
                    }
                });
            }
        } 
    });
}