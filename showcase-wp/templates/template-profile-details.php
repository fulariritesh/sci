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

		if(empty($_POST['dob'])){
			$dob_er = true;
		}else{
			$dob = sanitize_text_field( $_POST['dob']);
			// checks date format YYYY-MM-DD 
			if (!preg_match("/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/",$dob)) {
				$dob_er = true;
			}
		}

		if(empty($_POST['gender'])){
			$gen_er = true;
		}
		else{
			$gendervalue = sanitize_text_field( $_POST['gender']);
			//get values from ACF plugin
			$acf_gender = acf_get_field('sci_user_gender');
			$verify_gen = array_search($gendervalue,array_keys($acf_gender['choices']),true);		

			if($verify_gen !== false){
				if($gendervalue == 'custom'){

					//if custom gender selected check custom gender text field
					if(empty($_POST['custom_gender'])){
						$gen_er = true;
					}else{
						$custom_gender = sanitize_text_field( $_POST['custom_gender']);
						// checks for number and special characters | min:1 max:20 | Multilang kept in mind
						if (!preg_match("/^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,\d\-]{1,20}$/",$custom_gender)) {
							$gen_er = true;
						}
						$gender = $custom_gender;
					}
				}else{
					$gender = $gendervalue;
				}
			}else{
				$gen_er = true;
			}		
		}

		if(empty($_POST['mobile'])){
			$mob_er = true;
		}else{
			$mobile = sanitize_text_field( $_POST['mobile']);
			// checks 10 digit number | accepts country code (optional)
			if (!preg_match("/^(\+\d{1,3}[- ]?)?\d{10}$/",$mobile)) {
				$mob_er = true;
			}
		}

		if(empty($_POST['location'])){
			$loc_er = true;
		}else{
			$locationvalue = sanitize_text_field($_POST['location']);
			//get values from ACF plugin
			$acf_location = acf_get_field('sci_user_location');
			$verify_loc = array_search($locationvalue,array_keys($acf_location['choices']),true);
			if($verify_loc !== false){
				$location = $locationvalue;
			}else{
				$loc_er = true;
			}
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
				$success_dob = update_user_meta( $user_id, 'sci_user_dob', $dob);
				$success_gen = update_user_meta( $user_id, 'sci_user_gender', $gender);
				$success_mob = update_user_meta( $user_id, 'sci_user_mobile', $mobile);
				$success_loc = update_user_meta( $user_id, 'sci_user_location', $location);

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
							<label for="FirstName">
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
							<label for="LastName">
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
						<label for="DOB">
							Birth Date<span class="float-right text-danger pl-1">*</span>
						</label>
						<input 
							type="date" 
							class="form-control <?php echo ($dob_er) ? "is-invalid" : ""; ?>" 
							id=dob 
							name="dob" 
							value="<?php echo get_field('sci_user_dob','user_'.$user_id); ?>"
							required 
						/>
						<div class="invalid-feedback">Please enter a valid date</div>
					</div>

					<!-- GENDER -->
					<div class="form-group">
						<div>
							<label for="Gender">
								Gender<span class="float-right text-danger pl-1">*</span>
							</label>
						</div>
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<?php 
								//get values from ACF plugin
								$genderf = acf_get_field('sci_user_gender');
								$g = get_user_meta( $user_id, 'sci_user_gender', true);
								foreach($genderf['choices'] as $genvalue => $genlabel){	
									echo '<label class="btn btn-details-gen">';	
									echo '<input type="radio" name="gender" value="'.$genvalue.'" '.(($g == $genvalue ) ? "checked":"").' />'.$genlabel.'</label>';		
								}
							?>
						</div>
						<input type="hidden" class="form-control <?php echo ($gen_er) ? "is-invalid" : ""; ?>">
						<div class="invalid-feedback">Please enter a valid gender</div>

						<!-- CUSTOM GENDER (text field) -->
						<div id="custom_gender_wrapper" class="form-group">
							<input 
								type="text" 
								placeholder="Enter custom gender" 
								id="custom_gender" 
								name="custom_gender" 
								value="<?php $cg = get_user_meta( $user_id, 'sci_user_gender', true);  echo ($cg) ?  $cg : ""; ?>"
								class="form-control  mt-3 d-none"
							/>
						</div>
					</div>

					<!-- MOBILE -->
					<div class="form-group">
						<label for="Mobile">
							Mobile<span class="float-right text-danger pl-1">*</span>
						</label>
						<input 
							type="text" 
							class="form-control <?php echo ($mob_er) ? "is-invalid" : ""; ?>" 
							id="mobile" 
							name="mobile" 
							value="<?php $m = get_user_meta( $user_id, 'sci_user_mobile', true);  echo ($m) ?  $m : ""; ?>"
							required 
						/>
						<div class="invalid-feedback">Please enter a valid mobile number</div>
					</div>

					<!-- LOCATION -->
					<div class="form-group">
						<label for="Location">
							Location<span class="float-right text-danger pl-1">*</span>
						</label>
						<select class="form-control <?php echo ($loc_er) ? "is-invalid" : ""; ?>" id="location" name="location">
						<?php 
							//get values from ACF plugin
							$locationf = acf_get_field('sci_user_location');
							$l = get_user_meta( $user_id, 'sci_user_location', true);
							foreach($locationf['choices'] as $locvalue => $loclabel){		
								echo '<option class="dropdown-item" value="'.$locvalue.'" '.(($l==$locvalue)?'selected="selected"':"").'>'.$loclabel.'</option>';		
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