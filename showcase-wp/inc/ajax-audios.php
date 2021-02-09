<?php
add_action("wp_ajax_sci_add_audio", "sci_add_audio");
function sci_add_audio() {
	$user_id = get_current_user_id();
	$upload_id = NULL;

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(isset($_REQUEST["audio"])) {
        // $audio_link = sanitize_text_field($_REQUEST["audio"]);     
        // $row = array('audio_link' => $audio_link);
        // if(!empty($_REQUEST["caption"])){
        //     $audio_caption = sanitize_text_field($_REQUEST["caption"]);
        //     $row['audio_caption'] = $audio_caption;
        // }
        // $success = add_row('audios', $row, 'user_'.$user_id);
        echo json_encode(array('status' => 'success', 'msg' => 'TEST UPLOAD' ));
        exit();	
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
		echo json_encode(array('status' => 'warning','msg' => 'Please enter a audio link'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_edit_audio", "sci_edit_audio");
function sci_edit_audio() {
	$user_id = get_current_user_id();
    $upload_id = NULL;
    
   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["title"]) && !empty($_REQUEST["index"])) {
        $audio_title = sanitize_text_field($_REQUEST["title"]);
        $index = intval($_REQUEST["index"]);     
        $row = array('audio_title' => $audio_title);
        if(!empty($_REQUEST["description"])){
            $audio_description = sanitize_text_field($_REQUEST["description"]);
            $row['audio_description'] = $audio_description;
        }
        $success = update_row('audios', $index, $row, 'user_'.$user_id);
  
        if($success){
            echo json_encode(array('status' => 'success','msg' =>  'Success.' ));
            exit();	
        }else{
            echo json_encode(array('status' => 'danger','msg' => 'Edit failed' ));
            exit();	
        }		
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong.'));
		exit();	
	}else{
		echo json_encode(array('status' => 'warning','msg' => 'Please enter a title'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_delete_audio", "sci_delete_audio");
function sci_delete_audio() {
	$user_id = get_current_user_id();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["index"])) {
        $index = intval($_REQUEST["index"]);

        $success = delete_row('audios', $index, 'user_'.$user_id);
     
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
		echo json_encode(array('status' => 'danger','msg' => 'Invalid audio index'));
		exit();
   	}
    wp_die();
}

add_action("wp_ajax_sci_get_audio", "sci_get_audio");
function sci_get_audio() {
	$user_id = get_current_user_id();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}

   	if(!empty($_REQUEST["index"])) {
        $index = intval($_REQUEST["index"]);
        $index = $index - 1;
        
        $title = get_user_meta($user_id,  'audios_'.$index.'_audio_title', true);
        $description = get_user_meta($user_id,  'audios_'.$index.'_audio_description', true);

        if($title && $description){
            echo json_encode(array('title' => $title,'description' => $description));
            exit();	
        }else if($title){
            echo json_encode(array('title' => $title,'description' => ''));
            exit();	
        }else{
            echo json_encode(array('title' => '','description' => ''));
		    exit();
        }		
	}else{
        echo json_encode(array('title' => '','description' => ''));
		exit();	
    }
    wp_die();
}