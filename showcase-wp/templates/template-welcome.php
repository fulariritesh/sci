<?php
/* Template Name: Welcome Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 
get_header();

include('page_ids.php'); 
include('join-pagination.php');
?>   
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
