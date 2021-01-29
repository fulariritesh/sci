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
            <span class="d-block d-md-none float-left">Advance Filter</span>
            <button class="btn btn-primary btn-sm d-block d-md-none float-right" type="button" data-toggle="collapse"
              data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-filter"></i>
            </button>
            <div class="clear"></div>
          </div>

          <div class="searchparam shadow-sm collapse dont-collapse-sm " id="collapseExample">
            <div class=" row well px-3">
              <!-- Collapse Panel -->
              <div class="col-12 col-sm-6 col-md-3 py-3">
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
              <div class="col-12 col-sm-6 col-md-2 py-3"> 
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
              <div class="col-12 col-sm-6 col-md-2 py-3">
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
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option value="-1" <?php echo ($selected == "-1")?  'selected="selected"' : '' ?>>Experience</option>
                  <option value="value1" <?php echo ($selected == "value1")?  'selected="selected"' : '' ?>>A</option>
                  <option value="value2" <?php echo ($selected == "value2")?  'selected="selected"' : '' ?>>B</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <button class="btn btn-md btn-primary form-control" id="advance-search">Search</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="searchResults my-3">

    <div class="container" id="no-search-results">
      <div class="row noResults  p-0 shadow-sm ">
        <div class="col-6 col-sm-6 text-right pt-3"><img src="http://localhost:8080/wordpress/wp-content/uploads/2021/01/noProfilesFound.jpg" alt="No profile found" class="img-fluid" /></div>
        <div class="col-6 col-sm-6 p-3">
          <h4>No Profiles found from Pondicherry</h4>
          <h6>Explore other locations nearby for your requirements</h6>
          <h6 class="pt-1 pt-sm-2">If you want to showcase your talent from this location</h6>
          <?php
            $page_object = get_page_by_path( 'join-now' );
            $page_id = $page_object->ID;
            $permalink = get_permalink( $page_id );
          ?>
          <a href=<?php echo $permalink ?> title="Join Now" class="btn btn-sm btn-primary">Join Now</a> 
        </div>
      </div>
    </div>

    <div class="container resultlisting my-4">
      <div class="row">
      <div class="col-6 px-md-0">Showcasing India’s Talent Nationwide</div>
        <div class="col-6 px-md-0 text-right"><span class="totalCount">0</span> Results</div>
      </div>
      <div class="row py-3 displayList">
        
                
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