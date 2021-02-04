<?php 
add_action("wp_ajax_sci_change_name", "sci_change_name");

function sci_change_name() {
   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["name"]) {
      $data = wp_update_user( array( 'ID' => $current_user->ID, 'first_name' => $_REQUEST["name"] ) );      
   }

   if ( is_wp_error( $data ) ) {
       // There was an error; possibly this user doesn't exist.
       echo 'Error.';
   } else {
       // Success!
       echo 'User profile updated.';
   }

   wp_die();

}

add_action("wp_ajax_sci_change_number", "sci_change_number");
function sci_change_number() {
   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["number"]) {
      echo "Number Updated";     
   }

   wp_die();

}
 ?>