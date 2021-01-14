<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Showcase
 */

?>
<footer id="colophon" class="site-footer footer">
    <div class="container-fluid footerTop pb-5">
    <div class="container">
      <div class="row">
        <div class="col-12 footerlogo">
        	<?php the_custom_logo(); ?>
        </div>
      </div>
      <div class="row pt-3">
        <div class="col-sm-4 ourlinks"> 
          <h5 class="blockTitle">Our Links</h5>
          <div class="line"><span class="color-1"></span><span class="color-2"></span></div>
          <?php
                wp_nav_menu(
                  array(
                    'theme_location' => 'menu-footer',
                    'menu_id'        => 'footer-menu',
                    'menu_class'  => '',
                  )
                );
              ?>
        </div>
        <div class="col-sm-4">
          <h5 class="blockTitle">Our Latest News</h5>
          <div class="line">
          	<span class="color-1"></span>
          	<span class="color-2"></span>
          </div>
          <?php foreach (wp_get_recent_posts(["numberposts" => 3], "OBJECT") as $index => $post): ?>
          	<div class="news-post post-<?php echo $post->ID; ?>">
          		<div class="image">
          			<img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>">
          		</div>
          		<div class="content">
					<div class="title">	
	          			<?php echo $post->post_title; ?>
	          		</div>
	          		<div class="date">
	          			<?php echo $post->post_date; ?>
	          		</div>
          		</div>
          	</div>
          <?php endforeach ?>
        </div>
        <div class="col-12  col-md-4">
          <h5 class="blockTitle">Subscribe</h5>
          <div class="line"><span class="color-1"></span><span class="color-2"></span></div>
          <div class="subscribe">Subscribe for a newsletter</div>
          <div class="subscribesmalltext pb-4">Want to be notified about new locations? <br/>Just sign up.</div>
          <form>
            <input type="text" name="" class="form-control" placeholder="Enter your email" />
            <div class="pt-3 subscribesmalltext">
            <input type="checkbox" name="" value="agree" class=""> I agree with the <a href="">Privacy Policy</a>
          </div>
          </form>

          <div class="socialmedia pt-5 text-center text-md-left">
            <ul class="">
              <li class="">
                <a class="" href="#"
                  ><i class=" fab fa-facebook-f"></i
                ></a>
              </li>
              <li class="">
                <a class="" href=""
                  ><i class="fab fa-twitter"></i
                ></a>
              </li>
              <li class="">
                <a class="" href=""
                  ><i class="fab fa-instagram"></i
                ></a>
              </li>
              <li class="">
                <a class="" href=""
                  ><i class="fab fa-youtube"></i
                ></a>
              </li>
              <li class="">
                <a class="" href=""
                  ><i class=" fab fa-linkedin"></i
                ></a>
              </li>
             
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="container-fluid footerBottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
          	<a href="<?php echo esc_url( __( get_site_url('/'), 'showcase' ) ); ?>">
				<?php printf( esc_html__( '© Showcaseindia 2021', 'showcase' ) ); ?>
			</a>
          </div>
          <div class="col-sm-6 text-right">
            <ul>
              <li>
              	<a href="#">
              		Terms and conditions
              	</a>
              </li>
              <li>
              	<a href="#">
              		Privacy policy
              	</a>
              </li>
              <li>
              	<a href="#">
              		Sitemap
              	</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
