<?php
/* Template Name: Physical Attributes Page */

include('page_ids.php'); 
include('acf_field_ids.php'); 

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();

$height_er = $weight_er = $eye_color_er = $skin_color_er = $chest_er = NULL;
$height = $weight = $eye_color = $skin_color = $chest = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])){

		if($_POST['submit'] == 'save'){
			$height = sanitize_text_field( $_POST['height']);
			$weight = sanitize_text_field( $_POST['weight']);
			$eye_color = sanitize_text_field( $_POST['eye_color']);
			$skin_color = sanitize_text_field( $_POST['skin_color']);
			$chest = sanitize_text_field( $_POST['chest']);

			echo $height;
			echo $weight;
			echo $eye_color;
			echo $skin_color;
			echo $chest;

			$success_height = update_user_meta( $user_id, 'sci_user_height', $height);
			$success_weight = update_user_meta( $user_id, 'sci_user_weight', $weight);
			$success_eye_color = update_user_meta( $user_id, 'sci_user_eye_color', $eye_color);
			$success_skin_color = update_user_meta( $user_id, 'sci_user_skin_color', $skin_color);
			$success_chest = update_user_meta( $user_id, 'sci_user_chest', $chest);

			if(!($height_er || $weight_er || $eye_color_er || $skin_color_er || $chest_er)){
				wp_redirect( get_page_link( $add_headshot_page )); exit;
			}

		}else{
			$deleted_height = update_user_meta( $user_id, 'sci_user_height');
			$deleted_weight = update_user_meta( $user_id, 'sci_user_weight');
			$deleted_eye_color = update_user_meta( $user_id, 'sci_user_eye_color');
			$deleted_skin_color = update_user_meta( $user_id, 'sci_user_skin_color');
			$deleted_chest = update_user_meta( $user_id, 'sci_user_chest');

			wp_redirect( get_page_link( $add_headshot_page )); exit;
		}		
	}
}

get_header();

include('join-pagination.php');

?>

<section class="pr-details d-flex justify-content-center py-5">
    <div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0">
    <div class="card-header">Physical-attributes</div>
		
        <div class="card-body px-4">
			<p>The more complete this is, the better the chance of being scouted by someone casting a specific look.</p>
			<form action="" method="POST" >
				<div class="form-group">
					<?php
						$height_f = get_field_object($height_field);
						$user_height= get_user_meta( $user_id, 'sci_user_height', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Height (cm): </label>
						<input class="disp-val" value="<?php echo ($user_height) ? $user_height : '' ?>" id="HeightInput" oninput="updateHeightInput(this.value);"></input>
					</div>
					<input name="height" value="<?php echo ($user_height) ? $user_height : '' ?>" type="range" id="HeightOutput" class="form-control-range slider" min="<?php echo $height_f['min']; ?>" max="<?php echo $height_f['max']; ?>" oninput="updateHeightInput(this.value);">
				</div>

				<div class="form-group">
					<?php
						$weight_f = get_field_object($weight_field);
						$user_weight= get_user_meta( $user_id, 'sci_user_weight', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Weight (kg): </label>
						<input class="disp-val" value="<?php echo ($user_weight) ? $user_weight : '' ?>" id="WeightInput" oninput="updateWeightInput(this.value);"></input>
					</div>
					<input name="weight" value="<?php echo ($user_weight) ? $user_weight : '' ?>" type="range" id="WeightOutput" class="form-control-range" min="<?php echo $weight_f['min']; ?>" max="<?php echo $weight_f['max']; ?>" oninput="updateWeightInput(this.value);">
				</div>

				<div class="form-group">
					<div>
						<label for="eye_color">Eye color:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php
							$eye_color_f = get_field_object($eye_color_field);
							$user_eye_color = get_user_meta( $user_id, 'sci_user_eye_color', true);
							foreach($eye_color_f['choices'] as $eye_color_value => $eye_color_label){	
								echo '<label class="btn btn-details-gen">';	
								echo '<input type="radio" name="eye_color" value="'.$eye_color_value.'" '.(($user_eye_color == $eye_color_value ) ? "checked":"").' />'.$eye_color_label.'</label>';		
							}
						?>				
					</div>
				</div>

				<div class="form-group">
					<div>
						<label for="skin_color">Skin color:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php
							$skin_color_f = get_field_object($skin_color_field);
							$user_skin_color = get_user_meta( $user_id, 'sci_user_skin_color', true);
							foreach($skin_color_f['choices'] as $skin_color_value => $skin_color_label){	
								echo '<label class="btn btn-details-gen">';	
								echo '<input type="radio" name="skin_color" value="'.$skin_color_value.'" '.(($user_skin_color == $skin_color_value ) ? "checked":"").' />'.$skin_color_label.'</label>';		
							}
						?>
					</div>
				</div>

				<div class="form-group">
					<?php
						$chest_f = get_field_object($chest_field);
						$user_chest= get_user_meta( $user_id, 'sci_user_chest', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Chest (cm): </label>
						<input class="disp-val" value="<?php echo ($user_chest) ? $user_chest : '' ?>" id="ChestInput" oninput="updateChestInput(this.value);"></input>
					</div>
					<input name="chest" value="<?php echo ($user_chest) ? $user_chest : '' ?>" type="range" id="ChestOutput" class="form-control-range" min="<?php echo $chest_f['min']; ?>" max="<?php echo $chest_f['max']; ?>" oninput="updateChestInput(this.value);">
				</div>

				<div class="d-flex justify-content-between py-3">
				<a href="<?php echo get_page_link($profile_details_page); ?>" class="btn btn-lg btn-details-bck btn-xs px-md-5">Back</a>
				<button type="submit" name="submit" value="save" class="btn btn-lg btn-details-nxt float-right btn-xs px-md-5">Next</button>
				</div>
				<div class="d-flex justify-content-center">
				<button type="submit" name="submit" value="skip" class="btn btn-pa-skp btn-xs">Skip for now</button>
				</div>
			</form>
        </div>
      
	</div>
</section>






<?php


get_sidebar();
get_footer();

?>
<script>
    function updateHeightInput(heightVal){
    var hv = heightVal;
    document.getElementById("HeightOutput").value = hv;
    document.getElementById("HeightInput").value = hv;
    }
    function updateWeightInput(weightVal){
    var wv = weightVal;
    document.getElementById("WeightOutput").value = wv;
    document.getElementById("WeightInput").value = wv;
    }
    function updateChestInput(chestVal){
    var cv = chestVal;
    document.getElementById("ChestOutput").value = cv;
    document.getElementById("ChestInput").value = cv;
    }
</script>