<?php
/* Template Name: Physical Attributes Page */

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

			if(empty($_POST['height'])){
				$height_er = true;
			}else{
				$heightvalue = sanitize_text_field($_POST['height']);
				if(is_numeric($heightvalue)){
					$heightvalue = intval($heightvalue);
					//get values from ACF plugin
					$acf_height = get_field_object($height_field);				
					if((intval($acf_height['min']) <= $heightvalue) && ($heightvalue <= intval($acf_height['max']))){
						$height = $heightvalue;
					}else{
						$height_er = true;
					}
				}else{
					$height_er = true;
				}			
			}

			if(empty($_POST['weight'])){
				$weight_er = true;
			}else{
				$weightvalue = sanitize_text_field($_POST['weight']);
				if(is_numeric($weightvalue)){
					$weightvalue = intval($weightvalue);
					//get values from ACF plugin
					$acf_weight = get_field_object($weight_field);				
					if((intval($acf_weight['min']) <= $weightvalue) && ($weightvalue <= intval($acf_weight['max']))){
						$weight = $weightvalue;
					}else{
						$weight_er = true;
					}
				}else{
					$weight_er = true;
				}			
			}

			if(empty($_POST['eye_color'])){
				$eye_color_er = true;
			}
			else{
				$eye_colorvalue = sanitize_text_field( $_POST['eye_color']);
				//get values from ACF plugin
				$acf_eye_color = get_field_object($eye_color_field);
				$verify_eye_color = array_search($eye_colorvalue,array_keys($acf_eye_color['choices']),true);		
				if($verify_eye_color !== false){				
					$eye_color = $eye_colorvalue;
				}else{
					$eye_color_er = true;
				}		
			}

			if(empty($_POST['skin_color'])){
				$skin_color_er = true;
			}
			else{
				$skin_colorvalue = sanitize_text_field( $_POST['skin_color']);
				//get values from ACF plugin
				$acf_skin_color = get_field_object($skin_color_field);
				$verify_skin_color = array_search($skin_colorvalue,array_keys($acf_skin_color['choices']),true);		
				if($verify_skin_color !== false){				
					$skin_color = $skin_colorvalue;
				}else{
					$skin_color_er = true;
				}		
			}

			if(empty($_POST['chest'])){
				$chest_er = true;
			}else{
				$chestvalue = sanitize_text_field($_POST['chest']);
				if(is_numeric($chestvalue)){
					$chestvalue = intval($chestvalue);
					//get values from ACF plugin
					$acf_chest = get_field_object($chest_field);				
					if((intval($acf_chest['min']) <= $chestvalue) && ($chestvalue <= intval($acf_chest['max']))){
						$chest = $chestvalue;
					}else{
						$chest_er = true;
					}
				}else{
					$chest_er = true;
				}			
			}


			if(!($height_er || $weight_er || $eye_color_er || $skin_color_er || $chest_er)){

				$success_height = update_user_meta( $user_id, 'sci_user_height', $height);
				$success_weight = update_user_meta( $user_id, 'sci_user_weight', $weight);
				$success_eye_color = update_user_meta( $user_id, 'sci_user_eye_color', $eye_color);
				$success_skin_color = update_user_meta( $user_id, 'sci_user_skin_color', $skin_color);
				$success_chest = update_user_meta( $user_id, 'sci_user_chest', $chest);

				wp_redirect( get_page_link(get_page_by_path('add-headshot'))); exit;
			}

		}else{

			$deleted_height = delete_user_meta( $user_id, 'sci_user_height');
			$deleted_weight = delete_user_meta( $user_id, 'sci_user_weight');
			$deleted_eye_color = delete_user_meta( $user_id, 'sci_user_eye_color');
			$deleted_skin_color = delete_user_meta( $user_id, 'sci_user_skin_color');
			$deleted_chest = delete_user_meta( $user_id, 'sci_user_chest');

			wp_redirect( get_page_link(get_page_by_path('add-headshot'))); exit;
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

				<!-- HEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$height_f = get_field_object($height_field);
						$user_height= get_user_meta( $user_id, 'sci_user_height', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Height (cm): </label>
						<input class="disp-val" value="<?php echo ($user_height) ? $user_height : ($height_f['min'] + $height_f['max'])/2 ?>" id="HeightInput" oninput="updateHeightInput(this.value);"></input>
					</div>
					<input 
						name="height" 
						value="<?php echo ($user_height) ? $user_height : ($height_f['min'] + $height_f['max'])/2 ?>"
						type="range" id="HeightOutput" 
						class="form-control-range slider <?php echo ($height_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $height_f['min']; ?>" 
						max="<?php echo $height_f['max']; ?>" 
						oninput="updateHeightInput(this.value);"
					>
					<div class="invalid-feedback">Please enter a valid height</div>
				</div>

				<!-- WEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$weight_f = get_field_object($weight_field);
						$user_weight= get_user_meta( $user_id, 'sci_user_weight', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Weight (kg): </label>
						<input class="disp-val" value="<?php echo ($user_weight) ? $user_weight : ($weight_f['min'] + $weight_f['max'])/2 ?>" id="WeightInput" oninput="updateWeightInput(this.value);"></input>
					</div>
					<input 
						name="weight" 
						value="<?php echo ($user_weight) ? $user_weight : ($weight_f['min'] + $weight_f['max'])/2 ?>" 
						type="range" id="WeightOutput" 
						class="form-control-range <?php echo ($weight_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $weight_f['min']; ?>" 
						max="<?php echo $weight_f['max']; ?>" 
						oninput="updateWeightInput(this.value);"
					>
					<div class="invalid-feedback">Please enter a valid weight</div>
				</div>

				<!-- EYE COLOR -->
				<div class="form-group">
					<div>
						<label for="eye_color">Eye color:</label>
					</div>					
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php
							//get values from ACF plugin
							$eye_color_f = get_field_object($eye_color_field);
							$user_eye_color = get_user_meta( $user_id, 'sci_user_eye_color', true);
							foreach($eye_color_f['choices'] as $eye_color_value => $eye_color_label){	
								echo '<label class="btn btn-details-gen">';	
								echo '<input type="radio" name="eye_color" value="'.$eye_color_value.'" '.(($user_eye_color == $eye_color_value ) ? "checked":"").' />'.$eye_color_label.'</label>';		
							}
						?>						
					</div>
					<input type="hidden" class="form-control <?php echo ($eye_color_er) ? "is-invalid" : ""; ?>">
					<div class="invalid-feedback">Please select a valid eye color</div>
				</div>

				<!-- SKIN COLOR -->
				<div class="form-group">
					<div>
						<label for="skin_color">Skin color:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php
							//get values from ACF plugin
							$skin_color_f = get_field_object($skin_color_field);
							$user_skin_color = get_user_meta( $user_id, 'sci_user_skin_color', true);
							foreach($skin_color_f['choices'] as $skin_color_value => $skin_color_label){	
								echo '<label class="btn btn-details-gen">';	
								echo '<input type="radio" name="skin_color" value="'.$skin_color_value.'" '.(($user_skin_color == $skin_color_value ) ? "checked":"").' />'.$skin_color_label.'</label>';		
							}
						?>
					</div>
					<input type="hidden" class="form-control <?php echo ($skin_color_er) ? "is-invalid" : ""; ?>">
					<div class="invalid-feedback">Please select a valid skin color</div>
				</div>

				<!-- CHEST -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$chest_f = get_field_object($chest_field);
						$user_chest= get_user_meta( $user_id, 'sci_user_chest', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="formControlRange">Chest (cm): </label>
						<input class="disp-val" value="<?php echo ($user_chest) ? $user_chest : ($chest_f['min'] + $chest_f['max'])/2 ?>" id="ChestInput" oninput="updateChestInput(this.value);"></input>
					</div>
					<input 
						name="chest" 
						value="<?php echo ($user_chest) ? $user_chest : ($chest_f['min'] + $chest_f['max'])/2 ?>" 
						type="range" id="ChestOutput" 
						class="form-control-range <?php echo ($chest_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $chest_f['min']; ?>" 
						max="<?php echo $chest_f['max']; ?>" 
						oninput="updateChestInput(this.value);"
					>
					<div class="invalid-feedback">Please enter a valid chest size</div>
				</div>

				<!-- BACK - SAVE -->
				<div class="d-flex justify-content-between py-3">
					<a href="<?php echo get_page_link(get_page_by_path('profile-details')); ?>" class="btn btn-lg btn-details-bck btn-xs px-md-5">Back</a>
					<button type="submit" name="submit" value="save" class="btn btn-lg btn-details-nxt float-right btn-xs px-md-5">Next</button>
				</div>
				
				<!-- SKIP -->
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