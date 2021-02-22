<?php 
add_action("wp_ajax_search", "search_callback");

$totalUserList = array();
function search_callback() {
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "sitewide_search")) {
      exit("No naughty business please");
   }   

   $search_string = $_REQUEST["searchString"];
   $offset = $_REQUEST["offset"];
   $rejectOffset = $_REQUEST["rejectOffset"];
   $pageSize = $_REQUEST["pageSize"]; 
   $findRejected = $_REQUEST["findRejected"];


   $data = new stdClass();  
   $data->totalCount = 0;
   
    

    $totalUserList = array();
    $lastMatch_userID = GetList(0, 1, false, true)[0]->ID;


    $fetchMore = true;


    if((bool)$findRejected){
        do{
            
            $userList = GetList($offset, $pageSize, false, false);

            if(!empty($userList)){
                foreach($userList as $user){

                    $offset = (int)$offset + 1;
                    
                    $UserData  = get_user_meta($user->ID);
                    
                    foreach($UserData as $key => $value){
    
                        if((strpos(strtolower($key), strtolower('content_log')) !== false) || (substr(strtolower($key),0,1) == "_")){
                            continue;
                        }
    
                        if($key == 'sci_user_gender'){
                        
                            if(strtolower($value[0]) == strtolower($search_string)){
                                if(!in_array($user,$totalUserList )){
                                    array_push($totalUserList, $user );
                                    break;
                                }
                            }
                            
                            
                        }else if($key == 'sci_user_location'){
                            $locations = get_acf_values_from_group("USER: Profile details", 'sci_user_location')['choices']; 
                            foreach($locations as $locationKey => $location){
                                if(strtolower($location) == strtolower($search_string)){
                                    if($locationKey == $value[0]){
                                        if(!in_array($user,$totalUserList )){
                                            array_push($totalUserList, $user );
                                            break;
                                        }
                                    }
                                }
                            }
                        }else if($key == 'profession'){
                            if ( is_serialized( $value[0] ) ) {
                                $categories = maybe_unserialize($value[0]);
                                foreach($categories as $category){
                                    if(strtolower(get_term_meta( $category, 'category_name_singular', true )) == strtolower($search_string)){
                                        if(!in_array($user,$totalUserList )){
                                            array_push($totalUserList, $user );
                                            break;
                                        }
                                    };
                                }
                            }
                        }else if(strpos(strtolower($value[0]), strtolower($search_string)) !== false){
                            if(!in_array($user,$totalUserList )){
                                array_push($totalUserList, $user );
                                break;
                            }
                        }
    
                    }
    
    
                    if($lastMatch_userID == null || $user->ID == $lastMatch_userID || count($totalUserList) >= $pageSize){
                        
                        if($lastMatch_userID == null || $user->ID == $lastMatch_userID){
                            $data->findRejected = true;
                        }
                        
                        $fetchMore = false; 
                        break; 
                    }
        
                }
            }else{
                $data->isLast = true;
                $fetchMore = false;
            }
           

        }while($fetchMore);
    }

    

    if(count($totalUserList) < $pageSize){
        $fetchMore = true;
        $lastMatch = GetList(0, 1, true, true);

        if(!empty($lastMatch)){
            $lastMatch_userID = $lastMatch[0]->ID;

            do{
            
                $userList = GetList($rejectOffset, $pageSize, true, false);
    
                foreach($userList as $user){
    
                    $rejectOffset = (int)$rejectOffset + 1;
                    
                    $UserData  = get_user_meta($user->ID);
                    
                    foreach($UserData as $key => $value){
    
                        if(strpos(strtolower($key), strtolower('content_log')) !== false){
                            break;
                        }
    
                        if($key == 'sci_user_gender'){
                        
                            if(strtolower($value[0]) == strtolower($search_string)){
                                if(!in_array($user,$totalUserList )){
                                    array_push($totalUserList, $user );
                                    break;
                                }
                            }
                            
                            
                        }else if($key == 'sci_user_location'){
                            $locations = get_acf_values_from_group("USER: Profile details", 'sci_user_location')['choices']; 
                            foreach($locations as $locationKey => $location){
                                if(strtolower($location) == strtolower($search_string)){
                                    if($locationKey == $value[0]){
                                        if(!in_array($user,$totalUserList )){
                                            array_push($totalUserList, $user );
                                            break;
                                        }
                                    }
                                }
                            }
                        }else if($key == 'profession'){
                            if ( is_serialized( $value[0] ) ) {
                                $categories = maybe_unserialize($value[0]);
                                foreach($categories as $category){
                                    if(strtolower(get_term_meta( $category, 'category_name_singular', true )) == strtolower($search_string)){
                                        if(!in_array($user,$totalUserList )){
                                            array_push($totalUserList, $user );
                                            break;
                                        }
                                    };
                                }
                            }
                        }else if(strpos(strtolower($value[0]), strtolower($search_string)) !== false){
                            if(!in_array($user,$totalUserList )){
                                array_push($totalUserList, $user );
                                break;
                            }
                        }
    
                    }
    
                    if($lastMatch_userID == null || $user->ID == $lastMatch_userID || count($totalUserList) >= $pageSize){
                        if($lastMatch_userID == null || $user->ID == $lastMatch_userID){
                            $data->isLast = true;
                        }
                        $fetchMore = false; 
                        break; 
                    }
        
                }           
    
            }while($fetchMore);
        }else{
            $data->isLast = true;
        }
        
    }


    $data->offset = $offset;
    

    if(!empty($totalUserList)){
        $data->totalCount = count($totalUserList);
        foreach($totalUserList as $user){

            $termIds = get_user_meta($user->ID, 'profession',true);
        
            $userProfessions = get_terms( array(
                'include'       => $termIds,
                'hide_empty'    => false,
                'parent'        => 0,
                'fields'        => 'ids'
            ) );

            $user->professions = array();
            foreach($userProfessions as $profession){
                $professionDetails = new stdClass();
                $professionDetails->singularName = get_term_meta( $profession, 'category_name_singular', true );
                $professionDetails->badgeColour = get_term_meta( $profession, 'badge_color', true );

                array_push($user->professions, $professionDetails);
            }

            $user->href = get_author_posts_url($user->ID);
            
            $user->headshot = home_url() . "/wp-content/uploads/2021/02/unkown-1.jpg";
            if( have_rows('sci_user_headshots', 'user_' . $user->ID) ): ;
            while ( have_rows('sci_user_headshots', 'user_' . $user->ID) ) : the_row();
                $imageId = get_sub_field('sci_user_headshot');
                if(get_post_meta( $imageId['id'], 'is_approved', true )){
                    $user->headshot =  $imageId['url'];
                    break;
                }
            endwhile;
            endif;
            
            $user->location = get_field('sci_user_location', 'user_' . $user->ID)['label'];  
        }
    
        $data->userList = array($totalUserList);
    }

   echo json_encode($data);

   wp_die();

}

function GetList($offset, $pageSize, $rejected, $findTotal){
    $meta_query = array('relation' => 'AND' , array(
        'key'     => 'profession',
        'value'   => array(''),
        'compare' => 'NOT IN',
        ),
        array(
            'key'     => 'profile_visibility_status',
            'value'   => 1,
            'compare' => '=',
        ),
        array(
            'key'     => 'profile_status',
            'value'   => "Pending",
            'compare' => '!=',
        )
    );
    
    if($rejected){
        array_push($meta_query, array(
            'key'     => 'profile_status',
            'value'   => "Rejected",
            'compare' => '=',
        ));
    }else{
        array_push($meta_query, array(
            'key'     => 'profile_status',
            'value'   => "Rejected",
            'compare' => '!=',
        )); 
    }


    $args = array(
        'role'          => 'subscriber',
        'number'        => $findTotal? 1 : $pageSize,
        'orderby'       => 'user_registered',
        'order'         => $findTotal? 'ASC':'DESC',
        'offset'        => $findTotal? 0: $offset,
        'fields'        => array( 'ID','display_name' ),
        'meta_query'    => $meta_query
    );

        return get_users($args);
   }


   function get_acf_values_from_group($field_group, $field){
    $raw_field_groups = acf_get_raw_field_groups();
    foreach ($raw_field_groups as $key => $value) {
        if ($value["title"] == $field_group) {
            foreach (acf_get_fields($value['key']) as $key => $value) {
                if ($value['name'] == $field) {
                    return $value;
                }
            }
        }
    }
  }
?>