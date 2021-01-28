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
					wp_redirect( get_page_link( $complete_page )); exit;		
				}

				// Show the uploaded file in browser
				//wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
			}

		}
		
	}
}


get_header();

include('join-pagination.php');

?>



<section class="pr-details container-fluid py-5">
	<div class="row">
		<div
			class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0 mx-auto"
		>
			<div class="card-header">Add a Headshot!</div>

			<div class="card-body px-4">
					<form action="" method="POST" enctype="multipart/form-data" >

					<!-- capture-div -->
					<div class="capture-div">
						<p>
						Make sure you're looking straight on, use good lighting & a plain
						background, skip the filter, effects, hats & sunshine.
						</p>
						<div class="img-preview">
							<video autoplay="true" id="videoElement"></video>
							<span class="img-preview-default-txtCam">Image preview!</span>
						</div>
						<div class="d-flex justify-content-around pt-5 pb-3">
							<a class="btn btn-lg btn-details-cptr btn-xs px-md-5" href=""
								><i class="fas fa-camera"></i></a
							>
							<a class="btn btn-lg btn-details-fileup btn-xs"><i class="fas fa-upload"></i>
								Upload File
							</a>
						</div>
					</div>

					<!-- upload-div -->
					<div class="upload-div">
						<!-- Img-preview -->
						<div class="img-preview">
							<img src="" alt="img-preview" class="img-preview-img">
							<span class="img-preview-default-txt">Image preview!</span>
							
						</div>			
						<label class="btn btn-custom-file-upload d-flex justify-content-center">
							<input 
							type="file" 
							name="hsFile" 
							id="hsFile"
							class="form-control my-1 <?php echo ($headshot_er) ? "is-invalid" : ""; ?>"
							accept="image/*"
							/>
							Choose file to upload
						</label>
						<div class="invalid-feedback"><?php echo $headshot_er_msg; ?></div>
					</div>
			
					<!-- file-edit-btns -->
					<div class="file-edit-btns">
						<div class="d-flex justify-content-around py-4">
							<button class="btn btn-details-uphs btn-xs" href=""
								><i class="fas fa-crop-alt"></i></button
							>
							<button class="btn btn-details-uphs btn-xs">
								<i class="fas fa-undo"></i>
							</button>
							<button class="btn btn-details-uphs btn-xs">
								<i class="fas fa-undo fa-flip-horizontal"></i>
							</button>
						</div>
					</div>

					<div class="d-flex justify-content-between pt-5 pb-3">
						<a class="btn btn-lg btn-details-bck btn-xs px-md-5" 
						href="<?php echo get_page_link($physical_attributes_page); ?>"
						>Back</a
						>
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
      const inpFile =document.getElementById("hsFile");
      const previewContainer = document.getElementById("img-preview");
      const previewImg = document.querySelector(".img-preview-img");
      const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
      const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

      inpFile.addEventListener("change",function(){
        const file = this.files[0];
        if (file){
          const reader = new FileReader();
          previewDefaultTxt.style.display = "none";
          previewImg.style.display = "block";

          reader.addEventListener("load", function(){
            console.log(this);
            previewImg.setAttribute("src",this.result);
          });
          reader.readAsDataURL(file);
        }
      })

      if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices
          .getUserMedia({ video: true })
          .then(function (stream) {
            previewDefaultTxtCam.style.display = "none";
            video.style.display ="block";
            video.srcObject = stream;
          })
          .catch(function (err0r) {
            console.log("Something went wrong!");
          });
      }
</script>
<script>
	jQuery(document).ready(function(){
	jQuery(".upload-div").hide();
	jQuery(".file-edit-btns").hide();

	jQuery(".btn-details-fileup").click(function(){
	jQuery(".capture-div").hide();
	jQuery(".upload-div").show();
	jQuery(".file-edit-btns").show();
	});

	});
</script>
