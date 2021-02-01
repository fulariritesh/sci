<?php
/* Template Name: Physical Attributes v2.0 Page */

include('page_ids.php'); 
include('acf_field_ids.php'); 

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();

$height_er = $weight_er = $eye_color_er = $skin_color_er = $chest_er = NULL;
$height_ft = $height_in = $weight_kg = $eye_color = $skin_color = $chest_in = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])){

		if($_POST['submit'] == 'save'){

			if(empty($_POST['height_ft'])){
				$height_er = true;
			}else{

                //Process Feet first (mandatory)
                $heightvalueft = sanitize_text_field($_POST['height_ft']);
				if(is_numeric($heightvalueft)){
					$heightvalueft = intval($heightvalueft);
					//get values from ACF plugin
					$acf_height_ft = get_field_object($height_field_ft);			
					if((intval($acf_height_ft['min']) <= $heightvalueft) && ($heightvalueft <= intval($acf_height_ft['max']))){
						$height_ft = $heightvalueft;
					}else{
						$height_er = true;
                    }
                    
                    //Process Inch (optional)
                    if(empty($_POST['height_in'])){
                        $height_in = 0;
                    }else{
                        $heightvaluein = sanitize_text_field($_POST['height_in']);
                        if(is_numeric($heightvaluein)){
                            $heightvaluein = intval($heightvaluein);
                            //get values from ACF plugin
                            $acf_height_in = get_field_object($height_field_in);			
                            if((intval($acf_height_in['min']) <= $heightvaluein) && ($heightvaluein <= intval($acf_height_in['max']))){
                                $height_in = $heightvaluein;
                            }else{
                                $height_er = true;
                            }

                        }else{
                            $height_er = true;
                        }
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
					$weightvalue = floatval($weightvalue);
					//get values from ACF plugin
					$acf_weight = get_field_object($weight_field_kg);				
					if((floatval($acf_weight['min']) <= $weightvalue) && ($weightvalue <= floatval($acf_weight['max']))){
						$weight_kg = $weightvalue;
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
					$acf_chest = get_field_object($chest_field_in);				
					if((intval($acf_chest['min']) <= $chestvalue) && ($chestvalue <= intval($acf_chest['max']))){
						$chest_in = $chestvalue;
					}else{
						$chest_er = true;
					}
				}else{
					$chest_er = true;
				}			
			}


			if(!($height_er || $weight_er || $eye_color_er || $skin_color_er || $chest_er)){

                $success_height_ft = update_user_meta( $user_id, 'sci_user_height_ft', $height_ft);
                $success_height_in = update_user_meta( $user_id, 'sci_user_height_in', $height_in);
				$success_weight = update_user_meta( $user_id, 'sci_user_weight_kg', $weight_kg);
				$success_eye_color = update_user_meta( $user_id, 'sci_user_eye_color', $eye_color);
				$success_skin_color = update_user_meta( $user_id, 'sci_user_skin_color', $skin_color);
				$success_chest = update_user_meta( $user_id, 'sci_user_chest_in', $chest_in);

				wp_redirect( get_page_link( $add_headshot_page )); exit;
			}

		}else{

            $deleted_height_ft = delete_user_meta( $user_id, 'sci_user_height_ft');
            $deleted_height_in = delete_user_meta( $user_id, 'sci_user_height_in');
			$deleted_weight = delete_user_meta( $user_id, 'sci_user_weight_kg');
			$deleted_eye_color = delete_user_meta( $user_id, 'sci_user_eye_color');
			$deleted_skin_color = delete_user_meta( $user_id, 'sci_user_skin_color');
			$deleted_chest = delete_user_meta( $user_id, 'sci_user_chest_in');

			wp_redirect( get_page_link( $add_headshot_page )); exit;
		}		
	}
}

get_header();

include('join-pagination.php');

?>

<section class="pr-details d-flex justify-content-center py-5">
    <div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0">
    <div class="card-header">Physical Features</div>
		
        <div class="card-body px-4">
			<p>The more complete this section is, the better your chances of catching the eye of a scout.</p>
			<p>If this section is not relevant to your skillset, please skip below. And remember, you can always update this information later if you change your mind.</p>
			<form action="" method="POST" >

				<!-- HEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$height_f_ft = get_field_object($height_field_ft);
                        $user_height_ft = get_user_meta( $user_id, 'sci_user_height_ft', true);
                        $height_f_in = get_field_object($height_field_in);
						$user_height_in = get_user_meta( $user_id, 'sci_user_height_in', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="height">Height (Ft & In): </label>
					</div>
                    <div class="d-flex justify-content-between">
                        <input 
                            name="height_ft" 
                            value="<?php echo ($user_height_ft) ? $user_height_ft : ''; ?>"
                            type="number" 
                            class="form-control mr-2 <?php echo ($height_er) ? "is-invalid" : ""; ?>" 
                            min="<?php echo $height_f_ft['min']; ?>" 
                            max="<?php echo $height_f_ft['max']; ?>"
                            step="<?php echo $height_f_ft['step']; ?>"
                        >
                        <input 
                            name="height_in" 
                            value="<?php echo ($user_height_in) ? $user_height_in : ''; ?>"
                            type="number" 
                            class="form-control ml-2 <?php echo ($height_er) ? "is-invalid" : ""; ?>" 
                            min="<?php echo $height_f_in['min']; ?>" 
                            max="<?php echo $height_f_in['max']; ?>"
                            step="<?php echo $height_f_in['step']; ?>"
                        >
                    </div>
					<?php echo ($height_er) ? '<div class="text-danger" style="font-size: 80%;">Please enter a valid height</div>' : ''; ?>
				</div>

				<!-- WEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$weight_f = get_field_object($weight_field_kg);
						$user_weight= get_user_meta( $user_id, 'sci_user_weight_kg', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="weight">Weight (kg): </label>
					</div>
					<input 
						name="weight" 
						value="<?php echo ($user_weight) ? $user_weight : ''; ?>" 
						type="number"
						class="form-control <?php echo ($weight_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $weight_f['min']; ?>" 
						max="<?php echo $weight_f['max']; ?>" 
						step="<?php echo $weight_f['step']; ?>" 
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
						$chest_f = get_field_object($chest_field_in);
						$user_chest = get_user_meta( $user_id, 'sci_user_chest_in', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="chest">Chest (In): </label>
					</div>
					<input 
						name="chest" 
						value="<?php echo ($user_chest) ? $user_chest : ''; ?>" 
						type="number"
						class="form-control <?php echo ($chest_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $chest_f['min']; ?>" 
						max="<?php echo $chest_f['max']; ?>" 
                        step="<?php echo $chest_f['step']; ?>"
					>
					<div class="invalid-feedback">Please enter a valid chest size</div>
				</div>

				<!-- BACK - SAVE -->
				<div class="d-flex justify-content-between py-3">
					<a href="<?php echo get_page_link($profile_details_page); ?>" class="btn btn-lg btn-details-bck btn-xs px-md-5">Back</a>
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