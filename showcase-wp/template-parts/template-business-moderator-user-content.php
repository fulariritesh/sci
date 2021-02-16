<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
       
    .BMTabs .tab-content{
        border-left:1px solid #dee2e6;
        border-right:1px solid #dee2e6;
        border-bottom:1px solid #dee2e6;
    }

    .photo-grid .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        padding: 0 4px;
    }

    /* Create four equal columns that sits next to each other */
    .photo-grid  .column {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
        max-width: 25%;
        padding: 0 4px;
    }

    .photo-grid .column img {
        vertical-align: middle;
        width: 100%;
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media screen and (max-width: 800px) {
    .column {
        -ms-flex: 50%;
        flex: 50%;
        max-width: 50%;
    }
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
    .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
    }



    .statusselect-radio input[type="checkbox"]{
    height:18px;
    width:18px;
    }

    .profileStatus{
    background: #f5f5f5;
    }                   
    .btn-pending.active{
        background: #ffd800;
    }
    .btn-rejected.active{
        background: #de1a1a;
        color:#fff;
    }
    .btn-approved.active{
        background: #16d011;
        color:#fff;
    }
    
    .history-accordion .card{
        border-radius:0;
        border-top:0;
        
    }
    .history-accordion .card .card-header{
            border-bottom:0;
            padding:0;
        }

        .switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}
 
.switch input {display:none;}
 
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #efefef;
  -webkit-transition: .4s;
  transition: .4s;
}
 
.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
 
input:checked + .slider {
  background-color: #07bb9b;
}
 
input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}
 
input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(55px);
}
 
/*------ ADDED CSS ---------*/
.on
{
  display: none;
}
 
.on
{
  color: #fff;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 38%;
  font-size: 13px;
}
 .off
{
  color: #444;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 56%;
  font-size: 13px;
}
input:checked+ .slider .on
{display: block;}
 
input:checked + .slider .off
{display: none;}
 
/*--------- END --------*/
 
/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
 
.slider.round:before {
  border-radius: 50%;}

.hr-text {
    height: 13px;
    border-bottom: 1px solid #dee2e6;
    width: 100%;
    margin-top: 0px;
}

.hr-text .credit-title {
    background: #fff; 
 }

 .btn-add {
    background: #04c382;
    color: #fff;
    text-transform: capitalize;
    border: 1px solid #00a06a; }

    .btn-plain {
    background: #fff;
    color: #444;
    border: 1px solid #f3f3f3; }

    .experience-category{
        padding-left: 20px;
    }

    .accordion {
    background-color: #fff;
    .card {
      border: 1px solid #bebebe !important;
      border-radius: 0 !important;
      .card-header.collapsed:after {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f078";
        color: $header-icon-color;
        padding-top: 0.7rem;
        float: right;
      }
      .card-header:after {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #f2f2f2;
        content: "\f00c";
        padding-top: 0.7rem;
        float: right;
      }
      .card-header.selected {
        background:#07bb9b ;
        color: #fff;
        .icon {
          fill: $header-activeicon-color;
        }
      }
    }
    .icon {
      width: 3rem;
      height: 3rem;
      fill: $header-icon-color;
    }
  }

  .credit-title-histoy{
    background-color: lightsteelblue;
    padding: 4px;
    border-radius: 5px;
    font-size: medium;
    text-align: center;
  }

  .time-badge{
    padding: 6px;
    background-color: lavender;
    border-radius: 20px;
    font-weight: 500;
    padding-inline-start: 10px;
  }

  .hr-text-history{
    margin-bottom: 20px;
    border-bottom: 2px solid #dee2e6;
  }
</style>

<?php

    $user_ID = $_REQUEST["ID"];
    $user = get_user_by( 'ID', $user_ID );

?>

<section class="container-fluid ">
        <div class="container px-0 mt-5">
            <div class="row pb-3">
                <div class="col-12">
                <a href=<?php echo admin_url() . 'admin.php?page=authorize-content' ?> class="btn btn-add">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <h1 id="user-id" data-id=<?php echo $user_ID; ?>><?php echo $user->display_name; ?></h1>
                    <h6>Changes Updated</h6>
                </div>
                <div class="col-2 ">
                    <h6>Profile Visibility</h6>
                    <label class="switch">
                        <input type="checkbox" id="tog-btn-profile-visibility">
                        <div class="slider round">
                          <!--ADDED HTML -->
                          <span class="on">Show</span>
                          <span class="off">Hide</span>
                          <!--END-->
                        </div>
                      </label>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-12 BMTabs">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#latest-content">Latest Content</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sections">Sections</a>
                        </li>
                        <li class="nav-item">
                        <a id="history-tab" class="nav-link" data-toggle="tab" href="#history">History</a>
                        </li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- latest content tab -->
                        <div class="tab-pane container py-4 active" id="latest-content">
                            <?php 
                            $basicDetailsStatus = get_user_meta($user_ID, 'basic_details_are_approved',true);
                            $location = get_user_meta($user_ID, 'sci_user_location',true);
                            $dob = get_user_meta($user_ID, 'sci_user_dob',true);
                            $gender = get_user_meta($user_ID, 'sci_user_gender',true);
                            $mobile = get_user_meta($user_ID, 'sci_user_mobile',true);

                            if(($basicDetailsStatus == "" || $basicDetailsStatus == 'Updated') && 
                                ($location != "" || $dob != "" ||$gender != "" ||$mobile != "") ){ ?>
                                
                                <div class="col-12 pt-3 pb-3 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                            Personal Details
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-personal-details">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-personal-details">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                <div class="row pt-3">
                                <div class="col-12 row">
                                        <div class="col-12">
                                            <h2 id="name"><?php echo $user->display_name; ?></h2>
                                            <h5 id="location"><?php echo get_field('sci_user_location', 'user_' . $user_ID)['label']; ?></h5>
                                            <h5 id="gender"><?php echo get_user_meta($user_ID, 'sci_user_gender',true); ?></h5>
                                            <h5 id="mobile"><?php echo get_user_meta($user_ID, 'sci_user_mobile',true); ?></h5>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <?php } ?>

                            <?php
                                $introTocamaraStatus = get_user_meta($user_ID, 'intro_to_camera_is_approved',true);
                                $introTextStatus = get_user_meta($user_ID, 'intro_text_is_approved',true);


                                if(($introTocamaraStatus == "" ||  $introTocamaraStatus == 'Updated') || 
                                   ($introTextStatus == "" ||  $introTextStatus == 'Updated')): ?>
                                    <div class="col-12 pt-3 pb-3 details-block">
                                        <div class="hr-text">
                                            <span class="credit-title pr-3">
                                            Introduction
                                            </span>
                                        </div>
                                        <div class="col-12 text-right pt-3 px-0">
                                            <button class="btn btn-edit btn-sm selectAll selectAll">Select All</button>
                                            <button data-status="Rejected" class="btn btn-danger btn-sm action-introduction">Reject</button>
                                            <button  data-status="Approved" class="btn btn-add btn-sm action-introduction">Approve</button>
                                            <span class="actionTaken"></span>
                                        </div>
                                        <div class="row pt-3">
                                            <?php
                                                $introUrl = get_user_meta($user_ID, 'intro_to_camera',true);
                                                if($introUrl!= "" && ($introTocamaraStatus == "" ||  $introTocamaraStatus == 'Updated') ){?>
                                                    <div class="col-4 border px-0 ">
                                                        <iframe id="introToCamara" width="100%" height="250px" src=<?php echo $introUrl ?>>
                                                        </iframe>
                                                        <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox" type="checkbox" value="" data-value="camara">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                            ?>
                                            <?php
                                                $introText = get_user_meta($user_ID, 'intro_text',true);
                                                if($introText!= "" && ($introTextStatus == "" ||  $introTextStatus == 'Updated') ){?>
                                                    <div class="col-8 row">
                                                        <div class="col-1">
                                                            <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input checkbox" type="checkbox" value="" data-value="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-11">
                                                            <p id="introText">
                                                                <?php echo $introText ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php }
                                            ?>   
                                            
                                        </div>
                                    </div>
                                <?php endif; 
                            ?>


                            <?php 
                            $headshotsToApprove = array();
                            if( have_rows('sci_user_headshots', 'user_' . $user_ID) ): ;
                                while ( have_rows('sci_user_headshots', 'user_' . $user_ID) ) : the_row();
                                    $imageId = get_sub_field('sci_user_headshot');
                                    $status = get_post_meta( $imageId['id'], 'is_approved', true );
                                    if($status == "" || $status == "Updated"){
                                        $headshot = array();
                                        $headshot["ID"] = $imageId['ID'];
                                        $headshot["title"] = $imageId['title'];
                                        $headshot["url"] = $imageId['url'];
                                        array_push($headshotsToApprove, $headshot);
                                    }
                                endwhile;
                            endif; ?>

                            <?php
                            if(!empty($headshotsToApprove)){ ?>
                                <div class="col-12 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                        Headshots (<?php echo count($headshotsToApprove) ?>)
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button class="btn btn-edit btn-sm selectAll">Select All</button>
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-headshots">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-headshots">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                    <!-- Photo Grid  -->
                                    <div class="photo-grid pt-3">
                                        <div class="row"> 
                                            <?php foreach($headshotsToApprove as $headshot){ ?>
                                                <div class="column">
                                                    <div class="border image-block">
                                                        <img id=<?php echo $headshot["ID"] ?> src=<?php echo $headshot["url"] ?> alt=<?php echo $headshot["title"] ?> >
                                                        <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox" type="checkbox" value="" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            


                            <?php 
                            $photosToApprove = array();
                            $photos = get_field('photos', 'user_' . $user_ID);
                            if( $photos ):
                                foreach( $photos as $photo ):
                                    $status = get_post_meta( $photo["ID"], 'is_approved', true );
                                    if($status == "" || $status == "Updated"){
                                        $thisphoto = array();
                                        $thisphoto["ID"] = $photo['ID'];
                                        $thisphoto["title"] = $photo['title'];
                                        $thisphoto["url"] = $photo['url'];
                                        array_push($photosToApprove, $thisphoto);
                                    }
                                endforeach;
                            endif; 
                            ?>

                            <?php
                            if(!empty($photosToApprove)){ ?>
                                <div class="col-12 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                        Photos (<?php echo count($photosToApprove) ?>)
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button class="btn btn-edit btn-sm selectAll">Select All</button>
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-photos">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-photos">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                    <!-- Photo Grid  -->
                                    <div class="photo-grid pt-3">
                                        <div class="row"> 
                                            <?php foreach($photosToApprove as $photo){ ?>
                                                <div class="column">
                                                    <div class="border image-block">
                                                        <img id=<?php echo $photo["ID"] ?> src=<?php echo $photo["url"] ?> alt=<?php echo $photo["title"] ?> >
                                                        <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                            <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" value="" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            
                            <?php
                            $videosToApprove = array();
                            if( have_rows('videos', 'user_' . $user_ID) ): ;
                                while ( have_rows('videos', 'user_' . $user_ID) ) : the_row();
                                    $videoStatus = get_sub_field('is_approved')["value"];
                                    if($videoStatus == "" || $videoStatus == "Updated"){
                                        $video = array();
                                        $video["row_id"] = get_row_index();
                                        $video["link"] = get_user_meta($user_ID,  'videos_'.(get_row_index() - 1).'_video_link', true);
                                        $video["caption"] = get_sub_field('video_caption');
                                        array_push($videosToApprove, $video);
                                    }
                                endwhile;
                            endif; 
                            if(!empty($videosToApprove)){ ?>
                                <div class="col-12 pt-3 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                    Videos (<?php echo count($videosToApprove) ?>)
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button class="btn btn-edit btn-sm selectAll">Select All</button>
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-videos">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-videos">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                <div class="row pt-3 details-block">
                                    <?php foreach($videosToApprove as $video){ ?>
                                        
                                        <div class="col-4 border px-0 video-block">
                                            <iframe data-row=<?php echo $video["row_id"] ?> width="100%" height="250px" src=<?php echo $video["link"] ?>>
                                            </iframe>
                                            <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input checkbox" type="checkbox" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            

                            <?php
                            $audiosToApprove = array();
                            if( have_rows('audios', 'user_' . $user_ID) ): ;
                                while ( have_rows('audios', 'user_' . $user_ID) ) : the_row();
                                    $audio = get_sub_field('audio_file');
                                    $audioStatus = get_post_meta( $audio["ID"], 'is_approved', true );
                                    if($audioStatus == "" || $audioStatus == "Updated"){
                                        $audioFile = array();
                                        $audioFile["ID"] = $audio["ID"];
                                        $audioFile["title"] = get_sub_field('audio_title');    
                                        $audioFile["description"] = get_sub_field('audio_description');     
                                        $audioFile["url"] = $audio["url"];    
                                        $audioFile["mime_type"] = $audio["mime_type"];    
                                        array_push($audiosToApprove, $audioFile);
                                    }
                                endwhile;
                            endif;
                            ?>

                            <?php if(!empty($audiosToApprove)){ ?>
                                <div class="col-12 pt-3 pb-3 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                            Audio
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button class="btn btn-edit btn-sm selectAll">Select All</button>
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-audios">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-audios">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                    <div class="row pt-3 audio-block">
                                        <?php foreach($audiosToApprove as $audio) {  ?>
                                            <div class="col-6">
                                                <div class="col-1">
                                                    <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" value="" id="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-11 pt-1 audioFile" id=<?php echo $audio["ID"] ?>>
                                                    <h5 class="pt-2"><?php echo $audio["title"] ?></h5>
                                                    <h6><?php echo $audio["description"] ?></h6>
                                                    <audio controls>
                                                        <source src=<?php echo $audio["url"] ?> type=<?php echo $audio["mime_type"] ?>>
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>



                            <?php
                            $experiencesToApprove = array();
                                if( have_rows('experience', 'user_' . $user_ID) ): ;
                                while ( have_rows('experience', 'user_' . $user_ID) ) : the_row();
                                    $experienceStatus = get_sub_field('sci_experience_approved');
                                    if($experienceStatus == "" || $experienceStatus == "Updated"){
                                        
                                        $category = get_sub_field('category');
                                        if(!array_key_exists($category->term_id,$experiencesToApprove)){
                                            $experiencesToApprove[$category->term_id] = array();
                                        }
                                        if( have_rows('sections') ):
                                            while ( have_rows('sections') ) : the_row();
                                                $experience = array();
                                                $experience["year"] = get_sub_field('year');
                                                $experience["content"] = get_sub_field('content');
                                                array_push($experiencesToApprove[$category->term_id], $experience);
                                            endwhile;
                                         endif;   
                                    }
                                endwhile;
                                endif;
                            ?>
                            
                            <?php if(!empty($experiencesToApprove)){?>
                                <div class="col-12 pt-3 details-block">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                        Experience
                                        </span>
                                    </div>
                                    <div class="col-12 text-right pt-3 px-0">
                                        <button class="btn btn-edit btn-sm selectAll">Select All</button>
                                        <button data-status="Rejected" class="btn btn-danger btn-sm action-experience">Reject</button>
                                        <button data-status="Approved" class="btn btn-add btn-sm action-experience">Approve</button>
                                        <span class="actionTaken"></span>
                                    </div>
                                    <div class="row pt-3">
                                        <?php foreach($experiencesToApprove as $key => $experience){ 
                                            usort($experience, function ($a, $b) {
                                                return -1 * strcmp($a["year"], $b["year"]);
                                            });?>
                                            <div class="col-2 text-center">
                                                <div class="statusselect-radio pb-4 pl-3 pt-1 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input checkbox" type="checkbox" value="" id=<?php echo $key ?>><span class="experience-category"><?php echo get_field('category_name_singular', 'term_' . $key); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 pt-1">
                                                <?php foreach($experience as $exp){ ?>
                                                        <p><?php echo strip_tags($exp["content"]) . " - (" . $exp["year"] . ")" ?> </p>
                                                <?php } ?>
                                            </div>
                                            <div class="hr-text">
                                                <span class="credit-title pr-3"></span>
                                            </div>
                                            <br>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>
                        <!-- latest content tab end-->
                        <!-- Section tab -->
                        <div class="tab-pane container fade" id="sections">
                            <div class="row pt-3 p-3">
                                <div class="col-12 row profileStatus mx-auto p-3">
                                    <div class="col-3 pt-2">
                                        Profile Status
                                    </div>
                                    <div class="col-9 text-right ">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-plain btn-approved ">
                                              <input class="profile_status_radio" type="radio" name="profile_status" data-value="Approved" id="profile_status_approved" autocomplete="off" > Approved
                                            </label>
                                            <label class="btn btn-plain btn-rejected ">
                                              <input class="profile_status_radio" type="radio" name="profile_status" data-value="Rejected" id="profile_status_rejected" autocomplete="off"> Rejected
                                            </label>
                                            <label class="btn btn-plain btn-pending active">
                                              <input class="profile_status_radio" type="radio" name="profile_status" data-value="Pending" id="profile_status_pending" autocomplete="off"> Pending
                                            </label>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-12 pt-3 pb-3">
                                    <div class="hr-text">
                                        <span class="credit-title pr-3">
                                        Sections
                                        </span>
                                    </div>
                                    <div class="col-12 row pt-5">
                                       <div class="col-3">
                                           Personal Details
                                       </div>
                                       <div class="col-4">
                                        <label class="switch">
                                            <input type="checkbox" id="tog-btn-personal-visibility">
                                            <div class="slider round">
                                              <!--ADDED HTML -->
                                              <span class="on">Show</span>
                                              <span class="off">Hide</span>
                                              <!--END-->
                                            </div>
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Introduction
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-introduction-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                     <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Headshots
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-headshots-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                    <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Photos
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-photos-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                     <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Videos
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-videos-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                     <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Audios
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-audios-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                     <div class="col-12 row pt-4">
                                        <div class="col-3">
                                            Experience
                                        </div>
                                        <div class="col-4">
                                         <label class="switch">
                                             <input type="checkbox" id="tog-btn-experience-visibility">
                                             <div class="slider round">
                                               <!--ADDED HTML -->
                                               <span class="on">Show</span>
                                               <span class="off">Hide</span>
                                               <!--END-->
                                             </div>
                                           </label>
                                         </div>
                                     </div>
                                </div>
                        </div>
                        </div>
                        <!-- Section tab end-->
                         <!-- History tab-->
                        <div class="tab-pane container fade" id="history">
                            <div class="row p-3">
                                <div class="col-12 profileStatus border p-2">
                                    <div class="row">
                                        <div class="col-8 px-4"> Moderators Action</div>
                                        <div class="col-4 px-2">Date</div>
                                    </div>
                                </div>
                                <div class="col-12 px-0">
                                    <div id="accordion" class="history-accordion">

                                        
                                      
                                      </div> 
                                </div>
                            </div>
                        </div>
                         <!-- History tab end-->
                    </div>
                </div>
            </div>
        </div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
