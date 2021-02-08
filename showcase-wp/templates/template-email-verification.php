<?php
/* Template Name: Email verification Page */

$user_email = $_SESSION["user_args"]["submitted"]["user_email"];

if(!$user_email){
	wp_redirect( home_url() ); exit;
}

get_header();
?>  
    <section class="email-con d-flex justify-content-center py-5">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm">
            <div class="card-body text-center">
                <i class="far fa-envelope fa-5x my-4"></i>
                <h4 class="ty font-weight-bold">Thank you!</h4>
                <h4 class="um py-2">
                Please verify your email address to complete your registration.
                </h4>
                <p>
                Click the button in the email we have sent you on <?php echo $user_email; ?>  to Verify Your Account
                </p>
                <hr class="my-4" />
                <p>Didn't get the email?</p>
                <p>
                check your spam folder! <br />
                or
                <br>
                <a id="sci-rve" href="#">Resend verification email</a> or
                <a href="<?php echo get_page_link(get_page_by_path('contact-administrator')); ?>">contact administrator</a>
                </p>

                <!-- response message -->
				<div id="resEmailVerification">
				</div>

            </div>
        </div>
    </section>

<?php
get_sidebar();
get_footer();
?>
<script>
    var userEmail = "<?php echo $user_email; ?>";
</script>
