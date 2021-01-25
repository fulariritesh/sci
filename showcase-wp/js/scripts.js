import Splide from '@splidejs/splide';

$(document).ready(function(){
	// Check if element exists
	if (!!$('.slider_testimonials').length) {
		new Splide( '.slider_testimonials', {
			perPage: 2,
			arrows: false,
			padding: {
				left : 0,
				right: '2rem',
			},
			trimSpace: false,
			breakpoints: {
				768: {
					perPage: 1,
				},
			}
		} ).mount();
	}
	if (!!$('.slider_brands').length) {
		new Splide( '.slider_brands', {
			type: "loop",
			perPage: 8,
			arrows: false,
			pagination: false,
			padding: {
				left : 0,
				right: 0,
			},
			trimSpace: true,
			breakpoints: {
				990 : {
					perPage: 4,
				},
				768: {
					perPage: 2,
				},
			}
		} ).mount();
	}


	$('.brands_carousel').carousel({
	  interval: 2000
	})

	/* Profile details page - dynamically show custom gender text field */
	$("input[type='radio']").on('click', function (e){
		var genvalue = $("input[name='gender']:checked").val();
		if(genvalue === 'custom'){
			$('#custom_gender').removeClass('d-none');
		}else{
			$('#custom_gender').addClass('d-none');
		}
	});
})