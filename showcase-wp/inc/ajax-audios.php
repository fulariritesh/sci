<?php
add_action("wp_ajax_sci_add_audio", "sci_add_audio");
function sci_add_audio() {
	$user_id = get_current_user_id();
	$upload_id = NULL;

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}

	if(!empty($_REQUEST["title"])){
		$audio_title = sanitize_text_field($_REQUEST["title"]);
	}else{
		echo json_encode(array('status' => 'danger','msg' => "Please enter title"));
      	exit();
	}

	if(!empty($_REQUEST["description"])){
		$audio_description = sanitize_text_field($_REQUEST["description"]);
	}else{
		echo json_encode(array('status' => 'danger','msg' => "Please enter description"));
      	exit();
	}

   	if(!empty($_REQUEST["audio"])) {
    
		$success = false;
		$data = $_POST['audio'];
		$audio_array_1 = explode(";", $data);
		$audio_array_2 = explode(",", $audio_array_1[1]);
        $data = base64_decode($audio_array_2[1]);
        
        //data:audio/mpeg;base64,SUQzAw...
        $audio_mime_type = explode(":", $audio_array_1[0])[1];

        function mime2ext($mime) {
            $mime_map = [
                'audio/x-acc'                                                               => 'aac',       
                'audio/x-flac'                                                              => 'flac',   
                'audio/x-m4a'                                                               => 'm4a',
                'audio/mp4'                                                                 => 'm4a',                
                'audio/mpeg'                                                                => 'mp3',
                'audio/mpg'                                                                 => 'mp3',
                'audio/mpeg3'                                                               => 'mp3',
                'audio/mp3'                                                                 => 'mp3',  
                'audio/ogg'                                                                 => 'ogg',   
                'audio/x-wav'                                                               => 'wav',
                'audio/wave'                                                                => 'wav',
                'audio/wav'                                                                 => 'wav',
                'audio/x-ms-wma'                                                            => 'wma',
            ];
        
            return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
        }

        $audio_ext = mime2ext($audio_mime_type);

		$wordpress_upload_dir = wp_upload_dir();
		$new_file_path = $wordpress_upload_dir['path'] . '/' .$user_id.'_audio_'.time().'.'.$audio_ext;

		if( file_put_contents($new_file_path , $data ) ) {

			$upload_id = wp_insert_attachment( array(
				'guid'           => $new_file_path, 
				'post_mime_type' => $audio_mime_type,
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $user_id.'_audio_'.time().'.'.$audio_ext),
				'post_content'   => '',
				'post_status'    => 'inherit'
			), $new_file_path );
		
		}

		if((!is_wp_error($upload_id)) || ($upload_id !== 0)){		
		
			$row = array(
				'audio_file' => $upload_id,
				'audio_title' => $audio_title,
				'audio_description' => $audio_description
				);
			$success = add_row('audios', $row, 'user_'.$user_id);			
			
			if($success){
				echo json_encode(array('status' => 'success','msg' => "Success"));
				exit();	
			}else{
				echo json_encode(array('status' => 'danger','msg' => "Upload Failed"));
				exit();	
			}			
		}
		echo json_encode(array('status' => 'danger','msg' => "Something went wrong"));
		exit();	
	}else{
		echo json_encode(array('status' => 'danger','msg' => "Please enter audio file"));
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
            echo json_encode(array('status' => 'success','msg' =>  'Success' ));
            exit();	
        }else{
            echo json_encode(array('status' => 'danger','msg' => 'Edit failed' ));
            exit();	
        }		
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong'));
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
            echo json_encode(array('status' => 'success','msg' =>  'Success' ));
            exit();	
        }else{
            echo json_encode(array('status' => 'danger','msg' => 'Delete failed' ));
            exit();	
        }
		echo json_encode(array('status' => 'danger','msg' => 'Something went wrong'));
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