<?php
add_action("wp_ajax_sci_edit_physical_attributes", "sci_edit_physical_attributes");
function sci_edit_physical_attributes() {
	$user_id = get_current_user_id();
    $upload_id = NULL;
    $i = 0;
    
   	if(!wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
		echo json_encode(array('status' => 'danger','msg' => "No naughty business please"));
      	exit();
    }
      
    if(!empty($_REQUEST["sci_user_height_ft"])){
        $success = update_field('sci_user_height_ft', sanitize_text_field($_REQUEST["sci_user_height_ft"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_height_ft', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_height_ft', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_height_in"])){
        $success = update_field('sci_user_height_in', sanitize_text_field($_REQUEST["sci_user_height_in"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_height_in', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_height_in', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_weight_kg"])){
        $success = update_field('sci_user_weight_kg', sanitize_text_field($_REQUEST["sci_user_weight_kg"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_weight_kg', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_weight_kg', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_eye_color"])){
        $success = update_field('sci_user_eye_color', sanitize_text_field($_REQUEST["sci_user_eye_color"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_eye_color', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_eye_color', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_skin_color"])){
        $success = update_field('sci_user_skin_color', sanitize_text_field($_REQUEST["sci_user_skin_color"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_skin_color', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_skin_color', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_chest_in"])){
        $success = update_field('sci_user_chest_in', sanitize_text_field($_REQUEST["sci_user_chest_in"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_chest_in', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_chest_in', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_waist_in"])){
        $success = update_field('sci_user_waist_in', sanitize_text_field($_REQUEST["sci_user_waist_in"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_waist_in', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_waist_in', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_hair_length"])){
        $success = update_field('sci_user_hair_length', sanitize_text_field($_REQUEST["sci_user_hair_length"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_hair_length', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_hair_length', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_hair_color"])){
        $success = update_field('sci_user_hair_color', sanitize_text_field($_REQUEST["sci_user_hair_color"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_hair_color', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_hair_color', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_hair_type"])){
        $success = update_field('sci_user_hair_type', sanitize_text_field($_REQUEST["sci_user_hair_type"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_hair_type', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_hair_type', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }

    if(!empty($_REQUEST["sci_user_ethnicity"])){
        $success = update_field('sci_user_ethnicity', sanitize_text_field($_REQUEST["sci_user_ethnicity"]), 'user_'.$user_id);
        if($success){ 
            $i++;
        }  
    }else{
        $field_exist = get_field('sci_user_ethnicity', 'user_'.$user_id);
        if($field_exist){
            $success = delete_field('sci_user_ethnicity', 'user_'.$user_id);
            if($success){ 
                $i++;
            }
        }
    }


    
    echo json_encode(array('status' => 'success','msg' => $i.' physical attributes updated!'));
	exit();   

    wp_die();
}

