function invoice_edit( myObj) {
        var invoice_id = myObj.attr('invoice-id');
        
        myObj.prop('disabled', true).tooltip("hide");

        $.ajax({
            url: 'invoice_data.php?id=' + invoice_id,
            dataType : 'json',
            method: 'GET',
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {
            var response = data[0];
           
            $('#invoice_number input').val(response.invoice_number);
            $('#date_of_issue').datepicker('setDate', response.date_of_issue);
            $('#date_of_sale').datepicker('setDate', response.date_of_sale);
            $('#date_termin').datepicker('setDate', response.date_termin);
            $('#unit_price').val(response.unit_price);
            $("textarea[name='description']").val(response.description);
            $('#saveInvoice').attr('invoice-id', response.id);
            $('#invoice_number_form').show();

            var box = invoice_box( response.invoice_number );
                            
                box
                .on('shown.bs.modal', function() {
                    
                    $('#projectFormInvoice').show(); 
                })
                .on('hide.bs.modal', function(e) {
                    $('#projectFormInvoice').hide().appendTo('body');
                    myObj.prop('disabled', false);
                })
                .modal('show').find("div.modal-dialog").addClass("projectFormEdit-width");
            
        });
        
} // 

function invoice_update_box( myTitle) {
    return bootbox.dialog({
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Edycja faktury: '
                   + myTitle + '</span></h3>',
            message: $('#projectFormInvoice'),
            show: false 
            });
}