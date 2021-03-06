<?php
/**
 * The template for displaying edit profile page
 *
 * @package Showcase
 */

get_header();
$obj_id = wp_get_current_user()->data->ID;
$data = get_user_meta($obj_id);
$user_info = get_userdata($obj_id);
?>
<style type="text/css">

	.submit {
		position: relative;
	}
	.submit.loading {
	    padding-right: 30px;
	    position: relative;
	}
	.submit .editableform-loading {
	    display: inline-block;
	    width: 25px;
	    height: 25px;
	    top: calc(50%);
	    position: absolute;
	    transform: translateY(-50%);
	    right: 0;
	}
	.photogrid {
		flex-direction: column;
	}
	#imageGrid {
    /*	flex-direction: row;
	    flex-wrap: wrap;
	    display: flex;
	    align-items: flex-start;*/
	}
</style>
<style type="text/css">
    .packery:after {
      content: ' ';
      display: block;
      clear: both;
    }

    .grid-item {
    	float: left;
    	width: calc(33% - 10px);
    	background: transparent;
    	border: none;
    	overflow: hidden;
        position: relative;
    	border: 10px solid transparent;
    }
    .packery-item {
        float: left;
        width: calc(33% - 10px);
        background: #e6e5e4;
        border: 2px solid #b6b5b4;
        position: relative;
        display: flex;
        flex-direction: column;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }
    .packery-item.is-dragging,
    /* Packery adds class while transitioning to drop position */
    .packery-item.is-positioning-post-drag {
      //background: #EA0;
      z-index: 2; /* keep dragged item on top */
    }
    .packery-drop-placeholder {
      outline: 3px dashed #444;
      outline-offset: -6px;
      /* transition position changing */
      -webkit-transition: -webkit-transform 0.2s;
              transition: transform 0.2s;
    }
</style> 
<div class="bodyBG" id="edit-profile">
	<section class="container-fluid">
	    <div class="container px-0 ">
		    <div class="row">
		        <div class="col-6 col-sm-6 pt-3">
		           <h5>My Profile</h5>
		        </div>
		        <div class="col-6 col-sm-6 pt-3 text-right">
		            <a href="<?php echo get_author_posts_url($obj_id); ?>" class="btn btn-plain btn-sm shadow-sm" >View as Public</a>
		        </div>
		    </div>
			<?php get_template_part('template-parts/template-profile-completion' ); ?>
			<div class="row p-3 blockBG mb-3">
			    <div class="col-12 col-sm-6">
					<style type="text/css">
						#secondary-slider .splide__slide {
							background-position: top center !important;
						}
						.slider_headshot_thumbnail, .slider_headshot {
							margin-bottom: 1rem;
						}
						#image-slider .splide__slide {
							width: 42.7vw;
							height: 42.7vw;
							max-height: 462px;
							background-position-y: top !important;
						}
						.headshot {
							padding-top: 28px;
							padding-left: 13px;
						}
						.profile-personaldetails {
							padding-left: 63px;
							padding-top: 0;
							display: flex;
							justify-content: center;
							flex-direction: column;
						}
						.profile-personaldetails > h1 {
							margin-bottom: 23px;
							font-weight: 600;
							font-size: 44px;
							line-height: 1.1;
						}
						.profile-personaldetails > span {
							margin-bottom: 24px;
							font-size: 1.4rem;
							line-height: 1;
							position: relative;
							padding-left: 44px;
						}
						.profile-personaldetails > span i {
							position: absolute;
							left: 15px;
							top: 50%;
							transform: translate(-50%, -50%);
						}
						.selectedcategories {
							padding-top: 40px;
							margin-bottom: 65px;
						}
						.profile-personaldetails .selectedcategories span.badge {
							padding: 5px 31px;
							font-weight: 500;
							font-size: 22px;
							border-radius: 15px;
							padding-right: 28px;
							margin-right: 2px;
							margin-bottom: 5px;
						}						
						@media (max-width: 575px){
							#image-slider .splide__slide {
								height: calc(100vw - 60px);
							}
						}
					</style>
					<div class="headshot">				 
						<div id="image-slider" class="splide slider_headshot">
							<div class="splide__track">
								<ul class="splide__list">
									<?php
									// Check rows exists.
									if( have_rows('sci_user_headshots', 'user_' . $obj_id) ):
									    // Loop through rows.
									    while( have_rows('sci_user_headshots', 'user_' . $obj_id) ) : the_row();
									        // Load sub field value.
									        $sub_value = get_sub_field('sci_user_headshot'); ?>
									        <li  class="splide__slide">
									        	<img src="<?php echo $sub_value['url']; ?>">
												<?php 
													$approvalStatus = get_post_meta( $sub_value['ID'], 'is_approved', true );
													if($approvalStatus == "Updated"){
														?><span class="headshotpending-status"><i class="fas fa-question"></i></span> <?php
													}else if($approvalStatus == "Approved"){
														
														if(!get_post_meta( $sub_value['ID'], 'is_status_tag_viewed', false )[0]){
															update_post_meta( $sub_value['ID'], 'is_status_tag_viewed', true );
															?><span class="headshotapproved-status"><i class="fas fa-check" aria-hidden="true"></i></span> <?php
														}
													}else if($approvalStatus == "Rejected"){
														?><span class="headshotrejected-status"><i class="fas fa-exclamation"></i></span> <?php
													}
												?>
											</li>
									    <?php // End loop.
									    endwhile;
									// No value.
									else :
									    // Do something...
									endif;
									?>
								</ul>
							</div>
						</div>
						<?php 
						if( have_rows('sci_user_headshots', 'user_' . $obj_id) ): ?>
						<div id="secondary-slider" class="splide slider_headshot_thumbnail">
							<div class="splide__track">
								<ul class="splide__list">
									<?php
										// Loop through rows.												
									    while( have_rows('sci_user_headshots', 'user_' . $obj_id) ) : the_row();
									        // Load sub field value.
									        $sub_value = get_sub_field('sci_user_headshot'); ?>
									        <li  class="splide__slide" >
												<img src="<?php echo $sub_value['url']; ?>">
												<?php 
													$approvalStatus = get_post_meta( $sub_value['ID'], 'is_approved', true );
													if($approvalStatus == "Updated"){
														?><span class="headshotpending-status"><i class="fas fa-question"></i></span> <?php
													}else if($approvalStatus == "Approved"){
														if(!get_post_meta( $sub_value['ID'], 'is_status_tag_viewed', false )[0]){
															update_post_meta( $sub_value['ID'], 'is_status_tag_viewed', true );
															?><span class="headshotapproved-status"><i class="fas fa-check" aria-hidden="true"></i></span> <?php
														}
														
													}else if($approvalStatus == "Rejected"){
														?><span class="headshotrejected-status"><i class="fas fa-exclamation"></i></span> <?php
													}
												?>
												<div class="float-left">
													<?php echo (get_row_index() == 1) ? '<span class="text-primary m-2"  data-toggle="tooltip" data-placement="left" title="This is your profile picture." > <i class="fas fa-info-circle"></i></span>' : ''; ?>
												</div>
												<div class="float-right manageHeadshot" style="position: absolute; bottom: 0; right: 0;">
													<button class="btn btn-popup-edit" type="button" data-toggle="modal" data-target="#editheadshot" data-indexheadshot=<?php echo get_row_index(); ?>>
														<i class="fas fa-pen"></i>
													</button>
													<button class="btn btn-popup-del <?php echo (get_row_index() == 1) ? 'd-none' : ''; ?>" type="button"  data-toggle="modal" data-target="#deleteheadshot" data-indexheadshot=<?php echo get_row_index(); ?>>
														<i class="fas fa-trash-alt"></i>
													</button>
												</div>
											</li>
									<?php // End loop.
										endwhile;
										$usedHeadshots = count(get_field('sci_user_headshots', 'user_' . $obj_id));
										$emptyHeadshots = 4 - $usedHeadshots;
										for($i=($usedHeadshots+1); $i <= 4; $i++ ){
											echo 	'<li class="splide__slide defaultHeadshot"> 
														<i class="fas fa-user"></i>
														<div class="float-right manageHeadshot" style="position: absolute; bottom: 0; right: 0;">
															<button class="btn btn-popup-edit" type="button" data-toggle="modal" data-target="#editheadshot" data-indexheadshot="'.$i.'">
																<i class="fas fa-pen"></i>
															</button>
														</div>			
													</li>';
										}
									?>
								</ul>
							</div>
						</div>
						<?php // No value.
						else :
						    // Do something...
						endif; ?>
					</div>
					<div class="col-12 text-center pb-2 bestHeadshot">
					<span class=""  data-toggle="tooltip" data-placement="top" title="Best Headshot Examples" > <i class="fas fa-info-circle"></i></span> <a href="#" data-toggle="modal" data-target="#bestheadshot" >Examples</a> of best headshot images
					</div>
			    </div>
			    <div class="col-12 col-sm-6 profile-personaldetails pt-5">
		            <div id="editable-form" class="editable-form">
						<div class="form-group row"> 
							<?php 
								$approvalStatus = get_user_meta( $obj_id, 'basic_details_are_approved', true );
								if($approvalStatus == "Updated"){
									?><span class="textpending-status">Pending</span><?php
								}else if($approvalStatus == "Approved"){
									if(!get_user_meta( $obj_id, 'tag_visibility_is_basic_details_tag_viewed', true )){
										update_post_meta( $obj_id, 'tag_visibility_is_basic_details_tag_viewed', true );
										?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
									}
									
								}else if($approvalStatus == "Rejected"){
									?><span class="textrejected-status">Rejected</span> <?php
								}
							?>
						</div>	
		                <div class="form-group row"> 
		                     <h1>
		                     	<a id="name" data-type="text" data-pk="1" class="editable editable-click" data-abc="true" >
		                     		<?php echo $data['first_name'][0]; ?>
		                     	</a>
		                     </h1>
		                </div>
		                <div class="form-group row"> 
		                    <h5>
		                    	<i class="fas fa-envelope pr-2"></i>
		                    	<span><?php echo $user_info->data->user_email; ?></span>
		                    </h5>
		                </div>
		                <?php if (get_field('sci_user_mobile', 'user_' . $obj_id)): ?>
		                <div class="form-group row"> 
		                    <h5>
		                    	<i class="fas fa-phone-alt pr-2"></i>
		                		<a id="phone" data-type="text" data-pk="1" class="editable editable-click" data-abc="true" >
		                			<?php echo get_field('sci_user_mobile', 'user_' . $obj_id); ?>
		                		</a>
		                    </h5>
		                    <label class="switch ml-4">
		                        <input type="checkbox" id="togBtn" <?php echo !!get_field('hide_number', 'user_' . $obj_id) ? 'checked' : ''; ?>>
		                        <div class="slider round">
		                         <!--ADDED HTML -->
		                         <span class="on">Show</span>
		                         <span class="off">Hide</span>
		                         <!--END-->
		                        </div>
							</label>
		               	</div>
		               	<?php endif; ?>
						<?php if (get_field('sci_user_location', 'user_' . $obj_id)): ?>
		                <div class="form-group row"> 
		                    <h5>
		                    	<i class="fas fa-map-marker-alt pr-2"></i>
		                    	<a id="country" data-type="select" data-title="Select location" class="editable editable-click">
		                    		<?php echo get_field('sci_user_location', 'user_' . $obj_id, false); ?>
		                    	</a>
		                    </h5>
		                </div>
		                <?php endif ?>
		                <div class="form-group row"> 
		                	<?php if (get_field('sci_user_gender', 'user_' . $obj_id)): ?>
		                    <h5>
		                    	<i class="fas fa-venus-mars"></i> 
		                    	<a href="#" id="gender" data-type="select" data-pk="1" data-title="Select gender" class="editable editable-click" data-abc="true">
		                    		<?php echo get_field('sci_user_gender', 'user_' . $obj_id, false); ?>
		                    	</a> 
		                    </h5>
		                	<?php endif; ?>
		                </div>
						<?php if (get_field('sci_user_dob', 'user_' . $obj_id)): ?>
							<div class="form-group row"> 
								<h5>
									<i class="fas fa-birthday-cake"></i> 
									<a href="#" id="dob" data-type="date" data-pk="1" data-title="Select Birthday" class="editable editable-click" data-abc="true">
										<?php echo get_field('sci_user_dob', 'user_' . $obj_id); ?>
									</a> 
								</h5>
							</div>
						<?php endif; ?>
		            </div>
		        	<div class="text-right">
		        		<button class="btn btn-edit" data-toggle="modal" data-target="#editCat">
		        			Edit
		        		</button>
		        	</div>
					<?php if (get_field('profession', 'user_' . $obj_id)): ?>
						<div class="selectedcategories pt-1">
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
							<?php }

							?>
						</div>
					<?php endif ?>
		            <div class="selectedsocialmedia pt-1">
		            	<style type="text/css">
		            		.sci-icon {
								font-size: 1.5rem;
								padding: 5px;
								border-radius: 3px;
								color: #002f43;
		            		}
		            	</style>
		            	<div class="text-right"> <button class="btn btn-edit"  data-toggle="modal" data-target="#editSocialLinks">Edit</button></div>
		            	<a class="pr-1">
		                	<i class="sci-icon fab fa-instagram" aria-hidden="true"></i>
		                </a>
		                <a class="pr-1">
		                	<i class="sci-icon fab fa-facebook" aria-hidden="true"></i>
		                </a>
		                <a class="pr-1">
		                	<i class="sci-icon fab fa-twitter" aria-hidden="true"></i>
		                </a>
		                <a class="pr-1">
		                	<i class="sci-icon fab fa-youtube" aria-hidden="true"></i>
		                </a>
		            </div>
	        	</div>
	        </div>

	        <!-- Introduction  Block-->
	        <div class="row mb-3 p-3 blockBG">
	        	<style type="text/css">
	        		.introvideo {
	        			padding-top: 24px;
						padding-bottom: 19px;
	        		}
	        		.intro {
	        			padding-top: 35px;
	        		}
	        		.intro h4 {
						font-size: 2rem;
						line-height: 1;
						letter-spacing: -0.6px;
						margin-bottom: 33px;
	        		}
	        		.intro p {
	        			line-height: 1.44;
	        		}
	        	</style>
	        	<?php if (get_field('intro_to_camera', 'user_' . $obj_id)): ?>
	            <div class="col-12 col-sm-6 introvideo">
	                <?php echo get_field('intro_to_camera', 'user_' . $obj_id); ?>
					<?php 
						$approvalStatus = get_user_meta( $obj_id, 'intro_to_camera_is_approved', true );
						if($approvalStatus == "Updated"){
							?><span class="textpending-status">Pending</span><?php
						}else if($approvalStatus == "Approved"){
							if(!get_user_meta( $obj_id, 'tag_visibility_is_intro_to_camara_tag_viewed', true )){
								update_post_meta( $obj_id, 'tag_visibility_is_intro_to_camara_tag_viewed', true );
								?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
							}
							
						}else if($approvalStatus == "Rejected"){
							?><span class="textrejected-status">Rejected</span> <?php
						}
					?>
	            </div>
	        	<?php else : ?>
	        	<div class="col-sm-6 cameraIntro py-3">
	                <div class="col-12 pt-3 text-center">
	                    <h4>Intro to camera</h4>
	                </div>
	                <div class="col-12 text-center">
	                <p>Completing this section will increase your chances of being noticed by casting professionals.</p>
	                </div>
	                <div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-add" data-toggle="modal" data-target="#editIntro">Add Video</button></div>
	            </div>
	        	<?php endif; ?>

	        	<?php if (get_field('intro_text', 'user_' . $obj_id)): ?>
	            <div class="col-12 col-sm-6 intro">
	                <div class="row">
	                    <div class="col-6 col-sm-6 "> 
							<h4>Introduction  
								<?php 
									$approvalStatus = get_user_meta( $obj_id, 'intro_text_is_approved', true );
									if($approvalStatus == "Updated"){
										?><span class="textpending-status">Pending</span><?php
									}else if($approvalStatus == "Approved"){
										if(!get_user_meta( $obj_id, 'tag_visibility_is_intro_text_tag_viewed', true )){
											update_post_meta( $obj_id, 'tag_visibility_is_intro_text_tag_viewed', true );
											?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
										}
										
									}else if($approvalStatus == "Rejected"){
										?><span class="textrejected-status">Rejected</span> <?php
									}
								?>
							</h4>
						</div>
	                    <div class="col-6 col-sm-6 px-0 text-right">
	                        <button class="btn btn-edit" data-toggle="modal" data-target="#editIntro">Edit</button>
	                    </div>
	                </div>
	                <p><?php echo get_field('intro_text', 'user_' . $obj_id); ?></p>
	            </div>
	        	<?php else : ?>
	            <div class="col-sm-6 cameraIntro py-3">
	                <div class="col-12 pt-3 text-center">
	                    <h4>Introduction</h4>
	                </div>
	                <div class="col-12 text-center">
	                <p>Write a short introduction to yourself.</p>
	                </div>
	                <div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-add" data-toggle="modal" data-target="#editIntro">Add Intro</button></div>
	            </div>
	        	<?php endif; ?>
	        </div>

			<!-- Navigation Bar-->
	        <!-- <div class="row blockBG mt-3 "> -->
	            <nav id="navbar" class="navbar navbar-expand navbar-light navbarcolors sticky-top ">
	                <div class="" id="navbarNav">
	                  <ul class="navbar-nav">
	                    <li class="nav-item active">
	                      <a class="nav-link" href="#photos">Photo </a>
	                    </li>
	                    <li class="nav-item">
	                      <a class="nav-link" href="#videos">Video</a>
	                    </li>
	                    <li class="nav-item">
	                      <a class="nav-link" href="#audios">Audio</a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" href="#physical-attributes">Physical Attributes</a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" href="#credit-and-experience">Credit and Experience</a>
	                    </li>
						<?php if (get_field('profession', 'user_' . $obj_id)): ?>
								<?php
								$parents = [];
								foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
									$child = get_term($key);
									$termParent = ($child->parent == 0) ? $child : get_term($child->parent, 'jobs');
									array_push($parents, $termParent->term_id);
								}
								foreach (array_unique($parents) as $key) { ?>
									<li class="nav-item">
									<a class="nav-link" href="#<?php echo get_field('category_name_singular', 'term_' . $key); ?>"><?php echo get_field('category_name_singular', 'term_' . $key); ?></a>
									</li>								
								<?php 
								}
								?>				
						<?php endif ?>
	                  </ul>
	                </div>
	            </nav>
	        <!-- </div> -->

			<div id="photos" class="pt-5"></div>
			<div class="photogrid">
			    <?php if (get_field('photos', 'user_' . $obj_id)): ?>
				<div class="row">
					<div class="col-6 col-sm-6 pt-3 px-0">
						<h4>Photos (<?php echo get_field('photos', 'user_' . $obj_id)?count(get_field('photos', 'user_' . $obj_id)): 0; ?>)</h4>
					</div>
					<div class="col-6 col-sm-6 pt-3 px-0 text-right">
						<button class="btn btn-edit" data-toggle="modal" data-target="#managephotos">Edit</button>
						<button class="btn btn-add" data-toggle="modal" data-target="#addphotos">Add</button>
					</div>
				</div>
				<div class="row pt-2 photogrid">
					<div class="grid">
					<?php foreach ( get_field('photos', 'user_' . $obj_id) as $index => $obj): ?>
					<div class="grid-item">
						<a href="<?php echo $obj['url']; ?>" data-lightbox="roadtrip">
							<img src="<?php echo $obj['url']; ?>">					
							<?php 
								$approvalStatus = get_post_meta( $obj['ID'], 'is_approved', true );
								if($approvalStatus == "Updated"){
									?><span class="headshotpending-status"><i class="fas fa-question"></i></span> <?php
								}else if($approvalStatus == "Approved"){
									if(!get_post_meta( $obj['ID'], 'is_status_tag_viewed', false )[0]){
										update_post_meta( $obj['ID'], 'is_status_tag_viewed', true );
										?><span class="headshotapproved-status"><i class="fas fa-check" aria-hidden="true"></i></span> <?php
									}
									
								}else if($approvalStatus == "Rejected"){
									?><span class="headshotrejected-status"><i class="fas fa-exclamation"></i></span> <?php
								}
							?>				
						</a>
					</div>
					<?php endforeach;?>
					</div>
				</div>
			    <?php endif; ?>
			</div>
			
			<div id="videos" class="pt-5"></div>
			<!--Videos block-->
	        <div class="row mt- blockBG p-3">
				<style type="text/css">
					.iframe-container iframe {
						width: 100%;
					}
					.iframe-container.col-12 iframe {
						height: 500px;
					}
					.iframe-container.col-sm-4 iframe {
						height: 250px;
					}
	            </style>
				<div class="col-6 col-sm-6 pt-3 ">
					<h4>Videos (<?php echo get_field('videos', 'user_' . $obj_id)?count(get_field('videos', 'user_' . $obj_id)): 0; ?>)</h4>
				</div>
				<div class="col-6 col-sm-6 pt-3 text-right">
					<button class="btn btn-edit" data-toggle="modal" data-target="#manageVideos">Edit</button>
					<button class="btn btn-add" data-toggle="modal" data-target="#addvideo">Add</button>
				</div>
				<!-- Display user videos in reverse order  -->
				<?php $display_videos = array(); if( have_rows('videos', 'user_' . $obj_id) ): $i = 1; ?>
					<?php while ( have_rows('videos', 'user_' . $obj_id) ) : the_row(); ob_start(); $i++; ?>
						<div class="iframe-container profilevideos <?php echo get_row_index() == count(get_field('videos', 'user_' . $obj_id)) ? 'col-12 mt-2' : 'col-sm-4 pt-3'; ?>">
							<?php echo get_sub_field('video_link'); ?>
							<h5 class="pt-2 text-center"><?php echo get_sub_field('video_caption'); ?> 
							<?php 
									$approvalStatus = get_sub_field('is_approved')['value'];
									if($approvalStatus == "Updated"){
										?><span class="textpending-status">Pending</span><?php
									}else if($approvalStatus == "Approved"){
										if(!get_sub_field('is_status_tag_viewed')){
											update_sub_field('is_status_tag_viewed', true);
											?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
										}
										
									}else if($approvalStatus == "Rejected"){
										?><span class="textrejected-status">Rejected</span> <?php
									}
								?>
							</h5>	                				
						</div>
					<?php $display_videos[] = ob_get_clean(); endwhile; ?>
				<?php endif;
					$display_videos = array_reverse($display_videos);
					echo implode($display_videos);
				?>
			</div>

			<div id="audios" class="pt-5"></div>
	        <!--Audio block-->
	        <div class="row mt-3 blockBG p-3 audioblock">
	            <div class="col-6 col-sm-6 pt-3 "> <h4>Audio (<?php echo get_field('audios', 'user_' . $obj_id)?count(get_field('audios', 'user_' . $obj_id)): 0; ?>)</h4></div>
	            <div class="col-6 col-sm-6 pt-3  text-right">
	                <button class="btn btn-edit" data-toggle="modal" data-target="#manageAudio">Edit</button>
	                <button class="btn btn-add" data-toggle="modal" data-target="#addaudio">Add</button>
				</div>
				<!-- Display user audios in reverse order  -->
				<?php $display_audios = array(); if( have_rows('audios', 'user_' . $obj_id) ): $a = 1; ?>
						<?php while ( have_rows('audios', 'user_' . $obj_id) ) : the_row(); ob_start(); $a++; ?>
							<div class="col-12 pt-1  row">
								<div class="col-sm-6">
									
									<h5 class="pt-2"><?php echo get_sub_field('audio_title'); ?>
										<?php 
											$audioId = get_sub_field('audio_file')['ID'];
											$approvalStatus = get_post_meta( $audioId, 'is_approved', true );
											if($approvalStatus == "Updated"){
												?><span class="textpending-status">Pending</span><?php
											}else if($approvalStatus == "Approved"){
												if(!get_post_meta( $audioId, 'is_status_tag_viewed', false )[0]){
													update_post_meta( $audioId, 'is_status_tag_viewed', true );
													?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
												}
												
											}else if($approvalStatus == "Rejected"){
												?><span class="textrejected-status">Rejected</span> <?php
											}
										?>
									</h5>
									<h6><?php echo get_sub_field('audio_description'); ?></h6>													
								</div>
								<div class="col-sm-6 pt-3">
									<audio controls preload="metadata">
										<source src="<?php echo get_sub_field('audio_file')['url']; ?>" type="<?php echo get_sub_field('audio_file')['mime_type']; ?>">
										Your browser does not support the audio element.
									</audio>
								</div>
							</div>
						<?php $display_audios[] = ob_get_clean(); endwhile; ?>
				<?php endif; 
					$display_audios = array_reverse($display_audios);
					echo implode($display_audios);
				?>
	        </div>

			<div id="physical-attributes" class="pt-5"></div>
	        <!--Physical Attributes-->
	        <div class="row mt-3 physicalattribs">
	            <div class="col-9 col-sm-6 pt-3 px-0"><h4>Physical Features</h4></div>
				<div class="col-3 col-sm-6 pt-3 px-0 text-right">
					<button data-toggle="modal" data-target="#editPhysicalAttributes" class="btn btn-edit">Edit</button>
				</div>
	        </div>
	        <div class="row physicalfeatures justify-content-center pt-3">
	            <div class=" card">
	             	<div class="pa-height"><div class='sprite height-c'></div></div>
	             	<div class="card-title">
						Height<span>
						<?php $user_height_ft = get_field('sci_user_height_ft', 'user_' . $obj_id); echo ($user_height_ft) ? $user_height_ft.'ft' : 'Not Set';
							$user_height_in = get_field('sci_user_height_in', 'user_' . $obj_id); echo ($user_height_ft && $user_height_in) ? $user_height_in.'in' : '';
						?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-weight"><div class='sprite weight-c'></div></div>
					<div class="card-title">
						Weight<span>
						<?php $user_weight_kg = get_field('sci_user_weight_kg', 'user_' . $obj_id); echo ($user_weight_kg) ? $user_weight_kg.'kg' : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-ethnicity"><div class='sprite ethnicity-c'></div></div>
	                <div class="card-title">
						Ethnicity<span>
						<?php $user_ethnicity = get_field('sci_user_ethnicity', 'user_' . $obj_id); echo ($user_ethnicity) ? $user_ethnicity : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-chest"><div class='sprite chest-c'></div></div>
	                <div class="card-title">
						Chest<span>
						<?php $user_chest_in = get_field('sci_user_chest_in', 'user_' . $obj_id); echo ($user_chest_in) ? $user_chest_in.'in' : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-skincolor"><div class='sprite skincolor-c'></div></div>
	                <div class="card-title">
						Skin Color<span>
						<?php $user_skin_color = get_field('sci_user_skin_color', 'user_' . $obj_id); echo ($user_skin_color) ? $user_skin_color : 'Not Set'; ?>
						</span>
					</div>
	            </div>	        
	            <div class=" card">
	                <div class="pa-notset"><div class='sprite waist'></div></div>
	                <div class="card-title">
						Waist<span>
						<?php $user_waist_in = get_field('sci_user_waist_in', 'user_' . $obj_id); echo ($user_waist_in) ? $user_waist_in.'in' : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-notset"><div class='sprite eyecolor'></div></div>
	                <div class="card-title">
						Eye Color<span>
						<?php $user_eye_color = get_field('sci_user_eye_color', 'user_' . $obj_id); echo ($user_eye_color) ? $user_eye_color : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-notset"><div class='sprite hair-dye'></div></div>
	                <div class="card-title">
						Hair Color<span>
						<?php $user_hair_color = get_field('sci_user_hair_color', 'user_' . $obj_id); echo ($user_hair_color) ? $user_hair_color : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-notset"><div class='sprite hair-length'></div></div>
	                <div class="card-title">
						Hair Length<span>
						<?php $user_hair_length = get_field('sci_user_hair_length', 'user_' . $obj_id); echo ($user_hair_length) ? $user_hair_length : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	            <div class=" card">
	                <div class="pa-notset"><div class='sprite hair'></div></div>
	                <div class="card-title">
						Hair Type<span>
						<?php $user_hair_type = get_field('sci_user_hair_type', 'user_' . $obj_id); echo ($user_hair_type) ? $user_hair_type : 'Not Set'; ?>
						</span>
					</div>
	            </div>
	        </div>


	        <!-- ///////////////////////EXPERIENCE BLOCK//////////////////////////// -->

				<?php if (get_field('experience', 'user_' . $obj_id)): ?>
	                	


						<!-- //////////////////////// -->
						<!--Credit and Experience Block-->
						    <div id="credit-and-experience" class="pt-5"></div>
							<?php if (get_field('profession', 'user_' . $obj_id)):
									$arrYear = array();
									$arrCategory = array();

									foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
										$child = get_term($key);
										if ($child->parent == 0) {
											if( have_rows('experience', 'user_' . $obj_id) ):	
												while ( have_rows('experience', 'user_' . $obj_id) ) : the_row();
													$catKey = get_sub_field('category')->term_id;
													if($catKey == $child->term_id){ 
														if(!array_key_exists($catKey,$arrCategory)){
															$arrCategory[$catKey] = array();
														}

														$experienceApproved = get_sub_field('sci_experience_approved');
														$tagVisible = false;
														if($experienceApproved == 'Approved'){
															if(!get_sub_field('is_status_tag_viewed')){
																$tagVisible = true;
																update_sub_field('is_status_tag_viewed', true);
															}
															
														}
														
														if( have_rows('sections') ){
															while ( have_rows('sections') ) : the_row();
																$experience = new stdClass();
																$experience->content = strip_tags(get_sub_field('content'));
																$experience->year = get_sub_field('year');
																$experience->status = $experienceApproved;
																$experience->tagVisible = $tagVisible;
																array_push($arrCategory[$catKey], $experience);
															endwhile;

															usort($arrCategory[$catKey], function ($a, $b) {
																return -1 * strcmp($a->year, $b->year);
															});
														};
													};
												endwhile;		
											endif;
										}
									}
								endif;
								
								if(!empty($arrCategory)){
									foreach($arrCategory as $key => $obj){
										foreach($obj as $value){
											if(!array_key_exists($value->year,$arrYear)){
												$arrYear[$value->year] = array();
											}

											$experience = new stdClass();
											$experience->content = $value->content;
											$experience->category = $key;
											$experience->status = $value->status;
											$experience->tagVisible = $value->tagVisible;
											array_push($arrYear[$value->year], $experience);
										}
									}
								}
								if(!empty($arrYear)){
									krsort($arrYear);
								}

								?>

								
								<?php if(count($arrCategory) > 0 && count($arrYear)> 0 ){ ?>
									<div class="row mt-3 blockBG p-3 experienceblock">
										<div class="col-12 col-sm-6 pt-3">
											<!-- <div id="credit-and-experience" class="pt-5"></div> -->
											<h4>Credit and Experience</h4>
										</div>
										<div class="col-12 col-sm-6">
											<select class="form-control" id="year-category-toggle">
												<option value="category">Category</option>
												<option value="year">Year</option>
											</select>
										</div>
										<div class="col-12 pt-1 pt-3 pt-sm-0">

											
											<div id="experienceblock-category">
												<?php foreach($arrCategory as $key => $credits){ 
													if(!empty($credits)){ ?>
														<div class="hr-text">
															<span class="credit-title pr-3">
																<?php echo get_field('category_name_singular', 'term_' . $key); ?> 
															</span>
														</div>
														<ul>
															<?php foreach($credits as $credit){ ?>
																<li><?php echo $credit->content ?><span class="badge categorybadge"><?php echo $credit->year ?></span>
																	<?php
																		if($credit->status == "Updated"){
																			?><span class="textpending-status">Pending</span><?php
																		}else if($credit->status == "Approved" && $credit->tagVisible){
																			?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
																			
																		}else if($credit->status == "Rejected"){
																			?><span class="textrejected-status">Rejected</span> <?php
																		}
																	?>
																</li>
															<?php } ?>
														</ul>
													<?php }
												} ?>	
											</div>

											<div id="experienceblock-year">
												<?php foreach($arrYear as $key => $credits){ ?>
													<div class="hr-text">
														<span class="credit-title pr-3">
														<?php echo $key ?> 
														</span>
													</div>
													<ul>
														<?php foreach($credits as $credit){ ?>
															<li><?php echo $credit->content ?><span class="badge categorybadge"><?php echo get_field('category_name_singular', 'term_' . $credit->category); ?></span>
																<?php
																	if($credit->status == "Updated"){
																		?><span class="textpending-status">Pending</span><?php
																	}else if($credit->status == "Approved" && $credit->tagVisible){
																		?><span class="textapproved-status"><i class="fas fa-check"></i></span> <?php
																	}else if($credit->status == "Rejected"){
																		?><span class="textrejected-status">Rejected</span> <?php
																	}
																?>
															</li>
														<?php } ?>
													</ul>
												<?php } ?>	
											</div>

											<div class="col-sm-12 loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
										</div>
									</div>
								<?php } ?>
						<?php endif ?>								

								<?php 
									$allCategories = array();
									$categoriesWithProfession = array(); 
									$categoriesWithSubcategories = array();
								?>
								<?php if (get_field('profession', 'user_' . $obj_id)): 
									$formAdditionalFields = get_field('sci_form_additional_fields', 'option');
									foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
										$child = get_term($key);
										if ($child->parent == 0) { 
											array_push($allCategories, $child->term_id);?>
											<?php if( have_rows('experience', 'user_' . $obj_id) ): ?>	
												<?php while ( have_rows('experience', 'user_' . $obj_id) ) : the_row(); ?>
													<?php if(get_sub_field('category')->term_id == $child->term_id){
														array_push($categoriesWithProfession, $child->term_id);?>
														<div id="<?php echo get_field('category_name_singular', 'term_' . $child->term_id); ?>" class="pt-5"></div>
														<div class="row mt-3 blockBG p-3 cat-block">
															<div class="col-6 col-sm-4 col-lg-5 pt-3">
																<h4><?php echo get_field('category_name_singular', 'term_' . $child->term_id); ?></h4>
															</div>
															<div class="col-6 col-sm-2  col-lg-1 pt-3 text-right order-sm-11 ">
																<button class="btn btn-edit btn-add-experience" data-id=<?php echo $child->term_id ?>>Edit</button>
															</div>
															<div class="col-12 col-sm-6 col-lg-6 pt-3 text-left text-sm-right order-sm-6">
																<?php foreach($formAdditionalFields as $field){
																	if($field["sci_form_category"] == $child->term_id && in_array('experience_level',$field["sci_form_field"])){
																		if(get_sub_field('experience_level')) { ?>
																		<span class="badge experiencedbadge"> <i class="fas fa-check"></i> <?php echo get_sub_field('experience_level')["label"] ?></span>
																		<?php }
																	}
																} ?>
															</div>
														</div>
														<div class="row  blockBG cat-block pb-3">   
															<div class="col-12 pt-3 pt-sm-0">

																<?php 
																	$availableSubcategories =0;
																	foreach (get_field('profession', 'user_' . $obj_id) as $subCatIndex => $subCatkey) {
																		$childSubcat = get_term($subCatkey);
																				if ($childSubcat->parent == $child->term_id){
																					$availableSubcategories += 1;
																				}
																			} 
																	if($availableSubcategories > 0)	{	
																	?>

																		<div class="specialised-skills">
																			<div class="hr-text">
																				<span class="credit-title pr-3">
																				Specialised Skills
																				</span>
																			</div>
																			<p class="py-4"> 
																				<?php
																					foreach (get_field('profession', 'user_' . $obj_id) as $subCatIndex => $subCatkey) {
																						$childSubcat = get_term($subCatkey);
																						if ($childSubcat->parent == $child->term_id){ ?>
																							<span class="badge specialisedbadge"><i class="fas fa-check"></i> <?php echo get_field('category_name_singular', 'term_' . $childSubcat->term_id); ?></span>
																						<?php }
																					}
																				?>
																				
																			</p>
																		</div>
																	<?php } ?>
																
																<?php
																	foreach($formAdditionalFields as $field){
																		if($field["sci_form_category"] == $child->term_id){
																			foreach($field["sci_form_field"] as $fieldOption){
																				if($fieldOption != 'experience_level'){?>
																					<?php if(get_sub_field($fieldOption)) {?>
																						<div class=<?php echo $fieldOption ?>>
																							<div class="hr-text">
																								<span class="credit-title pr-3">
																									<?php 
																									echo ucfirst(str_replace("_"," ",$fieldOption));
																									?>
																								</span>
																							</div>
																							<p class="py-4">
																								
																									<?php if(array_key_exists('label',get_sub_field($fieldOption))) { ?>
																										
																											<span class="badge languagedbadge"><i class="fas fa-check"></i><?php echo get_sub_field($fieldOption)['label'] ?></span>	
																										 
																									<?php }else{ 	
																										foreach(get_sub_field($fieldOption) as $option){ ?>
																											<?php if(is_string($option)) { ?>
																												<span class="badge languagedbadge"><i class="fas fa-check"></i><?php echo $option ?></span>
																											<?php }else{
																												if($option['label'] != 'Others'){?>
																													<span class="badge languagedbadge"><i class="fas fa-check"></i><?php echo $option['label'] ?></span>	
																												<?php } else {
																													$otherOption = explode(',', get_sub_field($fieldOption. '-other'));
																													foreach($otherOption as $option){?>
																														<span class="badge languagedbadge"><i class="fas fa-check"></i><?php echo $option ?></span>
																													<?php }
																												} ?>
																											<?php } ?>
																									<?php }
																									} ?>
																							</p>
																						</div>
																					<?php }else{?>
																						
																					<?php } ?>
																				<?php }
																			}							
																		}
																	}
																?>
																		
																<?php if(get_sub_field('website')){ ?>
																	<div class="website">
																		<div class="hr-text">
																			<span class="credit-title pr-3">
																				<?php echo get_field('category_name_singular', 'term_' . $child->term_id); ?> Website
																			</span>
																		</div>
																		<p class="py-4"><?php echo get_sub_field('website') ?></p>
																	</div>
																<?php } ?>
																
																<?php if( have_rows('sections') ): ?>
																	<div class="experience">
																		<div class="hr-text">
																			<span class="credit-title pr-3">
																			<?php echo get_field('category_name_singular', 'term_' . $child->term_id); ?> Experience
																			</span>
																		</div> 
																	
																		
																			<ul><?php 
																			while ( have_rows('sections') ) : the_row(); ?>

																				<li><?php echo strip_tags(get_sub_field('content')) ?><span class="badge categorybadge"><?php echo get_sub_field('year') ?></span></li>
																			<?php endwhile; ?>
																			</ul>
																														
																	</div>
																<?php endif;?>			
															</div>
															<div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
														</div>
													<?php } ?>
												<?php endwhile; ?>
															
											<?php endif; ?>
										<?php }
										else{
											if(!in_array($child->parent, $categoriesWithSubcategories)){
												array_push($categoriesWithSubcategories, $child->parent);
											}
										}
									}
								endif; ?>

								<?php
								foreach($allCategories as $category)
									if(!in_array($category, $categoriesWithProfession)){?>
										<!--empty Block-->
										<div class="row mt-3 blockBG p-3 emptyblock">
											<div class="col-12 pt-3 text-center">
												<h4><?php echo get_field('category_name_singular', 'term_' . $category) ?></h4>
											</div>
											<div class="col-12 text-center">
											<p>Completing this section will increase your chances of being noticed by casting professionals.</p>
											</div>
											<div class="col-sm-12 loadMore text-center ">
												<button class="btn btn-md btn-full btn-primary px-5 btn-add-experience" data-id=<?php echo $category ?> >Add Details</button></div>
											</div>
									<?php }
								?>
							
					
						<!-- ///////////////////////EXPERIENCE BLOCK//////////////////////////// -->

		</div>
	</section>
</div>


<!-- category Modal -->
<div class="modal fade" id="editCat" tabindex="-1" aria-labelledby="editCatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-md-3 d-none d-lg-block">
            <!-- <img src="/images/footer-logo-grey.png" alt="logo"> -->
          </div>
          <div class="col-10 col-md-6">
            <h5 class="modal-title text-lg-center" id="editCatModalLabel">Manage Category</h5>
          </div>
          <div class="col-2 col-md-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-11 col-md-8 mx-auto">
              <p>Complete this section with as much detail as possible for better chances of being scouted</p>
            </div>
          </div>
          <form class="row" id="manage-category">
            <div class="col-12 col-lg-8 mx-auto accordion shadow-sm pt-4" id="accordion">
            	<?php 
            	$terms = get_terms( 'jobs', array(
				    'hide_empty' => false,
				    'parent' => 0
				) );

				?>
				<?php foreach ($terms as $Pindex => $parent) : ?>	
				<?php if (!count(get_term_children( $parent->term_id, 'jobs' ))) {continue;} ?>			
				<div class="accordion-group mb-3 mx-lg-5 card">
					<div class="row card-header collapsed p-2" id="headingTwo" type="button" data-toggle="collapse" data-target="#<?php echo $parent->slug ?>" aria-expanded="true" aria-controls="<?php echo $parent->slug ?>">
					<div class="col-3 pl-md-5">
						<svg class="icon">
							<use xlink:href="images/category-icons.svg#model" />
						</svg>
						<!-- <img src="./images/actors.png" alt="<?php echo $parent->name; ?>" /> -->
					</div>
					<div class="col-7 col-md-8">
						<p class="text-uppercase my-2 pt-1"><?php echo $parent->name; ?></p>
					</div>
					</div>
					<div id="<?php echo $parent->slug; ?>" class="collapse" aria-labelledby="headingOne">	
						<div class="accordion-inner card-body">
							<div class="btn-group-toggle" data-toggle="buttons">
								<?php foreach (get_term_children( $parent->term_id, 'jobs' ) as $Cindex => $child) : ?>
									<label class="btn btn-details-cat-subcat mb-1" data-category='<?php echo get_term_by( 'id', $child, 'jobs' )->term_id; ?>'>
										<input type="checkbox"/> <?php echo get_term_by( 'id', $child, 'jobs' )->name; ?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
					<!-- btns div -->
					<div class="d-flex justify-content-around py-4">
						<button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
						<div class="submit">
							<button class="btn btn-lg btn-popup-save px-4">Save</button>
						</div>
					</div>
				


            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- Add/Edit Headshot Modal -->
<div class="modal fade" id="editheadshot" tabindex="-1" aria-labelledby="editHeadshotModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
	<div class="modal-content">
	<div class="modal-header">
		<div class="col-md-3 d-none d-lg-block">
			<img src="/images/footer-logo-grey.png" alt="logo">
		</div>
		<div class="col-10 col-md-6">
			<h5 class="modal-title text-lg-center" id="editHeadshotModalLabel">Manage Headshot</h5>
		</div>
		<div class="col-2 col-md-3">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
	<div class="modal-body pr-details">
		<div class="row">
			<div class="card col-12 col-lg-8 mx-auto shadow-sm py-4">
			<div class="card-body">

				<!-- capture info -->
				<div class="capture-div">
					<ul class="text-muted">
					<li class="pb-2">Upload your introduction video on a public site like Youtube or Vimeo. Your profile should be set to public.</li>
					<li class="pb-2">Go to the video on the site you uploaded to and copy the link in your browser.</li>
					<li class="pb-2">Paste the video link in the box below and click 'Save'.</li>
					</ul>
				</div>
				<!-- upload-div info -->
				<div class="upload-div">
					<p>
					Crop headshot
					</p>
					<p class="text-muted">Click and drag the crop box to move and resize your headshot the way you'd like it to
					appear on your profile.
					</p>
				</div>
				<!-- Img preview -->
				<div class="img-preview">
					<video autoplay="true" id="videoElement"></video>
					<canvas id="canvas" class="d-none"></canvas>
					<img src="" alt="img-preview" class="img-preview-img">
					<span class="img-preview-default-txt">Image preview!</span>
				</div>
			
				<button class="btn btn-block btn-details-opncam btn-xs"><i class="fas fa-camera"></i> 
					Open Camera
				</button>

				<button class="btn btn-block btn-details-cptr btn-xs"><i class="fas fa-camera"></i> 
					Capture 
				</button>

				<button class="btn btn-block btn-details-fileup btn-xs"><i class="fas fa-upload"></i>
					Upload from device
				</button>
		
				<!-- upload input  -->
				<div class="upload-input">
					<label class="btn btn-custom-file-upload d-flex justify-content-center mt-4">
						<input type="file" name="hsFile" id="hsFile" />
						Choose file to upload
					</label>
				</div>	
				
				<!-- file-edit-btns -->
				<div class="file-edit-btns">
					<div class="d-flex justify-content-center py-4">			
					<button id="rotate-anticlock" class="btn btn-details-uphs btn-xs mx-2 px-4">
						<i class="fas fa-undo"></i>
					</button>
					<button id="rotate-clock" class="btn btn-details-uphs btn-xs mx-2 px-4">
						<i class="fas fa-undo fa-flip-horizontal"></i>
					</button>
					</div>
				</div>

				<!-- back-save-btns -->
				<div class="d-flex justify-content-around py-4">
					<button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
					<button id="saveHeadshot" class="btn btn-lg btn-popup-save px-4">Save</button>
				</div>

				<!-- response message -->
				<div id="resHeadshotWrapper" class="my-2"></div>
				<script>
				function headshotSuccess(){
					console.log('Refresh');
					window.location.reload();
				}
				</script>	
			</div>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
<!-- Delete Headshot Modal -->
<div class="modal fade" id="deleteheadshot" tabindex="-1" aria-labelledby="deleteheadshotLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteheadshotLabel">Confirm Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
				<p class="px-4 pb-3">
					Are you sure you want to delete the headshot?
				</p>
				<!-- btns div -->
				<div class="d-flex justify-content-end pb-4">
					<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
					<button id="deleteheadshotsave_submit" class="btn btn-lg btn-popup-delete">Delete</button>
				</div>   
			  
			  	<!-- response message -->
				<div id="resdeleteheadshotWrapper" class="m-2"></div>
          </div>

        </div>
    </div>
</div>

<!--Intro Modal -->
<div class="modal fade" id="manageHeadshot" tabindex="-1" aria-labelledby="editIntroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-md-3 d-none d-lg-block">
            <!-- <img src="/images/footer-logo-grey.png" alt="logo"> -->
          </div>
          <div class="col-10 col-md-6">
            <h5 class="modal-title text-lg-center" id="editHeadshotModalLabel">Manage Headshot</h5>
          </div>
          <div class="col-2 col-md-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
        <div class="modal-body pr-details">
          <div class="row">
            <div class="card col-12 col-lg-8 mx-auto shadow-sm py-4">
              <div class="card-body">

                <form action="">
                  <!-- capture info -->
                  <div class="capture-div">
                    <ul class="text-muted">
                      <li class="pb-2">Upload your introduction video on a public site like Youtube or Vimeo. Your profile should be set to public.</li>
                      <li class="pb-2">Go to the video on the site you uploaded to and copy the link in your browser.</li>
                      <li class="pb-2">Paste the video link in the box below and click 'Save'.</li>
                    </ul>
                  </div>
                <!-- upload-div info -->
                  <div class="upload-div">
                    <p>
                      Crop headshot
                    </p>
                    <p class="text-muted">Click and drag the crop box to move and resize your headshot the way you'd like it to
                      appear on your profile.
                    </p>
                  </div>

                  <!-- Img preview -->
                  <div class="img-preview">
                    <video autoplay="true" id="videoElement"></video>
                    <img src="" alt="img-preview" class="img-preview-img">
                    <span class="img-preview-default-txt">Image preview!</span>
                  </div>
                  <div class="invalid-feedback">
                    Opps error!
                  </div>
                  <!-- capture btn -->
                  <div class="capture-div">
                    <a type="button" class="btn btn-block btn-details-cptr btn-xs py-3" href=""><i class="fas fa-camera"></i> Capture from
                      Camera</a>
                    <button type="button" class="btn btn-block btn-details-fileup btn-xs py-3"><i class="fas fa-upload"></i>
                      Upload from device
                    </button>
                  </div>
                  <!-- uoload btn  -->
                  <div class="upload-div">
                    <label class="btn btn-custom-file-upload d-flex justify-content-center">
                      <input type="file" name="hsFile" id="hsFile" />
                      Choose file to upload
                    </label>
                  </div>

                  <!-- file-edit-btns -->
                  <div class="file-edit-btns">
                    <div class="d-flex justify-content-center py-4">
                      <button type="button" class="btn btn-details-uphs btn-xs mx-2 px-4">
                        <i class="fas fa-undo"></i>
                      </button>
                      <button type="button" class="btn btn-details-uphs btn-xs mx-2 px-4">
                        <i class="fas fa-undo fa-flip-horizontal"></i>
                      </button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-around py-4">
                    <button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-lg btn-popup-save px-4">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!--Intro Modal -->
<div class="modal fade" id="editIntro" tabindex="-1" aria-labelledby="editIntroModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <div class="col-md-3 d-none d-lg-block">
	        <!-- <img src="/images/footer-logo-grey.png" alt="logo"> -->
	      </div>
	      <div class="col-10 col-md-6">
	        <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Manage Introduction</h5>
	      </div>
	      <div class="col-2 col-md-3">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	    </div>
	    <div class="modal-body">
	      <div class="row">
	        <div class="card col-12 col-lg-8 mx-auto shadow-sm py-4">
	          <div class="card-body">
	            <form id="intro-form">
	              <h5 class="card-title">Add an Introduction to Camera</h5>
	              <p class="text-muted">A video introduction is your chance to make a great first impression. In this
	                video, be sure to focus on you. Share what inspires you and makes your talent unique.</p>
	              <ul class="text-muted">
	                <li class="pb-2">Upload your introduction video on a public site like Youtube or Vimeo. Your profile should be set to public.</li>
	                <li class="pb-2">Go to the video on the site you uploaded to and copy the link in your browser.</li>
	                <li class="pb-2">Paste the video link in the box below and click 'Save'.</li>
	              </ul>
	              <input class="form-control" type="text" placeholder="Paste your copied link here:" value="<?php echo get_field('intro_to_camera', 'user_' . $obj_id, false, false); ?> " />
	              <div class="invalid-feedback">
	                Opps error!
	              </div>
	              <div class="hr-text mt-3 mb-4"></div>
	              <h5 class="card-title">Introduction</h5>
	              <p class="text-muted">Write a short introduction to yourself.</p>
	              <div class="form-group">
	                <textarea class="form-control justify-content-center" maxlength="580" rows="4"><?php echo get_field('intro_text', 'user_' . $obj_id) ? get_field('intro_text', 'user_' . $obj_id) : ""; ?></textarea>
	                <span class="float-right text-muted pt-1"> max 180</span>
	              </div>
					<div class="d-flex justify-content-around py-4">
						<button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
						<div class="submit">
							<button class="btn btn-lg btn-popup-save px-4">Save</button>
						</div>
					</div>
	            </form>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>

<!-- Social links Modal -->
<div class="modal fade" id="editSocialLinks" tabindex="-1" aria-labelledby="editSocialLinksModalLabel"
aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
			  <div class="col-md-3 d-none d-lg-block">
			    <!-- <img src="/images/footer-logo-grey.png" alt="logo"> -->
			  </div>
			  <div class="col-10 col-md-6">
			    <h5 class="modal-title text-lg-center" id="editSocialLinksModalLabel">Manage Social Links</h5>
			  </div>
			  <div class="col-2 col-md-3">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			      <span aria-hidden="true">&times;</span>
			    </button>
			  </div>
			</div>
			<div class="modal-body">
			  <div class="row">
			    <div class="col-11 col-md-8 mx-auto text-center">
			      <p>Display your social media accounts, if any.</p>
			    </div>
			  </div>
			  <div class="row social-links">
			    <div class="card col-12 col-lg-8 mx-auto shadow-sm pt-4">
			      <div class="card-body">
			        <form id="social-icons">
			          <div class="form-group mt-4">
			            <div>
			              <!-- <img src="https://img.icons8.com/fluent/30/000000/instagram-new.png" />Instagram -->
			            </div>
			            <p class="url-eg">https://instagram.com/username</p>
			            <input class="form-control instagram" type="text" placeholder="Profile url" value="<?php echo get_field("sci_user_social_links_instagram", 'user_' . $obj_id) ?>" />
			          </div>
			          <div class="form-group mt-4">
			            <div>
			              <!-- <img src="https://img.icons8.com/color/30/000000/facebook.png" />Facebook -->
			            </div>
			            <p class="url-eg">https://www.facebook.com/username</p>
			            <input class="form-control facebook" type="text" placeholder="Profile url" value="<?php echo get_field("sci_user_social_links_facebook", 'user_' . $obj_id) ?>" />
			          </div>
			          <div class="form-group mt-4">
			            <div>
			              <!-- <img src="https://img.icons8.com/color/30/000000/twitter-squared.png" />Twitter -->
			            </div>
			            <p class="url-eg">https://twitter.com/username</p>
			            <input class="form-control twitter" type="text" placeholder="Profile url" value="<?php echo get_field("sci_user_social_links_twitter", 'user_' . $obj_id) ?>" />
			          </div>
			          <div class="form-group mt-4 pb-4">
			            <div>
			              <!-- <img src="https://img.icons8.com/color/30/000000/youtube-play.png" />Youtube -->
			            </div>
			            <p class="url-eg">https://www.youtube.com/channel/channelname</p>
			            <input class="form-control youtube" type="text" placeholder="Profile url" value="<?php echo get_field("sci_user_social_links_youtube", 'user_' . $obj_id) ?>" />
			          </div>
					<div class="d-flex justify-content-around py-4">
						<button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
						<div class="submit">
							<button class="btn btn-lg btn-popup-save px-4">Save</button>
						</div>
					</div>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>

<!--Manage Photos Modal -->
<div class="modal fade" id="managephotos" tabindex="-1" aria-labelledby="managephotosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
		<div class="modal-header">
			<div class="col-md-3 d-none d-lg-block">
			  <img src="/images/footer-logo-grey.png" alt="logo">
			</div>
			<div class="col-10 col-md-6">
			  <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Manage Photos</h5>
			</div>
			<div class="col-2 col-md-3">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
		</div>
		<div class="modal-body">
			<div class="row">
			  <div class=" col-12 col-lg-11 mx-auto  mb-4">
			    <div class="card-body">
			      <form id="managephotos-form">
			        <div class="row">
			          <div class="col-sm-10">
			            <p class="text-muted">Tip: Click and drag photos to change their order or move between columns.</p>
			          </div>
			          <div class="col-sm-2 text-right">
			            <a id="init-bulkEdit" href="" data-toggle="modal" data-target="#bulkedit">
			              <i class="fas fa-pencil-alt  editicon"></i></a>
			              <a id="init-bulkdelete" href="" data-toggle="modal" data-target="#deletephoto">
			                <i class="fas fa-trash-alt  deleteicon"></i></a>
			            <a id="init-addphoto" href="" data-toggle="modal" data-target="#addphotos">
			              <i class="fas fa-plus-circle  addicon"></i></a>
			          </div>
			        </div>
			        <div class="container-fluid pt-2 px-0 ">
						<div id="imageGrid" class="imageGrid packery">
							<?php foreach ( get_field('photos', 'user_' . $obj_id) as $index => $obj): ?>
							<div class="packery-item" data-media-id="<?php echo $obj["ID"]; ?>" data-caption="<?php echo get_post($obj['ID'])->post_excerpt; ?>">
								<div class="imgContent">
									<img class="card-img-top" src="<?php echo $obj['url']; ?>" />
									<?php 
                                    if (get_field('moderated', 'attachment_' . $obj["ID"])) {
    									switch (get_field('moderated', 'attachment_' . $obj["ID"])['value']) {
    										case 'pending':
    											echo "<div class='pending-status'>Pending</div>";
    											break;
    										case 'approved':
    											echo "<div class='approved-status'><i class='fas fa-check'></i></div>";
    											break;
    										case 'rejected':
    											echo "<div class='rejected-status'>Rejected</div>";
    											break;
    										default:
    											break;
                                        }
									} ?>
								</div>

								<div class="bulkselect-radio">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="">
									</div>
								</div>

								<div class="row managephotoicons">
									<div class="col-4 text-center py-3">
										<a alt="Edit Image" data-toggle="modal" data-target="#editcaption" data-backdrop="false">
											<i class="fas fa-pencil-alt"></i>
										</a>
									</div>
									<div class="col-4 text-center py-3">
										<a alt="Rotate" class="rotate-image">
											<i class="fas fa-undo"></i>
										</a>
									</div>
									<div class="col-4 text-center py-3">
										<a alt="Delete" class="delete-image">
											<i class="fas fa-trash-alt"></i>
										</a>
									</div>
								</div>
							</div>
							<?php endforeach;?>
						</div>
			        </div>
			        <div class="d-flex justify-content-around py-4">
			          <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
                      <div class="submit">
                            <button class="btn btn-lg btn-popup-save px-4">Save</button>
                        </div>
			        </div>
			      </form>
			    </div>
			  </div>
			</div>
		</div>
    </div>
  </div>
</div>

<!--Add Photos Modal -->
<div class="modal fade" id="addphotos" tabindex="-1" aria-labelledby="addphotosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-md-3 d-none d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div>
        <div class="col-10 col-md-6">
          <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Add Photo</h5>
        </div>
        <div class="col-2 col-md-3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class=" col-12 col-lg-11 mx-auto">
            <div class="card-body">

              <form action="">
                <div class="row">
                  <div class="col-sm-12">
                    <p class="text-muted">
                    <ul>
                      <li>Great profile pics 101: full length, waist up & a natural looking!</li>
                      <li>Quality over quantity (save the selfies for social)</li>
                      <li>Include a range of photos that demonstrate your experience and versatillity</li>
                    </ul>
                    </p>
                    <div class="col-8 uploadphoto pt-4 mx-auto text-center">
                      <label class="uploadimage">
                        <i class="fas fa-camera fa-3x"></i><br />
                        Select a Photo
                        <input type="file" id="file-input" class="" size="60">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8 pt-3 mx-auto px-0">
                    <label class="col-12 ">Rotate</label>
                    <div class="btn-group btn-group-toggle col-4" data-toggle="buttons">
                      <label class="btn btn-rotate active col-6">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked>
                        <i class="fas fa-undo"></i>
                      </label>
                      <label class="btn btn-rotate col-6">
                        <input type="radio" name="options" id="option2" autocomplete="off">
                        <i class="fas fa-undo fa-flip-horizontal"></i>
                      </label>
                    </div>

                    <label class="col-12 pt-3 ">Photo position on profile</label>
                    <div class="btn-group btn-group-toggle col-12 " data-toggle="buttons">
                      <label class="btn btn-secondary active col-6">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Top
                      </label>
                      <label class="btn btn-secondary col-6">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Bottom
                      </label>
                    </div>
                    <label class="col-12 pt-3">Add a caption</label>
                    <div class="col-12">
                      <input type="text" class="form-control" />
                    </div>

                  </div>
                </div>
            </div>
            <div class="  text-center pb-4">
              <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
              <button class="btn btn-md btn-popup-save px-4">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!--Edit Photos Caption Modal -->
<div class="modal fade" id="editcaption" tabindex="-1" aria-labelledby="editPhotoCaption" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-3 d-none d-lg-block">
          
        </div>
        <div class="col-6 ">
          <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Edit Photo Caption</h5>
        </div>
        <div class="col-3 ">
          <button type="button" class="close" data-toggle="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form id="saveCaption">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-11 pt-4 mx-auto text-center viewphotodiv">
                <img src="/images/gridimg/1.jpg" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-10 pt-3 mx-auto px-0">
              <label class="col-12 pt-3">Add a caption</label>
              <div class="col-12">
                <input type="text" class="form-control caption-value" />
              </div>
            </div>
          </div>
          <div class=" text-center py-3">
            <button class="btn btn-md btn-popup-cancel" data-toggle="modal">Cancel</button>
            <button class="btn btn-md btn-popup-save px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Delete Photos Caption Modal -->
<div class="modal fade" id="deletephoto" tabindex="-1" aria-labelledby="deletephoto" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <div class="col-3 d-none  d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div> -->
        <div class="col-6 ">
          <h5 class="modal-title " id="">Delete Confirm</h5>
        </div>
        <div class="col-6 ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form id="delete-photos">
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you want to delete the selected photo(s)?</p>
            </div></div>
          <div class=" text-center py-3">
            <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
            <button class="btn btn-md btn-popup-save px-4">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>
</div>


<!--Rotate Photos Caption Modal -->
<div class="modal fade" id="rotatephoto" tabindex="-1" aria-labelledby="rotatephoto" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-3 d-none  d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div>
        <div class="col-6 ">
          <h5 class="modal-title text-lg-center" id="">Rotate Photo</h5>
        </div>
        <div class="col-3 ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-11 pt-4 mx-auto text-center viewphotodiv">
                <img src="/images/gridimg/1.jpg" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-10 pt-3 mx-auto px-0 text-center">

              
              <div class="btn-group btn-group-toggle col-4" data-toggle="buttons">
                <label class="btn btn-rotate active col-6">
                  <input type="radio" name="options" id="option1" autocomplete="off" checked>
                  <i class="fas fa-undo"></i>
                </label>
                <label class="btn btn-rotate col-6">
                  <input type="radio" name="options" id="option2" autocomplete="off">
                  <i class="fas fa-undo fa-flip-horizontal"></i>
                </label>
              </div>
            </div>
          </div>
          <div class=" text-center py-3">
            <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
            <button class="btn btn-md btn-popup-save px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Bulk Edit Caption Modal -->
<div class="modal fade" id="editcaption" tabindex="-1" aria-labelledby="editPhotoCaption" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-3 d-none  d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div>
        <div class="col-6 ">
          <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Edit Photo Caption</h5>
        </div>
        <div class="col-3 ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-11 pt-4 mx-auto text-center viewphotodiv">
                <img src="/images/gridimg/1.jpg" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-10 pt-3 mx-auto px-0">

              <label class="col-12 pt-3">Add a caption</label>
              <div class="col-12">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div class=" text-center py-3">
            <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
            <button class="btn btn-md btn-popup-save px-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Manage video Modal -->
<div class="modal fade" id="manageVideos" tabindex="-1" aria-labelledby="manageVideosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-md-3 d-none d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div>
        <div class="col-10 col-md-6">
          <h5 class="modal-title text-lg-center" id="manageVideosModalLabel">Manage Video</h5>
        </div>
        <div class="col-2 col-md-3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <!--Videos block-->
        <div class="row justify-content-end pb-3">
          <button type="button" class="btn btn-popup-add mx-4" data-toggle="modal" data-target="#addvideo"><i
              class="fas fa-plus-circle fa-2x"></i></button>
        </div>
        <div class="row">
			<style type="text/css">
				.col-lg-4.profilevideos.pb-5 iframe {
					width: 100%;
					height: 200px;
				}
            </style>
			<?php if( have_rows('videos', 'user_' . $obj_id) ): ?>
				<?php while ( have_rows('videos', 'user_' . $obj_id) ) : the_row(); ?>
					<div class="col-lg-4 profilevideos pb-5">						
						<?php echo get_sub_field('video_link'); ?>
						<h5 class="pt-2"><?php echo get_sub_field('video_caption'); ?></h5>
						<div class="float-right manageVideo" >
							<button class="btn btn-popup-edit" type="button" data-indexvideo="<?php echo get_row_index(); ?>" data-toggle="modal" data-target="#editvideo">
								<i class="fas fa-pen fa-lg"></i>
							</button>
							<button class="btn btn-popup-del" type="button" data-indexvideo="<?php echo get_row_index(); ?>" data-toggle="modal" data-target="#deleteVideo">
								<i class="fas fa-trash-alt fa-lg"></i>
							</button>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>       
        </div>
      </div>
    </div>
  </div>
</div>
<!--add video Modal -->
<div class="modal fade" id="addvideo" tabindex="-1" aria-labelledby="addvideoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
		<div class="col-md-3 d-none d-lg-block">
			<img src="/images/footer-logo-grey.png" alt="logo">
		</div>
		<div class="col-10 col-md-6">
			<h5 class="modal-title text-lg-center" id="addvideoModalLabel">Add Video</h5>
		</div>
		<div class="col-2 col-md-3">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-12 col-lg-8 mx-auto py-4">
			<!-- <div class="card-body"> -->			
				<ul class="text-muted">
					<li class="pb-2">Upload your introduction video on a public site like Youtube or Vimeo. Your profile should be set to public.</li>
					<li class="pb-2">Go to the video on the site you uploaded to and copy the link in your browser.</li>
					<li class="pb-2">Paste the video link in the box below and click 'Save'.</li>
				</ul>
				<input id="addvideolink_input" class="form-control my-2" type="text" placeholder="Paste your copied link here:" />
				<input id="addvideocaption_input" class="form-control my-2" type="text" placeholder="Add caption (optional)" />
				<div class="d-flex justify-content-around py-4">
					<button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
					<button id="addvideosave_submit" class="btn btn-lg btn-popup-save px-4">Save</button>
				</div>

				<div id="resaddvideoWrapper"></div> 
			<!-- </div> -->
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
<!--edit video details Modal -->
<div class="modal fade" id="editvideo" tabindex="-1" aria-labelledby="editvideoModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editvideoModalLabel">Edit Video Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <label for="editvideolink_input">Video Link</label>
            <input id="editvideolink_input" class="form-control my-2" type="text" placeholder="Edit link here:" />
          
            <label for="editvideocaption_input">Caption</label>
            <input id="editvideocaption_input" class="form-control my-2" type="text" placeholder="Add/Edit caption" />
  
			<!-- btns div -->
			<div class="d-flex justify-content-end py-4">
				<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
				<button id="editvideosave_submit" class="btn btn-lg btn-popup-save px-4">Save</button>
			</div>

		  	<div id="reseditvideoWrapper"></div> 
      </div>
    </div>
  </div>
</div>
<!-- Delete video Modal -->
<div class="modal fade" id="deleteVideo" tabindex="-1" aria-labelledby="deleteVideoLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteVideoLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="px-4 pb-3">
            Are you sure you want to delete the video?
          </p>
          <!-- btns div -->
          <div class="d-flex justify-content-end pb-4">
            <button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
            <button id="deletevideosave_submit" class="btn btn-lg btn-popup-delete">Delete</button>
		  </div>   
		  
		  <div id="resdeletevideoWrapper"></div> 
      </div>

    </div>
  </div>
</div>
	
<!-- category details Modal -->
<div class="modal fade" id="catdetailed" tabindex="-1" aria-labelledby="catDetailedModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content" id="experience-modal-content">
			
		</div>
	</div>
	<!-- Delete Exp Modal -->
	<div class="modal fade" id="deleteExp" tabindex="-1" aria-labelledby="deleteExpLabel" aria-hidden="true" data-backdrop="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteExpLabel">Confirm Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="">
						<p class="px-4 pb-3">
							Are you sure you want to delete the Experience?
						</p>
						<!-- btns div -->
						<div class="d-flex justify-content-end pb-4">
							<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
							<button class="btn btn-lg btn-popup-delete">Delete</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Manage audio Modal -->
<div class="modal fade" id="manageAudio" tabindex="-1" aria-labelledby="manageAudioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
		<div class="col-md-3 d-none d-lg-block">
			<img src="/images/footer-logo-grey.png" alt="logo">
		</div>
		<div class="col-10 col-md-6">
			<h5 class="modal-title text-lg-center" id="manageAudioModalLabel">Manage Audio</h5>
		</div>
		<div class="col-2 col-md-3">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		</div>
		<div class="modal-body">
			<!--Audio block-->
			<div class="row justify-content-end pb-3">
				<button type="button" class="btn btn-popup-add mx-4" data-toggle="modal" data-target="#addaudio"><i
					class="fas fa-plus-circle fa-2x"></i></button>
			</div>
			<div class="row">

				<?php if( have_rows('audios', 'user_' . $obj_id) ): ?>
						<?php while ( have_rows('audios', 'user_' . $obj_id) ) : the_row(); ?>

							<div class="col-lg-4 audioblock pb-5">

								<div class="col-sm-12 card mb-2">
									<div class="col-sm-12 pb-3">
										<h5 class="pt-2"><?php echo get_sub_field('audio_title'); ?></h5>
										<h6><?php echo get_sub_field('audio_description'); ?></h6>
									</div>
									<div class="col-12 col-sm-12 mb-3">
										<audio controls preload="metadata">
											<source src="<?php echo get_sub_field('audio_file')['url']; ?>" type="<?php echo get_sub_field('audio_file')['mime_type']; ?>">
											Your browser does not support the audio element.
										</audio>
									</div>
								</div>

								<div class="float-right manageAudio">
									<button data-indexaudio="<?php echo get_row_index(); ?>" class="btn btn-popup-edit" type="button" data-toggle="modal" data-target="#editaudio">
									<i class="fas fa-pen fa-lg"></i>
									</button>
									<button data-indexaudio="<?php echo get_row_index(); ?>" class="btn btn-popup-del" type="button" data-toggle="modal" data-target="#deleteaudio">
									<i class="fas fa-trash-alt fa-lg"></i>
									</button>
								</div>

							</div>

						<?php endwhile; ?>
				<?php endif; ?>
			
			</div>
		</div>
	</div>
	</div>
</div>
<!--add audio Modal -->
<div class="modal fade" id="addaudio" tabindex="-1" aria-labelledby="addAudioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
		<div class="col-md-3 d-none d-lg-block">
			<img src="/images/footer-logo-grey.png" alt="logo">
		</div>
		<div class="col-10 col-md-6">
			<h5 class="modal-title text-lg-center" id="addAudioModalLabel">Add Audio</h5>
		</div>
		<div class="col-2 col-md-3">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-12 col-sm-10 mx-auto py-4">
				<p class="pb-2">You can upload MP3, WAV and OGG files</p>
				<div class="form-group">
					<label class="btn btn-popup-save">
					<input required id="addaudiofile_input" type="file" name="audio" accept="audio/*"/>
					Choose file to upload
					</label>
				</div>
				<div class="form-group">
					<label for="audioTitle">Title</label>
					<input required id="addaudiotitle_input" type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="audioDesp">Description</label>
					<textarea required id="addaudiodescription_input" class="form-control justify-content-end"></textarea>
				</div>
				<div class="d-flex justify-content-end py-2">
				<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
				<button id="addaudiosave_submit" class="btn btn-lg btn-popup-save px-4">Save</button>
				</div>

				<!-- response message -->
				<div id="resaddaudioWrapper"></div>
			</div>	
		</div>
		</div>
	</div>
	</div>
</div>
<!--edit audio details Modal -->
<div class="modal fade" id="editaudio" tabindex="-1" aria-labelledby="editAudioModalLabel" aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-lg modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="editAudioModalLabel">Edit Audio Details</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
			<label for="audioTitle">Title</label>
			<input id="editaudiotitle_input" type="text" class="form-control">
			</div>
			<div class="form-group">
			<label for="audioDesp">Description</label>
			<textarea id="editaudiodescription_input" class="form-control justify-content-end"></textarea>
			</div>
			<!-- btns div -->
			<div class="d-flex justify-content-end py-4">
			<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
			<button id="editaudiosave_submit" class="btn btn-lg btn-popup-save px-4">Save</button>
			</div>

			<!-- response message -->
			<div id="reseditaudioWrapper"></div>
		</div>
	</div>
	</div>
</div>
<!-- Delete audio Modal -->
<div class="modal fade" id="deleteaudio" tabindex="-1" aria-labelledby="deleteAudioLabel" aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="deleteAudioLabel">Confirm Delete</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<p class="px-4 pb-3">
			Are you sure you want to delete the audio?
			</p>
			<!-- btns div -->
			<div class="d-flex justify-content-end pb-4">
			<button class="btn btn-lg btn-popup-cancel mr-4" data-dismiss="modal">Cancel</button>
			<button id="deleteaudiosave_submit" class="btn btn-lg btn-popup-delete">Delete</button>
			</div>

			<!-- response message -->
			<div id="resdeleteaudioWrapper"></div>
		</div>
	</div>
	</div>
</div>

<!--PhysicalAttributes Modal -->
<div class="modal fade" id="editPhysicalAttributes" tabindex="-1" aria-labelledby="editPhysicalAttributesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
		<div class="col-md-3 d-none d-lg-block">
			<img src="/images/footer-logo-grey.png" alt="logo">
		</div>
		<div class="col-10 col-md-6">
			<h5 class="modal-title text-lg-center" id="editIntroModalLabel">Physical Features</h5>
		</div>
		<div class="col-2 col-md-3">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="card col-12 col-lg-8 mx-auto shadow-sm py-4">
			<div class="card-body">
				<p class="text-muted">Fill in all the details relevant to your skillset for better chances of being scouted.</p>

				<!-- HEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_height_ft = acf_get_field('sci_user_height_ft');
                        $acf_height_in = acf_get_field('sci_user_height_in');						
					?>
					<label for="<?php echo $acf_height_ft['name']; ?>"><?php echo $acf_height_ft['label']; ?>:</label>
					<div class="d-flex justify-content-between">
						<input 
                            name="<?php echo $acf_height_ft['name']; ?>" 
                            value="<?php echo ($user_height_ft) ? $user_height_ft : ''; ?>"
							type="<?php echo $acf_height_ft['type']; ?>"
							placeholder="<?php echo $acf_height_ft['placeholder']; ?>"
                            class="form-control mr-2" 
                            min="<?php echo $acf_height_ft['min']; ?>" 
                            max="<?php echo $acf_height_ft['max']; ?>"
                            step="<?php echo $acf_height_ft['step']; ?>"
                        >
                        <input 
							name="<?php echo $acf_height_in['name']; ?>" 
                            value="<?php echo ($user_height_in) ? $user_height_in : ''; ?>"
							type="<?php echo $acf_height_in['type']; ?>"
							placeholder="<?php echo $acf_height_in['placeholder']; ?>"
                            class="form-control ml-2" 
                            min="<?php echo $acf_height_in['min']; ?>" 
                            max="<?php echo $acf_height_in['max']; ?>"
                            step="<?php echo $acf_height_in['step']; ?>"
						>
						<button id="clear_<?php echo $acf_height_ft['name']; ?>" class="btn btn-popup-del ml-2" type="button">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>				
					<div class="text-danger d-none" style="font-size: 80%;">Please enter a valid height</div>
				</div>

				<!-- WEIGHT -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_weight_kg = acf_get_field('sci_user_weight_kg');				
					?>
					<label for="<?php echo $acf_weight_kg['name']; ?>"><?php echo $acf_weight_kg['label']; ?>: </label>
					<div class="d-flex justify-content-between">
						<input 
							name="<?php echo $acf_weight_kg['name']; ?>" 
							value="<?php echo ($user_weight_kg) ? $user_weight_kg : ''; ?>"
							type="<?php echo $acf_weight_kg['type']; ?>"
							placeholder="<?php echo $acf_weight_kg['placeholder']; ?>"
							class="form-control" 
							min="<?php echo $acf_weight_kg['min']; ?>" 
							max="<?php echo $acf_weight_kg['max']; ?>"
							step="<?php echo $acf_weight_kg['step']; ?>"
						>
						<button id="clear_<?php echo $acf_weight_kg['name']; ?>" class="btn btn-popup-del ml-2" type="button">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
					<div class="invalid-feedback">Please enter a valid weight</div>
				</div>

				<!-- CHEST -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_chest_in = acf_get_field('sci_user_chest_in');				
					?>
					<label for="<?php echo $acf_chest_in['name']; ?>"><?php echo $acf_chest_in['label']; ?>: </label>
					<div class="d-flex justify-content-between">
						<input 
							name="<?php echo $acf_chest_in['name']; ?>" 
							value="<?php echo ($user_chest_in) ? $user_chest_in : ''; ?>"
							type="<?php echo $acf_chest_in['type']; ?>"
							placeholder="<?php echo $acf_chest_in['placeholder']; ?>"
							class="form-control" 
							min="<?php echo $acf_chest_in['min']; ?>" 
							max="<?php echo $acf_chest_in['max']; ?>"
							step="<?php echo $acf_chest_in['step']; ?>"
						>
						<button id="clear_<?php echo $acf_chest_in['name']; ?>" class="btn btn-popup-del ml-2" type="button">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
					<div class="invalid-feedback">Please enter a valid chest size</div>
				</div>

				<!-- WAIST -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_waist_in = acf_get_field('sci_user_waist_in');				
					?>
					<label for="<?php echo $acf_waist_in['name']; ?>"><?php echo $acf_waist_in['label']; ?>: </label>
					<div class="d-flex justify-content-between">
						<input 
							name="<?php echo $acf_waist_in['name']; ?>" 
							value="<?php echo ($user_waist_in) ? $user_waist_in : ''; ?>"
							type="<?php echo $acf_waist_in['type']; ?>"
							placeholder="<?php echo $acf_waist_in['placeholder']; ?>"
							class="form-control" 
							min="<?php echo $acf_waist_in['min']; ?>" 
							max="<?php echo $acf_waist_in['max']; ?>"
							step="<?php echo $acf_waist_in['step']; ?>"
						>
						<button id="clear_<?php echo $acf_waist_in['name']; ?>" class="btn btn-popup-del ml-2" type="button">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
					<div class="invalid-feedback">Please enter a valid waist size</div>
				</div>

				<!-- EYE COLOR -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_eye_color = acf_get_field('sci_user_eye_color');		
					?>
					<div>
					<label for="<?php echo $acf_eye_color['name']; ?>"><?php echo $acf_eye_color['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_eye_color['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_eye_color['type']; ?>" 
							    name="<?php echo $acf_eye_color['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_eye_color == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button id="clear_<?php echo $acf_eye_color['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>

				<!-- SKIN COLOR -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_skin_color = acf_get_field('sci_user_skin_color');		
					?>
					<div>
					<label for="<?php echo $acf_skin_color['name']; ?>"><?php echo $acf_skin_color['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_skin_color['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_skin_color['type']; ?>" 
							    name="<?php echo $acf_skin_color['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_skin_color == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button id="clear_<?php echo $acf_skin_color['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>
		
				<!-- HAIR COLOR -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_hair_color = acf_get_field('sci_user_hair_color');	
						$user_hair_color_custom = false;		
					?>
					<div>
					<label for="<?php echo $acf_hair_color['name']; ?>"><?php echo $acf_hair_color['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_hair_color['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_hair_color['type']; ?>" 
							    name="<?php echo $acf_hair_color['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_hair_color == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_hair_color['type']; ?>" 
							    name="<?php echo $acf_hair_color['name']; ?>"
								id="sci_user_custom_hair_color_radio"
								<?php 						
								if($user_hair_color){
									if(array_search($user_hair_color,array_values($acf_hair_color['choices']),true) === false){
										$user_hair_color_custom = true;
									}
									echo ($user_hair_color_custom) ? 'checked' : ''; 
								}
								?>
								value="<?php echo ($user_hair_color_custom) ? $user_hair_color : 'other'; ?>"
								/>
								Other
							</label>
					</div>
					<button id="clear_<?php echo $acf_hair_color['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>
				<div id="sci_user_custom_hair_color_wapper" class="form-group <?php echo ($user_hair_color_custom) ? '' : 'd-none'; ?>">
					<input 
						type="text" 
						class="form-control" 
						placeholder="Enter hair color" 
						value="<?php echo ($user_hair_color_custom) ? $user_hair_color : ''; ?>"
						id="sci_user_custom_hair_color_text"
					/>
				</div>
				
				<!-- HAIR LENGTH -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_hair_length = acf_get_field('sci_user_hair_length');		
					?>
					<div>
					<label for="<?php echo $acf_hair_length['name']; ?>"><?php echo $acf_hair_length['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_hair_length['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_hair_length['type']; ?>" 
							    name="<?php echo $acf_hair_length['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_hair_length == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button id="clear_<?php echo $acf_hair_length['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>

				<!-- HAIR TYPE -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_hair_type = acf_get_field('sci_user_hair_type');		
					?>
					<div>
					<label for="<?php echo $acf_hair_type['name']; ?>"><?php echo $acf_hair_type['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_hair_type['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_hair_type['type']; ?>" 
							    name="<?php echo $acf_hair_type['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_hair_type == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button id="clear_<?php echo $acf_hair_type['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>

				<!-- ETHNICITY -->
				<div class="form-group">
					<?php
						//get values from ACF plugin
						$acf_ethnicity = acf_get_field('sci_user_ethnicity');
						$user_ethnicity_custom = false;		
					?>
					<div>
					<label for="<?php echo $acf_ethnicity['name']; ?>"><?php echo $acf_ethnicity['label']; ?>:</label>
					</div>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<?php foreach($acf_ethnicity['choices'] as $value => $label): ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_ethnicity['type']; ?>" 
							    name="<?php echo $acf_ethnicity['name']; ?>"
								value="<?php echo $value; ?>"
								<?php echo ($user_ethnicity == $label) ? 'checked' : '' ?>
								/>
								<?php echo $label; ?>
							</label>
						<?php endforeach; ?>
							<label class="btn btn-details-gen">
								<input 
								type="<?php echo $acf_ethnicity['type']; ?>" 
							    name="<?php echo $acf_ethnicity['name']; ?>"
								id="sci_user_custom_ethnicity_radio"
								<?php 						
								if($user_ethnicity){
									if(array_search($user_ethnicity,array_values($acf_ethnicity['choices']),true) === false){
										$user_ethnicity_custom = true;
									}
									echo ($user_ethnicity_custom) ? 'checked' : ''; 
								}
								?>
								value="<?php echo ($user_ethnicity_custom) ? $user_ethnicity : 'other'; ?>"
								/>
								Other
							</label>
					</div>
					<button id="clear_<?php echo $acf_ethnicity['name']; ?>" class="btn btn-popup-del" type="button">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>
				<div id="sci_user_custom_ethnicity_wapper" class="form-group <?php echo ($user_ethnicity_custom) ? '' : 'd-none'; ?>">
					<input 
						type="text" 
						class="form-control" 
						placeholder="Enter ethnicity" 
						value="<?php echo ($user_ethnicity_custom) ? $user_ethnicity : ''; ?>"
						id="sci_user_custom_ethnicity_text"
					/>
				</div>

				<div class="d-flex justify-content-center py-4">
					<button class="btn btn-lg btn-popup-cancel mr-2" data-dismiss="modal">Cancel</button>
					<button id="editphysicalattributessave_submit" class="btn btn-lg btn-popup-save px-4 ml-2">Save</button>
				</div>

				<!-- Response message -->
				<div id="reseditphysicalattributesWrapper"></div>
		
			</div>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>

<!--Best Headshot Modal -->
<div class="modal fade" id="bestheadshot" tabindex="-1" aria-labelledby="bestheadshotLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
		<div class="modal-header">
			<div class="col-md-3 d-none d-lg-block">
			  <img src="/images/footer-logo-grey.png" alt="logo">
			</div>
			<div class="col-10 col-md-6">
			  <h5 class="modal-title text-lg-center" id="bestheadshotLabel">Examples of Good Headshots</h5>
			</div>
			<div class="col-2 col-md-3">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
		</div>
		<div class="modal-body">
			<div class="row">
			  <div class=" col-12 col-lg-10 mx-auto  mb-4">
			    <div class="card-body">
			      <form id="bestHeadshots">
			       <div class="container-fluid pt-2 px-0 ">
					<div class="row">
						<div class="col-12 col-md-4 headshotcol1 text-center p-4">
							<div class="iconarea py-5">
								<i class="fas fa-camera-retro fa-4x"></i>
							</div>
							<div class="headshotpoints py-3">
								<h2>[ 1 ]</h2>
								<p>Pay attention to framing, lighting, and background in your headshot.</p>
							</div>
							<div class="headshotpoints py-3">
								<h2>[ 2 ]</h2>
								<p>Go easy with the makeup, you want to look natural. Take your headshot during the day so you can use natural light over artificial light.</p>
							</div>
							<div class="headshotpoints py-3">
								<h2>[ 3 ]</h2>
								<p>Skip the sunglasses, hats, filters and special effects. This is business!</p>
							</div>
						</div>
						<div class="col-12 col-md-8  pt-3 pl-5">
							<div class="row">
								<div class="col-12">
									<h5>What makes a great headshot?</h5>
									<p>A headshot is your first impression and a good headshot is very crucial to your chances of being scouted. Having a good headshot is an investment in your career as an artist or performer. Follow the guidelines and examples below to make sure your headshot is an accurate reflection of you </p>
								</div>
								<?php if( have_rows('best_headshots', 'options') ){ ?>
								<?php while ( have_rows('best_headshots', 'options') ) : the_row(); ob_start(); $i++; ?>
								<div class="col-6 pt-3 pr-3">
									<img src="<?php echo get_sub_field('best_headshot'); ?>" alt="Best Headshot" class="img-fluid" />
								</div>
								<?php  endwhile; ?>
								<?php } ?>
							</div>
						</div>
					</div>
			        </div>			      
			      </form>
			    </div>
			  </div>
			</div>
		</div>
    </div>
  </div>
</div>

<script type="text/javascript">
(function(on){
    on("DOMContentLoaded", function(){
        var $grid = new Packery( '.grid', {
            itemSelector: '.grid-item',
            gutter: 10,
            percentPosition: true
        });
        imagesLoaded(".grid-item img").on( 'progress', function() {
            $grid.layout();
        });  
    });
})(document.addEventListener);

(function(on){
    on("DOMContentLoaded", function(){
        window.$drag = new Packery( '.packery', {
            itemSelector: '.packery-item',
            gutter: 10,
            percentPosition: true
        });
        imagesLoaded(".packery-item img").on( 'progress', function() {
            $drag.layout();
        });  
        $drag.getItemElements().forEach( function( itemElem ) {
            var draggie = new Draggabilly( itemElem );
            $drag.bindDraggabillyEvents( draggie );
        });
        function orderItems() {
            $drag.getItemElements().forEach( function( itemElem, i ) {
                itemElem.setAttribute('data-order', i + 1);
            });
        }

        $drag.on( 'layoutComplete', orderItems );
        $drag.on( 'dragItemPositioned', orderItems );
    });
})(document.addEventListener);

</script>

<script>

var navbar = document.getElementById("navbar");
if (navbar) {
	window.onscroll = function() {myFunction()};
    var sticky = navbar.offsetTop;    
    function myFunction() {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
      } else {
        navbar.classList.remove("sticky");
      }
    }    	
}
</script>
<?php
get_sidebar();
get_footer();
