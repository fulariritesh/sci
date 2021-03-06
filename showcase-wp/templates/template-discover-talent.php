<?php
/*
Template Name: Discover Talent
*/
?>

 <?php get_header(); 
 
$locationSelected;
$genderSelected;
 ?>
 <div class="bodyBG">


 <section class="container-fluid findtalent-topbar">
    <div class="container px-0 ">
      <div class="row">
        <div class="col-6 col-sm-8 pt-3">
          <!-- Nav tabs -->
          <ul class="nav findtalent-tabs">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="">Find Talent</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-sm-4 pt-3 scibreadcrumb">
          <ul class="nav float-right">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="#category-search" id="AllCategories">All Categories</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="tab-content">
        <div class="tab-pane container active category-search p-3" id="category-search">
          <div class="FT-allcategories" id="FT-allcategories">
          <h5 class="text-uppercase">All Categories</h5>
          <div class="row m-0 category-blocks">
            
          </div>
          </div>
          <div class="FT-subcategories" id="FT-subcategories">
            <h5 class="text-uppercase" id="subcategory-type"></h5>
            <div class="row m-0 sub-category-blocks">
           
            </div>
            </div>
        </div>

        <div class="searchFilters mt-2">
          <div class="p-3 d-block d-md-none">
            <span class="d-block d-md-none float-left pt-2">Advance Filter</span>
            <button class="btn btn-primary btn-sm d-block d-md-none float-right pb-1" type="button" data-toggle="collapse"
              data-target="#collapseAdvance" aria-expanded="false" aria-controls="collapseAdvance">
              <i class="fas fa-filter"></i>
            </button>
            <div class="clear"></div>
          </div>

          <div class="searchparam shadow-sm collapse dont-collapse-sm " id="collapseAdvance">
            <div class=" row well px-3">
              <!-- Collapse Panel -->
              <div class="col-12 col-sm-6 col-md-4 py-1 py-md-3 px-3 pr-md-0">
               
                <select placeholder="Select Location" class="form-control" id="loaction">
                  <option value="-1">Select Location</option>
                  <?php
                    $loactions = get_acf_field_settings_from_group("USER: Profile details", 'sci_user_location')['choices'];
                    
                    foreach($loactions as $key => $value){
                      ?>
                        <option value=<?php echo $key ?>><?php echo $value ?></option>
                      <?php
                    }
                  ?>
                </select>
                 
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-1 py-md-3 px-3 pr-md-0"> 
              
                <select placeholder="Select Gender" class="form-control" id="gender">
                  <option value="-1">Gender</option>
                  <?php
                    $genders = get_acf_field_settings_from_group("USER: Profile details", 'sci_user_gender')['choices'];
                    
                    foreach($genders as $key => $value){
                      ?>
                        <option value=<?php echo $key ?>><?php echo $value ?></option>
                      <?php
                    }
                  ?>
                </select></div>
              <div class="col-12 col-sm-6 col-md-2 py-1 py-md-3 px-3 pr-md-0">
              
                <select placeholder="Select Location" class="form-control" id="age">
                  <option value="-1">Age</option>
                  <?php
                    $ageGroups = get_acf_field_settings_from_group("SETTINGS: discover talent", 'sci_age_groups')['choices'];
                    
                    foreach($ageGroups as $key => $value){
                      ?>
                        <option value=<?php echo $key ?>><?php echo $value ?></option>
                      <?php
                    }
                  ?>
                </select>
                  
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-1 py-md-3 px-3 pr-md-0">
              
                <select placeholder="Select Location" class="form-control">
                  <option value="-1">Experience</option>
                  <option value="value1">A</option>
                  <option value="value2">B</option>
                </select>
                  
              </div>
              <div class="col-12 col-sm-12 col-md-2 py-1 pb-3 py-md-3 text-right text-md-left">
                <button class="btn btn-sm btn-add px-2" id="advance-search">Search</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="searchResults mt-3">

    <div class="container" id="no-search-results">
      <div class="row noResults  p-0 shadow-sm ">
        <div class="col-6 col-sm-6 text-right pt-3"><img src=<?php the_field('sci_no_result_image', 'option'); ?> alt="No profile found" class="img-fluid" /></div>
        <div class="col-6 col-sm-6 p-3">
          <?php
            echo the_field('sci_no_result_text', 'option');
          ?>
          <?php
            $page_object = get_page_by_path( 'join-now' );
            $page_id = $page_object->ID;
            $permalink = get_permalink( $page_id );
          ?>
          <a href=<?php echo $permalink ?> title="Join Now" class="btn btn-sm btn-primary">Join Now</a> 
        </div>
      </div>
    </div>

    <div class="container resultlisting py-4">
      <div class="row px-3 px-lg-0">
      <div class="col-6 px-0 px-md-0">Showcasing India’s Talent Nationwide</div>
      <div class="col-6 px-0 px-md-0 text-right"><span class="totalCount">0</span> Results</div>
      </div>
      <div class="row py-3 px-3 px-lg-0 displayList">
        
                
      </div>
      <div class="loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Load More</button></div>
    </div>
  </section>
</div>
    
<?php get_footer(); ?>


<?php

function get_acf_field_settings_from_group($field_group, $field){
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