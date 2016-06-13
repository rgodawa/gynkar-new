function project_submit(projectsTable) {
    var users_notice = $.map($('#users_notice input:checkbox:checked'), function(e, i) {
            return +e.value;
            });
    var status_change = $('#project_status').find('input[type="radio"]:checked').attr('data-is-dirrty');
    var form_data = {
        id: $('#projectFormEdit').find('#id').val(),
        title_id: $('#projectFormEdit').find('#title_id').val(),
        title_number: $('#projectFormEdit').find('#title_number input').val(),
        status_id: $('#project_status').find('input[type="radio"]:checked').val(),
        users_notice: users_notice.join(',')
    } 
    $.ajax({
        url: 'project_update.php',
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
                myDialog('Projekt o podanej nazwie i numerze jest już zarejestrowany', 'css/cartoons/Sam.png', 'btn-warning');
                $('#projectFormEdit').find('#title_id').focus();
                break;
            case (response.id > 0):
                var $button = $('button[data-id="' + response.id + '"]'),
                    $tr     = $button.closest('tr'),
                    $cells  = $tr.find('td');
                $cells.eq(1).html(response.full_title);
                if (status_change == 'true') {
                    projectsTable.row($tr).remove().draw( false );  
                }
                myDialog('Dane projektu zaktualizowane', 'css/cartoons/Julian.png');                  
                $('#projectFormEdit').parents('.bootbox').modal('hide');
                break;
        }
    });
}