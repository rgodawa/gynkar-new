function product_info(myObj) {
var id = myObj.attr('data-product'),
    title = myObj.closest('tr').find('.title').text() + ', produkt: ' +
        myObj.attr('data-product-group') + ' - ' + myObj.html();
    
    $('#projects-panel').spin();
    myObj.prop('disabled', true).tooltip('hide');
    $.ajax({
        url: 'product_data_audit.php?id=' + id,
        dataType : 'json',
        method: 'GET',
        error: function(x,e) { error_to_console(x,e) }
    }).success(function(data) {
        $('#projects-panel').spin(false);
        myObj.prop('disabled', false);
        var myHtml = create_table_audit(data[0]);
        bootbox
        .alert({ 
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-info-sign"></i><span>'
                    + ' Historia zmian projektu: '
                    + title + '</span></h3>',
            message: myHtml
        })
        .modal('show').find("div.modal-dialog").addClass("infoTable-width")
        .find('.bootbox-close-button').removeAttr('data-dismiss');
    });
}