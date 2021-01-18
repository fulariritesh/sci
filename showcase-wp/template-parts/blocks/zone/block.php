<?php 

$align = get_field('align_image');
$drop_color = get_field('drop_color');
$image = get_field('image');
$content = get_field('content');


?>
<?php if ($align == 'left'): ?>
<section class="container-fluid gradient-bg artist-block ">
	<div class="container">
		<div class="row">
		  <div class="col-sm-6">
		    <div id="drop3"></div>
		    <div id="drop4"></div>
		    <div id="drop5"></div>
		    <div  id="imageBlock" class=" shadow-sm">
		      <img src="<?php echo $image; ?> " class="img-fluid"/>
		    </div>
		  </div>
		  <div class="col-sm-6 blockInfo pt-1">
		    <h4>Enter the zone</h4>
		    <?php echo $content; ?>
			<?php if (have_rows('popular_categories')): ?>    
		    <div class="popcategory pt-4">
		    	<h4>Popular Categories</h4>
				<?php while (have_rows('popular_categories')): the_row(); ?>
		      		<button class="btn btn-categoryblock3 btn-md mt-2" href='<?php echo get_sub_field('category')[0]->slug; ?>'><?php echo get_sub_field('category')[0]->name; ?></button>
           		<?php endwhile; ?>
		    </div>
			<?php endif;?>
		  </div>
		</div>
	</div>
</section>
<?php else: ?>
<section class="container-fluid gradient-bg influencer-block">
	<div class="container">
		<div class="row">
		  <div class="col-sm-6 blockInfo">
		    <h4>Enter the zone</h4>
		    <?php echo $content; ?>
			<?php if (have_rows('popular_categories')): ?>    
		    <div class="popcategory pt-4">
		    	<h4>Popular Categories</h4>
				<?php while (have_rows('popular_categories')): the_row(); ?>
		      		<button class="btn btn-categoryblock3 btn-md mt-2" href='<?php echo get_sub_field('category')[0]->slug; ?>'><?php echo get_sub_field('category')[0]->name; ?></button>
           		<?php endwhile; ?>
		    </div>
			<?php endif;?>
		  </div>
		  <div class="col-sm-6">
		    <div id="drop8"></div>
		    <div id="drop7"></div>
		    <div id="drop6"></div>
		    <div  id="imageBlock-influencers" class=" shadow-sm">
		      <img src="<?php echo $image; ?>" class="img-fluid"/>
		    </div>
		  </div>
		</div>
	</div>
</section>
<?php endif; ?> 