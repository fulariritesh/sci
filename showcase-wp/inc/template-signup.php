<?php
/* Template Name: Signup Page */

get_header();
?>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

        endwhile; 
        //End of the loop.
        ?>
       
        
       <section class="sign-up d-flex justify-content-center py-5">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm">
          <div class="card-body">
            <h4 class="text-center font-weight-bold py-4">
              Get your free account
            </h4>
            <button class="btn btn-signup-fb btn-block btn-lg">
              Sign In with Facebook
            </button>
            <button class="btn btn-signup-gm btn-block btn-lg">
              Sign In with Gmail
            </button>
            <div class="py-4">
              <div class="or text-center">or</div>
              <hr class="" />
            </div>
            
            <?php echo do_shortcode('[ultimatemember form_id="8"]'); ?>

            <p class="text-center mt-4">
              Already a member? <a href="<?php echo esc_url( get_page_link( 105 ) ); ?>">Sign In</a>
            </p>
          </div>
        </div>
      </section>


       


<?php
get_sidebar();
get_footer();
?>
