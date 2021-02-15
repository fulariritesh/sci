<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
        .summaryBlock{
        background:#07bb9b;
        color:#fff;
        border-radius: 8px;
        padding-top:10px;
}
.bm-badge{
    background:#e3e3e3;
    font-weight:normal;
    font-size:16px;
    border-radius:8px;
    padding: 4px 15px;
    margin-right: 5px;
}

.btn-secondary, .btn-secondary:hover, .btn-secondary:active{
    background:#00a6d0;
    color:#fff;
    font-weight: 600;
}
    </style>

<?php

    $newUsersArgs = array(
        'role'          => 'subscriber',
        'fields'        => array( 'ID'),
    );
    $newUsers = get_users($newUsersArgs);

    $rejected_meta_queries = array('relation' => 'AND' , array(
        'key'     => 'profile_status',
        'value'   => 'Rejected',
        'compare' => '=',
    ));
    $rejectedArgs = array(
        'role'          => 'subscriber',
        'fields'        => array( 'ID' ),
        'meta_query'    => $rejected_meta_queries
    );
    $userRejected = get_users($rejectedArgs);

    $meta_queries = array('relation' => 'OR' , 
    array(
        'key'     => 'content_approval_personal_details_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_introduction_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_headshots_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_photos_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_videos_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_audios_updated',
        'value'   => 1,
        'compare' => '=',
    ),
    array(
        'key'     => 'content_approval_experience_updated',
        'value'   => 1,
        'compare' => '=',
    )
);

    $updatedContentArgs = array(
        'role'          => 'subscriber',
        'number'        => -1,
        'meta_key'       => 'content_approval_content_updated_date',
        'orderby'       => array( 'meta_value' => 'ASC' ), 
        'offset'        => 0,
        'fields'        => array( 'ID','display_name' ),
        'meta_query'    => $meta_queries
    );
    $userWithUpdatedContent = get_users($updatedContentArgs);

?>
<section class="container-fluid ">
        <div class="container px-0 mt-5">
            <div class="row">
                <div class="col-4">
                    <div class="row summaryBlock mx-3">
                        <div class="col-4 text-center"><h1><?php echo !empty($newUsers) ? count($newUsers) : 0 ?></h1></div>
                        <div class="col-8 pt-2"><h4>New Profiles</h4></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row summaryBlock mx-3">
                        <div class="col-4 text-center"><h1><?php echo !empty($userWithUpdatedContent) ? count($userWithUpdatedContent) : 0 ?></h1></div>
                        <div class="col-8 pt-2"><h4>New Updates</h4></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row summaryBlock mx-3">
                        <div class="col-4 text-center"><h1><?php echo !empty($userRejected) ? count($userRejected) : 0 ?></h1></div>
                        <div class="col-8 pt-2"><h4>Profiles Rejected</h4></div>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <th>Job Seeker</th>
                            <th>Content Updated on</th>
                            <th>Content Updated</th>
                            <th></th>
                        </tr>
                        <?php
                            if(!empty($userWithUpdatedContent)){
                                foreach($userWithUpdatedContent as $updatedUser){ ?>
                                    <tr>
                                        <td><?php echo $updatedUser->display_name ?></td>
                                        <?php
                                            $dateupdatedOn = date_create(get_user_meta($updatedUser->ID, 'content_approval_content_updated_date', true ));
                                        ?>
                                        <td><?php echo date_format($dateupdatedOn,"d-M-Y") ?></td>
                                        <td>
                                            <?php
                                                $basicDetailsStatus = get_user_meta($updatedUser->ID, 'basic_details_are_approved',true);
                                                $location = get_user_meta($updatedUser->ID, 'sci_user_location',true);
                                                $dob = get_user_meta($updatedUser->ID, 'sci_user_dob',true);
                                                $gender = get_user_meta($updatedUser->ID, 'sci_user_gender',true);
                                                $mobile = get_user_meta($updatedUser->ID, 'sci_user_mobile',true);

                                                if(($basicDetailsStatus == "" || $basicDetailsStatus == 'Updated') && 
                                                    ($location != "" || $dob != "" ||$gender != "" ||$mobile != "") ){
                                                    ?><span class="badge bm-badge">Basic Details</span><?php
                                                }


                                                if( have_rows('sci_user_headshots', 'user_' . $updatedUser->ID) ): ;
                                                    while ( have_rows('sci_user_headshots', 'user_' . $updatedUser->ID) ) : the_row();
                                                        $imageId = get_sub_field('sci_user_headshot');
                                                        $status = get_post_meta( $imageId['id'], 'is_approved', true );
                                                        if($status == "" || $status == "Updated"){
                                                            ?><span class="badge bm-badge">Heashots</span><?php
                                                            break;
                                                        }
                                                    endwhile;
                                                endif;

                                                $introTocamaraStatus = get_user_meta($updatedUser->ID, 'intro_to_camera_is_approved',true);
                                                $introUrl = get_user_meta($updatedUser->ID, 'intro_to_camera',true);
                                                if($introUrl!= "" && ($introTocamaraStatus == "" ||  $introTocamaraStatus == 'Updated') ){
                                                    ?><span class="badge bm-badge">Intro to camara</span><?php
                                                }

                                                $introTextStatus = get_user_meta($updatedUser->ID, 'intro_text_is_approved',true);
                                                $introTest = get_user_meta($updatedUser->ID, 'intro_text',true);
                                                if($introTest != "" && ($introTextStatus == "" ||  $introTextStatus == 'Updated') ){
                                                    ?><span class="badge bm-badge">Intro text</span><?php
                                                }

                                                $photos = get_field('photos', 'user_' . $updatedUser->ID);
                                                if( $photos ):
                                                    foreach( $photos as $photo ):
                                                        $status = get_post_meta( $photo["ID"], 'is_approved', true );
                                                        if($status == "" || $status == "Updated"){
                                                            ?><span class="badge bm-badge">Photos</span><?php
                                                            break;
                                                        }
                                                    endforeach;
                                                endif; 


                                                if( have_rows('videos', 'user_' . $updatedUser->ID) ): ;
                                                    while ( have_rows('videos', 'user_' . $updatedUser->ID) ) : the_row();
                                                        $videoStatus = get_sub_field('is_approved')["value"];
                                                        if($videoStatus == "" || $videoStatus == "Updated"){
                                                            ?><span class="badge bm-badge">Video</span><?php
                                                            break;
                                                        }
                                                    endwhile;
                                                endif;

                                                if( have_rows('audios', 'user_' . $updatedUser->ID) ): ;
                                                    while ( have_rows('audios', 'user_' . $updatedUser->ID) ) : the_row();
                                                        $audio = get_sub_field('audio_file');
                                                        $audioStatus = get_post_meta( $audio["ID"], 'is_approved', true );
                                                        if($audioStatus == "" || $audioStatus == "Updated"){
                                                            ?><span class="badge bm-badge">Audio</span><?php
                                                            break;
                                                        }
                                                    endwhile;
                                                endif;

                                                $experienceCounter = 0;
                                                if( have_rows('experience', 'user_' . $updatedUser->ID) ): ;
                                                    while ( have_rows('experience', 'user_' . $updatedUser->ID) && $experienceCounter == 0 ) : the_row();
                                                        $experienceStatus = get_sub_field('sci_experience_approved');
                                                        if($experienceStatus == "" || $experienceStatus == "Updated"){

                                                            if( have_rows('sections') ):
                                                                while ( have_rows('sections') ) : the_row();
                                                                    $experienceCounter += 1;
                                                                    ?><span class="badge bm-badge">Experience</span><?php
                                                                    break;
                                                                endwhile;
                                                             endif; 
                                                            
                                                        }
                                                    endwhile;
                                                endif;
                                            ?>                                      
                                        </td>
                                        <td>
                                        <a href=<?php echo admin_url() . 'admin.php?page=updated_content&ID=' . $updatedUser->ID ?> class="btn btn-secondary">View</a>
                                        </td>
                                    </tr> 
                                <?php }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>  

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>