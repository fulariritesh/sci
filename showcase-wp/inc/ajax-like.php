<?php
add_action("wp_ajax_sci_toggle_like", "sci_toggle_like");
function sci_toggle_like() {
    $current_user = get_current_user_id();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_like")) {
      exit("No naughty business please");
   }   
   if (!empty($_REQUEST["user_id"])){
    if (in_array($current_user, get_field('likes', 'user_'. $_REQUEST['user_id']))){
        $total_likes = get_field('likes', 'user_'. $_REQUEST['user_id']);
        $key = array_search ($current_user, $total_likes);
        unset($total_likes[$key]);
        update_field(__sci_s("USER: Profile details", 'likes')['key'], $total_likes, 'user_' . $_REQUEST['user_id']);
        echo json_encode(array('status' => 'dislike','count' =>  count($total_likes)));
        exit();   
    }
    else{
        $total_likes = get_field('likes', 'user_'. $_REQUEST['user_id']);
        $total_likes[count($total_likes)+1] = $current_user;
        update_field(__sci_s("USER: Profile details", 'likes')['key'], $total_likes, 'user_' . $_REQUEST['user_id']);
        echo json_encode(array('status' => 'like','count' =>  count($total_likes)));
        exit();
    }
    exit('error');        
   }
      wp_die();

}
?>