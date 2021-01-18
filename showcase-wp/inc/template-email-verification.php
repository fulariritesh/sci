<?php
/* Template Name: Email verification Page */
$user_email = $_SESSION["user_args"]["submitted"]["user_email"];
// $user_email = 'test@example.com';

if(!$user_email){
	wp_redirect( home_url() ); exit;
}

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
        ?>
        Thank you, Please confirm your email to complete registration.
        <br>
        Click on the button in the email we sent to <?php echo $user_email ?> and you'll be on your way.
        <br>
        Didnt recieve the email ? check spam folder!
        <br>
        <span style="color:blue; cursor: pointer;" id="sci-rve">Send email again</span>or<a href="#" style="color:blue;" >contact administrator</a>
        
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

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>
<script>
// var userID = "<?php //echo $_SESSION['user_id']; ?>";
var userEmail = "<?php echo $_SESSION["user_args"]["submitted"]["user_email"]; ?>";
</script>
