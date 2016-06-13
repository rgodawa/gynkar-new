function product_add(myObj, projectsTable) {
    var title = myObj.closest('tr').find('.title').text(),
        produkt = myObj.attr('data-product-group');
    bootbox.confirm({ 
        closeButton: false,
        title: '<h3><i class="glyphicon glyphicon glyphicon-plus"></i></h3>',
        message: '<h3 class="text-center">Czy dodać nowy ' + produkt + ' do projektu ' + title + '?</h3>', 
        buttons: {
            'cancel':  { label: 'Nie', className: 'btn-default pull-left' },
            'confirm': { label: 'Tak', className: 'btn-success pull-right' }
            },
        callback: function(result){ 
            if (result) {
	           $.ajax({
                        url: 'product_insert.php',
                        method: 'POST',
                        data:  { project_id: myObj.data('project-id'),
                                 product_group_id: myObj.data('product-group-id'), 
                        		 product_type_id: myObj.data('product-type-id')
                        	}, 
                        error: function(x,e) { error_to_console(x,e) }
                }).success(function(data) {
                    /*
                	var response = data[0];
                    myObj.removeClass('billboard spot film YouTube btn btn-default addProduct glyphicon glyphicon-plus');
                    myObj.removeAttr("data-project-id");
                    myObj.removeAttr("title data-original-title");
                    myObj.removeAttr("data-product-type-id");
                    myObj.removeAttr("data-product-group-id");
                    myObj.removeAttr("data-toggle");
                    myObj.removeAttr("data-placement");

                    myObj.attr('data-product', response.id);
                    myObj.attr('data-product-group', response.product_group_name);
                    myObj.html(response.product_type_name + '<br/>' + 'Beta: ' + response.product_date_of_beta);
                    myObj.addClass('btn btn-sm editProduct btn-default'); 
                    */                
                   	myDialog('Produkt został dodany', 'css/cartoons/Scooby.png', 'btn-success', true);
                });
            }
        }
    });

}