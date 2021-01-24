<section class="container-fluid talent-block allcategories">
	<div class="container category-block text-center">
		<?php the_field("title"); ?>
	<?php if (have_rows('icons')): ?>    
	  <div class="row">
		<?php while (have_rows('icons')): the_row(); ?>
		    <div class="card text-center">
		    	<a href="<?php echo get_sub_field('link'); ?>">
		      		<img src="<?php echo get_sub_field('image'); ?>" alt="" class="img-fluid" loading="lazy"/>				    		
	      			<div class="card-title text-uppercase"><?php echo get_sub_field('title'); ?></div>
		    	</a>
		    </div>		      		
   		<?php endwhile; ?>
	  </div>
	<?php endif ?>
	</div>
</section>