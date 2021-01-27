<?php
/* Template Name: Add Headshot Page */

include('page_ids.php'); 
include('acf_field_ids.php'); 

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();
$upload_id = NULL;

$headshot_er = $headshot_er_msg = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])){

		if($_POST['submit'] == 'upload'){

			if(empty($_FILES['headshot'])){
				$headshot_er = true;
				$headshot_er_msg = 'Please upload a headshot image';
			}else{

				// delete previous old headshot
				$user_headshot_old = get_user_meta( $user_id, 'sci_user_headshot_1', true);
				if(($user_headshot_old !== false)){ 
					wp_delete_attachment(intval($user_headshot_old), true);
					delete_user_meta( $user_id, 'sci_user_headshot_1');
				}

				$wordpress_upload_dir = wp_upload_dir();
				$i = 1; // number of tries when the file with the same name is already exists

				$headshot = $_FILES['headshot'];
				$timestamp = time();

				$new_file_path = $wordpress_upload_dir['path'] . '/' .$user_id.'_'.$headshot['name'];
				$new_file_mime = mime_content_type( $headshot['tmp_name'] );

				if($headshot['error']){
					$headshot_er = true;
					$headshot_er_msg = $headshot['error'];
				}

				if($headshot['size'] > wp_max_upload_size()){
					$headshot_er = true;
					$headshot_er_msg = 'File too large';
				}

				if(!$headshot_er){

					while( file_exists( $new_file_path ) ) {
						$i++;
						$new_file_path = $wordpress_upload_dir['path'] . '/'.$i.'_'.$user_id.'_'.$headshot['name'];
					}
		
					if( move_uploaded_file( $headshot['tmp_name'], $new_file_path ) ) {
		
						$upload_id = wp_insert_attachment( array(
							'guid'           => $new_file_path, 
							'post_mime_type' => $new_file_mime,
							'post_title'     => preg_replace( '/\.[^.]+$/', '', $user_id.'_'.$headshot['name']),
							'post_content'   => '',
							'post_status'    => 'inherit'
						), $new_file_path );
					
						// wp_generate_attachment_metadata() won't work if you do not include this file
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
					
						// Generate and save the attachment metas into the database
						wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );		
					
					}
		
					if((!is_wp_error($upload_id)) || ($upload_id !== 0)){

						$success_headshot_1 = update_user_meta( $user_id, 'sci_user_headshot_1', $upload_id);
						
						
					}

					// Show the uploaded file in browser
					//wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
				}

			}
		}else if($_POST['submit'] == 'save'){
			wp_redirect( get_page_link( $complete_page )); exit;
		}else{
		}
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

				<p>
					Make sure you're looking straight on, use good lighting & a plain
					background, skip the filter, effects, hats & sunsine.
				</p>

				<div class="disp-cam">	

					<video autoplay="true" id="videoElement"></video>

					<div class="d-flex justify-content-center py-3">
					<button class="btn btn-lg btn-details-cptr px-md-5 btn-xs">
					Capture
					</button>
					</div>

					<?php 
					$user_headshot = get_user_meta( $user_id, 'sci_user_headshot_1', true);
					$user_headshot_disp =  wp_get_attachment_image( intval($user_headshot), 
					'medium', 
					"", 
					array( "class" => "img-responsive", "id" => "headshot_display"));
					if(($user_headshot !== false) && (!empty($user_headshot_disp))){ 
						echo $user_headshot_disp;
					}
						
					?>

				</div>

				<!-- <div id="cropped_result"></div>         -->
				<!-- <button id="crop_button">Crop</button>  -->
				
				<hr />

				<form action="" method="POST" enctype="multipart/form-data" >
					<div class="form-group">
		
						<label for="upload-hs">Upload Headshot!</label>				
						<input
							type="file"
							class="form-control my-1 <?php echo ($headshot_er) ? "is-invalid" : ""; ?>"
							id="upload-hs"
							aria-describedby="uploadHelp"
							accept="image/*"
							name="headshot"
							onchange="loadHeadShotFile(event)"
						/>
							
						<small id="uploadHelp" class="form-text text-muted">
							File size limited to 10MB
						</small>
						<div class="invalid-feedback"><?php echo $headshot_er_msg; ?></div>
					</div>

					<div class="d-flex justify-content-center">
						<button
						type="submit"
						name="submit"
						value="upload"
						class="btn btn-lg btn-details-uphs px-md-5 btn-xs mx-auto"
						>
						Upload
						</button>
					</div>
					
					<div class="d-flex justify-content-between py-3">
						<a 
						class="btn btn-lg btn-details-bck btn-xs px-md-5" 
						href="<?php echo get_page_link($physical_attributes_page); ?>"
						>
						Back
						</a>
					
						<button 
							type="submit"
							name="submit"
							value="save"
							class="btn btn-lg btn-details-nxt btn-xs px-md-5"
						>
						Save
						</button>
					</div>		
				</form>
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
	var video = document.querySelector("#videoElement");

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices
		.getUserMedia({ video: true })
		.then(function (stream) {
			video.srcObject = stream;
		})
		.catch(function (err0r) {
			console.log("Something went wrong!");
		});
	}


	//import 'cropperjs/dist/cropper.css';
	//import Cropper from 'cropperjs';

	const image = document.getElementById('headshot_display');
	const cropper = new Cropper(image, {
	viewMode : 2,
	aspectRatio: 1 / 1,
	background : false,
	crop(event) {
		// console.log(event.detail.x);
		// console.log(event.detail.y);
		// console.log(event.detail.width);
		// console.log(event.detail.height);
		// console.log(event.detail.rotate);
		// console.log(event.detail.scaleX);
		// console.log(event.detail.scaleY);
	},
	});

	// document.getElementById('crop_button').addEventListener('click', function(){
	// var imgurl =  cropper.getCroppedCanvas().toDataURL();
	// var img = document.createElement("img");
	// img.src = imgurl;
	// document.getElementById("cropped_result").appendChild(img);
	// });

</script>
