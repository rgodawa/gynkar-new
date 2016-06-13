function project_delete(myObj, projectsTable) {
var project_id = myObj.attr('data-id'),
    title = myObj.closest('tr').find('.title').text();

    bootbox.confirm({ 
        closeButton: false,
        title: '<h3><i class="glyphicon glyphicon glyphicon-remove"></i></h3>',
        message: '<h3 class="text-center">Czy usunąć projekt:</br>' + title + '?</h3>', 
        buttons: {
            'cancel':  { label: 'Nie', className: 'btn-default pull-left' },
            'confirm': { label: 'Tak', className: 'btn-danger pull-right' }
            },
        callback: function(result){ 
            if (result) {
                var form_data = {id: project_id};
                $.ajax({
                    url: 'project_delete.php',
                    method: 'POST',
                    data:  form_data,
                    error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                        var response = data[0];
                        var $button = $('button[data-id="' + response.id + '"]'),
                            $tr     = $button.closest('tr')
                        projectsTable.row($tr).remove().draw( false );
                        myDialog('Projekt usunięty', 'css/cartoons/Delete.jpg', 'btn-success', true);
                    });
            } 
        }
    });
}