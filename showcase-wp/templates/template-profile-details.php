<?php
/* Template Name: Profile details Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 

$user_id = get_current_user_id();

$fn_er = $ln_er = $dob_er = $gen_er = $mob_er = $loc_er = NULL;
$firstname = $lastname = $dob = $gender = $mobile = $location = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST['submit'])){

		if(empty($_POST['firstname'])){
			$fn_er = true;
		}else{
			$firstname = sanitize_text_field( $_POST['firstname']);
			// checks for number and special characters | min:1 max:20 | Multilang kept in mind
			if (!preg_match("/^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,\d\-]{1,20}$/",$firstname)) {
				$fn_er = true;
			}
		}

		if(empty($_POST['lastname'])){
			$ln_er = true;
		}else{
			$lastname = sanitize_text_field( $_POST['lastname']);
			// checks for number and special characters | min:1 max:20 | Multilang kept in mind
			if (!preg_match("/^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,\d\-]{1,20}$/",$lastname)) {
				$ln_er = true;
			}
		}

		if(empty($_POST['sci_user_dob'])){
			$dob_er = true;
		}else{
			$dob = sanitize_text_field( $_POST['sci_user_dob']);
			// checks date format YYYY-MM-DD 
			if (!preg_match("/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/",$dob)) {
				$dob_er = true;
			}
		}

		if(empty($_POST['sci_user_gender'])){
			$gen_er = true;
		}
		else{
			$gender = sanitize_text_field($_POST['sci_user_gender']);
			//user clicked custom but did not enter value in textbox hence default value will be custom. 
			if($gender == 'custom'){
				$gen_er = true;		
			}			
		}

		if(empty($_POST['sci_user_mobile'])){
			$mob_er = true;
		}else{
			$mobile = sanitize_text_field( $_POST['sci_user_mobile']);
			// checks 10 digit number | accepts country code (optional)
			if (!preg_match("/^(\+\d{1,3}[- ]?)?\d{10}$/",$mobile)) {
				$mob_er = true;
			}
		}

		if(empty($_POST['sci_user_location'])){
			$loc_er = true;
		}else{
			$location = sanitize_text_field($_POST['sci_user_location']);
		}

		if(!($fn_er || $ln_er || $dob_er || $gen_er || $mob_er || $loc_er)){		
			$userdata = array(
				'ID'                    => $user_id,    //(int) User ID. If supplied, the user will be updated.
				'display_name'          => $firstname,   //(string) The user's display name. Default is the user's username.
				'nickname'              => $firstname,   //(string) The user's nickname. Default is the user's username.
				'first_name'            => $firstname,   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
				'last_name'             => $lastname,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.				
			);

			$user = wp_update_user( $userdata );

			if(!is_wp_error($user)){
				$success_dob = update_field('sci_user_dob', $dob, 'user_'.$user_id);
				$success_gen = update_field('sci_user_gender', $gender, 'user_'.$user_id);
				$success_mob = update_field('sci_user_mobile', $mobile, 'user_'.$user_id);
				$success_loc = update_field('sci_user_location', $location, 'user_'.$user_id);

				$profile_detail_complete = update_user_meta( $user_id, 'sci_user_profile_detail_complete', true);

				wp_redirect( get_page_link(get_page_by_path('physical-attributes'))); exit;
			}
			
		}
  	}
  
}

get_header();

include('join-pagination.php');
?>

	<section class="pr-details d-flex justify-content-center py-5">
		<div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0">
			<div class="card-header">Enter your basic information</div>
			<div class="card-body px-4">

				<form action="" method="post">
					<!-- First and last name -->
					<div class="form-row">
						<!-- FIRSTNAME -->
						<div class="col-md-6 mb-3">
							<label for="firstName">
								First name<span class="float-right text-danger pl-1">*</span>
							</label>
							<input
								type="text"
								class="form-control <?php echo ($fn_er) ? "is-invalid" : ""; ?>"
								id="firstname" 
								name="firstname"
								value="<?php $fn = get_user_meta( $user_id, 'first_name', true);  echo ($fn) ?  $fn : ""; ?>"
								required
							/>
							<div class="invalid-feedback">Please enter a valid first name</div>
						</div>

						<!-- LASTNAME -->
						<div class="col-md-6 mb-3">
							<label for="lastName">
								Last name<span class="float-right text-danger pl-1">*</span>
							</label>
							<input
								type="text"
								class="form-control <?php echo ($ln_er) ? "is-invalid" : ""; ?>"
								id="lastname"
								name="lastname"
								value="<?php $ln = get_user_meta( $user_id, 'last_name', true);  echo ($ln) ?  $ln : ""; ?>"
								required
							/>
							<div class="invalid-feedback">Please enter a valid last name</div>
						</div>
					</div>

					<!-- DOB -->
					<div class="form-group">
						<?php
							$user_dob = get_field('sci_user_dob','user_'.$user_id);
							$acf_dob = acf_get_field('sci_user_dob');	
						?>
						<label for="<?php echo $acf_dob['name']; ?>">
							<?php echo $acf_dob['label']; ?><span class="float-right text-danger pl-1">*</span>
						</label>
						<input 
							type="date" 
							class="form-control <?php echo ($dob_er) ? "is-invalid" : ""; ?>" 
							id="<?php echo $acf_dob['name']; ?>"
							name="<?php echo $acf_dob['name']; ?>"
							value="<?php echo ($user_dob) ? $user_dob : ''; ?>"
							required 
						/>
						<div class="invalid-feedback">Please enter a valid date</div>
					</div>

					<!-- GENDER -->
					<div class="form-group">
						<?php
							$user_gender = get_field('sci_user_gender','user_'.$user_id);
							$acf_gender = acf_get_field('sci_user_gender');
							$user_gender_custom = false;
						?>
						<div>
							<label for="<?php echo $acf_gender['name']; ?>">
								<?php echo $acf_gender['label']; ?><span class="float-right text-danger pl-1">*</span>
							</label>
						</div>
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<?php 
								foreach($acf_gender['choices'] as $value => $label): ?>
									<label class="btn btn-details-gen">	
									<input 
									type="<?php echo $acf_gender['type']; ?>" 
									name="<?php echo $acf_gender['name']; ?>" 
									value="<?php echo $value; ?>" 
									<?php echo ($user_gender == $value ) ? "checked" : ""; ?> 
									/>
									<?php echo $label; ?>
									</label>	
							<?php 	endforeach;	?>
								<label class="btn btn-details-gen">
									<input 
									type="<?php echo $acf_gender['type']; ?>" 
									name="<?php echo $acf_gender['name']; ?>"
									id="sci_user_custom_gender_radio"
									<?php 						
									if($user_gender){
										if(array_search($user_gender,array_keys($acf_gender['choices']),true) == false){
											$user_gender_custom = true;
										}
										echo ($user_gender_custom) ? 'checked' : ''; 
									}
									?>
									value="<?php echo ($user_gender_custom) ? $user_gender : 'custom'; ?>"
									/>
									Custom
								</label>
						</div>
						<input type="hidden" class="form-control <?php echo ($gen_er) ? "is-invalid" : ""; ?>">
						<div class="invalid-feedback">Please enter a valid gender</div>
					</div>
					<div id="sci_user_custom_gender_wapper" class="form-group <?php echo ($user_gender_custom) ? '' : 'd-none'; ?>">
						<input 
							type="text" 
							class="form-control" 
							placeholder="Enter custom gender" 
							value="<?php echo ($user_gender_custom) ? $user_gender : ''; ?>"
							id="sci_user_custom_gender_text"
						/>
					</div>

					<!-- MOBILE -->
					<div class="form-group">
						<?php
							$user_mobile = get_field('sci_user_mobile','user_'.$user_id);
							$acf_mobile = acf_get_field('sci_user_mobile');	
						?>
						<label for="<?php echo $acf_mobile['name']; ?>">
							<?php echo $acf_mobile['label']; ?><span class="float-right text-danger pl-1">*</span>
						</label>
						<input 
							type="<?php echo $acf_mobile['type']; ?>" 
							class="form-control <?php echo ($mob_er) ? "is-invalid" : ""; ?>" 
							id="<?php echo $acf_mobile['name']; ?>"
							name="<?php echo $acf_mobile['name']; ?>"
							name="<?php echo $acf_mobile['placeholder']; ?>"
							value="<?php echo ($user_mobile) ? $user_mobile : ''; ?>"
							required 
						/>
						<div class="invalid-feedback">Please enter a valid mobile number</div>
					</div>

					<!-- LOCATION -->
					<div class="form-group">
						<?php
							$user_location_array = get_field('sci_user_location','user_'.$user_id);
							$acf_location = acf_get_field('sci_user_location');	
							$user_location = $user_location_array['label'];
						?>
						<label for="<?php echo $acf_location['name']; ?>">
							<?php echo $acf_location['label']; ?><span class="float-right text-danger pl-1">*</span>
						</label>
						<select 
							class="form-control <?php echo ($loc_er) ? "is-invalid" : ""; ?>" 
							id="<?php echo $acf_location['name']; ?>" 
							name="<?php echo $acf_location['name']; ?>"
						>
						<?php 
							foreach($acf_location['choices'] as $value => $label){		
								echo '<option class="dropdown-item" value="'.$value.'" '.(($user_location==$label)?'selected="selected"':"").'>'.$label.'</option>';		
							}
						?>
						</select>
						<div class="invalid-feedback">Please enter a valid location</div>
					</div>

					<!-- BACK - SUBMIT -->
					<div class="d-flex justify-content-between">
						<a href="<?php echo get_page_link(get_page_by_path('welcome')); ?>" class="btn btn-lg btn-xs btn-details-bck px-md-5">Back</a>
						<button 
							type="submit" 
							name="submit" 
							value="submit" 
							class="btn btn-lg btn-xs btn-details-nxt px-md-5 d-flex justify-content-end"
						>
						Next
						</button>					
					</div>
				</form>
			</div>
		</div>
	</section>


<?php
get_sidebar();
get_footer();
?>