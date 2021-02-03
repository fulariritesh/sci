import Splide from '@splidejs/splide';
import Lightbox from 'lightbox2';

// Edit Profile scripts
require("./bootstrap-editable.min.js");

$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();

	$.fn.editable.defaults.mode = 'inline';
	$.fn.editableform.buttons =
		'<button type="submit" class="btn btn-primary btn-sm editable-submit">' +
	    	'<i class="fa fa-fw fa-check"></i>' +
	    	'</button>' +
		'<button type="button" class="btn btn-warning btn-sm editable-cancel">' +
	    	'<i class="fa fa-fw fa-times"></i>' +
	    '</button>';
	    
	$('#name').editable({
 		type: 'text',
    	url: Edit.request_url,    
		send: "always",
	  	params: function(params) { 
			var data = {};
			data['id'] = params.pk;
			data[params.name] = params.value;
			data['action'] = 'sci_change_name';
			data['nonce'] = Edit.nonce;
			return data;
		}
	});

	$('#phone').editable({
		type: 'text',
		url: Edit.request_url, 
		send: "always",
	  	params: function(params) {  
			var data = {};
			data['id'] = params.pk;
			data['number'] = params.value;
			data['action'] = 'sci_change_number';
			data['nonce'] = Edit.nonce;
			return data;
		}
	});

	$('#gender').editable({
		source: [
			{
				value: 1,
				text: 'Male'
			},
			{
				value: 2,
				text: 'Female'
			}
		]
	});

	$('#country').editable({
		value: 'ru',    
		source: [
		      {value: 'gb', text: 'Great Britain'},
		      {value: 'us', text: 'United States'},
		      {value: 'ru', text: 'Russia'}
		   ]
	});
});

$(".card-header").click(function () {
	$(this).toggleClass("selected");
});
var video = document.querySelector("#videoElement");
const inpFile = document.getElementById("hsFile");
const previewContainer = document.getElementById("img-preview");
const previewImg = document.querySelector(".img-preview-img");
const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

if (inpFile) inpFile.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    previewDefaultTxt.style.display = "none";
    previewImg.style.display = "block";

    reader.addEventListener("load", function () {
      console.log(this);
      previewImg.setAttribute("src", this.result);
    });
    reader.readAsDataURL(file);
  }
})

if (navigator.mediaDevices) {
  navigator.mediaDevices
    .getUserMedia({ video: true })
    .then(function (stream) {
      previewDefaultTxtCam.style.display = "none";
      video.style.display = "block";
      video.srcObject = stream;
    })
    .catch(function (err0r) {
      console.log("Something went wrong!");
    });
}
$(document).ready(function () {
	$(".upload-div").hide();
	$(".file-edit-btns").hide();
	$(".btn-details-fileup").click(function () {
		$(".capture-div").hide();
		$(".upload-div").show();
		$(".file-edit-btns").show();
	});
});

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