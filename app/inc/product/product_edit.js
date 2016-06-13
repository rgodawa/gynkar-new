function product_edit(myObj) {
	var product_id = myObj.attr('data-product'),
    	$myButton = myObj;
      
      $myButton.attr("data-is-dirrty", "false")
      $.ajax({
      	url: 'product_stages_data.php?id=' + product_id,
      	dataType : 'json',
      	method: 'GET',
      	error: function(x,e) { error_to_console(x,e) }
      	}).success(function(data) {
          var myTitle = get_stages_title(data[0][0])
          set_stages_to_form(data)
          $('#panelProduct').dirrty({preventLeaving: false})
              .on("dirty", function(){
                  $("#saveProduct").removeAttr("disabled");
              })
              .on("clean", function(){
                  $("#saveProduct").attr("disabled", "disabled");
              })
          $("#panelStages").dirrty({preventLeaving: false})
              .on("dirty", function(){
                  $("#saveStages").removeAttr("disabled");        
              })
              .on("clean", function(){
                  $("#saveStages").attr("disabled", "disabled");
              })
          bootbox
          .dialog({
              closeButton: true,
              title: myTitle,
              message: $('#productStageForm'),
              onEscape: function() { 
                  return ($('#saveProduct').prop('disabled') && $('#saveStages').prop('disabled'));
              },
              show: false 
          })
          
          .on('shown.bs.modal', function() {
              $('#productStageForm').show() 
          })
          .on('hide.bs.modal', function(e) {
              $('#productStageForm').hide().appendTo('body');
              if ($myButton.attr('data-is-dirrty') == 'true') {
                  myProduct_button($myButton);    
              }
          })
          .modal('show').find("div.modal-dialog")
          .addClass("productStageForm-width")
          .find('.bootbox-close-button').removeAttr('data-dismiss')
         
      }); // end success
}