<?php
add_action("wp_ajax_sci_user_hide_show_profile", "sci_user_hide_show_profile");
function sci_user_hide_show_profile() {
	$current_user = wp_get_current_user();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "sci_nonce")) {
		echo json_encode(array('status' => 'danger', 'msg' => 'no naughty bussiness'));
      	exit();
   	}

	if(empty($_REQUEST['password'])){
		echo json_encode(array('status' => 'danger', 'msg' => 'Please enter your password'));
      	exit();
	}else{
		$pwd = sanitize_text_field($_REQUEST['password']);

		$verify_pwd = wp_check_password( $pwd, $current_user->data->user_pass, $current_user->data->ID);

        if($verify_pwd){
			$current_visibility = get_field('profile_visibility_status', 'user_' . $current_user->data->ID);
			update_field('profile_visibility_status', !$current_visibility, 'user_' . $current_user->data->ID);

			if($current_visibility){
				echo json_encode(array('status' => 'success', 'msg' => 'Your profile is now hidden', 'visibility' => 0 ));
				exit();
			}else{
				echo json_encode(array('status' => 'success', 'msg' => 'Your profile is now visible', 'visibility' => 1 ));
				exit();
			}
		}else{
			echo json_encode(array('status' => 'danger', 'msg' => 'Incorrect password'));
      		exit();
		}
	}
	
	
   
   wp_die();
}
