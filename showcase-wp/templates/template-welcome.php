<?php
/* Template Name: Welcome Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 
get_header();

include('page_ids.php'); 

?>  
      <!-- Pagination -->
      <ul class="nav jp-nav justify-content-center">
          <li class="nav-item act">
          <a class="nav-link" href="<?php echo get_page_link($welcome_page); ?>">Get Started</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="<?php echo get_page_link($profile_details_page); ?>">Details</a>
          </li>
          <li class="nav-item">
          <a class="nav-link d-none d-sm-block" href="physical-attributes.html">Physical Attributes</a>
          <a class="nav-link d-block d-sm-none"> Attributes</a>
          </li>
          <li class="nav-item">
          <a class="nav-link d-none d-sm-block" href="#">Add a headshot</a>
          <a class="nav-link d-block d-sm-none">Headshot</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="#">Complete</a>
          </li>
      </ul>  
      <section class="wel-msg d-flex justify-content-center py-5">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm p-0">
          <div class="card-header">Welcome!</div>
          <div class="card-body px-4">
            <p class="card-text">
              Thanks for your interest in Showcase India. As one of the largest
              Talent platform, we connect millions of businesses with
              professionals like you.
            </p>
            <p>Fill out the profile to get started.</p>
            <a href="<?php echo get_page_link($profile_details_page); ?>" class="btn btn-primary px-5 py-2 my-3">Next</a>
          </div>
        </div>
      </section>
<?php
get_sidebar();
get_footer();
?>
