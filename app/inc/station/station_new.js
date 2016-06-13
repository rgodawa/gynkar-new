function station_new() {
  var station_box = bootbox.prompt({
      title: "Nazwa stacji",
      buttons: prompt_buttons(),
      callback: function(result) {  
          if (!!result) { 
              var form_data = {id: 0, station_name: result};
              $.ajax({
                  url: 'station_update.php',
                  method: 'POST',
                  data: form_data,
                  error: function(x,e) { error_to_console(x,e) }
              }).success(function(data) {
                  var response = data[0];         
                  switch (true) {
                  case (response.id == 0):
                      myDialog('Błąd zapisu do bazy', 'css/cartoons/Error.png');
                      break;
                  case (response.id == -1):
                      myDialog('Stacja o podanej nazwie jest już zarejestrowana', 'css/cartoons/Sam.png', 'btn-warning');
                      break;
                  case (response.id > 0):
                      myDialog('Nowa stacja dodana', 'css/cartoons/Julian.png', 'btn-success', true);
                      break;
                  }
              });
          }
      }
    });
   return true;      
}