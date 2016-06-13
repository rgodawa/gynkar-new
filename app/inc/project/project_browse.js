$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"}); 

    var projectsTable = $('#projects').DataTable({ 
            "stateSave": true,
            "stateSaveParams": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_projects'+window.location.pathname, JSON.stringify(oData) );
                },
            "stateLoadParams": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_projects'+window.location.pathname) );
            },
            "bPaginate": true,
            "responsive": true,
            "pageLength": 10,
            "aaSorting":[],
            "language": { "url": "json/dataTables.polish.lang" },
            "bAutoWidth": false, // Disable the auto width calculation 
           
            "aoColumns": [
                { "sWidth": "5%" },  
                { "sWidth": "20%" }, 
                { "sWidth": "10%" }, 
                { "sWidth": "10%" }, 
                { "sWidth": "13%" },  
                { "sWidth": "13%" },  
                { "sWidth": "13%" }, 
                { "sWidth": "16%" } 
            ]
           
    }); // end of function dataTable

    $('#projects').on( 'draw.dt', function () {
        $('#projects').show();
    });


    $('.editProduct').on('click', function() {  
        if ( $(this).hasClass( "addProduct" ) ) {
            product_add($(this), projectsTable);
        } else {    
            product_edit($(this));    
        }
    }); // end editProduct click


    $('.invoiceProject').on('click', function() {
        if ( $(this).hasClass( "invoicePrint" ) ) {
            invoice_print($(this)); 
        } else {   
            invoice_new($(this));
        }
    });

    $('.invoicePrint').on('click', function() {
        invoice_print($(this));
    });

    $('.infoProject').on('click', function() {
        project_info($(this));
    }); 

    $('.deleteProject').on('click', function() {
        project_delete($(this), projectsTable)
    }); 

    $('.editProject').on('click', function() {
        project_edit($(this));
    }); 

    $('.addProduct').on('click', function() {
        if ( $(this).hasClass( "editProduct" ) ) {
            product_edit($(this));
        } else {    
            product_add($(this), projectsTable);
        }
    });



    $('#projectFormEdit').submit(function(e) {
        e.preventDefault();
        project_submit(projectsTable);
    });

    $('#projectFormEdit #cancel').click(function(e) {
        e.preventDefault();
        if ($('#projectFormEdit #save').prop('disabled') == false) {
            project_cancel()
        } else {
            $('#projectFormEdit').parents('.bootbox').modal('hide');
        }
        return true;
    }); 

    var menu_spot = new BootstrapMenu('.editProduct', {
    fetchElementData: function($rowElem) {
        //return $rowElem.data('product');
        return $rowElem.attr('data-product');
    },

    actionsGroups: [
    ['1' ],['2'],['3']
    ],

    actions: {1:{
     
            name: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                return 'Usuń ' + $button.data('product-group');
            },
            iconClass: 'fa-trash-o',
            classNames: 'action-danger',
            onClick: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                product_delete($button);
            }
            }, 
            2:{
            name: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                return 'Edytuj ' + $button.data('product-group');
            },
            iconClass: 'fa fa-pencil',
            onClick: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                $button.click();
            } 
            },
            3:{
            name: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                return 'Historia zamian';
            },
            iconClass: 'fa fa-info',
            onClick: function(myProduct_id) {
                var $button = $('button[data-product="' + myProduct_id + '"]');
                product_info($button);
            }
            }}
    });

});