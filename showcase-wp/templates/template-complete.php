<?php
/* Template Name: Complete Page */

if (!is_user_logged_in() ) {
  wp_redirect(get_page_link(get_page_by_path('login'))); exit;
} 
$user_id = get_current_user_id();

get_header();

include('join-pagination.php');
?>

<section class="pr-details container-fluid py-5">
    <div class="row">
      <div class="card col-11 col-md-6 col-xl-4 shadow-sm mx-auto p-0">
        <div class="card-header">Congratulations<?php $fn = get_user_meta( $user_id, 'first_name', true);  echo ($fn) ?  ', '.$fn : ""; ?>!</div>
        <div class="card-body px-4">
          <p class="card-text">
            Your basic registration on Showcase India is now complete. Check
            out your profile completion rate below.
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card col-11 col-md-6 col-xl-4 shadow-sm mx-auto mt-2 p-0">
        <?php get_template_part('template-parts/template-profile-completion' ); ?>
      </div>
    </div>
</section>

<?php
get_sidebar();
get_footer();
?>