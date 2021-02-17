<?php
/* Template Name: Complete Page */

if (!is_user_logged_in() ) {
  wp_redirect(get_page_link(get_page_by_path('login'))); exit;
} 


get_header();

include('join-pagination.php');

?>



<?php


get_sidebar();
get_footer();

?>