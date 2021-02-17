<?php
/* Template Name: Add Headshot Page */

if (!is_user_logged_in() ) {
	wp_redirect(get_page_link(get_page_by_path('login'))); exit;
}

get_header();
$user_id = get_current_user_id();

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
						$user_headshots = get_field('sci_user_headshots', 'user_' . $user_id);
						if($user_headshots){ 
							$user_headshot_1 = $user_headshots[0]["sci_user_headshot"]["sizes"]["thumbnail"];	
							echo '<p class="text-muted px-2">uploaded headshot</p>';
							echo '<img src="'.$user_headshot_1.'" class="img-thumbnail" />';
						}
					?>
					</div>	
				</div>

				<!-- response message -->
				<div id="resHeadshotWrapper"></div>
				<script>
				function headshotSuccess(){
					console.log('Goto Complete');
					window.location.href = "<?php echo get_page_link(get_page_by_path('complete')); ?>";
				}
				</script> 

				<!-- back-save-btns -->
				<div class="d-flex justify-content-between pt-5 pb-3">				
					<a 
					class="btn btn-lg btn-details-bck btn-xs px-md-5"
					href="<?php echo get_page_link(get_page_by_path('physical-attributes')); ?>">
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