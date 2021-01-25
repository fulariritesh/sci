<?php
function discover_talent_scripts() {
    // Register the script
    wp_register_script( 'discover-talent-script', get_stylesheet_directory_uri(). '/js/discover-talent.js', array('jquery'), false, true );
  
    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'load_matching_talents' ),
    );
    wp_localize_script( 'discover-talent-script', 'discover', $script_data_array );
  
    wp_enqueue_script( 'discover-talent-script' );
}
add_action( 'wp_enqueue_scripts', 'discover_talent_scripts' );

add_action('wp_ajax_load_matching_talents_by_ajax', 'load_matching_talents_by_ajax_callback');
add_action('wp_ajax_nopriv_load_matching_talents_by_ajax', 'load_matching_talents_by_ajax_callback');


function load_matching_talents_by_ajax_callback() {
    check_ajax_referer('load_matching_talents', 'security');
    get_template_part( '/inc/template-discover-talent-list' );
}


//load count
add_action('wp_ajax_get_matching_talents_count_by_ajax', 'get_matching_talents_count_by_ajax_callback');
add_action('wp_ajax_nopriv_get_matching_talents_count_by_ajax', 'get_matching_talents_count_by_ajax_callback');


function get_matching_talents_count_by_ajax_callback(){
    $args = array(
        'role' => 'subscriber',
        'meta_key'     => 'profession',
        'meta_value'   => array(''),
        'meta_compare' => 'NOT IN'
    );
    $allUsersWithProfession = get_users($args);
    echo count($allUsersWithProfession);

    wp_die();
}
?>