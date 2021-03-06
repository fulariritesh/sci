<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Showcase
 */

get_header();
if (is_user_logged_in()):
$current_user = wp_get_current_user();
endif;
?>
	<style text="text/css">
		.selectedcategories span.badge {
			padding: 5px 31px;
			font-weight: 500;
			font-size: 22px;
			border-radius: 15px;
			padding-right: 28px;
			margin-right: 2px;
			margin-bottom: 5px;
		}
		.liked{color:blue;}
	</style>
  <div class="bodyBG">
  <?php $args = array( 'role' => 'subscriber',
		'meta_query' => array(
			array(
				'key'   => 'spotlight-toggle',
				'value' => '1',
			)
		)
	);
		$users = get_users( $args );
		foreach ( $users as $user ) {
			// Creating the var user_ID to use with ACF Pro
			$user_id = 'user_'. esc_html( $user->ID );
		}
	?>
    <section class="container-fluid">
        <div class="container px-0">
            <div class="spotlight-bannerbg col-sm-8 mx-auto py-3 p-md-5 row mt-3" style="background-image: url('<?php echo (get_field('banner_image'))?>')">
                <div class="col-sm-6 col-md-10 pt-4 px-0 mx-auto">
                    <h2 class="text-center pb-3"><?php echo (get_field('banner_title'))?></h2>
                    <h5 class="text-justify"><?php echo (get_field('banner_subtitle'))?></h5>
                    <!-- <button class="btn btn-plain btn-lg mt-3">Find People</button> -->
                </div>
            </div>
			<!-- Spotlight search div  -->
			<?php if (current_user_can('toggle_spotlight_btn')):?>
				<div class="input-group col-sm-8 mx-auto px-0 row my-5">
					<input type="text" class="form-control" placeholder="Search Spotlight" aria-label="Search Spotlight" aria-describedby="button-addon2">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
					</div>
				</div>
			<?php endif;?>
            <div class="col-sm-8 mx-auto px-0 row mt-3">
                <div class="hr-text text-center">
                    <span class="spotlightbadge">
                    Today's Pick
                    </span>
                 </div>
            </div>
			<?php foreach ($users as $key => $value ): ?>
				<div class="spotlightpost pt-3">
						<?php
						$obj_id = $value->ID;
						$data = get_user_meta($obj_id);
						$user_info = get_userdata($obj_id); ?>
						<div class="col-sm-8 mx-auto row mt-3 pb-4 post border">
						<?php if (get_field('sci_user_headshots', 'user_' . $obj_id)): ?>
							<div class="col-12 col-sm-6 pt-4">
								<img src="<?php echo get_field('sci_user_headshots', 'user_' . $obj_id)[0]['sci_user_headshot']['url']; ?>">     
							</div>
						<?php endif ?>
						<div class="col-12 col-sm-6 profile-personaldetails pt-5">
							<h1><a href="<?php echo get_author_posts_url($obj_id); ?>"><?php echo $data['first_name'][0] . " " . $data['last_name'][0]; ?>	</a></h1>
							<h5><i class="fas fa-map-marker-alt pr-2"></i> <?php echo get_field('sci_user_location', 'user_' . $obj_id ,false); ?>, India</h5>
							<h5><i class="fas fa-venus-mars"></i> <?php echo get_field('sci_user_gender', 'user_' . $obj_id); ?></h5>
							<?php if (get_field('profession', 'user_' . $obj_id)): ?>
								<div class="selectedcategories">
									<?php
									$parents = [];
									foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
										$child = get_term($key);
										$termParent = ($child->parent == 0) ? $child : get_term($child->parent, 'jobs');
										array_push($parents, $termParent->term_id);
									}
									foreach (array_unique($parents) as $key) { ?>
										<span class="badge mt-2" style="background: <?php echo get_field('badge_color', 'term_' . $key); ?>">
											<?php echo get_field('category_name_singular', 'term_' . $key); ?>
										</span>									
									<?php }?>
								</div>
							<?php endif; ?>
							<div class="selectedsocialmedia pt-3">
								<style type="text/css">
									.sci-icon {
										font-size: 1.5rem;
										padding: 5px;
										border-radius: 3px;
										color: #002f43;
									}
								</style>
								<?php if (get_field('sci_user_social_links_instagram', 'user_' . $obj_id)): ?>
								<a href="<?php echo get_field('sci_user_social_links_instagram', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
									<i class="sci-icon fab fa-instagram" aria-hidden="true"></i>
								</a>
								<?php endif; ?>
								<?php if (get_field('sci_user_social_links_facebook', 'user_' . $obj_id)): ?>
								<a href="<?php echo get_field('sci_user_social_links_facebook', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
									<i class="sci-icon fab fa-facebook" aria-hidden="true"></i>
								</a>
								<?php endif; ?>
								<?php if (get_field('sci_user_social_links_twitter', 'user_' . $obj_id)): ?>
								<a href="<?php echo get_field('sci_user_social_links_twitter', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
									<i class="sci-icon fab fa-twitter" aria-hidden="true"></i>
								</a>
								<?php endif; ?>
								<?php if (get_field('sci_user_social_links_youtube', 'user_' . $obj_id)): ?>
								<a href="<?php echo get_field('sci_user_social_links_youtube', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
									<i class="sci-icon fab fa-youtube" aria-hidden="true"></i>
								</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col-sm-8 row mx-auto post likebar">
						<div class="col-6 col-sm-6 py-2">
							<!-- <a href="#" onclick="addLike()"> -->
								<!-- <svg class="icon b4-click"> -->
									<!-- <use xlink:href="images/pa-icons/like.svg#like" ></use> -->
								<!-- </svg> -->
							<!-- </a> -->
						<?php if (!is_user_logged_in(  )): ?>
							<p class="text-muted">
									Please log In to like posts
							</p>
							<?php endif;?>	
						</div>
						<div class="col-6 col-sm-6 py-2 text-right">
							<?php if (is_user_logged_in()): ?>
								<?php if (!!get_field('likes', 'user_'. $obj_id)): ?>
									<?php if (in_array($current_user->ID,get_field('likes', 'user_'. $obj_id))):?>
										<span class="profile-like-box" data-user="<?php echo $obj_id;?>" id="<?php echo $obj_id;?>">
											<i class="fas fa-thumbs-up liked"></i>
										<span class="profile-like-count">
											<?php echo (count(get_field('likes', 'user_'. $obj_id))); ?> 
										</span>
										</span>
										<?php else : ?>
										<span class="profile-like-box" data-user="<?php echo $obj_id;?>">
											<i class="fas fa-thumbs-up"></i>
										<span class="profile-like-count">
											<?php echo (count(get_field('likes', 'user_'. $obj_id))); ?> 
										</span>
										</span>
									<?php endif;?>
								<?php else : ?>
									<span class="profile-like-box" data-user="<?php echo $obj_id;?>">
											<i class="fas fa-thumbs-up"></i>
									<span class="profile-like-count">0</span>
								<?php endif; ?>	
							<?php else :?>
								<span class="profile-like-count">
									<?php echo get_field('likes', 'user_'. $obj_id)?(count(get_field('likes', 'user_'. $obj_id))):0; ?> 
								</span>
							<?php endif;?>
							<span>likes</span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
        </div>
    </section>
  </div> 
<?php

get_sidebar();
get_footer();

