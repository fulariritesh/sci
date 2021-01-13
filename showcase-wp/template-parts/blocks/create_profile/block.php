<?php 


 ?>


<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="<?php echo get_field("image"); ?>" alt="First slide">
      <div class="content">
      	<?php echo get_field("content"); ?>
      </div>
    </div>
  </div>
</div>