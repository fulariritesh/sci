<?php 


 ?>


<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="" alt="First slide">
      <div class="content">
      	
      </div>
    </div>
  </div>
</div>

<section class="container-fluid gradient-bg profile-block py-4">
	<div class="container">
		<div class="row">
		  <div class="col-sm-6 blockInfo">
		  	<?php echo get_field("content"); ?>
		    <h4>Let people discover you</h4>
		    <h1>Post profile quickly</h1>
		    <p>
		      Quick and easy sign-up process and an AI system that does the work and matches you with employers in the entertainment industry who are most likely to hire you.
		    </p>
		    <button class="btn btn-profile btn-lg">CREATE MY PROFILE NOW</button>
		  </div>
		  <div class="col-sm-6">
		    <div id="drop1"></div>
		    <div id="drop2"></div>
		    <div class="imageBlockLeft shadow-sm">
		      <img src="<?php echo get_field("image"); ?>" class="img-fluid" alt="profile pic">
		    </div>
		   
		  </div>
		</div>
	</div>
</section>