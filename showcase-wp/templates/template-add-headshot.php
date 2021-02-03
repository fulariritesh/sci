<?php
/* Template Name: Add Headshot Page */

include('page_ids.php'); 
include('acf_field_ids.php'); 

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();
$upload_id = NULL;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['headshot'])){

		// delete previous old headshot
		$user_headshot_old = get_user_meta( $user_id, 'sci_user_headshot', true);
		if(($user_headshot_old !== false)){ 
			wp_delete_attachment(intval($user_headshot_old), true);
			delete_user_meta( $user_id, 'sci_user_headshot');
		}
	
		$data = $_POST['headshot'];
		$image_array_1 = explode(";", $data);
		$image_array_2 = explode(",", $image_array_1[1]);
		$data = base64_decode($image_array_2[1]);
		$wordpress_upload_dir = wp_upload_dir();
		$new_file_path = $wordpress_upload_dir['path'] . '/' .$user_id.'_'.time().'.png';

		if( file_put_contents($new_file_path , $data ) ) {

			$upload_id = wp_insert_attachment( array(
				'guid'           => $new_file_path, 
				'post_mime_type' => 'image/png',
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $user_id.'_'.time().'.png'),
				'post_content'   => '',
				'post_status'    => 'inherit'
			), $new_file_path );
		
			// wp_generate_attachment_metadata() won't work if you do not include this file
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		
			// Generate and save the attachment metas into the database
			wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );	
		}

		if((!is_wp_error($upload_id)) || ($upload_id !== 0)){
			$success_headshot_1 = update_user_meta( $user_id, 'sci_user_headshot', $upload_id);
			
			http_response_code(200);
			echo json_encode(array('data' => $upload_id ));
			exit();		
		}

		http_response_code(500);
		echo json_encode(array('data' => 'Something went wrong.'));
		exit();		
		
	}else{
		http_response_code(400);
		echo json_encode(array('data' => 'Upload Error.'));
		exit();
	}
}


get_header();

include('join-pagination.php');

?>

<section class="pr-details container-fluid py-5">
	<div class="row">
		<div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0 mx-auto">			
			<div class="card-header">Add a Headshot</div>
			
			<div class="card-body px-4">

				<!-- capture-div info -->
				<div class="capture-div">
					<!-- Info div -->
					<ul class="text-muted">
					<li class="pb-2">Pay attention to framing, lighting, and background in your headshot. This
						is your first impression!</li>
					<li class="pb-2">Go easy with the makeup and try to use natural light.</li>
					<li class="pb-2">Skip the sunglasses, hats, filters and special effects. This is business!</li>
					</ul>
				</div>

				<!-- upload-div info -->
				<div class="upload-div">
					<p>
					Crop headshot
					</p>
					<p class="text-muted">Click and drag the crop box to move and resize your headshot the way you'd like it to
					appear on your profile.
					</p>
				</div>

				<!-- Img preview -->
				<div class="img-preview">
					<video autoplay="true" id="videoElement"></video>
					<canvas id="canvas" class="d-none"></canvas>
					<img src="" alt="img-preview" class="img-preview-img">
					<span class="img-preview-default-txt">Image preview!</span>
				</div>

				<!-- capture btn -->
				<div class="capture-div">
					<button class="btn btn-block btn-details-cptr btn-xs py-3" href=""><i class="fas fa-camera"></i> 
					Capture from Camera
					</button>
					<button class="btn btn-block btn-details-fileup btn-xs py-3"><i class="fas fa-upload"></i>
					Upload from device
					</button>
				</div>

				<!-- upload btn  -->
				<div class="upload-div">
					<label class="btn btn-custom-file-upload d-flex justify-content-center">
					<input type="file" name="hsFile" id="hsFile" />
					Choose file to upload
					</label>
				</div>

				<!-- file-edit-btns -->
				<div class="file-edit-btns">
					<div class="d-flex justify-content-center py-4">			
					<button id="rotate-anticlock" class="btn btn-details-uphs btn-xs mx-2 px-4">
						<i class="fas fa-undo"></i>
					</button>
					<button id="rotate-clock" class="btn btn-details-uphs btn-xs mx-2 px-4">
						<i class="fas fa-undo fa-flip-horizontal"></i>
					</button>
					</div>
				</div>

				<!-- preview uploaded image -->
				<div>
					<div class="d-flex align-items-center justify-content-center py-4">

					
					<?php 
						$user_headshot = get_user_meta( $user_id, 'sci_user_headshot', true);
						$user_headshot_disp =  wp_get_attachment_image( intval($user_headshot), 
						'thumbnail', 
						"", 
						array( "class" => "img-thumbnail", "id" => "headshot_display"));
						if(($user_headshot !== false) && (!empty($user_headshot_disp))){ 
							echo '<p class="text-muted px-2">uploaded headshot</p>';
							echo $user_headshot_disp;
						}
					?>
					</div>	
				</div>

				<!-- error message -->
				<div id="errorHeadshotWrapper">
				</div>

				<!-- back-save-btns -->
				<div class="d-flex justify-content-between pt-5 pb-3">				
					<a 
					class="btn btn-lg btn-details-bck btn-xs px-md-5"
					href="<?php echo get_page_link($physical_attributes_page); ?>">
					Back
					</a>
					<button 
					id="saveHeadshot" 
					class="btn btn-lg btn-details-nxt btn-xs px-md-5">
					Save
					</button>
				</div>

        	</div>
		</div>
	</div>
</section>



<?php
get_sidebar();
get_footer();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous"></script>

<script>
    jQuery(document).ready(function () {
		jQuery(".upload-div").hide();
		jQuery(".file-edit-btns").hide();

		var cropper;
		var data;
		var canvas = document.querySelector("#canvas");
		var video = document.querySelector("#videoElement");
		const inpFile = document.getElementById("hsFile");
		const previewContainer = document.getElementById("img-preview");
		const previewImg = document.querySelector(".img-preview-img");
		const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
		const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

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
			.catch(function (err0r) {
			
				console.log("Looks like your device has no camera.");
				jQuery('#errorHeadshotWrapper').empty();
				jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															Looks like your device has no camera. \
														</div>');
			});
		}

		

		jQuery(".btn-details-fileup").click(function () {
			jQuery(".capture-div").hide();
			jQuery(".upload-div").show();
			jQuery(".file-edit-btns").show();
		});

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

		jQuery(".btn-details-cptr").click(function (e) {
			e.preventDefault();
			console.log('capturing...');
			jQuery(".upload-div").show();
			jQuery(".file-edit-btns").show();
			//console.log(video.offsetHeight,video.offsetWidth);
			takepicture(video.offsetHeight,video.offsetWidth);
			jQuery(".capture-div").hide();
		});
	  

	  	jQuery('#saveHeadshot').on('click', function(){
			console.log('uploading...');
			if(cropper){
				canvas = cropper.getCroppedCanvas({
					width:400,
					height:400
				});
				canvas.toBlob(function(blob){
					url = URL.createObjectURL(blob);
					var reader = new FileReader();
					reader.readAsDataURL(blob);
					reader.onloadend = function(){
						var base64data = reader.result;
						//console.log(base64data);
						jQuery.ajax({
							url:'<?php echo get_page_link($add_headshot_page); ?>',
							method:'POST',
							data:{headshot:base64data},
							success:function(response, status, xhr)
							{
								res = JSON.parse(response);
								console.log(res, status, xhr.status);
								cropper.destroy();
								cropper = null;

								if(xhr.status == 200){
									window.location.href = '<?php echo get_page_link($complete_page); ?>';
								}else{
									jQuery('#errorHeadshotWrapper').empty();
									jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
																				<button type="button" class="close" data-dismiss="alert">&times;</button> \
																				'+ res.data +'. \
																			</div>');
								}
							}
						});
					};
				});
			}else{
				console.log('please capture or upload a headshot');
				jQuery('#errorHeadshotWrapper').empty();
				jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															Please capture or upload a headshot. \
														</div>');
			}	
		});

		jQuery('#rotate-anticlock').on('click', function(){
			console.log('rotate anticlock');
			if(cropper){			
				cropper.rotate(-90);
			}
		});

		jQuery('#rotate-clock').on('click', function(){
			console.log('rotate clock');
			if(cropper){
				cropper.rotate(90);
			}
		});

    });
</script>
