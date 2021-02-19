<?php
 
class Discover_Talent_Rest_Server extends WP_REST_Controller {
 
  var $my_namespace = 'sci/v';
  var $my_version   = '1';
 
  public function register_routes() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'talent-data';
    register_rest_route( $namespace, '/' . $base, array(
      array(
          'methods'         => WP_REST_Server::READABLE,
          'callback'        => array( $this, 'get_talent_data' )
        )
    ));
  }
 
  public function hook_rest_server(){
    add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  public function get_talent_data( WP_REST_Request $request ){
    $pageNumber = $request->get_param( 'pageNumber' );
    $pageSize = $request->get_param( 'pageSize' );

    $location = $request->get_param( 'location' );
    $gender = $request->get_param( 'gender' );
    $age = $request->get_param( 'age' );


    $categoryId = $request->get_param( 'category' );
    $categoryIds = $categoryId? explode(",", $request->get_param( 'category' )) : ["0"];  

    $limit = (int)$pageSize;
    $offset = ($pageNumber -1) * $pageSize; 



    $meta_queries = array('relation' => 'AND' , array(
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
    ));

    
    
    if($categoryId){
      $meta_queries_profession = array( 'relation' => 'OR' );

      foreach ( $categoryIds as $category ) {
        $meta_query = array( 'key' => 'profession', 'value' => sprintf(':"%s";', $category) , 'compare' => 'LIKE');
        array_push($meta_queries_profession, $meta_query);
      }
      array_push($meta_queries, $meta_queries_profession);
    }

    if($location && $location != "-1"){
      array_push($meta_queries, array( 'key' => 'sci_user_location', 'value' => $location , 'compare' => '='));
    }

    if($gender && $gender != "-1"){
      if($gender == 'custom'){

        $genderChoices = get_acf_field_settings_from_group_sci("USER: Profile details", 'sci_user_gender')['choices'];
        $i=0; 
        foreach($genderChoices as $genderChoice){
          $i++;
          if($i < count($genderChoices)){
            array_push($meta_queries, array( 'key' => 'sci_user_gender', 'value' => str_replace(' ', '_', $genderChoice) , 'compare' => '!='));
          }
        }

      }else {
        array_push($meta_queries, array( 'key' => 'sci_user_gender', 'value' => $gender , 'compare' => '='));
      }
      
    }

    if($age && $age != "-1"){
      $age = explode('-', $age); 
      $min_year   = (int)date('Y') - (int)$age[1];
      $max_year  = (int)date('Y') - (int)$age[0];

      $year_regex = array();
      for($y = $min_year; $y < $max_year; $y++) {
          array_push($year_regex, strval($y));
      }
      
      array_push($meta_queries, array(
          'key'       => 'sci_user_dob',
          'value'     => '^('.implode('|', $year_regex).')[0-9]{2}[0-9]{2}$',
          'compare' => 'REGEXP'
      ));
    }
    
    $args = array(
        'role'          => 'subscriber',
        'number'        => $limit,
        'orderby'       => 'user_registered',
        'order'         => 'DESC',
        'offset'        => $offset,
        'fields'        => array( 'ID','display_name' ),
        'meta_query'    => $meta_queries
    );
    $userList = get_users($args);
    $data = new stdClass();

    if( !empty( $userList ) ){
      
 

      foreach($userList as $user){

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
          $user->accountIsActive =  get_user_meta($user->ID, 'profile_status',true) != "Rejected" ? 1 : 0;
      }
    
      
      $data->userList = array($userList);
      $data->result = 0;
      

      
    }else{
      $data = new stdClass();
      if(($location && $location != "-1") || ($gender && $gender != '-1') || ($age && $age != '-1')){
        $data->result = 1;
        
      }else{
        $data->result = 2;
        $data->text = get_field('sci_no_users_in_category', 'option');
        
      }
      
    }

      if($pageNumber == 1){
        $totalUsersArgs = array(
            'role'          => 'subscriber',
            'orderby'       => 'user_registered',
            'order'         => 'DESC',
            'fields'        => array( 'ID','display_name' ),
            'meta_query'     => $meta_queries
        );

        $totalUsers = get_users($totalUsersArgs);
        
        $data->totalCount = count($totalUsers);

        $categoriesFound = get_terms( array(
            'taxonomy'      => 'jobs',
            'hide_empty'    => false,
            'parent'        => $categoryId? $categoryId :0,
            'fields'        => 'id=>name'
        ) );

        $categories = array();
        foreach($categoriesFound as $key => $value){
            $category = new stdClass();
            $category->id = $key;
            $category->name = get_term_meta( $key, 'category_name', true );
            $category->image = get_field('sci_category_image', 'jobs_' . $key);
            $category->singularName = get_term_meta( $key, 'category_name_singular', true );
            
            $args = array(
              'role'          => 'subscriber',
              'orderby'       => 'user_registered',
              'order'         => 'DESC',
              'fields'        => array( 'ID','display_name' ),
              'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => 'profession',
                    'value'   => array(''),
                    'compare' => 'NOT IN',
                ],
                [
                    'key'     => 'profession',
                    'value'   => sprintf(':"%s";', $key),
                    'compare' => 'LIKE',
                ],
                [
                    'key'     => 'profile_visibility_status',
                    'value'   => 1, 
                    'compare' => '=',
                ],
                [
                    'key'     => 'profile_status',
                    'value'   => "Pending", 
                    'compare' => '!=',
                ]
            ],
          );
          $category->count = count(get_users($args));

            array_push($categories, $category);
        }
        
        $data->categories = $categories;
      }

      return $data;
  }
 
}
 
$discover_talent_rest_server = new Discover_Talent_Rest_Server();
$discover_talent_rest_server->hook_rest_server();



function get_acf_field_settings_from_group_sci($field_group, $field){
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