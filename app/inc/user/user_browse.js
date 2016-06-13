$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip(); 

    var usersTable = $('#users').DataTable({ 
            "stateSave": true,
            "stateSaveParams": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_users'+window.location.pathname, JSON.stringify(oData) );
                },
            "stateLoadParams": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_users'+window.location.pathname) );
            },
            "bPaginate": true,
            "responsive": true,
            "pageLength": 10,
            "aaSorting":[],
            "language": { "url": "json/dataTables.polish.lang" }
    }); // end of function dataTable

    
    $('#users').on( 'draw.dt', function () {
        $('#users').show();
    });


    $('#addUser').on('click', function() { 
                   

        bootbox
            .dialog({
                closeButton: true,
                title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Dodanie nowego użytkownika</span></h3>',
                message: $('#userForm'),
                show: true 
            })
            
            .on('shown.bs.modal', function() {

                /*
                $('#new_user_password_1').rules("add", {required: true, minlength: 6});
                $('#new_user_password_2').rules("add", {required: true, minlength: 6,equalTo: "#new_user_password_1"});
                */

                $('#userForm').dirrty({preventLeaving: false})
                .on("dirty", function(){
                    $("#saveUser").removeAttr("disabled");
                })
                .on("clean", function(){
                    $("#saveUser").attr("disabled", "disabled");
                });


                set_new_user_to_form();
                
                $('#userForm').show();
                $('#username').focus(); 
            })
            .on('hide.bs.modal', function(e) { 
                $('#userForm').hide().appendTo('body');
            })
            .modal('show')
            .find("div.modal-dialog").addClass("new-userForm-width");
            
            


    });

    $('.editUser').on('click', function() {        
        userEdit($(this).attr('data-id'));
    }); // end editUser


    $('.deleteUser').on('click', function() {
        userDelete($(this), usersTable);    
    }); // end user deleteButton click

    $('.infoLoginUser').on('click', function() {
        user_info_login($(this));    
    }); // end user deleteButton click

});