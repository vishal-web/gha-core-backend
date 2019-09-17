$('#country').on('change', function(e) { 
	var state = $('#state').empty();
	var city = $('#city').empty();
	
	if (this.value !== '') {
		$.ajax({
			url : BASE_URL + 'ajaxresponse/get_states/' + this.value,
			method : 'GET',
			dataType: 'JSON',
			success: function(data, err) {
				if (data.length > 0) {
					data.forEach(function(row, index) {
						state.append($('<option>', {
							value: row.id,
							text: row.name
						}));
					})
				}
			}
		})
	}
});

$('#state').on('change', function(e) {  
	var city = $('#city').empty(); 
	if (this.value !== '') {
		$.ajax({
			url : BASE_URL + 'ajaxresponse/get_cities/' + this.value,
			method : 'GET',
			dataType: 'JSON',
			success: function(data, err) {
				if (data.length > 0) {
					data.forEach(function(row, index) {
						city.append($('<option>', {
							value: row.id,
							text: row.name
						}));
					})
				}
			}
		})
	}
});


$('#addChoice').on('click', function(e) {
	var appendPlace = $('#addChoice').parent().parent();
	var html = '';
	var counter = $('.choice').length + 1;
	var initializer = counter - 1;

	html += '<div class="form-group choice removeChoice-'+ counter +'">'+
	  '<label for="" class="col-md-2 control-label">Choice '+ counter +'</label>'+
	  '<div class="col-md-9">'+
	    '<div class="row">'+
	      '<div class="col-md-12 m-b-15">'+
	        '<input type="text" class="form-control" name="choice['+ initializer +'][answer]" placeholder="Enter Answer">'+
	      '</div>'+ 
	      '<div class="col-md-6">'+ 
	        '<input type="file" class="form-control" name="choice['+ initializer +'][image]" />' + 
	      '</div>'+
	      '<div class="col-md-6">'+
	        '<div class="checkbox">'+
	          '<label>'+
	            '<input type="hidden" name="choice['+ initializer +'][correct]" value="0">'+
	            '<input type="checkbox" name="choice['+ initializer +'][correct]" value="1" style="margin-top: 1px;">&nbsp;&nbsp;Correct ?'+
	          '</label>'+
	        	'<a class="removeChoice" data-choice="'+ counter +'" href="javascript:void(0);">&nbsp;&nbsp;&nbsp;&nbsp;Remove Choice</a>'+
	        '</div>'+
	      '</div>'+
	    '</div>'+
		'</div>';
	appendPlace.before(html);
});


$(document).on('click', '.removeChoice', function(e) {

	if (confirm('Sure you want to remove this ..?')) {
		var choice = $(this).data('choice');
		$('.removeChoice-' + choice).remove();

		var answer = $(this).data('answer'); 
		var question = $(this).data('question');
		if (typeof answer !== 'undefined' && answer > 0) {
			$.ajax({
				url : BASE_URL + 'ajaxresponse/removeanswer',
				method : 'POST',
				dataType: 'json',
				data: {answer, question, choice},
				success: function(response) {
					if (response.status == true) {
						console.log('option removed');
					} else {
						console.log('Something went wrong while removing options');
					}
				}
			})
		}
	}
});
