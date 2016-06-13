function set_data_to_form_edit(response) {
    $('#projectFormEdit').find('#id').val(response.id); 
    $('#projectFormEdit')
        .find('#title_id option')
        .filter(function(index) { return $(this).val() == response.title_id; }).prop('selected', true); 
    $('#projectFormEdit')
        .find('#title_number').datepicker('setDate', response.title_number);
    $('#project_status')
        .find('input[type="radio"]')
        .filter(function(index) { return $(this).val() == response.status_id; })
        .prop('checked', true); 
    $('#project_status')
        .find('input[type="radio"]')
        .filter(function(index) { return $(this).val() == 2; })
        .prop('disabled', (response.stage_opened != 0));
    $('#project_status')
        .find('input[type="radio"]')
        .filter(function(index) { return $(this).val() == 3; })
        .prop('disabled', ((response.stage_opened != 0) || (response.invoice_id == 0)));
    $("#save").attr("disabled", "disabled");        
}

function set_data_to_form(response) {
    //console.log(response.spot_date_of_issue);
	$('#projectForm')
        .find('#id').val(response.id);
    $('#projectForm')
        .find('#title_id option').filter(function(index) { return $(this).val() == response.title_id; }).prop('selected', true); 
    $('#projectForm')
        .find('#title_number').datepicker('setDate', new Date(response.spot_date_of_issue));
    $('#projectForm')
        .find('input[type="radio"][name="spot_radio"]').filter(function(index) { return $(this).val() == response.spot_type_id; }).prop('checked', true);
    $('#projectForm')
        .find('#spot_date_of_issue').datepicker('setDate', response.spot_date_of_issue);
    $('#projectForm')
        .find('#spot_date_of_beta').datepicker('setDate', response.spot_date_of_beta);        
    $('#projectForm')
        .find('#spot_length').val(response.spot_length);

    set_stations_to_form(response.spot_stations, '#spot_stations');

    $('#projectForm')
        .find('input[type="radio"][name="billboard_radio"]').filter(function(index) { return $(this).val() == response.billboard_type_id; }).prop('checked', true);
    $('#projectForm')
        .find('#billboard_date_of_issue').datepicker('setDate', response.billboard_date_of_issue);
    $('#projectForm')
        .find('#billboard_date_of_beta').datepicker('setDate', response.billboard_date_of_beta);        
    $('#projectForm')
        .find('#billboard_length').val(response.billboard_length); 

    set_stations_to_form(response.spot_stations, '#billboard_stations');    

    $('#projectForm')
        .find('input[type="radio"][name="youtube_radio"]').filter(function(index) { return $(this).val() == response.youtube_type_id; }).prop('checked', true);            
    $('#projectForm')
        .find('#youtube_date_of_issue').datepicker('setDate', response.youtube_date_of_issue);
    $('#projectForm')
        .find('#youtube_date_of_beta').datepicker('setDate', response.youtube_date_of_beta);            
    $('#projectForm')
        .find('#youtube_length').val(response.youtube_length);        

}

function check_choice_product() {
    var spot = $('input[type="radio"][name="spot_radio"]:checked').val();
    var billboard = $('input[type="radio"][name="billboard_radio"]:checked').val();
    var youtube = $('input[type="radio"][name="youtube_radio"]:checked').val();
    return (parseInt(spot) + parseInt(billboard) + parseInt(youtube));
}

function get_data_from_form() {
		var spot_stations = $.map($('#spot_stations input:checkbox:checked'), function(e, i) {
            return +e.value;
            }); 
        var billboard_stations = $.map($('#billboard_stations input:checkbox:checked'), function(e, i) {
            return +e.value;
            }); 
        var users_notice = $.map($('#users_notice input:checkbox:checked'), function(e, i) {
            return +e.value;
            }); 

        var data = {
            id: 0,
            title_id: $('#title_id').val(),
            title_number: $('#title_number input').val(),

            spot_type_id: $('input[type="radio"][name="spot_radio"]:checked').val(),
            spot_date_of_issue: $('#spot_date_of_issue input').val(),            
            spot_date_of_beta: $('#spot_date_of_beta input').val(),
            spot_length: $('#spot_length').val(),
            spot_comments: $('#spot_comments').val(),
            spot_stations: spot_stations.join(','),

            billboard_type_id: $('input[type="radio"][name="billboard_radio"]:checked').val(),
            billboard_date_of_issue: $('#billboard_date_of_issue input').val(),            
            billboard_date_of_beta: $('#billboard_date_of_beta input').val(),
            billboard_length: $('#billboard_length').val(),
            billboard_comments: $('#billboard_comments').val(),
            billboard_stations: billboard_stations.join(','),  

            youtube_type_id: $('input[type="radio"][name="youtube_radio"]:checked').val(),
            youtube_date_of_issue: $('#youtube_date_of_issue input').val(),            
            youtube_date_of_beta: $('#youtube_date_of_beta input').val(),
            youtube_length: $('#youtube_length').val(),
            youtube_comments: $('#youtube_comments').val()
        } 
        return data;
}

       


