<?php

function sci_authorize_content()
{
    add_role('business_user', __(
        'Business Moderator'),
        array(
            'edit_user' => true, 
            )
     );
     
    $role = get_role('business_user');

    $role->add_cap('authorize_content', true);
}

add_action('init', 'sci_authorize_content', 11);


function sci_authorize_content_menu() {
    add_menu_page(
        __( 'Authorize Profile Content', 'my-textdomain' ),
        __( 'Authorize Profile Content', 'my-textdomain' ),
        'authorize_content',
        'authorize-content',
        'sci_authorize_profile_content_page',
        'dashicons-schedule',
        3
    );
	add_submenu_page( 
		NULL, 
		__( 'Updated Content', 'my-textdomain' ), 
		__( 'Updated Content', 'my-textdomain' ), 
		'authorize_content', 
		'updated_content', 
		'sci_updated_content_page' );
}

add_action( 'admin_menu', 'sci_authorize_content_menu' );


function sci_authorize_profile_content_page() {
	get_template_part('template-parts/template-business-moderator-list' );
}

function sci_updated_content_page() {
	get_template_part('template-parts/template-business-moderator-user-content' );
}

function sci_moderator_scripts() {
    $page = isset($_REQUEST['page']) && $_REQUEST['page']!=""? $_REQUEST["page"] : '';
    
    if ($page == 'updated_content' || $page == 'authorize-content'){
        wp_register_script( 'moderator-script', get_stylesheet_directory_uri(). '/js/moderator.js', array('jquery'), false, true );
    
        $script_data_array = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'security' => wp_create_nonce( 'approve content' ),
        );
        wp_localize_script( 'moderator-script', 'moderator', $script_data_array );
    
        wp_enqueue_script( 'moderator-script' );
    }
}
add_action( 'admin_enqueue_scripts', 'sci_moderator_scripts' );

add_filter('wp_authenticate_user', function($user) {
    if (get_user_meta($user->ID, 'profile_status', true) != 'Rejected') {
        return $user;
    }
    return new WP_Error('Inactive ','Your Profile is Rejected. Kindly contact Admin');
}, 10, 2);

add_action('wp_ajax_get_profile_visibility', 'get_profile_visibility_callback');
function get_profile_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];

    $visibilityArray = array();
    $visibilityArray["profile"] = get_user_meta($user_id, 'profile_visibility_status',true);
    $visibilityArray["profileStatus"] = get_user_meta($user_id, 'profile_status',true);
    $visibilityArray["personal"] = get_user_meta($user_id, 'sections_visibility_personal_details',true);
    $visibilityArray["introduction"] = get_user_meta($user_id, 'sections_visibility_introduction',true);
    $visibilityArray["headshots"] = get_user_meta($user_id, 'sections_visibility_headshots',true);
    $visibilityArray["photos"] = get_user_meta($user_id, 'sections_visibility_photos',true);
    $visibilityArray["videos"] = get_user_meta($user_id, 'sections_visibility_videos',true);
    $visibilityArray["audios"] = get_user_meta($user_id, 'sections_visibility_audios',true);
    $visibilityArray["experience"] = get_user_meta($user_id, 'sections_visibility_experience',true);


    echo json_encode($visibilityArray);
    wp_die();
}

add_action('wp_ajax_set_profile_visibility', 'set_profile_visibility_callback');
function set_profile_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'profile_visibility_status', $visibility);
    wp_die();
}

add_action('wp_ajax_set_personal_visibility', 'set_personal_visibility_callback');
function set_personal_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_personal_details', $visibility);
    wp_die();
}

add_action('wp_ajax_set_introduction_visibility', 'set_introduction_visibility_callback');
function set_introduction_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_introduction', $visibility);
    wp_die();
}

add_action('wp_ajax_set_headshots_visibility', 'set_headshots_visibility_callback');
function set_headshots_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_headshots', $visibility);
    wp_die();
}

add_action('wp_ajax_set_photos_visibility', 'set_photos_visibility_callback');
function set_photos_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_photos', $visibility);
    wp_die();
}

add_action('wp_ajax_set_videos_visibility', 'set_videos_visibility_callback');
function set_videos_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_videos', $visibility);
    wp_die();
}

add_action('wp_ajax_set_audios_visibility', 'set_audios_visibility_callback');
function set_audios_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_audios', $visibility);
    wp_die();
}

add_action('wp_ajax_set_experience_visibility', 'set_experience_visibility_callback');
function set_experience_visibility_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $visibility = $_REQUEST["visibility"];

    echo update_user_meta($user_id, 'sections_visibility_experience', $visibility);
    wp_die();
}

add_action('wp_ajax_set_profile_status', 'set_profile_status_callback');
function set_profile_status_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];

    echo update_user_meta($user_id, 'profile_status', $status);
    wp_die();
}

add_action('wp_ajax_action_personal_details', 'action_personal_details_callback');
function action_personal_details_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    AddLog('Personal details', $status, $value, $user_id);
    
    update_user_meta($user_id, 'content_approval_personal_details_updated', false);
    echo update_user_meta($user_id, 'basic_details_are_approved', $status);
    wp_die();
}

add_action('wp_ajax_action_introduction', 'action_introduction_callback');
function action_introduction_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $introtext = trim($_REQUEST["introtext"]);
    $intro_camara = $_REQUEST["intro_camara"];

    $introTextHasValue = false;
    $introCamaraHasValue = false;

    $value = "";
    if($introtext != '' && $introtext != 'notset'){
        update_user_meta($user_id, 'intro_text_is_approved', $status);
        $value =  $value ."Text : " . $introtext . "; ";
        $introTextHasValue = true;
    }

    if($intro_camara != '' && $intro_camara != 'notset'){
        update_user_meta($user_id, 'intro_to_camera_is_approved', $status);
        $value = $value . "Camara : " . $intro_camara;
        $introCamaraHasValue = true;
    }
    
    AddLog('Introduction', $status, $value, $user_id);
    
    if(($introTextHasValue && $introCamaraHasValue) 
        || ($introTextHasValue && $intro_camara == 'notset')
        || ($introCamaraHasValue && $introtext == 'notset')){
        update_user_meta($user_id, 'content_approval_introduction_updated', false);
    }

    wp_die();
}


add_action('wp_ajax_action_headshot_details', 'action_headshot_details_callback');
function action_headshot_details_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    foreach($value as $headshot){
        update_post_meta( $headshot, 'is_approved', $status );
    }

    AddLog('Headshots', $status, json_encode($value), $user_id);
    update_user_meta($user_id, 'content_approval_headshots_updated', false);

    echo 'Ok';
    wp_die();
}

add_action('wp_ajax_action_photos', 'action_photos_callback');
function action_photos_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    foreach($value as $photo){
        update_post_meta( $photo, 'is_approved', $status );
    }

    AddLog('Photos', $status, json_encode($value), $user_id);
    update_user_meta($user_id, 'content_approval_photos_updated', false);

    echo 'Ok';
    wp_die();
}

add_action('wp_ajax_action_videos', 'action_videos_callback');
function action_videos_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    if( have_rows('videos', 'user_' . $user_id) ): ;
        while ( have_rows('videos', 'user_' . $user_id) ) : the_row();
            $row = get_row_index();
            if(in_array($row, $value)){
                update_sub_field('is_approved', $status);
            }
        endwhile;
    endif; 

    AddLog('Videos', $status, json_encode($value), $user_id);
    update_user_meta($user_id, 'content_approval_videos_updated', false);

    echo 'Ok';
    wp_die();
}


add_action('wp_ajax_action_audios', 'action_audios_callback');
function action_audios_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    foreach($value as $audio){
        update_post_meta( $audio, 'is_approved', $status );
    } 

    AddLog('Audios', $status, json_encode($value), $user_id);
    update_user_meta($user_id, 'content_approval_audios_updated', false);

    echo 'Ok';
    wp_die();
}


add_action('wp_ajax_action_experiences', 'action_experiences_callback');
function action_experiences_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $status = $_REQUEST["status"];
    $value = $_REQUEST["value"];

    
    if( have_rows('experience', 'user_' . $user_id) ): ;
        while ( have_rows('experience', 'user_' . $user_id) ) : the_row();

            if((string)in_array(get_sub_field('category')->term_id, $value)){
                update_sub_field('sci_experience_approved', $status);
            }
        endwhile;
    endif;

    AddLog('Experience', $status, json_encode($value), $user_id);
    update_user_meta($user_id, 'content_approval_experience_updated', false);

    echo 'Ok';
    wp_die();
}

add_action('wp_ajax_history_tab', 'history_tab_callback');
function history_tab_callback() {
    check_ajax_referer('approve content', 'security');
    $user_id = $_REQUEST["user_id"];
    $logs = get_field('content_log', 'user_' . $user_id);

    $datewiseArray = array();
    foreach($logs as $log){
         
        $dt = new DateTime($log["when_changed"]);
        $date = $dt->format('d-M-Y');

        if(!array_key_exists($date,$datewiseArray)){
            $datewiseArray[$date] = array();
        }

        if($log["what_changed"]["value"] == "Personal details"){
            if(!array_key_exists("Personal details",$datewiseArray[$date])){
                $datewiseArray[$date]["Personal details"] = array();
            }

            $data = array();
            $data["value"] = $log["value"];
            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;

            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Personal details"], $data);
        }else if($log["what_changed"]["value"] == "Introduction"){
            if(!array_key_exists("Introduction",$datewiseArray[$date])){
                $datewiseArray[$date]["Introduction"] = array();
            }

            $data = array();
            $introduction = explode(';',$log["value"]);
            

            foreach($introduction as $intro){
                
                $thisIntro = explode(':',$intro);
                // var_dump($thisIntro[1]);
                if(trim(strip_tags($thisIntro[0])) == 'Text'){
                    $data["intro_text"] = $thisIntro[1];
                }
                if(trim(strip_tags($thisIntro[0])) == 'Camara'){
                    $data["intro_camara"] = strip_tags($thisIntro[1]) . ':' .strip_tags($thisIntro[2]);
                }
            }
            

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Introduction"], $data);
        }else if($log["what_changed"]["value"] == "Headshots"){
            if(!array_key_exists("Headshots",$datewiseArray[$date])){
                $datewiseArray[$date]["Headshots"] = array();
            }

            $data = array();
            $data['headshots'] =  strip_tags($log["value"]);         

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Headshots"], $data);
        }else if($log["what_changed"]["value"] == "Photos"){
            if(!array_key_exists("Photos",$datewiseArray[$date])){
                $datewiseArray[$date]["Photos"] = array();
            }

            $data = array();
            $data['photos'] =  strip_tags($log["value"]);         

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Photos"], $data);
        }else if($log["what_changed"]["value"] == "Videos"){
            if(!array_key_exists("Videos",$datewiseArray[$date])){
                $datewiseArray[$date]["Videos"] = array();
            }

            $data = array();
            $data['videos'] = json_decode(strip_tags($log["value"]));         

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Videos"], $data);
        }else if($log["what_changed"]["value"] == "Audios"){
            if(!array_key_exists("Audios",$datewiseArray[$date])){
                $datewiseArray[$date]["Audios"] = array();
            }

            $data = array();
            $data['audios'] =  strip_tags($log["value"]);         

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Audios"], $data);
        }else if($log["what_changed"]["value"] == "Experience"){
            if(!array_key_exists("Experience",$datewiseArray[$date])){
                $datewiseArray[$date]["Experience"] = array();
            }

            $data = array();
            $data['experience'] =  json_decode(strip_tags($log["value"]));         

            $data["status"] = $log["status"]["label"];

            $datetime = new DateTime($log["when_changed"]);
            $time = $datetime->format('h:i A');
            $data["time"] = $time;


            usort($$data, function ($a, $b) {
                return -1 * strcmp($a->time, $b->time);
            });

            array_push($datewiseArray[$date]["Experience"], $data);
        }
    }

    krsort($datewiseArray);

    ?>
        <?php foreach($datewiseArray as $key => $data){
            $approvedWhat = '';
            if(array_key_exists("Personal details",$data)){
                $approvedWhat = $approvedWhat . "Personal details,";
            }
            if(array_key_exists("Introduction",$data)){
                $approvedWhat = $approvedWhat . " Introduction,";
            }
            if(array_key_exists("Headshots",$data)){
                $approvedWhat = $approvedWhat . " Headshots,";
            }
            if(array_key_exists("Photos",$data)){
                $approvedWhat = $approvedWhat . " Photos,";
            }
            if(array_key_exists("Videos",$data)){
                $approvedWhat = $approvedWhat . " Videos,";
            }
            if(array_key_exists("Audios",$data)){
                $approvedWhat = $approvedWhat . " Audios,";
            }
            if(array_key_exists("Experience",$data)){
                $approvedWhat = $approvedWhat . " Experience,";
            }
            ?>

            

            <div>
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href=<?php echo "#date" . $key ?>>
                        <div class="row px-3 py-2">
                            <div class="col-8"><?php echo rtrim($approvedWhat, ','); ?></div>
                            <div class="col-4"><?php echo $key ?></div>
                        </div>
                    </a>
                </div>
                <div id=<?php echo "date" . $key ?> class="collapse " data-parent="#accordion">
                    <div class="card-body">
                        <?php if(array_key_exists("Personal details",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Personal Details
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Personal details"){ 
                                    foreach($row as $record) {
                                        $splittedDetails = explode(';',$record["value"]); ?>
                                            <div class="row">
                                                <div class="col-10">
                                                    <?php foreach($splittedDetails as $splittedDetail){ 
                                                        $labels = explode(':',$splittedDetail) ?>
                                                        <h6><?php echo strip_tags($labels[0] . "-". $labels[1]) ?></h6>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-2">
                                                    <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                        <?php if(array_key_exists("Introduction",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Introduction
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Introduction"){ 
                                    foreach($row as $record) { ?>
                                        <div class="row pt-3">
                                            <div class="col-10">
                                                <div class="row">
                                                    <?php if(array_key_exists("intro_camara",$record)) { ?>
                                                        <div class="col-4 border px-0">
                                                            <iframe width="100%" height="250px" src=<?php echo $record['intro_camara'] ?>>
                                                            </iframe>
                                                        </div>
                                                    <?php } 
                                                    if(array_key_exists("intro_text",$record)){ ?>
                                                        <div class="col-6 m-3">
                                                            <p>
                                                                <?php echo $record['intro_text'] ?>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                            </div>
                                        </div>
                                        <div class="hr-text hr-text-history">
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                        <?php if(array_key_exists("Headshots",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Headshots
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Headshots"){ 
                                    foreach($row as $record) { ?>
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="photo-grid pt-3">
                                                        <div class="row"> 
                                                            <?php foreach(json_decode($record["headshots"]) as $headshot) { ?>
                                                                <div class="column">
                                                                    <div class="border">
                                                                        <img src=<?php echo wp_get_attachment_url($headshot) ?> >
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                 <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                        <?php if(array_key_exists("Photos",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Photos
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Photos"){ 
                                    foreach($row as $record) { ?>
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="photo-grid pt-3">
                                                        <div class="row"> 
                                                            <?php foreach(json_decode($record["photos"]) as $photo) { ?>
                                                                <div class="column">
                                                                    <div class="border">
                                                                        <img src=<?php echo wp_get_attachment_url($photo) ?> >
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                 <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if(array_key_exists("Audios",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Audios
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Audios"){ 
                                    foreach($row as $record) { ?>
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="photo-grid pt-3">
                                                        <div class="row"> 
                                                            <?php foreach(json_decode($record["audios"]) as $audio) { ?>
                                                                <div class="col-11 pt-1 audioFile">
                                                                    <h5 class="pt-2"></h5>
                                                                    <h6></h6>
                                                                    <audio controls>
                                                                        <source src=<?php echo wp_get_attachment_url($audio) ?> >
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                 <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if(array_key_exists("Videos",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Videos
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Videos"){ 
                                    foreach($row as $record) { ?>
                                            <div class="row">
                                                <div class="col-10"> 
                                                   <?php
                                                    if( have_rows('videos', 'user_' . $user_id) ): ;
                                                        while ( have_rows('videos', 'user_' . $user_id) ) : the_row();
                                                            if(in_array(get_row_index(), $record["videos"])){ ?>
                                                                <div class="col-4 border px-0 video-block">
                                                                    <iframe width="100%" height="250px" src=<?php echo get_user_meta($user_id,  'videos_'.(get_row_index() - 1).'_video_link', true); ?>>
                                                                    </iframe>
                                                                    <p><?php echo get_sub_field('video_caption') ?></p>
                                                                </div>
                                                            <?php }
                                                        endwhile;
                                                    endif;
                                                   ?> 
                                                </div>
                                                <div class="col-2">
                                                 <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>



                        <?php if(array_key_exists("Experience",$data)){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="credit-title pr-3 credit-title-histoy">
                                        Experience
                                    </p>
                                </div>
                            </div>
                            <?php foreach($data as $rowKey => $row) { 
                                if($rowKey == "Experience"){ 
                                    foreach($row as $record) { ?>
                                            <div class="row">
                                                <div class="col-10"> 
                                                   <?php
                                                    if( have_rows('experience', 'user_' . $user_id) ): ;
                                                    while ( have_rows('experience', 'user_' . $user_id) ) : the_row();
                                                        $categoryId = get_sub_field('category')->term_id;
                                                        if(in_array($categoryId, $record["experience"])){ ?>
                                                            <div class="row">
                                                                <p class="col-2"><?php echo get_field('category_name_singular', 'term_' . $categoryId); ?></p>
                                                                <div class="col-10 pt-1">
                                                                    <?php if( have_rows('sections') ):
                                                                        while ( have_rows('sections') ) : the_row(); ?>
                                                                            <p><?php echo strip_tags(get_sub_field('content')) . " - (" . get_sub_field('year') . ")" ?> </p>                                                                        
                                                                        <?php endwhile;
                                                                    endif; ?>
                                                                </div>
                                                            </div>  
                                                        <?php }
                                                    endwhile;
                                                    endif;
                                                   ?> 
                                                </div>
                                                <div class="col-2">
                                                    <p class="time-badge"><?php echo $record["status"] . " at " . $record["time"] ?></p>
                                                </div>
                                            </div>
                                            <div class="hr-text hr-text-history">
                                            </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                    </div>
                </div>
            </div>
        <?php } ?>

            
    <?php
    
    wp_die();
}


function AddLog($what, $status, $value, $user_id){
    $log = get_field('content_log', 'user_' . $user_id) ? get_field('content_log', 'user_' . $user_id) : array();

    $newRow = array();

    $newRow["what_changed"] = array('value' => $what, 'label' => $what);
    $newRow["when_changed"] = date("Y/m/d h:i:s A");
    $newRow["value"] = $value;
    $newRow["status"] = array('value' => $status, 'label' => $status);

    array_push($log, $newRow);

    update_field(__sci_s("USER: Profile details", 'content_log')['key'],  $log , 'user_' . $user_id );
}



//listing
add_action('wp_ajax_get_profiles_list', 'get_profiles_list_callback');
function get_profiles_list_callback() {
    check_ajax_referer('approve content', 'security');
    $typeId = $_REQUEST["typeId"];

    $userList = array();
    if($typeId == 'new'){
        $newUsers_meta_queries = array('relation' => 'OR' , 
        array(
            'key'     => 'profile_status',
            'value'   => 'pending',
            'compare' => '=',
        ));
        $newUsersArgs = array(
            'role'          => 'subscriber',
            'fields'        => array( 'ID'),
            'meta_query'    => $newUsers_meta_queries
        );
        $userList = get_users($newUsersArgs);
    }else if($typeId == 'updated'){
        $meta_queries = array('relation' => 'AND' ,
        array('relation' => 'OR' , 
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
            ),
        ),
        array(
            'key'     => 'profile_status',
            'value'   => 'pending',
            'compare' => '!=',
        ),
        array(
            'key'     => 'profile_status',
            'value'   => 'rejected',
            'compare' => '!=',
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
    $userList = get_users($updatedContentArgs);

    }else if($typeId == 'rejected'){
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
        $userList = get_users($rejectedArgs);
    }


        if(!empty($userList)){
            foreach($userList as $updatedUser){ ?>
                <tr class="user-list">
                    <td><?php echo get_user_by('ID',$updatedUser->ID)->display_name ?></td>
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
        } else { ?>
            <tr class="user-list"><td colspan="4">Sorry! There are no records to show. </td></tr>
        <?php }


    echo json_encode($visibilityArray);
    wp_die();
}

?>