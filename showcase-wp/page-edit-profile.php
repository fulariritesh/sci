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
	   <div class="row blockBG my-3 progressbar">
	       <div class="col-sm-11 mx-auto text-center p-3">
	        <h4 class="text-center font-weight-bold">
	            Profile Completion: <span class="completevalue">25%</span>
	            <a href="#" data-toggle="tooltip" title="Hooray!"> <i class="fas fa-info-circle"></i></a>
	        </h4>
	          <p class="text-center">
	            Good job! Keep adding to your profile to improve it further. 
	          </p>
	        <div class="progress pr-com-bar">
	            <div
	              class="progress-bar"
	              role="progressbar"
	              style="width: 25%"
	              aria-valuenow="25"
	              aria-valuemin="0"
	              aria-valuemax="100"
	            ></div>
	          </div>
	       </div>
	   </div>	  
	            <div class="row p-3 blockBG mb-3">
	                <div class="col-12 col-sm-6">
	                    <div class="col-12 text-center">
	                        <div class="headshotarea">
	                        <?php if (get_field('sci_user_headshot', 'user_' . $obj_id)): ?>
	                        <img src="<?php echo get_field('sci_user_headshot', 'user_' . $obj_id); ?>" />
							<?php endif ?>
	                        <div class="col"><button class="btn btn-add" data-toggle="modal" data-target="#editheadshot">Add Image</button></div>
	                    </div>
	                </div>
	                </div>
	                <div class="col-12 col-sm-6 profile-personaldetails pt-5">
	                    <div id="editable-form" class="editable-form">
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
	                            		<?php echo get_field('sci_user_location', 'user_' . $obj_id); ?>
	                            	</a>
	                            </h5>
	                        </div>
	                        <?php endif ?>
	                        <div class="form-group row"> 
	                        	<?php if (get_field('sci_user_gender', 'user_' . $obj_id)): ?>
	                            <h5>
	                            	<i class="fas fa-venus-mars"></i> 
	                            	<a href="#" id="gender" data-type="select" data-pk="1" data-title="Select gender" class="editable editable-click" data-abc="true">
	                            		<?php echo get_field('sci_user_gender', 'user_' . $obj_id); ?>
	                            	</a> 
	                            </h5>
	                        	<?php endif; ?>
	                        </div>
	                    </div>
                        	<div class="text-right"> <button class="btn btn-edit" data-toggle="modal" data-target="#editCat">Edit</button></div>
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
	                        <div class="col-6 col-sm-6 "> <h4>Introduction</h4></div>
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


	            <!-- Navigation Bar--><!-- 
	            <div class="row blockBG profilenavigation mt-3 ">
					<nav id="navbar" class="navbar navbar-expand navbar-light navbarcolors">
		                <div class="" id="navbarNav">
		                  <ul class="navbar-nav">
		                    <li class="nav-item active">
		                      <a class="nav-link" href="#">Photo </a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link" href="#">Video</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link" href="#">Audio</a>
		                    </li>
		                    <li class="nav-item">
		                        <a class="nav-link" href="#">Physical Attributes</a>
		                    </li>
		                    <li class="nav-item">
		                        <a class="nav-link" href="#">Credit and Experience</a>
		                    </li>
		                    <li class="nav-item">
		                        <a class="nav-link" href="#">Acting</a>
		                    </li>
		                    <li class="nav-item">
		                        <a class="nav-link" href="#">Modelling</a>
		                      </li>
		                  </ul>
		                </div>
	              	</nav>
	            </div> -->
	            <div class="content">
	            <!-- Photo Grid-->
	            <div class="photogrid">
	               
	                <div class="row">
	                    <div class="col-6 col-sm-6 pt-3 px-0"> <h4>Photos (23)</h4></div>
	                    <div class="col-6 col-sm-6 pt-3 px-0 text-right">
	                        <button class="btn btn-edit">Edit</button>
	                        <button class="btn btn-add">Add</button>
	                    </div>
	                </div>

	            <div class="row pt-2">
	              
	                  <div class="col-sm-4">
	                    
	                    <!-- <img src="./images/gridimg/7.jpg" style="width:100%"> -->
	                  </div>
	                  <div class="col-sm-4">
	                    <!-- <img src="./images/gridimg/1.jpg" style="width:100%"> -->
	                  </div>
	                  <div class="col-sm-4">
	                    <!-- <img src="./images/gridimg/2.png" style="width:100%"> -->
	                    <div class="approved-status"><i class="fas fa-check"></i></div>
	                  </div>
	                  <div class="col-sm-4">
	                    <!-- <img src="./images/gridimg/5.jpg" style="width:100%"> -->
	                    <div class="pending-status">Pending</div>
	                  </div>
	                  <div class="col-sm-4">
	                    <div class="rejected-overlay"></div> 
	                    <!-- <img src="./images/gridimg/5.jpg" style="width:100%"> -->
	                    <div class="rejected-status">Rejected</div>
	                  </div>

	            </div>
	            <div class="loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>

	          	<!-- The Modal -->
	            <div class="modal" id="myModal">
	                <div class="modal-dialog">
	                  <div class="modal-content">
	              
	                    <!-- Modal Header -->
	                    <div class="modal-header">
	                      <h4 class="modal-title">Modal Heading</h4>
	                      <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    </div>
	              
	                    <!-- Modal body -->
	                    <div class="modal-body">
	                      Modal body..
	                    </div>
	              
	                    <!-- Modal footer -->
	                    <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	                    </div>
	              
	                  </div>
	                </div>
	              </div>

	            </div>
	            <!--Videos block-->
	            <div class="row mt- blockBG p-3">
	                <div class="col-6 col-sm-6 pt-3 "> <h4>Videos (5)</h4></div>
	                <div class="col-6 col-sm-6 pt-3 text-right">
	                    <button class="btn btn-edit">Edit</button>
	                    <button class="btn btn-add">Add</button>
	                </div>
	                <div class="col-12 mt-2 profilevideos">
	                    <!-- <iframe width="100%" height="400px" src="https://www.youtube.com/embed/tgbNymZ7vqY">
	                    </iframe> -->
	                    <h5 class="pt-2">Video Title</h5>
	                    <h6>3 months ago</h6>
	                </div>
	                <div class="col-sm-4 profilevideos pt-3">
	                    <!-- <iframe width="100%" height="200px" src="https://www.youtube.com/embed/tgbNymZ7vqY">
	                    </iframe> -->
	                    <h5 class="pt-2">Video Title</h5>
	                    <h6>3 months ago</h6>
	                </div>
	                <div class="col-sm-4 profilevideos pt-3">
	                    <!-- <iframe width="100%" height="200px" src="https://www.youtube.com/embed/tgbNymZ7vqY">
	                    </iframe> -->
	                    <h5 class="pt-2">Video Title</h5>
	                    <h6>3 months ago</h6>
	                </div>
	                <div class="col-sm-4 profilevideos pt-3">
	                    <!-- <iframe width="100%" height="200px" src="https://www.youtube.com/embed/tgbNymZ7vqY">
	                    </iframe> -->
	                    <h5 class="pt-2">Video Title</h5>
	                    <h6>3 months ago</h6>
	                </div>
	                <div class="col-sm-12 loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
	            </div>

	             <!--Audio block-->
	             <div class="row mt-3 blockBG p-3 audioblock">
	                <div class="col-6 col-sm-6 pt-3 "> <h4>Audio (3)</h4></div>
	                <div class="col-6 col-sm-6 pt-3  text-right">
	                    <button class="btn btn-edit">Edit</button>
	                    <button class="btn btn-add">Add</button>
	                </div>
	                <div class="col-12 pt-1  row">
	                    <div class="col-sm-6">
	                        <h5 class="pt-2">Audio Title</h5>
	                        <h6>audio description</h6>
	                    </div>
	                    <div class="col-sm-6 pt-3">
	                        <audio controls>
	                            <source src="horse.ogg" type="audio/ogg">
	                            <source src="horse.mp3" type="audio/mpeg">
	                            Your browser does not support the audio element.
	                          </audio>
	                    </div>
	                    <hr>
	                </div>
	                <div class="col-12 pt-1  row">
	                    <div class="col-sm-6">
	                        <h5 class="pt-2">Audio Title</h5>
	                        <h6>audio description</h6>
	                    </div>
	                    <div class="col-sm-6 pt-3">
	                        <audio controls>
	                            <source src="horse.ogg" type="audio/ogg">
	                            <source src="horse.mp3" type="audio/mpeg">
	                            Your browser does not support the audio element.
	                          </audio>
	                    </div>
	                </div>
	             </div>

	              <!--Physical Attributes-->
	             <div class="row mt-3 physicalattribs">
	                <div class="col-9 col-sm-6 pt-3 px-0"> <h4>Physical Attributes</h4></div>
	                    <div class="col-3 col-sm-6 pt-3 px-0 text-right">
	                        <button class="btn btn-edit">Edit</button>
	                    </div>
	            </div>
	                    <div class="row physicalfeatures justify-content-center pt-3">
	                        <div class=" card">
	                         <div class="pa-height"><div class='sprite height-c'></div></div>
	                         <div class="card-title">Height<span>180cms/5ft 11in</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-weight"><div class='sprite weight-c'></div></div>
	                            <div class="card-title">Weight<span>68kg/149lbs</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-ethnicity"><div class='sprite ethnicity-c'></div></div>
	                            <div class="card-title">Ethnicity<span>Indian</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-chest"><div class='sprite chest-c'></div></div>
	                            <div class="card-title">Chest<span>36cms</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-skincolor"><div class='sprite skincolor-c'></div></div>
	                            <div class="card-title">Skin Color<span>Brown</span></div>
	                        </div>
	                    
	                        <div class=" card">
	                            <div class="pa-notset"><div class='sprite waist'></div></div>
	                            <div class="card-title">Waist<span>Not Set</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-notset"><div class='sprite eyecolor'></div></div>
	                            <div class="card-title">Eye Color<span>Not Set</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-notset"><div class='sprite hair-dye'></div></div>
	                            <div class="card-title">Hair Color<span>Not Set</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-notset"><div class='sprite hair-length'></div></div>
	                            <div class="card-title">Hair Length<span>Not Set</span></div>
	                        </div>
	                        <div class=" card">
	                            <div class="pa-notset"><div class='sprite hair'></div></div>
	                            <div class="card-title">Hair Type<span>Not Set</span></div>
	                        </div>
	                      </div>

	             <!--Credit and Experience Block-->
	             <div class="row mt-3 blockBG p-3 experienceblock">
	                <div class="col-12 col-sm-6 pt-3">
	                    <h4>Credit and Experience</h4>
	                </div>
	                <div class="col-12 col-sm-6">
	                    <select class="form-control">
	                        <option>Year</option>
	                        <option>Category</option>
	                    </select>
	                </div>
	                <div class="col-12 pt-1 pt-3 pt-sm-0">
	                    <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        2020
	                        </span>
	                     </div>
	                     <ul>
	                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">Modelling</span></li>
	                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">Acting</span></li>
	                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">Acting</span></li>
	                     </ul>
	                     <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        2019
	                        </span>
	                     </div>
	                     <ul>
	                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">Music</span></li>
	                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">Acting</span></li>
	                     </ul>
	                     <div class="col-sm-12 loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
	                </div>
	            </div>

	             <!--empty Block-->
	             <div class="row mt-3 blockBG p-3 emptyblock">
	                <div class="col-12 pt-3 text-center">
	                    <h4>Actors</h4>
	                </div>
	                <div class="col-12 text-center">
	                   <p>Completing this section will increase your chances of being noticed by casting professionals.</p>
	                </div>
	                <div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-primary px-5">Add Details</button></div>
	            </div>

	            <!--Actors Block-->
	            <div class="row mt-3 blockBG p-3 cat-block">
	                <div class="col-6 col-sm-4 col-lg-5 pt-3">
	                    <h4>Actors</h4>
	                </div>
	                <div class="col-6 col-sm-2  col-lg-1 pt-3 text-right order-sm-11 ">
	                    <button class="btn btn-edit">Edit</button>
	                </div>
	                <div class="col-12 col-sm-6 col-lg-6 pt-3 text-left text-sm-right order-sm-6">
	                    <span class="badge experiencedbadge"> <i class="fas fa-check"></i> No previous acting experience</span>
	                </div>
	            </div>
	            <div class="row  blockBG cat-block pb-3">   
	               <div class="col-12 pt-3 pt-sm-0">
	                   <div class="specialised-skills">
	                    <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        Specialised Skills
	                        </span>
	                     </div>
	                     <p class="py-4"><span class="badge specialisedbadge"><i class="fas fa-check"></i> Feature Films</span><span class="badge specialisedbadge"><i class="fas fa-check"></i> Short Films</span></p>
	                   </div>

	                   <div class="languages">
	                    <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        Languages
	                        </span>
	                     </div>
	                     <p class="py-4"><span class="badge languagedbadge"><i class="fas fa-check"></i> Marathi</span><span class="badge languagedbadge"><i class="fas fa-check"></i> English</span></p>
	                   </div>
	               
	                    <div class="experience">
	                        <div class="hr-text">
	                            <span class="credit-title pr-3">
	                            Acting Experience
	                            </span>
	                         </div>
	                         <ul>
	                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">2020</span></li>
	                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">2019</span></li>
	                         </ul>
	                    </div>
	               </div>
	                <div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
	            </div>

	             <!--Modelling Block-->
	             <div class="row mt-3 blockBG p-3 cat-block">
	                <div class="col-6 col-sm-4 col-lg-5 pt-3">
	                    <h4>Modelling</h4>
	                </div>
	                <div class="col-6 col-sm-2  col-lg-1 pt-3 text-right order-sm-11 ">
	                    <button class="btn btn-edit">Edit</button>
	                </div>
	                <div class="col-12 col-sm-6 col-lg-6 pt-3 text-left text-sm-right order-sm-6 ">
	                    <span class="badge experiencedbadge"> <i class="fas fa-check"></i> No previous modelling experience</span>
	                </div>
	            </div>
	            <div class="row  pb-3 cat-block blockBG">
	               <div class="col-12 pt-3 pt-sm-0">
	                   <div class="specialised-skills">
	                    <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        Specialised Skills
	                        </span>
	                     </div>
	                     <p class="py-4"><span class="badge specialisedbadge"><i class="fas fa-check"></i> Cat Walk</span><span class="badge specialisedbadge"><i class="fas fa-check"></i> Hair Model</span><span class="badge specialisedbadge"><i class="fas fa-check"></i> Fitting</span></p>
	                   </div>

	                   <div class="website">
	                    <div class="hr-text">
	                        <span class="credit-title pr-3">
	                        Modelling Website
	                        </span>
	                     </div>
	                     <p class="py-4">abc.com</p>
	                   </div>
	               
	                    <div class="experience">
	                        <div class="hr-text">
	                            <span class="credit-title pr-3">
	                            Modelling Experience
	                            </span>
	                         </div>
	                         <ul>
	                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">2020</span></li>
	                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.<span class="badge categorybadge">2019</span></li>
	                         </ul>
	                    </div>
	               </div>
	                <div class="col-sm-12 loadMore text-center "><button class="btn btn-md btn-full btn-primary px-5">Show More</button></div>
	            </div>
	        </div>   <!-- content closing -->
	            <!-- </div> tab pane div closing -->
	        <!-- </div> -->
	    </div>
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
						<img src="./images/actors.png" alt="<?php echo $parent->name; ?>" />
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

<!-- Modal headshot -->
<div class="modal fade" id="editheadshot" tabindex="-1" aria-labelledby="editHeadshotModalLabel" aria-hidden="true">
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
	                <textarea class="form-control justify-content-center" maxlength="180"><?php echo get_field('intro_text', 'user_' . $obj_id) ? get_field('intro_text', 'user_' . $obj_id) : ""; ?></textarea>
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
