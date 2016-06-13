$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip(); 

    var titlesTable = $('#titles').DataTable({ 
            "stateSave": true,
            "stateSaveParams": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_titles'+window.location.pathname, JSON.stringify(oData) );
                },
            "stateLoadParams": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_titles'+window.location.pathname) );
            },
            "bPaginate": true,
            "responsive": true,
            "pageLength": 10,
            "aaSorting":[],
            "language": { "url": "json/dataTables.polish.lang" }
            /*
            dom: 'Bfrtip',
            buttons: [
            {
                text: 'Dodaj',
                tag: 'button',
                className: 'btn btn-primary',
                action: function ( e, dt, node, config ) {
                    addTitle();
                }
            }
        ]
        */
    }); // end of function dataTable 


    $('#titles').on( 'draw.dt', function () {   
        $('#titles').show();
    });


    $('#addTitle').click(function(){addTitle();});

    function addTitle() {
        box = bootbox.prompt({
                title: "Tytuł kategorii",
                buttons: prompt_buttons(),
                callback: function(result) {  
                    if (!!result) { 
                        var form_data = {id: 0, title: result};
                        $.ajax({
                            url: 'title_update.php',
                            method: 'POST',
                            data: form_data,
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
                                myDialog('Nowa kategoria dodana', 'css/cartoons/Julian.png', 'btn-success', true);
                                break;
                            }
                        });
                    }
                }
            });

        return true;      
    } 

    $('.editTitle').on('click', function() {        
        var myId = $(this).attr('data-id');
        var $button = $('button[data-id="' + myId + '"]'),
                      $tr     = $button.closest('tr'),
                      $cells  = $tr.find('td');
        box = bootbox.prompt({
                title: "Tytuł kategorii",
                value: $cells.eq(1).text(),
                buttons: prompt_buttons(),
                callback: function(result) {
                if (!!result) {
                    $.ajax({
                        url: 'title_update.php',
                        dataType : 'json',
                        method: 'POST',
                        data: {id: myId, title: result},
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
                                $cells.eq(1).text(response.title);
                                myDialog('Tytuł kategorii zaktualizowany', 'css/cartoons/Julian.png', 'btn-success', false);
                                break;
                        }
                    });
                }
            } 
        }); 
    }); // end editTitle


    $('.deleteTitle').on('click', function() {
            var myId = $(this).attr('data-id'),
                title = $(this).closest('tr').find('.title').text();
            bootbox.confirm({ 
                closeButton: true,
                message: 'Czy usunąć kategorię: ' + title + '?', 
                buttons: {
                    'cancel':  { label: 'Anuluj', className: 'btn-default pull-left' },
                    'confirm': { label: 'Usuń', className: 'btn-danger pull-right' }
                    },
                callback: function(result){ 
                    if (result) {
                        var form_data = {id: myId};
                        $.ajax({
                            url: 'title_delete.php',
                            method: 'POST',
                            data:  form_data,
                            error: function(x,e) { error_to_console(x,e) }
                        }).success(function(data) {
                                var response = data[0];
                                console.log(response.id);
                                var $button = $('button[data-id="' + response.id + '"]'),
                                    $tr     = $button.closest('tr')
                                titlesTable.row($tr).remove().draw( false );
                                myDialog('Kategoria usunięta', 'css/cartoons/Delete.jpg');
                            });
                    } // end of if
                }
            });
        }); // end title deleteButton click



}); // end ready

function prompt_buttons() {
    return {
            'cancel': {
                label: 'Anuluj',
                className: 'btn-default pull-left'
                },
            'confirm': {
                label: 'Zapisz',
                className: 'btn-success pull-right'
                }
            };
}