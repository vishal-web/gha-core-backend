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
					state.append($('<option>', {
						value: '',
						text: 'Select state'
					}));
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
					city.append($('<option>', {
						value: '',
						text: 'Select city'
					}));
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

$("#start-exam").click(function() {
	let href = $(this).data('href');
	let id = $(this).data('id');
	$.ajax({
		url : BASE_URL + 'ajaxresponse/examstarted',
		method : 'POST',
		dataType: 'JSON',
		data: {id},
		success: function(data, err) {
			if (data.status == true) {
				window.location.href = href;
			}
		}
	})
})

/*$('#login-with-google').click((e) => { 

	// console.log($(e.target));
	// let url = $(this).data('href');
	// console.log('url', $(this).data("href"));
	// window.open(url,'_blank','toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400');

});*/