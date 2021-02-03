<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Showcase
 */

get_header();

?>
<?php 

$obj_id = get_queried_object_id();
$data = get_user_meta($obj_id);
$user_info = get_userdata($obj_id);
?>
<style type="text/css">
	.bodyBG {
		display: flex;
	}
	div.mb-3 {
		margin-bottom: 2.5rem !important;
	}
	.photogrid {
		flex-direction: column;
	}
	.fixed {
		position: fixed;
		top: 0;
		z-index: 99;
	}
</style>
  <div class="bodyBG">
    <section class="container-fluid">
        <div class="container px-0 ">
	        <div class="row">
	            <div class="col-6 col-sm-8 pt-3">
	            	<!-- Nav tabs -->
		            <ul class="nav findtalent-tabs">
		                <li class="nav-item">
		                	<a class="nav-link select" data-toggle="tab" href="">Find Talent</a>
		                </li>
		            </ul>
	            </div>
	            <div class="col-6 col-sm-4 pt-3 scibreadcrumb">
		            <ul class="nav float-right">
		                <li class="nav-item">
		                	<a class="nav-link select" href="/find-talent/">Find Talent</a>
		                </li>
		                <li class="pt-2"><i class="fas fa-chevron-right"></i></li>
		                <li class="nav-item">
		                    <a class="nav-link select">View Profile</a>
		                </li>
		            </ul>
	            </div>
	        </div>      
	        <div class="tab-content">
	            <div class="tab-pane container active">
	                <div class="row p-3 blockBG mb-3">
	                    <div class="col-12 col-sm-6">
							<style type="text/css">
								#secondary-slider .splide__slide {
									background-position: top center !important;
								}
								.slider_headshot_thumbnail, .slider_headshot {
									margin-bottom: 2rem;
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
								 <?php if (get_field('sci_user_headshot', 'user_' . $obj_id)): ?>
								<div id="image-slider" class="splide slider_headshot">
									<div class="splide__track">
										<ul class="splide__list">
											<li class="splide__slide">
								     			<img src="<?php echo get_field('sci_user_headshot', 'user_' . $obj_id); ?>">
											</li>
											<?php
											// Check rows exists.
											if( have_rows('featured_images', 'user_' . $obj_id) ):

											    // Loop through rows.
											    while( have_rows('featured_images', 'user_' . $obj_id) ) : the_row();

											        // Load sub field value.
											        $sub_value = get_sub_field('image'); ?>
											        <li  class="splide__slide">
											        	<img src="<?php echo $sub_value; ?>">
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
								<?php endif ?>
								<?php 
								// Check rows exists.
								if( have_rows('featured_images', 'user_' . $obj_id) ): ?>
								<div id="secondary-slider" class="splide slider_headshot_thumbnail">
									<div class="splide__track">
										<ul class="splide__list">
											<li class="splide__slide">
								     			<img src="<?php echo get_field('sci_user_headshot', 'user_' . $obj_id); ?>">
											</li>
											<?php
											    // Loop through rows.
											    while( have_rows('featured_images', 'user_' . $obj_id) ) : the_row();

											        // Load sub field value.
											        $sub_value = get_sub_field('image'); ?>
											        <li  class="splide__slide">
											        	<img src="<?php echo $sub_value; ?>">
													</li>
											<?php // End loop.
											    endwhile;?>
											<li class="splide__slide fas fa-user" id="add_featured_image"  data-toggle="modal" data-target="#editheadshot"></li>
										</ul>
									</div>
								</div>
								<?php // No value.
								else :
								    // Do something...
								endif; ?>
	     					</div>
	                    </div>
	                    <div class="col-6 profile-personaldetails">
	                        <h1>
	                        	<?php echo $data['first_name'][0] . " " . $data['last_name'][0]; ?>	
	                        </h1>
	                        <span>
	                        	<i class="fas fa-envelope pr-2"></i> 
	                        	<?php echo $user_info->data->user_email; ?>
	                        </span>
	                        <?php if (get_field('sci_user_location', 'user_' . $obj_id)): ?>
	                        <span>
	                        	<i class="fas fa-map-marker-alt pr-2"></i> 
	                        	<?php echo get_field('sci_user_location', 'user_' . $obj_id); ?>, India
	                        </span>
	                        <?php endif ?>

	                        <?php if (get_field('sci_user_mobile', 'user_' . $obj_id)): ?>
	                        <span>
	                        	<i class="fas fa-phone-alt pr-2"></i> 
	                        	+91 <?php echo get_field('sci_user_mobile', 'user_' . $obj_id); ?>
	                        </span>
	                        <?php endif ?>

	                        <?php if (get_field('sci_user_gender', 'user_' . $obj_id)): ?>
	                        <span>
	                        	<i class="fas fa-venus-mars pr-2"></i> 
	                        	<?php echo get_field('sci_user_gender', 'user_' . $obj_id); ?>
	                        </span>
	                        <?php endif ?>
		
							<?php if (get_field('profession', 'user_' . $obj_id)): ?>
	                        <div class="selectedcategories">
								<?php
								foreach (get_field('profession', 'user_' . $obj_id) as $index => $key) {
									if (get_field('category_name_singular', 'term_' . $key->term_id)) { ?>
										<span class="badge" style="background: <?php echo get_field('badge_color', 'term_' . $key->term_id); ?>">
											<?php echo get_field('category_name_singular', 'term_' . $key->term_id); ?>
										</span>									
									<?php }
								}
								?>
	                        </div>
							<?php endif ?>

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
	                        	<?php endif ?>
	                        	<?php if (get_field('sci_user_social_links_facebook', 'user_' . $obj_id)): ?>
	                            <a href="<?php echo get_field('sci_user_social_links_facebook', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
	                            	<i class="sci-icon fab fa-facebook" aria-hidden="true"></i>
	                            </a>
	                        	<?php endif ?>
	                        	<?php if (get_field('sci_user_social_links_twitter', 'user_' . $obj_id)): ?>
	                            <a href="<?php echo get_field('sci_user_social_links_twitter', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
	                            	<i class="sci-icon fab fa-twitter" aria-hidden="true"></i>
	                            </a>
	                        	<?php endif ?>
	                        	<?php if (get_field('sci_user_social_links_youtube', 'user_' . $obj_id)): ?>
	                            <a href="<?php echo get_field('sci_user_social_links_youtube', 'user_' . $obj_id); ?>" target="_blank" class="pr-1">
	                            	<i class="sci-icon fab fa-youtube" aria-hidden="true"></i>
	                            </a>
	                        	<?php endif ?>
	                        </div>
	                    </div>
	                </div>
	                <!-- Introdustion  Block-->
	                <?php if (get_field('intro_text', 'user_' . $obj_id)): ?>
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
	                    <div class="col-12 col-sm-6 introvideo">
	                        <iframe width="100%" height="340px" src="<?php echo get_field('intro_to_camera', 'user_' . $obj_id); ?>">
	                        </iframe>
	                    </div>
	                    <div class="col-12 col-sm-6 intro">
	                        <h4>Introduction</h4>
	                        <p><?php echo get_field('intro_text', 'user_' . $obj_id); ?></p>
	                    </div>
	                </div>
	                <?php endif ?>
	                <?php if (get_field('photos', 'user_' . $obj_id) || get_field('videos', 'user_' . $obj_id) || get_field('audios', 'user_' . $obj_id) || get_field('experience', 'user_' . $obj_id)): ?>
	                <!-- Navigation Bar-->
	                <div class="row blockBG profilenavigation mb-3">
	                	<style type="text/css">
	                		#page .profilenavigation a {
	                			color: inherit;
	                			padding: 25px 30px;
	                			line-height: 1;
	                			position: relative;
	                		}
	                		.profilenavigation .nav-item {
	                			position: relative;
	                		}
	                		#page .profilenavigation .nav-item.active {
	                			color: #00c4f5;
	                		}
	                		#page .profilenavigation .nav-item.active::after {
								content: "";
								position: absolute;
								width: 100%;
								height: 4px;
								background: #00c4f5;
								bottom: 0;
	                		}
	                	</style>
		                <nav class="navbar-expand-lg navbar-light navbarcolors container" id="myScrollspy">
							<div class="" id="navbarNav">
							  <ul class="navbar-nav">
	                			<?php if (get_field('photos', 'user_' . $obj_id)): ?>
							    <li class="nav-item active">
							      <a class="nav-link" href="#photos">Photos</a>
							    </li>
	                			<?php endif ?>
	                			<?php if (get_field('audios', 'user_' . $obj_id)): ?>
							    <li class="nav-item">
							      <a class="nav-link" href="#audios">Audio</a>
							    </li>
	                			<?php endif ?>
	                			<?php if (get_field('videos', 'user_' . $obj_id)): ?>
							    <li class="nav-item">
							      <a class="nav-link" href="#videos">Video</a>
							    </li>
	                			<?php endif ?>
							    <li class="nav-item">
							      <a class="nav-link" href="#attributes">Physical Attributes</a>
							    </li>
	                			<?php if (get_field('experience', 'user_' . $obj_id)): ?>
							    <li class="nav-item">
							      <a class="nav-link" href="#credits">Credit and Experience</a>
							    </li>
			                	<?php if( have_rows('experience', 'user_' . $obj_id) ): ?>
			                		<?php while ( have_rows('experience', 'user_' . $obj_id) ) : the_row(); ?>
								    <li class="nav-item">
								      <a class="nav-link" href="#<?php echo get_sub_field('category')->slug; ?>"><?php echo get_sub_field('category')->name; ?></a>
								    </li>
			                		<?php endwhile; ?>
								<?php endif; ?>
	                			<?php endif ?>
							  </ul>
							</div>
		                </nav>
	                </div>
	                <?php endif ?>
	                <?php if (get_field('photos', 'user_' . $obj_id)): ?>
	                <!-- Photo Grid-->
	                <div class="row photogrid mb-3" id="photos">
		                <div class="col-12 pt-3">
		                	<h4>Photos (<?php echo count(get_field('photos', 'user_' . $obj_id)); ?>)</h4>
		                </div>
		                <div class="[insert classes here]">
		                	<style type="text/css">
		                		.grid-item {
									float: left;
									width: 33%;
									background: transparent;
									border: none;
									overflow: hidden;
									border: 10px solid transparent;
								}
		                	</style>     	
		                    <div class="grid">
								<?php foreach ( get_field('photos', 'user_' . $obj_id) as $index => $obj): ?>
								<div class="grid-item">
									<a href="<?php echo $obj['url']; ?>" data-lightbox="roadtrip">
										<img src="<?php echo $obj['url']; ?>">									
									</a>
								</div>
								<?php endforeach;?>
		                   	</div>
		                   	<script type="text/javascript">
		                   		(function(on){
		                   			on("DOMContentLoaded", function(){
										var $grid = new Isotope( '.grid', {});
										imagesLoaded(".grid-item img").progress( function() {
											$grid.layout();
										});	
									});
		                   		})(document.addEventListener)
		                   	</script>
		                </div>
	                </div>
	                <?php endif ?>
	                <!--Videos block-->
	                <?php if (get_field('videos', 'user_' . $obj_id)): ?>
	                <div class="row mb-3 blockBG p-3" id="videos">
	                    <div class="col-12 pt-3">
	                    	<h4>Videos (<?php echo count(get_field('videos', 'user_' . $obj_id)); ?>)</h4>
	                    </div>
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
	                	<?php if( have_rows('videos', 'user_' . $obj_id) ): ?>
	                		<?php while ( have_rows('videos', 'user_' . $obj_id) ) : the_row(); ?>
	                			<div class="iframe-container <?php echo get_row_index() == 1 ? 'col-12 mt-2' : 'col-sm-4 pt-3'; ?>">
	                				<?php echo get_sub_field('video_link'); ?>
	                        		<h5 class="pt-2">Video Title</h5>	                				
	                			</div>
	                		<?php endwhile; ?>
	                	<?php endif; ?>

						<script>
						(function(){
							document.querySelectorAll('.iframe-container').forEach(function(item, index){
								let iframe = item.querySelector("iframe");
								let title = item.querySelector("h5");
								title.innerText = iframe.getAttribute('title');
							});
						})()
						
						</script>
	                </div>
	                <?php endif ?>
	                <?php if (get_field('audios', 'user_' . $obj_id)): ?>
	                <!--Audio block-->
	                <div class="row mb-3 blockBG p-3 audioblock" id="audios">
	                    <div class="col-12 pt-3">
	                        <h4>Audio (<?php echo count(get_field('audios', 'user_' . $obj_id)); ?>)</h4>
	                    </div>
	                	<?php if( have_rows('audios', 'user_' . $obj_id) ): ?>
	                		<?php while ( have_rows('audios', 'user_' . $obj_id) ) : the_row(); ?>
			                    <div class="col-12 py-3 row">
			                        <div class="col-sm-6">
			                            <h5 class="pt-2"><?php echo get_sub_field('audio')['title']; ?></h5>
			                            <h6>audio description</h6>
			                        </div>
			                        <div class="col-sm-6">
			                            <audio controls>
			                                <source src="<?php echo get_sub_field('audio')['url']; ?>" type="audio/mpeg">
			                                Your browser does not support the audio element.
			                              </audio>
			                        </div>
			                    </div>
	                		<?php endwhile; ?>
	                	<?php endif; ?>
	                 </div>
	                <?php endif ?>
	                <div class="row py-3 physicalattribs" id="attributes">
	                    <div class="col-12 pt-3 px-0">
	                        <h4>Physical Attributes</h4>
	                    </div>
	                </div>
	                <div class="row mb-3 physicalfeatures justify-content-center">
		                <?php 
		                function cm2feet($cm){
						     $inches = $cm/2.54;
						     $feet = intval($inches/12);
						     $inches = $inches%12;
						     return sprintf('%d ft %d in', $feet, $inches);
						} 
						function kgToLb ($val) {
							return $val * 2.20;
						}?>
	                    <div class="card">
	                    	<div class="pa-height">
	                    		<div class='sprite height-c'></div>
	                    	</div>
	                    	<div class="card-title">
	                    		Height
	                    		<span>
	                    			<?php if (get_field('sci_user_height', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_height', 'user_' . $obj_id); ?>cms / <?php echo cm2feet(get_field('sci_user_height', 'user_' . $obj_id)); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                    		</span>
	                    	</div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-weight">
	                        	<div class='sprite weight-c'></div>
	                        </div>
	                        <div class="card-title">
	                        	Weight
	                        	<span>
									<?php if (get_field('sci_user_weight', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_weight', 'user_' . $obj_id); ?>kgs / <?php echo kgToLb(get_field('sci_user_weight', 'user_' . $obj_id)); ?>lbs
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-ethnicity">
	                        	<div class='sprite ethnicity-c'></div>
	                        </div>
	                        <div class="card-title">Ethnicity
	                        	<span>
	                        		Indian
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-chest">
	                        	<div class='sprite chest-c'></div>
	                        </div>
	                        <div class="card-title">Chest
	                        	<span>
									<?php if (!!get_field('sci_user_chest', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_chest', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-skincolor">
	                        	<div class='sprite skincolor-c'></div>
	                        </div>
	                        <div class="card-title">Skin Color
	                        	<span>
									<?php if (!!get_field('sci_user_skin_color', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_skin_color', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>

	                    <div class="card">
	                        <div class="pa-notset">
	                        	<div class='sprite waist'></div>
	                        </div>
	                        <div class="card-title">Waist
	                        	<span>
									<?php if (!!get_field('sci_user_waist', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_waist', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-notset">
	                        	<div class='sprite eyecolor'></div>
	                        </div>
	                        <div class="card-title">Eye Color
	                        	<span>
									<?php if (!!get_field('sci_user_eye_color', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_eye_color', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-notset">
	                        	<div class='sprite hair-dye'></div>
	                        </div>
	                        <div class="card-title">Hair Color
	                        	<span>
									<?php if (!!get_field('sci_user_hair_color', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_hair_color', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-notset">
	                        	<div class='sprite hair-length'></div>
	                        </div>
	                        <div class="card-title">Hair Length
	                        	<span>
									<?php if (!!get_field('sci_user_hair_length', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_hair_length', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                    <div class="card">
	                        <div class="pa-notset">
	                        	<div class='sprite hair'></div>
	                        </div>
	                        <div class="card-title">Hair Type
	                        	<span>
									<?php if (!!get_field('sci_user_hair_type', 'user_' . $obj_id)): ?>
	                    				<?php echo get_field('sci_user_hair_type', 'user_' . $obj_id); ?>
	                    			<?php else :  ?>
	                    				Not set
	                    			<?php endif; ?>
	                        	</span>
	                        </div>
	                    </div>
	                </div>
	                <?php if (get_field('experience', 'user_' . $obj_id)): ?>
	                	<style type="text/css">
	                		.cat-title {
								padding-left: 41px;
	                		}
	                		.cat-title h4 {
								font-size: 30px;
	                		}
	                		.specialised-skills {
	                			padding-top: 23px;
	    						padding-left: 27px;
	                		}
	                		.specialised-skills .content {
	                			padding-bottom: 13px;
	    						padding-top: 44px;
	                		}
	                		.hr-text .credit-title {
								font-size: 20px;
								line-height: 1;
	                		}
	                		span.specialisedbadge {
								padding: 7px 28px;
								border-radius: 30px;	
	                		}
	                		span.experiencedbadge {
								padding: 10px 30px;
								border-radius: 30px;
	                		}
	                		.experienceblock {
							    padding-left: 26px;
							    padding-top: 28px;
							    padding-bottom: 28px;
	                		}
	                		.experienceblock h4 {
							    font-size: 30px;
							    letter-spacing: 1px;
	                		}
	                		.experienceblock .form-control {
								max-width: 200px;
								display: inline-block;
								border-radius: 15px;
								padding: 3px 12px;
								font-size: 16px;
								line-height: 1;
								height: auto;
	                		}
	                		.credit-item {
							    padding-top: 22px;
							    padding-left: 9px;
							    width: calc(100% - 60px);
	                		}
	                		.credit-item ul {
								padding-left: 10px;
								list-style-type: none;
								padding-top: 31px;
	                		}
	                		.credit-item li {
								padding-left: 33px;
								position: relative;
								margin-bottom: 20px;
	                		}
	                		.credit-item li::after{
								content: "";
								position: absolute;
								width: 10px;
								height: 10px;
								background: #787878;
								border-radius: 50%;
								left: 0;
								top: 7px;
	                		}
	                		.credit-item .categorybadge {
								border-radius: 30px;
								padding: 7px 27px;
								font-size: 13px;
	                		}
	                	</style>
         		        <!--Credit and Experience Block-->
		                <div class="row mb-3 blockBG experienceblock" id="credits">
		                    <div class="col-12 col-sm-6">
		                        <h4>Credit and Experience</h4>
		                    </div>
		                   	<?php 
		                   		$credits = []; 
		                   		$credits_exp = [];
		                   		foreach (get_field('experience', 'user_' . $obj_id) as $key => $row): 
		                    	 	foreach ($row['sections'] as $key => $section): 		                    		
			                    		preg_match_all("/(?:<li>)([^[]+)\[(\d+)\]<\/li>/", $section['content'], $res); 
			                    		foreach ($res[0] as $key => $section) {
			                    			array_push($credits, [$res[2][$key] => [$res[1][$key], $row['category']->name] ]);
			                    		}
		                    		endforeach;
		                    	endforeach;
				                foreach ($credits as $index => $value) {
				                	$year = array_keys($value)[0];
				                	$text = $credits[$index][$year];
				                	if (array_key_exists($year, $credits_exp)) {
				                		array_push($credits_exp[$year], $text);
				                	}else{
				                		$credits_exp[$year] = [];
				                		array_push($credits_exp[$year], $text);
				                	}
				                }
				                krsort($credits_exp);
			                ?>
		                    <div class="col-12 col-sm-6 text-right">
		                        <select class="form-control">
		                            <option>Year</option>
		                    		<?php foreach ($credits_exp as $indexP => $credit) : ?>
		                            <option><?php echo $indexP; ?></option>
		                    		<?php endforeach; ?>	
		                        </select>
		                    </div>
		                    <div class="col-12 pt-1 py-3 pt-sm-0 sortable">
		                    	<?php foreach ($credits_exp as $indexP => $credit) : ?>
		                    	<div class="credit-item" data-year="<?php echo $indexP; ?>">
			                        <div class="hr-text">
			                            <span class="credit-title pr-3">
			                            	<?php echo $indexP; ?>
			                            </span>
			                         </div>
			                         <ul>
		                    			<?php foreach ($credit as $indexC => $item) : ?>
			                            <li><?php echo $item[0]; ?><span class="badge categorybadge"><?php echo $item[1]; ?></span></li>
		                    			<?php endforeach; ?>	
			                         </ul>
		                    	</div>
		                    	<?php endforeach; ?>	
		                    </div>
		                </div>
	                   	<script type="text/javascript">
	                   		(function(on){
	                   			on("DOMContentLoaded", function(){
									window.$grid = new Isotope( '.sortable', {
										itemSelector: '.credit-item',
										layoutMode: 'fitRows',
										transitionDuration: "0.6s",
									});
									var select = document.querySelector(".experienceblock select.form-control");
									select.addEventListener("change", function(event){
										let year;
										if (event.target.selectedOptions[0].innerText == 'Year') {
											year = "*";
										}else{
											year = '[data-year= ' + event.target.selectedOptions[0].innerText + ']';
										}
										$grid.arrange({
											filter: year
										})							
									})

	                   			})
	                   		})(document.addEventListener)
	                   	</script>
	                	<div class="experience">
		                	<?php if( have_rows('experience', 'user_' . $obj_id) ): ?>
		                		<?php while ( have_rows('experience', 'user_' . $obj_id) ) : the_row(); ?>
					                <div class="mb-3 blockBG py-3 cat-block row" id="<?php echo get_sub_field('category')->slug; ?>">
					                    <div class="col-12 col-sm-6 pt-3 cat-title">
					                        <h4><?php echo get_sub_field('category')->name; ?></h4>
					                    </div>
					                    <div class="col-12 col-sm-6 pt-3 text-left text-sm-right">
					                        <span class="badge experiencedbadge"> <i class="fas fa-check"></i> <?php echo get_sub_field('experience_type', 'user_' . $obj_id)['label']; ?></span>
					                    </div>
					                    <?php if( have_rows('sections') ): ?>
						                   <div class="col-12 pt-3 pt-sm-0">
		            						<?php while ( have_rows('sections') ) : the_row(); ?>
						                       <div class="specialised-skills">
						                        <div class="hr-text">
						                            <span class="credit-title pr-3">
						                            	<?php echo get_sub_field('title'); ?>
						                            </span>
						                         </div>
						                         <div class="content">
							                        <?php echo preg_replace("/(?:\[(.[^\]]+)\])/", "<span class='badge specialisedbadge'> $1</span>", get_sub_field('content')); ?>
						                         </div>
						                       </div>
											<?php endwhile; ?>
						                   </div>
										<?php endif; ?>
					                </div>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
	                <?php endif ?>
	            </div>
	        </div>     
        </div>
    </section>
  </div> 


  <!-- Modal headshot -->
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
                        <button type="button" id="rotate-anticlock" class="btn btn-details-uphs btn-xs mx-2 px-4">
                          <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" id="rotate-clock" class="btn btn-details-uphs btn-xs mx-2 px-4">
                          <i class="fas fa-undo fa-flip-horizontal"></i>
                        </button>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around py-4">
                      <button class="btn btn-lg btn-popup-cancel" data-dismiss="modal">Cancel</button>
                      <button class="btn btn-lg btn-popup-save px-4">Save</button>
					</div>			
					<!-- error message -->
					<div id="errorHeadshotWrapper" class="m-2"></div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
										

<script type="text/javascript">
	(function(){
		document.addEventListener("scroll", function(event){
			let nav = document.querySelector(".profilenavigation nav");
			let navContainer = document.querySelector(".profilenavigation");
			if (window.scrollY > navContainer.offsetTop + navContainer.offsetHeight) {
				nav.classList.add("fixed");
			}
			if (window.scrollY < navContainer.offsetTop){
				nav.classList.remove("fixed");
			}

		})
	})()
</script>
<?php
get_footer();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous"></script>
<script>
jQuery(document).ready(function () {
		jQuery(".upload-div").hide();
		jQuery(".file-edit-btns").hide();

		var cropper;
		var data;
		var canvas = document.querySelector("#canvas");
		var video = document.querySelector("#videoElement");
		const inpFile = document.getElementById("hsFile");
		const previewContainer = document.getElementById("img-preview");
		const previewImg = document.querySelector(".img-preview-img");
		const previewDefaultTxtCam = document.querySelector(".img-preview-default-txtCam");
		const previewDefaultTxt = document.querySelector(".img-preview-default-txt");

		inpFile.addEventListener("change", function () {
			const file = this.files[0];
			if (file) {
				const reader = new FileReader();
				
				reader.addEventListener("load", function () {
					//console.log(this);
					previewDefaultTxt.style.display = "none";
					previewImg.setAttribute("src", this.result);
					previewImg.style.display = "block";
					cropper = new Cropper(previewImg, {
							viewMode: 1,
							aspectRatio: 1,
							initialAspectRatio: 1
						});
					});
				reader.readAsDataURL(file);	
			}
		});	

		if (navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices
			.getUserMedia({ video: true })
			.then(function (stream) {
			previewDefaultTxtCam.style.display = "none";
			video.style.display = "block";
			video.srcObject = stream;
			})
			.catch(function (err0r) {
			
				console.log("Looks like your device has no camera.");
				jQuery('#errorHeadshotWrapper').empty();
				jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															Looks like your device has no camera. \
														</div>');
			});
		}

		

		jQuery(".btn-details-fileup").click(function () {
			jQuery(".capture-div").hide();
			jQuery(".upload-div").show();
			jQuery(".file-edit-btns").show();
		});

		function takepicture(height,width) {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                data = canvas.toDataURL('image/png');
                previewDefaultTxt.style.display = "none";
                previewImg.style.display = "block";
				previewImg.setAttribute('src', data);
				cropper = new Cropper(previewImg, {
							viewMode: 1,
							aspectRatio: 1,
							initialAspectRatio: 1
						});
                //console.log(data);
            } 
        }

		jQuery(".btn-details-cptr").click(function (e) {
			e.preventDefault();
			console.log('capturing...');
			jQuery(".upload-div").show();
			jQuery(".file-edit-btns").show();
			//console.log(video.offsetHeight,video.offsetWidth);
			takepicture(video.offsetHeight,video.offsetWidth);
			jQuery(".capture-div").hide();
		});
	  

	  	jQuery('#saveHeadshot').on('click', function(){
			console.log('uploading...');
			if(cropper){
				canvas = cropper.getCroppedCanvas({
					width:400,
					height:400
				});
				canvas.toBlob(function(blob){
					url = URL.createObjectURL(blob);
					var reader = new FileReader();
					reader.readAsDataURL(blob);
					reader.onloadend = function(){
						var base64data = reader.result;
						//console.log(base64data);
						jQuery.ajax({
							url:'<?php echo get_template_directory().'/inc/ajax-headshot.php'; ?>',
							method:'POST',
							data:{headshot:base64data},
							success:function(response, status, xhr)
							{
								res = JSON.parse(response);
								console.log(res, status, xhr.status);
								cropper.destroy();
								cropper = null;

								if(xhr.status == 200){
									console.log('success');
								}else{
									jQuery('#errorHeadshotWrapper').empty();
									jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
																				<button type="button" class="close" data-dismiss="alert">&times;</button> \
																				'+ res.data +'. \
																			</div>');
								}
							}
						});
					};
				});
			}else{
				console.log('please capture or upload a headshot');
				jQuery('#errorHeadshotWrapper').empty();
				jQuery('#errorHeadshotWrapper').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															Please capture or upload a headshot. \
														</div>');
			}	
		});

		jQuery('#rotate-anticlock').on('click', function(){
			console.log('rotate anticlock');
			if(cropper){			
				cropper.rotate(-90);
			}
		});

		jQuery('#rotate-clock').on('click', function(){
			console.log('rotate clock');
			if(cropper){
				cropper.rotate(90);
			}
		});

    });
</script>