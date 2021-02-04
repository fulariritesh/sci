import Splide from '@splidejs/splide';
import Lightbox from 'lightbox2';
import Cropper from 'cropperjs';

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

$(document).ready(function () {
	/* Category Subcategory Page */
	$(".card-header").click(function () {
		$(this).toggleClass("selected");
		$(this).children('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
  	});

	/* Profile Details Page */ 
  	$("input[type='radio']").on('click', function (e){
		var genvalue = $("input[name='gender']:checked").val();
		if(genvalue === 'custom'){
			$('#custom_gender').removeClass('d-none');
		}else{
			$('#custom_gender').addClass('d-none');
		}
	});
});

/* Add Headshot(s) */ 
$(document).ready(function () {
	$(".upload-div").hide();
	$(".file-edit-btns").hide();

	$(".btn-details-fileup").click(function () {
		$(".capture-div").hide();
		$(".upload-div").show();
		$(".file-edit-btns").show();
	});

	var cropper;
	var data;
	var res;
	var indexHeadshot = 1;
	var canvas = document.querySelector("#canvas");
	var video = document.querySelector("#videoElement");
	const inpFile = document.getElementById("hsFile");
	const previewContainer = document.getElementById("img-preview");
	const previewImg = document.querySelector(".img-preview-img");
	const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
	const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

	$('li.splide__slide').click(function () {
		var index = $(this).attr("data-index");
		if(index){
			indexHeadshot = index;
			console.log('Headshot: '+indexHeadshot);
		}	
  	});

	inpFile.addEventListener("change", function () {
		const file = this.files[0];
		if (file) {
			const reader = new FileReader();
			
			reader.addEventListener("load", function () {
				//console.log(this);
				previewDefaultTxt.style.display = "none";
				previewImg.setAttribute("src", this.result);
				previewImg.style.display = "block";
				cropper = new Cropper(previewImg, {
						viewMode: 1,
						aspectRatio: 1,
						initialAspectRatio: 1
					});
				});
			reader.readAsDataURL(file);	
		}
	});	

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices
		.getUserMedia({ video: true })
		.then(function (stream) {
		previewDefaultTxtCam.style.display = "none";
		video.style.display = "block";
		video.srcObject = stream;
		})
		.catch(function (error) {
			console.log("Looks like your device has no camera.");
			$('#errorHeadshotWrapper').empty();
			$('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
													<button type="button" class="close" data-dismiss="alert">&times;</button> \
													Looks like your device has no camera. \
												</div>');
		});
	}

	function takepicture(height,width) {
		var context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
			data = canvas.toDataURL('image/png');
			previewDefaultTxt.style.display = "none";
			previewImg.style.display = "block";
			previewImg.setAttribute('src', data);
			cropper = new Cropper(previewImg, {
						viewMode: 1,
						aspectRatio: 1,
						initialAspectRatio: 1
					});
			//console.log(data);
		} 
	}

	$(".btn-details-cptr").click(function (e) {
		e.preventDefault();
		console.log('capturing...');
		$(".upload-div").show();
		$(".file-edit-btns").show();
		//console.log(video.offsetHeight,video.offsetWidth);
		takepicture(video.offsetHeight,video.offsetWidth);
		$(".capture-div").hide();
	});

	$('#rotate-anticlock').on('click', function(){
		console.log('rotate anticlock');
		if(cropper){			
			cropper.rotate(-90);
		}
	});

	$('#rotate-clock').on('click', function(){
		console.log('rotate clock');
		if(cropper){
			cropper.rotate(90);
		}
	});

	$('#saveHeadshot').on('click', function(){
		console.log('uploading...');
		if(cropper){
			canvas = cropper.getCroppedCanvas({
				width:400,
				height:400
			});
			canvas.toBlob(function(blob){
				URL.createObjectURL(blob);
				var reader = new FileReader();
				reader.readAsDataURL(blob);
				reader.onloadend = function(){
					var base64data = reader.result;
					//console.log(base64data);
					$.ajax({
						url: SCI_HEADSHOT.request_url,
						method:'POST',
						data:{
							headshot: base64data,
							nonce: SCI_HEADSHOT.nonce,
							action:'sci_add_headshot',
							index: indexHeadshot
						},
						success:function(response, status, xhr)
						{
							res = JSON.parse(response);
							console.log(response, status, xhr.status);
							cropper.destroy();
							cropper = null;

							if(xhr.status == 200){
								$('#errorHeadshotWrapper').empty();
								$('#errorHeadshotWrapper').prepend('<div class="alert alert-success alert-dismissible"> \
																			<button type="button" class="close" data-dismiss="alert">&times;</button> \
																			'+ res.data +'. \
																		</div>');
							}else{
								$('#errorHeadshotWrapper').empty();
								$('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
																			<button type="button" class="close" data-dismiss="alert">&times;</button> \
																			'+ res.data +'. \
																		</div>');
							}
						},
						error :function(xhr,status,error){
							console.log(xhr,status,error);
						}
					});
				};
			});
		}else{
			console.log('please capture or upload a headshot');
			$('#errorHeadshotWrapper').empty();
			$('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
														<button type="button" class="close" data-dismiss="alert">&times;</button> \
														Please capture or upload a headshot. \
													</div>');
		}	
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
})