<?php
/* Template Name: Physical Attributes v2.0 Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();

$height_er = $weight_er = $eye_color_er = $skin_color_er = $chest_er = NULL;
$height_ft = $height_in = $weight_kg = $eye_color = $skin_color = $chest_in = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])){

		if($_POST['submit'] == 'save'){

			if(!empty($_POST["sci_user_height_ft"])){
				if(is_numeric($_POST["sci_user_height_ft"])){
					$success = update_field('sci_user_height_ft', sanitize_text_field($_POST["sci_user_height_ft"]), 'user_'.$user_id);
				}else{
					$height_er = true;
				}
				// if(!$success){ 
				// 	$height_er = true;
				// }
			}else{
				$field_exist = get_field('sci_user_height_ft', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_height_ft', 'user_'.$user_id);
					// if(!$success){ 
					// 	$height_er = true;
					// }
				}
			}
		
			if(!empty($_POST["sci_user_height_in"])){
				if(is_numeric($_POST["sci_user_height_in"])){
					$success = update_field('sci_user_height_in', sanitize_text_field($_POST["sci_user_height_in"]), 'user_'.$user_id);
				}else{
					$height_er = true;
				}
				// if(!$success){ 
				// 	$height_er = true;
				// }  
			}else{
				$field_exist = get_field('sci_user_height_in', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_height_in', 'user_'.$user_id);
					// if(!$success){ 
					// 	$height_er = true;
					// }
				}
			}

			if(!empty($_POST["sci_user_weight_kg"])){
				if(is_numeric($_POST["sci_user_weight_kg"])){
					$success = update_field('sci_user_weight_kg', sanitize_text_field($_POST["sci_user_weight_kg"]), 'user_'.$user_id);
				}else{
					$weight_er = true;
				}
				// if(!$success){ 
				// 	$weight_er = true;
				// }  
			}else{
				$field_exist = get_field('sci_user_weight_kg', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_weight_kg', 'user_'.$user_id);
					// if(!$success){ 
					// 	$weight_er = true;;
					// }
				}
			}

			if(!empty($_POST["sci_user_eye_color"])){
				$success = update_field('sci_user_eye_color', sanitize_text_field($_POST["sci_user_eye_color"]), 'user_'.$user_id);
				// if(!$success){ 
				// 	$eye_color_er = true;
				// }  
			}else{
				$field_exist = get_field('sci_user_eye_color', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_eye_color', 'user_'.$user_id);
					// if(!$success){ 
					// 	$eye_color_er = true;;
					// }
				}
			}

			if(!empty($_POST["sci_user_skin_color"])){
				$success = update_field('sci_user_skin_color', sanitize_text_field($_POST["sci_user_skin_color"]), 'user_'.$user_id);
				// if(!$success){ 
				// 	$skin_color_er = true;
				// }  
			}else{
				$field_exist = get_field('sci_user_skin_color', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_skin_color', 'user_'.$user_id);
					// if(!$success){ 
					// 	$skin_color_er = true;;
					// }
				}
			}

			if(!empty($_POST["sci_user_chest_in"])){
				if(is_numeric($_POST["sci_user_chest_in"])){
					$success = update_field('sci_user_chest_in', sanitize_text_field($_POST["sci_user_chest_in"]), 'user_'.$user_id);
				}else{
					$chest_er = true;
				}
				// if(!$success){ 
				// 	$chest_er = true;
				// }  
			}else{
				$field_exist = get_field('sci_user_chest_in', 'user_'.$user_id);
				if($field_exist){
					$success = delete_field('sci_user_chest_in', 'user_'.$user_id);
					// if(!$success){ 
					// 	$chest_er = true;;
					// }
				}
			}

			if(!($height_er || $weight_er || $eye_color_er || $skin_color_er || $chest_er)){
				wp_redirect(get_page_link(get_page_by_path('add-headshot'))); exit;
			}

		}else{

            $deleted_height_ft = delete_field('sci_user_height_ft', 'user_'.$user_id);
            $deleted_height_in = delete_field('sci_user_height_in', 'user_'.$user_id);
			$deleted_weight = delete_field('sci_user_weight_kg', 'user_'.$user_id);
			$deleted_eye_color = delete_field('sci_user_eye_color', 'user_'.$user_id);
			$deleted_skin_color = delete_field('sci_user_skin_color', 'user_'.$user_id);
			$deleted_chest = delete_field('sci_user_chest_in', 'user_'.$user_id);

			wp_redirect(get_page_link(get_page_by_path('add-headshot'))); exit;
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
			<p>Fill in all the details relevant to your skillset for better chances of being scouted.</p>
			<p>If this section is not relevant to your skillset, please skip below. And remember, you can always update this information later if you change your mind.</p>
			<form action="" method="POST" >

				<!-- HEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_height_ft = acf_get_field('sci_user_height_ft');
                        $user_height_ft = get_user_meta( $user_id, 'sci_user_height_ft', true);
                        $acf_height_in = acf_get_field('sci_user_height_in');
						$user_height_in = get_user_meta( $user_id, 'sci_user_height_in', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="<?php echo $acf_height_ft['name']; ?>"><?php echo $acf_height_ft['label']; ?>: </label>
					</div>
                    <div class="d-flex justify-content-between">
                        <input 
                            name="<?php echo $acf_height_ft['name']; ?>" 
                            value="<?php echo ($user_height_ft) ? $user_height_ft : ''; ?>"
                            type="<?php echo $acf_height_ft['type']; ?>"
                            class="form-control mr-2 <?php echo ($height_er) ? "is-invalid" : ""; ?>" 
                            min="<?php echo $acf_height_ft['min']; ?>" 
                            max="<?php echo $acf_height_ft['max']; ?>"
							step="<?php echo $acf_height_ft['step']; ?>"
							placeholder="<?php echo $acf_height_ft['placeholder']; ?>"
                        >
                        <input 
                            name="<?php echo $acf_height_in['name']; ?>" 
                            value="<?php echo ($user_height_in) ? $user_height_in : ''; ?>"
                            type="<?php echo $acf_height_in['type']; ?>" 
                            class="form-control ml-2 <?php echo ($height_er) ? "is-invalid" : ""; ?>" 
                            min="<?php echo $acf_height_in['min']; ?>" 
                            max="<?php echo $acf_height_in['max']; ?>"
							step="<?php echo $acf_height_in['step']; ?>"
							placeholder="<?php echo $acf_height_in['placeholder']; ?>"
                        >
                    </div>
					<?php echo ($height_er) ? '<div class="text-danger" style="font-size: 80%;">Please enter a valid height</div>' : ''; ?>
				</div>

				<!-- WEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_weight_kg = acf_get_field('sci_user_weight_kg');
						$user_weight_kg= get_user_meta( $user_id, 'sci_user_weight_kg', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="<?php echo $acf_weight_kg['name']; ?>"><?php echo $acf_weight_kg['label']; ?>: </label>
					</div>
					<input 
						name="<?php echo $acf_weight_kg['name']; ?>" 
						value="<?php echo ($user_weight_kg) ? $user_weight_kg : ''; ?>" 
						type="<?php echo $acf_weight_kg['type']; ?>"
						class="form-control <?php echo ($weight_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $acf_weight_kg['min']; ?>" 
						max="<?php echo $acf_weight_kg['max']; ?>" 
						step="<?php echo $acf_weight_kg['step']; ?>"
						placeholder="<?php echo $acf_weight_kg['placeholder']; ?>"
					>
					<div class="invalid-feedback">Please enter a valid weight</div>
				</div>

				<!-- EYE COLOR -->
				<div class="form-group">
					<?php
						$user_eye_color = get_field('sci_user_eye_color','user_'.$user_id);
						$acf_eye_color = acf_get_field('sci_user_eye_color');
					?>
					<div>
						<label for="<?php echo $acf_eye_color['name']; ?>"><?php echo $acf_eye_color['label']; ?>:</label>
					</div>					
					<div class="btn-group btn-group-toggle" data-toggle="buttons">			
					<?php 
						foreach($acf_eye_color['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">	
							<input 
							type="<?php echo $acf_eye_color['type']; ?>" 
							name="<?php echo $acf_eye_color['name']; ?>" 
							value="<?php echo $value; ?>" 
							<?php echo ($user_eye_color == $label ) ? "checked" : ""; ?> 
							/>
							<?php echo $label; ?>
							</label>	
					<?php 	endforeach;	?>						
					</div>
					<input type="hidden" class="form-control <?php echo ($eye_color_er) ? "is-invalid" : ""; ?>">
					<div class="invalid-feedback">Please select a valid eye color</div>
				</div>

				<!-- SKIN COLOR -->
				<div class="form-group">
					<?php
						$user_skin_color = get_field('sci_user_skin_color','user_'.$user_id);
						$acf_skin_color = acf_get_field('sci_user_skin_color');
					?>
					<div>
						<label for="<?php echo $acf_skin_color['name']; ?>"><?php echo $acf_skin_color['label']; ?>:</label>
					</div>					
					<div class="btn-group btn-group-toggle" data-toggle="buttons">			
					<?php 
						foreach($acf_skin_color['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">	
							<input 
							type="<?php echo $acf_skin_color['type']; ?>" 
							name="<?php echo $acf_skin_color['name']; ?>" 
							value="<?php echo $value; ?>" 
							<?php echo ($user_skin_color == $label ) ? "checked" : ""; ?> 
							/>
							<?php echo $label; ?>
							</label>	
					<?php 	endforeach;	?>
					</div>
					<input type="hidden" class="form-control <?php echo ($skin_color_er) ? "is-invalid" : ""; ?>">
					<div class="invalid-feedback">Please select a valid skin color</div>
				</div>

				<!-- CHEST -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_chest_in = acf_get_field('sci_user_chest_in');
						$user_chest_in = get_user_meta( $user_id, 'sci_user_chest_in', true);
					?>
					<div class="d-flex justify-content-between">
						<label for="<?php echo $acf_chest_in['name']; ?>"><?php echo $acf_chest_in['label']; ?>: </label>
					</div>
					<input 
						name="<?php echo $acf_chest_in['name']; ?>" 
						value="<?php echo ($user_chest_in) ? $user_chest_in : ''; ?>" 
						type="<?php echo $acf_chest_in['type']; ?>"
						class="form-control <?php echo ($chest_er) ? "is-invalid" : ""; ?>" 
						min="<?php echo $acf_chest_in['min']; ?>" 
						max="<?php echo $acf_chest_in['max']; ?>" 
                        step="<?php echo $acf_chest_in['step']; ?>"
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