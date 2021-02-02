<?php
/* Template Name: Welcome Page */

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
        // End of the loop.
        ?>
       
        
    <!-- Pagination -->
    <ul class="nav jp-nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="#">Get Started</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-none d-sm-block" href="#">Physical Attributes</a>
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
            <a href="#" class="btn btn-primary px-5 py-2 my-3">Next</a>
          </div>
        </div>
      </section>


       


<?php
get_sidebar();
get_footer();
?>
