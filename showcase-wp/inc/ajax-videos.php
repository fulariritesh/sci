<?php
add_action("wp_ajax_sci_add_video", "sci_add_video");
function sci_add_video() {
	$user_id = get_current_user_id();
	$upload_id = NULL;

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["video"])) {
        $video_link = sanitize_text_field($_REQUEST["video"]);     
        $row = array('video_link' => $video_link);
        if(!empty($_REQUEST["caption"])){
            $video_caption = sanitize_text_field($_REQUEST["caption"]);
            $row['video_caption'] = $video_caption;
        }
        $success = add_row('videos', $row, 'user_'.$user_id);    
        if($success){          
            echo json_encode(array('status' => 'success', 'msg' => 'Success.' ));
            exit();	
        }else{         
            echo json_encode(array('status' => 'danger','msg' => 'Upload failed' ));
            exit();	
        }			
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong.'));
		exit();	
	}else{
		echo json_encode(array('status' => 'warning','msg' => 'Please enter a video link'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_edit_video", "sci_edit_video");
function sci_edit_video() {
	$user_id = get_current_user_id();
    $upload_id = NULL;
    
   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["video"]) && !empty($_REQUEST["index"])) {
        $video_link = sanitize_text_field($_REQUEST["video"]);
        $index = intval($_REQUEST["index"]);     
        $row = array('video_link' => $video_link);
        if(!empty($_REQUEST["caption"])){
            $video_caption = sanitize_text_field($_REQUEST["caption"]);
            $row['video_caption'] = $video_caption;
        }
        $success = update_row('videos', $index, $row, 'user_'.$user_id);     
        if($success){
            echo json_encode(array('status' => 'success','msg' =>  'Success.' ));
            exit();	
        }else{
            echo json_encode(array('status' => 'danger','msg' => 'Upload failed' ));
            exit();	
        }		
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong.'));
		exit();	
	}else{
		echo json_encode(array('status' => 'warning','msg' => 'Please enter a video link'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_delete_video", "sci_delete_video");
function sci_delete_video() {
	$user_id = get_current_user_id();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["index"])) {
        $index = intval($_REQUEST["index"]);     
        $success = delete_row('videos', $index, 'user_'.$user_id);
        if($success){
            echo json_encode(array('status' => 'success','msg' =>  'Success.' ));
            exit();	
        }else{
            echo json_encode(array('status' => 'danger','msg' => 'Delete failed' ));
            exit();	
        }
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong.'));
		exit();	
	}else{
		echo json_encode(array('status' => 'danger','msg' => 'Invalid video index'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_get_video", "sci_get_video");
function sci_get_video() {
	$user_id = get_current_user_id();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}

   	if(!empty($_REQUEST["index"])) {
        $index = intval($_REQUEST["index"]);
        $index = $index - 1;
        
        $video = get_user_meta($user_id,  'videos_'.$index.'_video_link', true);
        $caption = get_user_meta($user_id,  'videos_'.$index.'_video_caption', true);

        if($video && $caption){
            echo json_encode(array('video' => $video,'caption' => $caption));
            exit();	
        }else if($video){
            echo json_encode(array('video' => $video,'caption' => ''));
            exit();	
        }else{
            echo json_encode(array('video' => '','caption' => ''));
		    exit();
        }		
	}else{
        echo json_encode(array('video' => '','caption' => ''));
		exit();	
    }
    wp_die();
}