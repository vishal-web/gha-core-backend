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

	
	

	

	html += '<div class="form-group choice removeChoice-'+ counter +'">'+
	  '<label for="" class="col-md-3 control-label">Choice '+ counter +'</label>'+
	  '<div class="col-md-8">'+
	    '<div class="row">'+
	      '<div class="col-md-8">'+
	        '<input type="text" class="form-control" name="choice['+ counter +'][answer]" placeholder="Enter Answer">'+
	      '</div>'+
	      '<div class="col-md-4">'+
	        '<div class="checkbox">'+
	          '<label>'+
	            '<input type="hidden" name="choice['+ counter +'][correct]" value="0">'+
	            '<input type="checkbox" name="choice['+ counter +'][correct]" style="margin-top: 1px;">&nbsp;&nbsp;Correct ?'+
	          '</label>'+
	        	'<a class="removeChoice" data-choice="'+ counter +'" href="javascript:void(0);">&nbsp;&nbsp;&nbsp;&nbsp;Remove Choice</a>'+
	        '</div>'+
	      '</div>'+
	    '</div>'+
		'</div>';
	appendPlace.before(html);
});


$(document).on('click', '.removeChoice', function(e) {
	var choice = $(this).data('choice');
	$('.removeChoice-' + choice).remove();
});
