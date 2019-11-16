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

$("#start-exam, #yesConf").click(function() {

	if ($("#confirmation").is(":checked")) {
		let href = $("#start-exam").data('href');
		let id = $("#start-exam").data('id');

		Exam.start(href, id);	
	}

	$("#verificationModal").modal();
});

const Exam = {
	start : (href,id) => {
		$.ajax({
			url : BASE_URL + 'ajaxresponse/examstarted',
			method : 'POST',
			dataType: 'JSON',
			data: {id},
			success: function(data, err) {
				if (data.status == true && data.id) {
					window.location.href = href + '/' + data.id;
				}
			}
		})
	}
}

/*$('#login-with-google').click((e) => { 

	// console.log($(e.target));
	// let url = $(this).data('href');
	// console.log('url', $(this).data("href"));
	// window.open(url,'_blank','toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400');

});*/


var cart = {
	addToCart: function(self) {
		let course_id = self.data('course-id');
		let uuid = getCookie('uuid'); 
		let url = BASE_URL + 'ajaxresponse/add_to_cart';
		if (course_id && uuid) {
			$.post(url,{
				course_id,
				uuid
			}, function(response) {
				if (response.status === 0) {
					alert(response.message);
				} else if (response.status === 1) {
					// alert(response.message);
					cart.updateCart();
					// jQuery('html,body').animate({scrollTop:0},0); 
					window.location = BASE_URL + 'cart';
				}
			})
		}
	},
	removeCartItem: function(self) {
		let id = self.data('id');
		let url = BASE_URL + 'ajaxresponse/remove_cart_item/' + id;
		$.get(url,function(response) {
			if (response.status === 1) {
				window.location.reload();
			} else if (response.status === 0) {
				console.log('something went wrong while removing item from cart');
			}
		})
	},
	updateCart: function() {
		let url = BASE_URL + 'ajaxresponse/get_cart_item_count';
		$.get(url,function(response) {
			if (response.cart_items > 0) {
				$('#cart_items_count').html(response.cart_items + ' course');
			}
		})
	}
}


$("#add-to-cart").click(function(e) {
	e.preventDefault();
	cart.addToCart($(this));
})

$(".remove-cart-item").click(function(e) {
	e.preventDefault();
	if (confirm('Sure you want to remove this ?')) {
		cart.removeCartItem($(this));
	}
})


const isEmpty = (value) => {
	return value === undefined ||
  value === null ||
  (typeof value === 'object' && Object.keys(value).length === 0) ||
  (typeof value === 'string' && value.trim().length === 0);
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


cart.updateCart();

$("#checkout-form").on('submit',function(e) {
	e.preventDefault();  
	let formData = new FormData($("#checkout-form")[0]);
	let url = $(this).attr('action');
	$.ajax({
		url: url,
		type: 'POST', 
		data: formData,
		processData: false,
		contentType: false, 
		success: function(response) {
			let { status, form_error, message, redirect_url } = response;

			if (status === 0) {
				if (!isEmpty(form_error)) { 
					$.each(form_error, (key, val) => {
						let elem = $('input[name="'+key+'"]');  
						if (key === 'billing_city' || key === 'billing_country' || key === 'billing_state') {
							key = key.replace('billing_','');
							elem = $(`#${key}`);
						}

						elem.parent().removeClass('has-error has-success').addClass(val.length > 0 ? 'has-error' : 'has-success').find('.text-danger').remove();
						elem.after(val); 
					});

					jQuery('html, body').animate({
						scrollTop: $('.has-error').first().offset().top - 100
					},500); 
				}
			} else {
				$('.form-group').removeClass('has-error has-success');
				$('.text-danger').remove();
			}

			if(!isEmpty(redirect_url)) {
				window.location = redirect_url;
				return '';
			}

			if (!isEmpty(message)) {
				alert(message);
			}
		}
	});
});

$('#place-order').click(function() {
	$("#checkout-form").submit();
})