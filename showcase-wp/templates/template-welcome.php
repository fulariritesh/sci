<?php
/* Template Name: Welcome Page */

if (!is_user_logged_in() ) {
  wp_redirect(home_url()); exit;
} 
get_header();

include('join-pagination.php');
?>   
	<section class="wel-msg d-flex justify-content-center py-5">
		<div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm p-0">
			<div class="card-header">Welcome to Showcase India,</div>
			<div class="card-body px-4">
			<p class="card-text">
			We are so thrilled to have you be a part of our global community of talent. 
			<br>
			Let's get started on your showcase right away by filling out your profile.
			</p>

			<a href="<?php echo get_page_link(get_page_by_path('profile-details')); ?>" class="btn btn-primary px-5 py-2 my-3">Let's Go!</a>
			</div>
		</div>
	</section>
<?php
get_sidebar();
get_footer();
?>
