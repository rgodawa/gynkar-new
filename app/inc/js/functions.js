function error_to_console(x,e) {
        if (x.status==0) {
            console.log('You are offline!!\n Please Check Your Network.');
        } else if(x.status==404) {
            console.log('Requested URL not found.');
        } else if(x.status==500) {
            console.log('Internel Server Error.');
        } else if(e=='parsererror') {
            console.log('Error.\nParsing JSON Request failed.');
        } else if(e=='timeout'){
            console.log('Request Time out.');
        } else {
            console.log('Unknow Error.\n'+x.responseText);
        }
    } // end error_to_console

function set_stations_to_form(stringFromServer, mySelector) {
    var arrayOfValues = stringFromServer.split(",");
    var $checkboxes = $(mySelector + " input[type=checkbox]");
    
    $checkboxes.each(function(idx, element){
        element.checked = (arrayOfValues.indexOf(element.value) != -1); 
    });
} // end set_stations_to_form 

function myDialog(myTitle, myImage, myClass, myReload) {
    var my_reload = ((myReload == undefined) ? false : myReload);
    bootbox.dialog({
            closeButton: true,
            title: myTitle,
            message: '<img class="myDialog" src="' + myImage + '"/>',
            buttons: {
                success: {  
                label: "Zamknij",
                className: ((myClass == undefined) ? "btn-success" : myClass),
                callback: function() {
                    if (my_reload == true) {
                        location.reload();
                        }
                    }
                }
            }
        });
} // end myDialog 

function myProjectAddedDialog(myTitle, myImage, myClass) {
    bootbox.dialog({
            closeButton: true,
            title: myTitle,
            message: '<img class="myDialog" src="' + myImage + '"/>',
            buttons: {
                success: {  
                label: "Zamknij",
                className: ((myClass == undefined) ? "btn-success" : myClass),
                callback: function() {
                        window.location.assign('projekty-otwarte');
                    }
                }
            }
        });
} // end myDialog


function myProduct_button( myButton ) {
    var myId = myButton.attr('data-product'); 

    $.ajax({
            url: 'product_data.php',
            method: 'POST',
            data: {id: myId},
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {
            var response = data[0];
            myButton.removeClass('btn-default btn-primary btn-success btn-danger');
            myButton.html(response.product_type_name + '<br/>' + 'Beta: ' + response.product_date_of_beta);

            switch (true) {
                case ((response.stage_date_diff < 0) && (response.stage_opened != 0)):
                    myButton.addClass('btn-danger');
                    break;                
                case (response.stage_closed == 0):
                    myButton.addClass('btn-default');
                    break;
                case (response.stage_opened == 0):
                    myButton.addClass('btn-success');
                    break;
                default:
                   myButton.addClass('btn-primary');
                    break; 
            }    
       });
    
} 

function prompt_buttons() {
    return {
            'cancel': {
                label: 'Anuluj',
                className: 'btn-default pull-left'
                },
            'confirm': {
                label: 'Zapisz',
                className: 'btn-success pull-right'
                }
            };
}

function create_table_audit(myArray) {
    var rt = '<h3 class="text-center">Brak danych.</3>'; 
    var rowCount = myArray.length;
    if (rowCount != 0)  {
        var columnCount = Object.keys(myArray[0]).length;
        
        var table = $("<table />");
        var header = table[0].createTHead();
        var body = table[0].createTBody();
    
        var row = header.insertRow(0); 
        for (var i = 0; i < columnCount; i++) {
            var cell = row.insertCell(-1);
            var obj = myArray[0];
            cell.innerHTML = Object.keys(obj)[i];
        }
    
        for (var i = 0; i < rowCount; i++) {
            var row = body.insertRow(-1);
            var obj = myArray[i];
            var keys = Object.keys(obj);
            for (var j = 0; j < columnCount; j++) {
                var cell = row.insertCell(-1);                
                cell.innerHTML = obj[keys[j]];
            }
        }     
    
        rt = '<div class="table-responsive">';
        rt = rt + '<table id="infoTable" class="table table-striped table-bordered table-vcenter" width="100%">';
        rt = rt + table.html();
        rt = rt + '</table>';
        rt = rt + '</div>';
    
        rt = rt + '<script>';
        rt = rt + '$(document).ready(function() {'
        rt = rt + '$("#infoTable").DataTable(';
        rt = rt + '{"language": {"url":"json/dataTables.polish.lang" }, "aaSorting":[]});';
        rt = rt + '});';
        rt = rt + '</script>';
   
    }
    return rt;
}

function reformatDate(dateStr) {
  dArr = dateStr.split("-");  // ex input "2010-01-18"
  return dArr[2]+ "-" +dArr[1]+ "-" +dArr[0]; //ex out: "18/01/10"
}

function reformatNumber(num) {
    var n = num.toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+' ') : $0;
    }).replace(".", ",");
} 