function product_delete(myObj, projectsTable) {
var product_id = myObj.attr('data-product'),
    product = myObj.attr('data-product-group'),
    title = myObj.closest('tr').find('.title').text();

    console.log(myObj);

    bootbox.confirm({ 
        closeButton: false,
        title: '<h3><i class="glyphicon glyphicon glyphicon-remove"></i></h3>',
        message: '<h3 class="text-center">Czy usunąć ' + product + ' projektu:</br>' + title + '?</h3>', 
        buttons: {
            'cancel':  { label: 'Nie', className: 'btn-default pull-left' },
            'confirm': { label: 'Tak', className: 'btn-danger pull-right' }
            },
        callback: function(result){ 
            if (result) {
                var form_data = {id: product_id};
                $.ajax({
                    url: 'product_delete.php',
                    method: 'POST',
                    data:  form_data,
                    error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                        /*
                        var response = data[0];
                        myObj.attr('data-product', '0');
                        myObj.html('');
                        myObj.removeClass('btn btn-sm editProduct btn-default btn-primary btn-success btn-danger');

                        myObj.addClass('btn btn-default addProduct glyphicon glyphicon-plus');
                        myObj.attr("data-toggle", "tooltip");
                        myObj.attr("data-placement", "bottom");
                        myObj.attr("title", "");
                        myObj.attr("data-original-title", "Dodaj " + myObj.attr("data-product-group"));
                        */
                        myDialog('Produkt usunięty', 'css/cartoons/Delete.jpg', 'btn-success', true);
                    });
            } 
        }
    });
}