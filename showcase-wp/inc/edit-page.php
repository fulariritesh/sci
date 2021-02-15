<?php 
add_action("wp_ajax_sci_change_name", "sci_change_name");

function sci_change_name() {
   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["name"]) {
      preg_match("/^([\w.]+) ?(.*)?$/", $_REQUEST["name"], $res);
      $first_name = $res[1] ? $res[1] : '';
      $last_name = $res[2] ? $res[2] : '';
      $data = wp_update_user( array( 'ID' => $current_user->ID, 'first_name' => $first_name, 'last_name' => $last_name ) );      
   }

   if ( is_wp_error( $data ) ) {
       // There was an error; possibly this user doesn't exist.
       echo 'Error.';
   } else {
       // Success!
       echo 'ok';
   }

   wp_die();

}

add_action("wp_ajax_sci_change_number", "sci_change_number");
function sci_change_number() {


   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["number"]) {
      update_field(__sci_s("USER: Profile details", 'sci_user_mobile')['key'], $_REQUEST["number"], 'user_' . $current_user->ID);
      echo "ok";
   }
   if (!!$_REQUEST["hide_number"]) {
      $bool = filter_var($_REQUEST["hide_number"], FILTER_VALIDATE_BOOLEAN);
      update_field(__sci_s("USER: Profile details", 'hide_number')['key'], $bool, 'user_' . $current_user->ID);
      echo "ok";

   }

   wp_die();

}

add_action("wp_ajax_sci_change_location", "sci_change_location");
function sci_change_location() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["location"]) {
      update_field(__sci_s("USER: Profile details", 'sci_user_location')['key'], $_REQUEST["location"], 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_gender", "sci_change_gender");
function sci_change_gender() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["gender"]) {
      update_field(__sci_s("USER: Profile details", 'sci_user_gender')['key'], $_REQUEST["gender"], 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_category", "sci_change_category");
function sci_change_category() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["categories"]) {
      $new = array_map(function($item){
         return get_term_by('id', $item, 'jobs');
      }, json_decode($_REQUEST["categories"]));
      update_field(__sci_s("Profession", 'profession')['key'], json_decode($_REQUEST["categories"]), 'user_' . $current_user->ID);
      echo "ok";
   }
   wp_die();

}

add_action("wp_ajax_sci_change_intro", "sci_change_intro");
function sci_change_intro() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   update_field(__sci_s("USER: Profile details", 'intro_to_camera')['key'], $_REQUEST["camera"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Profile details", 'intro_text')['key'], $_REQUEST["text"], 'user_' . $current_user->ID);
   echo "ok";

   wp_die();

}

add_action("wp_ajax_sci_change_social", "sci_change_social");
function sci_change_social() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_instagram')['key'], $_REQUEST["instagram"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_facebook')['key'], $_REQUEST["facebook"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_twitter')['key'], $_REQUEST["twitter"], 'user_' . $current_user->ID);
   update_field(__sci_s("USER: Social Links and websites", 'sci_user_social_links_youtube')['key'], $_REQUEST["youtube"], 'user_' . $current_user->ID);
   echo "ok";

   wp_die();

}

add_action("wp_ajax_sci_manage_photos", "sci_manage_photos");
function sci_manage_photos() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   $newOrder = [];

   if ($_REQUEST['order']) {
      foreach ($_REQUEST['order'] as $key => $value) {
         $id = (int) $value['id'];
         if ($value['caption']) {
            $my_post = array(
               'ID'           => $id,
               'post_excerpt'   => $value['caption'],
            );
            wp_update_post($my_post);
         }
         array_push($newOrder, get_post($id));
      }
   }
   //
   
   $path = str_replace('\\', '/', preg_replace("/^(?:.+)(wp-content.*)/", ABSPATH . "$1", $newOrder[0]->guid));

   //$image = wp_get_image_editor($path);
   //var_dump($image->rotate(-90));
   //var_dump($image->save($path));
   //var_dump($newOrder);
   update_field(__sci_s("USER: Profile details", 'photos')['key'], $newOrder, 'user_' . $current_user->ID);
   echo "ok";
   wp_die();

}
add_action("wp_ajax_sci_experience_form", "sci_experience_form");
function sci_experience_form() {
   $current_user = wp_get_current_user();
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }

   $catId = $_REQUEST["catid"];
   ?>

   <div class="modal-header" data-id=<?php echo $catId ?>>
            <div class="col-md-3 d-none d-lg-block">
               <img src=<?php echo get_field('sci_category_image', 'term_' . $catId); ?> alt="logo">
               </div>
               <div class="col-10 col-md-6">
                  <h5 class="modal-title text-lg-center" id="catDetailedModalLabel">
                     <span><?php echo get_field('category_name_singular', 'term_' . $catId); ?> </span> Details
                  </h5>
               </div>
               <div class="col-2 col-md-3">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-11 col-md-8 mx-auto">
                     <p>Complete this section with as much detail as possible for better chances of being scouted</p>
                  </div>
               </div>
               <!-- Main form -->
               <form class="row" id="form-experience">
                  <div class="col-12 col-lg-10 mx-auto accordion shadow-sm pt-4" id="accordion">
                     <!-- Specialised skill section -->
                     <div class="row px-4 pb-5">
                        <div class="hr-text col-12 p-0 mb-4">
                           <span class="credit-title font-weight-bold pr-3">
                              Specialised Skills
                           </span>
                        </div>
                        <div class="col-12">
                           <div id="experience-specialized-skills" class="btn-group-toggle" data-toggle="buttons">

                           <?php
                               $professions = get_user_meta($current_user->ID, 'profession',true);

                               $subCats = get_terms( array(
                                 'taxonomy'      => 'jobs',
                                 'hide_empty'    => false,
                                 'parent'        => $catId,
                                 'fields'        => 'id=>name'
                                 ) );
                             
                                 foreach($subCats as $key => $subCat){
                                    $isSelected = in_array($key, $professions) ? "active focus" : "";
                                    ?>

                                    <label <?php post_class("btn btn-popup-pill " . $isSelected) ?>>
                                       <input type="checkbox" value=<?php echo $key ?>> <?php echo $subCat ?> </input>
                                    </label>

                                 <?php }

                              ?>
                           </div>
                        </div>
                     </div>
                     <!-- section ends -->
                     

                     <?php
                        $formAdditionalFields = get_field('sci_form_additional_fields', 'option');
                        $additionalFieldsInCat;
                        foreach($formAdditionalFields as $key => $value){
                           if($value["sci_form_category"] == $catId){
                              $additionalFieldsInCat = $value["sci_form_field"];
                              break;
                           }
                        }
                        
                        $experience = __sci_s("USER: Profile details", 'experience')["sub_fields"];

                        if($additionalFieldsInCat){
                           foreach($additionalFieldsInCat as $field){

                              foreach($experience as $key => $value){ 
                                 if($value['name'] == $field){
                                    $userFieldValue;
                                    $otherField ;
                                       if( have_rows('experience', 'user_' . $current_user->ID) ):
                                          while ( have_rows('experience', 'user_' . $current_user->ID) ) : the_row();
                                             if(get_sub_field('category')->term_id == $catId){
                                                $userFieldValue = get_sub_field($field);
                                                $otherField = get_sub_field($field . '-other');
                                             }
                                          endwhile;   
                                       endif;?>
                                       <div class="row px-4 pb-5">
                                          <div class="hr-text col-12 p-0 mb-4">
                                             <span class="credit-title font-weight-bold pr-3">
                                                <?php echo ucfirst(str_replace("_"," ",$field)); ?>
                                             </span>
                                          </div>
                                          <?php
                                             $fieldType;
                                             if($value["multiple"] == 1){
                                                $fieldType = "checkbox";
                                             }else{
                                                $fieldType = "radio";
                                             }
                                          ?>
                                          <div class="col-12 form-additional-fields" data-name= <?php echo $field ?>>
                                             <div class="btn-group-toggle" data-toggle="buttons" data-type= <?php echo $fieldType ?>>  
                                                <?php foreach($value["choices"] as $key => $choice) {
                                                   $isSelected;
                                                      if($userFieldValue["value"]){
                                                         $isSelected = $key == $userFieldValue["value"] ? "active focus" : "";
                                                      }else if(is_array($userFieldValue[0])){
                                                         $contains = false;
                                                         foreach($userFieldValue as $object){
                                                           if($object["value"] == $key){
                                                            $contains = true;
                                                            break;
                                                           }
                                                         }
                                                         $isSelected = $contains ? "active focus" : "";
                                                      }
                                                      else{
                                                         $isSelected = in_array($key, $userFieldValue) ? "active focus" : "";
                                                      }
                                                   ?> 
                                                                                                  
                                                   <label <?php post_class("btn btn-popup-pill " . $isSelected) ?>>
                                                      <input class="other-fields" type=<?php echo $fieldType ?> value=<?php echo str_replace(" ","-",$choice) ?>> <?php echo $choice ?></input>
                                                   </label>
                                                <?php } ?> 
                                             </div>
                                             <div class="form-group row other-selected" <?php if(($key != "Others") || ($key == "Others" && $isSelected == "")){ echo 'style="display:none;"';} ?>>
                                                <div class="col-12 col-md-6">
                                                   <input class="form-control" data-other=<?php echo $field . '-other' ?> type="text" placeholder="Enter all the other inputs separated by comma" value="<?php echo $otherField ?>"></input>
                                                   <div class="invalid-feedback">
                                                      Opps error!
                                                   </div>
                                                </div>
                                             </div>
                                             
                                          </div>
                                       </div>
                                 <?php }
                              }
                           }
                        } 

                        if( have_rows('experience', 'user_' . $current_user->ID) ):
                           while ( have_rows('experience', 'user_' . $current_user->ID) ) : the_row();
                           
                              if(get_sub_field('category')->term_id == $catId){
                                 $userFieldValue = get_sub_field($field); ?>
                              
                                 <div class="row px-4 pb-5">
                                    <div class="hr-text col-12 p-0 mb-4">
                                       <span class="credit-title font-weight-bold pr-3">
                                          <?php echo get_field('category_name_singular', 'term_' . $catId); ?> Website
                                       </span>
                                    </div>
                                    <div class="col-12">
                                       <div class="form-group">
                                          <input id="experience-website" class="form-control" type="text" placeholder="Enter website:" value=<?php echo get_sub_field('website') ?>></input>
                                          <div class="invalid-feedback">
                                             Opps error!
                                          </div>
                                       </div>
                                    </div>
                                 </div>


                                 <?php $arrYear = array();
                                 if( have_rows('sections') ):
                                    while ( have_rows('sections') ) : the_row();

                                       $year = get_sub_field('year');
                                       if(!array_key_exists($year,$arrYear)){
                                          $arrYear[$year] = array();
                                       }
                                       $data = new stdClass(); 
                                       $data->row = get_row_index();
                                       $data->content = get_sub_field('content');
                                       array_push($arrYear[$year], $data);
                                       krsort($arrYear);
                                       ?>
                                    <?php endwhile;
                                 endif; ?>

                                 <div class="hr-text col-12 p-0 mb-4">
                                    <span class="credit-title font-weight-bold pr-3">
                                       Experience by Year
                                    </span>
                                 </div>
                                 <div class="accordion col-12 mx-auto" id="experience-accordion">
                                 <?php foreach($arrYear as $key => $yearData){ ?>   
                                    <div class="accordion-group mb-3 card new-experience-group">
                                       <div class="row card-header collapsed p-2" id=<?php echo  "row" . $key ?> type="button" data-toggle="collapse" data-target=<?php echo  '#year' . $key ?> aria-expanded="true" aria-controls=<?php echo "row" . $key ?>>
                                          <div class="col-11">
                                             <p class="text-uppercase my-2 pt-1 ml-2">Year <span>(<?php echo  $key ?>)</span>
                                             </p>
                                          </div>
                                       </div>
                                       <div id=<?php echo "year" . $key ?> class="collapse" aria-labelledby=<?php echo  "year" . $key ?>>
                                          <div class="accordion-inner card-body">
                                             <ul class="list" data-year=<?php echo $key ?>>
                                                <?php foreach($yearData as $data){ ?>
                                                   <li data-row=<?php echo $data->row ?> style="display: flex;padding-bottom: 5px;"><span contenteditable="true"><?php echo $data->content ?></span>
                                                      <div class="d-flex justify-content-end" style="flex: auto;">
                                                         <button class="btn btn-popup-del delete-experience" type="button" data-toggle="modal" data-target="#deleteExp">
                                                            <i class="fas fa-trash-alt fa-lg"></i>
                                                         </button>
                                                      </div>
                                                   </li>
                                                   
                                                <?php } ?>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 <?php } ?>  
                                 </div>
                              <?php };
                           endwhile;   
                        endif;

                        
                     ?>
                     
                     
                     
                     <!-- EXP input section -->
                     <div class="row px-4 pb-5">
                        <div class="hr-text col-12 p-0 mb-4">
                           <span class="credit-title font-weight-bold pr-3">
                              Add new Experience
                           </span>
                        </div>
                        <form action="">
                        <div class="col-12 card p-3 mb-3">
                           <!-- <div class="d-flex justify-content-end">
                              <button class="btn btn-popup-del" type="button" data-toggle="modal" data-target="#deleteExp">
                                 <i class="fas fa-trash-alt fa-lg"></i>
                              </button>
                           </div> -->
                           <div class="form-group row">
                              <div class="col-12 col-md-6">
                                 <label for="ExpYr">Year</label>
                                 <input type="text" class="form-control" id="ExpYr" maxlength="4" pattern="^[0-9]{4}$" required>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="experience-content">Experience</label>
                                 <textarea class="form-control justify-content-center" id="experience-content" rows="4" maxlength="500" required></textarea>
                                 <span class="float-right text-muted pt-1">500</span>
                              </div>
                           </div>
                           <div class="d-flex justify-content-start">
                              <button type="submit" id="add-experience" class="btn btn-lg btn-popup-savAddmr">Save & Add more</button>
                           </div>
                        </form>
                     </div>
                     <!-- section ends -->
                     <!-- btns div -->
                     <div class="d-flex justify-content-center py-4">
                        <button class=" btn-lg btn-popup-cancel mr-2" data-dismiss="modal">Cancel</button>
                        <!-- <div class="submit"> -->
                           <button id="experience-submit" class="btn btn-lg btn-popup-save px-4 ml-2">Save</button>
                        <!-- </div> -->
                     </div>
                  </div>
               </div>
            </form>
         </div> 

<?php wp_die();
}


add_action("wp_ajax_sci_experience_form_submit", "sci_experience_form_submit");
function sci_experience_form_submit() {

   $current_user = wp_get_current_user();
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   
   $data = json_decode(str_replace("\\","", $_REQUEST["updateData"]));
   $categoryId = $_REQUEST["category"];
   $subCats = $data->subCats; 
   $additionalFields = $data->additionalFields;
   $website = $data->website;
   $fieldOtherSpecifications = $data->fieldOtherSpecifications;
   $experiences = $data->experiences;
   $deleted = $data->deleted;

   $userProfessions = get_field('profession', 'user_' . $current_user->ID);

   $mainCategories = [];
   foreach($userProfessions as $userProfession){
      $child = get_term($userProfession);
      if($child->parent == 0 || $child->parent != $categoryId){
         array_push($mainCategories, strval($child->term_id));
      }
   }
   foreach($subCats as $cat){
      array_push($mainCategories, strval($cat));
   }

   update_field(__sci_s("Profession", 'profession')['key'], $mainCategories, 'user_' . $current_user->ID);
   


   $experienceField = get_field('experience', 'user_' . $current_user->ID);
   
   $categoryExperiencePresent = false;

   if(!empty($experienceField)){
      $experienceRow =0;
      foreach($experienceField as $experience){
         
         if($experience['category']->term_id == $categoryId){
            $categoryExperiencePresent = true;

            $sectionRow = 0;
            $newSections = array();
            if(!empty($experience['sections'])){
               $newSections = $experience['sections'];

               foreach($newSections as $key => $section){
                  $sectionRow += 1;
                  if(in_array($sectionRow, $deleted)){
                     unset($newSections[$key]);
                  }

               }

               foreach($experiences as $experience){
                  if($experience->rowNumber != "-1"){
                     $newSection = array(
                        "content" => $experience->content,
                        "year" => (string)$experience->year
                     );
                     $newSections[$experience->rowNumber-1] = $newSection;
                  }
               }
            }
            
            foreach($experiences as $experience){
                if($experience->rowNumber == "-1"){
                  $newSection = array(
                     "content" => $experience->content,
                     "year" => (string)$experience->year
                  );
                  $newSections[count($newSections)] = $newSection;
                }
            }
            $experienceField[$experienceRow]['sections'] = $newSections;


            //////////////////////////////
            foreach($additionalFields as $fields){
               $experienceField[$experienceRow][$fields->efFieldName] = $fields->efOptions;
            }

            foreach($fieldOtherSpecifications as $otherFields){
               $experienceField[$experienceRow][$otherFields->efFieldName] = $otherFields->efValue;
            }

            $experienceField[$experienceRow]['website'] = $website;
            //////////////////////////////

         }
         $experienceRow += 1;
 
      }
      
   }
   
   if(empty($experienceField) || !$categoryExperiencePresent){
      //create experience for category with details
      

      $experienceRow = [];

      $category = get_term($categoryId);
      $experienceRow["category"] = $category;

      foreach($additionalFields as $fields){
         $experienceRow[$fields->efFieldName] = $fields->efOptions;
      }

      foreach($fieldOtherSpecifications as $otherFields){
         $experienceRow[$otherFields->efFieldName] = $otherFields->efValue;
      }

      $experienceRow['website'] = $website;

      $newSections = array();
      foreach($experiences as $experience){
         if($experience->rowNumber == "-1"){
           $newSection = array(
              "content" => $experience->content,
              "year" => (string)$experience->year
           );
           $newSections[count($newSections)] = $newSection;
         }
     }
     $experienceRow['sections'] = $newSections;

     $experienceField[count($experienceField)] = $experienceRow;

   }
   
   update_field(__sci_s("USER: Profile details", 'experience')['key'],  $experienceField , 'user_' . $current_user->ID );
   
   echo 'Ok';
   wp_die();

}
 
add_action("wp_ajax_sci_toggle_spotlight", "sci_toggle_spotlight");
function sci_toggle_spotlight() {
   
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "edit_request")) {
      exit("No naughty business please");
   }   

   if (!!$_REQUEST["toggle_spotlight"]) {
         $temp_state = 0;
      if($_REQUEST["toggle_spotlight"]=="true"){
         $temp_state = 1;
      }
      update_field(__sci_s("USER: Profile details", 'spotlight-toggle')['key'], $temp_state, 'user_' . $_REQUEST['user_id']);
      echo "ok";
   }
   wp_die();

}?>