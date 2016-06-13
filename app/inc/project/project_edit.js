function project_edit(myObj) {
    $.ajax({
        url: 'project_data.php?id=' + myObj.attr('data-id'),
        dataType : 'json',
        method: 'GET',
        error: function(x,e) { error_to_console(x,e) }
    }).success(function(data) {
        var response = data[0];
        set_data_to_form_edit(response);
        set_stations_to_form(response.list_notice, '#users_notice');

        $("#projectFormEdit").dirrty({preventLeaving: false})
        .on("dirty", function(){
            $("#save").removeAttr("disabled");
        })
        .on("clean", function(){
            $("#save").attr("disabled", "disabled");
        });
        
        var box = bootbox.dialog({
            closeButton: true,
            onEscape: function() { return $('#save').prop('disabled'); },
            title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Edycja projektu</span></h3>',
            message: $('#projectFormEdit'),
            show: false 
        });
        
        box.on('shown.bs.modal', function() {
            $('#projectFormEdit').show() 
        })
        box.on('hide.bs.modal', function(e) {
            $('#projectFormEdit').hide().appendTo('body');
        })
        box.modal('show').find("div.modal-dialog")
        .addClass("projectFormEdit-width")
        .find('.bootbox-close-button').removeAttr('data-dismiss');
    });
}

function project_cancel() {
    bootbox.confirm({ 
        closeButton: true,
        title: '<h3><i class="glyphicon glyphicon glyphicon-alert"></i><span> Uwaga!</span></h3>',
        message: '<div class="text-center">Zmiany nie zostaną zachowane.</br>Kontynuować?</div>', 
        buttons: {
            'cancel':  { label: 'Nie',  className: 'btn-default pull-left' },
            'confirm': { label: 'Tak',  className: 'btn-danger pull-right' }
            },
        callback: function(result){
            if (result) { $('#projectFormEdit').parents('.bootbox').modal('hide'); }
            }
        });
}

