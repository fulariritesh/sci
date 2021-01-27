<?php
function discover_talent_scripts() {
    
    wp_register_script('discover-talent-script', get_stylesheet_directory_uri() . '/js/discover-talent.js', array('jquery'), null, true);
    if(is_page('discover-talent')){
        wp_enqueue_script('discover-talent-script'); 
    }
}
add_action( 'wp_enqueue_scripts', 'discover_talent_scripts' );

/**
 * Register custom hooks.
 */
require get_template_directory() . '/inc/discover-talent-rest-server.php';

function sci_replace_repeater_field( $where ) {
    $where = str_replace( "meta_key = 'repeaterkey_$", "meta_key LIKE 'repeaterkey_%", $where );
    return $where;
}
add_filter( 'posts_where', 'sci_replace_repeater_field' );
?>