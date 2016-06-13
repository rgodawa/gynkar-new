$(document).ready(function() {

    $.ajax({
        url: 'project_data.php?id=0',
        dataType : 'json',
        method: 'GET',
        error: function(x,e) { error_to_console(x,e) }
    }).success(function(data) {

        set_data_to_form(data[0]); 

        $('#projectForm').find('[name="spot"]').prop("disabled", true);
        $('#projectForm').find('[name="spot_station"]').prop("disabled", true);
        $('#projectForm').find('[name="billboard"]').prop("disabled", true);
        $('#projectForm').find('[name="billboard_station"]').prop("disabled", true);
        $('#projectForm').find('[name="youtube"]').prop("disabled", true);

        $('#projectForm').on("change", function (e) {
            if (check_choice_product() == 0) {
                $("#saveProject").attr("disabled", "disabled"); 
                $("#saveProjectBis").attr("disabled", "disabled");  
            } else {
                $("#saveProject").removeAttr("disabled"); 
                $("#saveProjectBis").removeAttr("disabled");
            }
        });

        $("#projectForm").dirrty({preventLeaving: false})
        .on("dirty", function(){
            $("#saveProject").removeAttr("disabled");
            $("#saveProjectBis").removeAttr("disabled");
        })
        .on("clean", function(){
            $("#saveProject").attr("disabled", "disabled");
            $("#saveProjectBis").attr("disabled", "disabled");
        });
   
        var box = bootbox.dialog({
                closeButton: false,
                //onEscape: function() { return $('#saveProject').prop('disabled'); },
                title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Dodawanie nowego projektu</span></h3>',
                message: $('#projectForm'),
                show: false
            });
        box.on('shown.bs.modal', function() {
                $('#projectForm').show() 
                $('#projectForm').find('#title_id').focus();
            });

       
        box.on('hide.bs.modal', function(e) {
                $('#projectForm').hide().appendTo('body');
                window.location.assign('projekty-otwarte');   
            });
       
        box.modal('show').find("div.modal-dialog")
        .addClass("projectForm-width")
        .find('.bootbox-close-button').removeAttr('data-dismiss');

    }); // end ajax success


    function myConfirm(validator) {
        var box = bootbox.confirm({ 
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-alert"></i><span> Uwaga!</span></h3>',
            message: '<div class="text-center">Zmiany nie zostaną zachowane.</br>Kontynuować?</div>', 
            buttons: {
                'cancel':  { label: 'Nie',  className: 'btn-default pull-left' },
                'confirm': { label: 'Tak',  className: 'btn-danger pull-right' }
                },
            callback: function(result){
                if (result) { myResetForm(validator); }
                }
            });
    }

    function myResetForm(validator) {
        validator.resetForm();
        $('#projectForm').parents('.bootbox').modal('hide');    
    }

    $('#cancelProjectBis').click(function(e){ 
        $('#cancelProject').click()
    });    
  
    $('#cancelProject').click(function(e){ 
        e.preventDefault();
        if ($('#saveProject').prop('disabled') == false) {
            myConfirm(validator);
            } else {
            myResetForm(validator);
        } 
    });

    
    var validator = $('#projectForm').validate({
        rules: {
            spot_station:  {
                required: function(element) {
                    return $('input[type="radio"][name="spot_radio"]:checked').val() != 0;
                    }
                },
            billboard_station:  {
                required: function(element) {
                    return $('input[type="radio"][name="billboard_radio"]:checked').val() != 0;
                    }
                }
        },

        messages: {   
            spot_station: {
                required: "Proszę wybrać stacje!"
            },
            billboard_station: {
                required: "Proszę wybrać stacje!"
            }
        },

        errorPlacement: function(error, element) {
            if (element.attr("name") == "spot_station") {
                error.appendTo("#spot_stations_error");
            } else {
                error.appendTo("#billboard_stations_error");
            }              
        },

        submitHandler: function(form) {
 
            var form_data = get_data_from_form();
        
            $.ajax({
                url: 'project_update.php',
                method: 'POST',
                data: form_data,
                error: function(x,e) { error_to_console(x,e) }
            }).success(function(data) {
                response = data[0];

                switch (true) {
                    case (response.rt == 0):
                        myDialog('Błąd zapisu do bazy', 'css/cartoons/Error.png');
                        break;
                    case (response.rt == -1):
                        myDialog('Projekt o podanej nazwie i numerze jest już zarejestrowany', 'css/cartoons/Sam.png');
                        $('#projectForm').find('#title_id').focus();
                        break;
                    case (response.rt > 0):
                        myProjectAddedDialog('Projekt został dodany', 'css/cartoons/Scooby.png');
                        //$('#projectForm').parents('.bootbox').modal('hide');
                        break;
                }
    
            });

            return false;

        } // end submitHandler

    }); //end of validate
    
}); //end function ready

