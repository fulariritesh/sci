<?php
/*
Template Name: Discover Talent
*/
?>

 <?php get_header(); ?>
 <div class="bodyBG">


    <section class="container-fluid findtalent-topbar">
    <div class="container px-0 ">
      <div class="row">
        <div class="col-8 pt-3">
          <!-- Nav tabs -->
          <ul class="nav findtalent-tabs">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="">Find Talent</a>
            </li>
          </ul>
        </div>
        <div class="col-4 pt-3 scibreadcrumb">
          <ul class="nav float-right">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="#category-search">All Categories</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="tab-content">
        <div class="tab-pane container active category-search p-3" id="category-search">
          <h5 class="text-uppercase">All Categories</h5>
          <div class="row m-0">

          <?php
                function sci_show_authors_in_categories() {

                    $categories = get_terms(array(
                        'taxonomy' => 'talent-categories',
                        'hide_empty' => false
                    ));
                    
                    foreach( $categories as $category ) {
                        if($category->parent == 0){
                            ?>
                                <div class="col-6 col-lg-3 mb-2  px-0">
                                <div class="row mx-1 shadow-sm ">
                                    <div class="col-4 py-2"><img src="http://localhost:8080/wordpress/wp-content/uploads/2021/01/icon-dancers.png" alt="Actors Category" /></div>
                                    <div class="col-8 py-2 px-0">
                                    <span class="text-uppercase d-block"><?php echo $category->name?></span>
                                    <span class="d-block cat-num">(<?php echo $category->count?>)</span>
                                    </div>
                                </div>
                                </div>
                            <?php
                        }
                    }
                }

                sci_show_authors_in_categories();
            ?>

            

          </div>
        </div>

        <div class="searchFilters mt-2">
          <div class="p-3 d-block d-md-none">
            <span class="d-block d-md-none float-left">Advance Filter</span>
            <button class="btn btn-primary btn-sm d-block d-md-none float-right" type="button" data-toggle="collapse"
              data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-filter"></i>
            </button>
            <div class="clear"></div>
          </div>

          <div class="searchparam shadow-sm collapse dont-collapse-sm show" id="collapseExample">
            <div class=" row well px-3">
              <!-- Collapse Panel -->
              <div class="col-12 col-sm-6 col-md-3 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3"> <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select></div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <input type="text" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="searchResults my-3">
    <div class="container noResults shadow-sm">
      <div class="col-sm-12 row mx-auto p-4">
        <div class="col-12 col-sm-6 text-right"><img src="./images/noProfilesFound.jpg" alt="No profile found" /></div>
        <div class="col-12 col-sm-6">
          <h4>No Profiles found from Pondicherry</h4>
          <h6>Explore other locations nearby for your requirements</h6>
          <h6 class="pt-2">If you want to showcase your talent from this location</h6>
          <button class="btn btn-lg btn-primary">Join Now</button>
        </div>
      </div>
    </div>

    <div class="container resultlisting my-4">
      <div class="row">
        <div class="col-6 px-0">Showcasing India’s Talent Nationwide</div>
        <div class="col-6 px-0 text-right">Showing <span class="showingCount">0</span> of <span class="totalCount">0</span> Results</div>
      </div>
      <div class="row py-3 displayList">
        
                
      </div>
      <div class="loadMore text-center py-3"><button class="loadMore btn btn-md btn-full btn-primary px-5">Load More</button></div>
    </div>
  </section>
</div>
    
<?php get_footer(); ?>






























<!-- <div class="row">
		<div class="col-sm-12">
            <?php
                function sci_list_talents() {
                    global $wpdb;

                    $results = $wpdb->get_results( "SELECT u.ID as id, u.user_nicename, p.guid as profile_url, GROUP_CONCAT( DISTINCT t.name ORDER BY t.name SEPARATOR':') as category
                                        ,m2.meta_key as meta_key2, m2.meta_value as user_location FROM $wpdb->users u
                                        LEFT JOIN $wpdb->usermeta m1 ON m1.user_id = u.id
                                        LEFT JOIN $wpdb->usermeta m2 ON m2.user_id = u.id
                                        LEFT JOIN $wpdb->posts p ON p.ID = m1.meta_value
                                        LEFT JOIN $wpdb->term_relationships tr ON tr.object_id = u.ID
                                        LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                                        LEFT JOIN $wpdb->terms t ON t.term_id = tt.term_id
                                        WHERE m1.meta_key = 'sci_user_avatar' AND m2.meta_key = 'location'
                                        GROUP BY id, user_nicename, profile_url
                                        LIMIT 3
                                        OFFSET 1
                    " );
                    


                    if ( ! empty( $results ) ) {
                        foreach ( $results as $user ) {
                            echo '<p>' . $user->id .' '. $user->user_nicename  .' '. $user->profile_url.' '. $user->user_location  .' '. $user->category .'</p>';
                            
                        }
                    } else {
                        echo 'No matching talents found.';
                    }
                }

                sci_list_talents();
            ?>
		</div> 
    </div> -->