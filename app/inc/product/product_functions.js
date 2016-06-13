function set_stages_to_form(data) {
	var arrayLength = data[0].length;
    var productData = data[0][0];

    set_stations_to_form(productData.list_stations_id, '#stations');

    $('#product_date_of_issue').datepicker('setDate', productData.product_date_of_issue);
    $('#product_date_of_beta').datepicker('setDate', productData.product_date_of_beta);
    $('#product_length').val(productData.product_length);
    $('#product_comments').val(productData.product_comments);

    $('#saveProduct').attr('product-id', productData.product_id );
    $('#saveStages').attr('product-id', productData.product_id );

    $('#saveProduct').attr("disabled", "disabled");
    $('#saveStages').attr("disabled", "disabled");

    $('#spot_radio').hide();
    $('#billboard_radio').hide();
    $('#youtube_radio').hide();


    switch (productData.product_group_id) {
        case '1':
            $('#spot_radio').show();
            $('#spot_radio')
            .find('input[type="radio"]')
            .filter(function(index) { return $(this).val() == productData.product_type_id; })
            .prop('checked', true);
            break;
        case '2':
            $('#billboard_radio').show();
            $('#billboard_radio')
            .find('input[type="radio"]')
            .filter(function(index) { return $(this).val() == productData.product_type_id; })
            .prop('checked', true);
            break;
        case '3':
            $('#youtube_radio').show();
            $('#youtube_radio')
            .find('input[type="radio"]')
            .filter(function(index) { return $(this).val() == productData.product_type_id; })
            .prop('checked', true);
            break;
    }


    
    if (productData.product_group_id == 3) {
        $('#stations_tv').hide();
        $('#form_date_of_beta').hide();
        $('#form_product_length').hide();
    } else {
        $('#stations_tv').show();
        $('#form_date_of_beta').show();
        $('#form_product_length').show();
    }

    for (var i = 0; i < arrayLength; i++) {            
        var response = data[0][i]; 
        var stag_order = response.prod_stag_order;
        var buttonId = '#save_' + stag_order;
        var myButton = $(buttonId);
        var myPanel = $('#panel_stage_' + stag_order);

        if (myPanel.length) { 
            get_panel_color(myPanel, response);
        }

        if (myButton.length) {
        	myButton.attr('stage-id', response.prod_stag_id);
        	myButton.attr('stage-order', stag_order);
            myButton.attr('product-id', productData.product_id );
            myButton.removeClass('btn-success');
            myButton.addClass('btn-default');
        }


        
        for (var key in response) {
            var tagId = '#' + key + '_' + stag_order;
            var myElement = $(tagId);

            if (myElement.length) {
                var $tag  = $(tagId)[0].tagName; 
                switch (true) {
                    case (myElement.is('.panel-heading')):
                        myElement.text(response[key]);
                        break;
                    case (myElement.is('.date')):
                        myElement.datepicker('setDate', new Date((response[key] == '0000-00-00') ? '' : response[key]));
                        break;
                    case (myElement.is('.radio')):
                        myElement
                            .find('input[type="radio"]')
                            .filter(function(index) { return $(this).val() == response[key]; })
                            .prop('checked', true);
                        break;
                    default:
                        myElement.val(response[key]);
                        break;   
                }
                
        }
    }
    }
}

function get_stages_title(data) {
    var title = '<h3><i class="glyphicon glyphicon glyphicon-edit"></i>';
    title += '<span> Projekt: ' + data.title + ' ' + data.title_number + ',</span>'; 
    title += '<span> produkt: ' + data.product_group_name + ' - ' + data.product_type_name + '</span></h3>';
    return title;
}

function set_stages_field_prop(nLength) {
    var nVal = 0;
    for (var i = 1; i <= nLength; i++) {
        nVal = $('#stage_done_' + i).find('input[type="radio"]:checked').val();
        $('#closing_date_' + i + ' input').prop('disabled', (nVal != 1));
    }
}

function get_panel_color(myPanel, myResponse) {
    myPanel.removeClass('panel-primary panel-success panel-default panel-danger panel-warning');

    switch (true) {
                case ((myResponse.stage_done == 0) && (myResponse.stage_date_diff == 0)):
                    myPanel.addClass('panel-warning');
                    break;
                case ((myResponse.stage_done == 0) && (myResponse.stage_date_diff < 0)):
                    myPanel.addClass('panel-danger');
                    break;
                case (myResponse.stage_done == 1):
                    myPanel.addClass('panel-success');
                    break;
                case ((myResponse.stage_done == 0) || (myResponse.stage_done == 2)):
                    myPanel.addClass('panel-default');
                    break;
                default:
                   myPanel.addClass('panel-primary');
                    break; 
            }
    return true;
}