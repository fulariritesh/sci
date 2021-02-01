<?php
/* Template Name: Email verification Page */

include('page_ids.php'); 

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
                <a href="<?php echo get_page_link($contact_administrator_page); ?>">contact administrator</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="revModal" tabindex="-1" aria-labelledby="revModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Resend Verification Email
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

<?php
get_sidebar();
get_footer();
?>
<script>
    var userEmail = "<?php echo $user_email; ?>";
</script>
