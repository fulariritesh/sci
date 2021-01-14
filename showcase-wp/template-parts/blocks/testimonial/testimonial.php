<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>
<?php 
$testimonials_count = get_fields()['testimonials'];
 ?>

<?php if (have_rows('testimonials')): ?>    
<div class="testimonials">
    <div id="testimonials_carousel" class="carousel slide col-sm-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php foreach ($testimonials_count as $key => $value) : ?>
                <li data-target="#testimonials_carousel" data-slide-to="<?php echo $key; ?>" <?php echo $key == 0 ? "class='active'"  : ""; ?>></li>
            <?php endforeach; ?>
        </ol>
        <div class="carousel-inner">
            <?php while (have_rows('testimonials')): the_row(); ?>
                <div class="testimonial carousel-item <?php echo get_row_index() == 1 ? 'active' : ''; ?>">
                    <div class="d-block w-100">
                        <div class="image">
                            <img src="<?php echo get_the_post_thumbnail_url(get_sub_field('testimonial')->ID); ?>">
                        </div>
                        <div class="quote">
                            <?php echo get_sub_field('testimonial')->post_content; ?>
                        </div>
                        <div class="name">
                            <?php echo get_sub_field('testimonial')->post_title; ?>
                        </div>
                    </div>
                </div>  
            <?php endwhile; ?>
        </div>
    </div>
</div> 
<?php else: ?>
    <h2>Add testimonials here</h2>
<?php endif;?>
