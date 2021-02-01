import Splide from '@splidejs/splide';
import Lightbox from 'lightbox2';

$(document).ready(function(){
	// Check if element exists
	if (!!$('.slider_headshot').length) {
		const headshot = new Splide( '.slider_headshot', {
			perPage: 1,
			cover: true,
			arrows: false,
			pagination: false,
			padding: {
				left : 0,
				right: 0,
			},
			trimSpace: false,
			breakpoints: {
				768: {
					perPage: 1,
				},
			}
		} ).mount();
		if (!!$('.slider_headshot_thumbnail').length){
			const thumbnail = new Splide( '.slider_headshot_thumbnail', {
				perPage: 4,
				gap: 10,
				cover: true,
				focus: 'center',
				rewind: true,
				arrows: false,
				pagination: false,
				isNavigation: true,
				fixedWidth  : "132px",
				height: 105,
				breakpoints : {
					'990': {
						fixedWidth: "50%",
						height    : 100,
					}
				}
			} ).mount();
			headshot.sync( thumbnail ).mount()		
		}
	}
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
	/* 

		!!! --- Use conditional fields in acf --- !!! ~ Wiseman 

	*/
	$("input[type='radio']").on('click', function (e){
		var genvalue = $("input[name='gender']:checked").val();
		if(genvalue === 'custom'){
			$('#custom_gender').removeClass('d-none');
		}else{
			$('#custom_gender').addClass('d-none');
		}
	});
})