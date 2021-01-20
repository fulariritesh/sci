import Splide from '@splidejs/splide';

$(document).ready(function(){

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

	$('.brands_carousel').carousel({
	  interval: 2000
	})

})