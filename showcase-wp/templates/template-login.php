<?php
/* Template Name: Login Page */

get_header();

?>

<section class="login reg-bg container-fluid py-5">
    <div class="row">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm mx-auto">
        <div class="card-body">
            <h4 class="text-center font-weight-bold py-4">Welcome back!</h4>
            <div class="pb-4">
            <button class="btn btn-signup-fb btn-block btn-lg btn-xs">
                Log in with Facebook
            </button>
            <button class="btn btn-signup-gm btn-block btn-lg btn-xs">
                Log in with Gmail
            </button>
            </div>
            <div class="hr-or">
            <span class="credit-title px-3"> Or </span>
            </div>
            <?php 
				echo do_shortcode('[ultimatemember form_id="330"]'); 

				/*Dev*/ 
				//echo do_shortcode('[ultimatemember form_id="9"]');
			?>
            <div class="row mt-4 xs-txt">
            <p class="col-12 col-md-6">
                <a href="<?php echo get_page_link(get_page_by_path('reset-password')); ?>">Forgot password?</a>
            </p>
            <p class="col-12 col-md-6">
                Not a member? <a href="<?php echo get_page_link(get_page_by_path('signup')); ?>">Sign Up</a>
            </p>
            </div>
        </div>
        </div>
    </div>
</section>

<?php
get_sidebar();
get_footer();
?>