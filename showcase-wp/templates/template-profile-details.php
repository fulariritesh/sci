<?php
/* Template Name: Profile details Page */
include('page_ids.php'); 
include('acf_field_ids.php'); 

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
			if (!preg_match("/^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,\d\-]{2,20}$/",$firstname)) {
				$fn_er = true;
			}
		}

		if(empty($_POST['lastname'])){
			$ln_er = true;
		}else{
			$lastname = sanitize_text_field( $_POST['lastname']);
			if (!preg_match("/^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,\d\-]{2,20}$/",$lastname)) {
				$ln_er = true;
			}
		}

		if(empty($_POST['dob'])){
			$dob_er = true;
		}else{
			$dob = sanitize_text_field( $_POST['dob']);
			if (!preg_match("/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/",$dob)) {
				$dob_er = true;
			}
		}

		if(empty($_POST['gender'])){
			$gen_er = true;
		}
		else{
			$gendervalue = sanitize_text_field( $_POST['gender']);
			$acf_gender = get_field_object($gender_field);
			$verify_gen = array_search($gendervalue,array_keys($acf_gender['choices']),true);		

			if($verify_gen !== false){
				if($gendervalue == 'custom'){
					if(empty($_POST['custom_gender'])){
						$gen_er = true;
					}else{
						$custom_gender = sanitize_text_field( $_POST['custom_gender']);
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
			if (!preg_match("/^(\+\d{1,3}[- ]?)?\d{10}$/",$mobile)) {
				$mob_er = true;
			}
		}

		if(empty($_POST['location'])){
			$loc_er = true;
		}else{
			$locationvalue = sanitize_text_field($_POST['location']);
			$acf_location = get_field_object($location_field);
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

				// if($success_dob && $success_gen && $success_mob && $success_loc){
				// }
				wp_redirect( get_page_link( $physical_attributes )); exit;
			}
			
		}
  	}
  
}

get_header();

 
?>
	<!-- Pagination -->
	<ul class="nav jp-nav justify-content-center">
		<li class="nav-item">
		<a class="nav-link" href="<?php echo get_page_link($welcome_page); ?>">Get Started</a>
		</li>
		<li class="nav-item act">
		<a class="nav-link" href="<?php echo get_page_link($profile_details_page); ?>">Details</a>
		</li>
		<li class="nav-item">
		<a class="nav-link d-none d-sm-block" href="physical-attributes.html">Physical Attributes</a>
		<a class="nav-link d-block d-sm-none"> Attributes</a>
		</li>
		<li class="nav-item">
		<a class="nav-link d-none d-sm-block" href="#">Add a headshot</a>
		<a class="nav-link d-block d-sm-none">Headshot</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="#">Complete</a>
		</li>
	</ul>
    <section class="pr-details d-flex justify-content-center py-5">
      <div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0">
        <div class="card-header">Enter your details</div>
        <div class="card-body px-4">
          <form action="" method="post">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="FirstName"
                  >First name<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
                <input
                  type="text"
                  class="form-control <?php echo isset($fn_er) ? "is-invalid" : ""; ?>"
				  id="firstname" 
				  name="firstname"
				  value="<?php $fn = get_user_meta( $user_id, 'first_name', true);  echo isset($fn) ?  $fn : ""; ?>"
                  required
                />
                <div class="invalid-feedback">Please enter a valid first name</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="LastName"
                  >Last name<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
                <input
                  type="text"
                  class="form-control <?php echo isset($ln_er) ? "is-invalid" : ""; ?>"
				  id="lastname"
				  name="lastname"
				  value="<?php $ln = get_user_meta( $user_id, 'last_name', true);  echo isset($ln) ?  $ln : ""; ?>"
                  required
                />
                <div class="invalid-feedback">Please enter a valid last name</div>
              </div>
            </div>
            <div class="form-group">
              <label for="DOB"
                >Birth Date<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
			  <input type="date" 
			  class="form-control <?php echo isset($dob_er) ? "is-invalid" : ""; ?>" 
			  id=dob 
			  name="dob" 
			  value="<?php $d = get_user_meta( $user_id, 'sci_user_dob', true);  echo isset($d) ?  $d : ""; ?>"
			  required />
                <div class="invalid-feedback">Please enter a valid date</div>
            </div>
            <div class="form-group">
              <div>
                <label for="Gender"
                  >Gender<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
              </div>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
			  	<?php 
					$genderf = get_field_object($gender_field);
					$g = get_user_meta( $user_id, 'sci_user_gender', true);
					foreach($genderf['choices'] as $genvalue => $genlabel){	
						echo '<label class="btn btn-details-gen">';	
						echo '<input type="radio" name="gender" value="'.$genvalue.'" '.(($g == $genvalue ) ? "checked":"").' />'.$genlabel.'</label>';		
					}
				?>
              </div>
			  <div id="custom_gender_wrapper" class="form-group">
			  <input type="text" 
			  placeholder="Enter custom gender" 
			  id="custom_gender" 
			  name="custom_gender" 
			  value="<?php $cg = get_user_meta( $user_id, 'sci_user_gender', true);  echo isset($cg) ?  $cg : ""; ?>"
			  class="form-control <?php echo isset($gen_er) ? "is-invalid" : ""; ?> mt-3 d-none"/>
			  <div class="invalid-feedback">Please enter a valid custom gender</div>
			</div>
            </div>
            <div class="form-group">
              <label for="Mobile"
                >Mobile<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
			  <input type="text" 
			  class="form-control <?php echo isset($mob_er) ? "is-invalid" : ""; ?>" 
			  id="mobile" 
			  name="mobile" 
			  value="<?php $m = get_user_meta( $user_id, 'sci_user_mobile', true);  echo isset($m) ?  $m : ""; ?>"
			  required />
                <div class="invalid-feedback">Please enter a valid mobile number</div>
            </div>
            <div class="form-group">
              <label for="Location"
                >Location<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
              <select class="form-control <?php echo isset($loc_er) ? "is-invalid" : ""; ?>" id="location" name="location">
			  	<?php 
					$locationf = get_field_object($location_field);
					$l = get_user_meta( $user_id, 'sci_user_location', true);
					foreach($locationf['choices'] as $locvalue => $loclabel){		
						echo '<option class="dropdown-item" value="'.$locvalue.'" '.(($l==$locvalue)?'selected="selected"':"").'>'.$loclabel.'</option>';		
					}
				?>
			  </select>
			  <div class="invalid-feedback">Please enter a valid location</div>
			</div>
			<div class="d-flex justify-content-between">
            	<a href="<?php echo get_page_link($welcome_page); ?>" class="btn btn-lg btn-xs btn-details-bck px-md-5">Back</a>
            	<button type="submit" name="submit" value="submit" class="btn btn-lg btn-xs btn-details-nxt px-md-5 d-flex justify-content-end">Next</button>
				</div>
		</form>
        </div>
      </div>
    </section>


<?php
get_sidebar();
get_footer();
?>