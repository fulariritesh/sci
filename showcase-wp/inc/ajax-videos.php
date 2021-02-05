<?php
add_action("wp_ajax_sci_add_video", "sci_add_video");

function sci_add_video() {
	$user_id = get_current_user_id();
	$upload_id = NULL;

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('data' => "No naughty business please"));
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
            http_response_code(200);
            echo json_encode(array('data' => 'Success.' ));
            exit();	
        }else{
            http_response_code(500);
            echo json_encode(array('data' => 'Upload failed' ));
            exit();	
        }
			
		http_response_code(500);
		echo json_encode(array('data' => 'Something went wrong.'));
		exit();	
	}else{
		http_response_code(400);
		echo json_encode(array('data' => 'Please enter a video link'));
		exit();
   	}

   wp_die();

}