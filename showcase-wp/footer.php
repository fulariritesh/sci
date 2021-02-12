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
        <div class="col-12 col-lg-4 pt-3 pt-lg-0 ourlinks"> 
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
        <div class="col-12 col-lg-4 pt-5 pt-lg-0 d-none d-lg-block">
          <h5 class="blockTitle">Our Latest News</h5>
          <div class="line pb-2">
          	<span class="color-1"></span>
          	<span class="color-2"></span>
          </div>
			<div class="clear"></div>
          <?php foreach (wp_get_recent_posts(["numberposts" => 3], "OBJECT") as $index => $post): ?>
          	<div class="row news-post post-<?php echo $post->ID; ?> pt-3">
          		<div class="col-sm-3 image">
          			<img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>">
          		</div>
          		<div class="col-sm-8 content">
					<div class="title postTitle">	
	          			<?php echo $post->post_title; ?>
	          		</div>
	          		<div class="date subscribesmalltext pt-2">
	          			<i class="far fa-calendar-alt"></i> <?php echo $post->post_date; ?>
	          		</div>
          		</div>
          	</div>
          <?php endforeach ?>
        </div>
        <div class="col-12  col-lg-4 pt-5 pt-lg-0">
          <h5 class="blockTitle">Subscribe</h5>
          <div class="line"><span class="color-1"></span><span class="color-2"></span></div>
          <div class="subscribe">Subscribe for a newsletter</div>
          <div class="subscribesmalltext pb-3">Want to be notified about new locations? <br/>Just sign up.</div>
          <form>
            <input type="text" name="" class="form-control" placeholder="Enter your email" />
            <div class="pt-3 subscribesmalltext">
            <input type="checkbox" name="" value="agree" class=""> I agree with the <a href="">Privacy Policy</a>
          </div>
          <button class="btn btn-sm btn-add mt-2">Submit</button>
          </form>

          <div class="socialmedia pt-4 text-center text-lg-left">
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
    <div class="container-fluid footerBottom pb-3">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 text-left text-sm-right order-sm-8 p-2">
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
          <div class="col-sm-4 prder-sm-1 p-2">
          	<a href="<?php echo esc_url( __( get_site_url('/'), 'showcase' ) ); ?>">
				      <?php printf( esc_html__( '© Showcaseindia 2021', 'showcase' ) ); ?>
			      </a>
          </div>
        </div>
      </div>
    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</div>
</body>
</html>
