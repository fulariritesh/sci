import Splide from '@splidejs/splide';

$(document).ready(function(){

	new Splide( '.splide', {
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

	$('.brands_carousel').carousel({
	  interval: 2000
	})
	
})