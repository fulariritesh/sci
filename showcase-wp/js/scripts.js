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
	if (!!$('#edit-profile .profile-personaldetails').length) {
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
		$(".switch input[type='checkbox']").on("change", function(){
			var $this = $(this);
			clearInterval(window.jsTimeout);
			window.jsTimeout = setInterval(function(){
				$.post({
				    url: Edit.request_url,
				    data: {
				        id: 1,
				        action: 'sci_change_number',
				        nonce: Edit.nonce,
				        hide_number: !!$this.is(':checked')
				    },
				    success : function(res){
				    	console.log(res)
				    }
				})
				clearInterval(window.jsTimeout);
				delete window.jsTimeout;
			}, 1000)
		})
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
		$('#country').editable({
			url: Edit.request_url, 
			source: JSON.parse(Edit.locations),
			type: 'select',  
			send: "always",
		  	params: function(params) {  
				var data = {};
				data['location'] = params.value;
				data['action'] = 'sci_change_location';
				data['nonce'] = Edit.nonce;
				return data;
			}
		});
		$('#gender').editable({
			url: Edit.request_url, 
			source: JSON.parse(Edit.gender),
			type: 'select',  
			send: "always",
		  	params: function(params) {  
				var data = {};
				data['gender'] = params.value;
				data['action'] = 'sci_change_gender';
				data['nonce'] = Edit.nonce;
				return data;
			}
		});
		$('#editCat').on('show.bs.modal', function (e) {
			if (Edit.categories) JSON.parse(Edit.categories).map(function(item, index){
				let sci = document.querySelector("#editCat label[data-category='" + item + "']");
				sci.classList.add("active");
			})
		})
		$('#managephotos').on('show.bs.modal', function (e) {
			setTimeout(function(){
				$drag.layout();
			}, 200);
			$(".rotate-image").on('click', function(){
				$(this).parents(".packery-item").find("img").css({
				    transform: "rotate(-90deg)"
				})
			})
			$(".delete-image").on('click', function(){
				$(this).parents(".packery-item").remove();
				$drag.layout();
			})
		})
		$("#delete-photos").on("submit", function(){
			$(".bulkselect-radio input:checked").parents(".packery-item").remove();
			$drag.layout();
			$("#deletephoto").modal('hide');
		})
		$('#editcaption').on('show.bs.modal', function (e) {
			$(this).find('.caption-value').val($(e.relatedTarget).parents('[data-caption]').attr('data-caption'));
			$(this).find('.caption-value').attr("data-media-id", $(e.relatedTarget).parents('[data-media-id]').attr('data-media-id'));
		})
		$('#editcaption, #deletephoto').on('hidden.bs.modal', function(){
			$('body').addClass('modal-open');
		})
		$("#saveCaption").on("submit", function(event){
			event.preventDefault();
			$("[data-media-id='" + $(this).find('.caption-value').attr('data-media-id') + "']").attr('data-caption', $(this).find('.caption-value').val());
			$('#managephotos').modal('handleUpdate');
			$("#editcaption").modal("hide");
			$('#managephotos').modal("show");
		})
		$("#managephotos-form").on("submit", function(event){
			event.preventDefault();
			let order = [];

			jQuery('[data-order]').each(function(i, ele){
				let $item = jQuery('[data-order=' + (i + 1) + ']');
				console.log($item);
				console.log('[data-order=' + (i + 1) + ']');

                order.push({id : $item.attr("data-media-id"), caption :  $item.attr("data-caption")});
            })

			$("#managephotos-form .btn-popup-save").addClass('disabled');
			let loading = document.createElement("div");
			loading.classList.add("editableform-loading");
			$("#managephotos-form .btn-popup-save").parent().addClass("loading")
			$("#managephotos-form .btn-popup-save").parent()[0].appendChild(loading);

			$.post({
			    url: Edit.request_url,
			    data: {
			        action: 'sci_manage_photos',
			        nonce: Edit.nonce,
			        order: order
			    },
			    success : function(res){
			    	location.reload();
			    }
			})
		})
		$("#manage-category").on("submit", function(event){
			event.preventDefault();
			let categories = [];
			$("#editCat label[data-category].active").map(function(index, item){
				categories.push($(item).data('category'));
			})

			$("#manage-category .btn-popup-save").addClass('disabled');
			let loading = document.createElement("div");
			loading.classList.add("editableform-loading");
			$("#manage-category .btn-popup-save").parent().addClass("loading")
			$("#manage-category .btn-popup-save").parent()[0].appendChild(loading);

			$.post({
			    url: Edit.request_url,
			    data: {
			        id: 1,
			        action: 'sci_change_category',
			        nonce: Edit.nonce,
			        categories: JSON.stringify(categories)
			    },
			    success : function(res){
			    	location.reload();
			    }
			})
			/*$("#editCat").modal("hide");*/
		})
		$("#intro-form").on("submit", function(event){
			event.preventDefault();

			$("#intro-form .btn-popup-save").addClass('disabled');
			let loading = document.createElement("div");
			loading.classList.add("editableform-loading");
			$("#intro-form .btn-popup-save").parent().addClass("loading")
			$("#intro-form .btn-popup-save").parent()[0].appendChild(loading);
			$.post({
			    url: Edit.request_url,
			    data: {
			        action: 'sci_change_intro',
			        nonce: Edit.nonce,
			        camera: $("#intro-form input.form-control").val(),
			        text: $("#intro-form textarea.form-control").val(),
			    },
			    success : function(res){
			    	location.reload();
			    }
			})
		})
		$("#social-icons").on("submit", function(event){
			event.preventDefault();

			$("#social-icons .btn-popup-save").addClass('disabled');
			let loading = document.createElement("div");
			loading.classList.add("editableform-loading");
			$("#social-icons .btn-popup-save").parent().addClass("loading")
			$("#social-icons .btn-popup-save").parent()[0].appendChild(loading);
			$.post({
			    url: Edit.request_url,
			    data: {
			        action: 'sci_change_social',
			        nonce: Edit.nonce,
			        instagram: $("#social-icons input.instagram").val(),
			        facebook: $("#social-icons input.facebook").val(),
			        twitter: $("#social-icons input.twitter").val(),
			        youtube: $("#social-icons input.youtube").val(),
			    },
			    success : function(res){
			    	location.reload();
			    }
			})
		})
	}
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