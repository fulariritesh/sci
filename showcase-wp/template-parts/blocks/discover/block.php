<?php 

?>
      <section class="container-fluid gradient-bg talent-block">
        <div class="container">
        <div class="row">
          <div class="col-md-6 order-md-6">
            <div  id="imageBlock-simple" class="">
              <img src="<?php echo get_field('image'); ?>" class="img-fluid"  alt="influencer pic" loading="lazy" />
            </div>
          </div>
          <div class="col-md-6 blockInfo order-md-1">
          	<?php echo get_field('content'); ?>
          </div>
        </div>
      </div>
      </section>