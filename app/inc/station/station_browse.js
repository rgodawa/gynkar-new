$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip(); 

    var stationsTable = $('#stations').DataTable({ 
            "stateSave": true,
            "stateSaveParams": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_stations'+window.location.pathname, JSON.stringify(oData) );
                },
            "stateLoadParams": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_stations'+window.location.pathname) );
            },
            "bPaginate": true,
            "responsive": true,
            "pageLength": 10,
            "aaSorting":[],
            "language": { "url": "json/dataTables.polish.lang" }
    }); // end of function dataTable 


    $('#stations').on( 'draw.dt', function () {   
        $('#stations').show();
    });

    $('#addStation').click(function() {
        station_new();
    });

    $('.editStation').click(function() {
        station_edit($(this));
    });           

    $('.deleteStation').click(function() {
        station_delete($(this), stationsTable);
    }); 

}); // end ready

