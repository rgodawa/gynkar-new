function userEdit(myId) {        
   $.ajax({
       url: 'user_data.php?id=' + myId,
       dataType : 'json',
       method: 'GET',
       error: function(x,e) { error_to_console(x,e) }
   }).success(function(data) {           
       var box = userEdit_box();
           box               
           .on('shown.bs.modal', function() {

               $('#new_user_password_1').rules("remove");
               $('#new_user_password_2').rules("remove");
            
               $('#userFormEdit').dirrty({preventLeaving: false})
               .on("dirty", function() {
                   $("#saveUserEdit").removeAttr("disabled");
               })
               .on("clean", function() {
                   $("#saveUserEdit").attr("disabled", "disabled");
               });

               set_user_to_form(data);
               
               $('#userFormEdit').show() 
           })
           .on('hide.bs.modal', function(e) { 
               $('#userFormEdit').hide().appendTo('body');
           })
           .modal('show').find("div.modal-dialog").addClass("userForm-width")
   }); 

} 

function userEdit_box() {
    return bootbox.dialog({
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-edit"></i><span> Edycja danych użytkownika</span></h3>',
            message: $('#userFormEdit'),
            show: false 
            });
}

function set_user_to_form(data) {
    var userData = data[0];

    $('#userFormEdit #username').val(userData.username);
    $('#userFormEdit #first_name').val(userData.first_name);
    $('#userFormEdit #last_name').val(userData.last_name);
    $('#userFormEdit #email').val(userData.email);

    $('#userFormEdit #role_id')
        .find('input[type="radio"]')
        .filter(function(index) { return $(this).val() == userData.role_id; })
        .prop('checked', true);

    $("#userFormEdit #default_notice").prop('checked', (userData.default_notice == "1"));
    
    $("#userFormEdit #change_password").prop('checked', false);
    $('#userFormEdit #password_old').val('');
    $('#userFormEdit #password_new_1').val('');
    $('#userFormEdit #password_new_2').val('');
    
    $('#userFormEdit #saveUserEdit').attr('user-id', userData.id);

    $('#userFormEdit #panelPassword').show();
    $('.new_user_password').hide();
}

function set_new_user_to_form() {   
    $('#userForm #username').val('');
    $('#userForm #first_name').val('');
    $('#userForm #last_name').val('');
    $('#userForm #email').val('');
    $('#userForm #new_user_password_1').val('');
    $('#userForm #new_user_password_2').val('');

    $('#userForm #role_id')
    .find('input[type="radio"]')
    .filter(function(index) { return $(this).val() == 4; })
    .prop('checked', true);

    $("#userForm #default_notice").prop('checked', false);   
    $('#saveUser').attr('user-id', '0');

    //$('#panelPassword').hide();
    //$('.new_user_password').show();
}