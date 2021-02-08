<?php 
add_action("wp_ajax_sci_change_name", "sci_change_name");

function sci_change_name() {
   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["name"]) {
      preg_match("/^([\w.]+) ?(.*)?$/", $_REQUEST["name"], $res);
      $first_name = $res[1] ? $res[1] : '';
      $last_name = $res[2] ? $res[2] : '';
      $data = wp_update_user( array( 'ID' => $current_user->ID, 'first_name' => $first_name, 'last_name' => $last_name ) );      
   }

   if ( is_wp_error( $data ) ) {
       // There was an error; possibly this user doesn't exist.
       echo 'Error.';
   } else {
       // Success!
       echo 'ok';
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
      update_field(__sci_s("USER: Profile details", 'sci_user_mobile')['key'], $_REQUEST["number"], 'user_' . $current_user->ID);
      echo "ok";
   }
   if (!!$_REQUEST["hide_number"]) {
      $bool = filter_var($_REQUEST["hide_number"], FILTER_VALIDATE_BOOLEAN);
      update_field(__sci_s("USER: Profile details", 'hide_number')['key'], $bool, 'user_' . $current_user->ID);
      echo "ok";

   }

   wp_die();

}

add_action("wp_ajax_sci_change_location", "sci_change_location");
function sci_change_location() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["location"]) {
      update_field(__sci_s("USER: Profile details", 'sci_user_location')['key'], $_REQUEST["location"], 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_gender", "sci_change_gender");
function sci_change_gender() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["gender"]) {
      update_field(__sci_s("USER: Profile details", 'sci_user_gender')['key'], $_REQUEST["gender"], 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_category", "sci_change_category");
function sci_change_category() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["categories"]) {
      $new = array_map(function($item){
         return get_term_by('id', $item, 'jobs');
      }, json_decode($_REQUEST["categories"]));
      update_field(__sci_s("Profession", 'profession')['key'], json_decode($_REQUEST["categories"]), 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_intro", "sci_change_intro");
function sci_change_intro() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   update_field(__sci_s("USER: Profile details", 'intro_to_camera')['key'], $_REQUEST["camera"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Profile details", 'intro_text')['key'], $_REQUEST["text"], 'user_' . $current_user->ID);
   echo "ok";

   wp_die();

}

add_action("wp_ajax_sci_change_social", "sci_change_social");
function sci_change_social() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_instagram')['key'], $_REQUEST["instagram"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_facebook')['key'], $_REQUEST["facebook"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_twitter')['key'], $_REQUEST["twitter"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_youtube')['key'], $_REQUEST["youtube"], 'user_' . $current_user->ID);
   echo "ok";

   wp_die();

}

add_action("wp_ajax_sci_manage_photos", "sci_manage_photos");
function sci_manage_photos() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   $newOrder = [];

   if ($_REQUEST['order']) {
      foreach ($_REQUEST['order'] as $key => $value) {
         $id = (int) $value['id'];
         if ($value['caption']) {
            $my_post = array(
               'ID'           => $id,
               'post_excerpt'   => $value['caption'],
            );
            wp_update_post($my_post);
         }
         array_push($newOrder, get_post($id));
      }
   }
   //
   
   $path = str_replace('\\', '/', preg_replace("/^(?:.+)(wp-content.*)/", ABSPATH . "$1", $newOrder[0]->guid));

   //$image = wp_get_image_editor($path);
   //var_dump($image->rotate(-90));
   //var_dump($image->save($path));
   //var_dump($newOrder);
   update_field(__sci_s("USER: Profile details", 'photos')['key'], $newOrder, 'user_' . $current_user->ID);
   echo "ok";
   wp_die();

}
 ?>