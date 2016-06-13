<script>
$(document).ready(function() {
	var role_id = <?php echo $user['role_id'] ?>;
	var container='body';
    var options={
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
        language: 'pl'
    }; 

    if (role_id == 4) {
    	
    	$('#productStageForm input').attr('disabled', 'disabled');
		$('#productStageForm select').attr('disabled', 'disabled');
		$('#productStageForm input[type=radio]').attr('disabled', 'disabled');
		$('#productStageForm textarea').attr('disabled', 'disabled');

		$('input[name="stage_1"]').prop('disabled', false);
		$('input[name="stage_2"]').prop('disabled', false);
		$('input[name="stage_3"]').prop('disabled', false);
		$('input[name="stage_7"]').prop('disabled', false);
	}

    $("#product_date_of_issue").datepicker(options).on('changeDate', function(ev) {}).on('hide', function(event) {
		event.preventDefault();
		event.stopPropagation();
	});

	$("#product_date_of_issue").datepicker(options).on('show', function(ev) {
		if ($(this).find('input').prop('disabled') == true) {
			$(this).datepicker('hide');	
		}
	});

	$("#product_date_of_beta").datepicker(options).on('changeDate', function(ev) {}).on('hide', function(event) {
		event.preventDefault();
		event.stopPropagation();
	});

	$("#product_date_of_beta").datepicker(options).on('show', function(ev) {
		if ($(this).find('input').prop('disabled') == true) {
			$(this).datepicker('hide');	
		}
	});


    $("[id^='planned_closing_date']").datepicker(options).on('changeDate', function(ev) {}).on('hide', function(event) {
		event.preventDefault();
		event.stopPropagation();
	});

	$("[id^='planned_closing_date']").datepicker(options).on('show', function(ev) {
		if ($(this).find('input').prop('disabled') == true) {
			$(this).datepicker('hide');	
		}
	});	

	$("[id^='closing_date']").datepicker(options).on('changeDate', function(ev) {}).on('hide', function(event) {
		event.preventDefault();
		event.stopPropagation();
	});

	$("[id^='closing_date']").datepicker(options).on('show', function(ev) {
		if ($(this).find('input').prop('disabled') == true) {
			$(this).datepicker('hide');	
		}
	});

	$(".radio input").change(function() {
		var stage_order = $(this).attr('stage-order');
		var nVal = $(this).val();
		var myButton = $('#save_' + stage_order);

		$('#closing_date_' + stage_order + ' input').prop('disabled', (nVal != 1));

		if ((nVal == 1) && ($('#closing_date_' + stage_order + ' input').val() == '')) {
			$('#closing_date_' + stage_order).datepicker('setDate', new Date());
		}

		if (nVal != 1) {
			$('#closing_date_' + stage_order + ' input').val('');
		}


		myButton.removeClass('btn-success');
        myButton.addClass('btn-default');
	});



	$('.cancel-button').click(function(e){
		e.preventDefault();
		if (($('#saveProduct').prop('disabled') == false) || ($('#saveStages').prop('disabled') == false)) {

			bootbox.confirm({ 
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-alert"></i><span> Uwaga!</span></h3>',
            message: '<div class="text-center">Zmiany nie zostaną zachowane.</br>Kontynuować?</div>', 
            buttons: {
                'cancel':  { label: 'Nie',  className: 'btn-default pull-left' },
                'confirm': { label: 'Tak', className: 'btn-danger pull-right' }
                },
            callback: function(result){
            	if (result) {
            		$('#productStageForm').parents('.bootbox').modal('hide');
            		}
            	}
        	});
			
		} else {
			$('#productStageForm').parents('.bootbox').modal('hide');	
		}
	});



	$('#saveProduct').click(function(e){ 
		e.preventDefault();
		var product_type_id = 0;
		var stations = $.map($('#stations input:checkbox:checked'), function(e, i) {
            return +e.value;
            });
		

		switch (true) {
			case ($('#spot_radio').is(':visible')):
			product_type_id = $('input[type="radio"][name="spot_radio"]:checked').val();
			break;
			case ($('#billboard_radio').is(':visible')):
			product_type_id = $('input[type="radio"][name="billboard_radio"]:checked').val();
			break;
			case ($('#youtube_radio').is(':visible')):
			product_type_id = $('input[type="radio"][name="youtube_radio"]:checked').val();
			break;
		}


		var form_data = {
			id: $(this).attr('product-id'),
			type_id: product_type_id,
			date_of_issue: $('#product_date_of_issue input').val(),
			date_of_beta: $('#product_date_of_beta input').val(),
			length: $('#product_length').val(),
			comments: $('#product_comments').val(),
			stations: stations.join(',')
		}


		$.ajax({
            url: 'product_update.php',
            method: 'POST',
            data: form_data,
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {
        	var response = data[0];
        	var button = $('#projects button[data-product="' + response.id + '"]');
        	button.attr("data-is-dirrty", "true");

        	$('#saveProduct').prop('disabled', true);

        	if ($('#saveStages').prop('disabled') == false) {
        		$('#saveStages').click();	
        	} else {
        		myDialog('Dane Produktu zostały zaktualizowane', 'css/cartoons/Mia.png');
        		$('#productStageForm').parents('.bootbox').modal('hide');
        	}
        	
    	});   	   	

	}); // end saveProduct click

	$('#saveStages').click(function(e){ 
		e.preventDefault();
		var product_id = $(this).attr('product-id');
		var button = $('#projects button[data-product="' + product_id + '"]');

		for (var i = 1; i <= 8; i++) {  
			var buttonId = $('#save_' + i);
			if (buttonId.length) {  
				buttonId.click();
			}
		}


        button.attr("data-is-dirrty", "true");
        $('#saveStages').prop('disabled', true);

        if ($('#saveProduct').prop('disabled') == false) {
        	$('#saveProduct').click()
        } else {
        	myDialog('Etapy zostały zaktualizowane', 'css/cartoons/Psi.png');
			$('#productStageForm').parents('.bootbox').modal('hide');
       	}

	}); // end saveStages click


	$("[id^='save_']").click(function(){ 
		var stage_id = $(this).attr('stage-id');
		var stage_order = $(this).attr('stage-order');
		var stage_done = $('#stage_done_' + stage_order)
			.find('input[type="radio"]:checked')
            .val();
		var planned_closing_date = $('#planned_closing_date_' + stage_order + ' input').val();
		var closing_date = $('#closing_date_' + stage_order + ' input').val();

		var form_data = {
			id: stage_id,
			stage_done: stage_done,
			planned_closing_date: planned_closing_date,
			closing_date: closing_date
		}
		
        $.ajax({
            url: 'product_stages_update.php',
            method: 'POST',
            data: form_data,
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {

        });

	}); // end button save click
});
</script>