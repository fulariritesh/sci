<?php 
 $completionPercent = 0;

 $obj_id = wp_get_current_user()->data->ID;
 $data = get_user_meta($obj_id);
 $user_info = get_userdata($obj_id);

 $assigned_weightages = get_field('sci_field_weightage', 'option');
 $categoriesrequiringAttributesObj = get_field('sci_physical_attributes_mandatory_for', 'option');
 $categoriesrequiringAttributes = array();
 $isModeratorApprovalRequired = get_field('sci_moderator_approval_required', 'option'); 

 $mainCategories = array();
 $weightage_basic_information;
 $weightage_main_categories;
 $weightage_sub_categories;
 $weightage_headshot;
 $weightage_intro_to_camara;
 $weightage_self_summary;
 $weightage_minimum_photos;
 $weightage_physical_attributes;
 $weightage_category_outline;

 $attribute_checked;
 $attribute_count = 0;

 foreach($categoriesrequiringAttributesObj as $key => $value){
    array_push($categoriesrequiringAttributes, $value->term_id);
 }
 
 
 foreach($assigned_weightages as $key => $value){

    $fieldName = $value["field_name"];
    $fieldWeightage = $value["weightage"];
    
    if( $fieldName == 'basic_information'){
        $weightage_basic_information = (int)$fieldWeightage;
    }else if( $fieldName == 'main_categories'){
        $weightage_main_categories = (int)$fieldWeightage;
    }else if( $fieldName == 'sub_categories'){
        $weightage_sub_categories = (int)$fieldWeightage;
    }else if( $fieldName == 'headshot'){
        $weightage_headshot = (int)$fieldWeightage;
    }else if( $fieldName == 'intro_to_camara'){
        $weightage_intro_to_camara = (int)$fieldWeightage;
    }else if( $fieldName == 'self_summary'){
        $weightage_self_summary = (int)$fieldWeightage;
    }else if( $fieldName == 'minimum_photos'){
        $weightage_minimum_photos = (int)$fieldWeightage;
    }else if( $fieldName == 'physical_attributes'){
        $weightage_physical_attributes = (int)$fieldWeightage;
    }else if( $fieldName == 'category_outline'){
        $weightage_category_outline = (int)$fieldWeightage;
    }
 }


 if($user_info->data){
    foreach($user_info->data as $key => $value){
        if($key == "display_name"){
            $isApproved = $isModeratorApprovalRequired? get_user_meta( $user_info->data->ID, 'basic_details_are_approved', true ) : 1;
            if(!empty($value) && $isApproved){
                $completionPercent += $weightage_basic_information;
            }
        }
    }
}


foreach($data as $key => $value){
    if($key == 'profession'){

        $subcategoryWeightage = $weightage_sub_categories;  

        if (get_field('profession', 'user_' . $obj_id)){
            
            $subCategories = array();

            foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
                
                if($key->parent == 0){
                    array_push($mainCategories, $key->term_id);
                }else{
                    if(!in_array($key->parent, $subCategories, true)){
                        array_push($subCategories, $key->parent);
                    }
                }
            }

            $singlesubcategoryWeightage;  
            if($mainCategories && count($mainCategories) > 0){
                $completionPercent += $weightage_main_categories; 

                $singlesubcategoryWeightage = $subcategoryWeightage / count($mainCategories);
                $completionPercent += round(count($subCategories) * $singlesubcategoryWeightage);
            }
        }
        
    }else if($key == 'intro_to_camera'){
        $isApproved = $isModeratorApprovalRequired? get_user_meta( $user_info->data->ID, 'intro_to_camera_is_approved', true ) : 1;
        
        if(!empty($value[0]) && $isApproved){
            $completionPercent += $weightage_intro_to_camara;
        }
    }else if($key == 'intro_text'){
        $isApproved = $isModeratorApprovalRequired? get_user_meta( $user_info->data->ID, 'intro_text_is_approved', true ) : 1;
        if(!empty($value[0]) && $isApproved){
            $completionPercent += $weightage_self_summary;
        }
    }else if($key == 'photos'){
        $allApprovedPhotos = maybe_unserialize( $value[0] );

        if($isModeratorApprovalRequired && $allApprovedPhotos){

            foreach($allApprovedPhotos as $key => $value){
               
                $isThisPhotoApproved = get_post_meta( $value, 'is_approved', true );
                
                if(!$isThisPhotoApproved){
                    unset($allApprovedPhotos[$key]);
                }
            }
            
        }
        
        if($allApprovedPhotos && count($allApprovedPhotos) >= 3){
            $completionPercent += $weightage_minimum_photos;
        };
    }else if(!$attribute_checked && ($key == 'sci_user_eye_color' || $key == 'sci_user_skin_color' || $key == 'sci_user_chest_in' || $key == 'sci_user_weight_kg' || $key == 'sci_user_height_ft')){
        

        if(!empty(array_intersect($mainCategories, $categoriesrequiringAttributes))){

            if(!empty($value[0])){
                $attribute_count += 1;
            }

            $isApproved = $isModeratorApprovalRequired? get_user_meta( $user_info->data->ID, 'physical_attributes_are_approved', true ) : 1;

            if($attribute_count == 5 && $isApproved){
                $attribute_checked = 1;
                $completionPercent += $weightage_physical_attributes;
            }
        }
    }

}


if(get_field('sci_user_headshots','user_'.$obj_id)){
    $approvedHeadshotCount;
    foreach(get_field('sci_user_headshots','user_'.$obj_id) as $headShot){
        $image = $headShot["sci_user_headshot"];

        if(!empty($image) && !$approvedHeadshotCount){
            $isApproved = $isModeratorApprovalRequired? get_post_meta( (int)$image["ID"], 'is_approved', true ) : 1;

            if($isApproved){
                
                $approvedHeadshotCount += 1;
                $completionPercent += $weightage_headshot;
                
            }
            
        }
    }
}


if($mainCategories && !$attribute_checked && empty(array_intersect($mainCategories, $categoriesrequiringAttributes))){
    $attribute_checked = 1;
    $completionPercent += $weightage_physical_attributes;
}


if(get_field('experience','user_'.$obj_id)){
    
    $experiencesApproved = 0;
    $weightagePerExperience = $mainCategories ? $weightage_category_outline/count($mainCategories) : 0;
    
    
    foreach(get_field('experience','user_'.$obj_id) as $experience){
        if($isModeratorApprovalRequired){
            if($experience["sci_experience_approved"]){
                $experiencesApproved += 1;
            }
            
        }else{
            if(count($experience["sections"]) > 0){
                $experiencesApproved += 1;
            }
            
        }
    }
    
    $completionPercent += round($experiencesApproved * $weightagePerExperience);
    
}

//var_dump($data);  


  
?>
<div class="row blockBG my-3 progressbar">
    <div class="col-sm-11 mx-auto text-center p-3">
    <h4 class="text-center font-weight-bold">
        Profile Completion: <span class="completevalue"><?php echo $completionPercent ?>%</span>
        <a href="#" data-toggle="tooltip" title="Hooray!"> <i class="fas fa-info-circle"></i></a>
    </h4>
        <p class="text-center">
        <?php 
            if($completionPercent >= 100){
                echo get_field('sci_complete_profile_message', 'option'); 
            }else if($completionPercent <= 0){
                echo get_field('sci_blank_profile', 'option'); 
            }else{
                echo get_field('sci_incomplete_profile_message', 'option'); 
            }
            
        ?>
        <!-- Good job! Keep adding to your profile to improve it further.  -->
        </p>
    <div class="progress pr-com-bar">
        <div
            class="progress-bar"
            role="progressbar"
            style="width: <?php echo $completionPercent ?>%"
            aria-valuenow="<?php echo $completionPercent ?>"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
        </div>
    </div>
</div>
