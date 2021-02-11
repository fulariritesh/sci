import Splide from '@splidejs/splide';
import Lightbox from 'lightbox2';
import Cropper from 'cropperjs'; //sid

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
		let $experienceBlock = $('#experienceblock');
		if($experienceBlock){
			let $drpExperienceBlockToggle = $('#year-category-toggle');
			let $experienceBlockCategory = $('#experienceblock-category');
			let $experienceBlockYear = $('#experienceblock-year');
			
			$experienceBlockYear.hide();
			$drpExperienceBlockToggle.on('change', function(e) {
				let toggleValue = this.options[e.target.selectedIndex].value;
				if(toggleValue === 'category'){
					$experienceBlockYear.hide();
					$experienceBlockCategory.show();
				}else{
					$experienceBlockCategory.hide();
					$experienceBlockYear.show();
				}
			});
		}
		

		$('.btn-add-experience').on('click', function(e){
			e.preventDefault();
			// $(this).addClass('disabled');
			// let loading = document.createElement("div");
			// loading.classList.add("editableform-loading");
			// $(this).parent().addClass("loading")
			// $(this).parent()[0].appendChild(loading);
			
			let id = $(this).data('id');
			$.post({
			    url: Edit.request_url,
			    data: {
			        action: 'sci_experience_form',
					nonce: Edit.nonce,
					catid: id,
			    },
			    success : function(res){
					$('#experience-modal-content').html(res);
					$('#catdetailed').modal('show');
					// $(this).removeClass('disabled');
					// $(this).parent().removeClass("loading")
					// $(this).parent()[0].children().last().remove();
					//$('.other-selected').hide();
			    }
			})

		});

		

		$("#catdetailed").on('click','.other-fields', function() {
			if($(this).closest('.btn-group-toggle').data('type') == 'checkbox'){
				if($(this).val() == 'Others' && !$(this).parent().hasClass('active')){
					$(this).closest('.form-additional-fields').find('.other-selected').show();
				}else if($(this).val() == 'Others' && $(this).parent().hasClass('active')){
					$(this).closest('.form-additional-fields').find('.other-selected').hide();
				}
			}
		});

		let deletedExperiences = [];
		$("#catdetailed").on("click", ".delete-experience", function(event){
			event.stopPropagation();
			event.preventDefault();
			if($(this).closest('li').data('row')){
				deletedExperiences.push($(this).closest('li').data('row'));
			}

				let ul = $(this).closest('ul.list');
				let group = $(this).closest('.new-experience-group');
				$(this).closest('li').remove();
				if(ul.children().length <=0){
					group.remove();
				}
		});


		$("#catdetailed").on("click", "#experience-submit", function(event){
			event.preventDefault();

			$("#form-experience .btn-popup-save").addClass('disabled');
			let loading = document.createElement("div");
			loading.classList.add("editableform-loading");
			$("#form-experience .btn-popup-save").parent().addClass("loading")
			$("#form-experience .btn-popup-save").parent()[0].appendChild(loading);

			let $categoryModal = $(this).closest("#catdetailed");

						
			let catId = $categoryModal.find(".modal-header").data('id').toString();

			let subCatsIds = [];
			$categoryModal.find("#experience-specialized-skills").find(".btn-popup-pill.active").map(function(i, e){
				subCatsIds.push($(e).find('input').val());
			});

			let extraFields = $(this).closest("#catdetailed").find(".form-additional-fields");
			let fields = [];
			extraFields.map(function(i, e){
				let field = $();
				field.efType = $(this).find('.btn-group-toggle').data('type');
				field.efFieldName =  $(this).data('name');
				field.efOptions = []
				$(this).find(".btn-popup-pill.active").map(function(i, e){
					field.efOptions.push($(e).find('input').val().replace(/-/g, " "));
				});
				fields.push(field);
			});



			let fieldOthers = $(this).closest("#catdetailed").find('input[data-other$="-other"]');
			let otherFields = [];
			fieldOthers.map(function(i, e){
				let field = $();
				field.efFieldName = $(this).data('other');
				field.efValue = $(this).val();
				
				otherFields.push(field);
			});
			console.log(otherFields);

			let experienceWebsite = $('#experience-website').val();



			/////experiences
			let yearGroup = $(this).closest("#catdetailed").find('div[id^="year"]');
			let experienceDetails = [];
			yearGroup.map(function(i, e){
				
				let thisYear = $(this).find('ul.list').data('year');
				
				$(this).find('ul.list').children().map(function(i, e){
					let experience = $();
					experience.year = thisYear;
					experience.rowNumber = $(this).data('row')?$(this).data('row'):'-1';
					experience.content = $(this).find('span').text();

					experienceDetails.push(experience);
				});
				
			});
			/////experiences



			let dataStringified = JSON.stringify({subCats : subCatsIds, additionalFields : fields, website : experienceWebsite, fieldOtherSpecifications : otherFields, experiences : experienceDetails, deleted : deletedExperiences });
			console.log(dataStringified);
			$.post({
			    url: Edit.request_url,
			    data: {
			        action: 'sci_experience_form_submit',
					nonce: Edit.nonce,
					category : catId, 
			        updateData: dataStringified,
			    },
			    success : function(res){
					//console.log(JSON.parse(res));
			    	location.reload();
			    }
			})
		});

		

		$("#catdetailed").on("click", "#add-experience", function(event){
			event.stopPropagation();
			event.preventDefault();
			
			
			let year = $("#ExpYr").val();
			let content = $("#experience-content").val();

			if(year != '' && content !=''){
				$(this).prop('disabled', true);
				let cardBody = $('#year'+year);
				if(cardBody.length > 0){
					cardBody.find('ul[data-year='+year+']').append(`<li data-new="true" style="display: flex;padding-bottom: 5px;"><span contenteditable="true">${content}</span><div class="d-flex justify-content-end" style="flex: auto;">
					<button class="btn btn-popup-del delete-experience" type="button" data-toggle="modal" data-target="#deleteExp">
					<i class="fas fa-trash-alt fa-lg"></i>
					</button>
				</div></li>`);
				}else{
					let newGroup = `<div class="accordion-group mb-3 card new-experience-group">
					<div class="row card-header collapsed p-2" id="row${year}" type="button" data-toggle="collapse" data-target='#year${year}' aria-expanded="true" aria-controls="row${year}">
					   <div class="col-11">
						  <p class="text-uppercase my-2 pt-1 ml-2">Year <span>(${year})</span>
						  </p>
					   </div>
					</div>
					<div id="year${year}" class="collapse" aria-labelledby="year${year}">
					   <div class="accordion-inner card-body">
						  <ul class="list" data-year=${year}>
								<li data-new="true" style="display: flex;padding-bottom: 5px;"><span contenteditable="true">${content}</span>
								<div class="d-flex justify-content-end" style="flex: auto;">
									<button class="btn btn-popup-del delete-experience" type="button" data-toggle="modal" data-target="#deleteExp">
									<i class="fas fa-trash-alt fa-lg"></i>
									</button>
								</div></li>
						  </ul>
					   </div>
					</div>
				 </div>`;
	
				 $('#experience-accordion').append($(newGroup));
				}
				
				$("#ExpYr").val('');
				$("#experience-content").val('');
				$(this).prop('disabled', false);	
			}
			
		});
	}
});

// $(".card-header").click(function () {
// 	$(this).toggleClass("selected");
// });
// var video = document.querySelector("#videoElement");
// const inpFile = document.getElementById("hsFile");
// const previewContainer = document.getElementById("img-preview");
// const previewImg = document.querySelector(".img-preview-img");
// const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
// const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

// if (inpFile) inpFile.addEventListener("change", function () {
//   const file = this.files[0];
//   if (file) {
//     const reader = new FileReader();
//     previewDefaultTxt.style.display = "none";
//     previewImg.style.display = "block";

//     reader.addEventListener("load", function () {
//       console.log(this);
//       previewImg.setAttribute("src", this.result);
//     });
//     reader.readAsDataURL(file);
//   }
// })

// if (navigator.mediaDevices) {
//   navigator.mediaDevices
//     .getUserMedia({ video: true })
//     .then(function (stream) {
//       previewDefaultTxtCam.style.display = "none";
//       video.style.display = "block";
//       video.srcObject = stream;
//     })
//     .catch(function (err0r) {
//       console.log("Something went wrong!");
//     });
// }
// $(document).ready(function () {
// 	$(".upload-div").hide();
// 	$(".file-edit-btns").hide();
// 	$(".btn-details-fileup").click(function () {
// 		$(".capture-div").hide();
// 		$(".upload-div").show();
// 		$(".file-edit-btns").show();
// 	});
// });

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
});

//sid
$(document).ready(function () {
	/* Category Subcategory Page */
	$(".card-header").click(function () {
		$(this).toggleClass("selected");
		$(this).children('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
  	});

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
});

// sid
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
	var redirectFunction = '';
	var indexHeadshot = 1;
	var canvas = document.querySelector("#canvas");
	var video = document.querySelector("#videoElement");
	const inpFile = document.getElementById("hsFile");
	const previewContainer = document.getElementById("img-preview");
	const previewImg = document.querySelector(".img-preview-img");
	const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
	const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

	// $('li.splide__slide').click(function () {
	// 	var index = $(this).attr("data-index");
	// 	if(index){
	// 		indexHeadshot = index;
	// 		console.log('Headshot: '+indexHeadshot);
	// 	}	
	// });
	$(".manageHeadshot").find("button").click(function(){
		var index = $(this).attr("data-indexheadshot");
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
			$('#resHeadshotWrapper').empty();
			$('#resHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
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

	// ADD/EDIT HEADSHOT
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
							//console.log(response, status, xhr.status);
							cropper.destroy();
							cropper = null;

							if(res.status === 'success'){
								redirectFunction = 'onclick="headshotSuccess()"';
							}
							$('#resHeadshotWrapper').empty();
							$('#resHeadshotWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
																		<button '+ redirectFunction +' type="button" class="close" data-dismiss="alert">&times;</button> \
																		'+ res.msg +'. \
																	</div>');						
						}
					});
				};
			});
		}else{
			console.log('please capture or upload a headshot');
			$('#resHeadshotWrapper').empty();
			$('#resHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
														<button type="button" class="close" data-dismiss="alert">&times;</button> \
														Please capture or upload a headshot. \
													</div>');
		}	
	});

	// DELETE HEADSHOT
	$('#deleteheadshotsave_submit').click(function () {
		var res;
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				index: indexHeadshot,
				nonce: Edit.nonce,
				action:'sci_delete_headshot',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#resdeleteheadshotWrapper').empty();
				$('#resdeleteheadshotWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}	
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});

});

//sid
/* User Videos */
$(document).ready(function () {

	var indexVideo = 1;
	$(".manageVideo").find("button").click(function(){
		var index = $(this).attr("data-indexvideo");
		var res;
		if(index){
			indexVideo = index;
			console.log('Video: '+indexVideo);
		}
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				index: indexVideo,
				nonce: Edit.nonce,
				action:'sci_get_video',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#editvideolink_input').val(res.video)
				$('#editvideocaption_input').val(res.caption);					
			}
		});
	});
	  
	// ADD VIDEO
	$('#addvideosave_submit').click(function () {
		var res;
		var video = $('#addvideolink_input').val();
		var caption = $('#addvideocaption_input').val();
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				video: video,
				caption: caption,
				nonce: Edit.nonce,
				action:'sci_add_video',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#resaddvideoWrapper').empty();
				$('#resaddvideoWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}								
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});

	// EDIT VIDEO
	$('#editvideosave_submit').click(function () {
		var res;
		var video = $('#editvideolink_input').val();
		var caption = $('#editvideocaption_input').val();
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				video: video,
				caption: caption,
				index: indexVideo,
				nonce: Edit.nonce,
				action:'sci_edit_video',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#reseditvideoWrapper').empty();
				$('#reseditvideoWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}	
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});

	// DELETE VIDEO
	$('#deletevideosave_submit').click(function () {
		var res;
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				index: indexVideo,
				nonce: Edit.nonce,
				action:'sci_delete_video',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#resdeletevideoWrapper').empty();
				$('#resdeletevideoWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}	
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});
});

//sid
/* User Audios */
$(document).ready(function () {

	var indexAudio = 1;
	$(".manageAudio").find("button").click(function(){
		var index = $(this).attr("data-indexaudio");
		var res;
		if(index){
			indexAudio = index;
			console.log('Audio: '+indexAudio);
		}
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				index: indexAudio,
				nonce: Edit.nonce,
				action:'sci_get_audio',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#editaudiotitle_input').val(res.title);					
				$('#editaudiodescription_input').val(res.description)
			}
		});
	});
	  
	// ADD AUDIO
	$('#addaudiosave_submit').click(function () {
		var res;
		// var fd = new FormData(); 
        // var files = $('#addaudiofile_input')[0].files[0]; 
		// fd.append('file', files);
		// fd.append('nonce')
		const file = $('#addaudiofile_input')[0].files[0];
		var audio_src;
		if (file) {
			const reader = new FileReader();
			reader.addEventListener("load", function () {
				audio_src = this.result;
				//console.log(audio_src);
				$.ajax({
					url: Edit.request_url,
					method:'POST',
					data:{
						audio: audio_src,
						nonce: Edit.nonce,
						action:'sci_add_audio',
					},
					success: function(response, status, xhr){
						res = JSON.parse(response);
						$('#resaddaudioWrapper').empty();
						$('#resaddaudioWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
																	<button type="button" class="close" data-dismiss="alert">&times;</button> \
																	'+ res.msg +'. \
																</div>');
						if(res.status === 'success'){
							window.location.reload();
						}								
					},
					error :function(xhr,status,error){
						console.log(xhr,status,error);
					},
				});
			});
			reader.readAsDataURL(file);	
		}				
	});

	// EDIT AUDIO
	$('#editaudiosave_submit').click(function () {
		var res;
		var title = $('#editaudiotitle_input').val();
		var description = $('#editaudiodescription_input').val();
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				title: title,
				description: description,
				index: indexAudio,
				nonce: Edit.nonce,
				action:'sci_edit_audio',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#reseditaudioWrapper').empty();
				$('#reseditaudioWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}	
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});

	// DELETE AUDIO
	$('#deleteaudiosave_submit').click(function () {
		var res;
		$.ajax({
			url: Edit.request_url,
			method:'POST',
			data:{
				index: indexAudio,
				nonce: Edit.nonce,
				action:'sci_delete_audio',
			},
			success: function(response, status, xhr){
				res = JSON.parse(response);
				$('#resdeleteaudioWrapper').empty();
				$('#resdeleteaudioWrapper').prepend('<div class="alert alert-'+res.status+' alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+ res.msg +'. \
														</div>');
				if(res.status === 'success'){
					window.location.reload();
				}	
			},
			error :function(xhr,status,error){
				console.log(xhr,status,error);
			},
		});
	});
});