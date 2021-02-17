<?php
/* Template Name: Signup Page */

if(isset($_SESSION['user_profession'])){
	if(count($_SESSION['user_profession']) < 1){
		wp_redirect(get_page_link(get_page_by_path('category-subcategory'))); exit;
	}
}else{
	wp_redirect(get_page_link(get_page_by_path('category-subcategory'))); exit;
}

get_header();

?>
             
	<section class="sign-up d-flex justify-content-center py-5">
		<div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm">
			<div class="card-body">
			<h4 class="text-center font-weight-bold py-4">
			Sign up for your free </br>Showcase India account!
			</h4>
			<div class="pb-4">
				<button class="btn btn-signup-fb btn-block btn-lg btn-xs">
					Sign Up with Facebook
				</button>
				<button class="btn btn-signup-gm btn-block btn-lg btn-xs">
					Sign Up with Gmail
				</button>
			</div>
              <!-- <div class="py-4">
                <div class="or text-center">or</div>
                <hr class="" />
              </div> -->
			<div class="hr-or">
				<span class="credit-title px-3">
				Or
				</span>
			</div>
			
			<?php 
				echo do_shortcode('[ultimatemember form_id="329"]'); 

				/*Dev*/ 
				// echo do_shortcode('[ultimatemember form_id="8"]');
			?>

			<p class="text-center mt-4">
				Already a member? <a href="<?php echo get_page_link(get_page_by_path('login')); ?>">Log In</a>
			</p>
			</div>
		</div>
	</section>

<?php
get_sidebar();
get_footer();
?>
