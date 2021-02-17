<?php
add_action("wp_ajax_sci_add_headshot", "sci_add_headshot");
function sci_add_headshot() {
	$user_id = get_current_user_id();
	$upload_id = NULL;

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "headshot_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(isset($_REQUEST["headshot"]) && isset($_REQUEST["index"])) {
    
		$success = false;
		$index = intval($_REQUEST["index"]);
		$data = $_POST['headshot'];
		$image_array_1 = explode(";", $data);
		$image_array_2 = explode(",", $image_array_1[1]);
		$data = base64_decode($image_array_2[1]);
		$wordpress_upload_dir = wp_upload_dir();
		$new_file_path = $wordpress_upload_dir['path'] . '/' .$user_id.'_'.time().'.png';

		if( file_put_contents($new_file_path , $data ) ) {

			$upload_id = wp_insert_attachment( array(
				'guid'           => $new_file_path, 
				'post_mime_type' => 'image/png',
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $user_id.'_'.time().'.png'),
				'post_content'   => '',
				'post_status'    => 'inherit'
			), $new_file_path );
		
			// wp_generate_attachment_metadata() won't work if you do not include this file
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		
			// Generate and save the attachment metas into the database
			wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );	
		}

		if((!is_wp_error($upload_id)) || ($upload_id !== 0)){
		
			if(have_rows('sci_user_headshots', 'user_' . $user_id)){
				$row = array('sci_user_headshot' => $upload_id);
				$success = update_row('sci_user_headshots', $index, $row, 'user_'.$user_id);
			}else{
				$row = array('sci_user_headshot' => $upload_id);
				$success = add_row('sci_user_headshots', $row, 'user_'.$user_id);
			}
			
			if($success){
				echo json_encode(array('status' => 'success','msg' => "Success."));
				exit();	
			}else{
				echo json_encode(array('status' => 'danger','msg' => "Upload Failed."));
				exit();	
			}			
		}
		echo json_encode(array('status' => 'danger','msg' => "Something went wrong."));
		exit();	
	}else{
		echo json_encode(array('status' => 'danger','msg' => "Bad Request :("));
		exit();
   	}
   	wp_die();
}

add_action("wp_ajax_sci_delete_headshot", "sci_delete_headshot");
function sci_delete_headshot() {
	$user_id = get_current_user_id();

   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
   	}   

   	if(!empty($_REQUEST["index"])) {
        $index = intval($_REQUEST["index"]);     
        $success = delete_row('sci_user_headshots', $index, 'user_'.$user_id);
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