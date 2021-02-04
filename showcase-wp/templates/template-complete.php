<?php
/* Template Name: Complete Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 


get_header();

include('join-pagination.php');

?>



<?php


get_sidebar();
get_footer();

?>