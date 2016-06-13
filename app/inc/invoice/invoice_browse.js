$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"}); 

    var invoicesTable = $('#invoices').DataTable({ 
            "stateSave": true,
            "stateSaveParams": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_invoices'+window.location.pathname, JSON.stringify(oData) );
                },
            "stateLoadParams": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_invoices'+window.location.pathname) );
            },
            "bPaginate": true,
            "responsive": true,
            "pageLength": 10,
            "aaSorting":[],
            "language": { "url": "json/dataTables.polish.lang" },
            "bAutoWidth": false,
            "aoColumns": [
                { "sWidth": "5%" },  
                { "sWidth": "5%" }, 
                { "sWidth": "5%" }, 
                { "sWidth": "5%" }, 
                { "sWidth": "5%" },  
                { "sWidth": "40%" },  
                { "sWidth": "5%" }, 
                { "sWidth": "5%" },
                { "sWidth": "5%" },
                { "sWidth": "20%" }
            ],
            "footerCallback": function( tfoot, data, start, end, display ) {
              var api = this.api();
              var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$, ]/g, '')*1 : typeof i === 'number' ? i : 0;
              };
 
              /*
              total = api
                  .column( 6 )
                  .data()
                  .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                  }, 0 );

              console.log(total);
              */

              pageNettoTotal = api
                  .column( 6, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                  }, 0 );
              pageVatTotal = api
                  .column( 7, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                  }, 0 );
              pageBruttoTotal = api
                  .column( 8, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                  }, 0 );

              // Update footer
              $( api.column( 6 ).footer() ).html(reformatNumber((pageNettoTotal/100).toFixed(2)));
              $( api.column( 7 ).footer() ).html(reformatNumber((pageVatTotal/100).toFixed(2)));
              $( api.column( 8 ).footer() ).html(reformatNumber((pageBruttoTotal/100).toFixed(2)));
            }
    }); // end of function dataTable

    $('#invoices').on( 'draw.dt', function () {
        $('#invoices').show();
    });

    $('.invoiceDelete').on('click', function() {
        invoice_delete($(this), invoicesTable);
    });

    $('.invoicePrint').on('click', function() {
        invoice_print($(this));
    });

    $('.invoiceEdit').on('click', function() {
        invoice_edit($(this));
    });

});