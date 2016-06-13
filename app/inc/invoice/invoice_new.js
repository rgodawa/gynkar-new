function invoice_new( myObj) {
        var project_id = myObj.attr('data-id'),
            button = myObj,
            title = myObj.closest('tr').find('.title').text()

        button.prop('disabled', true).tooltip("hide");

        $.ajax({
            url: 'project_invoice_item.php?id=' + project_id,
            dataType : 'json',
            method: 'GET',
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {
            var response = data[0];

            $('#date_of_issue').datepicker('setDate', response.date_of_issue);
            $('#date_of_sale').datepicker('setDate', response.date_of_sale);
            $('#date_termin').datepicker('setDate', response.date_termin);
            $('#unit_price').val(response.unit_price);
            $("textarea[name='description']").val(response.description);
            $('#saveInvoice').attr('project-id', response.id);

            var box = invoice_box( title );
                            
                box
                .on('shown.bs.modal', function() {
                    $('#projectFormInvoice').show(); 
                })
                .on('hide.bs.modal', function(e) {
                    $('#projectFormInvoice').hide().appendTo('body');
                    button.prop('disabled', false);
                })
                .modal('show').find("div.modal-dialog").addClass("projectFormEdit-width");

        });
        
} 

function invoice_box( myTitle) {
    return bootbox.dialog({
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Faktura za projekt: '
                   + myTitle + '</span></h3>',
            message: $('#projectFormInvoice'),
            show: false 
            });
} 

function invoice_refresh(response) {
  var $button = $('button[invoice-id="' + response.invoice_id + '"]'),
      $tr     = $button.closest('tr'),
      $cells  = $tr.find('td');
      $cells.eq(1).text(response.invoice_number);
      $cells.eq(2).text(response.date_of_issue);
      $cells.eq(3).text(response.date_of_sale);
      $cells.eq(4).text(response.date_termin);
      $cells.eq(5).text(response.description);
      $cells.eq(6).text(response.gross_total);
      $cells.eq(7).text(response.tax_amount);
      $cells.eq(8).text(response.total);
}

function invoice_buttom_attr(myProject_id, myInvoice_id) {
    var button = $('.invoiceProject[data-id="' + myProject_id + '"]');
    button.attr('invoice-id', myInvoice_id);
    button.attr('data-original-title', 'Wydruk faktury');
    button.removeClass('invoiceProject glyphicon glyphicon-usd');
    button.addClass('invoicePrint glyphicon glyphicon-print'); 
}

$('#saveInvoice').click(function(e) {
    e.preventDefault();
    
    if ($('#saveInvoice').attr('project-id')!== undefined ) {
        var myUpdate = 0;
        var myId = $('#saveInvoice').attr('project-id');
    }

    if ($('#saveInvoice').attr('invoice-id')!== undefined ) {
        var myUpdate = 1;
        var myId = $('#saveInvoice').attr('invoice-id');
    }

    var form_data = {
        update: myUpdate,
        id: myId,
        invoice_number: $('#invoice_number input').val(),
        date_of_issue: $('#date_of_issue input').val(),
        date_of_sale: $('#date_of_sale input').val(),
        date_termin: $('#date_termin input').val(),
        unit_price: $('#unit_price').val(),
        description: $("textarea[name='description']").val()
    }


    $.ajax({
        url: 'project_invoice.php',
        method: 'POST',
        data:  form_data,
        error: function(x,e) { error_to_console(x,e) }
    }).success(function(data) {
        var response = data[0];
        
        if (myUpdate == 0) {
            invoice_buttom_attr(myId, response.id);
        }
        if (myUpdate == 1) {
            invoice_refresh(response);
        }
        $('#projectFormInvoice').parents('.bootbox').modal('hide');
    });

});
