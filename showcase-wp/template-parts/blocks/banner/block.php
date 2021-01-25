<?php if (have_rows('slides')): ?>
<div id="banner" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach (get_fields()['slides'] as $key => $value) : ?>
            <li data-target="#banner" data-slide-to="<?php echo $key; ?>" <?php echo $key == 0 ? "class='active'"  : ""; ?>></li>
        <?php endforeach; ?>
    </ol>
  	<div class="carousel-inner">
	    <?php while (have_rows('slides')): the_row(); ?>
	    <div class="carousel-item <?php echo get_row_index() == 1 ? 'active' : ''; ?> banner" style="background: url(<?php echo get_sub_field('image'); ?>) no-repeat center; background-size: cover;">
	      	<div class="carousel-content container">
				<?php echo get_sub_field('content'); ?>
			</div>
	    </div>
	    <?php endwhile; ?>
	</div>
</div>
<?php else: ?>
    <h2>Add banner images here</h2>
<?php endif;?>