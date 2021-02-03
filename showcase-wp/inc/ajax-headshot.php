<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    http_response_code(400);
	echo json_encode(array('data' => 'Testing Ajax.'));
	exit();

    $user_id = get_current_user_id();
    $upload_id = NULL;
    
    if(isset($_POST['headshot'])){

		// delete previous old headshot
		$user_headshot_old = get_user_meta( $user_id, 'sci_user_headshot', true);
		if(($user_headshot_old !== false)){ 
			wp_delete_attachment(intval($user_headshot_old), true);
			delete_user_meta( $user_id, 'sci_user_headshot');
		}
	
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
			$success_headshot_1 = update_user_meta( $user_id, 'sci_user_headshot', $upload_id);
			
			http_response_code(200);
			echo json_encode(array('data' => $upload_id ));
			exit();		
		}

		http_response_code(500);
		echo json_encode(array('data' => 'Something went wrong.'));
		exit();		
		
	}else{
		http_response_code(400);
		echo json_encode(array('data' => 'Upload Error.'));
		exit();
	}
}