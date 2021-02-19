<?php
function discover_talent_scripts() {
    
    wp_register_script('discover-talent-script', get_stylesheet_directory_uri() . '/js/discover-talent.js', array('jquery'), null, true);
    if(is_page('discover-talent-2')){
        wp_enqueue_script('discover-talent-script'); 
    }
    wp_localize_script(
		'discover-talent-script',
		'DISCOVER',
		array(
			'url' => rest_url(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'discover_talent_scripts' );

/**
 * Register custom hooks.
 */
require get_template_directory() . '/inc/discover-talent-rest-server.php';

?>