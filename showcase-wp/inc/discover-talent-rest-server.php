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

    $base      = 'sub-categories-data';
    register_rest_route( $namespace, '/' . $base, array(
      array(
          'methods'         => WP_REST_Server::READABLE,
          'callback'        => array( $this, 'get_sub_categories_data' )
        )
    ));
  }
 
  public function hook_rest_server(){
    add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

 
  public function get_talent_data( WP_REST_Request $request ){
    $pageNumber = $request->get_param( 'pageNumber' );
    $pageSize = $request->get_param( 'pageSize' );

    $limit = (int)$pageSize;
    $offset = ($pageNumber -1) * $pageSize; 
    
    $args = array(
        'role'          => 'subscriber',
        'number'        => $limit,
        'meta_key'      => 'profession',
        'meta_value'    => array(''),
        'meta_compare'  => 'NOT IN',
        'orderby'       => 'user_registered',
        'order'         => 'DESC',
        'offset'        => $offset,
        'fields'        => array( 'ID','display_name' )
    );
    $userList = get_users($args);
 
    if( empty( $userList ) ){
    return null;
    }
 

    foreach($userList as $user){
        $user->href = "/wordpress/profile/" . $user->ID;
        $user->headshot = get_field('sci_user_headshot', 'user_' . $user->ID);
        $user->location = get_field('sci_user_location', 'user_' . $user->ID);

        $termIds = get_user_meta($user->ID, 'profession',true);

        $userProfessions = get_terms( array(
            'include'       => $termIds,
            'hide_empty'    => false,
            'parent'        => 0,
            'fields'        => 'ids'
        ) );

        $user->professions = array();
        foreach($userProfessions as $profession){
            array_push($user->professions, get_term_meta( $profession, 'category_name_singular', true ));
        }
        
    }
    
    $data = new stdClass();
    $data->userList = array($userList);

    if($pageNumber == 1){
        $args = array(
            'role'          => 'subscriber',
            'meta_key'      => 'profession',
            'meta_value'    => array(''),
            'meta_compare'  => 'NOT IN',
            'orderby'       => 'user_registered',
            'order'         => 'DESC',
            'fields'        => array( 'ID')
        );

        $data->totalCount = count(get_users($args));

        $categoriesFound = get_terms( array(
            'taxonomy'      => 'jobs',
            'hide_empty'    => false,
            'parent'        => 0,
            'fields'        => 'id=>name'
        ) );

        $categories = array();
        foreach($categoriesFound as $key => $value){
            $category = new stdClass();
            $category->id = $key;
            $category->name = $value;
            $category->image = get_field('sci_category_image', 'jobs_' . $key);

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
            ],
          );
          $category->count = count(get_users($args));

          array_push($categories, $category);
        }

        $data->categories = $categories;
    }

    return $data;
  }

  public function get_sub_categories_data( WP_REST_Request $request ){
    $pageNumber = $request->get_param( 'pageNumber' );
    $pageSize = $request->get_param( 'pageSize' );
    $categoryId = $request->get_param( 'category' );
    $categoryIds = explode(",", $request->get_param( 'category' ));  

    $limit = (int)$pageSize;
    $offset = ($pageNumber -1) * $pageSize; 
    


    $meta_queries = array( 'relation' => 'OR' );

    foreach ( $categoryIds as $category ) {
        $meta_query = array( 'key' => 'profession', 'value' => sprintf(':"%s";', $category) , 'compare' => 'LIKE');
        array_push($meta_queries, $meta_query);
    }

    $args = array(
        'role'          => 'subscriber',
        'number'        => $limit,
        'orderby'       => 'user_registered',
        'order'         => 'DESC',
        'offset'        => $offset,
        'fields'        => array( 'ID','display_name' ),
        'meta_query'     => [
          'relation' => 'AND',
          array(
              'key'     => 'profession',
              'value'   => array(''),
              'compare' => 'NOT IN',
          ),
          $meta_queries
      ],
    );
    $userList = get_users($args);
 
    if( empty( $userList ) ){
      return null;
    }
 

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
            array_push($user->professions, get_term_meta( $profession, 'category_name_singular', true ));
        }

        $user->href = "/wordpress/profile/" . $user->ID;
        $user->headshot = get_field('sci_user_headshot', 'user_' . $user->ID);
        $user->location = get_field('sci_user_location', 'user_' . $user->ID);  
    }
    
    $data = new stdClass();
    $data->userList = array($userList);

    if($pageNumber == 1){
        $totalUsersArgs = array(
            'role'          => 'subscriber',
            'orderby'       => 'user_registered',
            'order'         => 'DESC',
            'fields'        => array( 'ID','display_name' ),
            'meta_query'     => [
              'relation' => 'AND',
              array(
                  'key'     => 'profession',
                  'value'   => array(''),
                  'compare' => 'NOT IN',
              ),
              $meta_queries
          ],
        );

        $totalUsers = get_users($totalUsersArgs);
        
        $data->totalCount = count($totalUsers);

        $categoriesFound = get_terms( array(
            'taxonomy'      => 'jobs',
            'hide_empty'    => false,
            'parent'        => $categoryId,
            'fields'        => 'id=>name'
        ) );

        $subcategories = array();
        foreach($categoriesFound as $key => $value){
            $category = new stdClass();
            $category->id = $key;
            $category->name = $value;
            $category->image = get_field('sci_category_image', 'jobs_' . $key);
            
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
            ],
          );
          $category->count = count(get_users($args));

            array_push($subcategories, $category);
        }

        $data->subcategories = $subcategories;
    }

    return $data;
  }
 
}
 
$discover_talent_rest_server = new Discover_Talent_Rest_Server();
$discover_talent_rest_server->hook_rest_server();

?>